<?PHP
/**************************************************************************************************/
// --> [REGISTER]
/**************************************************************************************************/
if($_GET[cod_cliente]){
	$sql = "SELECT ci.*, c.* FROM cliente c, site_gerar_contrato ci
	WHERE c.cliente_id = $_GET[cod_cliente] AND	c.cliente_id = ci.cod_cliente";
	$r = pg_query($sql);
	$buffer = pg_fetch_array($r);
	$valor_total = $buffer['valor_contrato'];
	if($buffer['n_parcelas'] > 3){
		//Acrescimo de 18%
		$valor_total_mod = round(($valor_total+(($valor_total*18)/100)));
	}elseif($buffer['parcelas'] == 1){
		 //Desconto de 7% pra pagamento a vista
		$valor_total_mod = round(($valor_total-(($valor_total*7)/100)));
	}else{
		$valor_total_mod = $valor_total;
	}
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
		// OP��ES DO CLIENTE
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Op��es</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Voltar' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Voltar, permite voltar ao cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<P>";


		// --> TIPBOX
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class=text height=30 valign=top align=justify>";
				echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
	echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>{$buffer[razao_social]}</b></td>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        echo "<table width=100% BORDER=0 align=center cellpadding=4 cellspacing=2>";
        echo "<tr>";
        echo "<td colspan=6 align=center class='roundborder text'><b>Propriedade de Contrato</b></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td align=center width=60 class='roundborder text'><b>Contrato</b></td>";
        echo "<td align=center width=135 class='roundborder text'><b>Ano/N� Contrato/C�digo</b><BR>{$buffer[ano_contrato]}.".str_pad($buffer[cliente_id], 4, "0", 0)."</td>";
        echo "<td align=left width=70 class='roundborder text'><b>N� Parcelas:<BR>Cl�usula:</b></td>";
        echo "<td align=left width=50 class='roundborder text'>{$buffer[n_parcelas]} Vezes<BR>4.1</td>";
        echo "<td align=left width=50 class='roundborder text'><b>Venc. Fatura:<BR>Cl�usula:</b></td>";
        echo "<td align=left width=50 class='roundborder text'>".date("d/m/Y", strtotime($buffer[vencimento]))."<BR>4.6</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text'><b>Valor:<BR>Cl�usula:</b></td>";
        if($_SESSION[grupo] == "administrador"){
            echo "<td align=left class='roundborder text'>R$ ".number_format($buffer[valor_contrato], 2, ',','.')." [$buffer[n_parcelas] x R$ ".number_format(round($valor_total_mod/$buffer[n_parcelas]), 2, ',','.')."]<BR>4.1</td>";
        }else{
            echo "<td align=left class='roundborder text'>R$ --,--<BR>4.1</td>";
        }
        echo "<td align=left class='roundborder text'><b>Enc. Banc�rio:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>R$ 4,00<BR>3(p)</td>";
        echo "<td align=left class='roundborder text'><b>Postagem:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>6,50<BR>3(p)</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text'><b>Atualiza��o:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text' colspan=3>R$ 25,00<BR>2(x); 3(k) e Par�grafo �nico cl�usula 3(l) PG � vista</td>";
        echo "<td align=left class='roundborder text'><b>Reembolso:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'><BR>3(n) e 4.4</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text'><b>D�bito em:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>05 dias<BR>4.2</td>";
        echo "<td align=left class='roundborder text'><b>Bloq. Acesso:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>05 dias<BR>5.4</td>";
        echo "<td align=left class='roundborder text'><b>Al�quota Multa:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>3%<BR>4.5</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text'><b>Al�quota Juros:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>0,29%<BR>4.5</td>";
        echo "<td align=left class='roundborder text'><b>Prazo Contrato:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>{$buffer[validade]}<BR>6.1</td>";
        echo "<td align=left class='roundborder text'><b>Recis�o:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>00 dias<BR>6.2</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text' colspan=2><b>Isen��o de multas por recis�o<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text' colspan=3><b>Servi�o personalizado inferior a 6 colab.<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>R$ 20,00<BR>Adeno 2.1</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text' colspan=2><b>M�o de Obra M�dica 1/2 per�odo:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>R$ 0,00<BR>Adeno 2.2</td>";
        echo "<td align=left class='roundborder text' colspan=2><b>Per�odo Integral<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>R$ 0,00<BR>2.2</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text' colspan=4><b>Taxa de deslocamento n� inferior a 10 colaboradores (complementar):<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'><b>1/2 per�odo</b><BR>4.2;4.4 e 4.5</td>";
        echo "<td align=left class='roundborder text'>R$ 50,00<BR>Adeno 2.4</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td align=left class='roundborder text' colspan=2><b>Loca��o de Acess�rio M�dico:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text'>R$ 0,00 di�ria<BR>2.3</td>";
        echo "<td align=left class='roundborder text'>R$ 0,00 Mensal<BR>2.3</td>";
        echo "<td align=left class='roundborder text'><b>Palestra (2 horas):</b><BR>Cl�usula:</td>";
        echo "<td align=left class='roundborder text'>R$ 0,00<BR>Adeno 3</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td align=left class='roundborder text' colspan=2><b>Servi�o de Visita T�cnica:<BR>Cl�usula:</b></td>";
        echo "<td align=left class='roundborder text' colspan=2>Inferior a 2 horas R$ 0,00<BR>4.2</td>";
        echo "<td align=left class='roundborder text' colspan=2>Turno de 6 horas R$ 0,00<BR>4.2</td>";
        echo "</tr>";

        echo "</table>";
        
        
    echo "</td>";
echo "</tr>";
echo "</table>";
    
?>