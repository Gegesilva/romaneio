<?php
    header('Content-type: text/html; charset=ISO-8895-1');
?> 

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="90" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleExibicao.css">

    <title>DATABIT</title>
  </head>

<style>

body{
  height: 150px;
  overflow: hidden; /* Hide scrollbars */
  background-image: url(https://i.ibb.co/0VZRMHx/databitoriginal-escura.jpg);
  background-size: cover;
}
.container {
    height: 490px;
    overflow-y: scroll;
 }
.divcentral{
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: honeydew;
  margin-top: 20%;
  margin-bottom: 10px;
  margin-left: auto;
  margin-right: auto;
  border-radius: 20px;
  width: 60%;
  height: 60%;
}
.inputcod{
  border-radius: 20px;
  margin-bottom: 5px;
}

</style>
</body>


<!-- example 2 - using auto margins -->
  <nav class="divcentral">
          <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                  </li>
              </ul>
          </div>
            <img src="media/logo.png" width="115" height="34" style="margin-left: 10px; border-radius: 20px;"  class="d-inline-block align-top" alt="">
          <div class="mx-auto order-0">
              <a class="navbar-brand mx-auto" href="#"> <b>TERMO DE INSTALAÇÃO/SUBS</b>
                    
                    <div class="divBtn">
                    <form method="post" action="ImpresExec_SUBS.php">

                        <input class="inputcod" type="text" name="cod" autofocus="true">
                         <input class="btnInserir" type="submit" value="Gerar">
                        <!-- <button id="btn">Imprimir</button> -->
                      </form>
                      <form action="gerencial.php">
                        <input class="voltar-fil" type="submit" value="Voltar">
                      </form>
                    </div>  
              </a>
        
          </div>
          <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        </div>
      </div>
    </div>
</body>
</html>
