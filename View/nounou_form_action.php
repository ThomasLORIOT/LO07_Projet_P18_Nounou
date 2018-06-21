<?php
// action du formulaire pour devenir nounou

session_start();
include '../Objets/Nounou.php';
include '../Objets/Utilisateur.php';
$user = new Utilisateur($_SESSION['idUtilisateur']);

if (isset($_POST)) {
    // inscription d'une nounou 
    //récupération des données du POST et vérification des valeurs 
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($value);
    }
    //création de nounou
    $newNounou = new Nounou($_POST['prenom'], $_POST['telephone'], $_POST['age'], $_POST['presentation'], $_POST['experience']);
    $verif = $newNounou->addDB();
    //si la nounou est bien ajouté
    //print_r($verif);
    if ($verif) {
        //récupération de l'id et ajout de celui ci dans utilisateur
        $user = new Utilisateur($_SESSION['idUtilisateur']);
        $user->setIdNounous($newNounou->getIdNounous());
        $user->updateDB();
        $_SESSION['nounouOUparents'] = 'nounou';
        header('Location: home.php');
        exit();
    }
}
//redirection vers la page welcome en cas de problème
header('Location: welcome.php?pb=1');

?>