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
			

			$this->pgDefined =array(1=>array("principal","top","bottom"), 
									2=>array("destinoCadastrado", "top" ,"bottom"), 
									3=>array("atualizarCadastro", "top" ,"bottom"),
									4=>array("convidarAmigos", "top" ,"bottom"),
									5=>array("detalhesPedidoCotacao", "top" ,"bottom"),
									6=>array("detalhesPedidoCotacaoCarrousel", "top" ,"bottom"));


		}



		}else{

		$this->pg = "paginainicial";

		$this->pgDefined = array("principal","top","bottom","menuCliente");

		}



/*
		fim da estrução

*/


}elseif ($this->navegacao == "agente"){
/*

caso o clientes steja logado

*/

/*cria a regra de blocos e restringe acesso direto as gets*/
	if(isset($_GET["pg"]))
		{

			$this->pg = $_GET["pg"]; 


		

	if(is_numeric($this->pg))
		{
			

			$this->pgDefined =array(1=>array("menuAgente", "principal","top","bottom"), 
									2=>array("menuAgente", "atualizarCadastroAgente","top" ,"bottom"), 
									3=>array("menuAgente", "propostasEfetuadas","top" ,"bottom"), 
									4=>array("menuAgente", "detalhesPedidoCotacao","top" ,"bottom"),
									5=>array("menuAgente", "visualizarScore","top" ,"bottom"),
									6=>array("menuAgente", "minhaConta","top" ,"bottom"));


		}



		}else{

		$this->pg = "paginainicial";

		$this->pgDefined = array("menuAgente", "principal","top","bottom");

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
									5=>array("blocoheader", "vazio" , "esqueciSenha", "blocofooteresquerdo"),
									6=>array("blocoheader", "vazio" , "recuperarSenha", "blocofooteresquerdo"),
									7=>array("blocoheader", "vazio" , "reenviarConfirmacao", "blocofooteresquerdo"),
									8=>array("blocoheader", "vazio" , "sobreSite", "blocofooteresquerdo"), 
									9=>array("blocoheader", "vazio" , "perguntasFrequentes", "blocofooteresquerdo"),
									10=>array("blocoheader", "vazio" , "termosUso", "blocofooteresquerdo"),
									11=>array("blocoheader", "vazio" , "contato", "blocofooteresquerdo"));


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