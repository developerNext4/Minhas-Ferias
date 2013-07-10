<?php

/*ini_set('display_errors','On'); 
// Report all PHP errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
echo ini_set('error_reporting', E_ALL);*/

defined( 'exe@8548@5498735__' ) or die( 'Voce não tem direito de acessar esta pagina' );
//echo  $_SERVER['SERVER_NAME'];
//echo __ROOT__;*/
include_once('model.php');

$blocos = new Blocos();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="utf-8">
<title>Minhas Ferias</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="templates/agente/js/bootstrap.js"></script>
<link href="templates/agente/css/bootstrap.min.css" rel="stylesheet">
<link href="templates/agente/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="templates/agente/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
<!--[if IE 8]>
<link href="css/ie8.css" rel="stylesheet">
<![endif]-->
</head>
<?php

// condicional para os blocos

if($blocos->bloco("top")){

$blocos->blocoview("top");

}

?>

<div class="row wrap_admin">
  <div class="container">
<?php

if($blocos->bloco("menuAgente")){
	$blocos->blocoview("menuAgente");
}

// condicional para os blocos
if($blocos->bloco("principal")){
	$blocos->blocoview("principal");
}

if($blocos->bloco("sobreSite")){
	$blocos->blocoview("sobreSite");
}

if($blocos->bloco("termos")){
	$blocos->blocoview("termos");
}

if($blocos->bloco("pacotes")){
	$blocos->blocoview("pacotes");
}

if($blocos->bloco("inserirPacotes")){
	$blocos->blocoview("inserirPacotes");
}

if($blocos->bloco("leads")){
	$blocos->blocoview("leads");
}

if($blocos->bloco("redesSociais")){
	$blocos->blocoview("redesSociais");
}

if($blocos->bloco("video")){
	$blocos->blocoview("video");
}

if($blocos->bloco("usuarios")){
	$blocos->blocoview("usuarios");
}

if($blocos->bloco("pedidos")){
	$blocos->blocoview("pedidos");
}

if($blocos->bloco("destinos")){
	$blocos->blocoview("destinos");
}

if($blocos->bloco("inserirDestino")){
	$blocos->blocoview("inserirDestino");
}
?>
    <div class="span7 contentLeft">
      <div class="contDescricao"> 
      	
      </div>
      <!--Fecha Conte descriçao-->
      
      <div class="gridCarrocel"> </div>
      <!--Obs: nessa div sera inserido o esquema de carroucel ou listagem simples -->
      
      <div class="boxTable"> </div>
      <!--Inserir blocos--> 
      
    </div>
    <!--Fecha contentLeft-->
    
    <div class="span4 colRight"> </div>
    <!--coluna colRight--> 
    
  </div>
  <!--Fecha container 2º--> 
</div>
<!--row wrap_admin-->
<div class="wrap_adminBottom"></div>
<?php
// condicional para os blocos

if($blocos->bloco("bottom")){

$blocos->blocoview("bottom");

}


?>
