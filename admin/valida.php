<?php

	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
  		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
		session_destroy();
		session_start();
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO 		= new UtilsDAO();
	// ==================== //
	
	// Declaraчуo de variсveis //
		$ADM_USUARIO	= ( isset( $_REQUEST['Email'] ) ) ? $_REQUEST['Email'] : null;
		$ADM_SENHA	= ( isset( $_REQUEST['Senha'] ) ) ? $_REQUEST['Senha'] : null;
	// ======================= //

	// Valido usuсrio //
		$uQry = mysql_query ("SELECT * FROM tb_administrador WHERE ADM_USUARIO = '" . addslashes( $ADM_USUARIO ) . "'");
		if (mysql_num_rows($uQry) > 0){
			$hQry = mysql_query("SELECT * FROM tb_administrador WHERE ADM_USUARIO = '" . addslashes( $ADM_USUARIO ) . 
								"' AND ADM_SENHA = MD5('" . addslashes( $ADM_SENHA ) . "')");
			if (mysql_num_rows($hQry) > 0){
				$jQry = mysql_fetch_array ($hQry);
				
				if ($jQry["ADM_STATUS"] == "1"){
					header( "Location: index.php"  );
				}else if ($jQry["ADM_STATUS"] == "2"){
					header( "Location: index.php?login=1"  );
					exit();
				}else{
					header( "Location: index.php?login=3"  );
					exit();
				} 
				
				// Gravo sessуo e redireciono para o painel
				$_SESSION["ADM_ID"] = $jQry["ADM_ID"];
				$_SESSION["ADM_NOME"] = utf8_encode ($jQry["ADM_NOME"]);
				$_SESSION["ADM_TIPO"] = $jQry["ADM_TIPO"];
				$_SESSION["PAINEL"]	= 1;

			}else{
				// Redireciono para o login
				header( "Location: index.php?login=2"  );
			}
		}else{
			header( "Location: index.php?login=4"  );
		}
	// ============== //
?>