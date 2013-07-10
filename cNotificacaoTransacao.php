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
	
	// Recebo os dados //
                if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
                    $notificationCode = $_POST["notificationCode"];
                    
                    $url = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/$notificationCode?email=andryonheavy@hotmail.com&token=FFC2DE4018F34B389B3D26E86214886A";
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $xml= curl_exec($curl);
                    
                    $xml = simplexml_load_string($xml);
                    $Referencia = $xml->reference;
                    
                    if ($xml->status == "3"){
                        // Paga
                        $hQry = mysql_query ("SELECT * FROM tb_pagamento a INNER JOIN tb_pacote b
                                              ON a.PCT_ID = b.PCT_ID WHERE PGM_CODIGO = '$Referencia'");
                        $jQry = mysql_fetch_array ($hQry);
                        
                        $iQry = mysql_query ("UPDATE tb_pagamento SET PCT_STATUS = '1', PGM_DATA_PAGAMENTO = NOW() 
                                              WHERE PGM_CODIGO = '$Referencia'");
                        $oQry = mysql_query ("UPDATE tb_usuario SET USR_QTD_LEADS = USR_QTD_LEADS + $jQry[PCT_LEADS]
                                              WHERE USR_ID = '$jQry[USR_ID]'");
                    }
                    if ($xml->status == "7"){
                        // Cancelada
                        $iQry = mysql_query ("UPDATE tb_pagamento SET PCT_STATUS = '2' 
                                              WHERE PGM_CODIGO = '$Referencia'");
                    }
                }
        // =============== //
		
?>