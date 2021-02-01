<center><img src='images/senhasadicionais.jpg' border=0></center>
<?PHP
/*****************************************************************************************************************/
// --> GET -> DELETAR SENHAS ADICIONAIS
/*****************************************************************************************************************/
if($_GET[said] && is_numeric($_GET[said])){
    $sql = "SELECT * FROM site_acesso_secundario WHERE id = ".(int)($_GET[said])." AND cod_cliente = $_SESSION[cod_cliente]";
    if(pg_num_rows(pg_query($sql))){
        $sql = "DELETE FROM site_acesso_secundario WHERE id = ".(int)($_GET[said]);
        if(pg_query($sql))
            $aderror = 5;
        else
            $aderror = 6;

        switch($aderror){
            case 5:
                $aderror = "Sua senha adicional para o e-mail <b>$admail</b> foi excluída com sucesso.";
            break;
            case 6:
                $aderror = "Houve um erro ao tentar excluir a senha adicional para o e-mail <b>$admail</b>. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
            break;
            default:
                $aderror = "";
            break;
        }
    }
}

/*****************************************************************************************************************/
// --> POST -> ADICIONAR SENHAS ADICIONAIS
/*****************************************************************************************************************/
if($_POST && $_POST[btnAdPass]){
    $admail  = anti_injection($_POST[admail]);
    $adpass  = anti_injection($_POST[adpass]);
    $adpass2 = anti_injection($_POST[adpass2]);
    $tipo_ac = (int)(anti_injection($_POST[tipo_acesso]));
    $aderror = 0;
    // -- TESTES --
    if(strlen($adpass) < 4 || $adpass != $adpass2){
        $aderror = 1;
    }
    $sql = "SELECT id FROM reg_pessoa_fisica   WHERE email='$admail'
            UNION
            SELECT id FROM reg_pessoa_juridica WHERE email='$admail'";
    if(pg_num_rows(pg_query($sql)))
        $aderror = 2;//e-mail já cadastrado
    $sql = "SELECT * FROM site_acesso_secundario WHERE email = '$admail'";
    if(pg_num_rows(pg_query($sql)))
        $aderror = 2;//e-mail já cadastrado
    if(!$aderror){
        //faz o cadastro
        $sql = "INSERT INTO site_acesso_secundario (email, senha, grupo, cod_cliente, data_criacao, data_alteracao,
        primary_id, tipo_acesso)
        VALUES
        ('$admail', '".md5($adpass)."', $_SESSION[tipo_usuario], $_SESSION[cod_cliente], '".date("Y/m/d")."',
        '".date("Y/m/d")."', 0, $tipo_ac)";
        if(pg_query($sql))
            $aderror = 3;
        else
            $aderror = 4;
    }
    switch($aderror){
       case 1:
           $aderror = "A senha digitada é inválida ou não confere com a confirmação de senha. Lembre-se, sua senha deve pelo menos 4 caracteres!";
       break;
       case 2:
           $aderror = "O e-mail informado já está em uso, por favor, utilize outro e-mail.";
       break;
       case 3:
           $aderror = "Sua senha adicional para o e-mail <b>$admail</b> foi cadastrada com sucesso.";
       break;
       case 4:
           $aderror = "Houve um erro ao tentar cadastrar a senha adicional para o e-mail <b>$admail</b>. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
       break;
       default:
           $aderror = "";
       break;
    }

}
/*****************************************************************************************************************/
echo "<div class='novidades_text'>";
    echo "<p align=justify>";
    echo "As senhas adicionais são extensões do cadastro principal, permitindo acesso controlado aos dados do cadastro
    principal, são permitidas duas senhas adicionais:";
    echo "<p align=justify>";
    echo "A <b>adicional interna</b> tem um acesso controlado, podendo o administrador liberar ou restringir permissões e é destinada a uso
    interno, já que há a possibilidade de alterações nos dados cadastrados.";
    echo "<p align=justify>";
    echo "A <b>adicional externa</b>, que é, por padrão, configurada apenas para exibição, não permitindo alterações de nenhuma natureza,
    é uma senha comunitária que pode ser liberada para terceiros. Esta senha não tem limite de acessos simultâneos,
    então, várias pessoas podem utilizá-la ao mesmo tempo.";
    echo "<p align=justify>";

    $sql = "SELECT * FROM site_acesso_secundario WHERE cod_cliente = $_SESSION[cod_cliente]";
    $res = pg_query($sql);
    $buf = pg_fetch_all($res);
    $accesslist = array();

    if(pg_num_rows($res)<2)
        echo "Você ainda pode criar ".(2-pg_num_rows($res))." senha(s).";
    echo "<BR>";
    if($aderror)
        echo "<p align=justify>".$aderror;
    
