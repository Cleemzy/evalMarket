<?php
class Promotions extends CI_Model{


    public function __construct(){
        $this->load->database();
    }

    public function processPromotion($promotion,$nombre,$up){
        $type='';
        $prixFinal=0;

            try{
                $type=$this->getPromotionType($promotion);
            

                    //If $promotionType is 'Reduction de %'
                    if(strcasecmp($type,'Reduction de %')==0){

                        $arrayNumbers=$this->getArrayOfNumbers($promotion);
                        $percent=$arrayNumbers[0][0];
                        $percentReductionValue=$up*($percent/100);
                        $newUp=$up-$percentReductionValue;
                        $prixFinal=$newUp*$nombre;
                    }

                    //If $promotionType is 'Pas de promotion'
                    if(strcasecmp($type,'Pas de promotion')==0){
                        $prixFinal=$nombre*$up ;
                    }

                    //If $promotionType is 'Achetes et offerts'
                    if(strcasecmp($type,'Achetes et offerts')==0){

                        $arrayNumbers=$this->getArrayOfNumbers($promotion);
                        $given=$arrayNumbers[0][0]+$arrayNumbers[0][1];
                        $achetes=$arrayNumbers[0][0];
                        $offerts=$arrayNumbers[0][1];

                            if($nombre<$given){

                                $prixFinal=$up*$nombre;

                            }elseif($nombre>=$given){

                                    if($nombre%$given==0){
                                        $nApp=0;
                                        $nNapp=0;

                                        $nApp=(integer)($nombre*($achetes/$given));
                                        $nNapp=$nombre-$nApp;

                                        $prixFinal=($nApp*$up)+($nNapp*0);

                                    }else{

                                        $nApp=0;
                                        $nNapp=0;

                                        $nApplicableAuProm=$nombre-($nombre%$given);
                                        $reste=$nombre%$given;

                                            $nApp=(integer)($nApplicableAuProm*($achetes/$given));
                                            $nNapp=$nApplicableAuProm-$nApp;

                                        $pReste=$reste*$up;

                                        $prixFinal=($nApp*$up)+($nNapp*0)+$pReste;
                                    }

                            }
                                
                            
                    }
            
                    //If $promotionType is 'Achetes et %'
                    if(strcasecmp($type,'Achetes et %')==0){

                        $arrayNumbers=$this->getArrayOfNumbers($promotion);
                        
                        $achetes=$arrayNumbers[0][0];
                        $reduit=1;
                        $given=$achetes+$reduit;

                        $percent=$arrayNumbers[0][2];
                        
                        if($nombre<$given){

                            $prixFinal=$up*$nombre;

                        }elseif($nombre>=$given){

                            if($nombre%$given==0){
                                $nApp=0;
                                $nNapp=0;

                                $nApp=(integer)($nombre*($achetes/$given));
                                $nNapp=$nombre-$nApp;

                                $prixFinal=(integer)(($nApp*$up)+($nNapp*($up*($percent/100))));

                            }else{

                                $nApp=0;
                                $nNapp=0;

                                $nApplicableAuProm=$nombre-($nombre%$given);
                                $reste=$nombre%$given;

                                    $nApp=(integer)($nApplicableAuProm*($achetes/$given));
                                    $nNapp=$nApplicableAuProm-$nApp;

                                $pReste=$reste*$up;

                                $prixFinal=(integer)(($nApp*$up)+($nNapp*($up*($percent/100)))+$pReste);
                            }
                        }

                    }


                }catch(Exception $e){
                    throw $e;
                }

        return $prixFinal;
    }


    //Extract numbers from $promotion 
    public function getArrayOfNumbers($promotion){
        $array=NULL;
        preg_match_all('!\d+!', $promotion, $array);
        return $array;
    }

    public function getPromotionType($promotion){
        $type='';
        $reductionS='reduction';
        $percentS='%';
        $achetesS='achetes';
        $offertsS='offerts';
        $noProm='Pas de promotion';

        //checking various bool options to $promotion
        $checkPercent=$this->checkWordFromProm($promotion,$percentS);
        $checkReduction=$this->checkWordFromProm($promotion,$reductionS);
        $checkAchetes=$this->checkWordFromProm($promotion,$achetesS);
        $checkOfferts=$this->checkWordFromProm($promotion,$offertsS);
        $checkNoProm=$this->checkWordFromProm($promotion,$noProm);

                    //if $promotion contains '%' and 'reduction'
                    if(($checkPercent)&&($checkReduction)){
                        $type='Reduction de %';
                    }

                    //if $promotion contains 'achetes' and '%'
                    if(($checkAchetes)&&($checkPercent)){
                        $type='Achetes et %';
                    }

                    //if $promotion contains 'achetes' and 'offerts'
                    if(($checkAchetes)&&($checkOfferts)){
                        $type='Achetes et offerts';
                    }
                    if($checkNoProm){
                        $type='Pas de promotion';
                    }
                    if($type==''){
                        throw new Exception('Type of promotion still not listed');
                    }
        return $type;
                    
    }

    public function checkWordFromProm($promotion,$word){
        $check=FALSE;
        if(strpos($promotion,$word)!==FALSE){
            $check=TRUE;
        }

        return $check;
    }
}
?>    