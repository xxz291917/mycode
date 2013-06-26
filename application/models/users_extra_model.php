<?php

class Users_extra_model extends MY_Model {

    public $credit_expression = 'extcredits1*3+extcredits2*2+extcredits3';

    function __construct() {
        parent::__construct();
        $this->table = 'users_extra';
        $this->id = 'user_id';
        $this->load->model(array('credit_log_model', 'users_model', 'groups_model','biz_permission'));
    }

    public function admin_credits($credits, $uid) {
        //获取扩展积分
        $extra = $this->get_by_id($uid);
        //计算得到需要增减的积分数
        if ($extra) {
            $need_credits = array();
            foreach ($credits as $key => $value) {
                if (!preg_match('/extcredits[1-8]/', $key))
                    continue;
                $need = $value - $extra[$key];
                if ($need != 0) {
                    $need_credits[$key] = $need;
                }
            }
            if ($this->update_credits($need_credits, $uid)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * 根据extra的积分数，自动更新总积分，和用户所属组
     * @author  xiaxuezhi
     * @param array $credits 八个积分扩展项目
     * @param string $action 积分变更关键字
     * @param muil $uid 用户积分
     */
    public function update_credits($credits, $uid, $action = 'admin_set') {
        if (!empty($this->table) && is_array($credits) && !empty($uid)) {
            //更新extra表
            $sql = "UPDATE $this->table SET  ";
            $sql_tmp = '';
            foreach ($credits as $key => $value) {
                if ($value==0 || !preg_match('/extcredits[1-8]/', $key))
                    continue;
                $sql_tmp .= "$key=$key" . ($value > 0 ? '+' : '') . "$value,";
            }
            if (empty($sql_tmp)) {
                return TRUE;
            }
            $sql .= trim($sql_tmp, ',') . ' ';
            $sql .= $this->create_where(array('user_id' => $uid));

            $this->db->trans_begin(); //手动开启事务
            //echo $sql;die;
            $extra_succ = $this->db->query($sql);
            //更新log表
            $log_succ = $this->credit_log_model->insert_log($credits, $uid, $action);
            //根据当前公式刷新总积分
            $user_credits_succ = $this->refresh_credits($uid);
            if ($extra_succ && $log_succ && $user_credits_succ) {
                $this->db->trans_commit();
                return true;
            } else {
                $this->db->trans_rollback();
            }
        }
        return FALSE;
    }

    public function refresh_credits($uid) {
        //获取扩展积分
        $extra = $this->get_by_id($uid,false);
        //根据总分计算公式，计算得出总积分$credits
        extract($extra);
        $expression = $this->credit_expression;
        $expression = preg_replace('/extcredits[1-8]/e', '$\0', $expression);
        $expression = '$credits = ' . $expression . ';';
        eval($expression);
        //根据总积分，获取当前所属组ID$member_id。
        $member_id = $this->groups_model->rank_by_credits($credits);
        //更新数据
        $data['credits'] = $credits;
        $data['member_id'] = $member_id;
        return $this->users_model->update($data, array('id' => $uid));
    }

    public function post_increment() {
        $extra_data['posts'] = ':1';
        $extra_data['today_posts'] = $this->biz_permission->is_today($this->user['last_post_time'])?':1':1;
        $extra_data['today_uploads'] = ':1';
        $extra_data['last_post_time'] = $this->time;
        //$extra_data['last_active_time'] = $this->time;
        return $this->update_increment($extra_data,array('user_id' => $this->user['id']));
    }
    
    public function reply_increment() {
        $extra_data['posts'] = ':1';
        $extra_data['today_posts'] = $this->biz_permission->is_today($this->user['last_post_time'])?':1':1;
        $extra_data['today_uploads'] = ':1';
        $extra_data['last_post_time'] = $this->time;
        //$extra_data['last_active_time'] = $this->time;
        return $this->update_increment($extra_data,array('user_id' => $this->user['id']));
    }

    private function update_active_time() {
        return $this->update(array('last_active_time'=>$this->time), array('user_id'=>$this->user['id']));
    }
    
    /**
     * 更新最后活动时间和在线时长。
     */
    public function update_user_active(){
        $this->update_active_time();
        $active_time = $this->time - $this->user['last_active_time'];
        if ($active_time != 0) {
            if ($active_time <= Users_model::$max_active) {
                $this->update_increment(array('online_time' => ':' . $active_time), array('user_id' => $this->user['id']));
            } else {
                $this->update_increment(array('online_time' => '1'), array('user_id' => $this->user['id']));
                $this->update(array('last_login_time' => $this->time, 'last_login_ip' => $this->ip), array('user_id' => $this->user['id']));
            }
        }
        
    }
    
}

?>
