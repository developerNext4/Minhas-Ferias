<?php
   require_once("classe.conexao.php");
   class DestinoDAO extends conexao{


		function DestinoDAO(){
			$this->conexao();
		}
		
		function ler($id){
			$this->sql("SELECT * FROM tb_destino WHERE DST_ID = '$id'");
			$linha = $this->linha();
			
			return $linha;
		}
		
      
		function insert( $arrValores ){
			
			$lastId = $this->inserir( "tb_destino", $arrValores );
			
			return $lastId;
		}
		
		
		function update( $arrValores, $id ){
			$strCondicao = " DST_ID = '" . $id . "' ";
			
			$this->alterar( "tb_destino", $arrValores, $strCondicao );
			
			return true;
		}
      
		function getWhere(  ){
			$sWhere = "  WHERE DST_STATUS IN ('1','2')";
			
						
			return $sWhere;
		}
		
		function getQueryCount(){
			$sQryCount = NULL;
			$sQryCount = "SELECT COUNT(*) AS QTDE FROM tb_destino  " . $this->getWhere(  );

			return $sQryCount;
		}
		
   }
?>