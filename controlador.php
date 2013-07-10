<?php
session_start();

defined( 'exe@8548@5498735__' ) or die( 'Voce nao tem direito de acessar esta pagina' );

class principal{

protected $url = null;
protected $navegacao = null;



/*construir as páginas */

public function __construct($navegacaovalor = "front"){

if(isset($_COOKIE["USR_ID"])){
	if ($_COOKIE["USR_ID"] != NULL){
		$_SESSION['USR_ID'] = $_COOKIE["USR_ID"];
		$_SESSION['USR_NOME'] = $_COOKIE["USR_NOME"];
		$_SESSION['USR_TIPO'] = $_COOKIE["USR_TIPO"];
		$_SESSION['PAINEL'] = $_COOKIE["PAINEL"];
	}
}

if (isset ($_SESSION['USR_NOME']) && isset ($_SESSION['PAINEL']) && $_SESSION["USR_TIPO"] == "1"){
	$navegacaovalor = "registrado";
}

if (isset ($_SESSION['USR_NOME']) && isset ($_SESSION['PAINEL']) && $_SESSION["USR_TIPO"] == "2"){
	$navegacaovalor = "agente";
}

if ($_GET["pg"] == 8 || $_GET["pg"] == 9 || $_GET["pg"] == 10 || $_GET["pg"] == 11){
	$navegacaovalor = "front";
}

//tetermina diretorio principal
$this->navegacao = $navegacaovalor;

	if($navegacaovalor== "registrado"){

		$this->url = "templates/registrado";

	}else if ($navegacaovalor== "agente"){
	
		$this->url = "templates/agente";
	
	}else{

		$this->url = "templates";

	}
} 
public function exibirpagina($nomedapagina){
 
return require_once($this->url."/blocos/".$nomedapagina.".php");

}

/*Exibir conteúdo*/

public function show(){

return require_once($this->url."/index.php");
}


}

?>