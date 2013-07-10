<?php
	// ====================================== //
	// Autor: 		Wagner Charles Lingenover
	// ====================================== //
	
	// Estartando a Sess�o //
		if( empty( $_SESSION ) ){
			session_start();
		}
		
		date_default_timezone_set("America/Sao_Paulo");
	// =================== //
	
	// Defini se est� em Ambiente de Produ��o ou de Desenvolvimento //
		if( $_SERVER["HTTP_HOST"] == "localhost" ){
			$_Url = "http://localhost/makrosis/_interfaces";
			define( "_DIRPATH", $_SERVER["DOCUMENT_ROOT"] . "/makrosis/" );
		}
		else{
			$_Url = "http://sistema.makrosis.com.br/_interfaces";
			define( "_DIRPATH", $_SERVER["DOCUMENT_ROOT"] . "/" );
		}
	// ============================================================ //
	
	// Pega a pagina corrente, e tira a extensao (.php) //
		$pagina = explode( "/", $_SERVER['PHP_SELF'] );
		$aDados = explode( ".", $pagina[count( $pagina ) -1] );
		$nmTela	= $aDados[0];
	// ================================================	//

	// Validando a Sess�o do Usu�rio //
		/*if( $nmTela != "index" && $nmTela != "vViewVaga" && intval( strpos( $_SERVER['PHP_SELF'], "_interfaces" ) ) == 0
			&& intval( strpos( $_SERVER['PHP_SELF'], "cNovaSenha.php" ) ) == 0 ){
			if( !isset( $_SESSION["_USUARIO"]["USR_ID"] ) || empty( $_SESSION["_USUARIO"]["USR_ID"] ) ){
				header( "Location: index.php?msgTxt=Usu�rio n�o logado!&clsTxt=er" ); exit;
			}
		}		*/
	// ============================= //
	
	// Arrays de Relacionamentos //
		$aStatusRel		= array( "0" => "� Retornar", "1" => "Retornado" );
		$aOpEmailRel	= array( "0" => "N�o Enviar", "1" => "Recrutamento e Sele��o" );
	// ========================= //
	
	// Arrays de Curr�culo //
		$arrDominio = array( 'x' => 'Selecione ...', '0' => 'B�sico', '1' => 'Intermedi�rio', '2' => 'Avan�ado' );
		$arrEtnia	= array( 'x' => 'Selecione ...', '0' => "Branco", '1' => "Negro", '2' => "Pardo" );
		$arrTipoCnh = array( 'x' => 'Selecione ...', 'Nenhum', 'A', 'B', 'C', 'D', 'E', 'AB', 'AC', 'AD', 'AE');
		$arrUf 		= array( 'x' => 'Selecione ...', '0' => 'AC', '1' => 'AL', '2' => 'AM', '3' => 'AP', '4' => 'BA', '5' => 'CE', '6' => 'DF', '7' => 'ES', '8' => 'GO', '9' => 'MA', '10' => 'MG', '11' => 'MT', '12' => 'MS', '13' => 'PA', '14' => 'PB', '15' => 'PE', '16' => 'PI', '17' => 'PR', '18' => 'RJ', '19' => 'RN', '20' => 'RO', '21' => 'RR', '22' => 'RS', '23' => 'SC', '24' => 'SE', '25' => 'SP', '26' => 'TO' );
		$arrSexo 	= array( 'x' => 'Selecione ...', '0' => "Masculino", '1' => "Feminino" );
		$arrSimNao 	= array( 'x' => 'Selecione ...', '0' => "N�o", '1' => "Sim" );
		$arrEstCiv	= array( 'x' => 'Selecione ...', '0' => 'Casado', '1' => 'Desquitado', '2' => 'Divorciado', '3' => 'Separado', '4' => 'Solteiro', '5' => 'Vi�vo', '6' => 'Uni�o Est�vel' );
		$arrNvlConh	= array( 'x' => 'Selecione ...', '0' => 'B�sico', '1' => 'Intermedi�rio', '2' => 'Avan�ado' );
		$arrNvlIdm	= array( 'x' => 'Selecione ...', '0' => 'B�sico', '1' => 'Intermedi�rio', '2' => 'Avan�ado', '3' => "Fluente" );
		$arrIndica	= array( 'x' => 'Selecione ...', '0' => "Indica��o de Amigo", '1' => "Indica��o de Empresa/Cliente", '2' => "An�ncio em Jornal", '3' => "An�ncio em R�dio", '4' => "An�ncio em Quadro de Avisos", '5' => "Sites de Internet", '6' => "TV", '7' => "Outro" );
		$arrRestrit	= array( 'x' => 'Selecione ...', '0' => 'Aberto', '1' => 'Semi-Confidencial', '2' => 'Confidencial' );
		$arrDefic	= array( 'x' => 'Selecione ...', '0' => 'N�o Possui', '1' => 'Visual', '2' => 'Cadeirante', '3' => 'Membros Inferiores', '4' => 'Membros Superiores', '5' => 'Auditiva', '6' => 'Outra' );
		$aStatusCur	= array( 'x' => 'Selecione ...', '0' => 'Cursando', '1' => 'Interrompido', '2' => 'Completo' );
		$arrNvlEsc	= array( 'x' => 'Selecione ...', '1' => 'Ensino Fundamental', '3' => 'Ensino M�dio', '5' => 'P�s-m�dio (t�cnico)', '7' => 'Ensino Superior', '9' => 'P�s Gradua��o', '11' => 'Mestrado', '13' => 'Doutorado' );
		$arrHorario	= array( 'x' => 'Selecione ...', '0' => 'Total', '1' => 'Comercial (2a. a sexta)', '2' => 'Comercial (2a. a s�bado)', '3' => 'Manh�', '4' => 'Tarde', '5' => 'Noite', '6' => 'Turnos de revezamento' );
		$arrRelEmp	= array( 'x' => 'Selecione ...', '0' => 'CTPS', '1' => 'Aut�nomo', '2' => 'Empres�rio', '3' => 'Estagi�rio', '4' => 'Tempor�rio', '5' => 'Prestador de Servi�os', '6' => 'Consultor Aut�nomo', '7' => 'Free lancer', '8' => 'Outro' );
		
		$arrBancos  = array( 'x' => 'Selecione ...', '237' => 'Bradesco', '745' => 'Citibank', '001' => 'Banco do Brasil', '341' => 'Ita�', '033' => 'Santander', '104' => 'Caixa Economica Federal', '399' => 'HSBC', '409' => 'Unibanco' );
		$arrTpConta = array( 'x' => 'Selecione ...', '1' => 'Conta Corrente', '2' => 'Poupan�a' );
		$arrCbAreas	= array( "0" => "nenhum", "1" => "Todos",	 "2" => "Est�gios / Trainees", "3" => "Operacionais de Produ��o", "4" => "Call Center ", "5" => "Assistentes", "6" => "T�cnicos de N�vel M�dio", "7" => "T�cnicos de N�vel Superior", "8" => "Analistas com N�vel Superior", "9" => "Gest�o", "10" => "TI (Tecnologia da Informa��o)", "11" => "Engenharia" );
		$aStatusPrc = array( "0" => "N�o Avaliado", "1" => "Aprovado", "2" => "Reprovado", "3" => "Banco de Dados", "4" => "Desistente", "5" => "Transferido" );
		$aStatusVgaRel = array( "x" => "Todas", "5" => "Publicada", "2" => "Encerrada Completa",  "3" => "Encerrada Parcial", "4" => "Cancelada", "6" => "Publica��o Suspensa", "9" => "Inativa");
		$aNotasAval	= array( "0" => "...", "1" => "1", "1.5" => "1,5", "2" => "2", "2.5" => "2,5", "3" => "3", "3.5" => "3,5", "4" => "4" );
		$aBancosAval	= array( "..." => "Selecione", "246" => "Banco ABC Brasil S.A.", "025" =>	"Banco Alfa S.A.", "641" =>	"Banco Alvorada S.A.", "029" =>"Banco Banerj S.A.", "000" => "Banco Bankpar S.A.", "740" => "Banco Barclays S.A.", "107" => "Banco BBM S.A.", "031" => "Banco Beg S.A.", "739" =>	"Banco BGN S.A.", "096" =>	"Banco BM&F de Servi�os de Liquida��o e Cust�dia S.A", "318" =>	"Banco BMG S.A.", "752" => "Banco BNP Paribas Brasil S.A.", "248" => "Banco Boavista Interatl�ntico S.A.", "218" => "Banco Bonsucesso S.A.", "065" => "Banco Bracce S.A.", "036" => "Banco Bradesco BBI S.A.", "204" => "Banco Bradesco Cart�es S.A.", "394" =>	"Banco Bradesco Financiamentos S.A.", "237" =>	"Banco Bradesco S.A.", "225" =>	"Banco Brascan S.A.", "208" =>	"Banco BTG Pactual S.A.", "044" =>	"Banco BVA S.A.", "263" => "Banco Cacique S.A.", "473" =>	"Banco Caixa Geral - Brasil S.A.", "040" =>	"Banco Cargill S.A.", "745" =>	"Banco Citibank S.A.", "M08" =>	"Banco Citicard S.A.", "M19" =>	"Banco CNH Capital S.A.", "215" =>	"Banco Comercial e de Investimento Sudameris S.A.","756" => "Banco Cooperativo do Brasil S.A. - BANCOOB", "748" => "Banco Cooperativo Sicredi S.A.", "222" =>	"Banco Credit Agricole Brasil S.A.", "505" =>	"Banco Credit Suisse (Brasil) S.A.", "229" =>	"Banco Cruzeiro do Sul S.A.", "003" =>	"Banco da Amaz�nia S.A.", "083-3" =>	"Banco da China Brasil S.A.","707" 	=> "Banco Daycoval S.A.", "M06" => "Banco de Lage Landen Brasil S.A.", "024" =>"Banco de Pernambuco S.A. - BANDEPE", "456" => "Banco de Tokyo-Mitsubishi UFJ Brasil S.A.", "214" => "Banco Dibens S.A.", "001" => B"Banco do Brasil S.A.", "047" => "Banco do Estado de Sergipe S.A.", "037" => "Banco do Estado do Par� S.A.", "041" => "Banco do Estado do Rio Grande do Sul S.A.", "004" => "Banco do Nordeste do Brasil S.A.", "265" => "Banco Fator S.A.", "M03" => "Banco Fiat S.A.", "224" => "Banco Fibra S.A.", "626" => "Banco Ficsa S.A.", "394" => "Banco Finasa BMC S.A.", "M18" =>	"Banco Ford S.A.", "233" =>	"Banco GE Capital S.A.", "M07" =>	"Banco GMAC S.A.", "612" =>	"Banco Guanabara S.A.", "M22" => "Banco Honda S.A.", "063" => "Banco Ibi S.A. Banco M�ltiplo", "M11" => "Banco IBM S.A.", "604" => "Banco Industrial do Brasil S.A.", "320" =>	"Banco Industrial e Comercial S.A.", "653" =>	"Banco Indusval S.A.", "249" =>	"Banco Investcred Unibanco S.A.", "184" =>	"Banco Ita� BBA S.A.", "479" =>	"Banco Ita�Bank S.A", "M09" =>	"Banco Itaucred Financiamentos S.A.","376" =>	"Banco J. P. Morgan S.A.", "074" =>	"Banco J. Safra S.A.", "079" =>	"Banco JBS S.A.", "217" =>	"Banco John Deere S.A.", "600" =>	"Banco Luso Brasileiro S.A.", "389" =>	"Banco Mercantil do Brasil S.A.", "746" => "Banco Modal S.A.", "045" => "Banco Opportunity S.A.", "623" =>	"Banco Panamericano S.A.", "611" =>	"Banco Paulista S.A.", "643" =>	"Banco Pine S.A.", "638" =>	"Banco Prosper S.A.","747" =>	"Banco Rabobank International Brasil S.A.", "356" =>	"Banco Real S.A.", "633" => "Banco Rendimento S.A.", "M16" =>	"Banco Rodobens S.A.", "072" =>	"Banco Rural Mais S.A.", "453" =>	"Banco Rural S.A.", "422" =>	"Banco Safra S.A.", "033" =>	"Banco Santander (Brasil) S.A.", "250" =>	"Banco Schahin S.A.", "749" =>	"Banco Simples S.A.", "366" =>	"Banco Soci�t� G�n�rale Brasil S.A.", "637" =>	"Banco Sofisa S.A.", "012" =>	"Banco Standard de Investimentos S.A.","464" =>	"Banco Sumitomo Mitsui Brasileiro S.A.", "082-5" =>	"Banco Top�zio S.A.", "M20" =>	"Banco Toyota do Brasil S.A.", "634" => "Banco Tri�ngulo S.A.", "M14" => "Banco Volkswagen S.A.", "M23" =>	"Banco Volvo (Brasil) S.A.", "655" => "Banco Votorantim S.A.", "610" => "Banco VR S.A.", "370" =>	"Banco WestLB do Brasil S.A.", "021" =>	"BANESTES S.A. Banco do Estado do Esp�rito Santo", "719" => "Banif-Banco Internacional do Funchal (Brasil)S.A.", "755" =>	"Bank of America Merrill Lynch Banco M�ltiplo S.A.", "073" =>	"BB Banco Popular do Brasil S.A.","078" =>	"BES Investimento do Brasil S.A.-Banco de Investimento", "069" =>	"BPN Brasil Banco M�ltiplo S.A.", "070" =>	"BRB - Banco de Bras�lia S.A.", "104" =>	"Caixa Econ�mica Federal", "477" =>	"Citibank N.A.", "081-7" =>	"Conc�rdia Banco S.A.", "487" =>	"Deutsche Bank S.A. - Banco Alem�o", "751" =>	"Dresdner Bank Brasil S.A. - Banco M�ltiplo", "064" =>	"Goldman Sachs do Brasil Banco M�ltiplo S.A.", "062" =>	"Hipercard Banco M�ltiplo S.A.", "399" =>	"HSBC Bank Brasil S.A. - Banco M�ltiplo", "492" =>	"ING Bank N.V.", "652" =>	"Ita� Unibanco Holding S.A.","341" =>	"Ita� Unibanco S.A.", "488" =>	"JPMorgan Chase Bank", "409" =>	"UNIBANCO - Uni�o de Bancos Brasileiros S.A.", "230" =>	"Unicard Banco M�ltiplo S.A."      );

		$arrTipoAss = array( '0' => 'Selecione ...', 'M' => 'MakroSIS', 'C' => 'Consultorias', 'H' => 'Holdings', 'S' => 'Simples' );
		$arrStatusAss = array( 'x' => 'Selecione ...', '0' => 'Inativo', '1' => 'Ativo', '2' => 'Acesso Bloqueado' );
		$arrStatusEmkt = array('1' => 'Ativo', '0' => 'Inativo' );
		$aNivel = array ("x" =>  "Selecione ...", "1" => "2� Grau / T�cnico",  "5" => "Doutorado", "2" => "Gradua��o", "4" => "Mestrado",  "3" => "P�s / Especializa��o");
		$aDeficienciaTipo = array ("x" => "Selecione ...", "1" => "Defici�ncia f�sica", "2" => "Defici�ncia auditiva", "3" => "Defici�ncia visual", "4" => "Defici�ncia mental", "5" => "Defici�ncia m�ltipla");
		$aIdioma = array ("x" => "Selecione ...", "1" => "Ingl�s", "2" => "Espanhol", "3" => "Alem�o", "4" => "Franc�s", "5" => "Italiano");
		$aNivelIdioma = array ("3" => "Fluente", "2" => "Intermedi�rio", "1" => "B�sico");
		$aStatusList = array ('T' => 'Todos', "1" => "Ativo", "2" => "Inativo");
		$aStatus = array ("1" => "Ativo", "2" => "Inativo");
		$aSalario = array ("x" => "Selecione ...", "2" => "At&eacute; R$ 1.000,00", "3" => "De R$ 1.001,00 a R$ 2.000,00", "4" => "De R$ 2.001,00 a R$ 3.000,00", "5" => "De R$ 3.001,00 a R$ 4.000,00", "6" => "De R$ 4.001,00 a R$ 5.000,00", "7" => "De R$ 5.001,00 a R$ 6.000,00", "8" => "De R$ 6.001,00 a R$ 7.000,00", "9" => "De R$ 7.001,00 a R$ 8.000,00", "10" => "De R$ 8.001,00 a R$ 9.000,00", "11" => "De R$ 9.001,00 a R$ 10.000,00", "12" => "De R$ 10.001,00 a R$ 15.000,00", "13" => "De R$ 15.001,00 a R$ 20.000,00", "14" => "Acima de R$ 20.000,00");
		$aEscolariedade = array ("x" => "Selecione ...", "1" => "Ensino m&eacute;dio completo", "2" => "Superior incompleto", "3" => "Superior completo", "4" => "Especializa&atilde;o completo", "4" => "Mestrado completo", "5" => "Doutorado completo", "6" => "PHD completo");
		$aMoedaList = array ("1" => "R$", "2" => "$", "3" => "&euro;");
		$aCondicao = array ("x" => "Selecione ...", "1" => "30 dias", "2" => "60 dias", "3" => "90 dias");
		$aUnidade = array ("x" => "Selecione ...", "1" => "Bloco", "2" => "Bombona", "3" => "Caixa", "4" => "Duzia", "5" => "Fardo", "6" => "Frasco", "7" => "Gal�o", "8" => "Hora/Homem", "9" => "Litro", "10" => "Metro", "11" => "Metro Quadrado", "12" => "Milheiro", "13" => "Pacote", "14" => "Par", "15" => "Quilo", "16" => "Rolo", "17" => "Saco", "18" => "Unidade");
		$aUnidadeVender = array ( "1" => "Bloco", "2" => "Bombona", "3" => "Caixa", "4" => "Duzia", "5" => "Fardo", "6" => "Frasco", "7" => "Gal�o", "8" => "Hora/Homem", "9" => "Litro", "10" => "Metro", "11" => "Metro Quadrado", "12" => "Milheiro", "13" => "Pacote", "14" => "Par", "15" => "Quilo", "16" => "Rolo", "17" => "Saco", "18" => "Unidade");
		$aUnidadeVenda = array ("1" => "bl", "2" => "bb", "3" => "cx", "4" => "dz", "5" => "fd", "6" => "fc", "7" => "gl", "8" => "hh",
"9" => "lt", "10" => "mt", "11" => "m2", "12" => "mh", "13" => "pc", "14" => "par", "15" => "ql", "16" => "rl",
"17" => "sc", "18" => "un");
		$aConsumo = array ("x" => "Selecione ...", "1" => "Nenhuma", "2" => "Di�ria", "3" => "Semanal", "4" => "Mensal", "5" => "Anual");
		$aMoeda = array ("x" => "Selecione ...", "1" => "Real R$", "2" => "D�lar $", "3" => "Euro &euro;");
		$aMoedaVenda = array ("1" => "R$", "2" => "$", "3" => "&euro;");
		$aValor = array ("x" => "Selecione ...", "1" => "De 10,00 a 50,00", "2" => "De 51,00 a 100,00", "3" => "De 101,00 a 200,00", "4" => "De 201,00 a 500,00", "5" => "De 501,00 a 1.000,00", "6" => "De 1.001,00 a 2.000,00", "7" => "De 2.001,00 a 3.000,00", "8" => "De 3.001,00 a 4.000,00", "9" => "De 4.001,00 a 5.000,00", "10" => "De 5.001,00 a 10.000,00", "11" => "De 10.001,00 a 15.000,00", "12" => "Acima de 15.000,00");
		$aStatusProdutosEmCotacao = array ("T" => "Todos", "1" => "Em an&aacute;lise Comprador", "4" => "Finalizada");
		$aNota			= array ("x" => "Selecione ...", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5");
		$aMotivo		= array ("x" => "Selecione ...", "1" => "A outra parte desistiu da compra", "2" => "N�o houve resposta", "3" => "Outro");
		$aStatusLeilao = array ("1" => "Ativo", "2" => "Inativo", "3" => "Em Forma&ccedil;&atilde;o", "4" => "Finalizado", "5" => "Exclu�do");
		$aGarantia = array ("0" => "N�o", "1" => "Sim");
		$aGarantiaList = array ("T" => "Todos", "0" => "N�o", "1" => "Sim");
		$aPrazoUnidade = array ("1" => "Dias", "2" => "Horas");
		$aPrazoUnidadeList = array ("T" => "Todos", "1" => "Dias", "2" => "Horas");
		$aPrazoResposta = array ("1" => "Normal", "2" => "Urgente");
	// =================== //
	
	// Vari�veis Globais //
		$displayGravata = "none";
	// ================= //
?>