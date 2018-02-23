<?php if(isset($_COOKIE["email"])){ $email = $_COOKIE["email"]; } else {$email="";} ?> 
<?php if(isset($_COOKIE["password"])){ $password = $_COOKIE["password"]; } else {$password="";} ?> 
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">connexion</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="body_login" class="modal-body">
                <form id="login">
                    <div id="changement">
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" aria-describedby="emailHelp" placeholder="moi@mail.ext">
                        <small id="emailHelp" class="form-text text-muted">on comuniquera jamais votre email .</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot passe</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?= $password; ?>" placeholder="Password">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input id="memoriser" type="checkbox" name="memoriser" value="oui" class="form-check-input">
                            se souvenir de moi
                        </label>
                    </div>
                    <p id="erreur_connection" style="color:red;"></p>
                    <button type="button" id="submit" class="btn btn-primary">connecter</button>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="inscription.php">nouveau? s'inscrire</a>
                    <a class="dropdown-item" id="mdpoublie" style="cursor: pointer" >mot passe oublie</a>
                    <a class="dropdown-item d-none" id="seconnecter" style="cursor: pointer">se connecter</a>
                </form>
            </div>
            <div class="modal-footer">
                <button id="fermer" type="button" class="btn btn-default" data-dismiss="modal">fermer</button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById("seconnecter").addEventListener("click", function(){
    $("#seconnecter").addClass("d-none");
    $("#mdpoublie").toggle();
    $("#changement").load("Vue/login.html");
    //console.log(form);
});
document.getElementById("mdpoublie").addEventListener("click", function(){
    var form="<div class=\"form-group\">\n";
    form+="<label for=\"email\">votre email </label>\n";
    form+="<input type=\"email\" class=\"form-control\" id=\"email\" name=\"email\" placeholder=\"votremail@dns.ext\" aria-describedby=\"emailHelp\" placeholder=\"moi@mail.ext\">";
    form+="</label>\n";
    form+="</div>\n";
    form+="<button type=\"button\" id=\"submitmail\" onclick='' class='btn btn-primary'>envoyer <i class=\"fa fa-paper-plane\" aria-hidden=\"true\"></i></button>\n";
    //form+="<br /><a href='#' id='anuler_mdp' onClick='seConnecter()' >se connecter</a> , <a href='inscription.php'>s'inscrire</a>";
    document.getElementById("changement").innerHTML =form;
    $("#mdpoublie").toggle();
    $("#seconnecter").removeClass("d-none");
    $("#submitmail").click(function(){
        var email = document.getElementById("email").value;
        $("#changement").css("text-align","center");
        $("#changement").html("<img id=\"ajaxLoading\" style=\"margin-left:auto;margin-right:auto;diplay:inline;width:auto\" src=\"img/loading.gif\" alt=\"Loading\" />");
          $.ajax({
          url: "Controleur/sendmail.php",
          global:false,
          method: "POST",
          data: "&email="+email,
          beforesend: function(){
            $("#changement").html("<img id=\"ajaxLoading\" src=\"img/loading.gif\" alt=\"Loading\" />");
          },
          success: function(data){
              console.log(data);
            $("#changement").css("text-align","");
            $("#changement").html("<p style='text-align:center'>"+data+"</p>");
          },
          error:function(){
            $("#login").html("une erreur est survenue veuillez reeseiller plus tard");
          }   
        });
        
    });
});


</script>