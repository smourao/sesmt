<?php
session_start();
include "functions.php";
include "config/connect.php";

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

if(!isset($_SESSION[usuario_id])){
    header('Location: http://www.sesmt-rio.com/erp/index.php?sessao=0');
}

function anti_injection($sql)
{
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
    $sql = trim($sql);//limpa espaços vazio
    $sql = strip_tags($sql);//tira tags html e php
    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
    return $sql;
}
?>
<html>
<head>
<title>Viabilidade de Atendimento</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="js.js"></script>
<script language="javascript" src="screen.js"></script>
<script language="javascript" src="bt.js"></script>
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

td.por{
    background-color: #000000;
}
td.por2{
    background-color: #66000A;
}

table.tmsg{
    border: 2px solid #000000;
}
td.msg1{
    background-image: url('msgbg1.jpg');
    background-repeat: repeat-x;
    font-size: 12px;
}
td.msg2{
    background-image: url('msgbg1.jpg');
    background-repeat: repeat-x;
    font-size: 12px;
}

-->
</style>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<center><h2><a name=top>SESMT - Segurança do Trabalho</a></h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966">
        <br>VIABILIDADE DE ATENDIMENTO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
                <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='tela_principal.php'" value="Sair" style="width:120;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">
<p>
<table width=100% border=0 cellspacing=2 cellpading=5 id=maint>
<tr>
   <td valign=middle id=ls>
<?PHP
        //$sql = "SELECT * FROM reg_pessoa_juridica WHERE cod_cliente > 0 AND id <> 6 ORDER BY data_cadastro DESC";
        $sql = "SELECT gc.*, c.razao_social FROM site_gerar_contrato gc, cliente c
        WHERE
        gc.status <> 2
        AND
        c.cliente_id = gc.cod_cliente";
        $result = pg_query($sql);
        $clientes = pg_fetch_all($result);

        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><b>Nº</b></td>";
        echo "<td align=center class=fontebranca12><b>Empresa</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><b>Cód. Cliente</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><b>Status</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><b>Cláusula 1</b></a></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($result);$x++){
                echo "<tr>";
                echo "<td class=fontebranca12 align=center><font size=1>".($x+1)."</td>";
                echo "<td class=fontebranca12 align=left><b>{$clientes[$x][razao_social]}</b></a></td>";
                echo "<td class=fontebranca12 align=center><b>{$clientes[$x][cod_cliente]}</b></td>";
                echo "<td class=fontebranca12 align=center><b>";
                if($clientes[$x][status]==1)
                    echo "Finalizado";
                elseif($clientes[$x][status]==0)
                    echo "Aguardando";
                elseif($clientes[$x][status]==2)
                    echo "Cancelado";
                

                echo "</b></td>";
                echo "<td class='fontebranca12 linksistema' align=center><b><a class=linksistema href='http://sesmt-rio.com/contratos/first_page.php?cod_cliente={$clientes[$x][cod_cliente]}&cid={$clientes[$x][cod_orcamento]}/{$clientes[$x][ano_orcamento]}&tipo_contrato={$clientes[$x][tipo_contrato]}&sala={$clientes[$x][atendimento_medico]}&parcelas={$clientes[$x][n_parcelas]}&vencimento=".date("d/m/Y", strtotime($clientes[$x][vencimento]))."&rnd=".rand(10000, 99999)."' target=_blank>Visualizar</a></b></td>";
            }
        echo "</table>";
?>
	 </td>
    </tr>
</table>
</body>
</html>
