<?php

class DataBase
{
    private $_connexion;    //comme un cookie, sert à garder une connexion à la base de données
    private $_nomServeur;   
    private $_nomUser;
    private $_mdpUser;
    private $_nomTableData;
    private $_nomFichierDataBase;   //Nom du ficher .csv pour récupérer les données d'une base de données

    function __construct($nomServeur, $nomUser, $mdpUser, $nomTableData, $nomFichierDataBase)
    //Pour construire un objet DataBase
    {
        $this->_nomServeur = $nomServeur;
        $this->_nomUser = $nomUser;
        $this->_mdpUser = $mdpUser;
        $this->_nomTableData = $nomTableData;
        $this->_nomFichierDataBase = $nomFichierDataBase;
    }

    public function ConnectDataBase()
    //Pour se connecter à la base de donnée, on a besoin du nom du serveur (localhost si local), du nom d'utilisateur, mot de passe et nom de table
    {
        $this->_connexion = mysqli_connect($this->_nomServeur, $this->_nomUser, $this->_mdpUser, $this->_nomTableData); // serveur, login, mdp, bd
        if (mysqli_connect_errno()) {
            exit();
        }
        mysqli_query($this->_connexion,'SET NAMES UTF8'); // conversion chaines en UTF8 (si problème affichage)
    }

    public function nomFichierDataBase($value = "")
    //Un accesseur/Getteur pour modifier ou accéder au nom de fichier .csv de la base de données.
    {
        if ($value == "")
        {
            return $this->_nomFichierDataBase;
        }

        $this->_nomFichierDataBase  = $value;
    }

    public function recuperationData()
    //Fonction pour récupérer les datas d'une database
    {
        $file = fopen($this->_nomFichierDataBase, "r"); //On ouvre le fichier
        fgets($file); //On saute une ligne pour accéder directement aux données
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) 
        //While pour mettre chaque ligne du fichier dans la base de données en séparant les données par des virgules
        {

            $sqlInsert = "INSERT into musiques (Id,Title,Artist,TopGenre,Year,BPM,Energy,Danceability,Loudness,
                    Liveness,Valence,Length,Acousticness,Speechiness,Popularity)
                    values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] ."','" .
                    $column[5] ."','" . $column[6] ."','" . $column[7] ."','" . $column[8] ."','" . $column[9] ."','" . $column[10] ."','" .
                    $column[11] ."','" . $column[12] ."','" . $column[13] ."','" . $column[14] . "')"; 
            
            //On écrit la requête et on l'envoie au serveur avec la fonction suivante
            
            $result = mysqli_query($this->_connexion, $sqlInsert);        
            
            //Pour traiter les erreurs
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }

    public function trieData($colonne, $searchText = "", $order = "up")
    //Fonction pour trier les données et afficher les résultats dans l'ordre croissant ou décroissant
    {
        if ($searchText != "" and $order == "up"){
            $sql = 'SELECT * FROM musiques WHERE TopGenre LIKE "%'.$searchText.'%" OR Artist LIKE "%'.$searchText.'%" OR Title LIKE "%'.$searchText.'%" ORDER BY '.$colonne.' Asc limit 200';
        }
        else if ($searchText != "" and $order == "down"){
            $sql = 'SELECT * FROM musiques WHERE TopGenre LIKE "%'.$searchText.'%" OR Artist LIKE "%'.$searchText.'%" OR Title LIKE "%'.$searchText.'%" ORDER BY '.$colonne.' Desc limit 200';
        }
        else if ($searchText == "" and $order == "up"){
            $sql = "SELECT * FROM musiques ORDER BY $colonne Asc limit 200";
        }
        else {
            $sql = "SELECT * FROM musiques ORDER BY $colonne Desc limit 200";
        }
        //On récupère la bonne requête en fonction des données en paramètres puis on l'envoie à la fonction suivante
        $this->affichageData($sql, $searchText, $order);
    }

    public function rechercher($searchText){
        //Fonction pour rechercher avec la barre de recherche
        $sql = 'SELECT * FROM musiques WHERE TopGenre LIKE "%'.$searchText.'%" OR Artist LIKE "%'.$searchText.'%" OR Title LIKE "%'.$searchText.'%" limit 200';
        $this->affichageData($sql, $searchText);
    }
    
    public function affichageData($query = "SELECT * from musiques limit 200", $searchText = "", $order = "")
    //Fonction la plus importante qui affiche la table de résultat et envoie la requête à la base en récupérant 
    //dans une variable tous les résultats. Selon les données de la requête GET précédente, on va donner un lien différent
    //sur les colonnes du tableau pour par exemple trier par colonne tout en gardant un mot de recherche.
    {
        //envoie de la requête au serveur
        $result = mysqli_query($this->_connexion, $query);
        $all_property = array();
        echo '<br><br>';
        //html va concaténer tous les chaines de caractères en html pour les afficher à la fin de la fonction
        $html = '';
        $html .= '<div class="container-fluid">
                        <div class="row">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>';
        while ($property = mysqli_fetch_field($result)){
            //while pour afficher les titres des colonnes et leur associer un lien cliquable
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
            //while pour afficher chaque donnée dans chaque cellule du tableau
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
}


?>
