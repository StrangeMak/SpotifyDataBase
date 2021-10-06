<?php
    include 'function.php';
    $SERVER = "localhost";            
    $USER   = "user";                 
    $MDP    = "mdp";                  
    $BD     = "spotify";
    $FileBD = "Spotify-2000.csv";

    //Création de l'objet DataBase
    $myDataBase = new DataBase($SERVER, $USER, $MDP, $BD, $FileBD);

    //Connexion à la base de donnée
    $myDataBase->ConnectDataBase();
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
		rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Classement musiques Spotify</title>
  </head>
  <body style="background-color: #f4efe7">
  <div class="container">
    <div class="row mb-3">
      <nav class="navbar py-0 navbar-expand-lg fixed-top navbar-dark" style="background-color: black;">
        <a class="navbar-brand" href="classementMusiques.php">
          <img src="images/Spotify.jpg" width="95" height="54" alt="Info Logo" />
        </a>
        <span class="navbar-text ms-3" style="color: white; font-weight: bold; font-size: 1em;"> Meilleures musiques Spotify </span>
        <ul class="nav me-5">
          <li class="nav-item ms-2">
            <a class="nav-link text-white" href="index.php">Accueil</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control ms-5 me-2" name="type" id="type" placeholder="Rechercher sur la base" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Recherche</button>
        </form>
      </nav>
    </div>
  </div>
  
<?php
    //recuperationData();
    if (isset($_GET["type"])){
      if (isset($_GET["tri"])){
        $myDataBase->trieData($_GET["tri"],$_GET["type"],$_GET["order"]);
      }
      else {$myDataBase->rechercher($_GET["type"]);}
    }
    else if (isset($_GET["tri"])){
      $myDataBase->trieData($_GET["tri"],"",$_GET["order"]);
    }
    else $myDataBase->affichageData();
?>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
