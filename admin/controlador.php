<?php
session_start();
//seguranca

defined( 'exe@8548@5498735__' ) or die( 'Voce nao tem direito de acessar esta pagina' );

class principal{

protected $url = null;
protected $navegacao = null;



/*construir as páginas */

public function __construct($navegacaovalor = "front"){

if (isset ($_SESSION['ADM_NOME']) && isset ($_SESSION['PAINEL'])){
	$navegacaovalor = "agente";
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