<?php

class  Smiley_model extends MY_Model {

    public $type = array(
        1  =>array('默认','smiley','default'),
        2  =>array('酷猴', 'smiley', 'coolmonkey'),
        3  =>array('呆呆男','smiley', 'grapeman'),
    );
            
    function __construct() {
        parent::__construct();
        $this->table='smiley';
    }
    
    public function get_smiley(){
        $smile_url = "js/kindeditor/plugins/smiley/images/";
        $sql = "select s.id,s.code,s.url,t.name,t.directory from smiley s left join smiley_type t on t.id = s.type_id where s.type='smiley' order by t.displayorder,s.displayorder";
        $query = $this->db->query($sql);
        $smileys = $query->result_array();
        $tmp_smileys = array();
        foreach ($smileys as $key => $smiley) {
            $smiley['url'] = base_url().$smile_url.$smiley['directory'].'/'.$smiley['url'];
            unset($smiley['name'],$smiley['directory']);
            $tmp_smileys[$smiley['id']] = $smiley;
        }
        return $tmp_smileys;
    }
    
    
    
    
    
}

?>
