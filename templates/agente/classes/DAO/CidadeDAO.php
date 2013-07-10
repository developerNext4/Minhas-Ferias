<?php
   require_once("classe.conexao.php");
   class CidadeDAO extends conexao{


		function CidadeDAO(){
			$this->conexao();
		}
			
		function listarCidade( $UF_ID ){
	         $this->sql( "SELECT *
			 		FROM TB_CIDADE AS C WHERE UF_ID = $UF_ID ORDER BY CIDADE_DESCRICAO" );
	         $arr=array();
			 $iCont=0;
			 
	         while( $linha = $this->linha() ){
			 	if( $iCont % 2 == 0 ){ $linha['class'] = 'par'; }
				else{ $linha['class'] = 'impar'; }
			 
	            $arr[] = $linha;
				$iCont++;
	         }
			 
	         return $arr;
		}
   }
?>