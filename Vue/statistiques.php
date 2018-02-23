<!DOCTYPE html>
<html>
    <?php include "head.php"; ?>
    <body>

        <?php
        include "navbar.php";
        ?>
        <br>
        <script type="text/javascript">
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer",
                        {
                            theme: "theme2",
                            title: {
                                text: "Types de Plats"
                            },
                            data: [
                                {
                                    type: "pie",
                                    showInLegend: true,
                                    toolTipContent: "{y} - #percent %",
                                    yValueFormatString: "# .recettes",
                                    legendText: "{indexLabel}",
                                    dataPoints: [
                                        {y: <?= $cocktail?>, indexLabel: "Coktails"},
                                        {y: <?= $dessert ?>, indexLabel: "desserts"},
                                        {y: <?= $principal?>, indexLabel: "plats"}

                                    ]
                                }
                            ]
                        });
                chart.render();
            }
//            $(function () {
//                $('[data-toggle="tooltip"]').tooltip();
//            });

        </script>
        <script src="libs/js/canvasjs.min.js"></script>

        <div class="container">
            <div style="display: inline-block">
            <a class="btn btn-primary" data-toggle="collapse" href="#information" aria-expanded="false" aria-controls="information">
                Information
            </a>
            <a class="btn btn-warning" data-toggle="collapse" href="#utilisateurs" aria-expanded="false" aria-controls="utilisateurs">
                Utilisateurs <i class="fa fa-users" aria-hidden="true"></i>
            </a>
            </div>
                <br><br>
            <div class="collapse" id="information">
                <div  class="row">
                    <div class="col-xs-6 col-md-4">

                        <div class="information" >
                            <h4><i class="fa fa-cutlery" aria-hidden="true"></i>&nbsp;Recettes</h4>
                            <ul>
                                <li>
                                    <button type="button" class="btn btn-primary">
                                        <b>Moi </b> <span class="badge badge-light"><?= $nb_recettes_users; ?></span> 
                                        <span class="sr-only">Aucunne recette</span>
                                    </button>     
                                </li>
                                <li>
                                    <button type="button" class="btn btn-success">
                                        <b>TOTAL   </b> <span class="badge badge-light"><?= $_SESSION['total_recettes'] ?></span> 
                                        <span class="sr-only">Aucunne recette</span>
                                    </button>  
                                </li>
                                <li>
                                    plat principal <span class="orange">(<?= $moy_plats ?>) :<?= afficher_petites_etoiles($moy_plats) ?></span><br>
                                    desserts <span class="orange">(<?= $moy_desserts ?>) :<?= afficher_petites_etoiles($moy_desserts) ?></span><br>
                                    cocktails <span class="orange">(<?= $moy_cocktails ?>): <?= afficher_petites_etoiles($moy_cocktails) ?></span><br>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="information">
                            <h4><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Utilisateurs</h4>
                            <ul>
                                <li>
                                    <button type="button" class="btn btn-primary">
                                        <b> Actifs </b> <span class="badge badge-light"><?= $actifs; ?></span> 
                                        <span class="sr-only">Personne est actif</span>
                                    </button>  
                                </li>
                                <li>
                                    <button type="button" class="btn btn-success"> <b>TOTAL  </b> <span class="badge badge-light"> <?= $nb_users ?> </span> 
                                        <span class="sr-only">Aucunne recette</span>
                                    </button>  
                                </li>
                                <li>
                                    plats principal  :<b><?= $principal ?> </b> <br>
                                    desserts :<b> <?= $dessert ?>  </b><br>
                                    cocktails :<b> <?= $cocktail ?>  </b><br>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-6  col-md-4">
                        <div class="information">
                            <h4><i class="fa fa-comment-o" aria-hidden="true"></i>&nbsp;Commentaires</h4>
                            <ul>
                                <li>
                                    <button type="button" class="btn btn-primary">
                                        <b> Moi </b> <span class="badge badge-light"> <?= $commentaires_utilisateur; ?> </span> 
                                        <span class="sr-only">Personne est actif</span>
                                    </button>  
                                </li>
                                <li>
                                    <button type="button" class="btn btn-success"> <b>TOTAL  </b> <span class="badge badge-light"><?= $commentaires_total; ?></span> 
                                        <span class="sr-only">Aucunne recette</span>
                                    </button>   
                                </li>
                                <li>
                                    <?= $nb_comment[0][0] ?> :<b> <?= $nb_comment[0][1] ?> <i class="fa fa-comment-o" aria-hidden="true"></i> </b> <br>
                                    <?= $nb_comment[1][0] ?> :<b> <?= $nb_comment[1][1] ?> <i class="fa fa-comment-o" aria-hidden="true"></i> </b> <br>
                                    <?= $nb_comment[2][0] ?> :<b> <?= $nb_comment[2][1] ?> <i class="fa fa-comment-o" aria-hidden="true"></i> </b><br>
                                </li>
                            </ul>
                        </div>
                    </div><!-- col -->
                </div><!-- row -->
            </div><!--collapse-->
            <div class="collapse" id="utilisateurs">
            <div class="row justify-content-md-center">
                <div class="col-xs-12  col-md-12">
                    <br><br>
                    <table class="table avectri table-striped table-responsive-md">
                        <thead class="thead-dark">
                            <tr>
                                <th data-tri="1" class="selection" data-type="num" scope="col">recettes</th>
                                <th scope="col">nom </th>
                                <th scope="col">prénom</th>
                                <th scope="col">mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $body="";
                                foreach($affichage_utilisateurs as $utilisateur){
                                    $body.="<tr>\n\r";
                                    $body.="<th scope=\"row\">".$utilisateur['recettes']."</th>\n\r";
                                    $body.="<td scope=\"row\">".strtoupper($utilisateur['nom'])."</td>\n\r";
                                    $body.="<td scope=\"row\"><a href='recettes.php?id_auteur=".$utilisateur['id']." '>".ucwords(strtolower($utilisateur['prenom']),'-\'\"')."</a></td>\n\r";
                                    $body.="<td scope=\"row\">".$utilisateur['email']."</td>\n\r";
                                    $body.="</tr>\n\r";
                                }
                                echo $body;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-xs-6  col-md-6">
                    <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
            <script>
            $("a[href=\"#utilisateurs\"]").click(function(){
                //alert("warning");
                //$("#utilisateurs").collapse('hide');
                $("#information").collapse('hide');
            });
            $("a[href=\"#information\"]").click(function(){
                //alert("success");
                //$("#information").collapse('hide');
                $("#utilisateurs").collapse('hide');
            });
$(function () {
$(".collapse").on('show.bs.collapse', function () {
    console.log ($(this).attr("id"));
})
});
            </script>
        </div>
        <br>
        <?php
        include 'footer.php';
        ?>
    </body>
</html>