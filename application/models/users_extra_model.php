<?php

class Users_extra_model extends MY_Model {
    
    public $credit_expression = 'extcredits1*3+extcredits2*2+extcredits3';
            
    function __construct() {
        parent::__construct();
        $this->table = 'users_extra';
        $this->id = 'user_id';
    }
    
    public function update($data, $where) {
        if (!empty($this->table) && !empty($data) && !empty($where)) {
            $is_succ = $this->db->update($this->table, $data, $where);
            if($is_succ){
                //如果更新了积分，自动计算总分，并且更新总分。
                if(preg_match('/extcredits[1-8]/', join(',', key($data)))){
                    $this->update_credits($where);
                    
                }
            }
        } else {
            return FALSE;
        }
    }
    
    /**
     * 根据extra的积分数，自动更新总积分，和用户所属组
     * @author  xiaxuezhi
     */
    public function update_credits($where) {
        //获取扩展积分
        $extra = $this->get_by_id($id);
        //根据总分计算公式，计算得出总积分
        $expression = $this->credit_expression;
        $expression = preg_replace('/extcredits[1-8]/', '$\0', $expression);
        echo $expression;
        $credits = $this->credit_expression;
        //根据总积分，获取当前所属组。
        
        //更新数据
    }

}

?>
