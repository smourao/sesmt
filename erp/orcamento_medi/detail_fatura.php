<?php
include "../sessao.php";
include "../config/connect.php";
?>
<html>
<head>
<title>EXAMES COMPLEMENTARES ~ MIGRAR -> FATURAS</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
<script language="javascript" src="scripts.js"></script>
</head>
<style>
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

#loading_done{
position: relative;
display: none;
}
</style>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho</h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966"><br>MIGRAR ORÇAMENTOS DE EXAME COMPLEMENTAR<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../tela_principal.php';" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>


  <tr>
    <th colspan="7" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Orçamentos Confirmados</h3>
    </th>
  </tr>
  <tr>

    <td width="30" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Nº</strong></div></td>

    <td width="30" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Cód.</strong></div></td>

    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social
	</strong></div></td>

    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Total</strong></div></td>


    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Orçamentos</strong></div></td>
<!--
    <td width="15%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Realizado</strong></div></td>
-->
    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Detalhes</strong></div></td>
    
    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Migrar</strong></div></td>

  </tr>
<?php
$cod_cliente = (int)($_GET[cod_cliente]);
$sql = "SELECT * FROM cliente WHERE cliente_id = {$cod_cliente}";
$cdata = pg_fetch_array(pg_query($sql));

$sql = "SELECT * FROM site_orc_medi_info WHERE cod_cliente = {$cod_cliente} AND migrado = 0 AND done = 1";
$rlo = pg_query($sql);
$orc = pg_fetch_all($rlo);
$total = 0;
for($y=0;$y<pg_num_rows($rlo);$y++){
    $sql = "SELECT * FROM site_orc_medi_produto WHERE cod_orcamento = ".(int)($orc[$y][cod_orcamento]);
    $rlp = pg_query($sql);
    $prod = pg_fetch_all($rlp);
    for($z=0;$z<pg_num_rows($rlp);$z++){
        $total += $prod[$z][preco_aprovado] * $prod[$z][quantidade];
    }
}

    echo "<tr>";
    echo "<td class='linhatopodiresq linksistema' align=center><font size=2>".($x+1)."</font></td>";
    echo "<td class='linhatopodiresq linksistema' align=center><font size=2>".str_pad($cdata[cliente_id], 4, "0", 0)."</font></td>";
    echo "<td class='linhatopodiresq linksistema'><font size=2>{$cdata[razao_social]}</font></td>";
    echo "<td class='linhatopodiresq linksistema' align=right><font size=2>R$ ".number_format($total, 2, ',','.')."</font></td>";
    echo "<td class='linhatopodiresq linksistema' align=center><font size=2>".pg_num_rows($rlo)."</font></td>";
    echo "<td class='linhatopodiresq linksistema' align=center><font size=2>Ver</font></td>";
    echo "<td class='linhatopodiresq linksistema' align=center><font size=2>Migrar</font></td>";
    echo "</tr>";


  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
