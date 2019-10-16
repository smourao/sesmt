<?PHP
include "../config/connect.php";
include "../sessao.php";
echo "<head> <link href=../css_js/css.css rel=stylesheet type=text/css>
	  <script language=javascript src=../scripts.js></script> </head>
	  <body bgcolor=#006633 text=#FFFFFF alink=#FFFFFF vlink=#FFFFFF>";
if(!$_GET){
echo '<form method="POST">
	  <table width=750 border=1 align=center>
		<tr>
			<td align=center colspan=2 bgcolor=#009966><br><b>Pesquisa de Clientes</b><br>&nbsp;</td>
		</tr>
		<tr>
			<td align=center><b>Pesquisa:</b>&nbsp;&nbsp;&nbsp;
			  <input type=text name=search>&nbsp;&nbsp;&nbsp;
			  <input type=submit value=Pesquisar>&nbsp;&nbsp;&nbsp;
			  <input type=button value=&lt;&lt;Voltar onClick=MM_goToURL("parent","../adm#financeiro");return document.MM_returnValue>
	  		</td>
		</tr>';
}

if($_POST){
	$sql = "SELECT * FROM cliente WHERE lower(razao_social) like '%".strtolower(addslashes($_POST['search']))."%' order by cliente_id";
	$re = pg_query($connect, $sql);
	$buffer = pg_fetch_all($re);
	echo "<tr><td class=linksistema>";
	
	for($x=0;$x<pg_num_rows($re);$x++){
		echo "<a href=?cod_cliente={$buffer[$x]['cliente_id']}&cod_filial={$buffer[$x]['filial_id']}&pc=0>".$buffer[$x]['cliente_id']." - ".$buffer[$x]['razao_social']."</a><br>&nbsp;";
		echo "<br>";
	}
	
	$sql = "SELECT * FROM cliente_pc WHERE lower(razao_social) like '%".strtolower(addslashes($_POST['search']))."%' order by cliente_id";
	$reb = pg_query($connect, $sql);
	$bb = pg_fetch_all($reb);
	
	 for($x=0;$x<pg_num_rows($reb);$x++){
		echo "<a href=?cod_cliente={$bb[$x]['cliente_id']}&cod_filial={$bb[$x]['filial_id']}&pc=1>[PC] ".$bb[$x]['cliente_id']." - ".$bb[$x]['razao_social']."</a><br>&nbsp;";
		echo "<br>";
	}

    echo "</tr></td></table></form>";
}

if($_GET['cod_cliente']){

echo "<head> <link href=../css_js/css.css rel=stylesheet type=text/css> </head>";
echo "  <body bgcolor=#006633 text=#FFFFFF alink=#FFFFFF vlink=#FFFFFF>
		<form method='POST' action='tmm.php?cod_cliente={$_GET[cod_cliente]}&cod_filial={$_GET[cod_filial]}&pc={$_GET[pc]}'>
		<table width=750 border=1 align=center>
		<tr>
			<td align=center colspan=2 bgcolor=#009966><br><b>Registro Para Criação de Faturas</b><br>&nbsp;</td>
		</tr>";

echo "<tr>
		  <td align=right>Contrato:&nbsp;</td>
		  <td>&nbsp;<select name=tipo_contrato width=700>
		  <option>Aberto</option>
		  <option>Fechado</option>
		  <option>Misto</option>
		  <option>Especifico</option>
		  <option>Curso</option>
		  </select>
		  </td>
	  </tr>";

echo "<tr>";
echo "<td align=right>Quantidade:&nbsp;</td> 
	  <td>&nbsp;<input type=text name=quantidade></td>";
echo "</tr>";

echo "<tr>";
echo "<td align=right>Data:&nbsp;</td>
	  <td>&nbsp;<input type=text name=data_exibicao></td>";
echo "</tr>";

echo "	  <tr>";
echo "<td align=right>Descrição:&nbsp;</td>
	  <td>&nbsp;<select name=descricao style=width:620>";
	  
	  $bus = "SELECT id, descricao FROM desc_fatura order by descricao";
	  $res = pg_query($connect, $bus);
	  
	  while ($row = pg_fetch_array($res)){
	  echo "<option value='$row[descricao]'>".$row[descricao]."</option>";
	  }
echo "</select></td>";
echo "</tr>
	  <tr>";
echo "<td align=right>Resumo:&nbsp;</td>
	  <td>&nbsp;<input type=text name=resumo></td>";
echo "</tr>
	  <tr>";
echo "<td align=right>Parcelas:&nbsp;</td>
	  <td>&nbsp;<input type=text name=parcelas></td>";
echo "</tr>
	  <tr>";
echo "<td align=right>Valor:&nbsp;</td>
	  <td>&nbsp;<input type=text name=valor_unitario></td>";
echo "</tr>
	  <tr>";
echo "<td align=right>Dt de Envio:&nbsp;</td>
	  <td>&nbsp;<input type=text name=data></td>";
echo "</tr>
	  <tr>";
echo "<td align=right>Dt de Venc:&nbsp;</td>
	  <td>&nbsp;<input type=text name=data1></td>";
echo "</tr>
	  <tr>";
echo "<td align=center colspan=2><br><input type=submit value='Enviar'>&nbsp;&nbsp;&nbsp;
	  <input type=button value=&lt;&lt;Voltar onClick=MM_goToURL('parent','nt_fiscal.php');return document.MM_returnValue>
	  <br>&nbsp;
      </td>
	  </tr>
	</table>
</form>";
}
?>
