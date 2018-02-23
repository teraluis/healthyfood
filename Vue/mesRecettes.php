<!DOCTYPE html>
<html>
<?php include "head.php"; ?>
<body>

<?php 
  include "navbar.php";
?>
<br>
<div class="container">
<div class="row">
<div class="col-lg-12 col-md-12 col-xs-12">
<?php if(isset($_GET['receta'])){ echo '<h1 class="orange">Resultat de votre recherche</h1>';
}else echo '<h1 class="orange">Mes recettes notés</h1>';
?>
<table class="table avectri table-striped table-responsive-md">
  <thead>
    <tr>
      <th scope="col">Nom recette</th>
      <th scope="col">categorie</th>
      <th scope="col">moyenne</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $tbody="";
    
    $recettes = $_SESSION['recettes_moyennes'];
    if($_SESSION['recettes_moyennes']!="vide"){
      foreach($recettes['recettes_moyenne'] as $r){
          $tbody.="<tr>\n\r";
          $tbody.="<th scope='row'><a href='index.php?id=".$r['id']."'>".strtoupper($r['nom'])."</a></th>\n\r";
          if($r['categorie']=="cocktail"){
            $tbody.="<td>".$r['categorie']." <i class='fa fa-glass' aria-hidden='true'></i></td>\n\r"; 
          }else if($r['categorie']=="plat principal"){
            $tbody.="<td>".$r['categorie']." <i class='fa fa-cutlery' aria-hidden='true'></i></td>\n\r";
          }else if($r['categorie']=="dessert"){
            $tbody.="<td>".$r['categorie']." <i class='fa fa-birthday-cake' aria-hidden='true'></i></td>\n\r";
          }
          else{
            $tbody.="<td>".$r['categorie']."</td>\n\r";
          }
          $tbody.="<td>".round($r['moyenne'])." ".afficher_petites_etoiles($r['moyenne'])."</td>\n\r";
          $r['image']==''?$r['image']="img/no-image.png":$r['image']=$r['image'];
          $tbody.="<td><img src='".$r['image']."'  height='42' width='42'></td>\n\r";
          $tbody.="</tr>\n\r";   
      }
    } else if($_SESSION['recettes_moyennes']=="vide") { $tbody="<tr><td colspan='4'>Vous n'avez ajoutte aucune recette pour le moment sur healtlyfood </tr>";}
      echo $tbody;
    ?>
  </tbody>
</table>
    <h1> Toutes mes recentes </h1>
<table class="table  table-striped table-responsive-md" id="toutes_recettes">
  <thead>
    <tr>
      <th scope="col">Nom recette</th>
      <th scope="col">categorie</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $tbody="";
        $i=1;
      foreach($recettes1 as $r){
          $tbody.="<tr>\n\r";
          $tbody.="<th scope='row'><a href='index.php?id=".$r['id']."'>".strtoupper($r['nom'])."</a></th>\n\r";
          if($r['categorie']=="cocktail"){
            $tbody.="<td>".$r['categorie']." <i class='fa fa-glass' aria-hidden='true'></i></td>\n\r"; 
          }else if($r['categorie']=="plat principal"){
            $tbody.="<td>".$r['categorie']." <i class='fa fa-cutlery' aria-hidden='true'></i></td>\n\r";
          }else if($r['categorie']=="dessert"){
            $tbody.="<td>".$r['categorie']." <i class='fa fa-birthday-cake' aria-hidden='true'></i></td>\n\r";
          }
          else{
            $tbody.="<td>".$r['categorie']."</td>\n\r";
          }
          $r['image']==''?$r['image']="img/no-image.png":$r['image']=$r['image'];
          $tbody.="<td><img src='".$r['image']."''  height='42' width='42'> <button type='button'  data-whatever='".$r['id']."' class='btn btn-danger supp' ligne='".$i."' data-toggle='modal' data-target='#confirm'>Suprimer <i class='fa fa-trash' aria-hidden='true'></i></button> <a  href='modifierRecette.php?id_recette=".$r['id']."' class='btn btn-success'>Modifier <i class='fa fa-pencil' aria-hidden='true'></i></a></td>\n\r";
          $tbody.="</tr>\n\r";
          $i++;
      }
      echo $tbody;
    ?>
  </tbody>
</table>
<div class="modal" tabindex="-1" role="dialog" id="confirm">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Suppression de RECETTE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p class="response">Etês vous sûr de vouloir supprimer <b class="nom_recette">RECETTE</b> après quoi la recette sera definitivement perdue.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="supprimer_definitivement" data-dismiss="modal">supprimer</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">anuler</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<script>
$('.supp').on('click', function () {
  var lignes = document.getElementById("toutes_recettes").rows;
  var ligne = $(this).attr('ligne');
  var datawhatever= $(this).attr('data-whatever');
  datawhatever= parseInt(datawhatever);
  console.log(datawhatever);
  $('#supprimer_definitivement').on('click',function(){
      console.log(datawhatever);
        $.post("Controleur/supprimerRecette.php",
        {
            id: datawhatever 
        },
        function(data, status){
            console.log(data+". statut :"+status);
            $(".response").innerHTML="Data: " + data + "\nsuppression en cours: " + status;
        });
     lignes[ligne].innerHTML="<td colspan='3'style='text-align:center;font-weight:bold;font-style:italic' > vottre recette a été supprime </td>"; 
  });
  
});
</script>
<?php
include 'footer.php';
?>
</body>
</html>