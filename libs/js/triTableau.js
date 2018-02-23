
  // Tri dynamique de tableau HTML
  // Auteur : Copyright � 2015 - Django Blais
  // Source : http://trucsweb.com/tutoriels/Javascript/tableau-tri/
  // Sous licence du MIT.
  function twInitTableau() {
    // Initialise chaque tableau de classe � avectri �
       [].forEach.call( document.getElementsByClassName("avectri"), function(oTableau) {
       var oEntete = oTableau.getElementsByTagName("tr")[0];
       var nI = 1;
  	  // Ajoute � chaque ent�te (th) la capture du clic
  	  // Un picto fl�che, et deux variable data-*
  	  // - Le sens du tri (0 ou 1)
  	  // - Le num�ro de la colonne
      [].forEach.call( oEntete.querySelectorAll("th"), function(oTh) {
        oTh.addEventListener("click", twTriTableau, false);
        oTh.setAttribute("data-pos", nI);
        if(oTh.getAttribute("data-tri")=="1") {
         oTh.innerHTML += "<i class=\"fa fa-sort-amount-desc\" aria-hidden=\"true\"></i>";
        } else {
          oTh.setAttribute("data-tri", "0");
          oTh.innerHTML += "<i class=\"fa fa-sort-amount-asc\" aria-hidden=\"true\"></i>";
        }
        // Tri par d�faut
        if (oTh.className=="selection") {
          oTh.click();
        }
        nI++;
      });
    });
  }
  
  function twInit() {
    twInitTableau();
  }
  function twPret(maFonction) {
    if (document.readyState != "loading"){
      maFonction();
    } else {
      document.addEventListener("DOMContentLoaded", maFonction);
    }
  }
  twPret(twInit);

  function twTriTableau() {
    // Ajuste le tri
    var nBoolDir = this.getAttribute("data-tri");
    this.setAttribute("data-tri", (nBoolDir=="0") ? "1" : "0");
    // Supprime la classe � selection � de chaque colonne.
    [].forEach.call( this.parentNode.querySelectorAll("th"), function(oTh) {oTh.classList.remove("selection");});
    // Ajoute la classe � selection � � la colonne cliqu�e.
    this.className = "selection";
    // Ajuste la fl�che
    this.querySelector("i").className = (nBoolDir=="0") ? "fa fa-sort-amount-desc" : "fa fa-sort-amount-asc";

    // Construit la matrice
    // R�cup�re le tableau (tbody)
    var oTbody = this.parentNode.parentNode.parentNode.getElementsByTagName("tbody")[0]; 
    var oLigne = oTbody.rows;
    var nNbrLigne = oLigne.length;
    var aColonne = new Array(), i, j, oCel;
    for(i = 0; i < nNbrLigne; i++) {
      oCel = oLigne[i].cells;
      aColonne[i] = new Array();
      for(j = 0; j < oCel.length; j++){
        aColonne[i][j] = oCel[j].innerHTML;
      }
    }

    // Trier la matrice (array)
    // R�cup�re le num�ro de la colonne
    var nIndex = this.getAttribute("data-pos");
    // R�cup�re le type de tri (num�rique ou par d�faut � local �)
    var sFonctionTri = (this.getAttribute("data-type")=="num") ? "compareNombres" : "compareLocale";
    // Tri
    aColonne.sort(eval(sFonctionTri));
    // Tri num�rique
    function compareNombres(a, b) {return a[nIndex-1] - b[nIndex-1];}
    // Tri local (pour support utf-8)
    function compareLocale(a, b) {return a[nIndex-1].localeCompare(b[nIndex-1]);}
    // Renverse la matrice dans le cas d�un tri descendant
    if (nBoolDir==0) aColonne.reverse();
    
    // Construit les colonne du nouveau tableau
    for(i = 0; i < nNbrLigne; i++){
      aColonne[i] = "<td>"+aColonne[i].join("</td><td>")+"</td>";
    }

    // assigne les lignes au tableau
    oTbody.innerHTML = "<tr>"+aColonne.join("</tr><tr>")+"</tr>";
  }


