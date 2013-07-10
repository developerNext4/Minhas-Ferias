	<script>
	$(document).ready(function(){
		<?php
			ini_set('display_errors','Off'); 
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
  
    
      <div class="boxTabs">

        <div class="boxLogincliente"><!-- Only required for left/right tabs -->
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Crie o seu destino</a></li>
            <li class="d"><a href="#tab2" data-toggle="tab">Para onde Ir</a></li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane active" id="tab1">
            <?php
				$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
				if (  $msgTxt == 1){
			?>
					<div class="alert alert-success">
						Pedido de Cotação realizado com sucesso!
					</div>
			<?php
				}else if($msgTxt == 2){
			?>
					<div class="alert alert-error">
						Houve um problema ao realizar o cadastro! Tente novamente mais tarde.
					</div>
			
			<?php
				}
				
			?>
              
                <h3>O que você deseja cotar para sua viagem?</h3>
                <form action="cCriarDestino.php" method="post" class="form-inline" name="Cotacao" onsubmit="return criarDestino();">
                	<input type="hidden" name="Contador" id="Contador" value="1" />
                 	<input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]);?>" />
                  <div class="controls controls-row">
                    <label class="checkbox inline">
                      <input type="checkbox" checked="checked" id="CTC_AEREO" name="CTC_AEREO" value="1" onclick="verifyAereo();">
                      Aéreo </label>
                    <label class="checkbox inline">
                      <input type="checkbox" checked="checked" id="CTC_HOTEL" name="CTC_HOTEL" value="1">
                      Hotel </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="CTC_ALUGUEL" name="CTC_ALUGUEL" value="1">
                      Aluguel de carro </label>
                    <label class="checkbox inline">
                      <input type="checkbox" id="CTC_ATIVIDADE" name="CTC_ATIVIDADE" value="1">
                      Atividades Locais </label>
                  </div>
                  <h2>Roteiros e dadas</h2>
                  <div class="controls controls-row tipoRdio">
                    <label class="inline"> 
                      <input class="inline" type="radio" name="CTC_PASSAGEM" id="CTC_PASSAGEM1" checked="checked" value="1" ></label><label class="inline">&nbsp; Ida e Volta
                      <input class="inline" type="radio" name="CTC_PASSAGEM" id="CTC_PASSAGEM2" value="2">
                        &nbsp;Somente Ida
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
                                	<option value="0">Não definido</option>
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
                    <!--<div class="camp2">
                            <div class="blDat">
                              <label>Para </label>
                                <input class="paraViagem" type="text" name="CTC_PARA" id="CTC_PARA">
                              </div>

                            <div class="blQtd">
                             <label> Qtde de Noites </label>
                              <input class="qtdViagem" type="text" name="" id="" />
                            </div>
                            
                            
                          </div>  -->
                   <div>  
                      <span class="linkOutroDestino"> <input type="checkbox" name="CTC_DATA_FLEXIVEIS" id="CTC_DATA_FLEXIVEIS" value="1" />Data Flex&iacute;veis:</span>    
                      <span class="linkOutroDestino"><a style="cursor:pointer" onclick="addDestino();"> + Adicionar outro destino</a></span>

                  </div>
                      
                  <div class="selectSpan1">
                        <div class="coluSpan1"> <span>Adultos</span>
                          <input class="select1" name="CTC_ADULTOS" id="CTC_ADULTOS" type="text" value="0" />
                           <div class="btn_add"><a style="cursor:pointer" onclick="aumentaValor('CTC_ADULTOS');">+</a> <a style="cursor:pointer" onclick="diminuiValor('CTC_ADULTOS');">-</a></div>
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


                  <textarea maxlength="500"  class="msgClient" id="" name="CTC_OBS" id="CTC_OBS"   placeholder="Deixe seu comentário, observações e o que mais desejar :)" onKeyDown="conta()" onKeyUp="conta()" ></textarea><br />
                  Faltam <label id="caracteres">500</label> caracteres
                  <button class="btn btn-rky clearBt" type="submit">Adicionar destino</button>
                  </td> 
                </form>
              
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
    <script>
	function verifyMaisAvaliacoesModal(ID){
		$.ajax({
			url: "ajxVerificaMaisAvaliacoes.php",
			global: false,
			type: "GET",
			data: ({USR_ID: ID, Contador: $('#Contador').val(), FONTE: 1}),
			dataType: "html",
			success: function(data){
				document.getElementById('avaliacao').innerHTML = data;
			}
		 });
	}
	</script>
    <!-- Conteudo Principal coluna Direita -->
    <div class="span4 boxContD">
      <p class="logo"> <img src="./images/background/logo.png" alt="" title="" /></p>
      <div class="span6" style="border:1px solid"> <p><strong> Últimas atualizações nos destinos criados</strong></p>
      <?php
      $rQry = mysql_query ("SELECT * FROM tb_cotacao 
			WHERE USR_ID = '$_SESSION[USR_ID]' ORDER BY CTC_ID DESC LIMIT 5");
		while ($tQry = mysql_fetch_array ($rQry)){
			
			echo ("<p><a href='index.php?pg=5&CTC_ID=$tQry[CTC_ID]'><strong>De:</strong> ".$tQry["CTC_DE"]." <strong>Para:</strong> ".$tQry["CTC_PARA"]." </strong></a></p>");
		}
	  ?>
       
       </div>
      <div class="span6" style="border:1px solid; margin-top:30px">
        <table  width="100%">
                <tr>
                    <td width="50%">
                        <table width="95%" align="center" style="background-color:#F7F7F7">
                            <tr>
                                <td><strong>TOP 10 agentes que mais fecharam negócios</strong></td>
                                <?php
									$top = array ();
									$bem = array ();
									$i = 1;
									$tQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_TIPO = '2' AND USR_STATUS = '1'");
									while ($yQry = mysql_fetch_array ($tQry)){
										$uQry = mysql_query ("SELECT COUNT(*) AS COUNT FROM tb_cotacao_proposta WHERE USR_ID = '$yQry[USR_ID]'");
										$iQry = mysql_fetch_array ($uQry);
										$top[$i]['count'] = $iQry['COUNT'];
										$top[$i]['usuario'] = utf8_encode ($yQry['USR_NOME']);
										$top[$i]['id'] = $yQry['USR_ID'];
										
										$dQry = mysql_query ("SELECT AVG(AVL_NOTA) AS NOTA FROM tb_avaliacao WHERE AVL_AVALIADO = '$yQry[USR_ID]'");
										$fQry = mysql_fetch_array ($dQry);
										$bem[$i]['nota'] = $fQry['NOTA'];
										$bem[$i]['usuario'] = utf8_encode ($yQry['USR_NOME']);
										$bem[$i]['id'] = $yQry['USR_ID'];
										
										$i++;
									}
									arsort($top,'count');
									
									for ($i = 1; $i <= 10; $i++){
										$codigo = $top[$i]['id'];
										echo ("<tr><td><a href='#myModal$codigo' role='button'  data-toggle='modal'>".$top[$i]['usuario']."</a></td></tr>");
									?>
                                    	<div id="myModal<?php echo ($top[$i]['id']); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                <h3 id="myModalLabel">Avaliações do Agente</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>O agente fechou <strong>
												<?php
                                                    $hQry = mysql_query ("SELECT COUNT(*) AS FECHADOS 
													FROM tb_cotacao_proposta 
                                                    WHERE USR_ID = '$codigo' AND CPP_STATUS = '3'");
                                                    $jQry = mysql_fetch_array ($hQry);
                                                    echo ($jQry['FECHADOS']);
                                                ?>
                                                 negócio(s)</strong> no site.</p>
                                                 <p>Possui <strong>
												<?php
                                                    $qQry = mysql_query ("SELECT COUNT(*) AS RECEBIDAS 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $wQry = mysql_fetch_array ($qQry);
                                                    echo ($wQry['RECEBIDAS']);
                                                ?> avaliações</strong>, sua nota média é <strong>
                                                <?php
                                                    $eQry = mysql_query ("SELECT AVG(AVL_NOTA) AS MEDIA 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $rQry = mysql_fetch_array ($eQry);
                                                    if ($rQry['MEDIA'] == NULL){
                                                        $rQry['MEDIA'] = 0;
                                                    }
                                                    echo (round ($rQry['MEDIA']));
                                                ?></strong></p>
                                                <p>Comentários dos consumidores:</p>
                                                    <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($codigo); ?>" />
                                                    <div style="width:500px;" id="avaliacao">
                                                        <input type="hidden" name="Contador" id="Contador" value="2" />
                                                        <?php
                                                            $pQry = mysql_query ("SELECT * FROM tb_avaliacao 
															WHERE AVL_AVALIADO = '$codigo'
                                                            ORDER BY AVL_ID DESC LIMIT 2");
                                                            if (mysql_num_rows($pQry) > 0){
                                                                $iCont = 1;
                                                                while ($oQry = mysql_fetch_array ($pQry)){
                                                                    if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
                                                                    else{ $back = "#FFFFCC"; }
                                                        ?>
                                                                   <div style="background-color:<?php echo ($back); ?>">
                                                                    <p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
                                                                    <p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
                                                                   </div>
                                                        <?php
                                                                    $iCont++;
                                                                }
                                                        ?>
                                                                <p align="center">
                                                                    <button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoesModal(<?php  echo ($codigo); ?>);">Ver Mais</button>
                                                                </p>
                                                        <?php
                                                            
                                                            }else{
                                                        ?>
                                                               <div class="alert">
                                                                <strong>Este agente não possui avaliações!</strong>
                                                                </div>
                                                        
                                                        <?php
                                                            }
                                                        ?>
                                            </div>
                                            
                                        </div>
                                    <?php
									}
								?>
                            </tr>
                        </table>
                    </td> 
                    <td>
                        <table width="95%" align="center" style="background-color:#F7F7F7">
                            <tr>
                                <td><strong>TOP 10 agentes mais bem avaliados pelos consumidores</strong></td>
                                <?php
									
									arsort($bem,'nota');
									
									for ($i = 1; $i <= 10; $i++){
										$codigo = $bem[$i]['id'];
										echo ("<tr><td><a href='#myModal$codigo' role='button'  data-toggle='modal'>".$bem[$i]['usuario']."</a></td></tr>");
									?>
                                    	<div id="myModal<?php echo ($bem[$i]['id']); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                                <h3 id="myModalLabel">Avaliações do Agente</h3>
                                            </div>
                                            <div class="modal-body">
                                                <p>O agente fechou <strong>
												<?php
                                                    $hQry = mysql_query ("SELECT COUNT(*) AS FECHADOS 
													FROM tb_cotacao_proposta 
                                                    WHERE USR_ID = '$codigo' AND CPP_STATUS = '3'");
                                                    $jQry = mysql_fetch_array ($hQry);
                                                    echo ($jQry['FECHADOS']);
                                                ?>
                                                 negócio(s)</strong> no site.</p>
                                                 <p>Possui <strong>
												<?php
                                                    $qQry = mysql_query ("SELECT COUNT(*) AS RECEBIDAS 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $wQry = mysql_fetch_array ($qQry);
                                                    echo ($wQry['RECEBIDAS']);
                                                ?> avaliações</strong>, sua nota média é <strong>
                                                <?php
                                                    $eQry = mysql_query ("SELECT AVG(AVL_NOTA) AS MEDIA 
													FROM tb_avaliacao 
                                                    WHERE AVL_AVALIADO = '$codigo'");
                                                    $rQry = mysql_fetch_array ($eQry);
                                                    if ($rQry['MEDIA'] == NULL){
                                                        $rQry['MEDIA'] = 0;
                                                    }
                                                    echo (round ($rQry['MEDIA']));
                                                ?></strong></p>
                                                <p>Comentários dos consumidores:</p>
                                                    <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($codigo); ?>" />
                                                    <div style="width:500px;" id="avaliacao">
                                                        <input type="hidden" name="Contador" id="Contador" value="2" />
                                                        <?php
                                                            $pQry = mysql_query ("SELECT * FROM tb_avaliacao 
															WHERE AVL_AVALIADO = '$codigo'
                                                            ORDER BY AVL_ID DESC LIMIT 2");
                                                            if (mysql_num_rows($pQry) > 0){
                                                                $iCont = 1;
                                                                while ($oQry = mysql_fetch_array ($pQry)){
                                                                    if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
                                                                    else{ $back = "#FFFFCC"; }
                                                        ?>
                                                                   <div style="background-color:<?php echo ($back); ?>">
                                                                    <p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
                                                                    <p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
                                                                   </div>
                                                        <?php
                                                                    $iCont++;
                                                                }
                                                        ?>
                                                                <p align="center">
                                                                    <button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoesModal(<?php  echo ($codigo); ?>);">Ver Mais</button>
                                                                </p>
                                                        <?php
                                                            
                                                            }else{
                                                        ?>
                                                               <div class="alert">
                                                                <strong>Este agente não possui avaliações!</strong>
                                                                </div>
                                                        
                                                        <?php
                                                            }
                                                        ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                <?php
									}
								?>
                                
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
     
      </div>
  

