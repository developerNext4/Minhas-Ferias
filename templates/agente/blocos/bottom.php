  <div class="container footerAdmin">
    	<div class="span"> 
       <span class="bg_destfooter">Você é um agente de Viagens<br /> <a href="#">Cadastre-se aqui</a></span>
      </div>
      <div class="span5 menuFooter">
        <span>Navegue pelo site:</span>
        <ul>
        	<li><a href="index.php?pg=8">Sobre</a></li>
            <li><a href="#">Perguntas Frequentes</a></li>
            <li><a href="#">Termos de uso</a></li>
            <li><a href="#">Contato</a></li>
        </ul>
      </div>
      <div class="span2 blocoSocial">
      <p class="tituloSocial">Redes Sociais</p>
          <p>Siga-nos e acompanhe.</p>
          <?php
            $reQry = mysql_query ("SELECT * FROM tb_redes_sociais LIMIT 1");
            $eeQry = mysql_fetch_array ($reQry);
          ?>
          <a href="<?php echo ($eeQry['RDS_FACEBOOK']) ?>" target="_blank"><span class="boxFacebook"></a></span>
          <a href="<?php echo ($eeQry['RDS_TWITTER']) ?>" target="_blank"><span class="boxTwiter"></a></span> 
          <a href="<?php echo ($eeQry['RDS_YOUTUBE']) ?>" target="_blank"><span class="boxyottube"></a></span>

      </div>
      <div style="clear:both"></div>
<p class="copyright">© 2013 Vazzo.com.br - Todos os direitos reservados</p>
  </div>
   


<!---Fecha div Container-->

</body>
</html>