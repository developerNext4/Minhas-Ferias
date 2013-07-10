	<script>
	$(document).ready(function(){
		<?php
			require_once( "./classes/DAO/UtilsDAO.php" );
			$oUtilsDAO		= new UtilsDAO();
			
			$subjects = NULL;
			$hQry = mysql_query ("SELECT DST_NOME FROM tb_destino WHERE DST_STATUS = '1'");
			while ($jQry = mysql_fetch_array ($hQry)){
				$subjects .= "'".$jQry['DST_NOME']."',";
			}
			$subjects = substr ($subjects,0,-1);
		?>
		var subjects = [ <?php echo ($subjects); ?> ];   
		$('#CTC_DE').typeahead({source: subjects});
		$('#CTC_PARA1').typeahead({source: subjects});
		$('#CTC_PARA2').typeahead({source: subjects});
		$('#CTC_PARA3').typeahead({source: subjects});
		$('#CTC_PARA4').typeahead({source: subjects});
		$('#CTC_PARA5').typeahead({source: subjects});
		$('#CTC_PARA6').typeahead({source: subjects});
		$('#CTC_PARA7').typeahead({source: subjects});
		$('#CTC_PARA8').typeahead({source: subjects});
		$('#CTC_PARA9').typeahead({source: subjects});
		$('#CTC_PARA10').typeahead({source: subjects});
		
					
	});
	
	function aumentaValor(campo){
		document.getElementById(campo).value = parseInt(document.getElementById(campo).value) + 1;
	}
	function diminuiValor(campo){
		if (document.getElementById(campo).value != 0){
			document.getElementById(campo).value = parseInt(document.getElementById(campo).value) - 1;
		}
	}
	
	function verifyDataVolta (valor){
		var dia = $('#DIA').val();
		var mes = $('#MES').val();
		var ano = $('#ANO').val();
		
		if (dia != 0){
		
			var diaVolta = valor.substr(0,2);
			var mesVolta = valor.substr(3,2);
			var anoVolta = valor.substr(6,4);
			
			var Volta = anoVolta+''+mesVolta+''+diaVolta;
			var Partida = ano+''+mes+''+dia;
			if (Partida > Volta) {
				alert ('A Data de Volta de ser maior que a Data de Partida');
			}else{
				$.ajax({
					url: "ajxCalculaDiferencaDatas.php",
					global: false,
					type: "GET",
					data: ({diaPartida: dia, mesPartida: mes, anoPartida: ano, diaVolta: diaVolta, mesVolta: mesVolta, anoVolta: anoVolta}),
					dataType: "html",
					success: function(data){
						$('#CTC_QTD_NOITES1').val(data);
					}
				 });
			}
			
		}
	}
	
	function alteraVolta (valor){
		var dia = $('#DIA').val();
		var mes = $('#MES').val();
		var ano = $('#ANO').val();

		if (dia != 0){
			$.ajax({
				url: "ajxCalculaDataVolta.php",
				global: false,
				type: "GET",
				data: ({QTDE_NOITES: valor, DIA: dia, MES: mes, ANO: ano}),
				dataType: "html",
				success: function(data){
					$('#CTC_DATA_VOLTA').val(data);
				}
			 });
		}
	}
	
	function conta(){
		var faltam = 500 - parseInt(document.forms[0].CTC_OBS.value.length);
       document.getElementById('caracteres').innerHTML=faltam;
	} 
		
		function criarDestino(){
			if (document.getElementById('CTC_AEREO').checked == false && document.getElementById('CTC_HOTEL').checked == false && document.getElementById('CTC_ALUGUEL').checked == false && document.getElementById('CTC_ATIVIDADE').checked == false){
				alert ('Selecione pelo menos uma opção para o campo O QUE VOCÊ DESEJA COTAR PARA SUA VIAGEM!');
				return false;
			}
			if (document.getElementById('CTC_AEREO').checked == true){
				if ($('#CTC_DE').val() == ''){
					alert ('O campo DE é obrigatório!');
					$('#CTC_DE').focus();
					return false;
				}
			}
			if ($('#CTC_PARA').val() == ''){
				alert ('O campo PARA é obrigatório!');
				$('#CTC_PARA').focus();
				return false;
			}
			if ($('#CTC_PARTIDA').val() == ''){
				alert ('O campo DATA DE PARTIDA é obrigatório!');
				$('#CTC_PARTIDA').focus();
				return false;
			}
			
			if ($('#CTC_ADULTOS').val() == '0' && $('#CTC_ZERO_TRES').val() == '0' && $('#CTC_CRIANCAS').val() == '0'){
				alert ('No mínimo um dos campos (ADULTOS, DE 0 a 23 MESES, CRIANÇAS DE 2 A 12 ANOS) deve estar com um valor maior do que 0!');
				return false;
			}
			
		}
		
		function verifyAereo(){
			if (document.getElementById('CTC_AEREO').checked == false){
				document.getElementById('CTC_PASSAGEM1').disabled = true;
				document.getElementById('CTC_PASSAGEM2').disabled = true;
				document.getElementById('CTC_DE').disabled = true;
			}else{
				document.getElementById('CTC_PASSAGEM1').disabled = false;
				document.getElementById('CTC_PASSAGEM2').disabled = false;
				document.getElementById('CTC_DE').disabled = false;
			}
		}
		
		function addDestino(){
			var erro = 0;
			for (i=1; i<=$('#Contador').val(); i++){
				if ($('#CTC_PARA'+i).val() == ''){
					alert ("Digite o Destino!");
					$('#CTC_PARA'+i).focus();
					erro = 1;
					break;
				}
				if ($('#CTC_QTD_NOITES'+i).val() == ''){
					alert ("Digite a Quantidade de Noites!");
					$('#CTC_QTD_NOITES'+i).focus();
					erro = 1;
					break;
				}
			}
			
			if (erro == 0){
				var Contador = parseInt($('#Contador').val()) + 1;
				document.getElementById('novoDestino'+Contador).style.display = 'block';
				$('#Contador').val(Contador);
				/*var valuePara = '';
				var valueNoites = '';
				var Contador = parseInt($('#Contador').val()) + 1;
				if (Contador > 2){
					for (k=2; k<Contador; k++){
						var valuePara = document.getElementById('CTC_PARA'+k).value;
						var valueNoites = document.getElementById('CTC_QTD_NOITES'+k).value;
					}
				}
				$('#Contador').val(Contador);
				var Html = document.getElementById('novoDestino').innerHTML;
				
				document.getElementById('novoDestino').innerHTML = Html + '<div class="camp2">'+
				'<div class="blDat">' +
				'<label>Para </label>' +
				'<input class="paraViagem" type="text" value="'+valuePara+'" name="CTC_PARA'+Contador+'" id="CTC_PARA'+Contador+'">' +
				'</div>' +
				'<div class="blQtd">' +
				'<label> Qtde de Noites </label>' +
				'<input class="qtdViagem" type="text" value="'+valueNoites+'" name="CTC_QTD_NOITES'+Contador+'" id="CTC_QTD_NOITES'+Contador+'" />' +
				'</div>';*/
			}
		}
	</script> 
