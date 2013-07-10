<?php
   require_once("classe.conexao.php");
   class UsuarioDAO extends conexao{


		function UsuarioDAO(){
			$this->conexao();
		}
		
		function ler($id){
			$this->sql("SELECT * FROM tb_usuario WHERE USR_ID = '$id'");
			$linha = $this->linha();
			
			return $linha;
		}
		
		function listar(){
			// DEFINIวรO DE VARIมVEIS //
			$aDados	= array();
			$iCont	= 0;
		
			// INICIANDO A CONSTRUวรO DA QUERY //
			$sSQL = "SELECT * FROM TB_PLANO WHERE PLN_STATUS = '1'";
	
			// EXECUTANDO A QUERY //
			$this->sql( $sSQL );
			
			while( $linha = $this->linha() ){
								
				$aDados[] = $linha;
				$iCont++;
			}
			
			return $aDados;
		}
      
		function insertAgente( $arrValores ){
			
			$lastId = $this->inserir( "tb_usuario", $arrValores );
			
			return $lastId;
		}
		
		function insertCliente( $arrValores ){
			
			$lastId = $this->inserir( "tb_usuario", $arrValores );
			
			return $lastId;
		}
		
		function update( $arrValores, $id ){
			$strCondicao = " USR_ID = '" . $id . "' ";
			
			$this->alterar( "tb_usuario", $arrValores, $strCondicao );
			
			return true;
		}
      
		function getWhere( $PLN_DESCRICAO = "", $PLN_STATUS = "T" ){
			$sWhere = " WHERE 1 ";
			
			// Verifica em quais campos a pesquisa serแ efetuada //
				if($PLN_DESCRICAO != NULL || $PLN_DESCRICAO != ""){
					$sWhere .= " AND PLN_DESCRICAO LIKE '%" . $PLN_DESCRICAO . "%'";
				}
				if($PLN_STATUS != "T"){		
					$sWhere .= " AND PLN_STATUS = '".$PLN_STATUS."'";	
				}
			// ================================================= //
						
			return $sWhere;
		}
		
		function getQueryCount($PLN_DESCRICAO = NULL, $PLN_STATUS = "T"){
			$sQryCount = NULL;
			$sQryCount = "SELECT COUNT(*) AS QTDE FROM TB_PLANO  " . $this->getWhere( $PLN_DESCRICAO, $PLN_STATUS );

			return $sQryCount;
		}
				
   }
?>