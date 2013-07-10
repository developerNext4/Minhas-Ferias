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
		
		if ($('#USR_EMAIL').val() != $('#USR_EMAIL_CONFIRMAR').val()){
			alert ('Os e-mails não conferem!');
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
		
		if ($('#USR_TELEFONE1').val() == ''){
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

		if (  $msgTxt == 1){
	?>
    		<div class="alert alert-success">
            	Parabéns! Seu cadastro foi confirmado com sucesso. Realize o login para continuar
            </div>
    <?php
		}else if($msgTxt == 2){
	?>
    	    <div class="alert alert-error">
           		Erro ao confirmar cadastro! Código inválido
            </div>
    <?php
		}
	?>
    
    
    </div><!--Fecha contentPaginas  & contentCadastro-->
</div>

