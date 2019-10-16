<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$cliente = $_GET['cliente'];
$setor = $_GET['setor'];

if(isset($_GET['cliente']) ){
/*
$sql = "select c.razao_social, c.cliente_id, s.nome_setor, s.cod_setor, data_criacao
		from cliente c, setor s, cliente_setor cs 
		where cs.cod_cliente = c.cliente_id
		and cs.cod_setor = s.cod_setor
		and cs.cod_cliente <> 0
		AND EXTRACT(year FROM data_criacao) = {$ano}
		AND c.cliente_id={$_GET['cliente']}
		order by c.razao_social";
*/
    $sql = "SELECT c.razao_social, c.cliente_id, cs.id_ppra
    FROM cliente c, cliente_setor cs
    WHERE cs.cod_cliente = c.cliente_id
    AND cs.cod_cliente <> 0
    AND EXTRACT(YEAR FROM data_criacao) = '{$ano}'
    AND c.cliente_id={$_GET['cliente']}
    GROUP BY c.cliente_id, c.razao_social, cs.id_ppra
    ORDER by c.razao_social";
}else{
      /*$sql = "select distinct(c.razao_social), c.cliente_id
		from cliente c, setor s, cliente_setor cs
		where cs.cod_cliente = c.cliente_id
		and cs.cod_setor = s.cod_setor
		and cs.cod_cliente <> 0
		AND EXTRACT(year FROM data_criacao) = {$ano}
		order by c.razao_social";
      */
    $sql = "SELECT distinct(c.razao_social), c.cliente_id, cs.id_ppra
    FROM cliente c, cliente_setor cs
    WHERE cs.cod_cliente = c.cliente_id
    AND cs.cod_cliente <> 0
    AND EXTRACT(year FROM data_criacao) = '{$ano}'
    ORDER BY c.razao_social";
}
$result_ppra = pg_query($sql);
?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_lista" method="post" action="ppra1.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td colspan="4" bgcolor="#009966" align="center">
		<br>
        <h2 >CGRT</h2>
        <h2 >Cadastro Geral de Relatórios Técnicos</h2>
	</td>
  </tr>
   <tr>
		<th colspan="4" bgcolor="#009966">
		<br>&nbsp;
		<input name="btn_novo" type="submit" id="btn_novo" onClick="MM_goToURL('parent','ppra1.php'); return document.MM_returnValue" value="Novo" style="width:100;" onClick="confirmar();" title="Criar novo registro de PPRA" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		<br>&nbsp;
		<?php
		   echo "<center><font size=2><a href=\"javascript:location.href='?y=".($ano-1)."'\" class=fontebranca12><<</a>  <b>{$ano}</b>  <a href=\"javascript:location.href='?y=".($ano+1)."'\"  class=fontebranca12>>></a></font>    </center>";
		?>
		</th>
	</tr>
  </tr>
    <th width="400"><br><h3 class="style2">CLIENTE</h3></th>
    <th width="300"><br><h3 class="style2">RELATÓRIOS</h3></th>
  </tr>
<?php
    if($_GET[y])
        $newrgdt = $_GET[y]+1;
    else
        $newrgdt = date("Y")+1;
	while($row = pg_fetch_array($result_ppra)){
	$sql = "SELECT c.*, cs.*, cnae
			FROM cliente_setor cs, cliente c, cnae cn, setor s
			WHERE cs.cod_cliente = c.cliente_id
			AND s.cod_setor = cs.cod_setor
			AND c.cnae_id = cn.cnae_id
			AND cs.id_ppra = $row[id_ppra]";
	$cod = pg_fetch_array(pg_query($sql));
	
        switch($row[cliente_id]){
            case 147:
                $row[razao_social] .= " - UPV";
            break;
            case 148:
                $row[razao_social] .= " - UQMI";
            break;
            case 149:
                $row[razao_social] .= " - UQMII";
            break;
        }
		echo "<tr>";
		echo "	<td class=linksistema><a href='#' onclick=\"var dado = prompt('Informe o ano de referência para a duplicação:','{$newrgdt}');if(dado){location.href='dupppra.php?cod_cliente={$row[cliente_id]}&id_ppra={$row[id_ppra]}&year={$ano}&newy='+dado;}\">Duplicar</a> | <a href=\"ppra.php?cliente=$row[cliente_id]&y=$ano&id_ppra={$row[id_ppra]}\">&nbsp;" .$cod[cod_ppra]." - "./*ucwords(strtolower($row[razao_social]))*/ $row[razao_social]." - ".date($cod[data_criacao])."</a> </td>";
	    echo "	<td class=linksistema><a href=\"ppra_relatorio.php?cliente=$row[cliente_id]&id_ppra={$row[id_ppra]}&sem_timbre=1&y=$ano\">&nbsp;PPRA</a> | <a href=\"../medico/pcmso_relatorio.php?cliente=$row[cliente_id]&id_ppra={$row[id_ppra]}&sem_timbre=1&y=$ano\">PCMSO</a> | <a href=\"lista_func_ppp.php?cliente=$row[cliente_id]&id_ppra={$row[id_ppra]}\">PPP</a></td>";
		echo "</tr>";
	}
// encerrar conexão
pg_close($connect);
?>
</table>
</form>
</body>
</html>