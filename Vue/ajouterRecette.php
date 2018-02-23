<!DOCTYPE html>
<html>
    <?php include "head.php"; ?>
    <body>
        <?php include "navbar.php"; ?>
        <br>
        <div class="container-fluid">
            <form class="container" action="Controleur/ajouterRecette.php" method="POST" id="needs-validation" novalidate>
                <div class="row  justify-content-lg-center ">
                    <div class="col-xs-6 col-md-5 col-lg-5">
                        <h4  class="text-center orange">Votre recette</h4>
                        <div class="form-group">
                            <label for="nom_recette">Nom recette</label>
                            <input type="text" class="form-control" id="nom_recette" name="nom_recette" maxlength="80" placeholder="nom de ma recette" required>
                            <div class="invalid-feedback">
                                SVP donnez un nom à votre recette
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url_image">Photo de votre plat</label>
                            <input type="text" class="form-control" id="url_image" name="url_image" placeholder="http://....monImage.jpg" >
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                click droit sur l image copier l' adresse de l'image
                            </small>
                        </div>
                        <div id="categorie">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"  name="type_plat" id="entree" value="entrée"> entree
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="type_plat" id="plat_principal" value="plat principal" > plat principal
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" checked name="type_plat" id="dessert" value="dessert"> dessert
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="type_plat" id="cocktail" value="cocktail" > cocktail
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url_video">Video de la preparation de votre plat </label>
                            <input type="text" class="form-control" id="url_image" id="url_video" name="url_video" placeholder="https://www.youtube.com/watch?v=2dGmuDJMtrI" >
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                tout simplement copier l'url de votre video
                            </small>
                        </div>
                        <label for="preparation">Temps préparation </label>
                        <div class="form-row">
                            <div class="col">
                                <input type="number" min="0" max="60" name="temps_preparation" class="form-control temps preparation " placeholder="10" id="temps_preparation" name="temps_preparation" value="0">
                            </div>
                            <div class="col">
                                <select class="form-control temps preparation  " id="format_preparation" name="format_preparation" >
                                    <option>min</option>
                                    <option>heure</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cuisson">Temps cuisson </label>
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control temps cuisson " id="temps_cuisson" name="temps_cuisson" >
                                        <script type="text/javascript">
                                            for (var i = 0; i < 61; i++) {
                                                if (i == 10) {
                                                    document.write("<option selected>" + i + "</option>");
                                                } else {
                                                    document.write("<option>" + i + "</option>");
                                                }
                                            }
                                        </script>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control temps cuisson " id="format_cuisson" name="format_cuisson" >
                                        <option>min</option>
                                        <option>heure</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_personnes">Nombre de personnes</label>
                            <select class="form-control" id="nombre_personnes" name="nombre_personnes">
                                <script type="text/javascript">
                                    for (var i = 1; i < 100; i++) {
                                        if (i == 6) {
                                            document.write("<option selected>" + i + "</option>");
                                        } else {
                                            document.write("<option>" + i + "</option>");
                                        }
                                    }
                                </script>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-6 col-md-7 col-lg-7">
                        <h4 class="orange text-center">Ingredients</h4>
                        <div id="mesinput" class="form-inline">
                            <div class="ligne">
                                <input type="text" list="ingredients_sugeres" name="ingredients[]" class="form-control ingredients" id="ingredients"   placeholder="ingredients"  required>
                                <input type="number" step="0.001" name="quantite[]" class="form-control quantite" id="quantite" min="0"  placeholder="quantite"  >
                                <input type="text" list="unites_sugeres" name="unites[]" class="form-control unites"  id="unites"  placeholder="unites"  >
                            </div>
                        </div>
                        <br>   
                        <?php 
                            $datalist="<datalist id='ingredients_sugeres'>";
                            $ingredients_sugeres = touts_les_ingredients($bdd);
                            foreach($ingredients_sugeres as $sugere){
                                $datalist.="<option value=".$sugere['nom']." >".$sugere['nom']."</option>";
                            }
                            $datalist.="</datalist>";
                            echo $datalist;
                            $datalist_unites="<datalist id='unites_sugeres'>";
                            $unites_sugeres = touts_les_unites($bdd);
                            foreach($unites_sugeres as $sugere){
                                $datalist_unites.="<option value=".$sugere['unites']." >".$sugere['unites']."</option>";
                            }
                            $datalist_unites.="</datalist>";
                            echo $datalist_unites;
                        ?>
                        <div id="buttonajouter" class="btn-group" role="group" aria-label="ingredients">
                            <button type="button" class="btn btn-primary" id="ajouter">Ajouter Ingredient</button>
                            <button type="button" class="btn btn-default" id="suprimer">Suprimer Ingredient</button>
                        </div><br/><br/>
                        <div class="form-group">
                            <label for="preparation">Entrez votre recette, vous pouvez la séparer avec le mot clée  &#171; ETAPE &#187; Attention ne pas mettre ETAPE en debut de paragraphe</label>
                            <textarea class="form-control" id="etape" name="etape"  rows="10">
