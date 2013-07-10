<?php
   require_once("classe.conexao.php");
   class MinhaContaDAO extends conexao{


		function MinhaContaDAO(){
			$this->conexao();
		}
		
		function ler($id){
			$this->sql("SELECT * FROM tb_pagamento WHERE USR_ID = '$id'");
			$linha = $this->linha();
			
			return $linha;
		}
		
		function listar(){
			// DEFINIÇÃO DE VARIÁVEIS //
			$aDados	= array();
			$iCont	= 0;
		
			// INICIANDO A CONSTRUÇÃO DA QUERY //
			$sSQL = "SELECT * FROM TB_PLANO WHERE PLN_STATUS = '1'";
	
			// EXECUTANDO A QUERY //
			$this->sql( $sSQL );
			
			while( $linha = $this->linha() ){
								
				$aDados[] = $linha;
				$iCont++;
			}
			
			return $aDados;
		}
      
		function insert( $arrValores ){
			
			$lastId = $this->inserir( "tb_pagamento", $arrValores );
			
			return $lastId;
		}
		
		function insertProposta( $arrValores ){
			
			$lastId = $this->inserir( "tb_pagamento_proposta", $arrValores );
			
			return $lastId;
		}
		
		function update( $arrValores, $id ){
			$strCondicao = " CTC_ID = '" . $id . "' ";
			
			$this->alterar( "tb_pagamento", $arrValores, $strCondicao );
			
			return true;
		}
      
		function getWhere(  ){
			$sWhere = " WHERE USR_ID = '$_SESSION[USR_ID]' ";
			
						
			return $sWhere;
		}
		
		function getQueryCount(){
			$sQryCount = NULL;
			$sQryCount = "SELECT COUNT(*) AS QTDE FROM tb_pagamento  " . $this->getWhere(  );

			return $sQryCount;
		}
		
		
				
   }
?>