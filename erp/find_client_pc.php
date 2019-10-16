<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Segurança do Trabalho e Medicina Ocupacional::</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
<script language="javascript" src="scripts.js"></script>
<style type="text/css" title="mystyles" media="all">
<!--
loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

loading_done{
position: relative;
display: none;
}

-->
</style>
</head>
<body background="#006633" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<center>Localizar Cliente</center>
<br>
<form method="POST">
<center>
<input type=text name=search id=search class=text size=12 value=<?PHP echo $_POST['search'];?>>
<input type=submit value="Procurar" class=button>
</center>
</form>

<script>
//window.parent.document.getElementById("teste").innerHTML = "Fudeu";
//window.parent.document.getElementById("ECI").checked = false;
</script>

<?PHP
//include "../sessao.php";
//include "../config/connect.php";
//include "../config/config.php";
//include "../config/funcoes.php";

include "config/connect.php";

//print_r($_POST);
if($_POST && $_POST['search']!= ""){
    echo"<script>
    //alert(window.parent.document.segmentos.segmento.length);
    for(var x = 0;x<window.parent.document.segmentos.segmento.length;x++){
        window.parent.document.segmentos.segmento[x].checked = false;
    }
    //window.parent.document.getElementById(\"segmento\").checked = false;
    </script>";
    
    
    if(is_numeric($_POST['search'])){
        $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$_POST['search']}";
    }else{
        $sql = "SELECT * FROM cliente_pc WHERE UPPER(razao_social) like '%".strtoupper($_POST['search'])."%'";
    }
    $result = pg_query( $sql);
    $buffer = pg_fetch_all($result);

    echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
    echo "<tr>";
    echo "<td align=center><b><font size=1>Selecionar</font></b></td>
      <td align=center><b><font size=1>Razao Social</font></b></td>";
    echo "</tr>";
        for($x=0;$x<pg_num_rows($result);$x++){
            if(!empty($buffer[$x][cnpj_contratante])){
                echo "<tr>";
                   echo "<td align=center style=\"cursor:pointer;\" onclick=\"window.opener.location.replace('cadastro_cliente_pc_aditivo.php?cliente_id={$buffer[$x]['cliente_id']}&filial_id={$buffer[$x]['filial_id']}&id={$buffer[$x]['id']}');\"><font size=1>Selecionar</font></td>";
                   echo "<td align=left><font size=1>{$buffer[$x]['razao_social']}</font></td>";
                echo "</tr>";
            }else{
                echo "<tr>";
                   echo "<td align=center style=\"cursor:pointer;\" onclick=\"window.opener.location.replace('cadastro_cliente_pc.php?cliente_id={$buffer[$x]['cliente_id']}&filial_id={$buffer[$x]['filial_id']}&id={$buffer[$x]['id']}');\"><font size=1>Selecionar</font></td>";
                   echo "<td align=left><font size=1>{$buffer[$x]['razao_social']}</font></td>";
                echo "</tr>";
            }
        }
    echo "</table>";
}
?>
