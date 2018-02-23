<!DOCTYPE html>
<html>
    <?php include "head.php"; ?>
    <body>
        <?php include "navbar.php"; ?>
        <br>
        <div id='contenu' class="container">
        <form class="well form-horizontal" action="Controleur/updateUser.php" method="post"  id="forminscription">
            
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                            <!-- Text input-->

                            <div class="form-group">
                                <label class="col">Prénom</label>  
                                <div class="col-md-auto inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <input  name="prenom" value="<?= $_SESSION['prenom']?>" class="form-control"  type="text">
                                    </div>
                                </div>
                            </div>

                            <!-- Text input-->

                            <div class="form-group">
                                <label class="col-md-auto control-label" >Nom</label> 
                                <div class="col-md-auto inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <input name="nom" value="<?= $_SESSION['nom'] ?>" class="form-control"  type="text">
                                    </div>
                                </div>
                            </div>


                            <!-- Select Basic -->

                            <div class="form-group"> 
                                <label class="col-md-auto control-label">Année naisance</label>
                                <div class="col-md-auto selectContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <select name="naissance" class="form-control selectpicker" >
                                            <?php
                                            date_default_timezone_set('UTC');
                                            $annee_naissance= date("Y");
                                            $naissance= intval($informations_utilisateur[0]['naissance']);
                                            
                                            for($i=1920;$i<$annee_naissance;$i++){
                                                if($i==$naissance){
                                                    echo '<option selected>'.$i.'</option>';
                                                }else{
                                                    echo '<option>'.$i.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- radio checks -->
                            <div class="form-group">
                                <label class="col-md-auto control-label">sexe :</label>
                                <div class="col-md-auto">
                                    <div class="radio form-check-inline">
                                        <label>
                                            <input type="radio" name="sexe" <?php if($_SESSION['sexe']=="homme"){echo "checked";} ?>   value="homme" /> <i class="fa fa-male" aria-hidden="true"></i> homme
                                        </label>
                                    </div>
                                    <div class="radio form-check-inline">
                                        <label>
                                            <input type="radio" name="sexe" <?php if($_SESSION['sexe']=="femme"){echo "checked";} ?> value="femme" /> <i class="fa fa-female" aria-hidden="true"></i> femme
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-auto control-label">E-Mail</label>  
                                <div class="col-md-auto inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                        <input name="email" value="<?= $_SESSION['email'] ?>"  class="form-control"  type="text">
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="col-md-auto control-label">mot passe</label>  
                                    <div class="col-md-auto inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                            <input name="password" id="mdp" value="<?= $informations_utilisateur[0]['password'] ?>" class="form-control"  type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-auto control-label">confirmer mot passe</label>  
                                    <div class="col-md-auto inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                            <input name="confirm" id="confirm" value="<?= $informations_utilisateur[0]['password'] ?>" class="form-control"  type="text">
                                        </div>
                                    </div>
                                </div>    

                            </div>
                            <div class="col-md-auto">
                                <!-- Text input-->
                                <h3>Renseignements à votre sujet</h3>
                                <div class="form-group">
                                    <label class="col-md-auto control-label">Pays</label>  
                                    <div class="col-md-auto inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            <input name="pays" id="pays" value="<?= $informations_utilisateur[0]['pays'] ?>" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-auto control-label">Region</label>  
                                    <div class="col-md-auto inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            <input name="region" id="region" value="<?= $informations_utilisateur[0]['region'] ?>" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                                <!-- Text input-->

                                <div class="form-group">
                                    <label class="col-md-auto control-label">Ville</label>  
                                    <div class="col-md-auto inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            <input name="city" id="city" value="<?= $informations_utilisateur[0]['city'] ?>" class="form-control"  type="text">
                                        </div>
                                    </div>
                                </div>


                                <!-- Text input-->

                                <div class="form-group">
                                    <label class="col-md-auto control-label">Code Postal</label>  
                                    <div class="col-md-auto inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            <input name="zip" id="zip" value="<?= $informations_utilisateur[0]['zip'] ?>" class="form-control"  type="text">
                                        </div>
                                    </div>
                                </div>


                            

                                <!-- Success message 
                                <div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>-->

                                <!-- Button -->
                                <div class="form-group">
                                    <label class="col-md-auto control-label"></label>
                                    <div class="col-md-auto">
                                        <button type="submit" class="btn btn-warning" > modifier <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                        <a role="button" class="btn btn-primary" href="index.php" > anuler <i class="fa fa-paper-plane-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                </div>
            </div>
        </form>
        </div>
        
<script type="text/javascript">
  var affLink = "https://www.spyoff.com/?a_aid=10752&a_bid=977f4319";
  var json;
  var parsedData;
  var ip;
  var city;
  var country;
  var zip;
  var region;
$.getJSON('https://freegeoip.net/json/?callback=?', function(data) {
  json = (JSON.stringify(data, null, 2));
  parsedData = JSON.parse(json);
  ip = parsedData.ip;
  country = parsedData.country_name;
  city = parsedData.city;
  zip=parsedData.zip_code;
  region=parsedData.region_name;
  document.getElementById("pays").value = country;
  document.getElementById("city").value = country;
  if(city=='')
    {
  document.getElementById("city").value = country;
    }
  else
    {
  document.getElementById("city").value = city;
    }
  document.getElementById("zip").value = zip;
  document.getElementById("region").value = region;
});
var inscription = document.getElementById("forminscription");
inscription.addEventListener('submit',function(event){
    event.preventDefault();
    var mdp = $('#mdp').val();
    var confirm = $('#confirm').val();
    if(mdp==confirm){
        $.post("Controleur/updateUser.php",
        
        $("#forminscription").serialize(),
        function(data,status){
            console.log(data);
            if(status=="success"){
                data=JSON.parse(data);
                console.log(data);
                if(data.password==false){
                    alert("les mots de passe ne sont pas identiques");
                    return 0;
                }
                else if(data.existe==true) {
                    alert("l utilisateur existe déjà");
                    return 0;
                }else {
                $message="<div class='row justify-content-md-center'>\n\
                <div class='col-md-auto'>\n\
                <div class='alert alert-success' role='alert'>\n\
                <h1 class='alert-heading' >MODIFIE </h1>\n\
                Vos informations personelles ont été modifies\n\
                </div>\n\
                </div>\n\
                </div>";
                $("#contenu").html($message);
                }
            }
            else if(status!="success") {
                alert("une erreur inconue est survenu");
            }
            
        });
    }
    else {
        alert("les mdp ne sont pas identiques");
    }
});
</script>
    <?php include 'footer.php'; ?>
</body>
</html>