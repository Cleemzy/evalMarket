<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="<?= site_url("assets/bootstrap/css/bootstrap.min.css")?>" type="text/css"> 
<link rel="stylesheet" href="<?= site_url("assets/css/chiffres.css")?>" type="text/css">
</head>
<body class="body">
  <div class="container">
    <h1>HISTORIQUE ET CHIFFRES D'AFFAIRE</h1>
    <table class="table" id="table">
      <thead class="thead-dark" id="thd">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Motifs</th>
            <th scope="col">Montant</th>
    </tr>
      </thead>
    <?php
        for($i=0;$i<sizeof($chiffre['chiffres']);$i++){
    ?>
    <tr>
            <th scope="row"><?php echo($chiffre['chiffres'][$i]['heure']);?> </th>
            <td><?php echo($chiffre['chiffres'][$i]['motifs']);?> </td>
            <td><?php echo($chiffre['chiffres'][$i]['montant']);?> Ar</td>

    </tr>
      <?php  } ?>
      <tr>
        <td><h4>CHIFFRE D'AFFAIRE TOTALE DE CETTE CAISSE:  <?php echo($chiffre['total']);?> Ar</h4></td>
        </tr>
    </table>
    <div class="link">
    <a id="l2" href="<?= site_url('mainController/') ?>">HOME</a>
        </div>
  </div>
</body>
</html>