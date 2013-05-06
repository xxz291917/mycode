<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_admin_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='groups_admin';
    }

    //'system', 'special', 'member'
    public function get_groups() {
        $sql = "SELECT ga.*,g.name,g.type,g.stars FROM {$this->table} ga LEFT JOIN groups g ON g.id = ga.group_id WHERE 1 ORDER BY g.type";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function form_filter($forums, $type = 'en') {
        foreach ($forums as $key => $value) {
            if ($type == 'en') {
                switch ($key) {
                    case 'submit':
                        unset($forums[$key]);
                        break;
                    case 'allow_special':
                        $forums[$key] = join(',', $value);
                        break;
                    case 'extra_setting':
                        $forums[$key] = json_encode($value);
                        break;
                    default:
                        $forums[$key] = trim($value);
                        break;
                }
            } else {
                switch ($key) {
                    case 'allow_special':
                        //权限存取的规则都是，以逗号分隔的用户组id。
                        $forums[$key] = explode(',', $value);
                        break;
                    case 'extra_setting':
                        $forums[$key] = json_decode($value, TRUE);
                        break;
                }
            }
        }
        return $forums;
    }
}

?>
