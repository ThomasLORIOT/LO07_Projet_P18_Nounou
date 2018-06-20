<?php
session_start();
require_once '../Objets/Utilisateur.php';
require_once '../Objets/Nounou.php';
require_once '../Functions/Functions_Formulaires.php';
require_once '../Functions/Functions.php';
$user = $_SESSION['idUtilisateur'];
$user = new Utilisateur($_SESSION['idUtilisateur']);
$nounou = new Nounou($user->getIdNounous());
?>

<!DOCTYPE html>
<!--
    Page home
    

-->
<html>
    <head>
        <title>Ajout garde</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../include/bootstrap/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!--load jquery avant js -->
        <script src="../include/bootstrap/js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="../Functions/Functions_JS.js"></script>
        <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
        <script>
            webshims.setOptions('forms-ext', {types: 'date'});
            webshims.polyfill('forms forms-ext');
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="home.php"><?php echo(ucfirst($_SESSION['nounouOUparents'])) ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href = 'deconnexion.php'">Déconnexion</button>
            </div>
        </nav>

        <div class="container-fluid text-center">
            <div class="row">
                <div class="col-sm-2">
                    <hr>
                    <button class="btn btn-dark" onclick="location.href = 'choix.php'">Retour</button>
                </div>
                <div class="col-sm-8 text-left">
                    <h1>Ajouter une garde</h1>
                    <?php
                    $message = "<h4>La garde à bien été ajoutée.</h4><br> Les parents intéressés pourront choisir votre garde et ajouter leurs enfants.";
                    message5Secondes($message, 'ajout');
                    $non = "La garde n'a pas pu être ajoutée, vérifiez si vous avez correctement remplie le formulaire";
                    message5Secondes($non, 'non');
                    $vide = "Formulaire non rempli entièrement";
                    message5Secondes($vide, 'vide');
                    //formulaire
                    debutForm("POST", "ajout_garde_action.php");
                    formInput('Date', 'date', 'date');
                    $heureDispo = array();
                    for ($i = 0; $i <= 24; $i++) {
                        $heureDispo[] = "$i:00:00";
                    }
                    formSelect('heureDébut', 'Heure de début', $heureDispo);
                    formSelect('heureFin', 'Heure de fin', $heureDispo);
                    echo("<label>Avec langue étrangère : oui</label>");
                    Radio('langue', '1');
                    echo("non");
                    Radio('langue', '0');
                    echo("<br>");
                    formInput("Nombre d'enfants au maximum", 'number', 'enfantsMax', "min='1' value='1'");
                    formAddSubmitReset();
                    finForm();
                    ?>
                </div>
            </div>
        </div>

        <footer class="page-footer font-small stylish-color-dark pt-4 mt-4">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2018 Copyright : Créé par Thomas Loriot et Vladimir Trois
            </div>
            <!-- Copyright -->
        </footer>

    </body>
</html>
