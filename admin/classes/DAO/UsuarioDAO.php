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
			// DEFINIÇÃO DE VARIÁVEIS //
			$aDados	= array();
			$iCont	= 0;
		
			// INICIANDO A CONSTRUÇÃO DA QUERY //
			$sSQL = "SELECT * FROM tb_usuarios";
	
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
			
						
			return $sWhere;
		}
		
		function getQueryCount($PLN_DESCRICAO = NULL, $PLN_STATUS = "T"){
			$sQryCount = NULL;
			$sQryCount = "SELECT COUNT(*) AS QTDE FROM tb_usuario  " . $this->getWhere( $PLN_DESCRICAO, $PLN_STATUS );

			return $sQryCount;
		}
				
   }
?>