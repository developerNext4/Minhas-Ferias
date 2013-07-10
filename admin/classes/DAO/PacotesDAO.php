<?php
   require_once("classe.conexao.php");
   class PacotesDAO extends conexao{


		function PacotesDAO(){
			$this->conexao();
		}
		
		function ler($id){
			$this->sql("SELECT * FROM tb_pacote WHERE PCT_ID = '$id'");
			$linha = $this->linha();
			
			return $linha;
		}
		
		function listar(){
			// DEFINIÇÃO DE VARIÁVEIS //
			$aDados	= array();
			$iCont	= 0;
		
			// INICIANDO A CONSTRUÇÃO DA QUERY //
			$sSQL = "SELECT * FROM TB_PLANO WHERE PCT_STATUS = '1'";
	
			// EXECUTANDO A QUERY //
			$this->sql( $sSQL );
			
			while( $linha = $this->linha() ){
								
				$aDados[] = $linha;
				$iCont++;
			}
			
			return $aDados;
		}
      
		function insert( $arrValores ){
			
			$lastId = $this->inserir( "tb_pacote", $arrValores );
			
			return $lastId;
		}
		
		
		function update( $arrValores, $id ){
			$strCondicao = " PCT_ID = '" . $id . "' ";
			
			$this->alterar( "tb_pacote", $arrValores, $strCondicao );
			
			return true;
		}
      
		function getWhere(  ){
			$sWhere = " WHERE PCT_STATUS IN ('1','2') ";
			
						
			return $sWhere;
		}
		
		function getQueryCount(){
			$sQryCount = NULL;
			$sQryCount = "SELECT COUNT(*) AS QTDE FROM tb_pacote  " . $this->getWhere(  );

			return $sQryCount;
		}
		
   }
?>