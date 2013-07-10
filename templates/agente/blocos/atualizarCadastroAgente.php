<script>
	$(document).ready(function(){
		$('#USR_EMAIL').blur(function(){      
				if($('#USR_EMAIL').val() != ""){
					 $.ajax({
				     	url: "ajxVerificaEmailExistente.php",
				        global: false,
				        type: "GET",
				        data: ({USR_EMAIL: $('#USR_EMAIL').val(), EMAIL_ATUAL: $('#EMAIL_ATUAL').val()}),
				        dataType: "html",
					    success: function(data){
							if (data == 1){
								$('#EMAIL_EXISTENTE').val('1');
								document.getElementById('EmailExistente').style.display = 'block';
							}else{
								$('#EMAIL_EXISTENTE').val('0');
								document.getElementById('EmailExistente').style.display = 'none';
							}
					    }
					 });
							 				        	 				        	 
		    	}
		});	
	});
	
	function validaAtualizarCadastroAgente(){
		if ($('#USR_NOME').val() == ''){
			alert ('O campo NOME é obrigatório!');
			return false;
		}
		
		var separado = $('#USR_NOME').val().split(" ");
		separado = separado.length;
		if (separado == 1){
			alert ('Você precisa digitar o nome completo!');
			$('#USR_NOME').focus();
			return false;
		}
		
		if ($('#USR_EMAIL').val() == ''){
			alert ('O campo E-MAIL é obrigatório!');
			$('#USR_EMAIL').focus();
			return false;
		}

		var obj = document.getElementById('USR_EMAIL');
		var txt = obj.value;
		if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 7))){
			alert('Email inválido! Digite um email válido');
			$('#USR_EMAIL').focus();
			return false;
		}
		
		if ($('#EMAIL_EXISTENTE').val() == 1){
			alert ('Este E-MAIL já está sendo usado! Por favor, digite um outro E-MAIL');
			$('#USR_EMAIL').focus();
			return false;
		}
		
		if ($('#USR_SENHA').val() != '' && document.getElementById('USR_SENHA').value.length < 6 ){
			alert ('A senha deve conter no minimo 6 caracteres!');
			$('#USR_SENHA').focus();
			return false;
		}
		
		if ($('#USR_SENHA').val() != ''){
			if ($('#USR_SENHA_CONFIRMAR').val() == ''){
				alert ('O campo CONFIRME SUA SENHA é obrigatório!');
				$('#USR_SENHA_CONFIRMAR').focus();
				return false;
			}
			if ($('#USR_SENHA').val() != $('#USR_SENHA_CONFIRMAR').val()){
				alert ('As senhas não conferem!');
				$('#USR_SENHA').focus();
				return false;
			}
		}
		
	}
</script>

