<?php

class Poll_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='poll';
        $this->id='topic_id';
        $this->load->model(array('poll_options_model','poll_voter_model'));
    }
    
    public function submit_poll($id,$options){
        //总投票数+1；
        $is_poll = $this->update_increment(array('voters'=>':1'), array('topic_id'=>$id));
        
        $poll_voter = array('topic_id'=>$id,
            'user_id'=>$this->user['id'],
            'username'=>$this->user['username'],
            'options'=>  join(',', $options),
            'vote_time'=>  $this->time,
            );
        $is_poll_voter = $this->poll_voter_model->insert($poll_voter);
        
        $poll_options = array(
            'votes'=>':1',
            //'voterids'=>'+'.$this->user['id'],
            );
        $where = " id IN(".join(',', $options).')';
        $is_poll_options = $this->poll_options_model->update_increment($poll_options, $where);
        
        return $is_poll && $is_poll_voter && $is_poll_options;
    }
    
}

?>
