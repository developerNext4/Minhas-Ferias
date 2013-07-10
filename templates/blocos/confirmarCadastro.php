
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
		}else if($msgTxt == 3){
	?>
    		<div class="alert alert-success">
            	Parabéns! Seu cadastro foi confirmado com sucesso e seu Pedido de Cotação foi criado. Realize o login para continuar
            </div>
    <?php
		}
	?>
    
    
    </div><!--Fecha contentPaginas  & contentCadastro-->
</div>

