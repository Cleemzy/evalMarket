<?php
class Achat extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function get_QA_with_total($list){
        $QA_withSomme=$this->somme_QA($list);
        $total=0;
        for($i=0;$i<sizeof($QA_withSomme['montants']);$i++){
           $total+=$QA_withSomme['montants'][$i]; 
        }
        $QA_total=[
            'pach' => $QA_withSomme['pach'],
            'quantite' => $QA_withSomme['quantite'],
            'montants' => $QA_withSomme['montants'],
            'total' => $total
        ];
        return $QA_total;
    }

    public function somme_QA($list){
        $QA=$this-> get_QuantiteAchat($list);
        $montants=(array)null;
        for($i=0;$i<sizeof($QA['pach']);$i++){

            $montant=$QA['pach'][$i]['pachat']*$QA['quantite'][$i];
            $new=array_push($montants,$montant);
        }

        $QA_withSomme=[
            'pach' => $QA['pach'],
            'quantite' => $QA['quantite'] ,
            'montants' => $montants
        ];

        return $QA_withSomme;
    }
    public function get_QuantiteAchat($list){

        $ach=$this->get_SpecificAchat($list);
        $quantites=(array) null;
    
        for($i=0;$i<sizeof($ach);$i++){
            for($j=0;$j<sizeof($list['preList']);$j++){
                if($ach[$i]['code']==$list['preList'][$j]['code']){
                    $new=array_push($quantites,$list['preList'][$j]['nombre']);
                }
            }
        }    
        $newArray=['pach' =>$ach,
                    'quantite' =>$quantites
        ];
        return $newArray;
    }

    public function get_SpecificAchat($list)
    {
        $codes=(array) null;
        for($i=0;$i<sizeof($list['preList']);$i++){
          $new=array_push($codes,$list['preList'][$i]['code']);  
        }

        $this->db->select('*');
        $this->db->from('achat');
        $this->db->where_in('code',$codes);
        $query = $this->db->get();
        
        return $query->result_array();
    }

}
?>