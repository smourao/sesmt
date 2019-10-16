<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
}
else{
	$cliente = $_POST["cliente"];
	$setor   = $_POST["setor"];
}

if(!empty($cliente)){
/******************** DADOS DO CLIENTE **********************/
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}
/******************** DADOS DO CLIENTE **********************/

if(!empty($setor)){
/*************** DADOS DO SETOR ****************/
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($query_set);
}
/*************** DADOS DO SETOR DO CLIENTE ****************/
?>
<html>
<head>
<title>Sugestões</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="orc.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_medida_produto" method="post">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
		<th bgcolor="#009966" colspan=2>
			<br> CADASTRO DE PLACAS DE SINALIZAÇÃO <br>&nbsp;		</th>
    </tr>
	<?php
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
				<br> <font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b><?php echo $row_cli[razao_social]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: 		<b><?php echo $row_cli[endereco]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Bairro:   		<b><?php echo $row_cli[bairro]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: 		<b><?php echo $row_cli[telefone];     ?></b> <br>
				&nbsp;&nbsp;&nbsp; E-mail:   		<b><?php echo $row_cli[email]; 		  ?></b> <hr>
				</font> </td>
		</tr>
	<?php
	}

	if($result_set){
		$row_set = pg_fetch_array($result_set);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
				<font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Setor:	   <b> <?php echo $row_set[nome_setor]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Descrição do Setor: <b> <?php echo $row_set[desc_setor]; ?></b> <hr>
				</font>			</td>
		</tr>
	<?php
	}
echo "</table>";

/***********************************************************************************************/
//                                      AJAX
/***********************************************************************************************/
echo "<script>update_ppra_placas({$cliente}, {$setor}, {$_GET[id_ppra]});</script>";
echo '<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >';
echo '<tr>';
echo '   <td><div id="pcontent"></div></td>';
echo '</tr>';
echo '</table>';

