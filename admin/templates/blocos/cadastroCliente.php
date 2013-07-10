<script>
	$(document).ready(function(){
		$('#USR_EMAIL').blur(function(){      
				if($('#USR_EMAIL').val() != ""){
					 $.ajax({
				     	url: "ajxVerificaEmailExistente.php",
				        global: false,
				        type: "GET",
				        data: ({USR_EMAIL: $('#USR_EMAIL').val()}),
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
	function valida(){
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
		
		if ($('#USR_SENHA').val() == ''){
			alert ('O campo SENHA é obrigatório!');
			return false;
		}
		
		if (document.getElementById('USR_SENHA').value.length < 6 ){
			alert ('A senha deve conter no minimo 6 caracteres!');
			$('#USR_SENHA').focus();
			return false;
		}
		
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
</script>

<div class="bloco_paginas row">
	<div class="contentCadastro">
	<?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		if (  $msgTxt == 1){
	?>
    		<div class="alert alert-success">
            	Cadastro realizado com sucesso! Verifique seu e-mail para confirmação do seu cadastro
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

    <form method="post" name="Usuario" onsubmit="return valida();" action="cCadastroCliente.php">
    	<input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
        <fieldset class="left30">
        <legend>Cadastro Cliente</legend>
        <label>Nome Completo</label>
        <input type="text" name="USR_NOME" id="USR_NOME">
        <label>E-mail</label>
        <input type="text" name="USR_EMAIL" id="USR_EMAIL">
        <div class="control-group error" id="EmailExistente" style="display:none">	
               <span class="help-inline">E-mail já existente</span>
        </div>
        <input type="hidden" name="EMAIL_EXISTENTE" id="EMAIL_EXISTENTE" value="0" />
        <label>Senha</label>
        <input type="password" name="USR_SENHA" id="USR_SENHA">
        <label>Confirmar Senha</label>
        <input type="password" name="USR_SENHA_CONFIRMAR" id="USR_SENHA_CONFIRMAR">
        <label></label>
        <button type="submit" class="btn">Cadastrar</button>
        </fieldset>
    </form>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>