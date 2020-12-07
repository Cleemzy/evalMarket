<html>
  <head>
  <link rel="stylesheet" href="<?= site_url("assets/bootstrap/css/bootstrap.min.css")?>" type="text/css"> 
  <link rel="stylesheet" href="<?= site_url("assets/css/cashEntry.css")?>" type="text/css">
    <script type="text/javascript">
    // <![CDATA[

        function getCount(count){
            if(count==0){
                count==1;
            }
            return count;
        }
      var count = 0;

      function addRow() {
        var table      = document.getElementById("table");
        var row        = document.createElement("tr");
        var countCell  = document.createElement("td");
        var countText  = document.createTextNode(++count);
        var firstCell  = document.createElement("td");
        var firstInput = document.createElement("input");
        var lastCell   = document.createElement("td");
        var lastInput  = document.createElement("input");

        firstInput.type = "text";
        firstInput.name = "code" + count;
        lastInput.type  = "text";
        lastInput.name  = "nombre" + count;

        table    .appendChild(row);
        row      .appendChild(countCell);
        countCell.appendChild(countText);
        row      .appendChild(firstCell);
        firstCell.appendChild(firstInput);
        row      .appendChild(lastCell);
        lastCell .appendChild(lastInput);

        document.getElementById('countField').value = count;
      }

    // ]]>
    </script>
  </head>
    <style>
      
    </style>
  <body class="body">
    <div class="container">
      <h3>SAISIE D'ARTICLE(S)</h3>
        <div class="form">
        <form action="<?= site_url('mainController/showPreList') ?>" method="post">
          <table class="table" id="table">
            <tr>
              <th>Articles</th>
              <th>Code</th>
              <th>Quantite</th>
            </tr>
          

          <script type="text/javascript">
            addRow();
            //sendCount();
          </script>
            <tr>
              <th>
              <input type="hidden" id="countField" value="1" name="count"/>
              </th>
            </tr>
            </table>
          <input class="btn-default" type="button" value="Add" onclick="addRow()" />
          <input class="btn-success" type="submit" value="Submit" />
          
        </form>
        <a href="<?= site_url('mainController/disconnect') ?>">Deconnexion</a>
    </div>
  </div>

  </body>
</html>