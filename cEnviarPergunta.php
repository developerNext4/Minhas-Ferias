<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declaração de variáveis //
		$acaoTela				= ( isset( $_REQUEST['acaoTela'] ) ) ? $_REQUEST['acaoTela'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$CTC_ID					= ( isset( $_REQUEST['CTC_ID'] ) ) ? $_REQUEST['CTC_ID'] : null;
		$USR_ID_PARA			= ( isset( $_REQUEST['USR_ID_PARA'] ) ) ? $_REQUEST['USR_ID_PARA'] : null;
		$PERGUNTA				= utf8_decode (( isset( $_REQUEST['PERGUNTA'] ) ) ? $_REQUEST['PERGUNTA'] : null);
		$pg						= ( isset( $_REQUEST['pg'] ) ) ? $_REQUEST['pg'] : null;
                $Usuarios                               = array();
	// ======================= //
	
	if ($USR_ID_PARA == "T"){
		// Busco todos fornecedores que fizeram propsota
		$hQry = mysql_query ("SELECT * FROM tb_cotacao_proposta WHERE CTC_ID = '$CTC_ID'");
		while ($jQry = mysql_fetch_array ($hQry)){
			$kQry = mysql_query ("INSERT INTO tb_cotacao_pergunta (CTC_ID, USR_ID_DE, USR_ID_PARA, CPR_PERGUNTA)
			VALUES ('$CTC_ID','$USR_ID','$jQry[USR_ID]','$PERGUNTA')");
                        $Usuarios[] = $jQry['USR_ID'];
                        $Usuarios[] = 3;
		}
	}else{
			$kQry = mysql_query ("INSERT INTO tb_cotacao_pergunta (CTC_ID, USR_ID_DE, USR_ID_PARA, CPR_PERGUNTA)
			VALUES ('$CTC_ID','$USR_ID','$USR_ID_PARA','$PERGUNTA')");
                        $Usuarios[] = $USR_ID_PARA;
	}
        
        foreach ($Usuarios as $key => $value){
            // Busco dados do agente
            $kQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$value'");
            $lQry = mysql_fetch_array ($kQry);
            $corpo = "<html>
			<head><meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
                            <title>Voc&ecirc; recebeu uma nova pergunta</title>
			</head>
			<body>
			
                            <table cellspacing='0' cellpadding='0' border='0' align='center' width='600'>
				<tbody>
                                	<tr>
						<td>
                                        		<strong><font face='tahoma' color='#2A4F5E' align='center' size='5'>Voc&ecirc; recebeu uma nova pergunta</font></strong><br/><br/>
							<font face='tahoma' color='#666666'>Prezado(a) $lQry[USR_NOME],</font><br/><br/>
						</td>
					</tr>
				</tbody>
                            </table>
					
                            <table cellspacing='0' cellpadding='0' border='0' align='center' width='600' style='border:0; border-tight' >
                                <tbody>
                                    <tr>
					<td><font face='tahoma' color='#666666'>Você recebeu uma nova pergunta para a cotação nº $CTC_ID.<br><br>
                                            Para visualizar acesse seu painel de controle clicando <a href='#'>AQUI</a></font></td>
										
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
		$assunto = "Você recebeu uma nova pergunta";
		mail($lQry['USR_EMAIL'],$assunto,$corpo,$header);
        }
        
        

				
	header( "Location: index.php?pg=$pg&CTC_ID=$CTC_ID&msgTxt=1"  );

		
?>