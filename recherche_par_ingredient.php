<?php

require 'Controleur/controlleur.php';
session_start();
$ingredients = touts_les_ingredients($bdd);

require_once 'Vue/recherche_par_ingredient.php';


