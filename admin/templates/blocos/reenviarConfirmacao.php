<script>

	function validaConfirmacao(){
		
		if ($('#USR_EMAIL_CONFIRMACAO').val() == ''){
			alert ('O campo E-MAIL � obrigat�rio!');
			$('#USR_EMAIL_CONFIRMACAO').focus();
			return false;
		}

	}
</script>

<div class="bloco_paginas row">
	<div class="contentCadastro" style="line-height:30px">
	<?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		if (  $msgTxt == 1){
	?>
    		<div class="alert alert-success">
            	Foi enviado um e-mail para sua conta contendo as instru��es para confirmar seu cadastro
            </div>
    <?php
		}else if($msgTxt == 2){
	?>
    	    <div class="alert alert-error">
           		E-mail inexistente!
            </div>
    
    <?php
		}else if($msgTxt == 3){
	?>
    		<div class="alert alert-error">
           		A sua conta j� foi confirmada!            
            </div>
    <?php
		}else if($msgTxt == 4){
	?>
    		<div class="alert alert-error">
           		Usu�rio BANIDO, acesso n�o permitido. Caso queira contestar essa informa��o entre em contato com o site clicando atrav�s da p�gina de CONTATO
            </div>
    <?php
		}
	?>

    <form method="post" name="Usuario" onsubmit="return validaConfirmacao();" action="cReenviarConfirmacao.php">
    	<input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
        <fieldset class="left30">
        <legend>Reenviar Confirma��o de Cadastro</legend>
        <label>E-mail</label>
        <input type="text" name="USR_EMAIL_CONFIRMACAO" id="USR_EMAIL_CONFIRMACAO">
        <button type="submit" class="btn">Enviar</button>
        </fieldset>
    </form>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>