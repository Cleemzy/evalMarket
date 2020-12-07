<!DOCTYPE html>
<head>
<link rel="stylesheet" href="<?= site_url("assets/bootstrap/css/bootstrap.min.css")?>" type="text/css"> 
<link rel="stylesheet" href="<?= site_url("assets/css/preList.css")?>" type="text/css">
</head>
<body class="body">
<div class="container">
    <h4 id="hd">LISTE TEMPORAIRE</h4>
    <form action="<?= site_url('mainController/trueList') ?>" method="post">
        <table class="table" id="table">
<thead class="thead">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Quantite</th>
                    <th scope="col">Prix unitaire</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Promotion</th>
                    <th scope="col">Total</th>
                    <th scope="col">Admin code pour supprimer</th>
                </tr>
</thead>
                <?php $i=1; ?>
                
            <?php foreach ($article as $a): ?>
                <tr id="<?= $i?>">
                    <td><input name="<?php echo ('code'.$i); ?>" size="15" type="text" value="<?php echo $a['code']; ?>" readonly></input></td>
                    <td><input name="<?php echo ('designation'.$i); ?>" size="15" type="text" value="<?php echo $a['designation']; ?>" readonly></input></td>
                    <td><input name="<?php echo ('nombre'.$i); ?>" size="15" type="text" value="<?php echo $a['nombre']; ?>" readonly></input></td>
                    <td><input name="<?php echo ('up'.$i); ?>" size="15" type="text" value="<?php echo $a['up']; ?>" readonly></input></td>
                    <td><input name="<?php echo ('stock'.$i); ?>" size="15" type="text" value="<?php echo $a['stock']; ?>" readonly></input></td>
                    <td><input name="<?php echo ('promotion'.$i); ?>" size="15" type="text" value="<?php echo $a['promotion']; ?>" readonly></input></td>
                    <td><input name="<?php echo ('final'.$i); ?>" size="15" type="text" value="<?php echo $a['final']; ?>" readonly></input></td>
                    <td id="error<?=$i?>">
                        <input type="password" name="<?php echo('password'.$i) ?>" id="<?php echo('password'.$i) ?>">
                        <button type="button" onclick = "Delete(<?php echo($i); ?>,<?php echo('password'.$i) ?>.value)"> Delete </button> 
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        
        </table>
        <button  type="submit" class="btn btn-success btn-lg btn-block">CONFIRM</button>
    </form>
    <a id="dc" href="<?= site_url('mainController/disconnect') ?>">Deconnexion</a>
            </div>
<script type="text/javascript">
var passwords=[];
<?php
    foreach ($admins as $adm):
    ?> passwords.push('<?php echo $adm['pass'];?>');
    <?php endforeach;
    ?>


                    function Delete(i,password){ 
                        //console.log(password);
                        var passwords=[];
                        <?php
                        foreach ($admins as $adm):
                        ?> passwords.push("<?php echo $adm['pass'];?>");
                        <?php endforeach;
                        ?>
                            var check=checkPassword(password,passwords);
                            if(check){
                                document.getElementById(""+i).remove(); 
                            }else{
                                var col=document.getElementById('error'+i);                                 
                                var tag = document.createElement("small");
                                var br=document.createElement("br");
                                var text = document.createTextNode("Wrong password");

                                tag.appendChild(text);
                                col.appendChild(tag);
                                col.appendChild(br);
                                
                                //alert("Wrong password");
                            }
                        } 

                    function checkPassword(password,pass){
                        var  check=false;
                                
                    for(i=0;i<pass.length;i++){
                                    //var string1=password.toString();
                                    // var string2=pass[i].toString();
                                    //console.log(string1+" "+string2);
                    if(password==pass[i]){
                        check=true;
                        }
                                    //console.log("Locale Compare"+password.localeCompare(pass[i]));
                                    // console.log(password+" "+pass[i]);
                                    // console.log(check);
                                }
                    return check;
                    }
    
</script>
<?php
    foreach ($admins as $adm):
     //echo $adm['pass'];
    endforeach;
    ?>
</body>

