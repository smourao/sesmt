/* function valida_usuario()
 {
	 if(document.form_cad_usuario.login.value == "")
	{
	   alert("Campo ''LOGIN'' vazio! Preencha o campo.");
	   document.form_cad_usuario.login.focus();
	   return false;
	}
	else
    	if (document.form_cad_usuario.senha.value == "")
	{
	   alert("Campo ''SENHA'' vazio! Preencha o campo.");
	   document.form_cad_usuario.senha.focus();
	   return false;
	}
 }*/
 
  function valida_cnae(cnae_digitado)
 {
	 if(document.cadastro.cnae_digitado.value != "$cnae_digitado")
	{
	   alert("Campo ''CNAE'' vazio! Preencha o campo.");
	   document.cadastro.cnae_digitado.focus();
	   return false;
	}
	/*else
    	if (document.form_cad_cliente.nome.value == "")
	{
	   alert("Campo ''NOME'' vazio! Preencha o campo.");
	   document.form_cad_cliente.nome.focus();
	   return false;
	}*/
 }