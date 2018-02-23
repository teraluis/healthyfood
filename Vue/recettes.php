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
}else echo '<h1 class="orange">Recettes</h1>';
?>
<table class="table avectri table-striped table-responsive-md">
  <thead>
    <tr>
      <th scope="col">Nom recette</th>
      <th scope="col">categorie</th>
      <th scope="col">auteur</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $tbody="";
   if($recetas=="aucune recette actuelement"){
       echo "<tr><td colspan='4' style='text-align:center'>aucune recette actuelement  </td> </tr>";
   }else{
       //var_dump($recetas['recettes']);
    foreach($recetas['recettes'] as $r){
      if($r['year']){
        $tbody.="<tr>\n\r";
        $tbody.="<th scope='row'><a href='index.php?id=".$r['id']."'>".mb_strtoupper($r['nom_recette'])."</a></th>\n\r";
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
        $tbody.="<td>".ucwords(strtolower($r['prenom']))." ".ucwords(strtolower($r['nom_user']),'-')."</td>\n\r";
        $r['image']==''?$r['image']="img/no-image.png":$r['image']=$r['image'];
        $tbody.="<td><img src='".$r['image']."'  height='42' width='42'></td>\n\r";
        $tbody.="</tr>\n\r";
      }
    }
    echo $tbody;
   }
    ?>
  </tbody>
</table>
</div>
</div>
</div>
<?php
include 'footer.php';
?>
</body>
</html>