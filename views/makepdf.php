<?php
require_once __DIR__ . '/vendor/autoload.php';

/*
echo($tableau[0]['designation']);
echo('<br>');
echo($somme);
*/
$total=$_POST['total'];
$benefice=$_POST['benefice'];;
//Create a new pdf instance
$mpdf = new \Mpdf\Mpdf();

//Datenow
$dateNow=date("Y-m-d H:i:s");

//Creating a pdf
$data = '';
$data .= '<h1>LeTsyClerc</h1><br />';
$data .=' <p>'.$dateNow.'</p><br /> ';
$data.= '<h2>TICKET DE CAISSE</h2><br />';
$data.='<p>_____________________________________________________________________________</p><br />';
//Add some data
//Tableau
$data.='<table>
<tr>
    <td><strong>Qte</strong></td>
    <td><strong>Designation</strong></td>
    <td><strong>P.Unit</strong></td>
    <td><strong>Promotion(s)</strong></td>
    <td><strong>Total</strong></td>
</tr>';

for($i=0;$i<sizeof($tableau);$i++){
    $data.='<tr>
            <td>'.$tableau[$i]["qte"].'</td>
            <td>'.$tableau[$i]["designation"].'</td>
            <td>'.$tableau[$i]["punit"].'</td>
            <td>'.$tableau[$i]["promotion"].'</td>
            <td>'.$tableau[$i]["total"].' Ar</td>
    </tr>';
}
$data.='
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>'.$somme.' Ar</td>
</tr>
</table>
<br />
<br />

';
$data.='<p>Benefice pour cet achat: '.$benefice.' Ar</p><br />';
$data.='<p>_____________________________________________________________________________</p><br />';

$data.='<p>Merci de votre visite!</p><br />';
$data.='<p>Chiffres d affaire : '.$total.' Ar</p><br />';
// Write PDF
$mpdf->WriteHTML($data);

//Output to browser
$mpdf->Output('ticket.pdf','D');
?>