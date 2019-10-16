<?PHP
/***************************************************************************************************/
// --> DEFINE / SESSION
/***************************************************************************************************/
    ini_set("session.gc_maxlifetime", "18000");
    session_start();
    define('module_path', 'modules/');
    define('image_path', 'images/');
    define('current_module_path', 'modules/'.$_GET[dir].'/');
/***************************************************************************************************/
// --> MAIN INCLUDES
/***************************************************************************************************/
    include("common/database/conn.php");
    include("common/functions.php");
    include("common/globals.php");
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
    $dir = anti_injection($_GET[dir]);
    $p   = anti_injection($_GET[p].".php");
    $menu_group_name = array('Medicina do Trabalho', 'Engenharia de Segurança', 'Recepção',
    'Comercial', 'Relatórios', 'Cadastros', 'Estatísticas', 'Administração', 'Financeiro',
    'Administração do Site', 'Edificação', 'Setorial', 'Pesquisas', 'Medida Preventiva');
    $group_col = '';
/***************************************************************************************************/
    if(empty($_SESSION[usuario_id]) || !isset($_SESSION[usuario_id])){
        unset($dir);
        $p = "login.php";
    }
    switch($_SESSION[grupo]){
        case 'administrador':
            $group_col = 'is_admin';
        break;
        case 'vendedor':
            $group_col = 'is_vendedor';
        break;
        case 'clinica':
            $group_col = 'is_clinica';
        break;
        case 'funcionario':
            $group_col = 'is_funcionario';
        break;
        case 'contador':
            $group_col = 'is_contador';
        break;
        case 'cliente':
            $group_col = 'is_cliente';
        break;
        case 'autonomo':
            $group_col = 'is_autonomo';
        break;
        default:
            $group_col = 'is_funcionario';
        break;
    }
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta http-equiv="Pragma" content="No-Cache"/>
    <meta http-equiv="Cache-Control" content="No-Cache,Must-Revalidate,No-Store"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta name="author" content="Celso Leonardo - SL4Y3R"/>
    <meta name="keywords" content="SESMT, Sesmt, sesmt, Medicina, medicina, Trabalho, trabalho, Higiene, higiene, Medicina Ocupacional, ASO, PPRA"/>
    <meta name="description" content="SESMT - Segurança do Trabalho e Higiene Ocupacional"/>
    <meta name="robots" content="all"/>
    <meta name="revisit" content="1 days"/>
    <meta name="distribution" content="Global"/>
    <meta name="MSSmartTagsPreventParsing" content="True"/>
    <title>SIST - Software Integrado de Segurança no Trabalho</title>

    <link href="layout/css/sist.css" rel="stylesheet" type="text/css">
    <link href="layout/css/custom.css" rel="stylesheet" type="text/css">
    <link href="layout/css/keyboard.css" rel="stylesheet" type="text/css">

    <script language="javascript" src="common/javascript/sist.js"></script>
    <script language="javascript" src="common/javascript/ajax.js"></script>
    <script language="javascript" src="common/javascript/keyboard.js"></script>
    <script language="javascript" src="common/javascript/calendar.js"></script>
<?PHP
/***************************************************************************************************/
// --> GOOGLE MAP - CLIENT DATA MODULE
/***************************************************************************************************/
if($_GET[dir] == "cad_cliente" && $_GET[p] == "detalhe_cliente" && $_GET[sp] == "mapa" && is_numeric($_GET[cod_cliente])){
    include('common/map_js_code.php');
}
/***************************************************************************************************/


