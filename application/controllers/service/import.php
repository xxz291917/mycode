<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

set_time_limit(0);

class import extends MY_Controller {

    private $dzdb;
    private $BBCode = null;
    private $forum_new;

    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'users_model',
            'users_extra_model',
            'users_medal_model',
            'topics_model',
            'posts_model',
            'poll_model',
            'poll_options_model',
            'poll_voter_model',
            'attachments_model',
            'credit_name_model',
            'ask_model',
            'ask_posts_model',
            'debate_model',
            'debate_posts_model',
            'groups_model',
            'groups_admin_model',
            'forums_model',
            'forums_statistics_model',
            'posts_supported_model',
            'attachments_model',
        ));

        $dz_config['hostname'] = "10.127.64.234";
        $dz_config['username'] = "client";
        $dz_config['password'] = "sskWDE638DE8fhgo2Lw34e";
        $dz_config['database'] = "kingda_x2";
        $dz_config['dbdriver'] = "mysql";
        $dz_config['dbprefix'] = "pre_";
        $dz_config['pconnect'] = FALSE;
        $dz_config['db_debug'] = TRUE;
        $dz_config['cache_on'] = FALSE;
        $dz_config['cachedir'] = "";
        $dz_config['char_set'] = "utf8";
        $dz_config['dbcollat'] = "utf8_general_ci";
        $this->dir = FCPATH . 'sql/';
        $this->pre = 'pre_';
        $this->dzdb = $this->load->database($dz_config, TRUE);
        
        $this->forum_new();
    }

    public function users($maxid = 0) {
        $data = $this->get_data('users');
        if (!empty($data['id'])) {
            $id = $data['id'] + 1;
        } else {
            $id = 1;
        }
        if ($id >= $maxid) {
            echo '全部完成';
            die;
        }
        $endid = ($id + 99) >= $maxid ? $maxid : $id + 99;
        $usertable = 'common_member';
        $counttable = 'common_member_count';
        $sql = "SELECT u.*,c.* FROM $this->pre$usertable u left join $this->pre$counttable c ON c.uid=u.uid WHERE u.uid BETWEEN $id AND $endid limit 0,100";
        $query = $this->dzdb->query($sql);
        $rows = $query->result_array();
        if (!empty($rows)) {
            $batch1 = array();
            $batch2 = array();
            $field1 = array(
                'uid' => 'id',
                'email' => 'email',
                'username' => 'username',
                'adminid' => 'group_id',
                'groupid' => 'member_id',
                'groupexpiry' => 'id',
                'regdate' => 'regdate',
                'credits' => 'credits',
                'status' => 'status',
            );
            $field2 = array(
                'uid' => 'user_id',
                'extcredits1' => 'extcredits1',
                'extcredits2' => 'extcredits2',
                'extcredits3' => 'extcredits3',
                'extcredits4' => 'extcredits4',
                'extcredits5' => 'extcredits5',
                'extcredits6' => 'extcredits6',
                'extcredits7' => 'extcredits7',
                'extcredits8' => 'extcredits8',
                'posts' => 'posts',
                'digestposts' => 'digests',
                'todayattachs' => 'today_uploads',
            );

            foreach ($rows as $key => $row) {
                foreach ($row as $k => $v) {
                    if (!empty($field1[$k])) {
                        if (isset($batch1[$key][$field1[$k]]))
                            continue;
                        $batch1[$key][$field1[$k]] = $v;
                    }
                    if (!empty($field2[$k])) {
                        if (isset($batch2[$key][$field2[$k]]))
                            continue;
                        $batch2[$key][$field2[$k]] = $v;
                    }
                }
            }
            $r1 = $this->users_model->insert_batch($batch1);
            $r2 = $this->users_extra_model->insert_batch($batch2);
            if ($r1 && $r2) {
                $this->set_data('users', array('id' => $endid));
                if ($endid < $maxid) {
                    $redirect = current_url();
                    $this->message('处理成功:' . $endid, 1, $redirect);
                } else {
                    $this->message('处理完成：' . $endid);
                }
            } else {
                $this->message('处理失败：' . $endid);
            }
        } else {
            $this->message('未搜到记录，当前处理到：' . $endid);
        }
    }

    public function topics($maxnum = 0) {
        $data = $this->get_data('topics');
        if (!empty($data['num'])) {
            $num = $data['num'];
        } else {
            $num = 0;
        }
        if ($num >= $maxnum) {
            $this->message('全部完成：' . $num);
        }
        $endnum = ($num + 5) >= $maxnum ? $maxnum : $num + 5;
        $table = 'forum_thread';

        //一周内的帖子。
        $oldtime = $this->time - 3600 * 24 * 10;
        $where = "dateline > $oldtime AND dateline < $this->time";

        $sql = "SELECT * FROM $this->pre$table WHERE $where ORDER BY tid limit $num,5";
        $query = $this->dzdb->query($sql);
        $rows = $query->result_array();

        if (!empty($rows)) {
            foreach ($rows as $key => $row) {
                $this->get_topic($row);
            }
            $this->set_data('topics', array('num' => $endnum));
            if ($endnum < $maxnum) {
                $redirect = current_url();
                $this->message('处理成功:' . $endnum, 1, $redirect);
            } else {
                $this->message('处理完成：' . $endnum);
            }
        } else {
            $this->set_data('topics', array('num' => $endnum));
            $this->message('未搜到记录，当前处理到：' . $endnum);
        }
    }

    public function topic_id($id) {
        $table = 'forum_thread';
        $sql = "SELECT * FROM $this->pre$table WHERE tid=$id";
        $query = $this->dzdb->query($sql);
        $row = $query->row_array();
        if (!empty($row)) {
            $this->get_topic($row);
            $this->message('处理完成');
        } else {
            $this->message('未搜到记录，当前处理到');
        }
    }

    private function get_topic($row) {
        $specials = array(0 => '1', 1 => '3', 3 => '2', 5 => '4'); //1,poll，3，ask，5，debate
        $field1 = array(
            'tid' => 'id',
            'fid' => 'forum_id',
            'typeid' => 'category_id',
            'author' => 'author',
            'authorid' => 'author_id',
            'subject' => 'subject',
            'dateline' => 'post_time',
            'lastpost' => 'last_post_time',
            'lastposter' => 'last_author',
            'views' => 'views',
            'replies' => 'replies',
            'highlight' => 'forum_id',
            'digest' => 'digest',
            'recommend_add' => 'supports',
            'recommend_sub' => 'opposes',
            'special' => 'special',
            'closed' => 'status'
        );
        $batch1 = array();
        foreach ($row as $k => $v) {
            if (!empty($field1[$k])) {
                if (isset($batch1[$field1[$k]]))
                    continue;
                if ($k == 'special') {
                    if (array_key_exists($v, $specials)) {
                        $v = $specials[$v];
                    } else {
                        break;
                    }
                } elseif ('closed' == $k) {
                    if (!empty($v)) {
                        $v = 5;
                    } else {
                        $v = 1;
                    }
                }elseif(('forum_id' == $k)){
                    if(empty($this->forum_new[$v])){
                        return TRUE;
                    }else{
                        $v = $this->forum_new[$v];
                    }
                }
                $batch1[$field1[$k]] = $v;
            }
        }
        //把主题插入数据库。
        $r1 = $this->topics_model->insert($batch1);
        $specail = $specials[$row['special']];
        //获取处理特殊帖子主题。
        if ($specail > 1) {
            $funs = array(2 => 'ask', 3 => 'poll', 4 => 'debate');
            $method = $funs[$specail] . '_topic';
            $this->$method($row);
        }
        //获取下面的所有posts
        $this->topic_post($row);
        //获取下面的所有附件
        $this->attachment($row);
        //获取处理特殊帖子回复。
        if ($specail > 1) {
            $funs = array(2 => 'ask', 3 => 'poll', 4 => 'debate');
            $method = $funs[$specail] . '_post';
            $this->$method($row);
        }
    }

    /**
     * 本主题下的所有帖子，循环读取，插入数据库。
     * @param type $row
     * @return type
     */
    public function topic_post($row) {
        $invisible = array('-1' => 2);
        $status = array('1' => 4);
        //获取poll_options表的数据总数
        $where = "tid = {$row['tid']}";
        $sql = "SELECT count(*) num FROM {$this->pre}forum_post WHERE $where";
        $query = $this->dzdb->query($sql);
        $num = $query->row_array();
        $num = $num['num'];
        for ($i = 0, $j = 0; $i <= $num; $i+=10) {
            $sql = "SELECT * FROM {$this->pre}forum_post WHERE $where limit $i,10";
            $query = $this->dzdb->query($sql);
            $posts = $query->result_array();
            if (empty($posts)) {
                return FALSE;
            }
            $posts_data = array();
            foreach ($posts as $k => $v) {
                $posts_data[$k]['id'] = $v['pid'];
                $posts_data[$k]['topic_id'] = $v['tid'];
                if(empty($this->forum_new[$v['fid']])){
                    break;
                }
                $posts_data[$k]['forum_id'] = $this->forum_new[$v['fid']];
                $posts_data[$k]['author'] = $v['author'];
                $posts_data[$k]['author_id'] = $v['authorid'];
                $posts_data[$k]['author_ip'] = $v['useip'];
                $posts_data[$k]['post_time'] = $v['dateline'];
                $posts_data[$k]['subject'] = $v['subject'];
                if ($v['attachment'] == 2) {
                    $sql = "SELECT aid FROM {$this->pre}forum_attachment WHERE pid = {$v['pid']}";
                    $query = $this->dzdb->query($sql);
                    $aids = $query->result_array();
                } else {
                    $aids = null;
                }
                $posts_data[$k]['content'] = $this->handle_content($v['message'], $aids);
                $posts_data[$k]['attachment'] = $v['attachment'];
                $posts_data[$k]['is_first'] = $v['first'];
                $posts_data[$k]['is_report'] = 0;
                $posts_data[$k]['is_bbcode'] = $v['bbcodeoff'] ? 0 : 1;
                $posts_data[$k]['is_smilies'] = $v['smileyoff'] ? 0 : 1;
                $posts_data[$k]['is_html'] = $v['htmlon'];
                $posts_data[$k]['is_anonymous'] = $v['anonymous'];
                $posts_data[$k]['is_sign'] = $v['usesig'];
                $posts_data[$k]['comment'] = $v['comment'];
                $posts_data[$k]['position'] = $j;
                if (isset($invisible[$v['invisible']])) {
                    $s = $invisible[$v['invisible']];
                } elseif (isset($status[$v['status']])) {
                    $s = $status[$v['status']];
                } else {
                    $s = 1;
                }
                $posts_data[$k]['status'] = $s;

                if ($row['special'] == 3) {
                    $ask_data[$k]['topic_id'] = $v['tid'];
                    $ask_data[$k]['post_id'] = $v['pid'];
                    $ask_data[$k]['user_id'] = $v['authorid'];
                }
                $j++;
            }
            $this->posts_model->insert_batch($posts_data);
            if ($row['special'] == 3) {
                $this->ask_posts_model->insert_batch($ask_data);
            }
        }
    }

    public function attachment($row) {
        //获取poll_options表的数据总数
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}forum_attachment WHERE $where";
        $query = $this->dzdb->query($sql);
        $attachments = $query->result_array();
        if (empty($attachments)) {
            return FALSE;
        }
        $attach_data = array();
        foreach ($attachments as $k => $v) {
            $attach_data[$v['aid']]['id'] = $v['aid'];
            $attach_data[$v['aid']]['downloads'] = $v['downloads'];
        }
