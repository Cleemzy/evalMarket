<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?= site_url("assets/bootstrap/css/bootstrap.min.css")?>" type="text/css"> 
    <link rel="stylesheet" href="<?= site_url("assets/css/goods.css")?>" type="text/css">

  </head>

  <body class="body">
    
    <div class="container">
      <h1>LISTE DES ARTICLES EN STOCK</h1>
      <table class="table">
      <thead class="thead">
      <tr>
              <th scope="col">Code</th>
              <th scope="col">Designation</th>
              <th scope="col">Prix unitaire</th>
              <th scope="col">Stock</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($goods as $gd): ?>
      <tr>
              <th scope="row"><?php echo $gd['code']; ?></th>
              <td><?php echo $gd['designation']; ?></td>
              <td><?php echo $gd['up']; ?></td>
              <td><?php echo $gd['stock']; ?></td>
      </tr>
      <?php endforeach; ?>
      </tbody>
      </table>
      <a class="link" href="<?= site_url("mainController/")?>">Retour</a>
    </div>

  </body>
</html>

