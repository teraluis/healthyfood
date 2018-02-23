function ajouter(){
  var formulaire = document.getElementById("mesinput");
  var ligne = document.createElement("div");
  ligne.classList.add("ligne");
  var elem = document.createElement("input");
  //var datalist=document.createElement("datalist");
  //var option = document.createElement("option");
  elem.type="text";
  elem.setAttribute("list","ingredients_sugeres");
  elem.name="ingredients[]";
  elem.style.width="100px";
  elem.style.margin="0px 3px 0px 0px";
  elem.placeholder="ingredients";
  elem.classList.add("form-control");
  elem.classList.add("ingredients");
  elem.style.size=5;
  elem.required=true;
  //datalist.appendChild(option);
  //option.textContent="pommes";
  //elem.appendChild(datalist);
  ligne.appendChild(elem);
  var elem2 = document.createElement("input");

  
  elem2.type="number";
  elem2.step="0.001";
  elem2.min=0;
  elem2.name="quantite[]";
  elem2.style.width="100px";
  elem2.style.margin="0px 3px 0px 0px";
  elem2.placeholder="quantite";
  elem2.classList.add("form-control");
  elem2.classList.add("quantite");
  elem2.style.size=5;
  elem2.required=true;

  ligne.appendChild(elem2);
  var elem3 = document.createElement("input");
  elem3.type="text";
  elem3.name="unites[]";
  elem3.style.width="100px";
  elem3.style.margin="0px 3px 0px 0px";
  elem3.placeholder="unites";
  elem3.classList.add("form-control");
  elem3.classList.add("unites");
  elem3.style.size=5;
  elem3.required=true;
  ligne.appendChild(elem3);
  var br = document.createElement("br");
  ligne.appendChild(br);
  formulaire.appendChild(ligne);
}
function suprimer(){
  var formulaire = document.getElementById("mesinput");
  var dernier_enfant = formulaire.lastChild;
  formulaire.removeChild(dernier_enfant);
}
function verifier(){
  var ingredients = document.getElementsByTagName("ingredients")
  for(var i=0;i<ingredients.length();i++){
    if(document.getElementsByTagName("ingredients")[i].value==="" ){
      alert('pas de champs vide');
      return false;
    }
    else {
      return true;
    }
  }
}
function fraction(x){
    x = parseFloat(x);
    var i=1;
    var j=1;
    
    if(x===0){
        return 0;
    }
    while(x!=i/j){
        if(x<i/j){
            j++;
        }else if(x>i/j) {
            i++;
        }
    }
    var fraction=[];
    fraction[0]=i;
    fraction[1]=j;
    return fraction[0]+"/"+fraction[1];
}
