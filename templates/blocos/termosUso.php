<div class="bloco_paginas row">
	<div class="contentCadastro">

        <fieldset class="left30">
            <legend>Termos de Uso</legend>
            <?php
				require_once( "./classes/DAO/UtilsDAO.php" );
				$oUtilsDAO		= new UtilsDAO();
				
				$hQry = mysql_query ("SELECT TRM_TEXTO FROM tb_termos");
				$jQry = mysql_fetch_array ($hQry);
				echo (utf8_encode ($jQry['TRM_TEXTO']));
			?>
        </fieldset>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>