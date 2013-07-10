<script>
	$(document).ready(function(){
		$('#USR_EMAIL_AGENTE').blur(function(){      
				if($('#USR_EMAIL_AGENTE').val() != ""){
					 $.ajax({
				     	url: "ajxVerificaEmailExistente.php",
				        global: false,
				        type: "GET",
				        data: ({USR_EMAIL: $('#USR_EMAIL_AGENTE').val()}),
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
	function validaAgente(){
		if ($('#USR_NOME_AGENTE').val() == ''){
			alert ('O campo NOME é obrigatório!');
			return false;
		}
		
		var separado = $('#USR_NOME_AGENTE').val().split(" ");
		separado = separado.length;
		if (separado == 1){
			alert ('Você precisa digitar o nome completo!');
			$('#USR_NOME_AGENTE').focus();
			return false;
		}
		
		if ($('#USR_EMAIL_AGENTE').val() == ''){
			alert ('O campo E-MAIL é obrigatório!');
			return false;
		}

		var obj = document.getElementById('USR_EMAIL_AGENTE');
		var txt = obj.value;
		if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 7))){
			alert('Email inválido! Digite um email válido');
			$('#USR_EMAIL_AGENTE').focus();
			return false;
		}
		
		if ($('#USR_EMAIL_AGENTE').val() != $('#USR_EMAIL_AGENTE_CONFIRMAR').val()){
			alert ('Os e-mails não conferem!');
			$('#USR_EMAIL_AGENTE').focus();
			return false;
		}
		
		if ($('#EMAIL_EXISTENTE').val() == 1){
			alert ('Este E-MAIL já está sendo usado! Por favor, digite um outro E-MAIL');
			$('#USR_EMAIL_AGENTE').focus();
			return false;
		}
		
		if ($('#USR_SENHA_AGENTE').val() == ''){
			alert ('O campo SENHA é obrigatório!');
			return false;
		}
		
		if (document.getElementById('USR_SENHA_AGENTE').value.length < 6 ){
			alert ('A senha deve conter no minimo 6 caracteres!');
			$('#USR_SENHA_AGENTE').focus();
			return false;
		}
		
		if ($('#USR_SENHA_AGENTE_CONFIRMAR').val() == ''){
			alert ('O campo CONFIRME SUA SENHA é obrigatório!');
			$('#USR_SENHA_AGENTE_CONFIRMAR').focus();
			return false;
		}
		
		if ($('#USR_SENHA_AGENTE').val() != $('#USR_SENHA_AGENTE_CONFIRMAR').val()){
			alert ('As senhas não conferem!');
			$('#USR_SENHA_AGENTE').focus();
			return false;
		}
		
		if ($('#USR_TELEFONE1_AGENTE').val() == ''){
			alert ('O campo TELEFONE DE CONTATO 1 é obrigatório!');
			return false;
		}
		
		if ($('#USR_LOGO').val() != ''){
			var extensoes_permitidas = new Array(".pdf"); 
			var arquivo = document.getElementById('USR_LOGO').value;
			extensao = (arquivo.substring(arquivo.lastIndexOf("."))).toLowerCase(); 
			if (extensao != '.jpg' && extensao != '.png'){
				alert ('Extensão não permitida! Selecione arquivos de imagem');
				$('#USR_LOGO').focus();
				return false;
			}
		}
	}
</script>

<div class="bloco_paginas row">
	<div class="contentCadastro">
	<?php
		$msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
		$logo   = $_GET['logo'];

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
		if ($logo == 2){
	?>
    		<div class="alert alert-error">
           		Problema ao realizar o upload do logo! O tamanho não pode ser maior que 200Kb. Após confirmação atualize seu cadastro.
            </div>
    <?php	
		}
	?>

    <form method="post" name="Usuario" onsubmit="return validaAgente();" enctype="multipart/form-data" action="cCadastroAgente.php">
    	<input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
        <fieldset class="left30">
        <legend>Cadastro de Agente</legend>
        <label>Nome Completo</label>
        <input type="text" name="USR_NOME_AGENTE" id="USR_NOME_AGENTE">
        <label>Agência em que trabalha</label>
        <input type="text" name="USR_AGENCIA_AGENTE" id="USR_AGENCIA_AGENTE">
        <div class="row">
        	<div class="span3"><label>Telefone de Contato 1</label>
       			 <input type="text" name="USR_TELEFONE1_AGENTE" id="USR_TELEFONE1_AGENTE"></div>
            <div class="span3"> <label>Telefone de Contato 2</label>
        		<input type="text" name="USR_TELEFONE2_AGENTE" id="USR_TELEFONE2_AGENTE"></div>
            <div class="span3"> <label>Telefone de Contato 3</label>
       			 <input type="text" name="USR_TELEFONE3_AGENTE" id="USR_TELEFONE3_AGENTE"></div>
        </div>
        
        <div class="row">
        	<div class="span3"><label>E-mail</label>
       			 <input type="text" name="USR_EMAIL_AGENTE" id="USR_EMAIL_AGENTE">
                 <div class="control-group error" id="EmailExistente" style="display:none">	
                 	<span class="help-inline">E-mail já existente</span>
                 </div>
                 <input type="hidden" name="EMAIL_EXISTENTE" id="EMAIL_EXISTENTE" value="0" />
            </div>
            <div class="span3"> <label>Confirmar E-mail</label>
        		<input type="text" name="USR_EMAIL_AGENTE_CONFIRMAR" id="USR_EMAIL_AGENTE_CONFIRMAR"></div>
        </div>
        <div class="row">
        	<div class="span3"> <label>Senha</label>
        		<input type="password" name="USR_SENHA_AGENTE" id="USR_SENHA_AGENTE"></div>
            <div class="span3"> <label>Confirmar Senha</label>
       		 <input type="password" name="USR_SENHA_AGENTE_CONFIRMAR" id="USR_SENHA_AGENTE_CONFIRMAR"></div>
        </div>
        <label>Logo</label>
        <input type="file" name="USR_LOGO" id="USR_LOGO">
        <label><input type="checkbox" name="USR_NOTIFICACOES_AGENTE" id="USR_NOTIFICACOES_AGENTE" value="1" /> Aceito receber noticias e novidades do site em meu e-mail</label>
       
        
        <label></label>
        <button type="submit" class="btn">Cadastrar
        </button>
        </fieldset>
    </form>
    </div><!--Fecha contentPaginas  & contentCadastro-->
</div>

