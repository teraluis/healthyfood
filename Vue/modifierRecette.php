<!DOCTYPE html>
<html>
    <?php include "head.php"; ?>
    
    <body>
        <?php include "navbar.php"; ?>
        <br>
        
        <div  class="container-fluid">
            
            <form recette="<?= $id ?>" class="container" method="POST" action="Controleur/modifierRecette.php" id="needs-validation" novalidate>
                <div class="row  justify-content-lg-center ">
                    <div class="col-xs-6 col-md-5 col-lg-5">
                        <h4  class="text-center orange">Votre recette</h4>

                        <div class="form-group">
                            <label for="nom_recette">Nom recette</label>
                            <input type="text" class="form-control" id="nom_recette" name="nom_recette" maxlength="80" value="<?= $tab_recette['recette']['nom'] ?>" required>
                            <div class="invalid-feedback">
                                SVP donnez un nom à votre recette
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url_image">Photo de votre plat</label>
                            <input type="text" class="form-control" id="url_image" name="url_image" value="<?= $tab_recette['recette']['url_image'] ?>" >
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                click droit sur l image copier l' adresse de l'image
                            </small>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" <?php if ($tab_recette['recette']['categorie'] == "entrée") {
            echo "checked";
        } ?> name="type_plat" id="entree" value="entrée"> entree
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" <?php if ($tab_recette['recette']['categorie'] == "plat principal") {
            echo "checked";
        } ?> name="type_plat" id="plat_principal" value="plat principal" > plat principal
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" <?php if ($tab_recette['recette']['categorie'] == "dessert") {
            echo "checked";
        } ?> type="radio" name="type_plat" id="dessert" value="dessert"> dessert
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="type_plat" <?php if ($tab_recette['recette']['categorie'] == "cocktail") {
                                echo "checked"; } ?> id="cocktail" value="cocktail" > cocktail
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="url_video">Video de la preparation de votre plat </label>
                            <input type="text" class="form-control" id="url_image" id="url_video" name="url_video" placeholder="<?php $tab_recette['recette']['url_video']; ?>" >
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                tout simplement copier l'url de votre video
                            </small>
                        </div>
                        <label for="preparation">Temps préparation </label>
                        <div class="form-row">
                            <div class="col">
                                <input type="number" min="0" max="60" class="form-control temps preparation " value="<?= $tab_recette['recette']['tpreparation']; ?>" id="temps_preparation" name="temps_preparation" >
                            </div>
                            <div class="col">
                                <select class="form-control temps preparation  " id="format_preparation" name="format_preparation" >
                                    <option <?php if ($tab_recette['recette']['preparation_unites'] == "min") {
            echo "selected";
        } ?>>min</option>
                                    <option <?php if ($tab_recette['recette']['preparation_unites'] == "heure") {
            echo "selected";
        } ?>>heure</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cuisson">Temps cuisson </label>
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control temps cuisson " id="temps_cuisson" name="temps_cuisson" >
<?php
for ($i = 0; $i < 61; $i++) {
    if ($i == $tab_recette['recette']['cuisson']) {
        echo "<option selected>" . $i . "</option>";
    } else {
        echo "<option>" . $i . "</option>";
    }
}
?>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control temps cuisson " id="format_cuisson" name="format_cuisson" >
                                        <option <?php if ($tab_recette['recette']['cuisson_unites'] == "min") {
    echo "selected";
} ?>>min</option>
                                        <option <?php if ($tab_recette['recette']['cuisson_unites'] == "heure") {
                                    echo "selected";
                                } ?>>heure</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nombre_personnes">Nombre de personnes</label>
                            <select class="form-control" id="nombre_personnes" name="nombre_personnes">
<?php
for ($i = 1; $i < 100; $i++) {
    if ($i == $tab_recette['recette']['nbpersonnes']) {
        echo "<option selected>" . $i . "</option>";
    } else {
        echo "<option>" . $i . "</option>";
    }
}
?>
                            </select>
                        </div>

                    </div>

                    <div class="col-xs-6 col-md-7 col-lg-7">
                        <h4 class="orange text-center">Ingredients à modifier ou à supprimer</h4>
                        <small id="suppIngMessage" class="form-text text-muted">
                            pour supprimer un ingredient cochez la casse grisse correspondante
                        </small>
