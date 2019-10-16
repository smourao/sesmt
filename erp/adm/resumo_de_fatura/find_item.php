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
<center>Localizar Produtos</center>
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

if($_GET['seg_id']!="" && !$_POST){
    //echo"<script>window.parent.document.getElementById(\"segmento\").checked = false;</script>";
    $sql = "SELECT DISTINCT desc_resumida_prod, cod_prod, desc_detalhada_prod FROM produto WHERE cod_atividade = {$_GET['seg_id']} ORDER BY desc_detalhada_prod";
    $result = pg_query( $sql);
    $buffer = pg_fetch_all($result);

    echo "<center><font size=1>".pg_num_rows($result)." produtos encontrados</font></center>";
    echo "<br>";
    echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
    echo "<tr>";
    //echo "<td align=center><b><font size=1>Cod.</font></b></td>":
    echo "<td align=center><b><font size=1>Adicionar</font></b></td>";
    echo "<td align=center><b><font size=1>Desc.</font></b></td>";
    //echo "<td align=center><b><font size=1>Valor</font></b></td>";
    echo "</tr>";
        for($x=0;$x<pg_num_rows($result);$x++){
            echo "<tr>";
               //echo "<td><font size=1>{$buffer[$x]['cod_prod']}</font></td>";
               //echo "<td onclick=\"add_orcamento_produto(prompt('Quantidade:', '1'), {$buffer[$x]['cod_prod']});\"><font size=1>{$buffer[$x]['cod_prod']}</font></td>";
               echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade / Número de participantes:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
               echo "<td align=left><font size=2>{$buffer[$x]['desc_detalhada_prod']}</font></td>";
               //echo "<td><font size=1>R$".number_format($buffer[$x]['preco_prod'],2,',','.')."</font></td>";
            echo "</tr>";
        }
    echo "</table>";
}

if($_POST && $_POST['search']!= ""){
    echo"<script>
    //alert(window.parent.document.segmentos.segmento.length);
    for(var x = 0;x<window.parent.document.segmentos.segmento.length;x++){
        window.parent.document.segmentos.segmento[x].checked = false;
    }
    //window.parent.document.getElementById(\"segmento\").checked = false;
    </script>";
    
    
    if(is_numeric($_POST['search'])){
        $sql = "SELECT DISTINCT desc_resumida_prod, cod_prod, desc_detalhada_prod FROM produto WHERE cod_prod = {$_POST['search']}";
    }else{
        $sql = "SELECT DISTINCT desc_resumida_prod, cod_prod, desc_detalhada_prod FROM produto WHERE UPPER(desc_detalhada_prod) like '%".strtoupper($_POST['search'])."%' ORDER BY desc_detalhada_prod";
    }

    $result = pg_query( $sql);
    $buffer = pg_fetch_all($result);

    echo "<center><font size=1>".pg_num_rows($result)." produtos encontrados</font></center>";
    echo "<br>";
    echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
    echo "<tr>";
    echo "<td align=center><b><font size=1>Adicionar</font></b></td>
      <td align=center><b><font size=1>Desc.</font></b></td>";
   // echo "<td align=center><b><font size=1>Valor</font></b></td>";
    echo "</tr>";
        for($x=0;$x<pg_num_rows($result);$x++){
            echo "<tr>";
               echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
               echo "<td align=left><font size=2>{$buffer[$x]['desc_detalhada_prod']}</font></td>";
               //echo "<td><font size=1>R$".number_format($buffer[$x]['preco_prod'],2,',','.')."</font></td>";
            echo "</tr>";
        }
    echo "</table>";
}

//print_r($buffer);
?>
