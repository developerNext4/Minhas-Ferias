<script>
	function validaSenha(){
		if ($('#Email').val() == ''){
			alert ('Digite o e-mail');
			$('#Email').focus();
			return false;
		}
		if ($('#Senha').val() == ''){
			alert ('Digite a senha');
			$('#Senha').focus();
			return false;
		}
	}
</script>
<body>
<div class="container">
  <div class="row">
    <div class="span6 offset6 areaLogin">
      <form class="form-inline form_Home" method="post" action="valida.php" onSubmit="return validaSenha();">
        <label class="titLogin">&Aacute;rea de Login </label>
        <label class="check">
          <input type="checkbox" name="Conectado" id="Conectado" value="1">
          Mantenha-me conectado </label>
        <br />
        <input type="text" class="input-small" name="Email" id="Email" placeholder="Digite seu email">
        <input type="password" class="input-small" name="Senha" id="Senha" placeholder="Senha">
        <button type="submit" class="btn btn-rky">Entrar</button>
      </form>
      <?php
	  	$login = ( isset( $_REQUEST['login'] ) ) ? $_REQUEST['login'] : null;
		if ($login == "2"){
	  ?>
      		<span class="colorRed">Senha incorreta! Se n&atilde;o lembra, utilize o esqueceu sua senha</span>
      <?php
	  	}
	  ?>
      
      <?php
	  	if ($login == "1"){
	  ?>
      		<span class="colorRed">Conta n&atilde;o confirmada! Caso n&atilde;o recebeu o e-mail <a href="index.php?pg=7">Clique Aqui</a></span>
      <?php
	  	}
	  ?>
      
      <?php
	  	if ($login == "3"){
	  ?>
      		<span class="colorRed">Usu&aacute;rio bloqueado! Entre em contato com o administrador</span>
      <?php
	  	}
	  ?>
      
       <?php
	  	if ($login == "4"){
	  ?>
      		<span class="colorRed">E-mail n&atilde;o cadastrado! Clique em cadastra-se</span>
      <?php
	  	}
	  ?>
      <div class="linksTop"><a href="index.php?pg=5"> Esqueceu sua senha?</a> | <a href="#myModal" role="button"  data-toggle="modal"> Cadastre-se</a> | <a href="index.php?pg=3">Cadastro Fornecedores</a></div>
      <div class="socialMedia"> <span class="socialTul"> Compartilhe</span> </div>
    </div>
  </div>
  <!---- Conteudo Principal Home ---->
  
      <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Cadastro de Cliente</h3>
        </div>
        <div class="modal-body">
            <script>
				$(document).ready(function(){
                                        $.validateEmail = function (email){
                                            er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
                                            if(er.exec(email)){
                                                    var error = 1;
                                            }else{
                                                    var error = 0;
                                            }
                                            return error;
                                        };
					$('#USR_EMAIL').blur(function(){ 
							if($('#USR_EMAIL').val() != ""){
								 $.ajax({
									url: "ajxVerificaEmailExistente.php",
									global: false,
									type: "GET",
									data: ({USR_EMAIL: $('#USR_EMAIL').val(), EMAIL_ATUAL : ''}),
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
					$('#Salvar').click(function(){      
						var erro = valida();
						if (erro != false){
							$.ajax({
								url: "ajxCadastroCliente.php",
								global: false,
								type: "GET",
								data: ({USR_EMAIL: $('#USR_EMAIL').val(), USR_NOME: $('#USR_NOME').val(), USR_SENHA: $('#USR_SENHA').val(), acaoTela: "insert"}),
								dataType: "html",
								success: function(data){
									document.getElementById('formulario').style.display = 'none';
									document.getElementById('retorno').style.display = 'block';
									if (data == 1){
										document.getElementById('sucesso').style.display = 'block';
									}else if (data == 3){
										document.getElementById('cotacao').style.display = 'block';
									}else{
										document.getElementById('erro').style.display = 'block';
									}
								}
							 });
						}
					});
				});
				function valida(){
					if ($('#USR_NOME').val() == ''){
						alert (utf8_decode('O campo NOME é obrigatório!'));
						return false;
					}
					
					var separado = $('#USR_NOME').val().split(" ");
					separado = separado.length;
					if (separado == 1){
						alert (utf8_decode('Você precisa digitar o nome completo!'));
						$('#USR_NOME').focus();
						return false;
					}
					
					if ($('#USR_EMAIL').val() == ''){
						alert (utf8_decode('O campo E-MAIL é obrigatório!'));
						return false;
					}
			
					/*var obj = document.getElementById('USR_EMAIL');
					var txt = obj.value;
					if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 7))){
						alert(utf8_decode('Email inválido! Digite um email válido'));
						$('#USR_EMAIL').focus();
						return false;
					}*/
                                        var valida = $.validateEmail($('#USR_EMAIL').val());
                                        if (valida == 0){
                                            alert(utf8_decode('Email inválido! Digite um email válido'));
                                            $('#USR_EMAIL').focus();
                                            return false;
                                        }
					
					if ($('#EMAIL_EXISTENTE').val() == 1){
						alert (utf8_decode('Este E-MAIL já está sendo usado! Por favor, digite um outro E-MAIL'));
						$('#USR_EMAIL').focus();
						return false;
					}
					
					if ($('#USR_SENHA').val() == ''){
						alert (utf8_decode('O campo SENHA é obrigatório!'));
						return false;
					}
					
					if (document.getElementById('USR_SENHA').value.length < 6 ){
						alert ('A senha deve conter no minimo 6 caracteres!');
						$('#USR_SENHA').focus();
						return false;
					}
					
					if ($('#USR_SENHA_CONFIRMAR').val() == ''){
						alert (utf8_decode('O campo CONFIRME SUA SENHA é obrigatório!'));
						$('#USR_SENHA_CONFIRMAR').focus();
						return false;
					}
					
					if ($('#USR_SENHA').val() != $('#USR_SENHA_CONFIRMAR').val()){
						alert (utf8_decode('As senhas não conferem!'));
						$('#USR_SENHA').focus();
						return false;
					}
				}
				

			</script>
            	<div id="retorno" style="display:none">
						<div class="alert alert-success" id="sucesso" style="display:none">
							Cadastro realizado com sucesso! Verifique seu e-mail para confirma&ccedil;&atilde;o do seu cadastro
						</div>
						<div class="alert alert-error" id="erro" style="display:none">
							Houve um problema ao realizar o cadastro! Tente novamente mais tarde.
						</div>
                        <div class="alert alert-success" id="cotacao" style="display:none">
							Cadastro realizado com sucesso! Verifique seu e-mail para confirma&ccedil;&atilde;o do seu cadastro para ativar o Pedido de Cota&ccedil;&atilde;o
						</div>
                </div>
			
            	<div id="formulario">
                    <form method="post" name="Usuario" action="cCadastroCliente.php">
                        <input type="hidden" name="acaoTela" id="acaoTela" value="insert" />
                        <fieldset class="left30">
                        <label>Nome Completo</label>
                        <input type="text" name="USR_NOME" id="USR_NOME">
                        <label>E-mail</label>
                        <input type="text" name="USR_EMAIL" id="USR_EMAIL">
                        <div class="control-group error" id="EmailExistente" style="display:none">	
                               <span class="help-inline">E-mail j&aacute; existente</span>
                        </div>
                        <input type="hidden" name="EMAIL_EXISTENTE" id="EMAIL_EXISTENTE" value="0" />
                        <label>Senha</label>
                        <input type="password" name="USR_SENHA" id="USR_SENHA">
                        <label>Confirmar Senha</label>
                        <input type="password" name="USR_SENHA_CONFIRMAR" id="USR_SENHA_CONFIRMAR">
                        <label></label>
                        <button type="button" id="Salvar" name="Salvar" class="btn btn-primary">Cadastrar</button>
                        </fieldset>
                    </form>
                 </div>
        
        </div>
    </div>