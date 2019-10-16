<link href="../../layout/css/sist.css" rel="stylesheet" type="text/css">
<link href="../../layout/css/custom.css" rel="stylesheet" type="text/css">
<link href="../../layout/css/keyboard.css" rel="stylesheet" type="text/css">

<script>

function formatar(src, mask)
{
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i)
if (texto.substring(0,1) != saida)
  {
        src.value += texto.substring(0,1);
  }
}
</script>
<?PHP

include("../../common/database/conn.php");
include("../../common/functions.php");
include("../../common/globals.php");

/**************************************************************************************************/
// -->
		$cod_cliente = $_GET[cod_cliente];
		
		if($_GET[cod_fatura]){
			
			$cod_fatura = $_GET[cod_fatura];
			
			$pegarvencimentosql = "SELECT data_vencimento FROM site_fatura_info WHERE cod_fatura = {$cod_fatura}";
			$pegarvencimentoquery = pg_query($pegarvencimentosql);
			$pegarvencimento = pg_fetch_array($pegarvencimentoquery);
			$vencimento = $pegarvencimento['data_vencimento'];
			
		}
		
		$boletosql = "SELECT * FROM cliente_boleto WHERE cod_cliente = $cod_cliente ORDER BY id DESC";
		$boletoquery = pg_query($boletosql);
		$boletoarray = pg_fetch_array($boletoquery);
		
		
		
		





// -->
/**************************************************************************************************/
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Boleto:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";








$urlwww = $_SERVER['SERVER_NAME'];

if($urlwww == 'www.sesmt-rio.com'){
	if($_GET[cod_fatura]){
		
		echo "<form name='form' method='post' action='http://www.sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=upload_search&cod_cliente=$cod_cliente&cod_fatura={$cod_fatura}' enctype='multipart/form-data'>";
	
	}else{
		
	    echo "<form name='form' method='post' action='http://www.sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=upload_search&cod_cliente=$cod_cliente' enctype='multipart/form-data'>";
		
	}
}else{

	if($_GET[cod_fatura]){
		
		echo "<form name='form' method='post' action='http://sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=upload_search&cod_cliente=$cod_cliente&cod_fatura={$cod_fatura}' enctype='multipart/form-data'>";
	
	}else{
		
	    echo "<form name='form' method='post' action='http://sesmt-rio.com/erp/2.0/?dir=cad_cliente&p=upload_search&cod_cliente=$cod_cliente' enctype='multipart/form-data'>";
		
	}

}
echo "<fieldset class='infraFieldset'><legend class='infraLegend'>Enviar Arquivos</legend>
    <label id='lblArquivo' for='txtArquivo' class='infraLabelObrigatorio'>Documento:</label>
    <input type='file' id='txtArquivo' name='txtArquivo' value='' />";







echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

if($_GET[cod_fatura]){
	
	echo '<input type=hidden name="data_vencimento" id="data_vencimento" value="'.$vencimento.'">';
	
}else{

?>

<tr>
<td width=180 class=fontebranca12><b><small>Data de Vencimento:</small></b></td>
   <td  class=fontebranca12>
   <input type=text size=10 maxlength=10 name="data_vencimento" id="data_vencimento" onkeypress="formatar(this, '##/##/####');">
   
   </td>
</tr>

<?php
}
echo "</table>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
			?>
            <a href="javascript:window.history.go(-1)"><input type='button' class='btn' name='back' value='Voltar'></a>
            <?php
            echo "&nbsp;";
            echo "<button type='submit' accesskey='S' name='sbmSalvar' class='infraButton'><span class='infraTeclaAtalho'>E</span>nviar</button>";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";
?>