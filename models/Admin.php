<?php
class Admin extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function get_Admins()
    {
        $query = $this->db->get('cashadmin');
        return $query->result_array();
    }
}
?>