<div class="span9">
<br />
	<?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Alteração de cadastro concluída com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?>
                <div class="alert alert-error">
                    Problema ao atualizar cadastro! Tente novamente mais tarde
                </div>
        
        <?php
            }
        ?>
        
        <?php
			// Requisições de Arquivos Externos //
				require_once( "./classes/DAO/UtilsDAO.php" );
			// ================================ //
			
			// Instanciando Objetos //
				$oUtilsDAO		= new UtilsDAO();
			// ==================== //

			$USR_NOME = NULL;
			$USR_EMAIL = NULL;
			$USR_TELEFONE1 = NULL;
			$USR_TELEFONE2 = NULL;
			$USR_TELEFONE3 = NULL;
			$USR_NOTIFICACOES = NULL;
			$USR_NOTICIAS_NOVIDADES = NULL;
			$USR_AGENCIA	= NULL;
			$USR_SITE		= NULL;
			
			//$cnx = mysql_connect ('localhost','root','');
			//mysql_select_db('minhas_ferias',$cnx);
			$hQry = mysql_query ("SELECT * FROM tb_usuario WHERE USR_ID = '$_SESSION[USR_ID]'");
			$jQry = mysql_fetch_array ($hQry);
			
			$USR_NOME = utf8_encode ($jQry['USR_NOME']);
			$USR_AGENCIA = utf8_encode ($jQry['USR_AGENCIA']);
			$USR_EMAIL = $jQry['USR_EMAIL'];
			$USR_TELEFONE1 = $jQry['USR_TELEFONE1'];
			$USR_TELEFONE2 = $jQry['USR_TELEFONE2'];
			$USR_TELEFONE3 = $jQry['USR_TELEFONE3'];
			$USR_SITE	= $jQry['USR_SITE'];
			$USR_ENDERECO = $jQry['USR_ENDERECO'];
			if ($jQry['USR_NOTIFICACOES'] == "1"){
				$USR_NOTIFICACOES = "checked";
			}
			if ($jQry['USR_NOTICIAS_NOVIDADES'] == "1"){
				$USR_NOTICIAS_NOVIDADES = "checked";
			}
			
		?>
    
        <form method="post" name="Usuario" onsubmit="return validaAtualizarCadastroAgente();" action="cAtualizarCadastroAgente.php">
        
            <input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
            <fieldset class="left30">
            <legend>Atualizar Cadastro</legend>
            <label>Nome Completo</label>
            <input type="text" name="USR_NOME" id="USR_NOME" class="span5" value="<?php echo ($USR_NOME); ?>">
            <label>E-mail</label>
            <input type="text" name="USR_EMAIL" id="USR_EMAIL" class="span5" value="<?php echo ($USR_EMAIL); ?>">
            <div class="control-group error" id="EmailExistente" style="display:none">	
                   <span class="help-inline">E-mail já existente</span>
            </div>
            <input type="hidden" name="EMAIL_EXISTENTE" id="EMAIL_EXISTENTE" value="0" />
            <input type="hidden" name="EMAIL_ATUAL" id="EMAIL_ATUAL" value="<?php echo ($USR_EMAIL); ?>" />
            <input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION["USR_ID"]); ?>" />
            <input type="hidden" name="Valores" id="Valores" value="" /><br>
            <label>Agência em que trabalha</label>
            <input type="text" name="USR_AGENCIA" id="USR_AGENCIA" class="span5" value="<?php echo ($USR_AGENCIA); ?>">
            <label>Telefone1</label>
            <input type="text" name="USR_TELEFONE1" id="USR_TELEFONE1" class="span4" value="<?php echo ($USR_TELEFONE1); ?>">
            <label>Telefone2</label>
            <input type="text" name="USR_TELEFONE2" id="USR_TELEFONE2" class="span4" value="<?php echo ($USR_TELEFONE2); ?>">
            <label>Telefone3</label>
            <input type="text" name="USR_TELEFONE3" id="USR_TELEFONE3" class="span4" value="<?php echo ($USR_TELEFONE3); ?>">
            <table width="100%">
            	<tr>
                	<td width="23%">
                <label>Senha</label>
                <input type="password" name="USR_SENHA" id="USR_SENHA">
                	</td>
                	<td>
                <label>Confirmar Senha</label>
                <input type="password" name="USR_SENHA_CONFIRMAR" id="USR_SENHA_CONFIRMAR">
                	</td>
                </tr>
            </table>
            <label><font color="#FF0000">* Se não quiser alterar a senha, basta deixar o campo vazio</font></label>
            <label>Site da Agência</label>
            <input type="text" name="USR_SITE" id="USR_SITE" class="span4" value="<?php echo ($USR_SITE); ?>">
            <label>Endereço da Agência</label>
            <input type="text" name="USR_ENDERECO" id="USR_ENDERECO" class="span4" value="<?php echo ($USR_ENDERECO); ?>">
            <!--<label><input type="checkbox" name="USR_NOTIFICACOES" id="USR_NOTIFICACOES" value="1"> Aceito receber informações sobre a minha conta em meu e-mail cadastrado</label>
            <label><input type="checkbox" name="USR_NOTICIAS_NOVIDADES"  id="USR_NOTICIAS_NOVIDADES" value="1"> Aceito receber noticias e novidades do site em meu e-mail</label><br>
            <label>O que você mais gosta em uma viagem?</label>
            <table width="50%">
            	<tr>
                	<td><input type="checkbox" name="Check1" id="Check1" value="1"> Texto</td>
                    <td><input type="checkbox" name="Check2" id="Check2" value="2"> Texto</td>
                    <td><input type="checkbox" name="Check3" id="Check3" value="3"> Texto</td>
                </tr>
                <tr>
                	<td><input type="checkbox" name="Check4" id="Check4" value="4"> Texto</td>
                    <td><input type="checkbox" name="Check5" id="Check5" value="5"> Texto</td>
                    <td><input type="checkbox" name="Check6" id="Check6" value="6"> Texto</td>
                </tr>-->
            </table>
            

            <label></label>
            <button type="submit" class="btn">Atualizar Cadastro</button>
        </form>
</div>

<!--<div class="span3" style="height:200px; background-color: #CCCCCC;">
	<h3>Conteudo de teste bloco span4</h3>
	
</div>-->