if($_SESSION[usuario_id]){
    echo '<script language="javascript" src="common/javascript/chat.js"></script>';
}
?>
    <!--[if IE]>
    <style type="text/css">
    div.sysmsg {
        /*
        left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
        top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        */
        top: expression( ( 300 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
    }
    div.chatmsg {
        right: auto; bottom: auto;
        /*
        left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
        top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        */
        left: expression((0 - chatmsg.offsetWidth + (document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth) + (ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft)) + 'px');
        top: expression((0 - chatmsg.offsetHeight + (document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight) + (ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop)) + 'px');
    }
    div.centeredwindow {
        top: expression( ( 300 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
    }
    </style>
    <![endif]-->

</head>
<?PHP
if($_GET[dir] == "cad_cliente" && $_GET[p] == "detalhe_cliente" && $_GET[sp] == "mapa" && is_numeric($_GET[cod_cliente])){
    echo "<body onload=\"load();\" onunload=\"GUnload();\">";
}else{
    echo "<body>";
}
?>

<!-- /*********************************************************************************************/
// MENSAGEM DO SISTEMA
/**********************************************************************************************/ -->
<div id="sysmsg" class="sysmsg" style="display: none;">&nbsp;</div>
<div id="centeredwindow" class="centeredwindow" style="display: none;">&nbsp;</div>
<div id="infobar" class="infobar">&nbsp;Carregando...</div>
<div id="mainwork">
<div id="fadescreen" class="fadescreen" style="display: none;">&nbsp;</div>

<!-- /*********************************************************************************************/
// CHAT
/**********************************************************************************************/ -->
<?PHP
if($_SESSION[usuario_id]){
    $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$_SESSION[usuario_id]}";
    $result = pg_query($sql);
    $userdata = pg_fetch_array($result);
    if($userdata[sist_sci_chat]){
        echo '<div id="chatmsg" class="chatmsg" style="display: block;">';
    }else{
        echo '<div id="chatmsg" class="chatmsg" style="display: none;">';
    }
        echo '    <div id=chatcontent class="roundborderselected" style="height: 220px;border: 0px solid;position: relative;">';
        echo '        <div id=chathead class="roundborderselected" style="border: 0px solid; float: left; width: 100%;height:20px;">';
        echo '            <table width=100% height=20 cellspacing=0 cellpadding=0 border=0>';
        echo '            <tr>';
        echo '            <td width=60 height=20></td>';
        echo '            <td align=center><img src="images/sci-title.png" border=0></td>';
        echo "            <td width=60 class='text curhand' onclick=\"changeChatStatus('{$_SESSION[usuario_id]}');\"><img src='images/imclose-tip.png' border=0></td>";
        echo '            </tr>';
        echo '            </table>';
        echo '        </div>';
        echo '        <div id=mainchat class="roundborderselected" style="float: left; width: 70%;overflow:auto;height:200px;">';
        echo '            &nbsp;';
        echo '        </div>';
        echo '        <div id=userlist class="roundborderselected" style="float: right; width: 29%;overflow:auto;height:200px;">';
        echo '            &nbsp;';
        echo '        </div>';
        echo '        <div id=chatstatus class="roundborderselected" style="border: 0px solid; float: left; width: 100%;height:20px;">';
        echo '            &nbsp;';
        echo '        </div>';
        echo '    </div>';
?>
                <table width=100% border=0 align=center>
                <tr>
                    <td align=center>
                    <input type=text name=txt id=txt class="inputText" style="width: 100%;" onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { <?PHP echo "sendMsg(chating, '{$_SESSION[usuario_id]}', document.getElementById('txt').value);"?>;}">
                    </td>
                    <td width=100 align=center>
                    <input type=button class="btn" value="Enviar" id=btnSend name=btnSend onclick="<?PHP echo "sendMsg(chating, '{$_SESSION[usuario_id]}', document.getElementById('txt').value);"?>">
                    </td>
                </tr>
                </table>
<?PHP
        echo '</div>';
}
?>
<!-- TRY OLD SIST -->
<div style="position:absolute;float:left;"><img src="images/tryold.png" border=0 onclick="location.href='../tela_principal.php';"></div>

<table width=100% border=0 cellspacing=0 cellpaddin=0 height=78>
<td class="menutopbar" height=78 align=center><img src="images/title.png" border=0 alt='SESMT - Segurança do Trabalho e Higiene Ocupacional' title='SESMT - Segurança do Trabalho e Higiene Ocupacional'></td>
</table>
<?PHP
/***************************************************************************************************/
// --> LOGGED-IN BAR
/***************************************************************************************************/
if($_SESSION[usuario_id]){
/***************************************************************************************************/
//Set name of user
    $name = explode(" ", $userdata[nome]);
    if(strlen($name[1])> 2)
        $uname = $name[0]." ".$name[1];
    else
        $uname = $name[0]." ".$name[1]." ".$name[2];
/***************************************************************************************************/
//Set the last login date
    $sql = "SELECT * FROM log WHERE usuario_id = {$_SESSION[usuario_id]} AND detalhe = 'login' ORDER BY log_id DESC LIMIT 1 OFFSET 1";
    $r = pg_query($sql);
    $loginfo = pg_fetch_array($r);
    if(date("d/m/Y", strtotime($loginfo[data])) == date("d/m/Y")){
        $lastlogdate = "hoje";
    }elseif(date("d/m/Y", strtotime($loginfo[data])) == date("d/m/Y", mktime(0,0,0,date("m"), date("d")-1, date("Y")))){
        $lastlogdate = "ontem";
    }else{
        $lastlogdate = "dia ".date("d/m/Y", strtotime($loginfo[data]));
    }
/***************************************************************************************************/
//Check SCI messages
    $id = $_SESSION[usuario_id];
    $sql = "SELECT u.* FROM usuario u, funcionario f WHERE u.usuario_id != $id AND f.funcionario_id = u.usuario_id ORDER BY f.nome";
    $res = pg_query($sql);
    $ulist = pg_fetch_all($res);
    $user = array();
    $ret = "";
    $n = 0;
    for($x=0;$x<pg_num_rows($res);$x++){
        $sql = "SELECT count(m.*) as n FROM sist_sci_messages m, sist_sci_check_message c
               WHERE
               (
               m.msg_from = c.msg_from
               AND
               m.msg_to = {$id}
               AND
               m.msg_from = {$ulist[$x]['usuario_id']}
               AND
               m.time_sended > c.last_check_messages)";
        $rz = pg_query($sql);
        $nmen = pg_fetch_array($rz);
        $n += $nmen[n];
    }
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class=text width=80%>Bem vindo, <b>{$uname}</b> [{$_SESSION[grupo]}], seu último login foi $lastlogdate às ".date("H:i:s", strtotime($loginfo[data])).".</td>";
    echo "<td class=text align=right>";
    
    echo "<a href='?dir=cpanel&p=index'><img src='images/cpanel-txt.png' border=0 title='Painel de controle do usuário' alt='Painel de controle do usuário'></a>";
    
    if($n>0){
        echo "<a href=\"#\" onclick=\"changeChatStatus('{$_SESSION[usuario_id]}');\"><img src='images/sci-ico.png' border=0 title='Clique aqui para mostrar/esconder o SCI' alt='Clique aqui para mostrar/esconder o SCI'></a>";
    }else{
        echo "<a href=\"#\" onclick=\"changeChatStatus('{$_SESSION[usuario_id]}');\"><img src='images/sci-ico-nmes.png' border=0 title='Clique aqui para mostrar/esconder o SCI' alt='Clique aqui para mostrar/esconder o SCI'></a>";
    }
    echo "<a href='?p=login&logout=1'><img src='images/logout-txt.png' border=0 title='Clique aqui para sair' alt='Clique aqui para sair'></a>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    //echo "<div class=menul style=\"height: 3px;border: 1;\">&nbsp;</div>";
}

/***************************************************************************************************/
// --> SITE MAP
/***************************************************************************************************/
    $whereim = "<a href='index.php' class=map>Inicio</a>";
    $sql = "SELECT * FROM site_modules_info WHERE internal_name = '$dir'";
    $rsz = pg_query($sql);
    $din = pg_fetch_array($rsz);
    if(pg_num_rows($rsz)>0)
        $whereim .= " >> <a href='?dir=$din[internal_name]&p=index' class=map>$din[module_name]</a>";
        
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td class='text map roundborderselected'><b>Mapa do site:</b> $whereim</td>";
    echo "</tr>";
    echo "</table>";
/***************************************************************************************************/
// --> PAGE INCLUDES
/***************************************************************************************************/
    if(!empty($dir)){
        if(file_exists(module_path.$dir."/".$p) && $din[$group_col] && pg_num_rows($rsz)>0){
            echo "<center><img src='".current_module_path."logo.png' border=0></center>";
            include(module_path.$dir."/".$p);
        }else{
            if(!$din[$group_col])
                showmessage('Você não tem permissão para acessar este módulo.', 1);
            else
                showmessage('O módulo selecionado não está disponível.', 1);
            include('main.php');
        }
    }else{
        if(file_exists($p)){
            include($p);
        }else{
            include('main.php');
        }
    }
?>
<!--//Copyright  -->
</div>
<!-- MAIN WORK -->
<BR>
<div id="footer">
    <div class='menul'>
    <table width=100% border=0 cellspacing=0 cellpadding=0>
    <tr>
    <td class=text align=center><font size=1><i>SESMT - Segurança do Trabalho e Higiene Ocupacional<BR>© 2002 ~ 2010 - Todos os direitos reservados</i></font></td>
    </tr>
    </table>
    </div>
</div>

<?PHP
if($_SESSION[usuario_id]){
    echo "
    <script>
        getChatList('{$_SESSION[usuario_id]}');
        setInterval(\"getChatList('{$_SESSION[usuario_id]}')\", 10000);
    </script>";
    if($userdata[showinfobar])
        echo "<script>check_infobar('{$_SESSION[usuario_id]}', document.getElementById('infobar'));</script>";
}

//testa resolução do usuário e exibe um alerta caso seja menor que o mínimo recomendado.
if(!isset($_SESSION[isResOk])){
    echo "
    <script>
    if(screen.width < 900){
        showAlert('Sua resolução está abaixo da recomendada.<BR>A resolução mínima recomendada é <b>1024 x 768</b>!');
    }
    </script>";
    $_SESSION[isResOk] = 1;
}
?>
</body>
</html>
