<script>

	function validaEsqueciSenha(){
		
		if ($('#USR_SENHA_NOVA').val() == ''){
			alert ('O campo NOVA SENHA é obrigatório!');
			$('#USR_SENHA_NOVA').focus();
			return false;
		}
		if ($('#USR_SENHA_NOVA_CONFIRMA').val() == ''){
			alert ('O campo CONFIRMARÇÃO DE SENHA é obrigatório!');
			$('#USR_SENHA_NOVA_CONFIRMA').focus();
			return false;
		}
		
		if($('#USR_SENHA_NOVA').val() != $('#USR_SENHA_NOVA_CONFIRMA').val()){
			alert ('As senhas não conferem!');
			$('#USR_SENHA_NOVA').focus();
			return false;
		}
		if ($('#CODIGO').val() == ''){
			alert ('Não é possível gerar nova senha! Entre em contato com o administrador');
			return false;
		}
	}
</script>

<div class="bloco_paginas row">
	<div class="contentCadastro">
	<?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		if (  $msgTxt == 1){
	?>
    		<div class="alert alert-success">
            	Senha alterada com sucesso
            </div>
    <?php
		}else if($msgTxt == 2){
	?>
    	    <div class="alert alert-error">
           		Erro ao alterar senha! Tente novamente mais tarde
            </div>
    
    <?php
		}
	?>

    <form method="post" name="Usuario" onsubmit="return validaEsqueciSenha();" action="recuperarSenha.php">
    	<input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
        <fieldset class="left30">
        <legend>Recuperar Senha</legend>
        <div class="span3">
            <label>Nova Senha</label>
            <input type="password" name="USR_SENHA_NOVA" id="USR_SENHA_NOVA">
      	</div>
        <div class="span3">
            <label>Confirmação da Senha</label>
            <input type="password" name="USR_SENHA_NOVA_CONFIRMA" id="USR_SENHA_NOVA_CONFIRMA">
            <input type="hidden" name="CODIGO" id="CODIGO" value="<?php echo ($_GET["Codigo"]); ?>" />
      	</div>
        <div class="span3">
        <button type="submit" class="btn">Enviar</button>
        </div>
        </fieldset>
    </form>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>