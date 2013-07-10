<?php
	// ====================================== //
	// Autor: 		Andryon Darllon Pech
	// ====================================== //
	
	// Requisiчѕes de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
	// Declaraчуo de variсveis //
		$PCT_ID					= ( isset( $_REQUEST['PCT_ID'] ) ) ? $_REQUEST['PCT_ID'] : null;
		$USR_ID					= ( isset( $_REQUEST['USR_ID'] ) ) ? $_REQUEST['USR_ID'] : null;
		$FONTE					= ( isset( $_REQUEST['FONTE'] ) ) ? $_REQUEST['FONTE'] : null;
		$PGM_VALOR				= ( isset( $_REQUEST['PGM_VALOR'] ) ) ? $_REQUEST['PGM_VALOR'] : null;
	// ======================= //
	
	// Realizo a aчуo //
		$hQry = mysql_query ("SELECT * FROM tb_pacote WHERE PCT_ID = '$PCT_ID'");
		$jQry = mysql_fetch_array ($hQry);
		$jQry['PCT_VALOR'] = str_replace (',','.',$jQry['PCT_VALOR']);
		
		$qQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$USR_ID'");
		$wQry = mysql_fetch_array ($qQry);
                
                // Pego a referъncia
                $nuQry = mysql_query ("SELECT MAX(PGM_ID)+1 AS REFERENCIA FROM tb_pagamento");
                $uuQry = mysql_fetch_array ($nuQry);
                
                
		
		$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';
		$data['email'] = 'andryonheavy@hotmail.com';
		$data['token'] = 'FFC2DE4018F34B389B3D26E86214886A';
		$data['currency'] = 'BRL';
		$data['itemId1'] = '0001';
		$data['itemDescription1'] = utf8_encode ($jQry['PCT_NOME']);
		if ($FONTE != NULL){
			$PGM_VALOR = str_replace (',','.',$PGM_VALOR);
			$data['itemAmount1'] = $PGM_VALOR;
		}else{
			$data['itemAmount1'] = $jQry['PCT_VALOR'];
		}
		$data['itemQuantity1'] = '1';
		$data['itemWeight1'] = '0';
		$data['reference'] = $uuQry['REFERENCIA'];
		$data['senderName'] = utf8_encode ($wQry['USR_NOME']);
		//$data['senderAreaCode'] = '11';
		//$data['senderPhone'] = '56273440';
		$data['senderEmail'] = $wQry['USR_EMAIL'];
		$data['shippingType'] = '1';
		//$data['shippingAddressStreet'] = 'Av. Brig. Faria Lima';
		//$data['shippingAddressNumber'] = '1384';
		//$data['shippingAddressComplement'] = '5o andar';
		//$data['shippingAddressDistrict'] = 'Jardim Paulistano';
		//$data['shippingAddressPostalCode'] = '01452002';
		//$data['shippingAddressCity'] = 'Sao Paulo';
		//$data['shippingAddressState'] = 'SP';
		$data['shippingAddressCountry'] = 'BRA';
		$data['redirectURL'] = 'http://www.sounoob.com.br/paginaDeAgracedimento';
		
		$data = http_build_query($data);
		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$xml= curl_exec($curl);
		
		
		$xml = simplexml_load_string($xml);
              
		if(count($xml -> error) > 0){
			echo ("ERRO");
			exit();
		}
		$CODIGO = $xml -> code;
                
		// Gravo na tabela
		if ($FONTE == NULL){
			$pQry = mysql_query ("INSERT INTO TB_PAGAMENTO (USR_ID, PCT_ID, PGM_CODIGO, PGM_DESCRICAO, PGM_VALOR, PGM_REFERENCIA,
			PGM_DATA) VALUES ('$USR_ID','$PCT_ID','$CODIGO','$jQry[PCT_NOME]','$jQry[PCT_VALOR]','$uuQry[REFERENCIA]',NOW())");
                        
		}
		
		header('Location: https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $xml -> code);
	// ============== //
		
?>