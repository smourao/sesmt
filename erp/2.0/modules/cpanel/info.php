<?PHP
/**********************************************************************************************/
// --> SALVA OPÇÕES
/**********************************************************************************************/
if($_POST && $_POST[btnSaveInfo]){
    $sql = "UPDATE funcionario
    SET
    email = '".addslashes($_POST[email])."',
    telefone = '".addslashes($_POST[telefone])."',
    celular = '".addslashes($_POST[celular])."',
    msn = '".addslashes($_POST[msn])."',
    skype = '".addslashes($_POST[skype])."'
    WHERE funcionario_id = {$_SESSION[usuario_id]}";
    
    $resdata = pg_query($sql);

    if($_POST[newpass] != "" && $resdata){
        if($_POST[newpass] == $_POST[newpass2]){
            $chgpass = "UPDATE usuario SET senha = '".addslashes($_POST[newpass])."' WHERE funcionario_id = $_SESSION[usuario_id]";
            $respass = pg_query($chgpass);
        }
    }else{
        $respass = 1;
    }

    if($resdata){
        if($respass){
            $ms = "Dados alterados com sucesso!";
        }else{
            $ms = "Dados alterados, mas sua senha não pôde ser definida, posssivelmente, a confirmação da senha não confere com a senha digitada. Por favor, tente novamente!";
        }
    }else{
        $ms = "Não foi possível alterar seus dados. Por favor, entre em contato com o setor de suporte!";
    }
    showMessage($ms);
}
/**********************************************************************************************/
$sql = "SELECT u.*, f.* FROM usuario u, funcionario f WHERE u.usuario_id = $_SESSION[usuario_id] AND f.funcionario_id = u.usuario_id ORDER BY f.nome";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=left class='text'><b>Dados do usuário:</b></td>";
echo "</tr>";
echo "</table>";

//FORM - SAVE DATA
echo "<table height=200 width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected' valign=top>";

echo "<form method=post id='frminfo' name='frminfo'>";

    echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span class='curhelp' title='Login utilizado para logar-se no sistema.' alt='Login utilizado para logar-se no sistema.'>";
        echo "Nome de usuário:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputTextobr value='$buffer[login]' readonly disabled>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span class='curhelp' title='Senha utilizada para logar-se no sistema.' alt='Senha utilizada para logar-se no sistema.'>";
        echo "Senha:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='' name='newpass' id='newpass'>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span class='curhelp' title='Repita a senha para confirmação.' alt='Repita a senha para confirmação.'>";
        echo "Repetir senha:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='' name='newpass2' id='newpass2'>";
    echo "</td>";
    echo "</tr>";


    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span>";
        echo "E-Mail:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='$buffer[email]' name='email' id='email'>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span>";
        echo "Telefone:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='$buffer[telefone]' name='telefone' id='telefone' maxlength=14 onkeypress=\"fone(this);\">";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span>";
        echo "Celular:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='$buffer[celular]' name='celular' id='celular' maxlength=14 onkeypress=\"fone(this);\">";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span>";
        echo "MSN:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='$buffer[msn]' name='msn' id='msn'>";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td align=left class='text' width='140'>";
        echo "<span>";
        echo "Skype:";
        echo "</span>";
    echo "</td>";
    echo "<td align=left class=text width='500'>";
        echo "<input type=text class=inputText value='$buffer[skype]' name='skype' id='skype'>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
    
echo "</td>";
echo "</tr>";
echo "</table>";

echo "&nbsp;<font size=1><i>- Caso não deseje a alteração da senha, deixe os campos <b>Senha</b> e <b>Repetir senha</b> em branco.</i></font>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSaveInfo' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";
?>
