<script>
	function validaContato(){
		if ($('#GOSTARIA_FALAR').val() == 'x'){
			alert ('O campo COM QUEM VOCÊ GOSTARIA DE FALAR é obrigatório!');
			$('#GOSTARIA_FALAR').focus();
			return false;
		}
		if ($('#ASSUNTO').val() == ''){
			alert ('O campo ASSUNTO é obrigatório!');
			$('#ASSUNTO').focus();
			return false;
		}
		if ($('#EMAIL_RETORNO').val() == ''){
			alert ('O campo E-MAIL PARA RETORNO é obrigatório!');
			$('#EMAIL_RETORNO').focus();
			return false;
		}
		if ($('#NOME').val() == ''){
			alert ('O campo NOME é obrigatório!');
			$('#NOME').focus();
			return false;
		}
		if ($('#MENSAGEM').val() == ''){
			alert ('O campo MENSAGEM é obrigatório!');
			$('#MENSAGEM').focus();
			return false;
		}
	}
</script>
<?php
	$USR_NOME = NULL;
	$USR_EMAIL = NULL;
	if (isset($_SESSION['USR_ID'])){
		$hQry = mysql_query ("SELECT USR_NOME, USR_EMAIL FROM tb_usuario WHERE USR_ID = '$_SESSION[USR_ID]'");
		$jQry = mysql_fetch_array ($hQry);
		$USR_NOME = $jQry['USR_NOME'];
		$USR_EMAIL = $jQry['USR_EMAIL'];
	}
?>
<div class="bloco_paginas row">
	<div class="contentCadastro">

		<?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		if (  $msgTxt == 1){
		?>
				<div class="alert alert-success">
					Contato enviado com sucesso
				</div>
		<?php
			}else if($msgTxt == 2){
		?>
    		<div class="alert alert-error">
         		Falha ao enviar contato! Tente novamente mais tarde
            </div>
        <?php
			}
		?>
        <fieldset class="left30">
            <legend>Contato</legend>
            <form method="post" name="Contato" onsubmit="return validaContato();" action="cContato.php">
                <input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
                <label>Com quem você gostaria de falar?</label>
                <select name="GOSTARIA_FALAR" id="GOSTARIA_FALAR">
                	<option value="x">Selecione</option>
                    <option value="1">Financeiro</option>
                    <option value="2">Atendimento</option>
                    <option value="3">Diretoria</option>
                </select>
                <label>Assunto</label>
                <input type="text" name="ASSUNTO" id="ASSUNTO">
                <label>E-mail para retorno</label>
                <input type="text" name="EMAIL_RETORNO" id="EMAIL_RETORNO" value="<?php echo ($USR_EMAIL); ?>">
                <label>Nome</label>
                <input type="text" name="NOME" id="NOME" value="<?php echo ($USR_NOME); ?>">
                <label>Mensagem</label>
                <textarea name="MENSAGEM" id="MENSAGEM"></textarea>
                <label></label>
                <button type="submit" class="btn">Cadastrar</button>
                </fieldset>
            </form>
        </fieldset>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>