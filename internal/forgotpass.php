<center><img src='images/recuperarsenha.jpg' border=0></center>
<p align=justify>
<?PHP
/******************************************************************************************************************/
// --> RECUPERAR A SENHA - VALIDAÇÃO POR TOKEN E E-MAIL
/******************************************************************************************************************/
if($_GET[token] && $_GET[email]){
    $email = anti_injection($_GET[email]);
    $token = anti_injection($_GET[token]);
    $sql = "SELECT * FROM site_lost_password WHERE email = '$email' AND token = '$token' AND status = 0";
    $rest = pg_query($sql);
    $data = pg_fetch_array($rest);
    
    //VERIFICAÇÃO: se existe a solicitação e a data é válida
    if(pg_num_rows($rest)>0 && $data[data_solicitacao] == date("Y-m-d")){
        //-------------------------------------------------------------------------------------------------------
        // -- POST -> CHANGE PASSWORD
        //-------------------------------------------------------------------------------------------------------
        if($_POST){
            $sql = "SELECT email, 1 as pessoa FROM reg_pessoa_fisica WHERE email = '{$_GET[email]}'
            UNION
            SELECT email, 2 as pessoa FROM reg_pessoa_juridica WHERE email = '{$_GET[email]}'";
            $result = pg_query($sql);
            $buffer = pg_fetch_array($result);
            if(pg_num_rows($result)){
                if($newpass == $newpass2 && strlen($newpass) >= 4){
                    if($buffer[pessoa] == 1)
                        $sql = "UPDATE reg_pessoa_fisica SET senha = '".md5($newpass)."' WHERE email='$email'";
                    else
                        $sql = "UPDATE reg_pessoa_juridica SET senha = '".md5($newpass)."' WHERE email='$email'";
                    pg_query($sql);
                    $sql = "UPDATE site_lost_password
                    SET status = 1, data_finalizacao = '".date("Y/m/d")."'
                    WHERE email = '$email' AND token = '$token'";
                    if(pg_query($sql)){
                        echo "<div class='novidades_text'>
                        Sua senha foi alterada com sucesso, você já pode efetuar login em nosso sistema utilizando
                        sua nova senha cadastrada.
                        </div>";
                    }else{
                        echo "<div class='novidades_text'>
                        Houve um erro ao tentar alterar a senha em nosso banco de dados.
                        <p align=justify>
                        Este erro pode ter sido causado por diversos fatores, como indisponibilidade em nossos servidores,
                        falha no acesso ao banco de dados, entre outros...<BR>
                        Lamentamos o ocorrido, uma mensagem com informações sobre o problema foi enviada ao setor de
                        suporte e será analisada em breve.
                        <p align=justify>
                        Adicionalmente, pedimos que entre em contato com nossa equipe de suporte clicando
                        <a href='?do=contato' target=_blank>aqui</a>, ou,
                        através de nossa <a href='?do=contato' target=_blank>central de atendimento</a>.
                        </div>";
                    }
                }else{
                    if(strlen($senha) < 4){
                        echo "<div class='novidades_text'>
                        A senha informada é inválida, por favor, utilize pelo menos 4 caracteres para uma nova senha.
                        </div>";
                    }else{
                        echo "<div class='novidades_text'>
                        A confirmação de senha e a senha são diferentes.
                        </div>";
                    }
                }
            }else{
                echo "<div class='novidades_text'>
                O e-mail <b>$email</b> não está cadastrado em nosso banco de dados, por favor,
                tente novamente com um e-mail diferente.
                <p align=justify>
                Em caso de dúvidas, entre em contato com nossa <a href='?do=contato' target=_blank>central de atendimento</a>.
                </div>";
            }
        //-------------------------------------------------------------------------------------------------------
        // -- FORM -> CHANGE PASSWORD
        //-------------------------------------------------------------------------------------------------------
        }else{
            //form to change pass
            echo "<div class='novidades_text'>";
            echo "Preencha os campos abaixo para definir uma nova senha para o login <b>$email</b>.";
            echo "</div>";
            echo "<BR><p><BR>";
            echo "<form method=post name='frmforgotpass' id='frmforgotpass' onsubmit=\"if(document.getElementById('newpass').value != document.getElementById('newpass2').value){ return false; }else{ return true; }\">";
            echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
            echo "<tr>";
            echo "<td width=180>Nova senha:</td>";
            echo "<td><input type=password id='newpass' name='newpass' class='required' onkeyup=\"change_classname('newpass', 'required');\"></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td width=180>Confirmar senha:</td>";
            echo "<td><input type=password id='newpass2' name='newpass2' class='required' onkeyup=\"change_classname('newpass2', 'required');\">&nbsp;<img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='Redigite sua senha.' title='Redigite sua senha.'></td>";
            echo "</tr>";
            echo "</table>";
            echo "<BR><p><BR>";
            echo "<center><input type=submit id='btnForgotPass' name='btnForgotPass' value='Alterar minha senha' onclick=\"if(document.getElementById('newpass').value != document.getElementById('newpass2').value){ document.getElementById('newpass').className = 'required_wrong'; document.getElementById('newpass2').className = 'required_wrong'; document.getElementById('newpass').focus();}\"></center>";
            echo "</form>";

        }
    }else{
        $sql = "UPDATE site_lost_password
        SET status = 2, data_finalizacao = '".date("Y/m/d")."'
        WHERE email = '$_GET[email]' AND token = '$_GET[token]'";
        pg_query($sql);
        echo "<div class='novidades_text'>
        Esta solicitação não é mais válida, por favor, solicite a recuperação novamente em nosso sistema
        <a href='http://sesmt-rio.com/?do=forgotpass'>clicando aqui</a>.
        </div>";
    }
/******************************************************************************************************************/
// --> RECUPERAR A SENHA - SOLICITAÇÃO POR E-MAIL
/******************************************************************************************************************/
}else{
    if($_POST && $_POST[lostemail]){
        $email = anti_injection($_POST[lostemail]);
        $sql = "SELECT * FROM site_lost_password
        WHERE
        lower(email) = '{$email}'
        AND
        data_solicitacao = '".date("Y/m/d")."'
        AND
        status = 0";
        $result = pg_query($sql);

        if(pg_num_rows($result)>0){
            echo "<div class='novidades_text'>
            Já existe uma solicitação de recuperação de senha feita na data de hoje. Por favor, verifique seu e-mail de
            cadastro.
            </div>";
        }else{
            $sql = "SELECT email FROM reg_pessoa_fisica WHERE email = '$email'
                    UNION
                    SELECT email FROM reg_pessoa_juridica WHERE email = '$email'";
            $ress = pg_query($sql);
            if(pg_num_rows($ress)>0){
                $token = rand(100000000, 999999999);
                $sql = "INSERT INTO site_lost_password
                (email, data_solicitacao, token)
                VALUES
                ('$email', '".date("Y/m/d")."', '$token')";
                $rez = pg_query($sql);
                $url = "http://www.sesmt-rio.com/?do=forgotpass&token=$token&email=$email";

                $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                <HTML><HEAD><TITLE>SESMT</TITLE><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
                <style type=\"text/css\">
                td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
                .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
                .style13 {font-size: 14px}
                .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
                .style16 {font-size: 9px}
                .style17 {font-family: Arial, Helvetica, sans-serif}
                .style18 {font-size: 12px}
                </style>
                </HEAD>
                <BODY>
                <table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
                	<tr>
                		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
                		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
                		  Monitoramento de Atividades no Trabalho ltda.</span>
                		  </font><br><br><p class=\"style18\">
                		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br><p>
                        </td>
                	</tr>
                </table>";

                $msg .= "
                <table width=100% border=0 cellpadding=0 cellspacing=0>
               	<tr>
              	<td width=100% class=fontepreta12><span class=style15>
                Foi solicitado a recuperação de senha em nosso sistema para o login <b>$email</b>,
                    se você não lembra sua senha e solicitou sua recuperação em nosso site, acesse o link abaixo
                    e informe uma nova senha para a sua conta.
                    <p>
                    Link para alteração de senha:<br> <a href='$url' target=_blank>$url</a>
                    <p>
                    <BR>
                    <p>
                    <BR>
                    <font color=red>IMPORTANTE: </font><BR>
                    - Se você não solicitou a alteração de senha, por favor, ignore esta mensagem.<BR>
                    - Esta solicitação é válida até às 23:59 do dia ".date("d/m/Y").", após esta data,
                    será necessário uma nova solicitação em nosso site.
                </td>
                </tr>
                </table>";

                $msg .= "
                <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
                	<p>
                		<tr>
                		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
                		<br /><br /><br /><br /><br /><br />
                		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
                		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
                          <p class=\"style17\">
                		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
                          www.sesmt-rio.com / www.shoppingsesmt.com<br />

                	    </td>
                		<td width=\"35%\" align=\"right\">
                        <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
                	</tr>
                </table>
                </BODY></HTML>";
                $headers = "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
                if(mail($email, "SESMT - Recuperação de Senha", $msg, $headers)){
                    echo "<div class='novidades_text'>
                    Foi enviado para o e-mail <b>$email</b> uma mensagem contendo informações
                    sobre como proceder com a recuperação de sua senha, por favor, verifique sua caixa de
                    entrada e siga os passos informados.
                    <p align=justify><BR>
                    <font color=red>IMPORTANTE:</font>
                    <BR>
                    - Dependendo do tráfego em nossos servidores, pode ser necessário aguardar alguns minutos
                    para o recebimento do e-mail em sua caixa de entrada.
                    </div>";
                }else{
                    echo "<div class='novidades_text'>
                    Houve um erro ao tentar enviar o e-mail para recuperação de senha.
                    <p align=justify>
                    Este erro pode ter sido causado por diversos fatores, como indisponibilidade em nossos servidores,
                    falha no acesso ao banco de dados, entre outros...<BR>
                    Lamentamos o ocorrido, uma mensagem com informações sobre o problema foi enviada ao setor de
                    suporte e será analisada em breve.
                    <p align=justify>
                    Adicionalmente, pedimos que entre em contato com nossa equipe de suporte clicando
                    <a href='?do=contato' target=_blank>aqui</a>, ou,
                    através de nossa <a href='?do=contato' target=_blank>central de atendimento</a>.
                    </div>
                    ";
                }
            }else{
                echo "<div class='novidades_text'>
                O e-mail <b>$email</b> não está cadastrado em nosso banco de dados, por favor,
                tente novamente com um e-mail diferente.
                <p align=justify>
                Em caso de dúvidas, entre em contato com nossa <a href='?do=contato' target=_blank>central de atendimento</a>.
                </div>";
            }
        }
    }else{
    ?>
    <div class='novidades_text'>
    <p align=justify>
    Lamentamos qualquer inconveniência por você não estar conseguindo acessar a SESMT<sup>®</sup>.
    Para recuperar sua senha, preencha o campo abaixo com o e-mail utilizado durante o processo de cadastro.
    </div>
    <BR><p><BR>
    <form method=post name='frmforgotpass' id='frmforgotpass' onsubmit="return echeck(document.getElementById('lostemail').value);">
    <table width=100% cellspacing=2 cellpadding=2 border=0>
    <tr>
    <td width=180>E-Mail:</td>
    <td><input type=text name='lostemail' id='lostemail' value='<?=$_POST[lostemail];?>' size=30 class='required' onkeyup="change_classname('lostemail', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Preencha este campo com o e-mail utilizado no momento do cadastro, será enviado para este e-mail o procedimento para recuperar sua senha.' title='Preencha este campo com o e-mail utilizado no momento do cadastro, será enviado para este e-mail o procedimento para recuperar sua senha.'></td>
    </tr>
    </table>
    <BR><p><BR>
    <center><input type=submit id='btnForgotPass' name='btnForgotPass' value='Recuperar minha senha' onclick="if(!echeck(document.getElementById('lostemail').value)){ document.getElementById('lostemail').className = 'required_wrong'; document.getElementById('lostemail').focus();}"></center>
    </form>
<?PHP
    }
}
?>