//        var_dump($attach_data);die;
        $subtable = 'forum_attachment_' . ($row['tid'] % 10);
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}$subtable WHERE $where";
        $query = $this->dzdb->query($sql);
        $attachments = $query->result_array();
        if (empty($attachments)) {
            return FALSE;
        }
        foreach ($attachments as $k => $v) {
            $attach_data[$v['aid']]['topic_id'] = $v['tid'];
            $attach_data[$v['aid']]['post_id'] = $v['pid'];
            $attach_data[$v['aid']]['user_id'] = $v['uid'];
            $attach_data[$v['aid']]['upload_time'] = $v['dateline'];
            $attach_data[$v['aid']]['size'] = $v['filesize'];
            $attach_data[$v['aid']]['extension'] = $v['dateline'];
            $attach_data[$v['aid']]['filename'] = $v['filename'];

            $new_v = 'uploads/old/' . $v['attachment'];
            $this->get_file($v['attachment'], $new_v, 'forum');
            $attach_data[$v['aid']]['path'] = $new_v;
            $attach_data[$v['aid']]['description'] = $v['description'];
            $attach_data[$v['aid']]['is_image'] = $v['isimage'];
            $attach_data[$v['aid']]['is_thumb'] = $v['thumb'];
            $attach_data[$v['aid']]['is_remote'] = $v['remote'];
            $attach_data[$v['aid']]['status'] = 1;
            $attach_data[$v['aid']]['width'] = $v['width'];
        }
        return $this->attachments_model->insert_batch($attach_data);
    }

    private function handle_content($content, $aids) {
        //code<pre class="codeprint brush:javascript;">sfsdfsdfsdf</pre>
        $content = preg_replace('/\[code\](.*?)\[\/code\]/ies', "\$this->codedisp('\\1')", $content);
        $content = preg_replace('/\[quote\](.*?)\[\/quote\]/is', '<blockquote class="blockquote">\1</blockquote>', $content);
        if (!empty($aids)) {
            $replace = array();
            $search = array();
            foreach ($aids as $key => $aid) {
                $search[] = "[attach]{$aid['aid']}[/attach]";
                $replace[] = "[attachimg]{$aid['aid']}[/attachimg]";
            }
            $content = str_replace($search, $replace, $content);
        }
        $content = $this->bbcode($content);
        $content = str_replace('<::>', "\n", $content);
        return $content;
    }

    private function codedisp($code) {
        $code = preg_replace("/\n\r|\n|\r/", '<::>', $code);
        $code = '<pre class="codeprint brush:javascript;">' . $code . '</pre>';
        return $code;
    }

    public function ask_topic($row) {
        $ask_data['topic_id'] = $row['tid'];
        $ask_data['price'] = $row['price'];
        $ask_data['forum_id'] = $row['fid'];
        $ask_data['category_id'] = $row['typeid'];
        $ask_data['post_time'] = $row['dateline'];
        $ask_data['last_post_time'] = $row['lastpost'];
        $ask_data['replies'] = $row['replies'];
        return $this->ask_model->insert($ask_data);
    }

    public function poll_topic($row) {
        //获取投票帖。
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}forum_poll WHERE $where limit 0,1";
        $query = $this->dzdb->query($sql);
        $poll = $query->row_array();
        if (empty($poll)) {
            return FALSE;
        }
        //完成poll表的数据
        $poll_data['topic_id'] = $poll['tid'];
        $poll_data['is_overt'] = $poll['overt'];
        $poll_data['is_multiple'] = $poll['multiple'];
        $poll_data['is_visible'] = $poll['visible'];
        $poll_data['max_choices'] = $poll['maxchoices'];
        $poll_data['expire_time'] = $poll['expiration'];
        $poll_data['preview'] = $poll['pollpreview'];
        $poll_data['voters'] = $poll['voters'];

        //获取poll_options表的数据
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}forum_polloption WHERE $where";
        $query = $this->dzdb->query($sql);
        $options = $query->result_array();
        if (empty($options)) {
            return FALSE;
        }

        $this->poll_model->insert($poll_data);

        //polloptionid 	tid 	votes 	displayorder 	polloption 	voterids 
        $options_data = array();
        foreach ($options as $k => $v) {
            $options_data[$k]['id'] = $v['polloptionid'];
            $options_data[$k]['topic_id'] = $v['tid'];
            $options_data[$k]['display_order'] = $v['displayorder'];
            $options_data[$k]['option'] = $v['polloption'];
            $options_data[$k]['votes'] = $v['votes'];
            $options_data[$k]['voterids'] = preg_replace('/\s+/', ',', $v['voterids']);
        }
        $this->poll_options_model->insert_batch($options_data);
    }

    public function debate_topic($row) {
        //获取辩论帖的记录。
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}forum_debate WHERE $where limit 0,1";
        $query = $this->dzdb->query($sql);
        $debate = $query->row_array();
        if (empty($debate)) {
            return FALSE;
        }
        //完成debate表的数据
        $debate_data['topic_id'] = $row['tid'];
        $debate_data['user_id'] = $debate['uid'];
        $debate_data['start_time'] = $row['starttime'];
        $debate_data['end_time'] = $debate['endtime'];
        $debate_data['umpire'] = $debate['umpire'];
        $debate_data['affirm_point'] = $debate['affirmpoint'];
        $debate_data['negate_point'] = $debate['negapoint'];
        $debate_data['umpire_point'] = $debate['umpirepoint'];

        $debate_data['affirm_debaters'] = $debate['affirmdebaters'];
        $debate_data['negate_debaters'] = $row['negadebaters'];
        $debate_data['affirm_votes'] = $debate['affirmvotes'];
        $debate_data['negate_votes'] = $debate['negavotes'];
        $debate_data['winner'] = $debate['affirmpoint'];
        $debate_data['best_debater'] = $debate['negapoint'];

        $debate_data['affirm_voterids'] = $debate['affirmvoterids'];
        $debate_data['negate_voterids'] = $debate['negavoterids'];
        $debate_data['affirm_replies'] = $debate['affirmreplies'];
        $debate_data['negate_replies'] = $debate['negareplies'];
        return $this->debate_model->insert($debate_data);
    }

    public function ask_post($row) {
        return TRUE;
    }

    public function poll_post($row) {
        //获取投票。
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}forum_pollvoter WHERE $where";
        $query = $this->dzdb->query($sql);
        $polls = $query->result_array();
        if (empty($polls)) {
            return FALSE;
        }
        $poll_data = array();
        foreach ($polls as $k => $v) {
            $poll_data[$k]['topic_id'] = $v['tid'];
            $poll_data[$k]['user_id'] = $v['uid'];
            $poll_data[$k]['username'] = $v['username'];
            $poll_data[$k]['options'] = preg_replace('/\s+/', ',', $v['options']);
            $poll_data[$k]['vote_time'] = $v['dateline'];
        }
        $this->poll_voter_model->insert_batch($poll_data);
    }

    public function debate_post($row) {
        $where = "tid = {$row['tid']}";
        $sql = "SELECT * FROM {$this->pre}forum_pollvoter WHERE $where";
        $query = $this->dzdb->query($sql);
        $polls = $query->result_array();
        if (empty($polls)) {
            return FALSE;
        }
        $debate_data = array();
        foreach ($polls as $k => $v) {
            $debate_data[$k]['topic_id'] = $v['tid'];
            $debate_data[$k]['post_id'] = $v['pid'];
            $debate_data[$k]['user_id'] = $v['username'];
            $debate_data[$k]['stand'] = $v['stand'];
            $debate_data[$k]['post_time'] = $v['dateline'];
            $debate_data[$k]['voters'] = $v['voters'];

            $supported_data[$k]['post_id'] = $v['pid'];
            $supported_data[$k]['user_ids'] = preg_replace('/\s+/', ',', $v['voterids']);
        }
        $this->debate_post_model->insert_batch($debate_data);
        $this->posts_supported_model->insert_batch($supported_data);
    }

    public function forums() {
        //全部导入
        $data = $this->get_data('forums');
        if (!empty($data)) {
            $this->message('已经全部完成，不要重复导入');
        }
        //清空当前论坛数据。
        $this->db->empty_table('forums');
        $this->db->empty_table('forums_statistics');

        $forums = array(
            'fid' => 'id',
            'fup' => 'parent_id',
            'type' => 'type',
            'name' => 'name',
            'status' => 'status',
            'displayorder' => 'display_order',
            'allowanonymous' => 'is_anonymous',
            'allowsmilies' => 'is_smilies',
            'allowhtml' => 'is_html',
            'description' => 'description',
            'icon' => 'icon',
            'moderators' => 'manager',
            'dateline' => 'create_time',
        );
        $forums_statistics = array(
            'fid' => 'forum_id',
            'posts' => 'posts',
            'threads' => 'topics',
            'todayposts' => 'today_posts',
        );

        $forumtable = 'forum_forum';
        $forum_forumfield = 'forum_forumfield';
        $sql = "SELECT f.*,d.description,d.icon,d.moderators,d.dateline FROM $this->pre$forumtable f left join $this->pre$forum_forumfield d ON d.fid=f.fid WHERE f.status in (0,1)";
        $query = $this->dzdb->query($sql);
        $rows = $query->result_array();
        if (!empty($rows)) {
            $batch1 = array();
            $batch2 = array();
            foreach ($rows as $key => $row) {
                foreach ($row as $k => $v) {
                    if (!empty($forums[$k])) {
                        if (isset($batch1[$key][$forums[$k]]))
                            continue;
                        if ($k == 'icon' && !empty($v)) {
                            $new_v = 'uploads/old/' . $v;
                            $this->get_file($v, $new_v);
                            $v = $new_v;
                        } elseif ('moderators' == $k) {
                            $v = preg_replace('/\s+/', ',', $v);
                        }
                        $batch1[$key][$forums[$k]] = $v;
                    }
                    if (!empty($forums_statistics[$k])) {
                        if (isset($batch2[$key][$forums_statistics[$k]]))
                            continue;
                        $batch2[$key][$forums_statistics[$k]] = $v;
                    }
                    if ('lastpost' == $k && !empty($v)) {
                        //213680	Adobe AIR权威指南	1373300163	momogoho
                        $lastpost = preg_split('/\s+/', $v);
                        if (!empty($lastpost[2]) && !empty($lastpost[3])) {
                            $batch2[$key]['last_post_time'] = $lastpost[2];
                            $batch2[$key]['last_author'] = $lastpost[3];
                        }
                    } else {
                        $batch2[$key]['last_post_time'] = 0;
                        $batch2[$key]['last_author'] = '';
                    }
                }
            }
            $r1 = $this->forums_model->insert_batch($batch1);
            $r2 = $this->forums_statistics_model->insert_batch($batch2);
            if ($r1 && $r2) {
                $this->set_data('forums', 'ok');
                $this->message('处理完成', 1);
            } else {
                $this->message('处理失败');
            }
        }
    }

    public function empty_topics() {
        $this->db->empty_table('topics');
        $this->db->empty_table('posts');
        $this->db->empty_table('ask');
        $this->db->empty_table('poll');
        $this->db->empty_table('debate');
        $this->db->empty_table('ask_posts');
        $this->db->empty_table('poll_voter');
        $this->db->empty_table('poll_options');
        $this->db->empty_table('debate_posts');
        $this->db->empty_table('posts_supported');
        $this->db->empty_table('attachments');
        $this->message('数据表已经清空');
    }

    public function get_data($action) {
        $filename = $this->dir . $action;
        if (file_exists($filename)) {
            $data = file_get_contents($filename);
            return json_decode($data, TRUE);
        } else {
            return FALSE;
        }
    }

    public function set_data($action, $data) {
        $filename = $this->dir . $action;
        return file_put_contents($filename, json_encode($data));
    }

    public function get_file($from, $to, $dir = 'common') {
        $old_path = 'http://bbs.9ria.com/data/attachment/' . $dir . '/';
        $new_path = FCPATH;
        $this->load->model('biz_curl');
        $content = $this->biz_curl->my_fopen($old_path . $from);
        if (!empty($content)) {
            $new_file = $new_path . $to;
            $filedir = dirname($new_file);
            $this->forcemkdir($filedir);
            return file_put_contents($new_file, $content);
        } else {
            return false;
        }
    }

    public function forcemkdir($path) {
        if (!file_exists($path)) {
            $this->forcemkdir(dirname($path));
            mkdir($path, 0777);
        }
    }

    public function bbcode($str) {
        if (empty($this->BBCode)) {
            $BBCode_path = FCPATH . APPPATH . 'third_party/';
            include_once $BBCode_path . 'dz_bbcode/function_discuzcode.php';
            $this->BBCode = TRUE;
        }
        $parsed = discuzcode($str);
        return $parsed;
    }

    private function forum_new() {
        $this->forum_new = array(
            '277' => '1',
            '279' => '2',
            '286' => '3',
            '278' => '8',
            '283' => '9',
            '284' => '11',
            '285' => '12',
            '280' => '14',
            '281' => '21',
            '265' => '22',
            '270' => '23',
            '267' => '25',
            '268' => '2',
            '274' => '26',
            '266' => '29',
            '273' => '34',
            '271' => '36',
            '272' => '38',
            '275' => '4',
            '276' => '43',
            '255' => '49',
            '261' => '50',
            '264' => '52',
            '256' => '61',
            '258' => '62',
            '260' => '63',
            '257' => '64',
            '259' => '65',
            '287' => '80',
            '289' => '82',
            '288' => '81',
            '292' => '95',
            '288' => '100',
            '308' => '123',
            '299' => '121',
            '302' => '138',
            '301' => '140',
            '3' => '145',
            '42' => '146',
            '43' => '147',
            '60' => '148',
            '14' => '149',
            '53' => '150',
            '4' => '151',
            '5' => '152',
            '18' => '153',
            '33' => '154',
            '54' => '155',
            '20' => '156',
            '57' => '157',
            '58' => '158',
            '51' => '159',
            '52' => '160',
            '68' => '161',
            '73' => '162',
            '61' => '163',
            '55' => '164',
            '312' => '165',
            '27' => '166',
            '64' => '167',
            '59' => '168',
            '56' => '169',
            '21' => '170',
            '29' => '171',
            '17' => '172',
            '74' => '173',
            '28' => '174',
            '8' => '175',
            '10' => '176',
            '9' => '177',
            '46' => '178',
            '7' => '179',
            '63' => '180',
            '19' => '181',
            '11' => '182',
            '75' => '183',
            '47' => '184',
            '44' => '185',
            '25' => '186',
            '49' => '187',
            '12' => '188',
            '254' => '189',
            '66' => '190',
        );
    }
    
}

?>
