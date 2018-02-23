<script src="libs/js/jquery-3.2.1.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand " href="index.php"><b class="titre_logo orange">healthy</b> <img src="img/hat.ico" height="20px" ><b class="titre_logo orange"> food</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Accueil <span class="sr-only">Accueil</span></a>
            </li>
            <li  class="nav-item">
                <a class="nav-link" href="recettes.php"><i class="fa fa-book" aria-hidden="true"></i>Recettes</a>
            </li>
            <li  class="nav-item">
                <a class="nav-link" href="recherche_par_ingredient.php"><i class="fa fa-book" aria-hidden="true"></i>Ingredients</a>
            </li>
            <li id="navli" class="nav-item"></li>
            <?php
            if (isset($_SESSION['user_id'])) {
                include 'gestion.php';
            }
            ?>
            <li class="nav-item">
                <a class="nav-link disabled" style="cursor:pointer" data-toggle="modal" data-target="#myModal"><i class="fa fa-user-circle" aria-hidden="true" ></i><span id="user">
                        <?php
                        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
                            echo $_SESSION['prenom'] . " " . $_SESSION['nom'] . "</span></a>";
                        } else {
                            echo "se connecter";
                        }
                        ?>
                    </span></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="recettes.php">
            <span class="input-group-btn">
                <button class="btn btn-secondary" style="border-radius: 5px 0px 0px 5px;" type="submit">Go!</button>
                <input type="text" class="form-control" name="receta" style="border-radius: 0px 5px 5px 0px;" placeholder="rechercher une recette" id="recherche" list="sugere" aria-label="rechercher">
                <datalist id="sugere">
                    <option value="poulet aux speculos">
                    <option value="poisson à la norvegienne">
                    <option value="meringue qui marche">
                </datalist>        
            </span>

            <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button> -->
        </form>
    </div>
</nav>

<!-- Modal -->
<?php
if (isset($_SESSION['user_id'])) {
    include 'modal_conectee.php';
} else {
    include 'modal_deconnectee.php';
}
?>
<script type="text/javascript">
    var return_first;
    function callback(response) {
        return_first = response;
    }
    $("#submit").on("click", function () {

        var email = $("#email").val();
        var password = $("#password").val();
        var memoriser = $("#memoriser").val();
        if (login == "" || password == "") {
            alert("Tous les champs doivent êtres remplis");
        } else {
            $("#changement").css("text-align", "center");
            $("#changement").html("<img id=\"ajaxLoading\" style=\"margin-left:auto;margin-right:auto;diplay:inline;width:auto\" src=\"img/loading.gif\" alt=\"Loading\" />");

            $.ajax({
                url: "login.php",
                global: false,
                method: "POST",
                data: {email: email, password: password, memoriser: memoriser},
                beforesend: function () {
                    $("#login").html("<img id=\"ajaxLoading\" src=\"img/loading.gif\" alt=\"Loading\" />");
                },
                success: function (data) {
                    $("#changement").css("text-align", "center");
                    console.log(data);
                    data = data.split(',');
                    if (data[data.length - 1] === "conecte") {
                        $("#login").html("<p style='text-align:center'> vous êtes conecté <b>" + data[2] + " " + data[1] + "</b></p>");
                        $("#user").html(data[2] + " " + data[1]);
                        $("#navli").load("Vue/gestion.php");
                        $("#commenter").load("Vue/commenter.php");
                        callback(data);
                    } else {
                        $("#erreur_connection").html("Login ou identifiant incorect");
                    }
                },
                error: function () {
                    $("#login").html("une erreur est survenue veuillez reeseiller plus tard");
                }
            });
        }
    });

    $(document).ready(function () {
        $("#recherche").keyup(function () {
            var txt = $("#recherche").val();
            if (txt.length > 0) {
                $.get("sugestions.php", {recherche: txt}, function (result) {
                    console.log(result);
                    result = JSON.parse(result);
                    if (result[0] == "pas de sugestion,") {
                        $("#sugere").html("<option value='pas de sugestion'>");
                    } else {
                        // var tab= result;
                        $("#sugere").empty();
                        console.log(result);
                        for (var key in result) {
                            var str = result[key]['nom'];
                            var res = str.toLowerCase();
                            $("#sugere").append("<option  value='" + res + "'>");
                            //$("#sugestiones").append(result['recette'][key]+" "+key+",");
                        }
                    }
                });
            }

        });
    });
    $(document).ready(function () {
//var nav = document.getElementsByClassName("nav-item");

        if (window.location.pathname == "/cuisine2/index.php") {
            $(".nav-item:first").addClass("active");
        }
        if (window.location.pathname == "/cuisine2/recettes.php") {
            $(".nav-item:nth-child(2)").addClass("active");
        }
    });

</script>


