<?php
	// Requisições de Arquivos Externos //
		require_once( "./classes/DAO/UtilsDAO.php" );
		require_once( "./classes/Utils/Util.php" );
	// ================================ //
	
	// Instanciando Objetos //
		$oUtil 			= new Util();
		$oUtilsDAO		= new UtilsDAO();
	// ==================== //
	
		$USR_ID = $_REQUEST['USR_ID'];
		$Contador = $_REQUEST['Contador'] + 2;
		$FONTE = $_REQUEST['FONTE'];
		
		if ($FONTE != NULL){
			$pQry = mysql_query ("SELECT * FROM tb_avaliacao WHERE AVL_AVALIADO = '$USR_ID'
			ORDER BY AVL_ID DESC LIMIT $Contador");
			$iCont = 1;
			?>
			<input type="hidden" name="Contador" id="Contador" value="<?php echo ($Contador); ?>" />
			<?php
			while ($oQry = mysql_fetch_array ($pQry)){
				if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
				else{ $back = "#FFFFCC"; }
			?>
				<div style="background-color:<?php echo ($back); ?>">
					<p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
					<p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
				 </div>
			 <?php
				$iCont++;
			}
			?>
			
			<p align="center">
								<button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoes(<?php echo ($USR_ID); ?>);">Ver Mais</button>
							</p>
           <?php
		}else{
	
			$pQry = mysql_query ("SELECT * FROM tb_avaliacao WHERE AVL_AVALIADO = '$_SESSION[USR_ID]'
			ORDER BY AVL_ID DESC LIMIT $Contador");
			$iCont = 1;
			?>
			<input type="hidden" name="Contador" id="Contador" value="<?php echo ($Contador); ?>" />
			<?php
			while ($oQry = mysql_fetch_array ($pQry)){
				if( $iCont % 2 == 0 ){ $back = "#E2FEEC"; }
				else{ $back = "#FFFFCC"; }
			?>
				<div style="background-color:<?php echo ($back); ?>">
					<p><?php echo ($oUtilsDAO->verifyEstrelas($oQry['AVL_NOTA'])); ?></p>
					<p><?php echo (utf8_encode ($oQry['AVL_OBSERVACAO'])); ?></p>
				 </div>
			 <?php
				$iCont++;
			}
			?>
			
			<p align="center">
								<button class="btn btn-primary" type="button" onclick="verifyMaisAvaliacoes();">Ver Mais</button>
							</p>
        <?php
		}
		?>