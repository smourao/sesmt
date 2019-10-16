<?PHP
ini_set("session.gc_maxlifetime", "18000");
session_start();
/***************************************************************************************************/
// --> MAIN INCLUDES
/***************************************************************************************************/
    include("common/database/conn.php");
    include("common/functions.php");

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
    $dir = anti_injection($_GET[dir]);
    $p   = anti_injection($_GET[p].".php");
    if(empty($_SESSION[usuario_id]) || !isset($_SESSION[usuario_id])){
        unset($dir);
        $p = "login.php";
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta http-equiv="Pragma" content="No-Cache"/>
    <meta http-equiv="Cache-Control" content="No-Cache,Must-Revalidate,No-Store"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta name="author" content="SL4Y3R"/>
    <meta name="keywords" content="SESMT, Sesmt, sesmt, Medicina, medicina, Trabalho, trabalho, Higiene, higiene, Medicina Ocupacional"/>
    <meta name="description" content="SESMT - Segurança do Trabalho e Higiene Ocupacional"/>
    <meta name="robots" content="all"/>
    <meta name="revisit" content="1 days"/>
    <meta name="distribution" content="Global"/>
    <meta name="MSSmartTagsPreventParsing" content="True"/>
    <title>SIST - Software Integrado de Segurança no Trabalho</title>

    <link href="layout/css/sist.css" rel="stylesheet" type="text/css">
    <link href="layout/css/custom.css" rel="stylesheet" type="text/css">
    <link href="layout/css/keyboard.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="layout/menu_themes/classic/classic.css" />

    <script language="javascript" src="common/javascript/sist.js"></script>
    <script language="javascript" src="common/javascript/ajax.js"></script>
    <script language="javascript" src="common/javascript/keyboard.js"></script>
    <script language="javascript" src="common/javascript/chat.js"></script>
    <!--[if IE]>
    <style type="text/css">
    div.sysmsg {
        /*
        left: expression( ( 0 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
        top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        */
        top: expression( ( 300 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
    }
    </style>
    <![endif]-->

</head>
<body>

<div id=content style="height: 220px;border: 0px solid;position: relative;">
    <div id=mainchat style="border: 1px solid; float: left; width: 70%;overflow:auto;height:200px;">
        &nbsp;
    </div>
    <div id=userlist style="border: 1px solid; float: right; width: 29%;overflow:auto;height:200px;">
        &nbsp;
    </div>
    <div id=chatstatus style="border: 0px solid; float: left; width: 100%;height:20px;">
        &nbsp;
    </div>
</div>
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
    echo "
    <script>
    getChatList('{$_SESSION[usuario_id]}');
    setInterval(\"getChatList('{$_SESSION[usuario_id]}')\", 10000);
    </script>";
?>
</body>
</html>
