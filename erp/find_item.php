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
    <option "; print $_POST['categoria'] == "Placas Segurança"? "selected":""; echo" value='Placas Segurança'>Placas Segurança</option>
    <option "; print $_POST['categoria'] == "Placas Reservado"? "selected":""; echo" value='Placas Reservado'>Placas Reservado</option>
    <option "; print $_POST['categoria'] == "Placas Radiação"? "selected":""; echo" value='Placas Radiação'>Placas Radiação</option>
    <option "; print $_POST['categoria'] == "Placas Proteja-se"? "selected":""; echo" value='Placas Proteja-se'>Placas Proteja-se</option>
    <option "; print $_POST['categoria'] == "Placas Perigo"? "selected":""; echo" value='Placas Perigo'>Placas Perigo</option>
    <option "; print $_POST['categoria'] == "Placas Pense"? "selected":""; echo" value='Placas Pense'>Placas Pense</option>
    <option "; print $_POST['categoria'] == "Placas Lembre-se"? "selected":""; echo" value='Placas Lembre-se'>Placas Lembre-se</option>
    <option "; print $_POST['categoria'] == "Placas Incêndio"? "selected":""; echo" value='Placas Incêndio'>Placas Incêndio</option>
    <option "; print $_POST['categoria'] == "Placas Importante"? "selected":""; echo" value='Placas Importante'>Placas Importante</option>
    <option "; print $_POST['categoria'] == "Placas Educação"? "selected":""; echo" value='Placas Educação'>Placas Educação</option>
    <option "; print $_POST['categoria'] == "Placas Economize"? "selected":""; echo" value='Placas Economize'>Placas Economize</option>
    <option "; print $_POST['categoria'] == "Placas Cuidado"? "selected":""; echo" value='Placas Cuidado'>Placas Cuidado</option>
    <option "; print $_POST['categoria'] == "Placas Aviso"? "selected":""; echo" value='Placas Aviso'>Placas Aviso</option>
    <option "; print $_POST['categoria'] == "Placas Atenção"? "selected":""; echo" value='Placas Atenção'>Placas Atenção</option>
    <option "; print $_POST['categoria'] == "Placa de Elevador"? "selected":""; echo" value='Placa de Elevador'>Placa de Elevador</option>
    <option "; print $_POST['categoria'] == "Cartões Temporários"? "selected":""; echo" value='Cartões Temporários'>Cartões Temporários</option>
    <option "; print $_POST['categoria'] == "Cavaletes"? "selected":""; echo" value='Cavaletes'>Cavaletes</option>
    <option "; print $_POST['categoria'] == "CIPA"? "selected":""; echo" value='CIPA'>CIPA</option>
    <option "; print $_POST['categoria'] == "Painel de Risco"? "selected":""; echo" value='Painel de Risco'>Painel de Risco</option>
    <option "; print $_POST['categoria'] == "Pedestal e Cone"? "selected":""; echo" value='Pedestal e Cone'>Pedestal e Cone</option>
    <option "; print $_POST['categoria'] == "Pictogramas"? "selected":""; echo" value='Pictogramas'>Pictogramas</option>
    <option "; print $_POST['categoria'] == "Placas Bilingüis"? "selected":""; echo" value='Placas Bilingüis'>Placas Bilingüis</option>
    <option "; print $_POST['categoria'] == "Placa de Aviso Ilustrada"? "selected":""; echo" value='Placas de Aviso Ilustradas'>Placas de Aviso Ilustradas</option>
    <option "; print $_POST['categoria'] == "Conservação de Energia"? "selected":""; echo" value='Conservação de Energia'>Placas de Conservação de Energia</option>
    <option "; print $_POST['categoria'] == "Placas de EPI"? "selected":""; echo" value='Placas de EPI'>Placas de EPI</option>
    <option "; print $_POST['categoria'] == "Placas de Higiene Ilustradas"? "selected":""; echo" value='Placas de Higiene Ilustradas'>Placas de Higiene Ilustradas</option>
    <option "; print $_POST['categoria'] == "Identificação de Andar"? "selected":""; echo" value='Identificação de Andar'>Placas de Identificação de Andar</option>
    <option "; print $_POST['categoria'] == "Identificação de Área"? "selected":""; echo" value='Identificação de Área'>Placas de Identificação de Área</option>
    <option "; print $_POST['categoria'] == "Placas de Meio Ambiente"? "selected":""; echo" value='Placas de Meio Ambiente'>Placas de Meio Ambiente</option>
    <option "; print $_POST['categoria'] == "Placas de Orientação de Veículos"? "selected":""; echo" value='Placas de Orientação de Veículos'>Placas de Orientação de Veículos</option>
    <option "; print $_POST['categoria'] == "Placa de Reciclagem"? "selected":""; echo" value='Placa de Reciclagem'>Placas de Reciclagem</option>
    <option "; print $_POST['categoria'] == "Placas de Risco"? "selected":""; echo" value='Placas de Risco'>Placas de Risco</option>
    <option "; print $_POST['categoria'] == "Placas de Risco de Fogo Internacional"? "selected":""; echo" value='Placas de Risco de Fogo Internacional'>Placas de Risco de Fogo Internacional</option>
    <option "; print $_POST['categoria'] == "Placas de Saúde"? "selected":""; echo" value='Placas de Saúde'>Placas de Saúde</option>
    <option "; print $_POST['categoria'] == "Sinalização Urbana e Rodoviária"? "selected":""; echo" value='Sinalização Urbana e Rodoviária'>Placas de Sinalização Urbana e Rodoviária</option>
    <option "; print $_POST['categoria'] == "Placa de Uso Obrigatório"? "selected":""; echo" value='Placa de Uso Obrigatório'>Placas de Uso Obrigatório</option>
    <option "; print $_POST['categoria'] == "Placas Dobráveis"? "selected":""; echo" value='Placas Dobráveis'>Placas Dobráveis</option>
    <option "; print $_POST['categoria'] == "Placas Ilustradas Conjugadas"? "selected":""; echo" value='Placas Ilustradas Conjugadas'>Placas Ilustradas Conjugadas</option>
    <option "; print $_POST['categoria'] == "Placas Tríplice"? "selected":""; echo" value='Placas Tríplice'>Placas Tríplice</option>
    <option "; print $_POST['categoria'] == "Setas Indicativas"? "selected":""; echo" value='Setas Indicativas'>Setas Indicativas</option>
    <option "; print $_POST['categoria'] == "Eletricidade"? "selected":""; echo" value='Eletricidade'>Sinalização de Eletricidade</option>
    <option "; print $_POST['categoria'] == "Sinalização de Incêndio"? "selected":""; echo" value='Sinalização de Incêndio'>Sinalização de Incêndio</option>
    <option "; print $_POST['categoria'] == "Rota de Incêndio"? "selected":""; echo" value='Rota de Incêndio'>Sinalização de Rota de Incêndio</option>
    <option "; print $_POST['categoria'] == "Educativa e Educativa Ilustrada"? "selected":""; echo" value='Educativa e Educativa Ilustrada'>Sinalização Educativa e Educativa Ilustrada</option>
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
    <option "; print $_POST['tamanho'] == "0.01 x 0.02"? "selected":""; echo">0.01 x 0.02</option>
    <option "; print $_POST['tamanho'] == "0.025 x 0.045"? "selected":""; echo">0.025 x 0.045</option>
    <option "; print $_POST['tamanho'] == "0.05 x 0.07"? "selected":""; echo">0.05 x 0.07</option>
    <option "; print $_POST['tamanho'] == "0.05 x 0.15"? "selected":""; echo">0.05 x 0.15</option>
    <option "; print $_POST['tamanho'] == "0.06 x 0.12"? "selected":""; echo">0.06 x 0.12</option>
    <option "; print $_POST['tamanho'] == "0.08 x 0.02"? "selected":""; echo">0.08 x 0.02</option>
    <option "; print $_POST['tamanho'] == "0.08 x 0.06"? "selected":""; echo">0.08 x 0.06</option>
    <option "; print $_POST['tamanho'] == "0.08 x 0.12"? "selected":""; echo">0.08 x 0.12</option>
    <option "; print $_POST['tamanho'] == "0.08 x 0.17"? "selected":""; echo">0.08 x 0.17</option>
    <option "; print $_POST['tamanho'] == "0.1 x 0.18"? "selected":""; echo">0.1 x 0.18</option>
    <option "; print $_POST['tamanho'] == "0.1 x 0.2"? "selected":""; echo">0.1 x 0.2</option>
    <option "; print $_POST['tamanho'] == "0.1 x 0.3"? "selected":""; echo">0.1 x 0.3</option>
    <option "; print $_POST['tamanho'] == "0.11 x 0.25"? "selected":""; echo">0.11 x 0.25</option>
    <option "; print $_POST['tamanho'] == "0.12 x 0.35"? "selected":""; echo">0.12 x 0.35</option>
    <option "; print $_POST['tamanho'] == "0.15 x 0.15"? "selected":""; echo">0.15 x 0.15</option>
    <option "; print $_POST['tamanho'] == "0.15 x 0.3"? "selected":""; echo">0.15 x 0.3</option>
    <option "; print $_POST['tamanho'] == "0.17 x 0.24"? "selected":""; echo">0.17 x 0.24</option>
    <option "; print $_POST['tamanho'] == "0.17 x 0.27"? "selected":""; echo">0.17 x 0.27</option>
    <option "; print $_POST['tamanho'] == "0.17 x 0.47"? "selected":""; echo">0.17 x 0.47</option>
    <option "; print $_POST['tamanho'] == "0.18 x 0.18"? "selected":""; echo">0.18 x 0.18</option>
    <option "; print $_POST['tamanho'] == "0.19 x 0.13"? "selected":""; echo">0.19 x 0.13</option>
    <option "; print $_POST['tamanho'] == "0.19 x 0.25"? "selected":""; echo">0.19 x 0.25</option>
    <option "; print $_POST['tamanho'] == "0.19 x 0.38"? "selected":""; echo">0.19 x 0.38</option>
    <option "; print $_POST['tamanho'] == "0.2 x 0.2"? "selected":""; echo">0.2 x 0.2</option>
    <option "; print $_POST['tamanho'] == "0.2 x 0.4"? "selected":""; echo">0.2 x 0.4</option>
    <option "; print $_POST['tamanho'] == "0.22 x 0.35"? "selected":""; echo">0.22 x 0.35</option>
    <option "; print $_POST['tamanho'] == "0.23 x 0.67"? "selected":""; echo">0.23 x 0.67</option>
    <option "; print $_POST['tamanho'] == "0.24 x 0.34"? "selected":""; echo">0.24 x 0.34</option>
    <option "; print $_POST['tamanho'] == "0.25 x 0.19"? "selected":""; echo">0.25 x 0.19</option>
    <option "; print $_POST['tamanho'] == "0.25 x 0.45"? "selected":""; echo">0.25 x 0.45</option>
    <option "; print $_POST['tamanho'] == "0.27 x 0.17"? "selected":""; echo">0.27 x 0.17</option>
    <option "; print $_POST['tamanho'] == "0.27 x 0.37"? "selected":""; echo">0.27 x 0.37</option>
    <option "; print $_POST['tamanho'] == "0.3 x 0.23"? "selected":""; echo">0.3 x 0.23</option>
    <option "; print $_POST['tamanho'] == "0.3 x 0.3"? "selected":""; echo">0.3 x 0.3</option>
    <option "; print $_POST['tamanho'] == "0.3 x 0.4"? "selected":""; echo">0.3 x 0.4</option>
    <option "; print $_POST['tamanho'] == "0.3 x 0.5"? "selected":""; echo">0.3 x 0.5</option>
    <option "; print $_POST['tamanho'] == "0.37 x 0.27"? "selected":""; echo">0.37 x 0.27</option>
    <option "; print $_POST['tamanho'] == "0.37 x 0.47"? "selected":""; echo">0.37 x 0.47</option>
    <option "; print $_POST['tamanho'] == "0.4 x 0.11"? "selected":""; echo">0.4 x 0.11</option>
    <option "; print $_POST['tamanho'] == "0.4 x 0.4"? "selected":""; echo">0.4 x 0.4</option>
    <option "; print $_POST['tamanho'] == "0.47 x 0.37"? "selected":""; echo">0.47 x 0.37</option>
    <option "; print $_POST['tamanho'] == "0.47 x 0.67"? "selected":""; echo">0.47 x 0.67</option>
    <option "; print $_POST['tamanho'] == "0.5 x 0.29"? "selected":""; echo">0.5 x 0.29</option>
    <option "; print $_POST['tamanho'] == "0.5 x 0.5"? "selected":""; echo">0.5 x 0.5</option>
    <option "; print $_POST['tamanho'] == "0.6 x 0.15"? "selected":""; echo">0.6 x 0.15</option>
    <option "; print $_POST['tamanho'] == "0.6 x 0.6"? "selected":""; echo">0.6 x 0.6</option>
    <option "; print $_POST['tamanho'] == "0.67 x 0.47"? "selected":""; echo">0.67 x 0.47</option>
    <option "; print $_POST['tamanho'] == "0.67 x 0.97"? "selected":""; echo">0.67 x 0.97</option>
    <option "; print $_POST['tamanho'] == "0.7 x 1"? "selected":""; echo">0.7 x 1</option>
    <option "; print $_POST['tamanho'] == "0.7 x 1.2"? "selected":""; echo">0.7 x 1.2</option>
    <option "; print $_POST['tamanho'] == "0.75 x 0.4"? "selected":""; echo">0.75 x 0.4</option>
    <option "; print $_POST['tamanho'] == "0.8 x 0.25"? "selected":""; echo">0.8 x 0.25</option>
    <option "; print $_POST['tamanho'] == "0.8 x 0.8"? "selected":""; echo">0.8 x 0.8</option>
    <option "; print $_POST['tamanho'] == "1 x 1"? "selected":""; echo">1 x 1</option>
    <option "; print $_POST['tamanho'] == "1 x 1.2"? "selected":""; echo">1 x 1.2</option>
    <option "; print $_POST['tamanho'] == "1 x 1.5"? "selected":""; echo">1 x 1.5</option>
    <option "; print $_POST['tamanho'] == "1 x 2"? "selected":""; echo">1 x 2</option>
    </select>
    </td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td align=center><b><font size=1>Legenda:</font></b></td>";
    echo "<td align=left>
    <select name=leg id=leg>
    <option value='Sem Legenda'></option>
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
              (
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['word'])."%".strtolower($_POST['categoria'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              OR
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['categoria'])."%".strtolower($_POST['word'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              )

              ";
           }
        }else{
            /*
            $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
            desc_detalhada_prod LIKE '%{$_POST['categoria']}%{$_POST['material']}%{$_POST['espessura']}%{$_POST['tamanho']}%{$_POST['acabamento']}%'";
            */
            $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
              (
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['word'])."%".strtolower($_POST['categoria'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              OR
              LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['categoria'])."%".strtolower($_POST['word'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'
              )
              ";
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
				     $grupo = "<br>[<b>Grupo:</b> {$buffer[$x]['g_min']} à {$buffer[$x]['g_max']}.]";
				 }else{
					 $grupo = "";
				 }
               echo "<tr>";
               echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_orcamento_produto(prompt('Quantidade:', '1'), '{$buffer[$x]['cod_prod']}');\"><font size=2><b>Adicionar</b></font></td>";
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
