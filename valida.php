<?php
	session_start();

	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
  		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
		
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO 		= new UtilsDAO();
		$oCriarDestinoDAO= new CriarDestinoDAO();
	// ==================== //
	
	// Declaraчуo de variсveis //
		$USR_EMAIL	= ( isset( $_REQUEST['Email'] ) ) ? $_REQUEST['Email'] : null;
		$USR_SENHA	= ( isset( $_REQUEST['Senha'] ) ) ? $_REQUEST['Senha'] : null;
		$CONECTADO  = ( isset( $_REQUEST['Conectado'] ) ) ? $_REQUEST['Conectado'] : null;
	// ======================= //

	// Valido usuсrio //
		$uQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_EMAIL = '" . addslashes( $USR_EMAIL ) . "'");
		if (mysql_num_rows($uQry) > 0){
			$hQry = mysql_query("SELECT * FROM tb_usuario WHERE USR_EMAIL = '" . addslashes( $USR_EMAIL ) . 
								"' AND USR_SENHA = MD5('" . addslashes( $USR_SENHA ) . "')");
			if (mysql_num_rows($hQry) > 0){
				$jQry = mysql_fetch_array ($hQry);
				
				$msgTxt = NULL;
				if ($jQry["USR_STATUS"] == "1"){
					if (isset ($_SESSION["CTC_AEREO"])){
						if ($jQry["USR_TIPO"] == "1"){
							// Crio o pedido de cotaчуo
							$oCriarDestinoDAO->criarPedidoNaoLogado($jQry['USR_ID'],$jQry['USR_NOME'], $jQry['USR_EMAIL'],1);
							$msgTxt = "&msgTxt=1";
						} 
					}
					if ($CONECTADO == "1"){
						setcookie("USR_ID", $jQry["USR_ID"],time()+2343600);
						setcookie("USR_NOME", utf8_encode ($jQry["USR_NOME"]),time()+2343600);
						setcookie("USR_TIPO", $jQry["USR_TIPO"],time()+2343600);
						setcookie("PAINEL", 1,time()+2343600);
					}
					// Gravo sessуo e redireciono para o painel
					$_SESSION["USR_ID"] = $jQry["USR_ID"];
					$_SESSION["USR_NOME"] = utf8_encode ($jQry["USR_NOME"]);
					$_SESSION["USR_TIPO"] = $jQry["USR_TIPO"];
					$_SESSION["PAINEL"]	= 1;
					
					header( "Location: index.php?pg=1$msgTxt"  );
				}else if ($jQry["USR_STATUS"] == "2"){
					header( "Location: index.php?login=1"  );
					exit();
				}else{
					header( "Location: index.php?login=3"  );
					exit();
				} 
				
				

			}else{
				// Redireciono para o login
				header( "Location: index.php?login=2"  );
			}
		}else{
			header( "Location: index.php?login=4"  );
		}
	// ============== //
?>