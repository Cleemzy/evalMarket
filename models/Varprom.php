<?php
class Varprom extends CI_Model{
    public function __construct(){
        $this->load->database();
        $this->load->model('promotions');
    }

//////////////////////////////////////////////////////
//Breaking down and rewriting the "checkAchat" function into small pieces 

    public function checkAchatList($achatList,$varprom){
        $validList=TRUE;
        $errorId=NULL;

            try{
                for($i=0;$i<sizeof($achatList);$i++){
                    if($this->checkArray($achatList[$i],$varprom)==FALSE){
                        $validList=FALSE;
                        $errorID=($i+1);
                    break;
                    }
                }
            }catch(Exception $e){
                throw $e;
            }
            

            if($validList==FALSE){
                throw new Exception("The purchase number ".$errorID." is wrong");
            }
        return $validList;
    }


    public function checkArray($achatArray,$theVarprom){
        $validArray=FALSE;
            try{

                $codeExist=$this->checkCode($achatArray['code'],$theVarprom);
                    if($codeExist){
                        $oneStock=$this->getStock($achatArray['code'],$theVarprom);
                        $designation=$this->getDesignation($achatArray['code'],$theVarprom);
                        $amountValid=$this->checkAmount($achatArray['nombre'],$oneStock,$designation);
                        if($amountValid){
                            $validArray=TRUE;
                        }
                    }
                
                //echo('CHECK ARRAY: '.$validArray.'<br>'.'CHECK CODE: '.$codeExist.'<br>'.'STOCK: '.$oneStock.'<br>'.'AMOUNT: '.$achatArray['nombre'].'<br>'.'CHECK AMOUNT: '.$amountValid);
            }catch(Exception $e){
                throw $e;
                //$error=$e->getMessage();
            }
            return $validArray;
    }

    public function checkAmount($amount,$stock,$designation){
        $amountValid=FALSE;
            if($amount<=$stock){
                $amountValid=TRUE;
            }
            if(empty($amount)){
                throw new Exception("Select amount for ".$designation);
            }
            if(!$amountValid){
                throw new Exception("Insufficient amount of ".$designation." in stock");
            }
            return $amountValid;
        
    }

    public function getDesignation($code,$array){
        $designation='';
            for($i=0;$i<sizeof($array);$i++){
                if($code==$array[$i]['code']){
                    $designation=$array[$i]['designation'];
                break;
                }
            }
        return $designation;
    }

    public function getStock($code,$array){
        $stock=0;
            for($i=0;$i<sizeof($array);$i++){
                if($code==$array[$i]['code']){
                    $stock=$array[$i]['stock'];
                break;
                }
            }
        return $stock;
    }

    public function checkCode($code,$array){
        $codeExist=FALSE;
            for($i=0;$i<sizeof($array);$i++){
                if($code==$array[$i]['code']){
                    $codeExist=TRUE;
                break;
                }
            }

            if(empty($code)){
                throw new Exception("You didn't submit an article");
            }
            if(!$codeExist){
                throw new Exception("The article code: <".$code."> is invalid");
            }
            return $codeExist;
    }
///////////////////////////////////////////////////////////////
    public function sendPrelist($achats,$varprom){
        $preList=(array) null;
        try{
                for($i=0;$i<sizeof($achats);$i++){

                    for($j=0;$j<sizeof($varprom);$j++){
                        if($achats[$i]['code']==$varprom[$j]['code']){
                            $code=$varprom[$j]['code'];
                            $designation=$varprom[$j]['designation'];
                            $promotion=$varprom[$j]['nom'];
                            $nombre=$achats[$i]['nombre'];
                            $up=$varprom[$j]['up'];
                            $stock=$varprom[$j]['stock'];

                            //process promotions
                            $prixFinal=$this->promotions->processPromotion($promotion,$nombre,$up);

                            $oneArray=["code" => $code,
                            "designation" => $designation,
                            "nombre" => $nombre,
                            "up" => $up,
                            "stock" => $stock,
                            "promotion" => $promotion,
                            "final" => $prixFinal
                            ];
                            
                            $push=array_push($preList,$oneArray);
                        }
                    }
                }
        }catch(Exception $e){
            throw $e;
        }

        return $preList;
    }

    /*
    public function checkAchat($achats,$varprom){

        //$varprom=get_varprom();
        $wrongCodeArray=(array) null;
        $invalidQuantityArray=(array) null;

        $codeExist=FALSE;
        $validStock=FALSE;
        $validAchat=FALSE;

             for($i=0 ; $i<sizeof($achats) ;$i++){

                for($j=0;$j<sizeof($varprom);$j++){
                    if($achats[$i]['code']==$varprom[$j]['code']){
                        $codeExist=TRUE;

                        //a little mistake but worth notice
                        //throws new Exception("Check the code of article number ".$i);
                    }
                    if($codeExist){
                        //throws new Exception("Unsufficient quantity in stock of article number ".$i);

                        if($achats[$i]['nombre']<=$varprom[$j]['stock']){
                            $validStock=TRUE;
                        }else{
                            $pushInvalidQuantity=array_push($invalidQuantityArray,$varprom[$j]['designation']);
                           
                            //Same situation as the issue below this condition 
                            //throw new Exception("Unsufficient quantity in stock of article number ".$achats[$i]['code']);
                        }

                    }
                    //Must rewrite the code below 'cause the loop can't reach beyond the exception
                    else{
                        $pushWrongCode=array_push($wrongCodeArray,($i+1));
                        //throw new Exception("Check the code of article number ".($i+1)." ".$achats[$i]['code']." ".$varprom[$j]['code']);
                    }
                }
        }
        
        //Concat error lists
        //for WRONG CODE:
            $textForWrongCode='';
                for($w=0;$w<sizeof($wrongCodeArray);$w++){
                    $textForWrongCode.=' ,'.$wrongCodeArray[$w];
                }
        //for INVALID AMOUNT:
            $textForInvalidQuantity='';
            for($z=0;$z<sizeof($invalidQuantityArray);$z++){
                $textForInvalidQuantity.=' ,'.$invalidQuantityArray[$z];
            }
            ///////////

            //condition FOR ALL VALIDITY 
            $empty='';

        if($textForWrongCode!=$empty){
            throw new Exception("Check the code of article number ".$textForWrongCode);
        }
        if($textForInvalidQuantity!=$empty){
            throw new Exception("These articles are out of amount: ".$textForInvalidQuantity);
        }

        if(($textForWrongCode==$empty)&&($textForInvalidQuantity==$empty)){
            $validAchat=TRUE;
        }
        return $validAchat;
    }
*/

    public function get_varprom(){
        $query = $this->db->get('viewgp');
        return $query->result_array();
    }

}