<?php
/* segurança */

defined( 'exe@8548@5498735__' ) or die( 'Voce não tem direito de acessar esta pagina' );

/*pega dados do controlador */

include_once("controlador.php");

class Blocos extends principal{

	//variavel para determinar blocos e páginas

protected $pgDefined = null;

// variavel para pegar a página

protected $pg = null;

// nome do bloco





 public function __construct()
	{
		parent::__construct();
			



if($this->navegacao == "registrado"){

/*

caso o clientes steja logado

*/

/*cria a regra de blocos e restringe acesso direto as gets*/
	if(isset($_GET["pg"]))
		{

			$this->pg = $_GET["pg"]; 


		

	if(is_numeric($this->pg))
		{
			
			$this->pgDefined =array(1=>array("destino","top","bottom"), 
									2=>array("bloco_paginas", "top" ,"bottom"), 
									3=>array("vazio", "top" ,"bottom"), 
									4=>array("vazio", "top" ,"bottom"));


		}



		}else{

		$this->pg = "paginainicial";

		$this->pgDefined = array("destino","top","bottom");

		}



/*
		fim da estrução

*/


}else{

   /*cria a regra de blocos e restringe acesso direto as gets*/
	if(isset($_GET["pg"]))
		{

			$this->pg = $_GET["pg"]; 


		

	if(is_numeric($this->pg))
		{
			

			$this->pgDefined =array(1=>array("blocoheader","bloco_principal","blocodireito", "blocofooteresquerdo"), 
									2=>array("blocoheader", "vazio" , "cadastroCliente", "blocofooteresquerdo"), 
									3=>array("blocoheader", "vazio" , "cadastroAgente", "blocofooteresquerdo"), 
									4=>array("blocoheader", "vazio" , "confirmarCadastro", "blocofooteresquerdo"),
									5=>array("blocoheader", "vazio" , "esqueciSenha", "blocofooteresquerdo"));


		}



		}else{

		$this->pg = "paginainicial";

		$this->pgDefined = array("blocoheader","bloco_principal","blocodireito", "blocofooteresquerdo");

		}


	}


	}



/* verifica se o link é atual e determina uma classe para ele. - solução otima para o menu.*/

function get_current($name) {
  if (strpos($_SERVER['REQUEST_URI'], $name) !== false)
    echo 'class="active"';
}



//verifica se o bloco é validado para página

public function bloco($nomebloco){

	$paginaret = false;


if($this->pg != "paginainicial"){


foreach($this->pgDefined[$this->pg] as $blocopg){

	if($blocopg == $nomebloco){


		$paginaret = true;

		break;	
	
	}else{
			$paginaret = false;

	}

		
}



}else{


foreach($this->pgDefined as $blocopg){

	if($blocopg == $nomebloco){

		


		$paginaret = true;

		break;
	
	}


}




}

return $paginaret;



}

/* exibe na página determinada */
public function blocoview($nomebloco){


//pega a url feita no controlador exibi no html do template

if($nomebloco != null){
 parent::exibirpagina($nomebloco);
}else{

	echo"pagina nao determinada";
}


}






}




?>