echo "<P>";

    echo "<form method='POST'>";
    echo "<br>";
    echo "<table border=1 cellspacing=0 cellpadding=0 width=760 align=center>";
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
    <option "; print $_POST['categoria'] == "Pictogramas" ? "selected":""; echo">Pictogramas</option>
    <option "; print $_POST['categoria'] == "Eletricidade" ? "selected":""; echo">Eletricidade</option>
    <option "; print $_POST['categoria'] == "Cartões Temporários" ? "selected":""; echo">Cartões Temporários</option>
    <option "; print $_POST['categoria'] == "Placas Dobráveis" ? "selected":""; echo">Placas Dobráveis</option>
    <option "; print $_POST['categoria'] == "Placas de Orientação de Veículos"? "selected":""; echo">Placas de Orientação de Veículos</option>
    <option "; print $_POST['categoria'] == "Setas Indicativas"? "selected":""; echo">Setas Indicativas</option>
    <option "; print $_POST['categoria'] == "Rota de Incêndio"? "selected":""; echo">Rota de Incêndio</option>
    <option "; print $_POST['categoria'] == "Placas de Risco"? "selected":""; echo">Placas de Risco</option>
    <option "; print $_POST['categoria'] == "Placas de EPI"? "selected":""; echo">Placas de EPI</option>
    <option "; print $_POST['categoria'] == "Cavaletes"? "selected":""; echo">Cavaletes</option>
    <option "; print $_POST['categoria'] == "Pedestal e Cone"? "selected":""; echo">Pedestal e Cone</option>
    <option "; print $_POST['categoria'] == "Sinalização Urbana e Rodoviária"? "selected":""; echo">Sinalização Urbana e Rodoviária</option>
    <option "; print $_POST['categoria'] == "Sinalização Educativa e Ilustrada"? "selected":""; echo">Sinalização Educativa e Ilustrada</option>
    <option "; print $_POST['categoria'] == "Conservação de Energia"? "selected":""; echo">Conservação de Energia</option>
    <option "; print $_POST['categoria'] == "Risco de Fogo Internacional"? "selected":""; echo">Risco de Fogo Internacional</option>
    <option "; print $_POST['categoria'] == "Placas de Aviso Ilustradas"? "selected":""; echo">Placas de Aviso Ilustradas</option>
    <option "; print $_POST['categoria'] == "Placas de Radiação"? "selected":""; echo">Placas de Radiação</option>
    <option "; print $_POST['categoria'] == "Placas Ilustradas Conjugadas"? "selected":""; echo">Placas Ilustradas Conjugadas</option>
    <option "; print $_POST['categoria'] == "CIPA"? "selected":""; echo">CIPA</option>
    <option "; print $_POST['categoria'] == "Placas Tríplice"? "selected":""; echo">Placas Tríplice</option>
    <option "; print $_POST['categoria'] == "Placa de Uso Obrigatório"? "selected":""; echo">Placa de Uso Obrigatório</option>
    <option "; print $_POST['categoria'] == "Placas de Interdição de Área"? "selected":""; echo">Placas de Interdição de Área</option>
    <option "; print $_POST['categoria'] == "Placas de Reciclagem"? "selected":""; echo">Placas de Reciclagem</option>
    <option "; print $_POST['categoria'] == "Placas de Identificação de Andar"? "selected":""; echo">Placas de Identificação de Andar</option>
    <option "; print $_POST['categoria'] == "Placas de Meio Ambiente"? "selected":""; echo">Placas de Meio Ambiente</option>
    <option "; print $_POST['categoria'] == "Placas de Saúde"? "selected":""; echo">Placas de Saúde</option>
    <option "; print $_POST['categoria'] == "Placas de Higiene Ilustradas"? "selected":""; echo">Placas de Higiene Ilustradas</option>
    <option "; print $_POST['categoria'] == "Placas Bilingüis"? "selected":""; echo">Placas Bilingüis</option>
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
    <select name=leg id=leg style=\"width: 400px;\">
    ";
    if($_POST['leg']){
       echo "<option value='{$_POST['leg']}'>{$_POST['leg']}</option>";
    }else{
       echo "<option value=''>&nbsp;</option>";
    }
    echo "
    </select>
    </td>";
    echo "</tr>";
    echo "</table>";
    echo "<center><input type=submit name=submit value=Procurar></center>";
    echo "</form>";
    if($_POST['submit']){
    if($_POST[word]){
       if(is_numeric($_POST['word'])){
          $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND cod_prod ='{$_POST['word']}'";
       }else{
          $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
          LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['word'])."%".strtolower($_POST['categoria'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."'";
       }
    }else{
        $sql = "SELECT * FROM produto WHERE cod_atividade = 4 AND
        LOWER(desc_detalhada_prod) LIKE '%".strtolower($_POST['categoria'])."%".strtolower($_POST['material'])."%".strtolower($_POST['espessura'])."%".strtolower($_POST['tamanho'])."%".strtolower($_POST['acabamento'])."%'";
    }
        $result = pg_query($sql);
        $buffer = pg_fetch_all($result);
            echo "<table border=1 align=center cellspacing=0 cellpadding=0 width=760>";
            echo "<tr>";
            echo "<td align=center><b><font size=1>Adicionar</font></b></td>";
            echo "<td align=center><b><font size=1>Desc.</font></b></td>";
           echo "</tr>";
              for($x=0;$x<pg_num_rows($result);$x++){
                 echo "<tr>";
                 echo "<td align=center style=\"cursor:pointer;\" onclick=\"add_ppra_placas('{$buffer[$x]['cod_prod']}', prompt('Quantidade / Número de participantes:', '1'), '{$cliente}', '{$setor}', '{$_GET[id_ppra]}');\"><font size=2><b>Adicionar</b></font></td>";
                 echo "<td align=left><font size=2>{$buffer[$x]['desc_detalhada_prod']}</font></td>";
                 echo "</tr>";
              }
           echo "</table>";
    }
?>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
		<td align="center">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='cad_mangueira.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&y=<?php echo $_GET[y]; ?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="btn_voltar" value="Voltar à Lista" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Visualizar Relatório" style="width:200px;" onClick="location.href='ppra_relatorio.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?PHP echo $_GET[id_ppra];?>';">
			<br>&nbsp;
		</td>
	</tr>
<input type="hidden" name="cliente" value="<?php echo $cliente;?>" />
<input type="hidden" name="setor"   value="<?php echo $setor;  ?>" />
</table>
</form>
</body>
</html>
