<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Selecione uma opção</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
                        echo "<select name='admin_option' id='admin_option' size=20 style=\"width: 240px;\" onclick=\"admin_panel_option(this.options[this.selectedIndex].value);\">";
                            echo "<option value='mod_admin'";
                            print $_GET[sp] == "mod_admin" ? ' selected ' : '';
                            echo ">Administração de módulos</option>";
                            
                            echo "<option value='mod_admin&action=update_modules'";
                            print $_GET[sp] == "mod_admin&action=update_modules" ? ' selected ' : '';
                            echo ">Atualizar lista de módulos</option>";
                        echo "</select>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
            switch($_GET[sp]){
                case 'mod_admin':
                    echo "<b>Administração de Módulos</b>";
                break;
                default:
                echo "<b>&nbsp;</b>";
                break;
            }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        if(file_exists(current_module_path.$_GET[sp].'.php'))
            include(current_module_path.$_GET[sp].'.php');

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
