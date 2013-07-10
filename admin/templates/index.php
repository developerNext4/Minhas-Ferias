<?php

/*define segurança */

defined( 'exe@8548@5498735__' ) or die( 'Voce não tem direito de acessar esta pagina' );

include_once('model.php');

$blocos = new Blocos();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<title>Minhas Ferias</title>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" >
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="templates/js/bootstrap.js"></script>
<script src="templates/js/functions.js"></script>
<link href="templates/css/bootstrap.min.css" rel="stylesheet">
<link href="templates/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="templates/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>
<!--[if IE 8]>
<link href="css/ie8.css" rel="stylesheet">
<![endif]-->
</head>



<?php

// condicional para os blocos

if($blocos->bloco("blocoheader")){




$blocos->blocoview("blocoheader");

}


?>


<div class="principal">


<?php
if($blocos->bloco("cadastroAgente")){
	$blocos->blocoview("cadastroAgente");
}
?>

<?php
if($blocos->bloco("cadastroCliente")){
	$blocos->blocoview("cadastroCliente");
}
?>

<?php
if($blocos->bloco("confirmarCadastro")){
	$blocos->blocoview("confirmarCadastro");
}
?>

<?php
if($blocos->bloco("recuperarSenha")){
	$blocos->blocoview("recuperarSenha");
}
?>

<?php
if($blocos->bloco("reenviarConfirmacao")){
	$blocos->blocoview("reenviarConfirmacao");
}
?>

<?php
if($blocos->bloco("sobreSite")){
	$blocos->blocoview("sobreSite");
}
?>

<?php
if($blocos->bloco("perguntasFrequentes")){
	$blocos->blocoview("perguntasFrequentes");
}
?>

<?php
if($blocos->bloco("termosUso")){
	$blocos->blocoview("termosUso");
}
?>

<?php
if($blocos->bloco("contato")){
	$blocos->blocoview("contato");
}
?>

<?php
if($blocos->bloco("esqueciSenha")){
	$blocos->blocoview("esqueciSenha");
}
?>

<?php

// condicional para os blocos
if($blocos->bloco("bloco_principal")){
	$blocos->blocoview("bloco_principal");
}

?>

</div>


<?php

if($blocos->bloco("blocofooteresquerdo")){

$blocos->blocoview("blocofooteresquerdo");

}


?>





