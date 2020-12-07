<?php
class Employee extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function logIn($pseudo,$pass){
        $val=FALSE;
        $query = $this->db->get('cashemployee');
        $list= $query->result_array();

        if(($pseudo==NULL)||($pass==NULL)){
            
            throw new Exception("One or both of the entries are empty");

        }else{
            foreach ($list as $l):
                if(($pseudo==$l['pseudo'])&&($pass==$l['pass'])) {
                    $val=TRUE;
                }
                else {
                    throw new Exception("Check either of the entries");
                }

            endforeach;
        }
            
        return $val;
    }

    public function get_Employees()
    {
        $query = $this->db->get('cashemployee');
        return $query->result_array();
    }
}
?>