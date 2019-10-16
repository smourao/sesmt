<?PHP
/***************************************************************************************************/
// --> DECLARAÇÃO DE VARIÁVEIS
/***************************************************************************************************/
$lerro = "&nbsp;";
/***************************************************************************************************/
// --> LOGOUT
/***************************************************************************************************/
if($_GET[logout]){
    //$sql = "INSERT INTO log (usuario_id, data, detalhe)values('".$_SESSION[usuario_id]."', '".date('m/d/Y H:i:s')."', 'logout')";
    //$lre = pg_query($sql);
    makelog($_SESSION[usuario_id], 'logout', 1);
    unset($_SESSION[usuario_id]);
    unset($_SESSION[grupo]);
    echo "<script>location.href='?p=login';</script>";
}

/***************************************************************************************************/
// --> LOGIN - POST
/***************************************************************************************************/
if($_POST){
    $login = anti_injection($_POST[login_name]);
    $senha = anti_injection($_POST[passwd]);

    $sql    = "SELECT * FROM usuario WHERE login='$login' and senha='$senha'";
    $result = pg_query($sql);
    $row    = pg_fetch_array($result);

    if(pg_num_rows($result) > 0){
        $sql = "SELECT * FROM grupo WHERE grupo_id='{$row[grupo_id]}'";
	    $res = pg_query($sql);
	    $grp = pg_fetch_array($res);
	    makelog($row[funcionario_id], 'login', 0);
	    $_SESSION['usuario_id'] = $row[funcionario_id];
        $_SESSION['grupo'] = $grp[nome];
    }else{
        showMessage("Login e/ou senha incorretos!", 1);
        makelog(0, 'Erro ao efetuar login! Usuário: '.$login.' Senha: '.$senha, 3);
    }
}
/***************************************************************************************************/
// --> REDIRECIONA CASO LOGADO
/***************************************************************************************************/
if($_SESSION[usuario_id]){
    if($_GET[p] == 'login'){
        echo redirectme('?p=main');
    }else{
        echo "<meta http-equiv=\"refresh\" content=\"0\">";
    }
    //Disabled to not redirect to index after login, should redirect to the original link after login!
}else{
?>
<BR>
<form name="fLogin" method="post">
    <table cellspacing="0" cellpadding="0" width="510" align=center>
	<tr><td id="loginTitle">Identificação de Usuário<br>SESMT</td></tr>
	<tr><td id="loginForm">
		<p class=bsmall align=justify>Entre com seu nome de usuário no campo "Login" e sua senha no campo "Senha", utilizando o teclado virtual. Depois clique em "Entrar".</p>
		<table class="formFields" cellspacing="0" width="100%" border=0>
			<tr>
				<td class="bmedium" width=150>Login</td>
				<td><input type="text" class="inputText" name="login_name" id="login_name" value="<?PHP echo $_POST[login_name];?>" size="25" maxlength="501" tabindex="1"></td>
			</tr>
			<tr>
				<td class="bmedium" width=150>Senha</td>
				<td>
                <INPUT maxlength="255" class="tx keyboardInput inputText" tabindex="2" name="passwd" id="fid-passwd" type="password" value="" size="25" onKeyPress="if ((window.event ? event.keyCode : event.which) != 13) { /*verify_login();*/alert('Para sua segurança, utilize o teclado virtual!');return false; }">
                <input type=hidden name="last" id="last" value='document.referrer;'>
                <input type="hidden" name="UcLogin1$btnLogin" id="UcLogin1_btnLogin"/>
                </td>
			</tr>
		</table>
		<BR>
		<div align=center id="error"><?PHP //echo $lerro;?></div>
	<div class="formButtons">
		<table width="100%" cellspacing="0"><tr>
			<td class="main" id="get_password">
                <a href="#" onClick="">Esqueçeu sua senha?</a>
			</td>
			<td class="misc" align=right>
            <DIV class="commonButton" id="bid-login">
            <input type="submit" class="btn" name="sub-login" value="Entrar" onclick="if(document.getElementById('login_name').value=='' || document.getElementById('fid-passwd').value==''){return false;}">
            </DIV></td>
		</tr></table>
		</form>
	</div>
	</td></tr>
</table>
<?PHP
}
?>
