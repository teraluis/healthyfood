  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-id-card-o" aria-hidden="true"></i> <?= $_SESSION['nom']." ".$_SESSION['prenom'] ?></h4><button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <i class="fa fa-envelope" aria-hidden="true"></i> <?= $_SESSION['email'] ?><br>
        <?php if ($_SESSION['sexe']=="femme") {
          echo "<i class='fa fa-female' aria-hidden='true'></i> ".$_SESSION['sexe']."<br>";
        }else {
          echo "<i class='fa fa-male' aria-hidden='true'></i> ".$_SESSION['sexe']."<br>";
        }
        ?>
        <i class="fa fa-tachometer" aria-hidden="true"></i> <?php  $p = (float) ($_SESSION['recettes_utilisateur']/$_SESSION['total_recettes'])*100; echo round($p)."%"; ?> recettes <br>
        <i class="fa fa-cutlery" aria-hidden="true"></i> <?= $_SESSION['recettes_utilisateur'] ?> recettes  <br>
        <?php 
        if($_SESSION['recettes_moyennes']!='vide'){
        $moy = $_SESSION['recettes_moyennes'];
        $m=0;
          foreach ($moy['recettes_moyenne'] as $v) {
            $m+=$v['moyenne'];
          }
        $m/=(float) count($moy['recettes_moyenne']);

        echo "<b>moyenne </b>: ".round($m,1)." <i class='fa fa-star-half-o' aria-hidden='true'></i>";
          if($m>4){
            echo " excellent <i class='fa fa-thumbs-o-up' aria-hidden='true'></i>";
          }
        }
        ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
        </div>
      </div>
    </div>
  </div>