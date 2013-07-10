<?php
	/******** CHANGELOG:: UtilsDAO.php
		Autor:	Wagner
		Data:	11/10/2008 
		O que?:	adicionando um RETURN na função montaSelectCombo().
		--------------------------------- 
		
		Autor:	Wagner
		Data:	18/10/2008 
		O que?:	adicionado a função montaSelectCombo().
		--------------------------------- 
	
		Autor:	Luiz
		Data:	19/10/2008
		O que?:	adicionada a funcao  montaSelectComboArray
		--------------------------------- 
	
		Autor:	Luiz
		Data:	23/10/2008
		O que?:	Adicionada funcao montaSelectComboArray numerico
		--------------------------------- 
	
		Autor:	Luiz
		Data:	27/12/2008
		O que?:	Adicionada função montaSelectComboArray2
		-------------------------------------------------------
		
		Autor:	
		Data:	
		O que?:			
	********************/
	
   require_once("classe.conexao.php");
   class UtilsDAO extends conexao{


      function UtilsDAO(){
         //parent::conexao();
         $this->conexao();
      }

		function montaSelectCombo( $tabela, $campoChave, $campoValor, $idCompara = NULL, $order = NULL, $where = NULL, $utf8 = NULL ){
			$sCombo = NULL;
			$sel	= NULL;
			$utf8	= $utf8;
			
			if( $order != NULL ){
				$order = $order;
			}else{
				$order = $campoValor;
			}
			
			$sql = "SELECT " . $campoChave . ", " . $campoValor . " FROM " . $tabela . " " . $where . " ORDER BY " . $order;
			$eQry = mysql_query( $sql );
			
			$sCombo .= '<option value="x">Selecione ...</option>';
			
			$this->sql($sql);

			while( $linha = mysql_fetch_array( $eQry ) ){
				if( is_array( $idCompara ) ){
					$chave_array = intval( array_search( $linha[0], $idCompara ) );
					
					if( ( $chave_array > 0 ) && ( $linha[0] == $chave_array ) ){
						$sel = ' selected="selected"';
					}
					else{
						$sel = "";
					}
				}
				else{
					if( ( $linha[0] == $idCompara ) && ( $sel != " selected " ) ){
						$sel = ' selected="selected"';
					}
					else{
						$sel = "";
					}
				}
				
				if( $utf8 == "utf8" ){
					$sCombo .= "<option value='$linha[0]' $sel>" . utf8_encode($linha[1]) . "</option>";
				}
				else{
					$sCombo .= "<option value='$linha[0]' $sel>" . $linha[1] . "</option>";
				}
			}
			
			return $sCombo;
		}


		//gera combo apartir de um array, utilizado em campos enum ex: $arrayCombo = array(MASCULINO,FEMININO)
		function montaSelectComboArray($arrayCombo,$strCompara = NULL ){
			$sCombo = NULL;
			$sel	= NULL;
			
			foreach ($arrayCombo as $c => $v){
				if( $c == $strCompara && $sel != " selected " )
					$sel = " selected ";
				else
					$sel = "";
				
			
				$sCombo .= "<option value='$c' $sel>$v</option>";			
			}
			
			return $sCombo;
		}


		function montaSelectComboArrayNumerico($arrayCombo,$strCompara=NULL){
			$sCombo = NULL;
			$i=0;
			foreach ($arrayCombo as $v){
				if( $i == $strCompara )
					$sel = " selected ";
				else
					$sel = "";
				
				$i++;
				
				$sCombo .= "<option value='$i' $sel>$v</option>";			
			}
			return $sCombo;
		}


		function listaUf(){
		 $sql="
		    select * from TB_ESTADO
		 ";
		  $this ->sql($sql);
		
		  $arrObjEstadoBean = array();
		
		  while($linha=$this->linha())
		  {
		     $arrObjEstadoBean[] = $this->DaoToEstadoBean($linha);
		  }
		
		  return $arrObjEstadoBean;
		
		}
		
		function montaSelectComboArray2( $arrayCombo, $strCompara = NULL, $utf8 = false ){
			$sCombo = NULL;
			$sel	= NULL;
			
			foreach( $arrayCombo as $c => $v ){
				if( $c == $strCompara && $sel != " selected " ){
					$sel = " selected ";
				}else{
					$sel = "";
				}
				
				if( $utf8 == "utf8" ){
					$sCombo .= '<option value="' . $c . '"  ' . $sel . '> ' . utf8_encode($v) . '</option>';
				}
				else{
					$sCombo .= '<option value="' . $c . '" ' . $sel . '>' . $v . '</option>';
				}
			}
			
			return $sCombo;
		}
		
		function pegarConfig($strConfig){
		 $sql="
		    select valor
		      from TB_CONFIG
		     where campo = '$strConfig'
		 ";
		 $this->sql($sql);
		 $linha=$this->linha();
		 return $linha[valor];
		}
      
		// Início da Função de Paginação //
		function getPaginacao( $iPgnAtual, $sQryCount, $pagina, $aCamposWhere, $sOutros = NULL ){

			$iNumReg	= "10";
			$iPgnAtual	= $iPgnAtual;
			$sPaginacao = '<div align="center">';
	
			# Verifica a Qtde Total de Registros!
			$eQry = mysql_query( $sQryCount ) or die( "Erro MYSQL_QUERY Paginação: " . mysql_error() );
			$iQry = mysql_num_rows( $eQry );
			$iNumTT	= 0;
			$iNumTT1= 0;
			$iNumTT2= 0;
			
			if( $iQry > 0 ){
				while( $rQry = mysql_fetch_object($eQry) ){
					$iNumTT1 = $rQry->QTDE;
					$iNumTT2 += 1;
				}
			}
			
			// Decidindo q QTDE de Registros //
			if( $iNumTT2 > $iNumTT1 ){
				$iNumTT = $iNumTT2;
			}else{
				$iNumTT = $iNumTT1;
			}
	
			$iQtdePgn	= ( $iNumTT % $iNumReg == 0 ) ? intval( $iNumTT / $iNumReg ) : intval( $iNumTT / $iNumReg ) + 1;
			$iPrmReg	= $iPgnAtual * $iNumReg;
			$iUltReg	= ( intval( $iPgnAtual + 1 ) * $iNumReg ) > $iNumTT ? $iNumTT : intval( $iPgnAtual + 1 ) * $iNumReg;
	
			# Verifica se Realmente existe um Registro ao menos!
				if( $iNumTT > 0 ){ $iNumRealRegs = intval( $iPrmReg + 1 ); }else{ $iNumRealRegs = "0"; }
			####################################################
	
			$iPrmPgn	= ( intval( $iPgnAtual - 5 ) < 0 ) ? "0" : intval( $iPgnAtual - 5 );
			$iUltPgn	= ( intval( $iPgnAtual + 5 ) > $iQtdePgn ) ? $iQtdePgn : intval( $iPgnAtual + 5 );
	
			$sLink		= $pagina . '';
			
			if( $sOutros != NULL ){
				$sLink .= $sOutros;
			}
			
			/*foreach( $aCamposWhere as $chaves => $valores ){
				if( is_array( $valores ) ){
					foreach( $valores as $c => $v ){
						if ($c == "CRR_IDADE"){
							$sLink .= '&' . $c . '1=' . $v[2];
							$sLink .= '&' . $c . '2=' . $v[3];
						} else if ($c == "CRG_SAL" || $c == "FRM_ESCOL"){
							$sLink .= '&' . $c . '1=' . intval($v[0]);
							$sLink .= '&' . $c . '2=' . intval($v[1]);
						} else if ($c == "CRG_ID"){
							$sLink .= '&CRC_CARGO_PR=' . $v;
						} else {
							$sLink .= '&' . $c . '=' . $v;
						}
						
					}
				}
				else{
					$sLink .= '&' . $chaves . '=' . $valores;
					
				}
			}*/

			if( $sOutros != NULL ){
				if ($sOutros == "1"){
					$sLink .= '&iPgn=';
				}else{
					$sLink .= '&iPgn=';
				}
			}
			else{
				$sLink .= '&iPgn=';
			}
	
			$iAntPagina	= ( intval( $iPgnAtual - 1 ) < 0 ) ? "0" : intval( $iPgnAtual - 1 );
			$iPrxPagina	= ( intval( $iPgnAtual + 1 ) > $iQtdePgn - 1 ) ? $iQtdePgn - 1 : intval( $iPgnAtual + 1 );
	
			$sAntPagina	= '<div style="float: left; margin-left: 25px; padding: 7px;">Mostrando <span class="texto2">' . $iNumRealRegs . '</span> at&eacute; <span class="texto2">' . $iUltReg . '</span> de <span class="texto2">' . $iNumTT . '</span> registros</div>';
			$sMeio 	= '<div class="pagination"><ul><li class="prev"><a href="' . $sLink . $iAntPagina . '">&nbsp;</a></li>';
			
			$sMeio2 = NULL;
			
			for( $i = intval( $iPgnAtual - 5 ); $i < intval( $iPgnAtual + 5 ); $i++ ){
				if( $i < 0 || $i >= $iQtdePgn ){}
				else{
					if( $iPgnAtual == $i ){
						$txtPagina = '<b>' . intval( $i + 1 ) . '</b>';
					}
					else{
						$txtPagina = intval( $i + 1 );
					}
					
					if( $i == 0 ){ $sMeio2 .= '<li><a href="' . $sLink . $i . '">' . $txtPagina . '</a></li>'; }
					else if( $i == intval( $iQtdePgn - 1 ) ){ $sMeio2 .= '<li><a href="' . $sLink . $i . '">' . $txtPagina . '</a></li>'; }
					else{ $sMeio2 .= '<li><a href="' . $sLink . $i . '">' . $txtPagina . '</a></li>'; }
				}
			}
	
			$sPrxPagina = '<li class="next"><a href="' . $sLink . $iPrxPagina . '">&nbsp;</a></li>';
	
			$sPaginacao .= $sMeio . $sMeio2 . $sPrxPagina . '</ul></div>' . $sAntPagina;

			return array( $sPaginacao, $iPrmReg, $iNumReg );
		}
		// Fim da Função de Paginação == //
		
		//gera radios apartir de um array, utilizado em campos enum ex: $arrayCombo = array('MASCULINO','FEMININO')
		function montaRadiosArray( $label, $arrayCombo, $strCompara = NULL ){
			$sCombo = NULL;
			$index = 0;
			
			foreach( $arrayCombo as $c => $v ){
				if( $strCompara == "" ){ $strCompara = "NENHUM DOMÍNIO"; }
				
				if( $c == $strCompara )
					$checked = " checked ";
				else
					$checked = "";
				
				$sCombo .= '&nbsp;<label class="checks" for="'.$label.'_'.$index.'"><input class="radio" style="width: 15px;" type="radio" name="'.$label.'" id="'.$label.'_'.$index.'" value="'.$c.'" '.$checked.' />&nbsp;' . $v . '&nbsp;</label>';
				$index++;
			}
			
			return $sCombo;
		}
		
		// Substitui ESPAÇOS por PERCENTUAL
		function alterTermo( $termo ){
			
			$termo = str_replace( "á", "%", $termo );
			$termo = str_replace( "é", "%", $termo );
			$termo = str_replace( "í", "%", $termo );
			$termo = str_replace( "ó", "%", $termo );
			$termo = str_replace( "ú", "%", $termo );
			$termo = str_replace( "Á", "%", $termo );
			$termo = str_replace( "É", "%", $termo );
			$termo = str_replace( "Í", "%", $termo );
			$termo = str_replace( "Ó", "%", $termo );
			$termo = str_replace( "Ú", "%", $termo );
			$termo = str_replace( "ã", "%", $termo );
			$termo = str_replace( "õ", "%", $termo );
			$termo = str_replace( "Ã", "%", $termo );
			$termo = str_replace( "Õ", "%", $termo );
			$termo = str_replace( "ç", "%", $termo );
			$termo = str_replace( "Ç", "%", $termo );
			$termo = str_replace( " ", "%", $termo );
			$termo = str_replace( "'", "\'", $termo );
			
			return $termo;
		}
		
		// Substitui ESPAÇOS por PERCENTUAL
		function formatFloat( $termo ){
			$termo = str_replace( ".", "", $termo );
			$termo = str_replace( ",", ".", $termo );
			
			return $termo;
		}

		/*
   		  * Função utilizada para contar Vagas publicadas
		*/
		function countPublicadas( $where, $ASS_ID ){
			$qr = mysql_query( "SELECT *, DATE_FORMAT( VGA_DATAE, '%d/%m/%Y' ) as dt, c.CRG_NOME FROM TB_VAGA v, TB_CARGO c 
								WHERE v.VGA_STATUS IN( '5' ) and c.CRG_ID = v.VGA_CARGO ".$where."
								AND ASS_ID = ".$ASS_ID." 
								ORDER BY VGA_DATAE DESC" );
			$count = mysql_numrows($qr);
			return $count;	
		}
 
		/*
   	    * Função utilizada para listar Vagas publicadas
		*/
		function listarPublicadas( $de, $ate, $where, $ASS_ID, $ASS_CODEMP){
			$qr = mysql_query( "SELECT *, DATE_FORMAT( VGA_DATAE, '%d/%m/%Y' ) as dt, c.CRG_NOME FROM TB_VAGA v, TB_CARGO c 
								WHERE v.VGA_STATUS IN( '5' ) and c.CRG_ID = v.VGA_CARGO ".$where."
								AND (ASS_ID = ".$ASS_ID." OR USR_ID = ".$ASS_CODEMP.")
								ORDER BY VGA_DATAE DESC LIMIT " . $de . ", " . $ate );

			$arr = array();
			$arr2 = array();
			while($reg = mysql_fetch_object($qr)){
				$qrE = mysql_query( "SELECT CLI_CIDADE FROM tb_usuario WHERE USR_ID = " .  $reg->USR_ID);
				$regE = mysql_fetch_object($qrE);
			
				$arr["data"]		= $reg->dt;
				$arr["id"]			= $reg->VGA_ID;
				$arr["num_vagas"]	= $reg->VGA_NRO_VAGAS;
				$arr["resumo"]		= utf8_encode($reg->VGA_RESUMO);
				$arr["setor"]		= utf8_encode($reg->VGA_AREA);
				$arr["cargo"]		= utf8_encode($reg->CRG_NOME);
				$arr["cidade"]		= utf8_encode($regE->CLI_CIDADE);
				$arr2[] = $arr;
			}
		
			return $arr2;	
		}
		
		function verifyURL ($URL){
			$qr = mysql_query( "SELECT ASS_ID, ASS_CODEMP FROM TB_ASSINANTE WHERE ASS_URL LIKE '%$URL%'");
			while ($reg = mysql_fetch_object($qr)){
					$arrASS["ASS_ID"] = $reg->ASS_ID;
					$arrASS["ASS_CODEMP"] = $reg->ASS_CODEMP;
					$arr2[] = $arrASS;
			} 
			return $arr2;
		}

		/*
	     * Função utilizada para autenticar usuários
		*/
		function autentica_usuario( $CRR_CPF, $CRR_SENHA ){
			$erro[0] = 1;

			$sQry = "SELECT CRR_ID, ASS_ID, CRR_SENHA, CRR_NOME, CRR_STATUS FROM TB_CURRICULUM WHERE CRR_CPF IN('" . $CRR_CPF . "')";
		
			$eQry = mysql_query( $sQry );
			$iNum = mysql_num_rows( $eQry );
								
			if( $iNum > 0 ){
				$rQry = mysql_fetch_object( $eQry );
				
				$erro[1] = utf8_decode($rQry->CRR_NOME);
				$erro[2] = $rQry->CRR_ID;
				$erro[3] = $rQry->CRR_STATUS;
				$erro[4] = $rQry->ASS_ID;
				
				if( $rQry->CRR_STATUS != "1" ){ 
					$erro[0] = 4;	// Cadastro Inativo //
				}
				else if( md5( $CRR_SENHA ) != $rQry->CRR_SENHA ){ 
					$erro[0] = 2;	// Senha Inválida //
				}
			}
			else{
				$erro[0] = 3;		// CPF não existe na Base //
			}
		
			return $erro;
		}	

		function curriculo_Upd($arrValores,$CRR_ID){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

			$oCurriculo->upd($arrValores,$CRR_ID);
			return true;
		}		

		function seleciona_candidato_id($ID){
			$qr = mysql_query( "SELECT CRR_CPF, CRR_ID, CRR_SENHA, CRR_NOME FROM TB_CURRICULUM WHERE CRR_ID = " .  $ID . " AND CRR_STATUS = '95'");
			$arr = array();
			$arr2 = array();
		
			while($reg = mysql_fetch_object($qr)){
				$arr["CRR_ID"] = $reg->CRR_ID;
				$arr["CRR_CPF"] = $reg->CRR_CPF;
				$arr["CRR_SENHA"] = $reg->CRR_SENHA;
				$arr["CRR_NOME"] = utf8_encode($reg->CRR_NOME);
			
				$arr2[] = $arr;
			}
		
		 	return $arr2;
	 	
		}
	
		function seleciona_candidato($CPF){
			$qr = mysql_query( "SELECT CRR_ID, CRR_NOME, CRR_CELULAR, CRR_FRESIDENCIAL, CRR_EMAIL FROM TB_CURRICULUM WHERE CRR_CPF LIKE '" .  $CPF . "' ");
			$arr = array();
			$arr2 = array();
		
			while($reg = mysql_fetch_object($qr)){
				$arr["CRR_ID"] = $reg->CRR_ID;
				$arr["CRR_NOME"] = utf8_encode($reg->CRR_NOME);
				$arr["CRR_CELULAR"] = utf8_encode($reg->CRR_CELULAR);
				$arr["CRR_FRESIDENCIAL"] = utf8_encode($reg->CRR_FRESIDENCIAL);
				$arr["CRR_EMAIL"] = utf8_encode($reg->CRR_EMAIL);
			
				$arr2[] = $arr;
			}
		
		 	return $arr2;	
		}

		function seleciona_vaga($VGA_ID){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

        	$oCurriculo->sql("SELECT USR_ID, VGA_CARGO FROM TB_VAGA WHERE VGA_ID IN( '" . $VGA_ID . "' ) ");
			$linha = $oCurriculo->linha();
		
			return $linha;
		}
		
		function seleciona_vaga_etapa($VGA_ID, $ETP_ID){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

    	    $oCurriculo->sql("SELECT VGE_ID FROM TB_VAGA_ETAPA WHERE VGA_ID IN( '" . $VGA_ID . "' ) AND ETP_ID IN( '" . $ETP_ID . "' )");
			while( $linha = $oCurriculo->linha()){
				$arr[] = $linha;
			}
		
			return $arr;
		}
		
		function triagem_candidato($VGA_ID, $CRR_ID, $cand){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

    	    $oCurriculo->sql( "SELECT COUNT(*) AS QTDE FROM TB_TRIAGEM WHERE VGA_ID IN( '" . $VGA_ID . "' ) AND (CRR_ID IN( '" . $CRR_ID . "' ) OR LOWER( TRG_CANDIDATO) LIKE ('%" . strtolower( base64_decode($cand)). "%') )");
			while( $linha = $oCurriculo->linha()){
				$arr[] = $linha;
			}
		
			return $arr;
		}
	
		function triagem_candidato_limite($CRR_ID,$dataAnterior,$now){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

    	    $oCurriculo->sql("SELECT COUNT(*) AS QTDE FROM TB_TRIAGEM WHERE CRR_ID IN( '" . $CRR_ID . "' )
						AND TRG_DATA BETWEEN '" . $dataAnterior . "' AND '" . $now . "'");
			while( $linha = $oCurriculo->linha()){
				$arr[] = $linha;
			}
		
			return $arr;
		}
	
		function insere_triagem($data,$CRR_ID,$VGA_ID,$USR_ID,$CRR_NOME,$CRR_FRESIDENCIAL,$CRR_CELULAR,$CRR_EMAIL){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

       		 $oCurriculo->sql( "INSERT INTO TB_TRIAGEM( ASS_ID, TRG_DATA, CRR_ID, TRG_FONTE, VGA_ID, USR_ID, TRG_CANDIDATO, TRG_TELEFONE, TRG_CELULAR, TRG_EMAIL, TRG_RESULTADO, USR_ID ) VALUES( '2', '" . $data . "', '" . $CRR_ID . "', 'MakroRH', '" . $VGA_ID . "', '" . $USR_ID . "', '" . $CRR_NOME . "', '" . $CRR_FRESIDENCIAL . "', '" . $CRR_CELULAR . "', '" . $CRR_EMAIL . "', '', '16' )");
		
			return 1;
		}
		
		function insere_processo($VGE_ID,$CRR_ID,$data){
			require_once( "../../classes/DAO/CurriculoDAO.php" );
			$oCurriculo	= new CurriculoDAO();

        	$oCurriculo->sql( "INSERT INTO TB_PROCESSO( VGE_ID, CRR_ID, USR_ID, PRC_OBS, PRC_DATA ) VALUES( '" . $VGE_ID . "', '" . $CRR_ID . "', '16', 'AUTO-TRIAGEM', '" . $data . "' )" );
		
			return 1;
		}
		
		function verifySMS($VGA_ID,$CRR_ID){ 
			$mQry = mysql_query("SELECT a.DVS_ID FROM TB_DIVULGASMS a INNER JOIN TB_DIVULGASMS_CONTATOS b
								ON a.DVS_ID = b.DVS_ID WHERE a.VGA_ID = $VGA_ID AND b.CRR_ID = $CRR_ID");
			$result = mysql_num_rows($mQry);
	
			return $result;
		}

		function getDados($VGA_ID,$CRR_ID){
			$mQry = mysql_query("SELECT DSC_STATUS, DSC_TEXTO FROM TB_DIVULGASMS a 
								INNER JOIN TB_DIVULGASMS_CONTATOS b
								ON a.DVS_ID = b.DVS_ID WHERE a.VGA_ID = $VGA_ID AND b.CRR_ID = $CRR_ID");
			while($reg = mysql_fetch_object($mQry)){
				$arr["DSC_STATUS"] = $reg->DSC_STATUS;
				$arr["DSC_TEXTO"] = utf8_encode($reg->DSC_TEXTO);
			
				$arr2[] = $arr;
			}
		
			return $arr;
		}
		
		/**
		 * Efetua uma consulta pelo cep dado
		 * Retorna um array de CEP, ENDERECO, BAIRRO, CIDADE e UF
		 * @param String $cep
		 */
		function consultaCEP($cep) {
			$cep = preg_replace("([.-])", "", $cep);
			
			$this->sql("SELECT 
							IF(E.ENDERECO_CEP IS NULL,C.CIDADE_CEP,E.ENDERECO_CEP) AS CEP,
							CONCAT(TL.ABREVIATURA,' ',E.ENDERECO_LOGR) AS ENDERECO,
							B.BAIRRO_DESCRICAO AS BAIRRO,
							C.CIDADE_ID AS CIDADE,
							UF.UF_ID AS UF
						FROM CEP_ENDERECO AS E
						LEFT OUTER JOIN CEP_BAIRRO AS B ON E.BAIRRO_ID = B.BAIRRO_ID
						LEFT OUTER JOIN TB_CIDADE AS C ON B.CIDADE_ID = C.CIDADE_ID
						LEFT OUTER JOIN CEP_TIPO_LOGRADOURO AS TL ON TL.TIPO_LOGRADOURO_ID = E.TIPO_LOGRADOURO_ID
						LEFT OUTER JOIN TB_UF AS UF ON UF.UF_ID = C.UF_ID
						WHERE E.ENDERECO_CEP = '" . $cep . "' OR C.CIDADE_CEP = '" . $cep . "'");
			$linha = $this->linha();
			return $linha;
		}
		
		function verifyEstrelas ($NOTA){
			if ($NOTA == "1"){
				echo ("<img src='templates/images/estrelas1.png' />");
			}else if ($NOTA == "2"){
				echo ("<img src='templates/images/estrelas2.png' />");
			}else if ($NOTA == "3"){
				echo ("<img src='templates/images/estrelas3.png' />");
			}else if ($NOTA == "4"){
				echo ("<img src='templates/images/estrelas4.png' />");
			}else if ($NOTA == "5"){
				echo ("<img src='templates/images/estrelas5.png' />");
			}
		}

	}
?>