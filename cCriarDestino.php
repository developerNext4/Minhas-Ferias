<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/CriarDestinoDAO.php" );
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
		$oUtil 			= new Util();
		$oCriarDestino 	= new CriarDestinoDAO();
	// ==================== //
	
	// Declaração de variáveis //
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$CTC_AEREO				= ( isset( $_REQUEST['CTC_AEREO'] ) ) ? $_REQUEST['CTC_AEREO'] : 0;
		$CTC_HOTEL				= ( isset( $_REQUEST['CTC_HOTEL'] ) ) ? $_REQUEST['CTC_HOTEL'] : 0;
		$CTC_ALUGUEL			= ( isset( $_REQUEST['CTC_ALUGUEL'] ) ) ? $_REQUEST['CTC_ALUGUEL'] : 0;
		$CTC_ATIVIDADE			= ( isset( $_REQUEST['CTC_ATIVIDADE'] ) ) ? $_REQUEST['CTC_ATIVIDADE'] : 0;
		$CTC_PASSAGEM			= ( isset( $_REQUEST['CTC_PASSAGEM'] ) ) ? $_REQUEST['CTC_PASSAGEM'] : null;
		$CTC_DE					= ( isset( $_REQUEST['CTC_DE'] ) ) ? $_REQUEST['CTC_DE'] : null;
		//$CTC_PARA				= ( isset( $_REQUEST['CTC_PARA'] ) ) ? $_REQUEST['CTC_PARA'] : null;
		$DIA					= ( isset( $_REQUEST['DIA'] ) ) ? $_REQUEST['DIA'] : null;
		$MES					= ( isset( $_REQUEST['MES'] ) ) ? $_REQUEST['MES'] : null;
		$ANO					= ( isset( $_REQUEST['ANO'] ) ) ? $_REQUEST['ANO'] : null;
		$CTC_DATA_VOLTA			= ( isset( $_REQUEST['CTC_DATA_VOLTA'] ) ) ? $_REQUEST['CTC_DATA_VOLTA'] : null;
		$CTC_DATA_FLEXIVEIS		= ( isset( $_REQUEST['CTC_DATA_FLEXIVEIS'] ) ) ? $_REQUEST['CTC_DATA_FLEXIVEIS'] : 0;
		$CTC_ADULTOS			= ( isset( $_REQUEST['CTC_ADULTOS'] ) ) ? $_REQUEST['CTC_ADULTOS'] : null;
		$CTC_ZERO_TRES			= ( isset( $_REQUEST['CTC_ZERO_TRES'] ) ) ? $_REQUEST['CTC_ZERO_TRES'] : null;
		$CTC_CRIANCAS			= ( isset( $_REQUEST['CTC_CRIANCAS'] ) ) ? $_REQUEST['CTC_CRIANCAS'] : null;
		$CTC_QTD_PROPOSTAS		= ( isset( $_REQUEST['CTC_QTD_PROPOSTAS'] ) ) ? $_REQUEST['CTC_QTD_PROPOSTAS'] : null;
		$CTC_OBS				= ( isset( $_REQUEST['CTC_OBS'] ) ) ? $_REQUEST['CTC_OBS'] : null;
		$Contador				= ( isset( $_REQUEST['Contador'] ) ) ? $_REQUEST['Contador'] : null;
		$DESEJOCOTAR			= NULL;
				
		$arrValores 									= array();
		$arrValores["USR_ID"] 							= $USR_ID;
		$arrValores["CTC_AEREO"] 						= $CTC_AEREO;
		$arrValores["CTC_HOTEL"] 						= $CTC_HOTEL;
		$arrValores["CTC_ALUGUEL"] 						= $CTC_ALUGUEL;
		$arrValores["CTC_ATIVIDADE"] 					= $CTC_ATIVIDADE;
		$arrValores["CTC_PASSAGEM"] 					= $CTC_PASSAGEM;
		$arrValores["CTC_DE"] 							= $CTC_DE;
		$arrValores["CTC_PARTIDA_DIA"] 					= $DIA;
		$arrValores["CTC_PARTIDA_MES"] 					= $MES;
		$arrValores["CTC_PARTIDA_ANO"] 					= $ANO;
		$arrValores["CTC_DATA_VOLTA"] 					= $oUtil->codificadata ($CTC_DATA_VOLTA);
		$arrValores["CTC_DATA_FLEXIVEIS"] 				= $CTC_DATA_FLEXIVEIS;
		$arrValores["CTC_ADULTOS"] 						= $CTC_ADULTOS;
		$arrValores["CTC_ZERO_TRES"] 					= $CTC_ZERO_TRES;
		$arrValores["CTC_CRIANCAS"] 					= $CTC_CRIANCAS;
		$arrValores["CTC_QTD_PROPOSTAS"] 				= $CTC_QTD_PROPOSTAS;
		$arrValores["CTC_OBS"] 							= $CTC_OBS;
		$arrValores["CTC_DATA"] 						= date ('Y-m-d H:i:s');		
			// ======================= //
	
	
	// Definindo a Ação da Tela //		
				
				// CODIFICANDO O PADRÃO UTF8 DAS INFORMÇÕES //
				/*foreach( $arrValores as $ch => $vl ){
					$arrValores[$ch] = utf8_encode( $vl );
				}*/
				
				// Verifico se os destinos existem
				$qQry = mysql_query ("SELECT DST_NOME FROM tb_destino WHERE DST_NOME = '$CTC_DE'");
				if (mysql_num_rows($qQry) > 0){}else{
					$wQry = mysql_query ("INSERT INTO tb_destino (DST_NOME) values ('$CTC_DE')");
				}
				
				for ($i = 1; $i <= $Contador; $i++){
					$arrValores["CTC_PARA"] = $_REQUEST["CTC_PARA".$i];
					$arrValores["CTC_QTD_NOITES"] = $_REQUEST["CTC_QTD_NOITES".$i];
					
					// Verifico se os destinos existem
					$eQry = mysql_query ("SELECT DST_NOME FROM tb_destino WHERE DST_NOME = '$CTC_PARA'");
					if (mysql_num_rows($eQry) > 0){
                                            $rQry = mysql_fetch_array ($eQry);
                                            $DST_ID = $rQry['DST_ID'];
                                        }else{
						$rQry = mysql_query ("INSERT INTO tb_destino (DST_NOME) values ('$CTC_PARA')");
                                                $uQry = mysql_query ("SELECT * FROM tb_destino ORDER BY DST_ID DESC LIMIT 1");
                                                $yQry = mysql_fetch_array ($uQry);
                                                $DST_ID = $yQry['DST_ID'];
					}
                                        $arrValores['DST_ID'] = $DST_ID;
						
					$IdCli = $oCriarDestino->insert( $arrValores );
				
				
					$msgTxt = 1;
					$Destinos = NULL;
					
					if ($CTC_AEREO == "1"){
						$DESEJOCOTAR .= "A&eacute;reo,";
					}
					if ($CTC_HOTEL == "1"){
						$DESEJOCOTAR .= " Hotel,";
					}
					if ($CTC_ALUGUEL == "1"){
						$DESEJOCOTAR .= " Aluguel,";
					}
					if ($CTC_ATIVIDADE == "1"){
						$DESEJOCOTAR .= " Atividades Locais,";
					}
					
					$DESEJOCOTAR = substr ($DESEJOCOTAR,0,-1);
					
					if ($CTC_PASSAGEM == "1"){
						$CTC_PASSAGEM = "Ida e Volta";
					}else{
						$CTC_PASSAGEM = "Somente Ida";
					}
					
					if ($CTC_DATA_FLEXIVEIS == "1"){
						$CTC_DATA_FLEXIVEIS = "Sim";
					}else{
						$CTC_DATA_FLEXIVEIS = "N&atilde;o";
					}
					
					// Busco e-mail do usuário
					$pQry = mysql_query ("SELECT USR_EMAIL, USR_NOME FROM tb_usuario WHERE USR_ID = '$USR_ID'");
					$oQry = mysql_fetch_array ($pQry);
					
						
					$corpo = "<html>
								<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
								<title>Pedido de Cota&ccedil;&atilde;o</title>
								</head>
								<body >
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
								<tbody>
									<tr>
										<td>
												<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Pedido de Cota&ccedil;&atilde;o</font></strong><br/><br/>
												<font face='tahoma' color='#666666'>Prezado (a) $oQry[USR_NOME],</font><br/><br/>
										</td>
									</tr>
								</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
									<tbody>
										<tr>
											<td><font face='tahoma' color='#666666'>O Pedido de Cota&ccedil;&atilde;o abaixo foi criado.<br><br>
											<table width='100%'>
												<tr>
													<td><b>Pedido nº:</b></td><td>$IdCli</td>
												</tr>
												<tr>
													<td><b>Desejo de Cotar:</b></td><td>$DESEJOCOTAR</td>
												</tr>
												<tr>
													<td><b>Passagem:</b></td><td>$CTC_PASSAGEM</td>
												</tr>
												<tr>
													<td><b>De:</b></td><td>$CTC_DE</td>
												</tr>
												<tr>
													<td><b>Data de Partidade:</b></td><td>".$DIA."/".$MES."/".$ANO."</td>
												</tr>
												<tr>
													<td><b>Data de Volta:</b></td><td>$CTC_DATA_VOLTA</td>
												</tr>
												<tr>
													<td><b>Para: </b></td><td>$arrValores[CTC_PARA]</td>
												</tr>
												<tr>
													<td><b>Qtde de Noites: </b></td><td>$arrValores[CTC_QTD_NOITES]</td>
												</tr>
												<tr>
													<td><b>Adultos</b></td><td>$CTC_ADULTOS</td>
												</tr>
												<tr>
													<td><b>De zero a 23 meses</b></td><td>$CTC_ZERO_TRES</td>
												</tr>
												<tr>
													<td><b>Crian&ccedil;as de 2 a 12 anos</b></td><td>$CTC_CRIANCAS</td>
												</tr>
												<tr>
													<td><b>Quantidade de Proposta:</b></td><td>$CTC_QTD_PROPOSTAS</td>
												</tr>
												<tr>
													<td><b>Observa&ccedil;&otilde;es</b></td><td>$CTC_OBS</td>
												</tr>
											</table>
											</font></td>
											
										</tr>
										<tr height='18'>
											<td></td>
											<td></td>
										</tr>
										
										<tr>
											<td><font face='tahoma' color='#666666'>Em caso de d&uacute;vidas acesse a central de ajuda do site. Se preferir, entre em contato atrav&eacute;s do fale conosco.</font></td>
											
											
										</tr>
										<tr height='40'>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
								
								<table cellspacing='0' cellpadding='0' border='0' align='center' width='600' >
									<tbody>
										<tr>
											<td width='174'>
												Logo
											</td>
											
											<td><font face='tahoma' color='#666666' size='1'>
											Equipe Vazzo<br/>
								Especializada em Viagens!<br/>
								www.vazzo.com.br<br/>
								Em caso de d&uacute;vidas, cr&iacute;ticas ou sugest&otilde;es acesse nosso atendimento: <strong> <a href='http://www.vazzo.com.br' style='text-decoration:none; color:#2A4F5E'>fale conosco</a></strong>
											</font></td>
										</tr>
									</tbody>
								
								</table>
								
								</body>
								</html>";
					$header = "MIME-Version: 1.0\n";
					$header .= "Content-type: text/html; charset=iso-8859-1\n";
					$header .= "From: Vazzo <atende@vazzo.com.br>\n";
					$assunto = "Pedido de Cotação";
					
					
					
					mail($oQry['USR_EMAIL'],$assunto,$corpo,$header);
				}
				
				
				header( "Location: index.php?pg=1&msgTxt=$msgTxt"  );
				
				break;
			

	// ======================== //
		
?>