<!DOCTYPE html>
<html>
    <?php include "head.php"; ?>
    <body>

        <?php
        include "navbar.php";
        ?>
        <br>
        <div class="container-fluid">
            <hr>
            <h4  class="text-center orange titre"><?= $tab_recette['recette']['nom'] ?> </h4><br/>
            <div class="row">
                <div class="col-xs-4 col-md-2 col-lg-2">

                    <div class="i">
                        <ul>
                            <li><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b><?= strftime('%d %B %Y', strtotime($tab_recette['recette']['date'])); ?></b> </li>
                            <li><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;<b><?= $tab_recette['recette']['auteur'] . " " . $tab_recette['recette']['nom_auteur']; ?></b></li>
                            <li><i class="fa fa-coffee" aria-hidden="true"></i>&nbsp;categorie:<b><?= $tab_recette['recette']['categorie'] ?></b></li>
                            <li><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;recettes:<b><?= $tab_recette['recette']['nb_recettes'] ?></b></li>
                            <li><i class="fa fa-list-ol" aria-hidden="true"></i>&nbsp;ingredients:<b> <?php if(isset($tab_recette['ingredients'])){echo count($tab_recette['ingredients']);}else {echo "vide";}  ?></b></li>
                        </ul>
                    </div>  
                    <ul class="list-group">
<?php
if(isset($tab_recette['ingredients'])){
$i = 0;
foreach ($tab_recette['ingredients'] as $ing) {
    echo "<li class=\"list-group-item\"><a style='text-decoration:none' href='recettes.php?ingredients=".$ing['nom_ingredient']."'>" . $ing['nom_ingredient'] . " </a><span class=\"ingredientes  badge badge-pill badge-primary\" id='" . "ing" . $i . "' data-toggle='tooltip' title=\"ing\" >" . round($ing['quantite'], 3) . "" . $ing['unites'] . "</span></li>";
    $i++;
}
}
?>

                    </ul>
                    <br>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="personnes">Personnes :</label>
                            <select class="form-control"  id="personnes" onchange="calcul()">
                                <?php
                                for ($i = 1; $i < 100; $i++) {
                                    if ($tab_recette['recette']['nbpersonnes'] == $i) {
                                        echo "<option selected>" . $i . "</option>";
                                    } else {
                                        echo "<option>" . $i . "</option>";
                                    }
                                }
                                ?>
                            </select></div>
                    </form>
                    <script type="text/javascript">
                        <?php if(isset($tab_recette['ingredients'])){ ?>
                        var quantites = document.getElementsByClassName("ingredientes");
                        var q_formate = [];
                        var unites = [];
                        for (var i = 0; i < quantites.length; i++) {
                            q_formate[i] = parseFloat(quantites[i].textContent);
                            var monstring = String(quantites[i].textContent);
                            monstring = monstring.replace(/[0-9]+/, "");
                            unites[i] = monstring;
                        }

                        var p0 = document.getElementById("personnes");
                        var x0 = parseFloat(p0.value);
                        function calcul() {
                            var p = document.getElementById("personnes");
                            var x = parseFloat(p.value);
                            var y = [];
                            console.log(p.value);
                            for (var i = 0; i < q_formate.length; i++) {
                                y[i] = (q_formate[i] * x) / x0;
                            }
                            var q = document.getElementsByClassName("ingredientes");
                            for (var i = 0; i < q.length; i++) {
                                q[i].textContent = y[i].toFixed(0) + unites[i];
                            }
                        }
                        <?php } ?>
                    </script>   
                </div>
                <div class="col-xs-6 col-md-6 col-lg-7">
<?php
$etapes = $tab_recette['recette']['preparation'];
$tab_etapes = explode("ETAPE", $etapes, 10);
$i = 1;
foreach ($tab_etapes as $e) {
    echo "<h5 class=\"orange\" >Etape " . $i . "</h5>";
    $i++;
    echo "<p class=\"etapes\">" . $e . "</p>";
}
?>
                    <div class="etoiles etoiles2" >
                    <?php
                    $etoiles = $tab_recette['recette']['etoiles'];
                    afficher_etoiles($etoiles);
                    ?>

                    </div>
                    <br>
