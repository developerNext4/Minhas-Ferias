<?php

/*ini_set('display_errors','Off'); 
// Report all PHP errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
echo ini_set('error_reporting', E_ALL);

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
<script src="templates/registrado/js/bootstrap.js"></script>
<link href="templates/registrado/css/bootstrap.min.css" rel="stylesheet">
<link href="templates/registrado/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="templates/registrado/css/custom.css" rel="stylesheet">
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
      if($blocos->bloco("detalhesPedidoCotacao")){
        $blocos->blocoview("detalhesPedidoCotacao");
      }
	   if($blocos->bloco("detalhesPedidoCotacaoCarrousel")){
        $blocos->blocoview("detalhesPedidoCotacaoCarrousel");
      }
	  if($blocos->bloco("convidarAmigos")){
        $blocos->blocoview("convidarAmigos");
      }
    ?>
    <div class="span5 contentLeft">
       
      	<?php
          if($blocos->bloco("principal")){
              $blocos->blocoview("principal");
            }

            if($blocos->bloco("atualizarCadastro")){
              $blocos->blocoview("atualizarCadastro");
            }
			
			if($blocos->bloco("destinoCadastrado")){
              $blocos->blocoview("destinoCadastrado");
            }
			
			
        ?>   
      
    </div><!--Fecha contentLeft-->
    
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
</div><!-- Essa esse e o final da div class="row wrap_admin"-->