<script>
	function validarConvite(){
		if ($('#NomeAmigo').val() == ''){
			alert ('O campo NOME DO AMIGO é obrigatório!');
			$('#NomeAmigo').focus();
			return false;
		}
		if ($('#EmailAmigo').val() == ''){
			alert ('O campo E-MAIL DO AMIGO é obrigatório!');
			$('#EmailAmigo').focus();
			return false;
		}
		var obj = document.getElementById('EmailAmigo');
		var txt = obj.value;
		if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 7))){
			alert('Email inválido! Digite um email válido');
			$('#EmailAmigo').focus();
			return false;
		}
	}
</script>
<span class="span1"></span>
<span class="span10">
    <div class="bloco_paginas row">
        <div class="contentCadastro">

            <fieldset class="left30">
            <legend>Convidar Amigo</legend>
	<?php
            $msgTxt = ( isset( $_REQUEST['msgTxt'] ) ) ? $_REQUEST['msgTxt'] : null;
            if (  $msgTxt == 1){
        ?>
                <div class="alert alert-success">
                    Amigo convidado com sucesso!
                </div>
        <?php
            }else if($msgTxt == 2){
        ?>
                <div class="alert alert-error">
                    Problema ao convidar amigo cadastro! Tente novamente mais tarde
                </div>
        
        <?php
            }
        ?>
            
            <form name="ordenacao" id="ordenacao" method="get" action="cConvidarAmigo.php" onSubmit="return validarConvite();">
                <p>Nome do Amigo:</p>
                <p><input type="text" name="NomeAmigo" id="NomeAmigo" value="" /></p>
                <p>E-mail do Amigo:</p>
                <p><input type="text" name="EmailAmigo" id="EmailAmigo" value="" /></p>
		<input type="hidden" name="USR_ID" id="USR_ID" value="<?php echo ($_SESSION['USR_ID']); ?>">
                <p><button class="btn btn-primary" type="submit">Enviar Convite</button></p>
            </form>

            
        </div><!--Fecha contentPaginas  & contentCadastro-->
        
    </div>
</span>