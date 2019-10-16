<?PHP
/**************************************************************************************************/
// -->
		$cod_cliente = $_GET[cod_cliente];

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






echo "<form name='form' method='post' action='?dir=cad_cliente&p=upload&cod_cliente=$cod_cliente' enctype='multipart/form-data'>";

echo "<fieldset class='infraFieldset'><legend class='infraLegend'>Enviar Arquivos</legend>
    <label id='lblArquivo' for='txtArquivo' class='infraLabelObrigatorio'>Documento:</label>
    <input type='file' id='txtArquivo' name='txtArquivo' value='' />";







echo "</table>";
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
?>

<tr>
<td width=180 class=fontebranca12><b>Data de Vencimento:</b></td>
   <td  class=fontebranca12>
   <input type=text size=10 maxlength=10 name="data_vencimento" id="data_vencimento" onkeypress="formatar(this, '##/##/####');">
   
   </td>
</tr>

<?php
echo "</table>";
echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='button' class='btn' name='back' value='Voltar' onmouseover=\"showtip('tipbox', '- Retorna ao cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$cod_cliente&sp=cadastro';\">";
            echo "&nbsp;";
            echo "<button type='submit' accesskey='S' name='sbmSalvar' class='infraButton'><span class='infraTeclaAtalho'>E</span>nviar</button>";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";

echo "</form>";
?>