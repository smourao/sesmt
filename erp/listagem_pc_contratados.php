<?php
include "./config/connect.php";
include "sessao.php";
$vendedor_id = $_SESSION[usuario_id];

$sql = "SELECT * FROM cliente_pc WHERE
cliente_id = $_GET[cod_cliente] AND filial_id = $_GET[cod_filial] AND contratante=1";
$result = pg_query($sql);
$contratante =  pg_fetch_array($result);

$query_clientes = "SELECT * FROM cliente_pc
WHERE cnpj_contratante = '$contratante[cnpj]'
ORDER BY cliente_id";

?>
<html>
<head>
<title>Lista de Contratados</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function doNumber () 
	{
		var whichcode = window.event.keyCode;
		if (whichcode < 48) { whichcode = 0; }
		if (whichcode > 57) { whichcode = 0; }
		window.event.keyCode = whichcode;
	}
</script>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="700" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
    <td height="26" colspan="5" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">
        <table width="136" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align=center>
                <input type=button value='Voltar' style="width:100px; height:30px;" onclick="javascript:location.href='listagem_pc.php';">
            </td>
            
          </tr>
        </table>
        </div>
    </div></td>
  </tr>
<!--
    <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
      </td>
    </tr>
-->
  <tr>
    <td colspan="5" class="linhatopodiresq" align=center>
     <font color=white size=3><b>
     <?PHP echo $contratante[razao_social];?>
     </b></font>
    </td>
  </tr>
  <tr>
    <td bgcolor="#009966"  width="76" class="linhatopodiresq"><div align="left" class="fontebranca12">Cod. Cliente </div></td>
    <!--
    <td bgcolor="#009966"  width="60" class="linhatopodir"><div align="left" class="fontebranca12">Cod. Filial </div></td>
    -->
    <td bgcolor="#009966" colspan=2 class="linhatopodir"><div align="left" class="fontebranca12">Raz&atilde;o Social </div></td>
    <td bgcolor="#009966"  width="138" class="linhatopodir"><div align="left" class="fontebranca12">Contato  </div></td>
    <td bgcolor="#009966"  width="100" class="linhatopodir"><div align="left" class="fontebranca12">Telefone</div></td>
  </tr>
<?php
if (!empty($query_clientes))
{
	$result_clientes=pg_query($query_clientes) 
		or die ("Erro na query: $query_clientes".pg_last_error($connect));

  if (pg_num_rows($result_clientes) > 0 )
  {
  
	  while($row=pg_fetch_array($result_clientes)){
?>
  <tr>
    <td class="linhatopodiresq"><div align="left" class="linksistema"><a href="cadastro_cliente_pc_aditivo.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&id=<?php echo $row[id]?>">
		<?php echo str_pad($row[cliente_id], 03, "0", STR_PAD_LEFT)?></a>
    &nbsp;</div></td>
    <!--
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente_pc_aditivo.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&id=<?php echo $row[id]?>">
		<?php echo str_pad($row[filial_id], 03, "0", STR_PAD_LEFT)?></a>
    &nbsp;</div></td>
    -->
    <td colspan=2 class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente_pc_aditivo.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&id=<?php echo $row[id]?>">
		<?php echo $row[razao_social]?>
	</a>&nbsp;</div></td>
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente_pc_aditivo.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&id=<?php echo $row[id]?>">
    	<?php echo $row[nome_contato_dir]?>
    </a>&nbsp;</div></td>
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente_pc_aditivo.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&id=<?php echo $row[id]?>">
		<?php echo $row[telefone]?></a>
    &nbsp;</div></td>
  </tr>
<?php
	}
  }
  else
  { 
	echo "<script>alert('Nenhum registro foi encontrado.');</script>";
  }
}
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
