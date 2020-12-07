<?php
class Chiffre extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function getChiffreDaffaire($list,$QA_total,$motifs){

        $dateNow=$dateNow=date("Y-m-d H:i:s");
        $montant=$list['somme']-$QA_total['total'];
        $chiffre=['heure' => $dateNow,'motifs' => $motifs,'montant' =>$montant];
        return $chiffre;
    }

    public function insertChiffre($chiffre){
        $data=[
            'heure' => $chiffre['heure'],
            'motifs' => $chiffre['motifs'],
            'montant'=> $chiffre['montant']
        ];
        $this->db->insert('chiffres',$data);
    }

    public function getTotalChiffres(){
        $chiffres=$this->get_Chiffres();
        $total=0;

        for($i=0;$i<sizeof($chiffres);$i++){
            $total+=$chiffres[$i]['montant'];
        }

        $totalChiffres=['chiffres'=>$chiffres,'total'=> $total];
        return $totalChiffres;
    }

    public function get_Chiffres()
    {
        $query = $this->db->get('chiffres');
        
        return $query->result_array();
    }

}