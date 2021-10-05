<?php

//Fonction qui permet de se connexionecter à la base de données
function ConnectDataBase($server, $user, $mdp, $db) 
{
    $connexion = mysqli_connect($server, $user, $mdp, $db); // serveur, login, mdp, bd
    if (mysqli_connect_errno()) {
        exit();
    }
    mysqli_query($connexion,'SET NAMES UTF8'); // conversion chaines en UTF8 (si problème affichage)
    return $connexion;
}


function recuperationData()
{
    global $connexion;
    $filename = "Spotify-2000.csv";
    $file = fopen($filename, "r");
    fgets($file);
    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

        $sqlInsert = "INSERT into musiques (Id,Title,Artist,TopGenre,Year,BPM,Energy,Danceability,Loudness,
                Liveness,Valence,Length,Acousticness,Speechiness,Popularity)
                values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] ."','" .
                 $column[5] ."','" . $column[6] ."','" . $column[7] ."','" . $column[8] ."','" . $column[9] ."','" . $column[10] ."','" .
                  $column[11] ."','" . $column[12] ."','" . $column[13] ."','" . $column[14] . "')"; 

        $result = mysqli_query($connexion, $sqlInsert);        
                    
        if (! empty($result)) {
            $type = "success";
            $message = "CSV Data Imported into the Database";
        } else {
            $type = "error";
            $message = "Problem in Importing CSV Data";
        }
    }
}

function trieData($colonne, $searchText = "", $order = "up")
{
    global $connexion;
    if (!$connexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if ($searchText != "" and $order == "up"){
        $sql = 'SELECT * FROM musiques WHERE TopGenre LIKE "%'.$searchText.'%" ORDER BY '.$colonne.' Asc limit 200';
    }
    else if ($searchText != "" and $order == "down"){
        $sql = 'SELECT * FROM musiques WHERE TopGenre LIKE "%'.$searchText.'%" ORDER BY '.$colonne.' Desc limit 200';
    }
    else if ($searchText == "" and $order == "up"){
        $sql = "SELECT * FROM musiques ORDER BY $colonne Asc limit 200";
    }
    else {
        $sql = "SELECT * FROM musiques ORDER BY $colonne Desc limit 200";
    }
    affichageData($sql, $searchText, $order);
    $connexion->close();
}

function rechercher($searchText){
    global $connexion;
    if (!$connexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = 'SELECT * FROM musiques WHERE TopGenre LIKE "%'.$searchText.'%" limit 200';
    affichageData($sql, $searchText);
    $connexion->close();
}

function affichageData($query = "SELECT * from musiques limit 200", $searchText = "", $order = ""){
    
    global $connexion;
    echo $searchText;
    $result = mysqli_query($connexion, $query);
    $all_property = array();
    echo '<br><br>';
    $html = '';
	$html .= '<div class="container-fluid">
                    <div class="row">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>';
    while ($property = mysqli_fetch_field($result)){
        if ($searchText != "" and isset($_GET["tri"]) and $_GET["tri"]==$property->name and $order=="up"){
            $html .= '<td style="cursor: pointer" onclick="location.href=\'classementMusiques.php?tri='.$property->name.'&type='.$searchText.'&order=down\'">' . $property->name . '</td>';
        }
        else if ($searchText != "" and isset($_GET["tri"]) and $_GET["tri"]==$property->name and $order=="down"){
            $html .= '<td style="cursor: pointer" onclick="location.href=\'classementMusiques.php?tri='.$property->name.'&type='.$searchText.'&order=up\'">' . $property->name . '</td>';
        }
        else if ($searchText != ""){
            $html .= '<td style="cursor: pointer" onclick="location.href=\'classementMusiques.php?tri='.$property->name.'&type='.$searchText.'&order=up\'">' . $property->name . '</td>';
        }
        else if ($searchText == "" and isset($_GET["tri"]) and $_GET["tri"]==$property->name and $order=="up"){
            $html .= '<td style="cursor: pointer" onclick="location.href=\'classementMusiques.php?tri='.$property->name.'&order=down\'">' . $property->name . '</td>';
        }
        else $html .= '<td style="cursor: pointer" onclick="location.href=\'classementMusiques.php?tri='.$property->name.'&order=up\'">' . $property->name . '</td>';  
        array_Push($all_property, $property->name); 
    }
    $html .= '</tr>
            </thead>
            <tbody>';
    while ($row = mysqli_fetch_array($result)) {
        $html .= "<tr>";
        foreach ($all_property as $item) {
            $html .= '<td>' . $row[$item] . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '	</tbody>
			 </table>
             </div>
             </div>';

    echo $html;
}


?>
