<!DOCTYPE html>
<head>
<link rel="stylesheet" href="<?= site_url("assets/bootstrap/css/bootstrap.min.css")?>" type="text/css"> 
<link rel="stylesheet" href="<?= site_url("assets/css/ticket.css")?>" type="text/css">
</head>

<body class="body">
  <div class="container">
    <h4>LISTE DES ACHATS</h4>
      <form action="<?= site_url('mainController/imprimer') ?>" method="post">
        <table class="table" id="table">
          <thead class="thead">
            <tr>
                <th>Qte</th>
                <th>Designation</th>
                <th>P.Unit</th>
                <th>Promotion</th>
                <th>Total</th>
            </tr>
</thead>
            <?php 
                for($i=0;$i<sizeof($lists['preList']);$i++){
            ?>
            <tr>
                    <td><input type="text" name="<?php echo('qte'.$i);?>" value="<?php echo($lists['preList'][$i]['nombre']); ?>"  readonly></input></td>
                    <td><input type="text" name="<?php echo('designation'.$i);?>" value="<?php echo($lists['preList'][$i]['designation']); ?>"  readonly></input></td>
                    <td><input type="text" name="<?php echo('punit'.$i);?>" value="<?php echo($lists['preList'][$i]['up']); ?>" size="15" readonly></input></td>
                    <td><input type="text" name="<?php echo('promotion'.$i);?>" value="<?php echo($lists['preList'][$i]['promotion']); ?>"   readonly></input></td>
                    <td><input type="text" name="<?php echo('total'.$i);?>" value="<?php echo($lists['preList'][$i]['final']); ?>"  readonly> Ar</input></td>

            </tr>


               <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td> <input type="text" name="somme" value="<?php echo($lists['somme']); ?>"> Ar</input></td>
            </tr>
            <tr>
                <td><input type="hidden" name="taille" value="<?php echo(sizeof($lists['preList']));?>"></input></td>
                <td><input type="hidden" name="total" value="<?php echo($total);?>"></input></td>
            </tr>
                <tr>
                  <td><h5>BENEFICE POUR CET ACHAT: </h5><input type="text" name="benefice" value="<?php echo($benefice);?>"> Ar</input></td>
                </tr>
                <tr>
                <td><h5>CHIFFRES D'AFFAIRE DE CETTE CAISSE: <?php echo($total);?> Ariary </h5></td>
                </tr>
        </table>
        <button class="btn-primary" type="submit" class="btn btn-success btn-lg btn-block">IMPRIMER</button>
      </form>  
    <table>  
    <div class="links">
      <tr>
              
              <a id="l1" href="<?= site_url('mainController/goEntry') ?>" accesskey="M">NEXT</a>
              
              
              <a id="l2" href="<?= site_url('mainController/showChiffresDaffaire') ?>" >CHIFFRES D'AFFAIRE</a>
            
         
                </div>
    </table>  
                </div>
</body>
</html>