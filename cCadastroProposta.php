<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisi��es de Arquivos Externos //
		require_once( "./classes/DAO/UsuarioDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUsuario 		= new UsuarioDAO();
		$oCriarDestinoDAO= new CriarDestinoDAO();
		$oUtil 				= new Util();
	// ==================== //
	
	// Declara��o de vari�veis //
		$CPP_TRECHO_SIGLA1		= ( isset( $_REQUEST['CPP_TRECHO_SIGLA1'] ) ) ? $_REQUEST['CPP_TRECHO_SIGLA1'] : null;
		$CPP_TRECHO_SIGLA2		= ( isset( $_REQUEST['CPP_TRECHO_SIGLA2'] ) ) ? $_REQUEST['CPP_TRECHO_SIGLA2'] : null;
		$CPP_TRECHO_SIGLA3		= ( isset( $_REQUEST['CPP_TRECHO_SIGLA3'] ) ) ? $_REQUEST['CPP_TRECHO_SIGLA3'] : null;
		$CPP_TRECHO_SIGLA4		= ( isset( $_REQUEST['CPP_TRECHO_SIGLA4'] ) ) ? $_REQUEST['CPP_TRECHO_SIGLA4'] : null;
		$CPP_TRECHO_COMPANIA1	= ( isset( $_REQUEST['CPP_TRECHO_COMPANIA1'] ) ) ? $_REQUEST['CPP_TRECHO_COMPANIA1'] : null;
		$CPP_TRECHO_COMPANIA2	= ( isset( $_REQUEST['CPP_TRECHO_COMPANIA2'] ) ) ? $_REQUEST['CPP_TRECHO_COMPANIA2'] : null;
		$CPP_TRECHO_COMPANIA3	= ( isset( $_REQUEST['CPP_TRECHO_COMPANIA3'] ) ) ? $_REQUEST['CPP_TRECHO_COMPANIA3'] : null;
		$CPP_TRECHO_COMPANIA4	= ( isset( $_REQUEST['CPP_TRECHO_COMPANIA4'] ) ) ? $_REQUEST['CPP_TRECHO_COMPANIA4'] : null;
		$CPP_TRECHO_PARTIDA1	= ( isset( $_REQUEST['CPP_TRECHO_PARTIDA1'] ) ) ? $_REQUEST['CPP_TRECHO_PARTIDA1'] : null;
		$CPP_TRECHO_PARTIDA2	= ( isset( $_REQUEST['CPP_TRECHO_PARTIDA2'] ) ) ? $_REQUEST['CPP_TRECHO_PARTIDA2'] : null;
		$CPP_TRECHO_PARTIDA3	= ( isset( $_REQUEST['CPP_TRECHO_PARTIDA3'] ) ) ? $_REQUEST['CPP_TRECHO_PARTIDA3'] : null;
		$CPP_TRECHO_PARTIDA4	= ( isset( $_REQUEST['CPP_TRECHO_PARTIDA4'] ) ) ? $_REQUEST['CPP_TRECHO_PARTIDA4'] : null;
		$CPP_TRECHO_DEPARA1		= ( isset( $_REQUEST['CPP_TRECHO_DEPARA1'] ) ) ? $_REQUEST['CPP_TRECHO_DEPARA1'] : null;
		$CPP_TRECHO_DEPARA2		= ( isset( $_REQUEST['CPP_TRECHO_DEPARA2'] ) ) ? $_REQUEST['CPP_TRECHO_DEPARA2'] : null;
		$CPP_TRECHO_DEPARA3		= ( isset( $_REQUEST['CPP_TRECHO_DEPARA3'] ) ) ? $_REQUEST['CPP_TRECHO_DEPARA3'] : null;
		$CPP_TRECHO_DEPARA4		= ( isset( $_REQUEST['CPP_TRECHO_DEPARA4'] ) ) ? $_REQUEST['CPP_TRECHO_DEPARA4'] : null;
		$CPP_TRECHO_CHEGADA1	= ( isset( $_REQUEST['CPP_TRECHO_CHEGADA1'] ) ) ? $_REQUEST['CPP_TRECHO_CHEGADA1'] : null;
		$CPP_TRECHO_CHEGADA2	= ( isset( $_REQUEST['CPP_TRECHO_CHEGADA2'] ) ) ? $_REQUEST['CPP_TRECHO_CHEGADA2'] : null;
		$CPP_TRECHO_CHEGADA3	= ( isset( $_REQUEST['CPP_TRECHO_CHEGADA3'] ) ) ? $_REQUEST['CPP_TRECHO_CHEGADA3'] : null;
		$CPP_TRECHO_CHEGADA4	= ( isset( $_REQUEST['CPP_TRECHO_CHEGADA4'] ) ) ? $_REQUEST['CPP_TRECHO_CHEGADA4'] : null;
		$CPP_TRECHO_SAIDA1		= ( isset( $_REQUEST['CPP_TRECHO_SAIDA1'] ) ) ? $_REQUEST['CPP_TRECHO_SAIDA1'] : null;
		$CPP_TRECHO_SAIDA2		= ( isset( $_REQUEST['CPP_TRECHO_SAIDA2'] ) ) ? $_REQUEST['CPP_TRECHO_SAIDA2'] : null;
		$CPP_TRECHO_SAIDA3		= ( isset( $_REQUEST['CPP_TRECHO_SAIDA3'] ) ) ? $_REQUEST['CPP_TRECHO_SAIDA3'] : null;
		$CPP_TRECHO_SAIDA4		= ( isset( $_REQUEST['CPP_TRECHO_SAIDA4'] ) ) ? $_REQUEST['CPP_TRECHO_SAIDA4'] : null;
		$CPP_VALOR_PASSAGEM		= ( isset( $_REQUEST['CPP_VALOR_PASSAGEM'] ) ) ? $_REQUEST['CPP_VALOR_PASSAGEM'] : null;
		$CPP_VALOR_TAXA			= ( isset( $_REQUEST['CPP_VALOR_TAXA'] ) ) ? $_REQUEST['CPP_VALOR_TAXA'] : null;
		$CPP_TOTAL_AEREO		= ( isset( $_REQUEST['CPP_TOTAL_AEREO'] ) ) ? $_REQUEST['CPP_TOTAL_AEREO'] : null;
		$CPP_HOTEL				= ( isset( $_REQUEST['CPP_HOTEL'] ) ) ? $_REQUEST['CPP_HOTEL'] : null;
		$CPP_HOTEL_LINK			= ( isset( $_REQUEST['CPP_HOTEL_LINK'] ) ) ? $_REQUEST['CPP_HOTEL_LINK'] : null;
		$CPP_HOTEL_ENDERECO		= ( isset( $_REQUEST['CPP_HOTEL_ENDERECO'] ) ) ? $_REQUEST['CPP_HOTEL_ENDERECO'] : null;
		$CPP_HOTEL_CLASSIFICACAO= ( isset( $_REQUEST['CPP_HOTEL_CLASSIFICACAO'] ) ) ? $_REQUEST['CPP_HOTEL_CLASSIFICACAO'] : null;
		$CPP_HOTEL_CHECKIN		= ( isset( $_REQUEST['CPP_HOTEL_CHECKIN'] ) ) ? $_REQUEST['CPP_HOTEL_CHECKIN'] : null;
		$CPP_HOTEL_CHECKOUT		= ( isset( $_REQUEST['CPP_HOTEL_CHECKOUT'] ) ) ? $_REQUEST['CPP_HOTEL_CHECKOUT'] : null;
		$CPP_HOTEL_QTD_NOITES	= ( isset( $_REQUEST['CPP_HOTEL_QTD_NOITES'] ) ) ? $_REQUEST['CPP_HOTEL_QTD_NOITES'] : null;
		$CPP_HOTEL_MEDIA_DIARIA	= ( isset( $_REQUEST['CPP_HOTEL_MEDIA_DIARIA'] ) ) ? $_REQUEST['CPP_HOTEL_MEDIA_DIARIA'] : null;
		$CPP_TOTAL_HOTEL		= ( isset( $_REQUEST['CPP_TOTAL_HOTEL'] ) ) ? $_REQUEST['CPP_TOTAL_HOTEL'] : null;
		$CPP_ALUGUEL_LOCADORA	= ( isset( $_REQUEST['CPP_ALUGUEL_LOCADORA'] ) ) ? $_REQUEST['CPP_ALUGUEL_LOCADORA'] : null;
		$CPP_ALUGUEL_CLASSIFICACAO	= ( isset( $_REQUEST['CPP_ALUGUEL_CLASSIFICACAO'] ) ) ? $_REQUEST['CPP_ALUGUEL_CLASSIFICACAO'] : null;
		$CPP_ALUGUEL_RETIRADA	= ( isset( $_REQUEST['CPP_ALUGUEL_RETIRADA'] ) ) ? $_REQUEST['CPP_ALUGUEL_RETIRADA'] : null;
		$CPP_ALUGUEL_GPS		= ( isset( $_REQUEST['CPP_ALUGUEL_GPS'] ) ) ? $_REQUEST['CPP_ALUGUEL_GPS'] : null;
		$CPP_ALUGUEL_DIARIAS	= ( isset( $_REQUEST['CPP_ALUGUEL_DIARIAS'] ) ) ? $_REQUEST['CPP_ALUGUEL_DIARIAS'] : null;
		$CPP_ALUGUEL_DEVOLUCAO	= ( isset( $_REQUEST['CPP_ALUGUEL_DEVOLUCAO'] ) ) ? $_REQUEST['CPP_ALUGUEL_DEVOLUCAO'] : null;
		$CPP_ALUGUEL_ENTREGA	= ( isset( $_REQUEST['CPP_ALUGUEL_ENTREGA'] ) ) ? $_REQUEST['CPP_ALUGUEL_ENTREGA'] : null;
		$CPP_ALUGUEL_SISTEMA	= ( isset( $_REQUEST['CPP_ALUGUEL_SISTEMA'] ) ) ? $_REQUEST['CPP_ALUGUEL_SISTEMA'] : null;
		$CPP_TOTAL_ALUGUEL	= ( isset( $_REQUEST['CPP_TOTAL_ALUGUEL'] ) ) ? $_REQUEST['CPP_TOTAL_ALUGUEL'] : null;
		$CPP_OBSERVACOES	= ( isset( $_REQUEST['CPP_OBSERVACOES'] ) ) ? $_REQUEST['CPP_OBSERVACOES'] : null;
		$CTC_ID				= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$USR_ID				= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
                $LeadComprou            = ( isset( $_REQUEST['LeadComprou'] ) ) ? $_REQUEST['LeadComprou'] : null;
				
		$arrValores 									= array();
		$arrValores["USR_ID"] 							= $USR_ID;
		$arrValores["CTC_ID"] 							= $CTC_ID;
		$arrValores["CPP_TRECHO_SIGLA1"] 				= $CPP_TRECHO_SIGLA1;
		$arrValores["CPP_TRECHO_COMPANIA1"] 			= $CPP_TRECHO_COMPANIA1;
		$arrValores["CPP_TRECHO_PARTIDA1"] 				= $oUtil->codificadata ($CPP_TRECHO_PARTIDA1);
		$arrValores["CPP_TRECHO_DEPARA1"] 				= $CPP_TRECHO_DEPARA1;
		$arrValores["CPP_TRECHO_CHEGADA1"] 				= $CPP_TRECHO_CHEGADA1;
		$arrValores["CPP_TRECHO_SAIDA1"] 				= $CPP_TRECHO_SAIDA1;
		$arrValores["CPP_TRECHO_SIGLA2"] 				= $CPP_TRECHO_SIGLA2;
		$arrValores["CPP_TRECHO_COMPANIA2"] 			= $CPP_TRECHO_COMPANIA2;
		$arrValores["CPP_TRECHO_PARTIDA2"] 				= $oUtil->codificadata ($CPP_TRECHO_PARTIDA2);
		$arrValores["CPP_TRECHO_DEPARA2"] 				= $CPP_TRECHO_DEPARA2;
		$arrValores["CPP_TRECHO_CHEGADA2"] 				= $CPP_TRECHO_CHEGADA2;
		$arrValores["CPP_TRECHO_SAIDA2"] 				= $CPP_TRECHO_SAIDA2;
		$arrValores["CPP_TRECHO_SIGLA3"] 				= $CPP_TRECHO_SIGLA3;
		$arrValores["CPP_TRECHO_COMPANIA3"] 			= $CPP_TRECHO_COMPANIA3;
		$arrValores["CPP_TRECHO_PARTIDA3"] 				= $oUtil->codificadata ($CPP_TRECHO_PARTIDA3);
		$arrValores["CPP_TRECHO_DEPARA3"] 				= $CPP_TRECHO_DEPARA3;
		$arrValores["CPP_TRECHO_CHEGADA3"] 				= $CPP_TRECHO_CHEGADA3;
		$arrValores["CPP_TRECHO_SAIDA3"] 				= $CPP_TRECHO_SAIDA3;
		$arrValores["CPP_TRECHO_SIGLA4"] 				= $CPP_TRECHO_SIGLA4;
		$arrValores["CPP_TRECHO_COMPANIA4"] 			= $CPP_TRECHO_COMPANIA4;
		$arrValores["CPP_TRECHO_PARTIDA4"] 				= $oUtil->codificadata ($CPP_TRECHO_PARTIDA4);
		$arrValores["CPP_TRECHO_DEPARA4"] 				= $CPP_TRECHO_DEPARA4;
		$arrValores["CPP_TRECHO_CHEGADA4"] 				= $CPP_TRECHO_CHEGADA4;
		$arrValores["CPP_TRECHO_SAIDA4"] 				= $CPP_TRECHO_SAIDA4;
		$CPP_VALOR_PASSAGEM 							= str_replace ('.','',$CPP_VALOR_PASSAGEM);
		$CPP_VALOR_PASSAGEM 							= str_replace (',','.',$CPP_VALOR_PASSAGEM);
		$arrValores["CPP_VALOR_PASSAGEM"] 				= $CPP_VALOR_PASSAGEM;
		$CPP_VALOR_TAXA 								= str_replace ('.','',$CPP_VALOR_TAXA);
		$CPP_VALOR_TAXA 								= str_replace (',','.',$CPP_VALOR_TAXA);
		$arrValores["CPP_VALOR_TAXA"] 					= $CPP_VALOR_TAXA;
		$CPP_TOTAL_AEREO 								= str_replace ('.','',$CPP_TOTAL_AEREO);
		$CPP_TOTAL_AEREO 								= str_replace (',','.',$CPP_TOTAL_AEREO);
		$arrValores["CPP_TOTAL_AEREO"] 					= $CPP_TOTAL_AEREO;
		$arrValores["CPP_HOTEL"] 						= $CPP_HOTEL;
		$arrValores["CPP_HOTEL_LINK"] 					= $CPP_HOTEL_LINK;
		$arrValores["CPP_HOTEL_ENDERECO"] 				= $CPP_HOTEL_ENDERECO;
		$arrValores["CPP_HOTEL_CLASSIFICACAO"] 			= $CPP_HOTEL_CLASSIFICACAO;
		$arrValores["CPP_HOTEL_CHECKIN"] 				= $oUtil->codificadata ($CPP_HOTEL_CHECKIN);
		$arrValores["CPP_HOTEL_CHECKOUT"] 				= $oUtil->codificadata ($CPP_HOTEL_CHECKOUT);
		$arrValores["CPP_HOTEL_QTD_NOITES"] 			= $CPP_HOTEL_QTD_NOITES;
		$CPP_HOTEL_MEDIA_DIARIA							= str_replace ('.','',$CPP_HOTEL_MEDIA_DIARIA);
		$CPP_HOTEL_MEDIA_DIARIA							= str_replace (',','.',$CPP_HOTEL_MEDIA_DIARIA);
		$arrValores["CPP_HOTEL_MEDIA_DIARIA"] 			= $CPP_HOTEL_MEDIA_DIARIA;
		$CPP_TOTAL_HOTEL								= str_replace ('.','',$CPP_TOTAL_HOTEL);
		$CPP_TOTAL_HOTEL								= str_replace (',','.',$CPP_TOTAL_HOTEL);
		$arrValores["CPP_TOTAL_HOTEL"] 					= $CPP_TOTAL_HOTEL;
		$arrValores["CPP_ALUGUEL_LOCADORA"] 			= $CPP_ALUGUEL_LOCADORA;
		$arrValores["CPP_ALUGUEL_CLASSIFICACAO"] 		= $CPP_ALUGUEL_CLASSIFICACAO;
		$arrValores["CPP_ALUGUEL_RETIRADA"] 			= $oUtil->codificadata ($CPP_ALUGUEL_RETIRADA);
		$arrValores["CPP_ALUGUEL_GPS"] 					= $CPP_ALUGUEL_GPS;
		$arrValores["CPP_ALUGUEL_DIARIAS"] 				= $CPP_ALUGUEL_DIARIAS;
		$arrValores["CPP_ALUGUEL_DEVOLUCAO"] 			= $oUtil->codificadata ($CPP_ALUGUEL_DEVOLUCAO);
		$arrValores["CPP_ALUGUEL_ENTREGA"] 				= $CPP_ALUGUEL_ENTREGA;
		$arrValores["CPP_ALUGUEL_SISTEMA"] 				= $CPP_ALUGUEL_SISTEMA;
		$CPP_TOTAL_ALUGUEL								= str_replace ('.','',$CPP_TOTAL_ALUGUEL);
		$CPP_TOTAL_ALUGUEL								= str_replace (',','.',$CPP_TOTAL_ALUGUEL);
		$arrValores["CPP_TOTAL_ALUGUEL"] 				= $CPP_TOTAL_ALUGUEL;
		$arrValores["CPP_OBSERVACOES"] 					= $CPP_OBSERVACOES;
	// ======================= //

	// Definindo a A��o da Tela //	
		// Verifico se fornecedor j� fez proposta
		$hQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE USR_ID = '$USR_ID' 
		AND CTC_ID = '$CTC_ID'");
		if (mysql_num_rows($hQry) > 0){
			$oCriarDestinoDAO->updateProposta ($arrValores,$CTC_ID,$USR_ID);
			$msgTxt = 5;
		}else{
			$oCriarDestinoDAO->insertProposta ($arrValores);
                        if ($LeadComprou == "1"){
                            $Resultado = $oCriarDestinoDAO->pegaPrecoLead($CTC_ID);
                            $nhQry = mysql_query ("UPDATE tb_usuario SET USR_QTD_LEADS = USR_QTD_LEADS - $Resultado WHERE USR_ID = '$USR_ID'");
                        }
			$msgTxt = 1;
		}
		
		header( "Location: index.php?pg=4&CTC_ID=$CTC_ID&msgTxt=1"  );
	// ======================== //
		
?>