Votre texte ici 
ETAPE
Votre texte ici
ETAPE
votre texte ici 	
                            </textarea>
                        </div>
                        <small id="helpEtapes" class="form-text text-muted">
                            Vous pouvez ajouter autant d'étapes que vous le souhaitez à l'aide du mot clée &#171; ETAPE &#187; 
                        </small>
                    </div>	
                </div>
                <button class="btn btn-primary"  type="submit">ajouter votre recette</button>
                <br><br>
            </form>
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger alert-dismissible fade hide" role="alert">
                        <strong>Information!</strong> Touts les les champs doivent être remplis
                        à l'exception de l'url image.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            document.getElementById("ajouter").addEventListener('click', ajouter, false);
            document.getElementById("suprimer").addEventListener('click', suprimer, false);

            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    var form = document.getElementById('needs-validation');
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                            $(".alert").removeClass("hide");
                            $(".alert").addClass("show");
                        } else {
                            $(".alert").removeClass("show");
                            $(".alert").addClass("hide");
                            event.preventDefault();
                            //$(".container-fluid").html("<div class=\"loading\"></div>");
                            console.log($('#needs-validation').serializeArray());
                                    $.ajax( {
                                    type: "POST",
                                    url: $('#needs-validation').attr( 'action' ),
                                    data:$('#needs-validation').serialize(),
                                    beforeSend : function (){
                                        $(".container-fluid").html("<div class=\"loading\"></div>");
                                    },
                                    success: function( response ) {
                                        $(".container-fluid").html("");
                                        var chaine  = response;
                                        var pattern = /error/i;
                                        if( pattern.test(chaine) ){
                                        $(".container-fluid").html("<div class='row justify-content-md-center'><div class='col-md-auto'><div class='alert alert-danger' role='alert'><h1 class='alert-heading' >ATTENTION </h1>"+response+"</div></div></div> ");
                                        } else {
                                        $(".container-fluid").html("<div class='row justify-content-md-center'><div class='col-md-auto'><div class='alert alert-success' role='alert'><h1 class='alert-heading' >SUCCESS </h1>"+response+"</div></div></div> ");
                                        }
                                      
                                      
                                    }
                                  });
                        }
                        form.classList.add('was-validated');
                        return false;
                    }, false);
                }, false);


                        document.getElementById("needs-validation").addEventListener('change', function () {
                            var platcheck = document.getElementById("plat_principal").checked;
                            var dessertcheck = document.getElementById("dessert").checked;
                            var entreecheck = document.getElementById("entree").checked;
                            var cocktailcheck = document.getElementById("cocktail").checked;
                            if (cocktailcheck == true) {
                                var temps = document.getElementsByClassName("temps");
                                platcheck = false;
                                dessertcheck = false;
                                entreecheck = false;
                                for (var i = 0; i < temps.length; i++) {
                                    temps[i].classList.add("disabled");
                                    temps[i].disabled = true;
                                }
                                var preparation = document.getElementsByClassName("preparation");
                                for (var i = 0; i < preparation.length; i++) {
                                    preparation[i].classList.remove("disabled");
                                    preparation [i].disabled = false;
                                }
                            } else if (platcheck == true || dessertcheck == true) {
                                var temps = document.getElementsByClassName("temps");
                                cocktailcheck = false;
                                entreecheck = false;
                                dessertcheck = false;
                                for (var i = 0; i < temps.length; i++) {
                                    temps[i].classList.remove("disabled");
                                    temps[i].disabled = false;
                                }
                            } else if (entreecheck == true) {
                                console.log("entree:" + entreecheck);
                                platcheck = false;
                                cocktailcheck = false;
                                dessertcheck = false;
                                var temps = document.getElementsByClassName("temps");
                                for (var i = 0; i < temps.length; i++) {
                                    temps[i].classList.remove("disabled");
                                    temps[i].disabled = false;
                                }
                                var temps1 = document.getElementsByClassName("preparation");

                                for (var i = 0; i < temps1.length; i++) {
                                    temps1[i].classList.remove("disabled");
                                    temps1[i].disabled = false;
                                }
                                var temps2 = document.getElementsByClassName("cuisson");

                                for (var i = 0; i < temps2.length; i++) {
                                    temps[i].classList.remove("disabled");
                                    temps[i].disabled = false;
                                }
                            }

                        }, false);
                    })();
        </script>
        <?php include 'footer.php'; ?>
    </body>
</html>