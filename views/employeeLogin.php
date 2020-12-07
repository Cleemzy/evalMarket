<!DOCTYPE html>
<html>
<head>
<head>
        <link rel="stylesheet" href="<?= site_url("assets/bootstrap/css/bootstrap.min.css")?>" type="text/css"> 
        <link rel="stylesheet" href="<?= site_url("assets/css/employeeLogin.css")?>" type="text/css">
    </head>
</head>
<body class="body">
  <div class="container">
    <h1>CONNEXION</h1>
    
    
    <form action="<?= site_url('mainController/eLog/') ?>" method="post">
        <div class="form-group">
        <label for="thePseudo">Pseudo</label>
        <input class="form-control" id="thePseudo" type="text" name="pseudo" value="Employee1" placeholder='pseudo' >
        </div>
        
        <div class="form-group">
        <label for="thePassword">Mot de passe</label>
        <input class="form-control" id="thePassword" type="password" name="pass" value="mdpEmploye1" placeholder="password" >
        </div>
        
        <button class="btn btn-primary" type="submit">Connexion</button>
        
    </form>
    <a href="<?= site_url('mainController/') ?>">HOME</a>
  </div>
  
</body>
</html>