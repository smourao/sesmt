<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Segurança do Trabalho e Medicina Ocupacional::</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc_pc.js"></script>
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

<?PHP
if($_GET['seg_id']!="4"){
?>
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
}
//include "../sessao.php";
//include "../config/connect.php";
//include "../config/config.php";
//include "../config/funcoes.php";

include "config/connect.php";

//print_r($_POST);

if($_GET['seg_id']=="4"){
    echo "<center>Localizar Produtos</center>";
    echo "<form method='POST'>";
    echo "<br>";
    echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
    echo "<tr>";
    echo "<td align=center><b><font size=1>Palavra chave:</font></b></td>";
    echo "<td align=left><input type=text name=word id=word value='{$_POST['word']}'></b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=center><b><font size=1>Categoria:</font></b></td>";
    echo "<td align=left>
    <select name=categoria id=categoria onchange=\"legendas_de_placas();\">
    <option></option>
    <option "; print $_POST['categoria'] == "Placas Segurança"? "selected":""; echo">Placas Segurança</option>
    <option "; print $_POST['categoria'] == "Placas Reservado"? "selected":""; echo">Placas Reservado</option>
    <option "; print $_POST['categoria'] == "Placas Radiação"? "selected":""; echo">Placas Radiação</option>
    <option "; print $_POST['categoria'] == "Placas Proteja-se"? "selected":""; echo">Placas Proteja-se</option>
    <option "; print $_POST['categoria'] == "Placas Perigo"? "selected":""; echo">Placas Perigo</option>
    <option "; print $_POST['categoria'] == "Placas Pense"? "selected":""; echo">Placas Pense</option>
    <option "; print $_POST['categoria'] == "Placas Lembre-se"? "selected":""; echo">Placas Lembre-se</option>
    <option "; print $_POST['categoria'] == "Placas Incêndio"? "selected":""; echo">Placas Incêndio</option>
    <option "; print $_POST['categoria'] == "Placas Importante"? "selected":""; echo">Placas Importante</option>
    <option "; print $_POST['categoria'] == "Placas Educação"? "selected":""; echo">Placas Educação</option>
    <option "; print $_POST['categoria'] == "Placas Economize"? "selected":""; echo">Placas Economize</option>
    <option "; print $_POST['categoria'] == "Placas Cuidado"? "selected":""; echo">Placas Cuidado</option>
    <option "; print $_POST['categoria'] == "Placas Aviso"? "selected":""; echo">Placas Aviso</option>
    <option "; print $_POST['categoria'] == "Placas Atenção"? "selected":""; echo">Placas Atenção</option>
    <option "; print $_POST['categoria'] == "Placa de Elevador"? "selected":""; echo">Placa de Elevador</option>
    </select>
    </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center><b><font size=1>Material:</font></b></td>";
    echo "<td align=left>
    <select name=material>
    <option></option>
    <option "; print $_POST['material'] == "PVC"? "selected":""; echo">PVC</option>
    <option "; print $_POST['material'] == "Poliestireno"? "selected":""; echo">Poliestireno</option>
    <option "; print $_POST['material'] == "Alumínio"? "selected":""; echo">Alumínio</option>
    <option "; print $_POST['material'] == "Acrílico"? "selected":""; echo">Acrílico</option>
    <option "; print $_POST['material'] == "Vinil"? "selected":""; echo">Vinil</option>
    </select>
    </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center><b><font size=1>Espessura:</font></b></td>";
    echo "<td align=left>
    <select name=espessura>
    <option></option>
    <option "; print $_POST['espessura'] == "1mm"? "selected":""; echo">1mm</option>
    <option "; print $_POST['espessura'] == "2mm"? "selected":""; echo">2mm</option>
    <option "; print $_POST['espessura'] == "3mm"? "selected":""; echo">3mm</option>
    <option "; print $_POST['espessura'] == "0,50mm"? "selected":""; echo">0,50mm</option>
    </select>
    </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center><b><font size=1>Acabamento:</font></b></td>";
    echo "<td align=left>
    <select name=acabamento>
    <option></option>
    <option "; print $_POST['acabamento'] == "Brilhante"? "selected":""; echo">Brilhante</option>
    <option "; print $_POST['acabamento'] == "Fosco"? "selected":""; echo">Fosco</option>
    <option "; print $_POST['acabamento'] == "Fosforescente"? "selected":""; echo">Fosforescente</option>
    <option "; print $_POST['acabamento'] == "Fluorescente"? "selected":""; echo">Fluorescente</option>
    </select>
    </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center><b><font size=1>Tamanho:</font></b></td>";
    echo "<td align=left>
    <select name=tamanho>
    <option></option>
    <option "; print $_POST['tamanho'] == "0.12x0.08"? "selected":""; echo">0.12x0.08</option>
    <option "; print $_POST['tamanho'] == "0.18x0.18"? "selected":""; echo">0.18x0.18</option>
    <option "; print $_POST['tamanho'] == "0.22x0.17"? "selected":""; echo">0.22x0.17</option>
    <option "; print $_POST['tamanho'] == "0.37x0.27"? "selected":""; echo">0.37x0.27</option>
    <option "; print $_POST['tamanho'] == "0.47x0.37"? "selected":""; echo">0.47x0.37</option>
    <option "; print $_POST['tamanho'] == "0.67x0.47"? "selected":""; echo">0.67x0.47</option>
    </select>
    </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center><b><font size=1>Legenda:</font></b></td>";
    echo "<td align=left>
    <select name=leg id=leg>
    ";
    if($_POST['leg']){
       echo "<option value='{$_POST['leg']}'>{$_POST['leg']}</option>";
    }
    echo "
    </select>
    </td>";
    echo "</tr>";


    echo "</table>";

    echo "<center><input type=submit value=Procurar></center>";

    echo "</form>";

    if($_POST){

    if($_POST[word]){
       if(is_numeric($_POST['word'])){
          $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND cod_prod ='{$_POST['word']}'";
       }else{
          $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
          LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['word'])."%".strtolower($_POST['categoria'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'";
       }
    }else{
        $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
        desc_detalhada_prod LIKE '%{$_POST['categoria']}%{$_POST['material']}%{$_POST['espessura']}%{$_POST['tamanho']}%{$_POST['acabamento']}%'";
    }
        $result = pg_query($sql);
        $buffer = pg_fetch_all($result);

            echo "<table border=1 cellspacing=0 cellpadding=0 width=100%>";
            echo "<tr>";
            echo "<td align=center><b><font size=1>Adicionar</font></b></td>";
            echo "<td align=center><b><font size=1>Desc.</font></b></td>";
           echo "</tr>";
              for($x=0;$x<pg_num_rows($result);$x++){
				 if($buffer[$x]['g_max'] != "" && $buffer[$x]['g_min'] !=""){
                     $grupo = "<BR>[<b>Grupo:</b> {$buffer[$x]['g_min']} à {$buffer[$x]['g_max']}.]";
				 }else{
					 $grupo = "";
				 }
                 echo "<tr>";
                 echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade / Número de participantes:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
                 echo "<td align=left><font size=2>{$buffer[$x]['desc_detalhada_prod']} {$grupo}</font></td>";
                 echo "</tr>";
              }
           echo "</table>";

    }

}

if($_GET['seg_id']!="" && !$_POST && $_GET['seg_id']!="4"){
    //echo"<script>window.parent.document.getElementById(\"segmento\").checked = false;</script>";
    $sql = "SELECT DISTINCT * FROM produto WHERE cod_atividade = {$_GET['seg_id']} ORDER BY desc_detalhada_prod";
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
        if($buffer[$x]['g_max'] != "" && $buffer[$x]['g_min'] !=""){
                     $grupo = "<BR>[<b>Grupo:</b> {$buffer[$x]['g_min']} à {$buffer[$x]['g_max']}.]";
				 }else{
					 $grupo = "";
				 }
            echo "<tr>";
               //echo "<td><font size=1>{$buffer[$x]['cod_prod']}</font></td>";
               //echo "<td onclick=\"add_orcamento_produto(prompt('Quantidade:', '1'), {$buffer[$x]['cod_prod']});\"><font size=1>{$buffer[$x]['cod_prod']}</font></td>";
               echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade / Número de participantes:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
               echo "<td align=left><font size=2>{$buffer[$x]['desc_detalhada_prod']} {$grupo}</font></td>";
               //echo "<td><font size=1>R$".number_format($buffer[$x]['preco_prod'],2,',','.')."</font></td>";
            echo "</tr>";
        }
    echo "</table>";
}

