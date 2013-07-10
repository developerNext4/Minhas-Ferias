<?php
	/******** CHANGELOG:: Utils.php
		Autor:	Andryon
		Data:	28/02/2012 
		
		Retirada do DIRPATH do caminho da classe UtilsDAO, 
		pois est� redlecarando duas conex�es e apontando para Makrosis
		
	********************/
	
	// Defini se est� em Ambiente de Produ��o ou de Desenvolvimento //
		if( isset( $_SERVER["HTTP_X_REQUESTED_WITH"] ) ){
			if( strpos( $_SERVER["REQUEST_URI"], "ajx" ) > 0 ) {
				if( strpos( $_SERVER["REQUEST_URI"], "_interfaces" ) > 0  ){
					require_once( "../../../classes/defines.php" );
				}
				else{
					require_once( "./classes/defines.php" );
				}
			}
			else{
				require_once( "../../../classes/defines.php" );
			}
		}
		else if( strpos( $_SERVER["REQUEST_URI"], "_interfaces/_candidatos" ) > 0  ){
			require_once( "../../classes/defines.php" );
		}
		else if( strpos( $_SERVER["REQUEST_URI"], "_interfaces/_clientes" ) > 0  ){
			require_once( "../../classes/defines.php" );
		}
		else if( strpos( $_SERVER["REQUEST_URI"], "_crontab/" ) > 0  ){
			require_once( "../classes/defines.php" );
		}
		else{
			require_once( "./classes/defines.php" );
		}
	// ============================================================ //
	
	require_once( "classes/DAO/UtilsDAO.php" );
	class Util
	{	
	  
	function porcentagemExtenso($valor=0) {
			
			$relacao = array(
				1 => "um", 2 => "dois", 3 => "tr�s", 4 => "quatro", 5 => "cinco", 
				6 => "seis", 7 => "sete", 8 => "oito", 9 => "nove", 10 => "dez",
				11 => "onze", 12 => "doze", 13 => "treze", 14 => "quatorze", 15=> "quinze", 
				16 => "dezesseis", 17 => "dezessete", 18 => "dezoito", 19 => "dezenove", 20 => "vinte",
				30 => "trinta", 40 => "quarenta", 50 => "cinquenta", 60 => "sessenta", 70 => "setenta", 
				80 => "oitenta", 90 => "noventa", 100 => "cem"
			);
			
			$valor = number_format($valor, 2, ".", ".");
			$inteiro = explode(".", $valor);
			$dezenas = $inteiro[0];
			$decimos = $inteiro[1];
			
			if ( $dezenas >= 1 && $dezenas <= 20 )
	      		return $relacao[$dezenas];	
	    	else if ( $valor >= 21 && $valor <= 100 ) {
	      		$resto = $valor % 10;
	    		$dezena = $valor - $resto;
	      		$ret = $relacao[$dezena];
		    	if($resto > 0) $ret .= ' e ' . $relacao[$resto];
		      	return $ret;
		    } else if ( $valor >= 101 && $valor <= 199 ) {
		    	$resto = $valor % 100;
		    	return "cento e " . $relacao[$resto];
		    } else if ( $valor >= 200 ) {
		    	return "duzentos";
		    } else if ( $valor >= 201 && $valor <= 299 ) {
		    	$resto = $valor % 200;
		    	return "duzentos e " . $relacao[$resto];
		    }
			
		}
		
		function valorPorExtenso($valor) {
			$singular = array("centavo", "real", "mil", "milh�o", "bilh�o", "trilh�o",
			"quatrilh�o");
			$plural = array("centavos", "reais", "mil", "milh�es", "bilh�es",
			"trilh�es",
			"quatrilh�es");
			
			$c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
			"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
			$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
			"sessenta", "setenta", "oitenta", "noventa");
			$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
			"dezesseis", "dezesete", "dezoito", "dezenove");
			$u = array("", "um", "dois", "tr�s", "quatro", "cinco", "seis",
			"sete", "oito", "nove");
			
			$z=0;
			
			$valor = number_format($valor, 2, ".", ".");
			$inteiro = explode(".", $valor);
			for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];
			
			// $fim identifica onde que deve se dar jun��o de centenas por "e" ou por "," ;)
			$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
			$rt='';
			for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]])
			: "";
			
			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
			$ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " :
			"").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
			($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
			}
			
			return($rt ? $rt : "zero");
		}
		
		function compararDatas($data1,$data2){
		 if($data1 > $data2){
			return 1;
		 }elseif($data1<$data2){
			return 2;
		 }elseif($data1==$data2){
			return 0;
		 }
	  }
	  
	  // Substitui ESPA�OS por PERCENTUAL
	  function alterTermo( $termo ){
		
		$termo = $this->limpa( $termo );
		$termo = str_replace( " ", "%", $termo );
		
		return $termo;
	  }
	
	  function dataEmIntervalo($dataVerificar,$dataIni,$dataFim)
	  {
		 //apenas em yyy-mm-dd
		 if($dataVerificar >= $dataIni && $dataVerificar <= $dataFim){
			return 1;
		 }else{
			return 0;
		 }
	
	  }
	  
	function CalcularIdade( $nascimento ){
		$aniv = explode( "-", $nascimento ); 			//separa a data de nascimento em array, utilizando o s�mbolo de - como separador
		$atual = explode( "-", date( "Y-m-d" ) ); 		//separa a data de hoje em array

		$idade = $atual[0] - $aniv[0];
		
		if( $aniv[1] > $atual[1] ){ 					//verifica se o m�s de nascimento � maior que o m�s atual
			$idade--; 									//tira um ano, j� que ele n�o fez anivers�rio ainda
		}
		elseif( $aniv[1] == $atual[1] 
			&& $aniv[2] > $atual[2] ){ 					//verifica se o dia de hoje � maior que o dia do anivers�rio
			$idade--; 									//tira um ano se n�o fez anivers�rio ainda
		}
		
		return $idade; //retorna a idade da pessoa em anos
	}
	
	 function retornaFormacao($idFormacao) {
			switch ($idFormacao){
				case 1:
					$formacao = "Ensino Fundamental";
				break;	
				case 3:
					$formacao = "Ensino M�dio";
				break;	
				case 5:
					$formacao = "P�s-m�dio (t�cnico)";
				break;	
				case 7:
					$formacao = "Ensino Superior";
				break;	
				case 9:
					$formacao = "P�s Gradua��o";
				break;	
				case 11:
					$formacao = "Mestrado";
				break;	
				case 13:
					$formacao = "Doutorado";
				break;	
				default:{
					$formacao = "N�o Informado";
					break;
				}
			}
			
			return $formacao; //retorna a formacao segundo o id
	}
	function retornaEstadoCivil($idEstCivil) {
			switch ($idEstCivil){
				case 0:
					$estCivil= "Casado";
				break;	
				case 1:
					$estCivil= "Desquitado";
				break;	
				case 2:
					$estCivil= "Divorciado";
				break;	
				case 3:
					$estCivil= "Separado";
				break;	
				case 4:
					$estCivil= "Solteiro";
				break;	
				case 5:
					$estCivil= "Vi�vo";
				break;	
				case 6:
					$estCivil= "Uni�o Est�vel";
				break;	
			}
			
			return $estCivil; //retorna a formacao segundo o id
	}

	
	  function listaUf()
	  {
		 $UtilsDAO = new UtilsDAO();
		 $arrUfBean =$UtilsDAO->listaUf();
		 return $arrUfBean;
	  }
	
	  function pegarConfig($strCampo){
		 $UtilDAO= new UtilsDAO();
		 return $UtilDAO->pegarConfig($strCampo);
	  }
	  
		function converteClass($clsTxt){
			$aClass['ok'] = "erroForm";
			$aClass['al'] = "sucessoForm";
			$aClass['er'] = "alertaForm";
			
			return $aClass[$clsTxt];
		}
		
		function getMensagem( $tipo ){
			if( strtoupper($tipo) == "" ){
				return NULL;
			}
			else{
				$aMsgErro[strtoupper('erroAcaoTela')] 	= "ERRO: A��o desconhecida para esta Tela!";
				$aMsgErro[strtoupper('insertOk')] 		= "OK: Registro inserido com SUCESSO!";
				$aMsgErro[strtoupper('insertErro')] 	= "ERRO: Problemas ao inserir o registro!";
				$aMsgErro[strtoupper('updateOk')] 		= "OK: Registro alterado com SUCESSO!";
				$aMsgErro[strtoupper('updateErro')] 	= "ERRO: Problemas ao alterar o registro!";
				$aMsgErro[strtoupper('deleteOk')] 		= "OK: Registro exclu&iacute;do com SUCESSO!";
				$aMsgErro[strtoupper('deleteDNVErro')] 	= "ERRO: O diret�rio selecionado n&atilde;o est&aacute; vazio!";
				$aMsgErro[strtoupper('deleteErro')] 	= "ERRO: Problemas ao excluir o registro!";
				$aMsgErro[strtoupper('listNULL')] 		= "ALERTA: N&atilde;o existem dados para a sua pesquisa!";
				$aMsgErro[strtoupper('uploadOk')] 		= "OK: Arquivo enviado com sucesso!";
				$aMsgErro[strtoupper('uploadEr')] 		= "ERRO: Arquivo com extens�o n�o permitida!";
				$aMsgErro[strtoupper('upSizeEr')] 		= "ERRO: Arquivo com tamanho (em Kb) acima do permitido!";
				$aMsgErro[strtoupper('upPermEr')] 		= "ERRO: Arquivo n�o enviado! Prov�vel problema de permiss�o.";
				$aMsgErro[strtoupper('uploadErCrr')]	= $aMsgErro[strtoupper('updateOk')] . "<br />ERRO: Foto com extens�o n�o permitida!";
				$aMsgErro[strtoupper('upSizeErCrr')] 	= $aMsgErro[strtoupper('updateOk')] . "<br />ERRO: Foto com tamanho (em Kb) acima do permitido!";
				$aMsgErro[strtoupper('upPermErCrr')]	= $aMsgErro[strtoupper('updateOk')] . "<br />ERRO: Foto n�o enviada! Prov�vel problema de permiss�o.";
				$aMsgErro[strtoupper('upErrArqOrg')]	= $aMsgErro[strtoupper('updateOk')] . "<br />ERRO: Foto original n�o p�de ser exclu�da!";
				$aMsgErro[strtoupper('erDplTriagem')] 	= "ERRO: TRIAGEM n�o inserida! Este candidato j� foi Triado para esta Vaga/OS.";
				$aMsgErro[strtoupper('insertOrdOk')] 	= "OK: Ordens inseridas com sucesso, continue o processo de sele��o!";
				$aMsgErro[strtoupper('insertOrdEr')] 	= "ERRO: Ocorreu um erro ao gravar as Ordens, volte e refa�a novamente!";
				$aMsgErro[strtoupper('insertOrdIn')] 	= "ERRO: Preencha uma ordem Correta!";
				$aMsgErro[strtoupper('mkdirErro')] 		= "ERRO: Diret�rio n&atilde;o criado! Prov&aacute;vel problema de permiss&atilde;o.";
				$aMsgErro[strtoupper('upErrBD')]		= "ERRO: Arquivo n&atilde;o enviado! Prov&aacute;vel incosist�ncia no Banco de Dados.";
				$aMsgErro[strtoupper('autorizadoErro')] = "ERRO: Voc&ecirc; n&atilde;o tem autoriza&ccedil;&atilde;o para essa a&ccedil;&atilde;o!";
	
				return $aMsgErro[strtoupper($tipo)];
			}
		}
		
		function getCombo( $valor, $type = NULL, $controle = NULL ){
			$sCombo = NULL;
			
			if( $type == "meses" ){
				$aMeses = array(	"01" => "Janeiro", "02" => "Fevereiro", "03" => "Mar�o", "04" => "Abril"
									, "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto"
									, "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro" );
									
				foreach( $aMeses as $chaves => $valores ){
					if( $chaves == $valor ){
						$sCombo .= '<option value="' . $chaves . '" selected>' . $valores . '</option>';
					}
					else{
						$sCombo .= '<option value="' . $chaves . '">' . $valores . '</option>';
					}
				}
			}
			else{
				// TRATANDO O COMBO DE STATUS PARA CLIENTES //
				if( $controle == 1 ){
					if( $valor == 1 ){
						$sCombo .= '<option value="1" selected>Ativo</option>';
						$sCombo .= '<option value="0">Inativo</option>';
						$sCombo .= '<option value="2">Prospect</option>';
						$sCombo .= '<option value="3">N�o Contatado</option>';
					}
					else if( $valor == 0 ){
						$sCombo .= '<option value="1">Ativo</option>';
						$sCombo .= '<option value="0" selected>Inativo</option>';
						$sCombo .= '<option value="2">Prospect</option>';
						$sCombo .= '<option value="3">N�o Contatado</option>';
					}
					else if( $valor == 2 ){
						$sCombo .= '<option value="1">Ativo</option>';
						$sCombo .= '<option value="0">Inativo</option>';
						$sCombo .= '<option value="2" selected>Prospect</option>';
						$sCombo .= '<option value="3">N�o Contatado</option>';
					}
					else if( $valor == 3 ){
						$sCombo .= '<option value="1">Ativo</option>';
						$sCombo .= '<option value="0">Inativo</option>';
						$sCombo .= '<option value="2">Prospect</option>';
						$sCombo .= '<option value="3" selected>N�o Contatado</option>';
					}
				}else{
					if( $valor == 1 ){
						$sCombo .= '<option value="1" selected>Ativo</option>';
						$sCombo .= '<option value="0">Inativo</option>';
					}else if( $valor == 0 ){
						$sCombo .= '<option value="1">Ativo</option>';
						$sCombo .= '<option value="0" selected>Inativo</option>';
					}else if( $valor == 3 ){
						$sCombo .= '<option value="0" selected>N�o Avaliado</option>';
						$sCombo .= '<option value="1">Aprovado</option>';
						$sCombo .= '<option value="2">Reprovado</option>';
						$sCombo .= '<option value="3">Banco de Dados</option>';
						$sCombo .= '<option value="4">Desistente</option>';
					}
				}
			}
			
			return $sCombo;
		}
		
		function difDates( $databd1, $databd2 ){
			$str_mes = NULL;
			$str_dia = NULL;
			$str_ano = NULL;
			
			if( $databd2 == "0000-00-00" ){ $databd2 = date( "Y-m-d" ); }
			
			$data1 = explode( "-", $databd1 );
			$data2 = explode( "-", $databd2 );
			
			$ano = $data2[0] - $data1[0];
			$mes = $data2[1] - $data1[1];
			$dia = $data2[2] - $data1[2];
			
			if( $mes < 0 ){
				$ano--;
				$mes = 12 + $mes;
			}

			if( $dia < 0 ){
				$mes--;
				$dia = 30 + $dia;
			}
			
			if( $ano > 0 ) $str_ano  = $ano . " ano";
			if( $ano > 1 ) $str_ano .= 's';
			
			if( $mes > 0 ) $str_mes  = $mes . " mes";
			if( $mes > 1 ) { if( $ano > 0 ) $str_ano .= ' e '; $str_mes .= 'es'; }
			
			if( $dia > 0 ) $str_dia  = $dia . " dia";
			if( $dia > 1 ) { if( $mes > 0 ) $str_mes .= ' e '; $str_dia .= 's'; }
			
			return "$str_ano $str_mes $str_dia";
		}
		
		function codificadata($data){

		  //Verifica o tipo da data
		
		  if (strlen($data) == 14){
		
			  //quebrando uma data timestamp
		
			  $output = substr($data,6,2) . '/' . substr($data,4,2) . '/' . substr($data,0,4);
		
			  return $output;
		
		  }
		
		  else
		
		  {
		
			  if((strstr($data, "-")) && (strlen($data)==10)){
		
				$arrdata = explode ("-", $data);
		
				return $arrdata[2] . "/" . $arrdata[1] . "/" . $arrdata[0];  
		
			  }
		
			  else if((strstr($data, "/")) && (strlen($data)==10)){
		
			  $arrdata = explode ("/", $data);
		
			  return $arrdata[2] . "-" . $arrdata[1] . "-" . $arrdata[0];    
		
			  }
		
			  else
		
			  {
		
			  return $data;
		
			  }
		
		  }
		
		}
		
		function limpa( $termo ) {
			
			$termo = str_replace( "�", "a", $termo );
			$termo = str_replace( "�", "A", $termo );
			$termo = str_replace( "�", "a", $termo );
			$termo = str_replace( "�", "A", $termo );
			$termo = str_replace( "�", "a", $termo );
			$termo = str_replace( "�", "A", $termo );
			$termo = str_replace( "�", "a", $termo );
			$termo = str_replace( "�", "A", $termo );
			$termo = str_replace( "�", "a", $termo );
			$termo = str_replace( "�", "A", $termo );

			$termo = str_replace( "�", "e", $termo );
			$termo = str_replace( "�", "E", $termo );
			$termo = str_replace( "�", "e", $termo );
			$termo = str_replace( "�", "E", $termo );
			$termo = str_replace( "�", "e", $termo );
			$termo = str_replace( "�", "E", $termo );
			$termo = str_replace( "�", "e", $termo );
  			$termo = str_replace( "�", "E", $termo );
			
			$termo = str_replace( "�", "i", $termo );
			$termo = str_replace( "�", "I", $termo );
			$termo = str_replace( "�", "i", $termo );
			$termo = str_replace( "�", "I", $termo );
			$termo = str_replace( "�", "i", $termo );
			$termo = str_replace( "�", "I", $termo );
			
			$termo = str_replace( "�", "o", $termo );
			$termo = str_replace( "�", "O", $termo );
			$termo = str_replace( "�", "o", $termo );
			$termo = str_replace( "�", "O", $termo );
			$termo = str_replace( "�", "o", $termo );
			$termo = str_replace( "�", "O", $termo );
			$termo = str_replace( "�", "o", $termo );
			$termo = str_replace( "�", "O", $termo );
			$termo = str_replace( "�", "o", $termo );
			$termo = str_replace( "�", "O", $termo );

			$termo = str_replace( "�", "u", $termo );
			$termo = str_replace( "�", "U", $termo );
			$termo = str_replace( "�", "u", $termo );
			$termo = str_replace( "�", "U", $termo );
			$termo = str_replace( "�", "u", $termo );
			$termo = str_replace( "�", "U", $termo );
			
			$termo = str_replace( "�", "n", $termo );
			$termo = str_replace( "�", "N", $termo );
			
			$termo = str_replace( "�", "c", $termo );
			$termo = str_replace( "�", "C", $termo );
			
			$termo = str_replace( "'", "", $termo );

			
			return $termo;
		}
		
		/**
			Valida a extens�o dos arquivos enviados via upload. Caso tenha uma extens�o que n�o est� liberada, n�o permite a execu��o do upload
			@parametros $type => tipo do arquivo permitido
		*/
		function validaUpload( $type, $foto = false ){
			$aTipos["image/gif"] = true;
			$aTipos["image/png"] = true;
			$aTipos["image/jpeg"] = true;
			$aTipos["image/pjpeg"] = true;
			$aTipos["application/pdf"] = true;
			$aTipos["application/msword"] = true;
			$aTipos["application/vnd.ms-excel"] = true;
			$aTipos["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"] = true;
			$aTipos["application/vnd.openxmlformats-officedocument.wordprocessingml.document"] = true;
		
			if( $foto ){
				if( $type == "image/gif"
					|| $type == "image/png"
					|| $type == "image/jpeg"
					|| $type == "image/pjpeg" ){
					return true;
				}
				else{
					return false;
				}
			}
			else if( isset( $aTipos[$type] ) && !empty( $aTipos[$type] ) ){
				return $aTipos[$type];
			}
			else{
				return false;
			}
		}
		
		/**
			Recebe o tipo o arquivo e retorna a sua extens�o
			@parametros $type => tipo do arquivo
		*/
		function converteExtensao( $type, $array = false ){
			$aTipos["image/gif"] = ".gif";
			$aTipos["image/png"] = ".png";
			$aTipos["image/jpeg"] = ".jpg";
			$aTipos["image/pjpeg"] = ".jpg";
			$aTipos["application/pdf"] = ".pdf";
			$aTipos["application/msword"] = ".doc";
			$aTipos["application/vnd.ms-excel"] = ".xls";
			$aTipos["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"] = ".xlsx";
			$aTipos["application/vnd.openxmlformats-officedocument.wordprocessingml.document"] = ".docx";
			
			if( $array ){
				return $aTipos;
			}
			else{
				return $aTipos[$type];
			}
		}
		
		/**
		 Cria��o: Wagner Charle Lingenover | 41 9121-3058 - lingenover@gmail.com - 10/07/2003
		 Altera��o: Wagner Charle Lingenover | 41 9121-3058 - lingenover@gmail.com - 10/07/2003
		
		 Esta fun��o retorna um caminho completo baseado em um caminho relativo informado
		 Ex.: dado o arquivo upload.php como par�metro arquivo
		 � obtido o diret�rio: /root/site/pasta1/pasta12/
		 Caso seja informado o diret�rio "../pasta2/pasta21/"
		 Ser� retornado o diret�rio /root/site/pasta2/pasta21/
		 Par�metros:
		 abase: arquivo base que ser� acessado para se obter o caminho completo, � recomendado que esse arquivo esteja no mesmo diret�rio do arquivo que chama a fun��o
		 crelativo: caminho relativo que quer ser obtido
		*/

		function ondeestou($crelativo = ""){
			$contasubidas	= NULL;
			$sondeestou		= NULL;
			$wdir_a			= NULL;
			$udir_a			= NULL;
			
			$caminhocompleto = $_SERVER['SCRIPT_FILENAME'];
			$caminhocompleto = str_replace("\\","/", $caminhocompleto);
			
			// verificando se h� subidas
				while(strstr($crelativo, "../")){
						$contasubidas++;
						$crelativo = substr($crelativo,3,strlen($crelativo));				
					}
				if(trim($crelativo) != ""){
					$crelativo .= "/";
				}
			
			// recortando o caminho completo com base nas subidas
				$dir_a		  = explode("/", $caminhocompleto);
				$caminhofinal = "";
				if(count($dir_a)>0){
					for($iondeestou = 0; $iondeestou < ((count($dir_a) - ($contasubidas)) - 1); $iondeestou++){
						$caminhofinal  .= $sondeestou . $dir_a[$iondeestou] ;
						$sondeestou		= "/";
					}
					$caminhofinal .= $sondeestou;
				}
		
			if((count($wdir_a) == 0)&&(count($udir_a) == 0)){
				return $caminhofinal . $crelativo;
			}else{
				return $caminhofinal . $crelativo;
			}
		}
		
		/**
			Verifica se o Candidato possui algum anexo para aquela Vaga/Etapa do Processo Seletivo
			@parametros $type => tipo do arquivo
		*/
		function getAnexosProcesso( $PRC_ID ){
			$sSaidaHTML = NULL;
			
			foreach( $this->converteExtensao( NULL, true ) as $ch => $vl ){
				$arquivo = $this->ondeestou( "anexos" ) . $PRC_ID . $vl;
				$arqview = "anexos/" . $PRC_ID . $vl;
				$imagem	 = "anexos/icons/" . str_replace( ".", "", $vl ) . ".jpg";
				
				if( file_exists( $arquivo ) ){
					$sSaidaHTML .= '&nbsp;<a href="' . $arqview . '" alt="Visualizar Anexo" target="_blank"><img src="' . $imagem . '" width="15" /></a>&nbsp;';
				}
			}
			
			return $sSaidaHTML;
		}
		
		/**
			Executa o upload de fotos e a redimensiona //
			@parametros $type => tipo do arquivo
		*/
		function upFotos( $origem, $destino ){
			if( move_uploaded_file( $origem, $destino ) ){
				// FOR�ANDO PERMISS�O DE VISUALIZA��O DAS FOTOS //
					chmod( $destino, 0666 );
					
				// LOAD FILE - LEITURA DO ARQUIVO //
					$img = ImageCreateFromFile( $destino );

				// REDIMENSIONANDO A IMAGEM //
					$img = ImageResizeToFit( $img, 150, false );
					imagejpeg( $img, $destino, 50 );
					chmod( $destino, 0666 );
					imagedestroy($img);
				// FIM: REDIMENSIONAMENTO DE FOTO //
				
				return true;
			}
			else{
				return false;
			}
		}
		
		/**
			Limpa as ocorr�ncias de 'Aspas Simples'
			@parametros $array => post enviado pelo formul�rio
		*/
		function limpaAspas( $array ){
			foreach( $array as $ch => $vl ){
				if( !is_array( $array[$ch] ) ){
					$array[$ch] = addslashes( $array[$ch] );
				}
			}
			
			return $array;
		}
		
		/**
			Convert para Mai�sculas
			@parametros $array => post enviado pelo formul�rio
		*/
		
		function convertUpperCase( $array ){
			$arrayNegativo[1] = "acaoTela";
			$arrayNegativo[2] = "msgTxt";
			$arrayNegativo[3] = "clsTxt";
			$arrayNegativo[4] = "_SALVAR";
			
			if( is_array( $array ) ){
				foreach( $array as $ch => $vl ){
					if( !is_array( $array[$ch] ) && intval( array_search( $ch, $arrayNegativo ) ) <= 0 ){
						$array[$ch] =  strtoupper( $this->limpa( $array[$ch] ) );
					}
				}
				
				return $array;
			}
			else{
				return strtoupper( $this->limpa( addslashes( $array ) ) );
			}
		}
		
		/**
			Montando o conjunto de Checks para os Perfis de Vagas
			@parametros $array => op��es previamente selecionadas
		*/
		function comboPerfisVagas( $_aSelecionados = NULL ){
			$_aPerfis["2"] = "Est�gios & Trainees";
			$_aPerfis["3"] = "Operacionais de Produ��o";
			$_aPerfis["4"] = "Call center";
			$_aPerfis["5"] = "Assistentes";
			$_aPerfis["6"] = "T�cnicos de N�vel M�dio";
			$_aPerfis["7"] = "T�cnicos de N�vel Superior";
			$_aPerfis["8"] = "Analistas com N�vel Superior";
			$_aPerfis["9"] = "Gest�o";
			$_aPerfis["10"]= "TI (Tecnologia da Informa��o)";
			$_aPerfis["11"]= "Engenharia";

			$sSaidaHTML = NULL;
			$iCont		= 0;
			$_checked	= NULL;
			
			foreach( $_aPerfis as $_chP => $_vlP ){
				$iCont++;
				
				foreach( $_aSelecionados as $_chS => $_vlS ){
					if( $_chP == $_vlS ){
						$_checked = ' checked="checked"';
						break;
					}
					else{
						$_checked = NULL;
					}
				}
				
				$sSaidaHTML .= '<div class="perfis_vagas"><input class="check" type="checkbox" name="PRF_VAGAS[' . $_chP . ']" id="PRF_VAGAS' . $iCont . '" value="' . $_chP . '" ' . $_checked . ' />&nbsp;' . $_vlP . '</div>';
			}
			
			// ADICIONANDO O CONTADOR //
			$sSaidaHTML .= '<input type="hidden" name="_Perfis_Contador" id="_Perfis_Contador" value="' . $iCont . '" />';

			return $sSaidaHTML;
		}
		
		function mailerSend( $remetente, $destinatario, $titulo, $mensagem, $email = "recrutamento" ){
			require_once( _DIRPATH . "classes/_bibliotecas/PHPMailer_v5.1/class.phpmailer.php" );
	   
			$mailer = new PHPMailer();

			// Define os Dados do Remetente do E-mail //
				if( $email == "mkrrh_comercial" ){
					$mailer->Host 		= 'smtp.makrorh.com.br';
					$mailer->Username 	= 'comercial@makrorh.com.br';			// Informe o e-mai o completo
					$mailer->Password 	= 'mkrss3112';							// Senha da caixa postal
				}
				// Disparos de Divulga��o pelo Site da MakroRH //
				else if( $email == "recrutamento" ){
					$mailer->Host 		= 'smtp.makrorh.com.br';
					$mailer->Username 	= 'recrutamento@makrorh.com.br';		// Informe o e-mai o completo
					$mailer->Password 	= 'mkrss3112';							// Senha da caixa postal
				}
				// Disparos de Divulga��o pelo Site da MakroSis //
				else if( $email == "makrosis" ){
					$mailer->Host 		= 'smtp.makrosis.com.br';
					$mailer->Username 	= 'makrorh@makrosis.com.br'; 			// Informe o e-mai o completo
					$mailer->Password 	= 'mkrss3112';							// Senha da caixa postal
				}
				// Disparos de Divulga��o pelo Site da QueroUmEmprego //
				else if( $email == "queroumemprego" ){
					$mailer->Host 		= 'smtp.queroumemprego.com.br';
					$mailer->Username 	= 'makrorh@queroumemprego.com.br';		// Informe o e-mai o completo
					$mailer->Password 	= 'mkrss3112';							// Senha da caixa postal
				}
				// Disparos de Divulga��o pelo Site da EuQueroUmEmprego //
				else if( $email == "euqueroumemprego" ){
					$mailer->Host 		= 'smtp.euqueroumemprego.com.br';
					$mailer->Username 	= 'makrorh@euqueroumemprego.com.br';	// Informe o e-mai o completo
					$mailer->Password 	= 'mkrss3112';							// Senha da caixa postal
				}
			// ====================================== //
		
			$mailer->AddReplyTo("recrutamento@makrorh.com.br");
			$mailer->IsSMTP();
			$mailer->IsHTML(true);
			$mailer->SMTPDebug = 1;
			$mailer->Port = 587; 						// Indica a porta de conex�o para a sa�da de e-mails
			$mailer->SMTPAuth = true; 					// Define se haver� ou n�o autentica��o no SMTP (mantenha como true)
			$mailer->FromName = $remetente;				// Nome que ser� exibido para o destinat�rio
			$mailer->From = $mailer->Username;			// Obrigat�rio ser a mesma caixa postal indicada em "username"
			$mailer->AddAddress( $destinatario, '' );
			$mailer->Subject = $titulo;
			$mailer->Body = $mensagem;
			
			# Registra o envio, grava se enviou corretamente ou se deu erro no envio!
			if( $mailer->Send() ){
				$sStatus = "1";
			}
			else{
				$sStatus = "2";
			}
			#die( $mailer->Username . " [".$mailer->Password."] " . " -> " . $sStatus);
			return $sStatus;
		}
		
		function dataExtenso(){
			$aMeses		= array( "1" => "Janeiro", "2" => "Fevereiro", "3" => "Mar�o", "4" => "Abril"
								, "5" => "Maio", "6" => "Junho", "7" => "Julho", "8" => "Agosto"
								, "9" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro" );
			
			return date("d") . " de " . $aMeses[intval(date("m"))] . " de " . date("Y");
		}
		
		function getIdade( $_CRR_DTNASC ){
			$diaAtual	= date("d");
			$mesAtual	= date("m");
			$anoAtual	= date("Y");
		
			$arrDtaNasc	= explode( "-", $_CRR_DTNASC );
			$intIdade	= intval( $anoAtual - $arrDtaNasc[0] );
			$dateCrrDtnasc = $intIdade;
			
			// VERIFICANDO SE O MES DE NASCIMENTO J� PASSOU //
			if( $arrDtaNasc[1] > $mesAtual ){
				$dateCrrDtnasc = intval( $dateCrrDtnasc - 1 );
			}
			else if( $arrDtaNasc[1] == $mesAtual ){
				if( $diaAtual < $arrDtaNasc[2] ){
					$dateCrrDtnasc = intval( $dateCrrDtnasc - 1 );
				}	
			}
			
			return $dateCrrDtnasc;
		}
		
		/**
			Fun�&atilde;o que retorna o caminho da Pasta / Central de Documentos
			@parametros $_ASS_ID => ID do Assinante
			@parametros $_DRT_ID => ID do Diret�rio
		*/
		function getCaminhoCentralDocs( $_ASS_ID, $_DRT_ID, $web = false )
		{
			require_once( _DIRPATH . "classes/DAO/CentralDocumentosDAO.php" );
			$oCentral = new CentralDocumentosDAO();
			
			$aDados = $oCentral->ler( $_DRT_ID );
			
			// Recuperando o USR_ID //
			if( count( $aDados ) > 0 ){
				$_ASS_ID = $aDados["ASS_ID"];
			}
			
			$_ASS_ID = sprintf( "%06d", $_ASS_ID );
			$_DRT_ID = sprintf( "%06d", $_DRT_ID );
			
			if( $web ){
				return "documentos/E" . $_ASS_ID . "_D" . $_DRT_ID;
			}
			else{
				return $this->ondeestou( "documentos/E" . $_ASS_ID . "_D" . $_DRT_ID );
			}
		}
		
		function getDirPath($DRT_ID,$USR_ID)
		{
			while(strlen($USR_ID) < 6)
			{
				$USR_ID	= "0".$USR_ID;
			}
			while(strlen($DRT_ID) < 6)
			{
				$DRT_ID	= "0".$DRT_ID;
			}

			$DRT_PATH	= "E".$USR_ID."_D".$DRT_ID;

			return $DRT_PATH;
		}
		
		/**
			Fun�&atilde;o que retorna os Arquivos existentes dentro de um Diret�rio ///
			@parametros $_diretorio => Diret�rio / Pasta a ser pesquisada ...
		*/
		function listaArquivos( $_diretorio ){
			// Abre o diret�rio
			$ponteiro = opendir( $_diretorio );
			$arquivos = array();
			
			// Monta os vetores com os itens encontrados na pasta //
			while( $nome_itens = readdir( $ponteiro ) ){
				$itens[] = $nome_itens;
			}
			
			// ordena o vetor de itens
			ksort( $itens );
			
			// percorre o vetor para fazer a separacao entre arquivos e pastas 
			foreach( $itens as $listar ){
				// retira "./" e "../" para que retorne apenas pastas e arquivos
				if( $listar != "." && $listar != ".." ){
				// Verifica se � Arquivo //
					if( !is_dir( $listar ) ){
						$arquivos[] = $listar;
					}
				}
			}
			
			return $arquivos;
		}
		
		/**
			Fun�&atilde;o que Cria um Diret�rio ///
			@parametros $_diretorio => Diret�rio / Pasta a ser criado ...
		*/
		function criarDiretorio( $_diretorio ){
			$cria = mkdir( $_diretorio, 0777 );
			
			return $cria;
		}
		
		/**
			Fun�&atilde;o que Remove um Diret�rio ///
			@parametros $_diretorio => Diret�rio / Pasta a ser criado ...
		*/
		function removerDiretorio( $_diretorio ){
			$remove = rmdir( $_diretorio );
			
			return $remove;
		}
		
		/**
			Fun�&atilde;o que padroniza o nome dos Arquivso ///
			@parametros $_arquivo => Nome do Arquivo a ser padronizado ...
		*/
		function padronizaNome( $_arquivo ){
			$_arquivo = $this->limpa( $_arquivo );
			$_arquivo = strtoupper( $_arquivo );
			$_arquivo = str_replace( " ", "_", $_arquivo );
			
			return $_arquivo;
		}
		
		/**
			Retorna o Array de N&iacute;veis de Setores
		*/
		function getNiveisSetores()
		{
			$_aArray["0"] = "Selecione ...";
			$_aArray["1"] = "Diretoria";
			$_aArray["2"] = "Ger�ncia";
			$_aArray["3"] = "Departamento";
			$_aArray["4"] = "Setor";
			$_aArray["5"] = "Se�&atilde;o";

			return $_aArray;
		}
		
		/**
			Retorna as Op��es de Status do Processo, sendo checked = true ou checked = false//
		*/
		function getCheckStatusProcesso( $status )
		{
			$_aArray = array();
			
			$_aArray[0] = array( "0" => ' checked="checked"', "1" => NULL, "2" => NULL, "3" => NULL, "4" => NULL );
			$_aArray[1] = array( "0" => NULL, "1" => ' checked="checked"', "2" => NULL, "3" => NULL, "4" => NULL );
			$_aArray[2] = array( "0" => NULL, "1" => NULL, "2" => ' checked="checked"', "3" => NULL, "4" => NULL );
			$_aArray[3] = array( "0" => NULL, "1" => NULL, "2" => NULL, "3" => ' checked="checked"', "4" => NULL );
			$_aArray[4] = array( "0" => NULL, "1" => NULL, "2" => NULL, "3" => NULL, "4" => ' checked="checked"' );

			return $_aArray[$status];
		}
	
		// Valida CPF
		function validaCpf($cpf)
		{
			$cpf = str_replace( ".", "", $cpf );
			$cpf = str_replace( "-", "", $cpf );
			
			$ArrayDigA = array();
			$ArrayDigB = array();
			$valSoma = 0;
			$valResto = 0;
			$numDigCalcA = 0;
			$numDigCalcB = 0;
		
			// Matriz usada de base para o calculo do CPF
			$cpfBaseIndex = array(11,10,9,8,7,6,5,4,3,2);
			$cpfString = $cpf;
			// Armazena na matriz a[] todos os algarismos do CPF
			for($i=0,$j=1;$i<11;$i++,$j++)
			{
				$ArrayDigA[$i] = substr($cpfString,$i,1);
			}
		
			// Calculando o primeiro d�gito verificador
			// Pegamos do 1� ao 9� algarismo do CPF para fazermos o c�lculo
			for($i=0,$j=1;$i<9;$i++,$j++)
			{
				// Multiplica��o a partir do 1� valor da matriz do cpf (a[0]) com o 2� valor da matriz de c (c[1])
				$ArrayDigB[$i]=$ArrayDigA[$i]*$cpfBaseIndex[$j];
				// Armazena em 'soma' a soma todos os produtos
				$valSoma += $ArrayDigB[$i];
			}
			// Armazena em resto o resto da divis�o da soma divido por 11
			$valResto = $valSoma % 11;
			$numDigCalcA = ($valResto<2) ? 0 : 11-$valResto ;
			// Fim do calculo do primeiro d�gito verificador
		
			// Zera a vari�vel resto e Soma
			$valResto=0;
			$valSoma=0;
			// Pegamos do 1� ao 10� (que � o primeiro d�gito verificador) algarismo do CPF para fazermos o c�lculo
			for($i=0;$i<10;$i++)
			{
				// Multiplica��o a partir do 1� valor da matriz do cpf (a[0]) com o 1� valor da matriz de c (c[0])
				$ArrayDigB[$i]=$ArrayDigA[$i]*$cpfBaseIndex[$i];
				// Armazena em 'soma' a soma todos os produtos
				$valSoma += $ArrayDigB[$i];
			}
			// Armazena em resto o resto da divis�o da soma divido por 11
			$valResto = $valSoma % 11;
			$numDigCalcB = ($valResto<2) ? 0 : 11-$valResto;                                                       // Se resto for igual menor que 2 o primeiro d�gito do CPF dever� ser 0
		
			// Primeiro Digito Informado no CPf N�O est� Conforme o D�gito Calculado
			if($ArrayDigA[9]!=$numDigCalcA)
			{
				return false;
			}
			// Segundo Digito Informado no CPf N�O est� Conforme o D�gito Calculado
			if($ArrayDigA[10]!=$numDigCalcB)
			{
				return false;
			}
		
			// Digitos Informados no CPF est�o em Conformidade com os D�gitos Calculados
			return true;
		}
	
		function foto_curriculo( $CRR_ID ){
			$arqFoto = _DIRPATH . "_interfaces/_candidatos/_fotos/"  . $CRR_ID . ".jpg";

			if( file_exists( $arqFoto ) ){
				return 1;
			}
			else{
				return 0;
			}
		}
		
		function rmvFotoCurriculo($CRR_ID){
			$fotoGIF = _DIRPATH . "_interfaces/_candidatos/_fotos/"  . $CRR_ID . ".gif";
			$fotoPNG = _DIRPATH . "_interfaces/_candidatos/_fotos/"  . $CRR_ID . ".png";
			$fotoJPG = _DIRPATH . "_interfaces/_candidatos/_fotos/"  . $CRR_ID . ".jpg";
	
			// Arquivo GIF //
			if( file_exists( $fotoGIF ) ){
				// Remove Arquivo GIF //
				if( unlink( $fotoGIF ) ){
					return 1;
				}
				else{
					return 9;
				}
			}
			// Arquivo PNG //
			else if( file_exists( $fotoPNG ) ){
				// Remove Arquivo PNG //
				if( unlink( $fotoPNG ) ){
					return 1;
				}
				else{
					return 9;
				}	
			}
			// Arquivo JPG //
			else if( file_exists( $fotoJPG ) ){
				// Remove Arquivo JPG //
				if( unlink( $fotoJPG ) ){
					return 1;
				}
				else{
					return 9;
				}
			}
			else{
				return 0;
			}
		}
		
		function getMenuCurriculo( $_OPCAO, $CRR_ID, $CRR_STATUS ){
			$saidaHtml = NULL;
			$aAbas[1] = "Dados Pessoais";
			$aAbas[2] = "Documenta��o";
			$aAbas[3] = "Educa��o";
			$aAbas[4] = "Experi�ncia";
			$aAbas[5] = "Pretens�es";
			$aAbas[6] = "Informa��es Adicionais";
			$aAbas[7] = "Visualizar";
			$aAbas[8] = "Desativar Curr�culo";
			
			foreach( $aAbas as $ch => $vl ){
				if( $ch != 8 ){
					if( $CRR_STATUS != "1" && $_OPCAO < $ch ){
						$class = ' class="abaOff"';
						$function = NULL;
					}
					else{
						if( $_OPCAO == $ch ){ $class = ' class="abaOn"'; }
						else{ $class = NULL; }
						
						$function = 'onclick="mudaAba('.$ch.');"';
					}
						
					$saidaHtml .= '<li id="aba'.$ch.'"'.$class.$function.'>'.$vl.'</li>';
				}
				else{
					$saidaHtml .= '<li id="aba'.$ch.'" onclick="return desativaCad('.$CRR_ID.');">'.$vl.'</li>';
				}
			}
			
			return $saidaHtml;
		}
		
		function getInteresses( $arrCb, $arrVer = NULL ){
			$html = NULL;
			
			for( $i = 1; $i < count( $arrCb ); $i++ ){
				$checked		= NULL;
				$divAptidoes	= NULL;
				$divInformacao	= NULL;
				
				for( $k = 0; $k < count( $arrVer ); $k++ ){
					if( $arrVer[$k] == $i ){
						$checked = "checked";
						break;
					}
				}
					
				switch( $i ){
					default:{
						$divAptidoes	= "";
						break;
					}
					case 3:
						$divAptidoes = "auxiliar de produ��o, operador de m�quinas, tornceiro, eletricista...";
					break;
					case 4: 	
						$divAptidoes = "telemarketing, televendas, back-office, suporte.";
					break;
					case 5: 	
						$divAptidoes = "administrativo, commercial, financeiro, cont�bil, RH, suprimentos, planejamento produ��o";
					break;
					case 6: 
						$divAptidoes = "t�cnico em eletr�nica, mecatr�nica, eletrot�cnico";
					break;
					case 7: 	
						$divAptidoes = " engenheria, TI...";
					break;
					case 8: 	
						$divAptidoes = "RH, financeiro, cont�bil, inform�tica";
					break;
					case 9:
						$divAptidoes = "supervis�o, coordena��o, ger�ncia, dire��o";
					break;	
					
				}
				
				
				if( $i == 1 ){
					$checkAll = ' onclick="return checkAll(this.checked);"';
				}
				else{
					$checkAll = NULL;
				}
				
				if( $i > 2 ){
					$divInformacao = ' <em><b>Habilidades e Aptid�es:</b> ' . $divAptidoes . '</em>';
				}
			
				$html .= '<label style="float: left; width: 300px; height: 60px;">
						<input style="width: auto;" type="checkbox" ' . $checked . ' value="' . $i . '" name="areas[]" id="areas_'.$i.'" ' . $checkAll . ' />' . $arrCb[$i] . $divInformacao . '
					</label>';
				
			}
			
			$html .= '<input type="hidden" name="areasTotais" id="areasTotais" value="'.intval(count($arrCb)-1).'" />';

			return $html;
		}
		
		function getMenu( $_ASS_TIPO ){
			$aMenu["M"] = "tplMenuMaster.html";
			$aMenu["C"] = "tplMenuConsultoria.html";
			$aMenu["H"] = "tplMenuHolding.html";
			$aMenu["S"] = "tplMenuSimples.html";
			
			return $aMenu[$_ASS_TIPO];
		}
		
		function getLetra ( $NUMERO ){
		  $arr = array("0" => array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z'));
		  
		  return $arr[0][$NUMERO];
		}
		
	}
?>