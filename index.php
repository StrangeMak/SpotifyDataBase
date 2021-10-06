<?php
    include 'function.php';
    $SERVER = "localhost";            
    $USER   = "user";                 
    $MDP    = "mdp";                  
    $BD     = "spotify";
    $FileBD = "Spotify-2000.csv";

    $myDataBase = new DataBase($SERVER, $USER, $MDP, $BD, $FileBD);

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
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: black;">
          <a class="navbar-brand" href="classementMusiques.php">
            <img src="images/Spotify.jpg" width="95" height="54" alt="Info Logo" />
          </a>
          <span class="navbar-text ms-3" style="color: white; font-weight: bold; font-size: 1em;"> Meilleures musiques Spotify </span>
          <ul class="nav justify-content-center">
            <li class="nav-item ms-2">
              <a class="nav-link text-white" href="index.php">Accueil</a>
            </li>
          </ul>
      </div>
    </div>
    <br><br>
    <div class="container">
      <div class="row mt-5">
        <div class="col-sm-6 mt-5">
          <div class="card text-center">
            <div class="row g-0">
              <div class="col-md-4 p-4">
                <img src="images/listening.png" alt="music is fun" class="card-img-top">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Classement de toutes les musiques de Spotify</h5>
                  <p class="card-text">Vous ne savez pas où chercher? Pourquoi choisir, cherchez sur toute la base.</p>
                  <a href="classementMusiques.php?" class="btn btn-dark">Allez voir!</a>
                </div>
              </div>
            </div>  
          </div>
        </div>
      
        <div class="col-sm-6 mt-5">
          <div class="card text-center">
            <div class="row g-0">
              <div class="col-md-4 p-4">
                <img src="images/cd.png" alt="love france" class="card-img-top">
              </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Classement de toutes les musiques pop sur Spotify</h5>
                <p class="card-text">Vous êtes un adepte féru des musiques pop? Cette recherche va vous convenir.</p>
                <a href="classementMusiques.php?type=pop" class="btn btn-dark">Allez voir!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