if($_POST && $_POST['search']!= "" && $_GET['seg_id']!="4"){
    echo"<script>
    //alert(window.parent.document.segmentos.segmento.length);
    for(var x = 0;x<window.parent.document.segmentos.segmento.length;x++){
        window.parent.document.segmentos.segmento[x].checked = false;
    }
    //window.parent.document.getElementById(\"segmento\").checked = false;
    </script>";


    if(is_numeric($_POST['search'])){
        $sql = "SELECT DISTINCT * FROM produto WHERE cod_prod = {$_POST['search']}";
    }else{
        $sql = "SELECT DISTINCT * FROM produto WHERE UPPER(desc_detalhada_prod) like '%".strtoupper($_POST['search'])."%' ORDER BY desc_detalhada_prod";
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
        if($buffer[$x]['g_max'] != "" && $buffer[$x]['g_min'] !=""){
				     $grupo = "<br>[<b>Grupo:</b> {$buffer[$x]['g_min']} à {$buffer[$x]['g_max']}.]";
				 }else{
					 $grupo = "";
				 }
            echo "<tr>";
               echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade:', '1'), {$buffer[$x]['cod_prod']});\"><font size=2><b>Adicionar</b></font></td>";
               echo "<td align=left><font size=2>{$buffer[$x]['desc_detalhada_prod']} {$grupo}</font></td>";
               //echo "<td><font size=1>R$".number_format($buffer[$x]['preco_prod'],2,',','.')."</font></td>";
            echo "</tr>";
        }
    echo "</table>";
}

//print_r($buffer);
?>
