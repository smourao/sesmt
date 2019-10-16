<?PHP
/***************************************************************************************************/
// --> GET MODULES
/***************************************************************************************************/
if($_GET[action] == 'update_modules'){
    $d = getcwd();
    $d .= '/'.module_path;
    $handler = opendir($d);
    $modules  = array();
    $files    = array();
    $items   = array();

    //Get the list of files/folders(modules)
    while($tmp = readdir($handler)){
        $items[] = $tmp;
    }

    //each kind of item in a separated var
    foreach($items as $i){
        if($i != '.' && $i != '..'){
            if(!is_file($i)){
                $modules[] = $i;
            }else{
                $files[] = $i;
            }
        }
    }
    sort($modules);
    $added_modules = array();
    for($x=0;$x<count($modules);$x++){
        $sql = "SELECT * FROM site_modules_info WHERE internal_name = '$modules[$x]'";
        $res = pg_query($sql);
        if(pg_num_rows($res)>0){
            //nothing todo!
        }else{
            $sql = "INSERT INTO site_modules_info
            (internal_name, module_name, enabled) values ('$modules[$x]', '$modules[$x]', 0)";
            pg_query($sql);
            $added_modules[] = $modules[$x];
        }
    }
    
    if(count($added_modules)>0){
        showmessage(count($added_modules).' novos módulos foram instalados!');
    }else{
        showmessage('Nenhum novo módulo instalado!');
    }
}elseif($_GET[action] == 'change_status'){
    $_GET[mid] = anti_injection($_GET[mid]);
    if(is_numeric($_GET[mid])){
        $sql = "SELECT * FROM site_modules_info WHERE id = $_GET[mid]";
        $res = pg_query($sql);
        $buffer = pg_fetch_array($res);
        if($buffer[enabled]){
            $sql = "UPDATE site_modules_info SET enabled = 0 WHERE id = $_GET[mid]";
            if(pg_query($sql)){
                showmessage('Status do módulo <b>'.$buffer[module_name].'</b> alterado para Inativo!');
            }else{
                showmessage('Houve um erro ao tentar atualizar o status do módulo <b>'.$buffer[module_name].'</b>.', 1);
            }
        }else{
            $sql = "UPDATE site_modules_info SET enabled = 1 WHERE id = $_GET[mid]";
            if(pg_query($sql)){
                showmessage('Status do módulo <b>'.$buffer[module_name].'</b> alterado para Ativo!');
            }else{
                showmessage('Houve um erro ao tentar atualizar o status do módulo <b>'.$buffer[module_name].'</b>.', 1);
            }
        }
    }
    //echo redirectme("?dir=admin_panel&p=index&sp=mod_admin");
}elseif($_GET[action] == 'del_mod'){
    $_GET[mid] = anti_injection($_GET[mid]);
    if(is_numeric($_GET[mid])){
        $sql = "DELETE FROM site_modules_info WHERE id = $_GET[mid]";
        if(pg_query($sql)){
            showmessage('Módulo removido da database!');
        }else{
            showmessage('Erro ao remover módulo da database!', 1);
        }
    }
}

if($_GET[action] !== "edit_module"){
    $d = getcwd();
    $d .= '/'.module_path;
    $handler = opendir($d);
    $modules  = array();
    $files    = array();
    $items   = array();

    //Get the list of files/folders(modules)
    while($tmp = readdir($handler)){
        $items[] = $tmp;
    }

    //each kind of item in a separated var
    foreach($items as $i){
        if($i != '.' && $i != '..'){
            if(!is_file($i)){
                $modules[] = $i;
            }else{
                $files[] = $i;
            }
        }
    }
    sort($modules);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class='text'>";
    echo "<b>Módulos:</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";


    for($x=0;$x<count($modules);$x++){
        $sql = "SELECT * FROM site_modules_info WHERE internal_name = '$modules[$x]'";
        $res = pg_query($sql);
        $mod = pg_fetch_array($res);
        if($mod[dev_by]){
            $sql = "SELECT * FROM funcionario WHERE funcionario_id = $mod[dev_by]";
            $func = pg_fetch_array(pg_query($sql));
        }
        if(pg_num_rows($res)>0){
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=justify class='text roundborder'>";
                echo "<table width=100% border=0>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'><b>".$mod[module_name]."</b></td>";
                echo "</tr>";
                echo "</table>";
                echo "<table width=100% border=0>";
                echo "<tr>";
                echo "<td class='text' width=150><b>Nome interno:</b></td><td class='text'>".$mod[internal_name]."</td>";
                echo "</tr><tr>";
                echo "<td class='text' width=150><b>Status:</b></td><td class='text'>"; print $mod[enabled] ? "<span class='text roundborderselected'>Ativo</span>" : "<span class='text roundborderselectedred'>Inativo</span>"; echo "</td>";
                echo "</tr><tr>";
                echo "<td class='text' width=150><b>Grupo: </b></td><td class='text'>".$menu_group_name[$mod[menu_group]]."</td>";
                echo "</tr><tr>";
                echo "<td class='text' width=150><b>Completo:</b></td><td class='text'>"; print $mod[is_finished] ? "<span class='text roundborderselected'>Sim</span>" : "<span class='text roundborderselectedred'>Não</span>"; echo "</td>";
                echo "</tr><tr>";
                echo "<td class='text' width=150><b>Código por:</b></td><td class='text'>";
                print $func[nome] ? $func[nome] : ""; echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<table width=100% border=0>";
                echo "<tr>";
                echo "<td align=center class='text roundbordermix'>";
                    echo "<input type='button' class='btn' name='btnAtivar' value='"; print $mod[enabled] ? "Desativar" : "Ativar"; echo "' onclick=\"location.href='?dir=admin_panel&p=index&sp=mod_admin&action=change_status&mid=$mod[id]';\">";
                    echo "&nbsp;";
                    echo "<input type='button' class='btn' name='btnEditar' value='Editar' onclick=\"location.href='?dir=admin_panel&p=index&sp=mod_admin&action=edit_module&mid=$mod[id]';\">";
                    echo "&nbsp;";
                    echo "<input type='button' class='btn' name='btnExcluir' value='Excluir' onclick=\"if(confirm('Tem certeza que deseja remover este módulo da database?','')){location.href='?dir=admin_panel&p=index&sp=mod_admin&action=del_mod&mid=$mod[id]';}\">";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            echo "<td>";
            echo "</tr>";
            echo "</table>";
            echo "<BR>";
        }
    }
}else{
    include(current_module_path."edit_module.php");
}

?>
