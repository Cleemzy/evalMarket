<?php
class mainController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('goods');
        $this->load->model('employee');
        $this->load->model('varprom');
        $this->load->model('promotions');
        $this->load->model('admin');
        $this->load->model('lists');
        $this->load->model('chiffre');
        $this->load->model('achat');

    } 

    public function test(){
        $this->load->view('test');
    }
    public function showChiffresDaffaire(){
        $totalChiffres=$this->chiffre->getTotalChiffres();
        $data['chiffre']=$totalChiffres;
        $this->load->view('chiffres',$data);
    }

    public function imprimer(){
        $tableauPrint=(array) null;
        $somme=$_POST['somme'];
        for($i=0;$i<$_POST['taille'];$i++){
            $qte=$_POST['qte'.$i];
            $designation=$_POST['designation'.$i];
            $punit=$_POST['punit'.$i];
            $promotion=$_POST['promotion'.$i];
            $total=$_POST['total'.$i];

            $oneArray=[
                "qte" => $qte,
                "designation" => $designation,
                "punit" => $punit,
                "promotion" => $promotion,
                "total" => $total
            ];
            $new=array_push($tableauPrint,$oneArray);
           
        }
        
        //print_r($tableauPrint);
        $data['tableau'] = $tableauPrint;
        $data['somme'] = $somme; 
        $this->load->view('makepdf',$data);
        
    }

    public function trueList(){
    if(!empty($_POST)){
        $preList=(array) null;
        for($i=1;$i<100;$i++){
            if(((((((isset($_POST['code'.$i]) && (isset($_POST['designation'.$i]))) && (isset($_POST['nombre'.$i]))) && (isset($_POST['up'.$i]))) && (isset($_POST['stock'.$i]))) && (isset($_POST['promotion'.$i]))) && (isset($_POST['final'.$i])))){
                
                $code=$_POST['code'.$i];
                $designation=$_POST['designation'.$i];
                $nombre=$_POST['nombre'.$i];
                $up=$_POST['up'.$i];
                $stock=$_POST['stock'.$i];
                $promotion=$_POST['promotion'.$i];
                $final=$_POST['final'.$i];
                $newStock=$stock-$nombre;

                $oneArray=["code" => $code,
                "designation" => $designation, 
                "nombre" => $nombre, 
                "up" => $up,
                "stock" => $stock,
                "promotion" => $promotion,
                "final" => $final,
                "newStock" => $newStock
                ];
                $new=array_push($preList,$oneArray);
            }
        }
            
            //print_r($preList);
        // echo("<br><br>");
            $list=$this->lists->getAlist($preList);

            $motifs='';
            for($o=0;$o<sizeof($list['preList']);$o++){
                $motifs.=$list['preList'][$o]['nombre'].' '.$list['preList'][$o]['designation'].'/ ';
            }
            //echo($motifs);


            $QA_total=$this->achat->get_QA_with_total($list);
            //print_r($QA_total);
            //print_r($list);


            $this->goods->updateGoods($list);
            // $dateNow=date("Y-m-d H:i:s");
            //echo($dateNow);
            

            $chiffresDaffaire=$this->chiffre->getChiffreDaffaire($list,$QA_total,$motifs);
            $this->chiffre->insertChiffre($chiffresDaffaire);

            $totalChiffres=$this->chiffre->getTotalChiffres();
            $total=$totalChiffres['total'];
            
            $data['lists'] = $list;
            $data['total'] = $total;
            $data['benefice']=$list['somme']-$QA_total['total'];
            $this->load->view('ticket',$data);
        }else{
            redirect(site_url('mainController/goEntry'));

        }

    
    }


    public function testVarpromMethods(){
        $code=$_POST['code'];
        $amount=$_POST['amount'];
        $oneStock=NULL;
        $amountValid=FALSE;
        $error="";
        $theVarprom=$this->varprom->get_varprom();
        $achatArray=["code" => $code, "nombre" => $amount];
        //echo($achatArray["code"]." ".$achatArray["nombre"]);


                try{
                    $validArray=$this->varprom->checkArray($achatArray,$theVarprom);
                    //echo('CHECK ARRAY: '.$validArray.'<br>'.'CHECK CODE: '.$codeExist.'<br>'.'STOCK: '.$oneStock.'<br>'.'AMOUNT: '.$amount.'<br>'.'CHECK AMOUNT: '.$amountValid);
                }
                catch(Exception $e){
                    $error=$e->getMessage();
                }
                echo $error;
        /*
            try{

                $codeExist=$this->varprom->checkCode($code,$theVarprom);
                    if($codeExist){
                        $oneStock=$this->varprom->getStock($code,$theVarprom);
                        $designation=$this->varprom->getDesignation($code,$theVarprom);
                        $amountValid=$this->varprom->checkAmount($amount,$oneStock,$designation);
                    }
                
                echo('CHECK CODE: '.$codeExist.'<br>'.'STOCK: '.$oneStock.'<br>'.'AMOUNT: '.$amount.'<br>'.'CHECK AMOUNT: '.$amountValid);
            }catch(Exception $e){
                $error=$e->getMessage();
            }
            echo $error ;
        */
    }

    public function showPreList(){
        if(!empty($_POST)){
                    $loop=$_POST['count'];
                    $iloop=(int)$loop;
                    $array=(array) null;
                    $preList=(array) null;
                    $new=0;
                            for($i=1;$i<=$iloop;$i++){
                            $st=strval($i);
                            $code=$_POST['code'.$st];
                            $nombre=$_POST['nombre'.$st];
                            $inArray=["code" => $code, "nombre" => $nombre];
                            $new=array_push($array,$inArray);
                        }
            
                    $theVarprom=$this->varprom->get_varprom();
                    $error='';
                    $validAchat=FALSE;
                    try{
                                $validAchat=$this->varprom->checkAchatList($array,$theVarprom);
            
                                if($validAchat){
                                    
                                        /*
                                        for($j=0;$j<sizeof($array);$j++){
                                            echo(' '.$array[$j]['code'].' '.$array[$j]['nombre']);
                                        }
                                        */
                                        $preList=$this->varprom->sendPrelist($array,$theVarprom);
                                    }
                            
                            //Leading to buying prelist
                            
                            $admin=$this->admin->get_Admins();
                            $data['article']=$preList;
                            $data['admins']=$admin;
                            $this->load->view('preList',$data);
            
                    }catch(Exception $e){
                        $error=$e->getMessage();
                    }
                    echo($error);
                    
                    
            
            
                    //Various tests for promotions
                        // $promType=$this->promotions->getPromotionType($preList[0]['promotion']);
                        // echo("<br><br>STRING1: Reduction de % <br>STRCOMP: ".strcasecmp('reduction de %',$promType)."<br>Promotion type: ".$promType."<br>Promotion string: ".$preList[0]['promotion']."<br><br>");
                        // $arrayOfNumbers=$this->promotions->getArrayOfNumbers($preList[0]['promotion']);
                        // echo('<br>NUMBERS FROM PROM:');
                        // $nombre=7;
                        // $diviseur=3;
                        // $reponse=$nombre/$diviseur;
                        // echo((integer)$reponse);
                        // print_r($arrayOfNumbers);
                    ////////////////////////////////
            
                    
        }
       else{
                    redirect(site_url('mainController/goEntry'));
       }
    }

    public function goEntry(){
        $this->load->view('cashEntry');
    }

    public function disconnect(){
        $this->session->sess_destroy();
        redirect(site_url('mainController/'));
    }

    public function eLog(){
        $pseudo=$_POST['pseudo'];
        $pass=$_POST['pass'];
        $pass=sha1($pass);
        $error='';
        //echo ' '.$pseudo.' '.$pass;
        try{
            $log=$this->employee->logIn($pseudo,$pass);
            if($log==TRUE){
                echo("connected");
                $this->session->set_userdata('pseudo',$pseudo);
                redirect(site_url('mainController/goEntry'));
            }
        }
        catch(Exception $e){
            $error=$e->getMessage();
        }
        if($error!=''){
            echo $error;
        }
    }

    public function employeeLogin(){
        //$data=$this->employee->get_Employees();
        $this->load->view('employeeLogin.php');
    }

    public function viewGoods(){

        //Retrieving every data from the GOODS DATABASE
        $data=$this->goods->get_Goods();

        //  DIRECT DISPLAY TEST OF GOODS (NOT CANNON)
        /*
        foreach ($data as $gd):
            echo $gd['code']; 
            echo $gd['designation'];
            echo $gd['up'];
            echo $gd['stock'];
        endforeach;
        */

        //Sending the aray to the "goods" view
        
        $data['goods'] = $this->goods->get_Goods();
        $this->load->view('goods',$data);
        
    }
    
    public function index(){
        $this->load->view('cash');
    }
}

?>