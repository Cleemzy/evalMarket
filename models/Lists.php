<?php
class Lists extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function getAlist($prelist){

        $somme=0;
            for($i=0;$i<sizeof($prelist);$i++){
                $somme+=$prelist[$i]['final'];
            }

        $list=["preList" => $prelist,
               "somme" => $somme
                ];

        return $list;
    }



    

            /*
                public function get_Admins()
                {
                    $query = $this->db->get('cashadmin');
                    return $query->result_array();
                }
            */
}
?>