<?php
if ($tab_recette['users'][0]['prenom'] == "personne") {
    $liste = "personne a encore vote pour votre recette";
} else {
    $liste="";
    for ($i = 0; $i < count($tab_recette['users']); $i++) {
        $liste.=$tab_recette['users'][$i]['prenom'] . " " . $tab_recette['users'][$i]['nom']." ";
        switch ($tab_recette['users'][$i]['etoiles']) {
            case '1':
                $liste .= ":★ ";
                break;
            case '2':
                $liste .= ":★★ ";
                break;
            case '3':
                $liste .= ":★★★ ";
                break;
            case '4':
                $liste .= ":★★★★ ";
                break;
            case '5':
                $liste .= ":★★★★★ ";
                break;
            default:
                $liste .= ":★★★★★ ";
                break;
        }
        $liste.="\n\r\t,";
    }
}
?>
                    
                    <button type="button" style="cursor: pointer" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="bottom" title="cuisiniers" data-content="<?= $liste ?>" data-original-title="personnes ayant vote">
                        Personnes ayant voté
                    </button>
                </div>
                <div id="image" class="col order-xs-6 order-md-6">
<?php
$pasimg = "img/no-image.png";
if ($tab_recette['recette']['url_image'] == "") {
    $tab_recette['recette']['url_image'] = $pasimg;
}
?>
                    <div class="card" >
                        <img class="card-img-top" src="<?= $tab_recette['recette']['url_image']; ?>" alt="Card image cap" width="200px" heigth="200px">
                        <div class="card-body">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b>TEMPS TOTAL</b> : <?php
                    $prep = $tab_recette['recette']['tpreparation'];
                    $cui = $tab_recette['recette']['cuisson'];
                    if ($tab_recette['recette']['preparation_unites'] == 'heure') {
                        $prep = intval($tab_recette['recette']['tpreparation']) * 60;
                    }
                    if ($tab_recette['recette']['cuisson_unites'] == 'heure') {
                        $cui = intval($tab_recette['recette']['cuisson']) * 60;
                    }
                    echo $prep + $cui;
?>min</div>
                                <div class="panel-body">
                                    <ul>
                                        <li>cuisson : <?= $tab_recette['recette']['cuisson'] . " " . $tab_recette['recette']['cuisson_unites'] ?></li>
                                        <li>préparation : <?= $tab_recette['recette']['tpreparation'] . " " . $tab_recette['recette']['preparation_unites'] ?></li>
                                    </ul>
                                </div>

                            </div>         
                        </div>
                    </div>
                </div>
            </div><!-- row -->
            <div class="row justify-content-lg-center">
                <div class="col-lg-auto">
                    <p class="note"></p>
                    <div  id="<?= $id; ?>" class="rating rating2"  >
<?php if (isset($_SESSION['user_id'])) {
    echo "<span class='" . $_SESSION['user_id'] . "user_id'></span>";
} ?>
                        <a  class="etoile" href="#5"  value="5" title="Give 5 stars">★</a><!--
                        --><a  class="etoile" href="#4"  value="4" title="Give 4 stars">★</a><!-- 
                        --><a  class="etoile" href="#3"  value="3" title="Give 3 stars">★</a><!--
                        --><a  class="etoile" href="#2"  value="2" title="Give 2 stars">★</a><!-- 
                        --><a  class="etoile" href="#1"  value="1" title="Give 1 star">★</a>
                    </div>

                </div>
                <div class="col col col-lg-2">

                </div>
            </div>

            <hr>
            <h5>Commentaires:</h5>
            <hr>
            <?php
            if ($commentaires['commentaires'] == 'pas de commentaires pour cette recette') {
                echo "<p style=\" text-align:center;color:#9b8585; \">Pas de commentaires pour cette recette</p>";
            } else {
                $img_male = "img/user-male.png";
                $img_femele = "img/user-femele.png"
                ?>
                <?php for ($i = 0; $i < count($commentaires['commentaires']); $i++) { ?>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-lg-2">
                            <div class="userImg" >
                                <img class="img-circle" style="background-color: white"  src="<?= $commentaires['commentaires'][$i]['sexe'] == "femme" ? $img_femele : $img_male; ?>" width="35%" height="25%">
                            </div>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-lg-9">
                            <h6><?= $commentaires['commentaires'][$i]['prenom'] . " " . $commentaires['commentaires'][$i]['nom'] ?> <span class="badge badge-light"><?= strftime("%Hh%M %d %B %Y", strtotime($commentaires['commentaires'][$i]['creation'])) ?></span> </h6>
                            <p style="text-align: justify;"><?= $commentaires['commentaires'][$i]['commentaire'] ?></p> 
                        </div>
                    </div><hr><!-- row -->

        <?php
    }
}
?>

            <?php
            if (isset($_POST['commentaire']) && isset($_SESSION['user_id'])) {
                $c = $_POST['commentaire'];
                $id_session = $_SESSION['user_id'];
                ?>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-lg-2">
                        <div class="userImg" >
                            <img class="img-circle" style="background-color: white"  src="img/user-male.png" width="35%" height="35%">
                        </div>
                    </div>
                    <div class="col-xs-9 col-sm-9 col-lg-9">
                        <h6>Votre commentaire<span class="badge badge-light"><?= date("d/m/Y") ?></span> </h6>
                        <p style="text-align: justify;"><?= $c ?></p> 
                    </div>
                </div><hr><!-- row -->
                <?php
                ajouterCommentaire($id, $id_session, $c, $bdd);
            } else if (isset($_POST['commentaire']) && !isset($_SESSION['user_id'])) {
                ?>
                <script type="text/javascript">
                    alert("vous devez être connecté pour pouvoir envoyer un commentaire");
                </script>
                <?php
            }
            ?>
            <div id="commenter"></div>  
            <?php if (isset($_SESSION['user_id'])) {
                include 'Vue/commenter.php';
            } ?>
        </div><!-- containner fluid -->
        <hr>
