<table cellspacing="0" cellpadding="0" width="510" align=center>

	<tr><td id="loginTitle">Identificação de Usuário<br>SESMT</td></tr>
	<tr><td id="loginForm">
		<p class=bsmall align=justify>Entre com seu nome de usuário no campo "Login" e sua senha no campo "Senha", utilizando o teclado virtual. Depois clique em "Entrar".</p>

		<form name="fLogin" method="post" onSubmit="if((document.forms[1]) && (!document.forms[1].passwd.value)) document.forms[1].passwd.focus(); return false;">
		<table class="formFields" cellspacing="0" width="100%" border=0>
			<tr>
				<td class="bmedium" width=150>Login</td>
				<td><input type="text" class="inputText" name="login_name" id="login_name" value="" size="25" maxlength="501" tabindex="1"></td>
			</tr>
			<tr>
				<td class="bmedium" width=150>Senha</td>
				<td><INPUT maxlength="255" class="tx keyboardInput inputText" tabindex="2" name="passwd" id="fid-passwd" type="password" value="" size="25" onKeyPress="if ((window.event ? event.keyCode : event.which) != 13) { /*verify_login();*/return false; }></td>
			</tr>
			<tr>
				<td class="bmedium">Idioma</td>
				<td><select name="locale_id" class="select" id="fid-locale_id" onChange="">
                    <option value='pt-BR' SELECTED>Padrão</option>
	                <option value='en-US'>ENGLISH (United States)</option>
                 </select>
               </td>
			</tr>
		</table>
		<input type="hidden" name="login_name" value="">
		</form>
	<div class="formButtons">
		<table width="100%" cellspacing="0"><tr>
			<td class="main" id="get_password">
				<input type="hidden" name="login_name" value="">
                <a href="#" onClick="">Esqueçeu sua senha?</a>
			</td>
			<td class="misc">
            <DIV class="commonButton" id="bid-login" onClick="return login_oC(document.forms[0], document.forms[1]);return false;" onMouseOver="" onMouseOut="">
            <input type="submit" class="btn" name="sub-login" value="Entrar">
            <!--
            <BUTTON name="bname_login" tabindex="3" id="buttonid-login" type="button">Log In</BUTTON>
            -->
            </DIV></td>

		</tr></table>

		</form>
	</div>

	</td></tr>
</table>


