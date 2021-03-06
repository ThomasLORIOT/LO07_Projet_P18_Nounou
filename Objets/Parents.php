<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parents
 *
 * @author Thomas
 */
require_once '../Functions/Functions_SQL.php';
require_once 'Enfants.php';
require_once 'Garde.php';
require_once 'debug.php';

class Parents {

    private $idParents;
    private $Ville;
    private $InformationsGénérales;

    function getIdParents() {
        return $this->idParents;
    }

    function setIdParents($idParents) {
        $this->idParents = $idParents;
    }

    function getVille() {
        return $this->Ville;
    }

    function getInformationsGénérales() {
        return $this->InformationsGénérales;
    }

    function setVille($Ville) {
        $this->Ville = $Ville;
    }

    function setInformationsGénérales($InformationsGénérales) {
        $this->InformationsGénérales = $InformationsGénérales;
    }

    function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 2:
                self::__construct1($argv[0], $argv[1]);
                break;
            case 1:
                self::__construct2($argv[0]);
                break;
        }
    }

    function __construct1($Ville, $InformationsGénérales) {
        $this->Ville = $Ville;
        $this->InformationsGénérales = $InformationsGénérales;
    }

    function __construct2($idParents) {
        $myDB = connectDB();
        $result = $myDB->query("SELECT * FROM parents WHERE idParents = '$idParents'");
        if ($result->num_rows == 0) {
            echo "<script>console.log('connait pas ce parents');</script>";
        } else {
            $row = mysqli_fetch_assoc($result);
            $this->idParents = $idParents;
            $this->Ville = $row['Ville'];
            $this->InformationsGénérales = $row['Informations Générales'];
        }
    }

    function __toString() {
        return "Parent($this->idParents;$this->Ville;$this->InformationsGénérales)<br>\n";
    }

    //ajout d'un parent dans la base + recupération de l'ID
    function addDB() {
        $result = FALSE;
        $requete = "INSERT INTO parents(Ville, `Informations Générales`) VALUES ('$this->Ville','$this->InformationsGénérales') ";
        $myDB = connectDB();
        $res = mysqli_query($myDB, $requete);
        echo "<script>console.log('requete : $requete');</script><br>\n";
        if ($res) {
            echo "<script>console.log('requête bien effectuée');</script><br>\n";
            $result = TRUE;
            //ajoute l'id crée par DB à l'objet
            $requete2 = "SELECT MAX(idParents)AS idParents FROM parents WHERE Ville = '$this->Ville' AND `Informations Générales` = '$this->InformationsGénérales'";
            $res2 = $myDB->query($requete2);
            $id = mysqli_fetch_assoc($res2);
            $this->setIdParents($id['idParents']);
        } else {
            $erreur = mysqli_error($myDB);
            echo "<script>console.log('erreur : $erreur');</script><br>\n";
        }
        mysqli_close($myDB);
        return $result;
    }

    function updateDB() {
        $requete = "UPDATE parents SET Ville='$this->Ville', `Informations Générales`='$this->InformationsGénérales' WHERE idParents = '$this->idParents'";
        requete($requete);
    }

    function addEnfant($Prénom, $DateDeNaissance, $Restrictions) {
        $enfant = new Enfants($Prénom, $DateDeNaissance, $Restrictions, $this->idParents);
        $enfant->addDB();
    }

    //return liste des id de ses enfants
    function getEnfant() {
        $requete = "SELECT idEnfants FROM enfants WHERE idParents=$this->idParents";
        $row = fetchAllRequete($requete);
        return $row;
    }

    function addEnfantGarde($idEnfant, $idNounous, $idHoraires) {
        $requete = "INSERT INTO enfants_gardé VALUES ($idEnfant, $idNounous, $idHoraires)";
        requete($requete);
    }

    function getGardeFaite() {
        $enfants = $this->getEnfant();
        $listeGarde = Array();
        foreach ($enfants as $value) {
            $requete = "SELECT idNounous, idHoraires FROM enfants_gardé NATURAL JOIN horaires WHERE enfants.idEnfants = $value->Enfants->getIdEnfants() AND Date < CURRENT_DATE() ORDER BY Date";
            $row = fetchRowRequete($requete);
            $i = 0;
            while (isset($row[i])){
                $listeGarde[] = new Garde($row[$i], $row[($i+1)]);
                $i = $i + 2;
            }
        }
        return $listeGarde;
    }

}
//$test = new Parents(1);
//echo($test);
//$listeGarde = $test->getEnfant();
//debug($listeGarde);
//foreach ($listeGarde as $value) {
//    echo($value);
//}