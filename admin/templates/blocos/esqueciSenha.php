<script>

	function validaEsqueciSenha(){
		
		if ($('#USR_EMAIL_SENHA').val() == ''){
			alert ('O campo E-MAIL é obrigatório!');
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
            	Foi enviado um e-mail para sua conta contendo as instruções para gerar a nova senha
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
           		Seu cadastro esta pendente de ativação, verifique sua caixa de e-mail e siga instruções do e-mail que você recebeu sobre o cadastro no site. Caso não tenha recebido o e-mail clique <a href="index.php?pg=7">AQUI</a> que reenviaremos            </div>
    <?php
		}else if($msgTxt == 4){
	?>
    		<div class="alert alert-error">
           		Usuário BANIDO, acesso não permitido. Caso queira contestar essa informação entre em contato com o site clicando através da página de CONTATO
            </div>
    <?php
		}
	?>

    <form method="post" name="Usuario" onsubmit="return validaEsqueciSenha();" action="cEsqueciSenha.php">
    	<input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
        <fieldset class="left30">
        <legend>Esqueci Minha Senha</legend>
        <label>E-mail</label>
        <input type="text" name="USR_EMAIL_SENHA" id="USR_EMAIL_SENHA">
        <button type="submit" class="btn">Enviar</button>
        </fieldset>
    </form>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>