<?php
foreach ($tab_recette['ingredients'] as $ing) {
    ?>
                            <div class="row">
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" data-toggle="tooltip" data-placement="top" title="supprimer" name="supprimer[]" value="<?= $ing['id'] ?>" aria-label="<?= $ing['nom_ingredient'] ?>" >
                                        </span>
                                        <input type="text" <?php echo "list='ingredients_sugeres'" ?> class="form-control" idingredient="<?= $ing['id'] ?>" name="ingredients[]"  aria-label="Ingredient à suprimer" value="<?= $ing['nom_ingredient'] ?>">
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <input type="number" min="0" step="0.01" class="form-control" name="quantite[]" data-toggle="tooltip" data-placement="top" title="utilisez des points"  value="<?= $ing['quantite'] ?>">
                                        <div class="invalid-feedback">
                                            point si décimaux
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xs-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" <?php echo "list='unites_sugeres'" ?> class="form-control" name="unites[]"  value="<?= $ing['unites'] ?>" >
                                    </div>
                                </div>
                            </div>
    <?php
}
?>
                        <div class="row">
                            <div class="col-xs-12 col-md-12 col-lg-12">
                                <h4 class="orange text-center">Ingredients à ajouter</h4>
                                <div id="mesinput" class="form-inline">

                                </div><br>

                                <div id="buttonajouter" class="btn-group" role="group" aria-label="ingredients" onsubmit="javascript:verifier()">
                                    <button type="button" class="btn btn-primary" onclick="ajouter()">Ajouter Ingredient</button>
                                    <button type="button" class="btn btn-default" onclick="suprimer()">Suprimer Ingredient</button>
                                </div><br/><br/>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="preparation">Entrez votre recette, vous pouvez la séparer avec le mot clée  &#171; ETAPE &#187;</label>
                            <textarea class="form-control" id="etape" name="etape"  rows="10"><?= $tab_recette['recette']['preparation']; ?>	
                            </textarea>
                        </div>
                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Vous pouvez ajouter autant d'étapes que vous le souhaitez à l'aide du mot clée &#171; ETAPE &#187;
                        </small>
                    </div>	
                </div>
                
                <button  class="btn btn-primary" type="submit">modifiez votre recette</button>
                <div id="chargement_bleu" ></div>
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
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

        </script>
        <script type="text/javascript">
                    (function () {
                        'use strict';
                        window.addEventListener('load', function () {
                            var form = document.getElementById('needs-validation');
                            var recette_id = form.getAttribute("recette");
                            console.log(recette_id);
                            console.log(form.checkValidity());
                            event.preventDefault();
                            form.addEventListener('submit', function (event) {
                                event.preventDefault();
                                var chargement_bleu=document.getElementById("chargement_bleu");
                                if (form.checkValidity() === false) {
                                    $(".container-fluid").html("<div class='row justify-content-md-center'><div class='col-md-auto'><div class='alert alert-danger' role='alert'><h1 class='alert-heading' >ATTENTION </h1>Une erreur est peut être survenue</div></div></div> ");
                                    event.stopPropagation();

                                } else {
                                    var chargement="<div id=\"panel\"><span id=\"loading1\">";
                                    chargement+="<span id=\"outerCircle\"></span>";
                                    chargement+="<span id=\"innerCircle\"></span>";
                                    chargement+="</span></div>";
                                    var chargement="<div id=\"panel\"><span id=\"loading1\">";
                                    chargement+="<span id=\"outerCircle\"></span>";
                                    chargement+="<span id=\"innerCircle\"><span id=\"center\"></span></span>";
                                    chargement+="</span></div>";
                                    $("body").css("background-color","rgba(255,255,250,0.2)");
                                    $("body").css("cursor","wait");
                                    chargement_bleu.innerHTML=chargement;

                                    $(".alert").removeClass("show");
                                    $(".alert").addClass("hide");

                                    var tabing = document.getElementsByName("ingredients[]");
                                    var idingredients = [];
                                    for (var i = 0; i < tabing.length; i++) {
                                        idingredients[i] = tabing[i].getAttribute("idingredient");
                                        console.log(tabing[i].getAttribute("idingredient"));
                                    }
                                    //console.log($('#needs-validation').serializeArray());
                                    $.ajax({
                                        type: "POST",
                                        url: $('#needs-validation').attr('action'),
                                        data: $('#needs-validation').serialize() + "&idingredients=" + idingredients + "&id_recette=" + recette_id,
                                        success: function (response, status) {
                                            $("#chargement_bleu").hide("slow");
                                            $("body").css("opacity",1);
                                            $("body").css("cursor","");
                                            if (status != "success") {
                                                $(".container-fluid").html("<div class='row justify-content-md-center'><div class='col-md-auto'><div class='alert alert-danger' role='alert'><h1 class='alert-heading' >ATTENTION </h1><p>" + response + "<a href='mesRecettes.php'>revenir à mes recettes</a></p></div></div></div> ");
                                            } else {
                                                $(".container-fluid").html("<div class='row justify-content-md-center'><div class='col-md-auto'><div class='alert alert-success' role='alert'><h1 class='alert-heading' >SUCCESS </h1><p>" + response + "</p><a href='mesRecettes.php'>revenir à mes recettes</a></div></div></div> ");
                                            }
                                        }
                                    });
                                }
                                form.classList.add('was-validated');
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