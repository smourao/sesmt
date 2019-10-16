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

    <style type="text/css">
    #fixme {
        /* Netscape 4, IE 4.x-5.0/Win and other lesser browsers will use this */
        position: absolute; left: 20px; top: 10px;
    }
    body > div#fixme {
        /* used by Opera 5+, Netscape6+/Mozilla, Konqueror, Safari, OmniWeb 4.5+, iCab, ICEbrowser */
        position: fixed;
    }
    </style>
    <!--[if gte IE 5.5]>
    <![if lt IE 7]>
    <style type="text/css">
    div#fixme {
      /* IE5.5+/Win - this is more specific than the IE 5.0 version */
      left: expression( ( 20 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
      top: expression( ( 10 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
    }
    </style>
    <![endif]>
    <![endif]-->

</head>
<body>
<!-- /*********************************************************************************************/
// MENSAGEM DO SISTEMA
/**********************************************************************************************/ -->

    <div id='fixme'>&nbsp;Mensagem!</div>


<table width=100% border=0 cellspacing=0 cellpaddin=0 height=78>
<td class="menutopbar" height=78 align=center><img src="images/title.png" border=0 alt='SESMT - Segurança do Trabalho e Higiene Ocupacional' title='SESMT - Segurança do Trabalho e Higiene Ocupacional'></td>
</table>
<?PHP
/***************************************************************************************************/
// --> LOGGED-IN BAR
/***************************************************************************************************/
if($_SESSION[usuario_id]){
    $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$_SESSION[usuario_id]}";
    $result = pg_query($sql);
    $userdata = pg_fetch_array($result);
    $name = explode(" ", $userdata[nome]);
    if(strlen($name[1])> 2)
        $uname = $name[0]." ".$name[1];
    else
        $uname = $name[0]." ".$name[1]." ".$name[2];

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
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td class=text width=80%>Bem vindo, <b>{$uname}</b> [{$_SESSION[grupo]}], seu último login foi $lastlogdate às ".date("H:i:s", strtotime($loginfo[data])).".</td>";
    echo "<td class=text align=right><a href='?p=login&logout=1'><img src='images/logout-txt.png' border=0 heigh=8 title='Clique aqui para sair!' alt='Clique aqui para sair!'></a></td>";
    echo "</tr>";
    echo "</table>";
    //echo "<div class=menul style=\"height: 3px;border: 1;\">&nbsp;</div>";
}

/***************************************************************************************************/
// --> MAIN MENU BAR
/***************************************************************************************************/
//if(!empty($dir)){
    $whereim = "<a href='index.php' class=map>Inicio</a>";
    switch($dir){
        case "cgrt":
            $whereim .= " >> <a href='?dir=cgrt&p=index' class=map>Cadastro Geral de Relatórios Técnicos</a>";
        break;
    }
    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td class='text map roundborderselected'><b>Mapa do site:</b> $whereim</td>";
    echo "</tr>";
    echo "</table>";
    //echo "<div class=menul>&nbsp;</div>";
//}
/***************************************************************************************************/
// --> PAGE INCLUDES
/***************************************************************************************************/
    if(!empty($dir)){
        if(file_exists("pages/".$dir."/".$p)){
            include("pages/".$dir."/".$p);
        }else{
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
<!--//Copyright
<BR>
<div class=menul>&nbsp;</div>
<table width=100% border=0 cellspacing=0 cellpadding=0>
<tr>
<td class=text align=center><font size=1><i>Copyright © 2002-2010 SESMT - Segurança do Trabalho e Higiene Ocupacional</i></font></td>
</tr>
</table>
-->
</body>
</html>

