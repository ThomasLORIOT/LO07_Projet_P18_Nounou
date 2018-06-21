<!--
    Page dde formulaire pour devenir parents avec en plus l'ajout des enfants
    Ne fonctionne malheureusement pasd

-->
<html>
    <head>
        <title>Parents - Formulaire</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../include/bootstrap/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!--load jquery avant js -->
        <script src="../include/bootstrap/js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="../Functions/Functions_JS.js"></script>
        <?php 
            include '../Functions/Functions_Formulaires.php'; 
            include '../Functions/Functions.php'; 
            $method = "post";
            $action="";
            if(!empty($_POST)){
                echo ("<pre>");
                print_r($_POST);
                echo ("</pre>");
            }
        ?>
    </head>
    <body>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="home.php">Parents</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href = 'deconnexion.php'">Déconnexion</button>
            </div>
        </nav>
        <div class="container">
            <h1 class="text-center">Inscription Parent</h1>
            <div class="block-center">
                <?php            
                    //formulaire
                    debutForm($method,$action, 'onsubmit="return verifFormParents(this)"');
                    formInput('Ville ','text','ville','onblur="verif(this)"');
                    formInput('Date de naissance', 'date', 'date[]', 'onblur="verif(this)"');
                    textArea('info',"Avez-vous des éléments importants pour l'organisation",'5','60','onblur="verifTextArea(this)" ');
                    formSelect('nbEnfants',"Combien d'enfant avez vous ?", array(1,2,3,4,5,6,7,8,9,10), 'onchange="ajouteEnfant(this)"');
                ?>
                <div  id='enfants'>                    
                    <div id=0 class='form-check'>
                        <legend  class="label-control" value="Enfant">Enfant</legend>
                        <?php
                           formInput('Nom', 'text', 'nom[]', 'onblur="verif(this)"');
                           formInput('Date de naissance', 'date', 'date[]', 'onblur="verif(this)"');
                           textArea('restrictions[]',"L'enfant à t'il des restrictions alimentaires ?",'5','60','onblur="verifTextArea(this,0)" ');
                        ?>                        
                    </div>
                </div>
                <script type="text/javascript" >
                        var count=0;
                        var div = document.getElementById('enfants');
                        var field=document.getElementById('0'); 
                        function ajout(){
                            count++;
                            clone=field.cloneNode(field);
                            clone.id=count;
                            clone.children[2].id='nom[${count}]';
                            clone.children[3].id='date[${count}]';
                            clone.children[4].id='restrictions[${count}]';
                            div.appendChild(clone);                               
                        }
                        function enlever(){
                            if(count>0){
                                div.removeChild(div.children[count]);
                                count--;
                            }
                        }
                </script>                    
                <div class="text-center">
                    <input type="button" onclick="ajout()" class='btn btn-default' value="Ajouter un champ enfant"/>
                    <input type="button" onclick="enlever()" class='btn btn-default' value="Enlever le champ enfant"/>
                </div>
                
                <?php
                    formAddSubmitReset();
                    finForm();
                ?>
            </div>
        </div>                
    </body>

</html>