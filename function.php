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

function trieData($colonne)
{
    global $connexion;
    if (!$connexion) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM musiques ORDER BY $colonne Asc limit 100";
    affichageData($sql);
    $connexion->close();
}

function rechercher($searchText){
    global $connexion;
    if (!$connexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM musiques WHERE  Asc limit 100";
}

function affichageData($query = "SELECT * from musiques limit 100"){
    
    global $connexion;
    $result = mysqli_query($connexion, $query);
    $all_property = array();

    $html = '';
	$html .= '<table class="table table-bordered table-striped table-hover">
				<thead class="table-dark">
					<tr>';
    while ($property = mysqli_fetch_field($result)){
        $html .= '<td style="cursor: pointer" onclick="location.href=\'classementMusiques.php?tri='.$property->name.'\'">' . $property->name . '</td>';  
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
			 </table>';

    echo $html;
}


?>
