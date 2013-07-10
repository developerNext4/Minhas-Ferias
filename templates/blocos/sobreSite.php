<div class="bloco_paginas row">
	<div class="contentCadastro">

        <fieldset class="left30">
            <legend>Sobre o Site</legend>
            <?php
				require_once( "./classes/DAO/UtilsDAO.php" );
				$oUtilsDAO		= new UtilsDAO();
				
				$hQry = mysql_query ("SELECT SBR_TEXTO FROM tb_sobre");
				$jQry = mysql_fetch_array ($hQry);
				echo (utf8_encode ($jQry['SBR_TEXTO']));
			?>
        </fieldset>
    </div><!--Fecha contentPaginas  & contentCadastro-->
    
</div>