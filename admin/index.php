<?php

//ini_set('display_errors','Off');
// define segurança 

define('exe@8548@5498735__', 1);

//

define('__ROOT__', dirname(__FILE__)); 
//define('__ROOT__',  'http://'.$_SERVER['SERVER_NAME'].'/minhas_ferias');




//solicita instrução do controlador
include_once("controlador.php");


/* criar regras para usuários */

// chama o controlador - falso se usuário não está locado - verdadeiro se estiver

$exibirPai = new principal();


// exibi página

$exibirPai->show();





?>