<?php include "footer.php" ?>
        <script>

            $(document).ready(function () {
                $('[data-toggle="popover"]').popover();
            });
            jQuery(document).ready(function ($) {

                if ($(window).width() < 950)
                    $("#image").addClass("order-first");
            });
            $(document).ready(function () {
                $(".etoile").click(function () {
                    var note = $(this).attr("value");
                    var recette_id = $(this).parent().attr('id');
<?php
if (isset($_SESSION['user_id'])) {
    ?>
                        var user_id = $("#<?= $_SESSION['user_id'] ?>user_id").attr('id');
                        user_ = parseInt(user_id);
    <?php } else {
    ?>
                        var uer_id = return_first[0];
    <?php
}
?>
                    $.ajax({
                        type: 'GET',
                        url: 'controleur/etoiles.php',
                        data: 'note=' + note + '&recette_id=' + recette_id + '&user_id=' + user_id,
                        beforeSend: function () {
                            $('#<?= $id; ?>').children().fadeOut();
                        },
                        success: function (data) {
                            if (data == "il manque l id recette ou la note") {
                                alert("vous devez être connecté pour noter une recette");
                            }
                            console.log(data);
                            data = parseInt(data);
                            if (isNaN(data)) {
                                data = note;
                                $('p.note').html("votre note est de : " + data + "/5 <i class='fa fa-star' aria-hidden='true'></i>");
                            } else {
                                switch (Math.round(data)) {
                                    case 3:
                                        $('p.note').html("bon :" + note + ",moyenne" + Math.round(data) + "/5");
                                        break;
                                    case 2:
                                        $('p.note').html("moyen :" + note + ",moyenne" + Math.round(data) + "/5");
                                        break;
                                    case 1:
                                        $('p.note').html("beurk: " + note + ",moyenne" + Math.round(data) + "/5");
                                        break;
                                    default:
                                        $('p.note').html("note :" + note + " ,moyenne :" + Math.round(data) + "/5");
                                }
                            }
                            /*                var estrella ="<i class='fa fa-star orange' aria-hidden='true'></i>";
                             for(var i =0;i<Math.round(data);i++){
                             $(estrella).insertAfter("p.note");
                             }  */
                        },
                        error: function (resultat, statut, error) {
                            alert(resultat + statut + error);
                        }
                    });
                });
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            $('.ingredientes').on('show.bs.tooltip', function () {
            //var id = $(this).attr("id");
            var q = $(this).text();
            var unit_text=q;
            unit_text=unit_text.replace(/[0-9]+/, "");
            //console.log("unit text"+unit_text);
            //console.log(typeof(q));
            //var t = $(this).attr("data-original-title");
            var q = parseFloat(q);
            if(Number.isInteger(q)!=true){
                $(this).attr("data-original-title", fraction(q));
            }else{
                switch(unit_text){
                    case "g":
                        $(this).attr("data-original-title", q/1000+" kg");
                    break;
                    case "cl":
                    $(this).attr("data-original-title", q/100+" litre");
                    break;
                    case "ml":
                    $(this).attr("data-original-title", q/1000+" litre");
                    break;
                    case "kg":
                    $(this).attr("data-original-title", q*1000+" g");
                    break;
                    case "l":
                    $(this).attr("data-original-title", q*100+"cl");
                    break;
                    case "litre":
                    $(this).attr("data-original-title", q*1000+"ml");
                    break;
                default :
                    $(this).attr("data-original-title", q+" "+unit_text);
                }
            }
                //console.log(typeof(q)); 
            });
        </script>
    </body>
</html>