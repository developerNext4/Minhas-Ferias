<?php
	/******** CHANGELOG:: classe.conexao.php
		Autor:	Wagner Lingenover
		Data:	11/10/2008 
		O que?:	alterado a função sql(). adicionando um RETURN para a função. a cada requisição da mesma retornará um true ou false para as solicitações de INSERT ou UPDATE.
		--------------------------------- 
	
		Autor:	luiz	
		Data:	19/10/2008
		O que?:	adicionado return na funcao alterar
		--------------------------------- 
	
		Autor:	Wagner	
		Data:	06/11/2008
		O que?:	alterado os 'for' das funções de addEmpresa() e updEmpres()
		--------------------------------- 
	
		Autor:	
		Data:	
		O que?:	
	********************/
	
	class conexao{
		
		var $mysql_host	= "localhost";
		var $mysql_user	= "minhas_ferias";
		var $mysql_password	= "acesso123";
		var $conexao		= "";
		var $mysql_bd		= "admin_minhasferias";

		function conexao(){
			$this->conn = @mysql_connect( $this->mysql_host, $this->mysql_user, $this->mysql_password ) or die (".:: Não foi possível Conectar-se ao Banco de Dados ::.");
			mysql_select_db( $this->mysql_bd,$this->conn );
		}
	
		function sql( $sql ){
			
			$this->resultado = mysql_query( $sql ) or die( "Erro ao executar SQL <BR>" . $sql . "" . mysql_error() );
			if( $this->resultado || count( $this->resultado ) > 0 ){
				return true;
			}else{
				return false;
			}
		}
	   
	   function cata($campo,$tabela,$con1,$con2){
		  $pr=mysql_fetch_array(mysql_query("select $campo from $tabela where $con1='$con2'"));
		  $x=$pr[0];
		  return($x);
	   }
	   
	  // Busca o resultado de uma linha e a retorna em um array associativa ( $ar['nome']) ou numerico ( $ar[0] )
	   function linha(){
		 $linha = mysql_fetch_array( $this->resultado );
	
		 return $linha;
	   }
		function registros(){
		  $nro=mysql_num_rows($this->resultado);
	
		  return $nro;
		}
	  //
	  
	  
	   function inserir($tabela,$valores){
			$sql = "INSERT INTO $tabela (";
			$campos = array_keys( $valores );
			
			for( $i = 0; $i < count( $campos ); $i++ ){
				$sql.= $campos[$i] . ( $i != count( $campos ) - 1 ? "," : ")" );
			}
			
			$sql .= " VALUES (";
			for( $i = 0; $i < count( $campos ); $i++ ){
				$sql .= "'" . utf8_decode($valores[$campos[$i]]) . ( $i != count( $campos ) - 1 ? "'," : "')" );
			}
			
			$this->sql($sql);
			return mysql_insert_id();
	   }
	   
		function alterar( $tabela, $valores, $CRR_ID ){
			$sql = "UPDATE $tabela SET ";
			
			$campos = array_keys( $valores );
			
			for( $i = 0; $i < count( $campos ); $i++ ){
				$sql .= $campos[$i] . " = '" . utf8_decode($valores[$campos[$i]]).( $i != count( $campos ) - 1 ? "', " : "' " );
			}
		
			$sql .= "WHERE " . $CRR_ID . "";
			
			return $this->sql( $sql );
		}
	
	   function excluir($tabela,$condicao){
		  $sql = "DELETE FROM $tabela WHERE $condicao ";
	
		  $this->sql($sql);
	   }
	}
?>