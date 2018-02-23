<!DOCTYPE html>
<html>
    <?php include "head.php"; ?>
    <body>
        <?php include "navbar.php"; ?>
        <br>
        <div id="container" class="container">
            <div class="row">
                <div class="col-md">
                    <h4>Ingredients</h4>
                    <form>
                        <div class="form-group">
                            <label for="select_ingredients">Choissisez un ou plusieurs ingredients</label>
                            <select multiple class="form-control" style="height:10em" id="select_ingredients">
                                <?php
                                $k=0;
                                foreach ($ingredients as $ingredient) {
                                    if($ingredient['nom']=="oeuf"){
                                        if($k>1){
                                            echo '<option value=\''.$ingredient['nom'].'\'>'.trim($ingredient['nom']).'</option>';
                                        }else {
                                            $k++;
                                        }
                                    }else {
                                        echo '<option value=\''.$ingredient['nom'].'\'>'.trim($ingredient['nom']).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="limite">Limiteà afficher</label>
                            <select class="form-control" id="limite">
                                <option>10</option>
                                <option>50</option>
                                <option>100</option>
                                <option>1000</option>
                                <option>infini</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md">
                    <h4>Recettes</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Auteur</th>
                                <th scope="col">categorie :</th>
                            </tr>
                        </thead>
                        <tbody id="recettes_ingredients">
                            <tr>
                                <th scope="col" colspan="3" style="background-color: grey;color: white;text-align:center">Selectionnez des recettes</th>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        var options_selectiones = [];
        var ingredients = document.getElementById('select_ingredients');
        ingredients.addEventListener("change", function (ingredient) {
            var options = ingredients.querySelectorAll("option");
            options.forEach(function (option) {
                if (option.selected == true) {
                    if ($.inArray(option.text, options_selectiones) == -1) {
                        options_selectiones.push(option.text);
                    } else {
                        options_selectiones.slice(option.text);
                    }
                } else {
                    var index = options_selectiones.indexOf(option.text);
                    if (index != -1) {
                        options_selectiones.splice(index, 1);
                    }
                }

            });
            var limite = $( "#limite" ).val();
            var tr =document.createElement("tr");
            var classe=document.createAttribute("class");
            classe.value="chargement";
            tr.setAttributeNode(classe);
            var td= document.createElement("td");
            td.align="center";
            var img="<img id=\"ajaxLoading\" style=\"margin-left:auto;margin-right:auto\;diplay:inline;width:auto\" src=\"img/loading.gif\" alt=\"Loading\" />";
            $(td).append(img);
            $(tr).append(td);
            $("#recettes_ingredients").append(tr);
            
            $.ajax({
                url: "Controleur/reccettes_from_ingredients.php",
                global: false,
                method: "POST",
                data: {ingredients: options_selectiones,limite: limite},
                cache: false,
                beforesend: function () {
                    
                    $("#recettes_ingredients").html("<img id=\"ajaxLoading\" src=\"img/loading.gif\" alt=\"Loading\" />");
                },
                success: function (data) {
                    $(".chargement").remove();
                    var tbody = "";
                    console.log(data);
                    if(data.match(/error/g)!=null){
                        console.log(data);
                        tbody += "<tr>";
                        var text="Il n'existe aucune recette pour ce melange d'ingredients";
                        tbody += "<td colspan=\"3\" style='text-align:center'>"+text+"</td>";
                        tbody += "</tr>";
                    }
                    else  {
                        var tab = JSON.parse(data);
                        console.log(tab);
                        for (var i in tab) {
                            tbody += "<tr>";
                            tbody += "<th scope='row'><a href='index.php?id=" + tab[i]['id'] + " '> " + ((tab[i]['nom']).toUpperCase()) + "</a></th>";
                            tbody += "<td>" + tab[i]['auteur'] + "</td>";
                            tbody += "<td>" + tab[i]['categorie'] + "</td>";
                            tbody += "</tr>";
                        }
                    }
                    $("#recettes_ingredients").html(tbody);
                },
                error: function () {
                    $("#recettes_ingredients").html("une erreur est survenue veuillez reeseiller plus tard");
                }
            });
        });
    </script>
</html>