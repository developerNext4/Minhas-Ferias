<?php
// template

if( !class_exists("template") ) {

	class template{
	
		function template( $arquivo = null ){
			
			$abre = "<!--inicio-->";
			$fecha= "<!--fim-->";
			if( !is_null( $arquivo ) ){
				if( file_exists( $arquivo )){
					$this->_TEMPLATE = implode( "" , file( $arquivo ) );
	
					$i = substr_count( $this->_TEMPLATE, $abre );
					$f = substr_count( $this->_TEMPLATE, $fecha );
					if( $i != 0 && $f != 0 ){
						$inicio = strpos( $this->_TEMPLATE, $abre) + strlen($abre);
						$fim = strpos( $this->_TEMPLATE, $fecha);
						$this->sub_template = substr( $this->_TEMPLATE, $inicio , $fim - $inicio);
	
						$this->_TEMPLATE = trim( $this->sub_template );
					}
				}else{
					echo "<pre> Arquivo <strong>" . $arquivo . "</strong> inexistente! </pre>";exit;
				}
			}
		}
		
		function load_string($string){
			$this->_TEMPLATE = $string;
		}
		
		/**
		 * Funcao de subistituicao de arrays no template, podendo trabalhar com arrays multi-dimensionais
		 * formato de uma array multidimensional para trabalhar
		 * array(array(array(valores)));
		 *
		 * @param String $chave_tpl
		 * @param Resource Link $result
		 * @param String $msgErro
		 * @return Boolean
		 */
		public function addChaveMulti($chave_tpl, $result, $msgErro = null){
			if (is_array($result)) {
				$abre = "<!--TI:".$chave_tpl."-->";
				$fecha= "<!--TF:".$chave_tpl."-->";
				$inicio = strpos( $this->_TEMPLATE, $abre) + strlen($abre);
				$fim = strpos( $this->_TEMPLATE, $fecha);
				if ((strpos( $this->_TEMPLATE, $abre)) && (strpos( $this->_TEMPLATE, $fecha))) {
					$tam = $fim - $inicio + strlen($fecha) + strlen($abre);
					$this->sub_template = substr ( $this->_TEMPLATE, $inicio , $fim - $inicio);
					$tpl_out2 = "";
					if(is_array($result)){
						if (count($result) > 0) {
							foreach($result as $chaves){
								$tpl_out = $this->sub_template;
								foreach($chaves as $chave => $valor ){
									if (!is_array($valor))
										$tpl_out = preg_replace("(<!--" . $chave . "-->)", $valor, $tpl_out);
									else {
										$tpl_temp = new TEMPLATE();
										$tpl_temp->load_string($tpl_out);
										$tpl_temp->addChaveMulti("sub_" . $chave_tpl, $valor, $msgErro);
										$tpl_out = $tpl_temp->pega();
									}
								}
								$tpl_out2 .= $tpl_out;
							}
						} else
							$tpl_out2 = !is_null($msgErro) ? $msgErro : "";
					}else if(is_resource($result)){
						while($chaves = mysql_fetch_array($result)){
							$tpl_out = $this->sub_template ;
							foreach($chaves as $chave=>$valor ){
								//$tpl_out = ereg_replace("<!--" . $chave . "-->", $valor, $tpl_out );
								$tpl_out = preg_replace("(<!--" . $chave . "-->)", $valor, $tpl_out );
							}
							$tpl_out2 = $tpl_out;
						}
					}
					$this->_TEMPLATE = substr_replace( $this->_TEMPLATE, $tpl_out2, $inicio - strlen($abre) , $tam);
					
					//Re-chamar a funcao para fazer mais replaces, caso existam.
					$this->addChaveMulti($chave_tpl, $result, $msgErro);
				}
			}
			return true;
		}
		
		function addChaveRecursiva( $chave, $result ){
	
			$abre = "<!--TI:".$chave."-->";
			$fecha= "<!--TF:".$chave."-->";
			$inicio = strpos( $this->_TEMPLATE, $abre) + strlen($abre);
			$fim = strpos( $this->_TEMPLATE, $fecha);
			$tam = $fim - $inicio + strlen($fecha) + strlen($abre);
			$this->sub_template = substr ( $this->_TEMPLATE, $inicio , $fim - $inicio);
			$tpl_out2 = "";
	
			if(is_array($result)){
				foreach($result as $chaves){
					$tpl_out = $this->sub_template ;
					foreach($chaves as $chave=>$valor ){
						if( is_resource($valor) || is_array($valor) ){
							$this->sub = new TEMPLATE();
							$this->sub->insereConteudo( "<!--TI:".$chave."-->".$this->pegaChaveMulti( $chave )."<!--TF:".$chave."-->" );
							$this->sub->addChaveMulti( $chave, $valor );
							$tpl_out = $this->trocaChaveMulti( $chave, $this->sub->pega(), $tpl_out );
							
						}else{
							//$tpl_out = ereg_replace("<!--" . $chave . "-->", $valor, $tpl_out );
							$tpl_out = preg_replace("(<!--" . $chave . "-->)", $valor, $tpl_out );
						}
					}
					$tpl_out2 .= $tpl_out;
				}
			}else if(is_resource($result)){
				while($chaves = mysql_fetch_array($result)){
					$tpl_out = $this->sub_template ;
					foreach($chaves as $chave=>$valor ){
						//$tpl_out = ereg_replace("<!--" . $chave . "-->", $valor, $tpl_out );
						$tpl_out = preg_replace("(<!--" . $chave . "-->)", $valor, $tpl_out );
					}
					$tpl_out2 .= $tpl_out;
				}
			}
			$this->_TEMPLATE = substr_replace( $this->_TEMPLATE, $tpl_out2, $inicio - strlen($abre) , $tam);
			return true;
		}
	
		function delChaveMulti($chave){
			$abre = "<!--TI:".$chave."-->";
			$fecha= "<!--TF:".$chave."-->";
			$inicio = strpos( $this->_TEMPLATE, $abre);
			$fim = strpos( $this->_TEMPLATE, $fecha);
			$tam = $fim - $inicio + strlen($fecha);
			$this->_TEMPLATE = substr_replace( $this->_TEMPLATE, "", $inicio , $tam);
			return true;
		}
	
		function addChave( $chave , $valor ){
			//$this->_TEMPLATE = ereg_replace("<!--" . $chave . "-->", strval( $valor ), $this->_TEMPLATE);
			$this->_TEMPLATE = preg_replace("(<!--" . $chave . "-->)", strval( $valor ), $this->_TEMPLATE);
			return(true);
		}
	
		function trocaChaveMulti($chave, $conteudo, $template){
			$abre = "<!--TI:".$chave."-->";
			$fecha= "<!--TF:".$chave."-->";
			$inicio = strpos( $template, $abre);
			$fim = strpos( $template, $fecha);
			$tam = $fim - $inicio + strlen($fecha);
			return substr_replace( $template, $conteudo, $inicio , $tam);
		}
	
		function pegaChaveMulti($chave){
			$abre = "<!--TI:".$chave."-->";
			$fecha= "<!--TF:".$chave."-->";
			$inicio = strpos( $this->_TEMPLATE, $abre) + strlen($abre);
			$fim = strpos( $this->_TEMPLATE, $fecha);
			$tam = $fim - $inicio;
			return substr( $this->_TEMPLATE, $inicio , $tam);
		}
	
		function insereConteudo( $conteudo ){
			$this->_TEMPLATE = $conteudo;
		}
	
		function pega() {
			return	$this->_TEMPLATE;
		}
	
		function mostra()  {
			echo $this->_TEMPLATE;
		}
	}
}
?>