echo "</div>";
/*****************************************************************************************************************/
// --> SENHAS ADICIONAIS CADASTADAS
/*****************************************************************************************************************/
if(pg_num_rows($res)){
    echo "<img src='images/sub-senhas-adicionais-criadas.jpg' border=0>";
    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td class='bgTitle' align=center>Login</td>";
        echo "<td class='bgTitle' align=center width=130>Tipo</td>";
        echo "<td class='bgTitle' align=center width=100>Opções</td>";
    echo "</tr>";
    for($x=0;$x<pg_num_rows($res);$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
        echo "<tr>";
        echo "<td class='$bgclass'>{$buf[$x][email]}</td>";
        echo "<td class='$bgclass' align=center>";
        print $buf[$x][tipo_acesso] == 1 ? "Adicional interna" : "Adicional Externa";
        echo "</td>";
        echo "<td class='$bgclass' align=center>";

        if($buf[$x][tipo_acesso] == 1)
            echo "<a href='?do=adpassper&said={$buf[$x][id]}'><img src='images/ico-edit.png' border=0 alt='Editar permissões' title='Editar permissões'></a> ";

        echo "<a href='?do=adpass&said={$buf[$x][id]}' onclick=\"return confirm('Tem certeza que deseja excluir esta senha?','');\"><img src='images/ico-del.png' border=0 alt='Excluir' title='Excluir'></a>";
        echo "</td>";
        echo "</tr>";
        $accesslist[] = $buf[$x][tipo_acesso];
    }
    echo "</table>";
    
    echo "<BR>";
    echo "<b>Legenda:</b>";
    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
    echo "<td width=25><img src='images/ico-edit.png' border=0 alt='Editar permissões' title='Editar permissões'></td><td><font size=1>Editar permissões.</font></td>";
    echo "</tr><tr>";
    echo "<td width=25><img src='images/ico-del.png' border=0 alt='Excluir' title='Excluir'></td><td><font size=1>Excluir senha adicional.</font></td>";
    echo "</tr>";
    echo "</table>";
    echo "<p>";
}
/*****************************************************************************************************************/
// --> CRIAR NOVAS SENHAS ADICIONAIS -> CASO EXISTAM MENOS DE 2
/*****************************************************************************************************************/
if(pg_num_rows($res)<2){
    echo "<img src='images/sub-criar-senha-adicional.jpg' border=0>";
    echo "<form method=post name=frmAdPass id=frmAdPass onsubmit=\"if(!echeck(this.admail.value)){ this.admail.className = 'required_wrong'; return false;} if(this.adpass.value.length < 4 || this.adpass.value == '' || this.adpass2.value != this.adpass.value){ this.adpass.className = 'required_wrong'; return false;}\">";
    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td width=180>E-Mail:</td>";
        echo "<td><input type=text name='admail' id='admail' class='required' onkeyup=\"change_classname('admail', 'required');\"></td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td width=180>Tipo:</td>";
        echo "<td>";
        echo "<select name='tipo_acesso' id='tipo_acesso' class='required'>";
            if(!in_array(1, $accesslist))
                echo "<option value='1'>Adicional interna</option>";
            if(!in_array(2, $accesslist))
                echo "<option value='2'>Adicional externa</option>";
        echo "</select>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td width=180>Senha:</td>";
        echo "<td><input type=password name='adpass' id='adpass' class='required' onkeyup=\"change_classname('adpass', 'required');\"></td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td width=180>Confirmar senha:</td>";
        echo "<td><input type=password name='adpass2' id='adpass2' class='required' onkeyup=\"change_classname('adpass2', 'required');\">&nbsp;<img src='images/ico-help.png' border=0 align=top style=\"cursor: help;\" alt='Redigite sua senha.' title='Redigite sua senha.'></td>";
    echo "</tr>";
    echo "</table>";
    echo "<BR>";
    echo "<center><input type=submit name=btnAdPass id=btnAdPass value='Criar nova senha'></center>";
    echo "</form>";
}

?>
