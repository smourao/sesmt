<center><img src='images/alterarsenha.jpg' border=0></center>
<p align=justify>
<?PHP
//-------------------------------------------------------------------------------------------------------
// -- POST -> CHANGE PASSWORD
//-------------------------------------------------------------------------------------------------------
if($_POST && $_POST[btnChangePass]){
    $email = $_SESSION[user_id];
    $sql = "SELECT email, 1 as pessoa FROM reg_pessoa_fisica WHERE email = '$email'
    UNION
    SELECT email, 2 as pessoa FROM reg_pessoa_juridica WHERE email = '$email'";
    $result = pg_query($sql);
    $buffer = pg_fetch_array($result);
    if(pg_num_rows($result)){
        if($newpass == $newpass2 && strlen($newpass) >= 4){
            if($buffer[pessoa] == 1)
                $sql = "UPDATE reg_pessoa_fisica SET senha = '".md5($newpass)."' WHERE email='$email'";
            else
                $sql = "UPDATE reg_pessoa_juridica SET senha = '".md5($newpass)."' WHERE email='$email'";
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
        Houve um erro ao verificar o e-mail <b>$email</b>, por favor, tente novamente em alguns minutos.
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
    echo "Preencha os campos abaixo para definir uma nova senha.";
    echo "</div>";
    echo "<BR><p><BR>";
    echo "<form method=post name='frmforgotpass' id='frmforgotpass' onsubmit=\"if(document.getElementById('newpass').value == ''){ document.getElementById('newpass').focus(); document.getElementById('newpass').className = 'required_wrong'; return false; } if(document.getElementById('newpass').value != document.getElementById('newpass2').value){ return false; }else{ return true; }\">";
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
    echo "<center><input type=submit id='btnChangePass' name='btnChangePass' value='Alterar minha senha' onclick=\"if(document.getElementById('newpass').value != document.getElementById('newpass2').value){ document.getElementById('newpass').className = 'required_wrong'; document.getElementById('newpass2').className = 'required_wrong'; document.getElementById('newpass').focus();}\"></center>";
    echo "</form>";
}
?>