<div class="row boxContHome">
    <div class="span5 offset1">
      <div class="boxTabs">
        <div class="tabbable"> <!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Crie o seu destino</a></li>
            <li class="d"><a href="#tab2" data-toggle="tab">Para onde Ir</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
              <div class="tabFormulario">
              	<?php
				$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
				if (  $msgTxt == 1){
				?>
						<div class="alert alert-success">
							Para realizar o Pedido de Cotação realize o login ou cadastre-se clicando <a data-toggle="modal" role="button" href="#myModal">AQUI</a>!
						</div>
				<?php
					}
					
					$CTC_AEREO			= ( isset($_SESSION["CTC_AEREO"]) ) ? $_SESSION['CTC_AEREO'] : 0;
					$CTC_HOTEL 			= ( isset($_SESSION["CTC_HOTEL"]) ) ? $_SESSION['CTC_HOTEL'] : 0;
					$CTC_ALUGUEL 		= ( isset($_SESSION["CTC_ALUGUEL"]) ) ? $_SESSION['CTC_ALUGUEL'] : null;
					$CTC_ATIVIDADE 		= ( isset($_SESSION["CTC_ATIVIDADE"]) ) ? $_SESSION['CTC_ATIVIDADE'] : null;
					$CTC_PASSAGEM 		= ( isset($_SESSION["CTC_PASSAGEM"]) ) ? $_SESSION['CTC_PASSAGEM'] : null;
					$CTC_DE				= ( isset($_SESSION["CTC_DE"]) ) ? $_SESSION['CTC_DE'] : null;
					$CTC_PARTIDA_DIA	= ( isset($_SESSION["DIA"]) ) ? $_SESSION['DIA'] : null;
					$CTC_PARTIDA_MES	= ( isset($_SESSION["MES"]) ) ? $_SESSION['MES'] : null;
					$CTC_PARTIDA_ANO	= ( isset($_SESSION["ANO"]) ) ? $_SESSION['ANO'] : null;
					$CTC_DATA_VOLTA 	= ( isset($_SESSION["CTC_DATA_VOLTA"]) ) ? $_SESSION['CTC_DATA_VOLTA'] : null;
					$CTC_DATA_FLEXIVEIS = ( isset($_SESSION["CTC_DATA_FLEXIVEIS"]) ) ? $_SESSION['CTC_DATA_FLEXIVEIS'] : null;
					$CTC_ADULTOS		= ( isset($_SESSION["CTC_ADULTOS"]) ) ? $_SESSION['CTC_ADULTOS'] : null;
					$CTC_ZERO_TRES 		= ( isset($_SESSION["CTC_ZERO_TRES"]) ) ? $_SESSION['CTC_ZERO_TRES'] : null;
					$CTC_CRIANCAS 		= ( isset($_SESSION["CTC_CRIANCAS"]) ) ? $_SESSION['CTC_CRIANCAS'] : null;
					$CTC_QTD_PROPOSTAS 	= ( isset($_SESSION["CTC_QTD_PROPOSTAS"]) ) ? $_SESSION['CTC_QTD_PROPOSTAS'] : null;
					$CTC_OBS 			= ( isset($_SESSION["CTC_OBS"]) ) ? $_SESSION['CTC_OBS'] : null;
					$CTC_DATA 			= ( isset($_SESSION["CTC_DATA"]) ) ? $_SESSION['CTC_DATA'] : null;	
					$CONTADOR  			= ( isset($_SESSION["CONTADOR"]) ) ? $_SESSION['CONTADOR'] : null;
					
					/*for ($i = 1; $i <= $Contador; $i++){
						$_SESSION["CTC_PARA$i"] = $_REQUEST["CTC_PARA".$i];
						$_SESSION["CTP_QTD_NOITES$i"] = $_REQUEST["CTC_QTD_NOITES".$i];
					}*/
					$checkHotel = "checked";
					if (isset($_SESSION["CTC_HOTEL"])){
						if ($CTC_HOTEL == "0"){
							$checkHotel = NULL;
						}
					}
					$checkAereo = "checked";
					if (isset($_SESSION["CTC_AEREO"])){
						if ($CTC_AEREO == "0"){
							$checkAereo = NULL;
						}
					}
					$checkAluguel = NULL;
					if ($CTC_ALUGUEL == "1"){
						$checkAluguel = "checked";
					}
					$checkAtividade = NULL;
					if ($CTC_ATIVIDADE == "1"){
						$checkAtividade = "checked";
					}
					
					$checkPassagem1 = NULL;
					if ($CTC_PASSAGEM == "2"){
						$checkPassagem2 = "checked";
					}else{
						$checkPassagem1 = "checked";
					}
				?>

                <h3>O que voc&ecirc; deseja cotar para sua viagem?</h3>
                <form action="cCriarDestinoNaoLogado.php" method="post" class="form-inline" name="Cotacao" onsubmit="return criarDestino();">
                  <input type="hidden" name="Contador" id="Contador" value="1" />
                  <div class="controls controls-row">
                    <label class="checkbox inline">
                      <input type="checkbox"  id="CTC_AEREO" checked="checked" name="CTC_AEREO" value="1" onclick="verifyAereo();">
                      A&eacute;reo </label>
                    <label class="checkbox inline">
                      <input type="checkbox"   id="CTC_HOTEL" checked="checked" name="CTC_HOTEL" value="1">
                      Hotel </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="CTC_ALUGUEL"  name="CTC_ALUGUEL" value="1">
                      Aluguel de carro </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="CTC_ATIVIDADE" name="CTC_ATIVIDADE" value="1">
                      Atividades Locais </label>
                  </div>
                  <h2>Roteiros e dadas</h2>
                  <div class="controls controls-row tipoRdio">
                    <label class="inline"> 
                      <input class="inline" type="radio" name="CTC_PASSAGEM" id="CTC_PASSAGEM1" checked="checked" value="1" ></label><label class="inline"> 
                      Ida e Volta
                      <input class="inline" type="radio" name="CTC_PASSAGEM" id="CTC_PASSAGEM2" value="2">
                        Somente Ida
                    </label>
                  </div>
                    <div class="bloAjudaMe">      
                          <div class="camp1">
                            <label>
                            <input class="deViagem" data-provide="typeahead"  name="CTC_DE" id="CTC_DE"  type="text" placeholder="De">
                            </label>

                            <label>
                              <input class="paraViagem" type="text" name="CTC_PARA1" id="CTC_PARA1" placeholder="Para">
                            </label>
                            
                          </div>
                          
                          <div class="camp2">
                              <div class="blDat">
                              <label>Data de Partida </label>
                                <select name="DIA" id="DIA">
                                	<option value="0">N&atilde;o definido</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                                <select name="MES" id="MES">
                                	<option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select name="ANO" id="ANO">
                                	<option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                </select>
                              </div>

                            <div class="blQtd">
                            <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES1" id="CTC_QTD_NOITES1" onchange="alteraVolta(this.value);" />
                            </div>
                          </div>  
                   </div>
                   <label>Data de Volta</label><br />
                    <input class="paraViagem" type="text" name="CTC_DATA_VOLTA" id="CTC_DATA_VOLTA" onchange="verifyDataVolta(this.value);">
                   <div id="novoDestino">
                    	<div class="camp2" style="display:none" id="novoDestino2">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA2" id="CTC_PARA2">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES2" id="CTC_QTD_NOITES2" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino3">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA3" id="CTC_PARA3">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES3" id="CTC_QTD_NOITES3" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino4">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA4" id="CTC_PARA4">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES4" id="CTC_QTD_NOITES4" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino5">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA5" id="CTC_PARA5">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES5" id="CTC_QTD_NOITES5" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino6">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA6" id="CTC_PARA6">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES6" id="CTC_QTD_NOITES6" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino7">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA7" id="CTC_PARA7">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES7" id="CTC_QTD_NOITES7" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino8">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA8" id="CTC_PARA8">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES8" id="CTC_QTD_NOITES8" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino9">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA9" id="CTC_PARA9">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES9" id="CTC_QTD_NOITES9" />
                            </div>
                          </div>
                          <div class="camp2" style="display:none" id="novoDestino10">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA10" id="CTC_PARA10">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="CTC_QTD_NOITES10" id="CTC_QTD_NOITES10" />
                            </div>
                          </div>
                    </div>
                   <span class="linkOutroDestino"> <input type="checkbox" name="CTC_DATA_FLEXIVEIS" id="CTC_DATA_FLEXIVEIS" value="1" />Data Flex&iacute;veis:</span>

                  <span class="linkOutroDestino"><a style="cursor:pointer" onclick="addDestino();"> + Adicionar outro destino</a></span>

                  <div class="selectSpan1">

                      <div class="coluSpan1"> <span>Adultos</span>
                        <input class="select1" name="CTC_ADULTOS" id="CTC_ADULTOS" type="text" value="0" />
                         <div class="btn_add"><a style="cursor:pointer;" onclick="aumentaValor('CTC_ADULTOS');">+</a> <a style="cursor:pointer" onclick="diminuiValor('CTC_ADULTOS');">-</a></div>
                      </div>

                      <div class="coluSpan2"> <span>De 0 a 23 meses</span>
                        <input class="select1" name="CTC_ZERO_TRES" id="CTC_ZERO_TRES" type="text" value="0" />
                          <div class="btn_add"><a style="cursor:pointer" onclick="aumentaValor('CTC_ZERO_TRES');">+</a> <a style="cursor:pointer" onclick="diminuiValor('CTC_ZERO_TRES');">-</a></div>
                      </div>

                      <div class="coluSpan3"> <span>Crian&ccedil;as de 2 a 12 anos</span>
                       <input class="select1" name="CTC_CRIANCAS" id="CTC_CRIANCAS" type="text" value="0" />
                        <div class="btn_add"><a style="cursor:pointer" onclick="aumentaValor('CTC_CRIANCAS');">+</a> <a style="cursor:pointer" onclick="diminuiValor('CTC_CRIANCAS');">-</a></div>
                      </div>
                  </div>
                  <div class="qtdPropost"><span>Qual a quantidade m&aacute;xima de  propostas que deseja receber?</span> 
                 	<select name="CTC_QTD_PROPOSTAS" id="CTC_QTD_PROPOSTAS">
                    	<option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                  </div>
                  <textarea maxlength="500"  class="msgClient" id="" name="CTC_OBS" id="CTC_OBS"   placeholder="Deixe seu coment&aacute;rio, observa&ccedil;&otilde;es e o que mais desejar :)" onKeyDown="conta()" onKeyUp="conta()" ></textarea><br /><br />
                  Faltam <label id="caracteres">500</label> caracteres<br />

                  <button class="btn btn-rky" type="submit">Adicionar destino</button>
                </form>
              </div>
              <!-- Fecha tab Formulário--> 
            </div>
            <div class="tab-pane" id="tab2">
              <div>
                <p>Para onde Ir</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Conteudo Principal coluna Direita -->
    <div class="span4 offset1 boxContD">
      <p class="logo"> <img src="templates/images/background/logo.png" alt="" title="" /></p>
      <?php
        $iQry = mysql_query ("SELECT * FROM tb_video LIMIT 1");
        $oQry = mysql_fetch_array ($iQry);
        
      ?>
      <div class="chamadHome"><?php echo (utf8_encode ($oQry['VDO_TEXTO'])); ?></div>
      <div class="videoHom">
        <h2>ASSISTA O V&#205;DEO ABAIXO!</h2>
        <div class="chamVideo"> <?php echo ($oQry['VDO_LINK']); ?></iframe></div>
      </div>
    </div>
  </div>
  <div class="footerImage">&nbsp;</div>
     