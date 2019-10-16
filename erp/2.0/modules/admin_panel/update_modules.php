<?PHP
if($_POST[btnSave]){
    if($_POST[is_admin] == 'on')
        $_POST[is_admin] = 1;
    if($_POST[is_vendedor] == 'on')
        $_POST[is_vendedor] = 1;
    if($_POST[is_clinica] == 'on')
        $_POST[is_clinica] = 1;
    if($_POST[is_funcionario] == 'on')
        $_POST[is_funcionario] = 1;
    if($_POST[is_contador] == 'on')
        $_POST[is_contador] = 1;
    if($_POST[is_cliente] == 'on')
        $_POST[is_cliente] = 1;
    if($_POST[is_autonomo] == 'on')
        $_POST[is_autonomo] = 1;

    $sql = "UPDATE site_modules_info SET module_name = '{$_POST[module_name]}', enabled = '{$_POST[status]}', menu_group = '{$_POST[menu_group]}',
    is_admin = '".((int)($_POST[is_admin]))."', is_vendedor = '".((int)($_POST[is_vendedor]))."',
    is_clinica = '".((int)($_POST[is_clinica]))."', is_funcionario = '".((int)($_POST[is_funcionario]))."',
    is_contador = '".((int)($_POST[is_contador]))."', is_cliente = '".((int)($_POST[is_cliente]))."',
    is_autonomo = '".((int)($_POST[is_autonomo]))."'
    WHERE
    id = $_POST[mid]";
    if(pg_query($sql)){
        showmessage('Módulo alterado com sucesso!');
    }else{
        showmessage('Houve um erro ao alterar este módulo!', 1);
    }
}


$sql = "SELECT * FROM site_modules_info WHERE id = '$_GET[mid]'";
$res = pg_query($sql);
$mod = pg_fetch_array($res);
echo "<form method='POST' name=frmEditModule>";
echo "<input type=hidden name=mid value='$_GET[mid]'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=justify class='text roundborder'>";
            echo "<table width=100% border=0>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'><b>Edição de Módulo</b></td>";
            echo "</tr>";
            echo "</table>";
            echo "<table width=100% border=0>";
            echo "<tr class='text roundbordermix'>";
            echo "<td class='text' width=150><b>Nome:</b></td><td class='text'><input type=text class=inputText name=module_name id=module_name value='$mod[module_name]' size=50></td>";
            echo "</tr><tr class='text roundbordermix'>";
            echo "<td class='text' width=150><b>Nome interno:</b></td><td class='text'>".$mod[internal_name]."</td>";
            echo "</tr><tr class='text roundbordermix'>";
            echo "<td class='text' width=150><b>Status:</b></td><td class='text'>";
            echo "<select name=status id=status>";
                echo "<option value=1 "; print $mod[enabled] ? " selected " : ""; echo ">Ativo</option>";
                echo "<option value=0 "; print $mod[enabled] ? "" : " selected "; echo ">Inativo</option>";
            echo "</select>";
            echo "</td>";
            echo "</tr><tr class='text roundbordermix'>";
            echo "<td class='text' width=150><b>Grupo: </b></td><td class='text'>";
            echo "<select name=menu_group>";
            for($x=0;$x< count($menu_group_name);$x++){
                echo "<option value=$x";
                print $mod[menu_group] == $x ? " selected " : "";
                echo ">{$menu_group_name[$x]}</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "</tr><tr class='text roundbordermix'>";
            echo "<td class='text' width=150><b>Completo:</b></td><td class='text'>"; print $mod[is_finished] ? "Sim" : "Não"; echo "</td>";
            echo "</tr><tr class='text roundbordermix'>";
            echo "<td class='text' width=150><b>Permissão:</b></td>";
            echo "<td class='text'>";
                echo "<table border=0 width=100%>";
                echo "<tr>";
                    echo "<td align=center class='text'><b>Admin</b></td>";
                    echo "<td align=center class='text'><b>Vendedor</b></td>";
                    echo "<td align=center class='text'><b>Clínica</b></td>";
                    echo "<td align=center class='text'><b>Funcionário</b></td>";
                    echo "<td align=center class='text'><b>Contador</b></td>";
                    echo "<td align=center class='text'><b>Cliente</b></td>";
                    echo "<td align=center class='text'><b>Autônomo</b></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td align=center class='text'><input type=checkbox name=is_admin ";       print $mod[is_admin] ? " checked " : ""; echo "></td>";
                    echo "<td align=center class='text'><input type=checkbox name=is_vendedor ";   print $mod[is_vendedor] ? " checked " : ""; echo "></td>";
                    echo "<td align=center class='text'><input type=checkbox name=is_clinica ";     print $mod[is_clinica] ? " checked " : ""; echo "></td>";
                    echo "<td align=center class='text'><input type=checkbox name=is_funcionario "; print $mod[is_funcionario] ? " checked " : ""; echo "></td>";
                    echo "<td align=center class='text'><input type=checkbox name=is_contador ";    print $mod[is_contador] ? " checked " : ""; echo "></td>";
                    echo "<td align=center class='text'><input type=checkbox name=is_cliente ";     print $mod[is_cliente] ? " checked " : ""; echo "></td>";
                    echo "<td align=center class='text'><input type=checkbox name=is_autonomo ";    print $mod[is_autonomo] ? " checked " : ""; echo "></td>";
                echo "</tr>";
                echo "</table>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<table width=100% border=0>";
            echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
                echo "<input type='submit' class='btn' name='btnSave' value='Salvar'>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
echo "</form>";
?>
