<?php
class Goods extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function updateGoods($list)
{

        for($i=0;$i<sizeof($list['preList']);$i++){

            $data = ['stock'  => $list['preList'][$i]['newStock']];

            $this->db->where('code', $list['preList'][$i]['code']);
            $this->db->update('goods',$data);
        }
            
    } 
    
    public function get_Goods()
    {
        $query = $this->db->get('goods');
        
        //Test de parcours de $query->result_array()
        /*
        foreach ($query->result_array() as $row)
            {
                    echo $row['code'];
                    echo $row['designation'];
                    echo $row['up'];
                    echo $row['stock'];
            }
        */
        
        return $query->result_array();
    }
    
}
?>