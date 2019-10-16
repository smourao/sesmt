<?PHP
   session_start();
   include "config/connect.php";
?>
<html>
<head>
<title>PLANILHA DE VENDEDORES</title>
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

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
      <input type=hidden name=orca id=orca value="<?PHP echo $_GET['orcamento'];?>">
      <input type=hidden name=cod_cliente id=cod_cliente value="<?PHP echo $_GET['cod_cliente'];?>">
      <input type=hidden name=cod_filial id=cod_filial value="<?PHP echo $_GET['cod_filial'];?>">
<p>
<center><h2> SESMT - Segurança do Trabalho</h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>PLANILHA DE VENDEDORES<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="location.href='planilha_vendedor.php'" value="Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">
<?PHP
   $sql = "SELECT * FROM funcionario WHERE grupo_id = 7 OR grupo_id = 1 ORDER BY nome";
   $result = pg_query($sql);
   $vendedor = pg_fetch_all($result);
?>
          <table width=100% border=1>
          <tr>
          
             <td width=200 valign=top>
             <center><b>Vendedores</b></center><p>
             <?PHP
                 for($x=0;$x<pg_num_rows($result);$x++){
                    echo "<a class=fontebranca12 href='?vid={$vendedor[$x]['funcionario_id']}'><b>";
                    echo $vendedor[$x]['nome'];
                    echo "</b></a><br>";
                 }
             ?>
             </td>
             
             <td valign=top>
                <?PHP
                    if($_GET['vid']){
                       $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$_GET['vid']} ";
                       $result = pg_query($sql);
                       $buffer = pg_fetch_array($result);
                       echo " ";
                       echo "<center>";
                       echo "<b>".$buffer[nome]."</b>";
                       echo "<p>";
                       echo "</center>";
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                       echo "<a href='?vid={$_GET['vid']}&a=1' class=fontebranca12><b>Orçamentos Gerados</b></a>";
                       echo "<br>";
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                       echo "<a href='?vid={$_GET['vid']}&a=2' class=fontebranca12><b>Orçamentos Aprovados</b></a>";
                       echo "<br>";
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                       echo "<a href='?vid={$_GET['vid']}&a=3' class=fontebranca12><b>Orçamentos Cancelados</b></a>";
                       echo "<br>";
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                       echo "<a href='?vid={$_GET['vid']}&a=4' class=fontebranca12><b>Quantitativo Faturado</b></a>";
                       echo "</center>";
                    }
                ?>
             </td>
          </tr>
          </table>
          <p>
          
          <table border=0 width=100%>
          <tr>
             <td>
             <?PHP
                /******************************************************************/
                // ORÇAMENTOS GERADOS
                /******************************************************************/
                if($_GET['a']==1){
                   $sql = "SELECT * FROM cliente_comercial WHERE funcionario_id = {$_GET['vid']} ORDER BY data DESC";
                   $r = pg_query($sql);
                   $data = pg_fetch_all($r);

                   echo "<center><b>Orçamentos Gerados</b></center>";
                   echo "<p>";
                   echo "<div class=fontebranca12>";
                   echo "<b>Orçamentos gerados:</b> ".pg_num_rows($r);
                   echo "</div>";
                   
                   echo "<p>";
                   
                   echo "<table width=100% border=1>";
                   echo "<tr>";
                   echo "<td align=center><b>Nº</b></td>";
                   echo "<td align=center><b>Razão Social</b></td>";
                   echo "<td align=center><b>Data de Cadastro</b></td>";
                   echo "<td align=center><b>Data de Envio</b></td>";
                   echo "</tr>";
                   
                   for($x=0;$x<pg_num_rows($r);$x++){
                      echo "<tr>";
                      echo "   <td class=fontebranca12 align=center>".STR_PAD($x+1, 3, "0", STR_PAD_LEFT)."</td>";
                      echo "   <td class=fontebranca12>{$data[$x]['razao_social']}</td>";
                      
                      echo "   <td class=fontebranca12 align=center>".date("d/m/Y", strtotime($data[$x]['data']))."</td>";
                      echo "   <td class=fontebranca12 align=center>".date("d/m/Y", strtotime($data[$x]['data_envio']))."</td>";
/*
                      echo "   <td class=fontebranca12 align=center>"; print trim($data[$x]['data']) ? date("d/m/Y", strtotime($data[$x]['data'])) : "N/D"; echo"</td>";
                      echo "   <td class=fontebranca12 align=center>"; print trim($data[$x]['data_envio']) ? date("d/m/Y", strtotime($data[$x]['data_envio'])) : "N/D"; echo"</td>";
*/
                      echo "</tr>";
                   }
                   
                   echo "</table>";

                /******************************************************************/
                // ORÇAMENTOS APROVADOS
                /******************************************************************/
                }elseif($_GET['a']==2){
                   $sql = "SELECT * FROM cliente WHERE vendedor_id = {$_GET['vid']} ORDER BY cliente_id DESC";
                   $r = pg_query($sql);
                   $data = pg_fetch_all($r);

                   echo "<center><b>Orçamentos Aprovados</b></center>";
                   echo "<p>";
                   echo "<div class=fontebranca12>";
                   echo "<b>Orçamentos gerados:</b> ".pg_num_rows($r);
                   echo "</div>";

                   echo "<p>";

                   echo "<table width=100% border=1>";
                   echo "<tr>";
                   echo "<td align=center><b>Nº</b></td>";
                   echo "<td align=center><b>Razão Social</b></td>";
                   echo "<td align=center><b>Data de Cadastro</b></td>";
                   echo "<td align=center><b>Data de Envio</b></td>";
                   echo "</tr>";

                   for($x=0;$x<pg_num_rows($r);$x++){
                      echo "<tr>";
                      echo "   <td class=fontebranca12 align=center>".STR_PAD($x+1, 3, "0", STR_PAD_LEFT)."</td>";
                      echo "   <td class=fontebranca12>{$data[$x]['razao_social']}</td>";

                      echo "   <td class=fontebranca12 align=center>".date("d/m/Y", strtotime($data[$x]['data']))."</td>";
                      echo "   <td class=fontebranca12 align=center>".date("d/m/Y", strtotime($data[$x]['data_envio']))."</td>";
/*
                      echo "   <td class=fontebranca12 align=center>"; print trim($data[$x]['data']) ? date("d/m/Y", strtotime($data[$x]['data'])) : "N/D"; echo"</td>";
                      echo "   <td class=fontebranca12 align=center>"; print trim($data[$x]['data_envio']) ? date("d/m/Y", strtotime($data[$x]['data_envio'])) : "N/D"; echo"</td>";
*/
                      echo "</tr>";
                   }

                   echo "</table>";

                /******************************************************************/
                // ORÇAMENTOS CANCELADOS
                /******************************************************************/
                }elseif($_GET['a']==3){
                   echo "<center><b>Orçamentos Cancelados</b></center>";

                /******************************************************************/
                // RELATÓRIO QUANTITATIVO ( EM PDF PARA IMPRESSÃO )
                /******************************************************************/
                }elseif($_GET['a']==4){
                   echo "<center><b>Quantitativo Faturado</b></center>";
                }
             ?>
             </td>
          </tr>
          </table>

	 </td>
    </tr>
</table>
</body>
</html>
