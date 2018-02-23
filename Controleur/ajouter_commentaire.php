<?php 
require 'Controleur/controlleur.php';
if(isset($_POST['commentaire']) && isset($_SESSION['user_id']) ){
  	$c=$_POST['commentaire'];
    $id_session=$_SESSION['user_id'];
    ajouterCommentaire($id,$id_session,$c,$bdd);
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
}else {
	echo "vous devez être connecté pour envoyer un commentaire";
}
?>