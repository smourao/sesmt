<?PHP
include "../config/connect.php";
include "../functions.php";

$mes = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", );

$sql = "SELECT * FROM bt_treinamento WHERE id=$_GET[tid]";
$result = pg_query($sql);
$tr = pg_fetch_array($result);

$sql = "SELECT * FROM funcionarios WHERE cod_func = $tr[cod_funcionario] AND cod_cliente = $tr[cod_cliente]";
$result = pg_query($sql);
$func = pg_fetch_array($result);

$sql = "SELECT * FROM bt_cursos WHERE id = $tr[cod_curso]";
$result = pg_query($sql);
$curso = pg_fetch_array($result);
?>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style9 {font-size: 12px; font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif;}
.style1 {font-size: 60px; font-family: Benguiat Bk BT}
-->
</style>
<link href="../../css_js/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {color: #000000; font-weight: bold;}
-->
</style>
<center><p><br /><p>
<BR>
<table width=950 height=582 cellspacing=0 cellpadding=0 border=0>
<tr>
<td width=865 height=580><center>

  <table width="900" border="0">
    <tr>
      <td align="center" class="style1">CERTIFICADO</td>
    </tr>
  </table>
  
  <table width="950" border="0">
    <tr>
      <td align="right"><span class="style9">Nº <?PHP echo STR_PAD($tr[numero_certificado], 6, "0",0);?></span></td>
    </tr>
  </table>
  <p><br />
  <table width="900" border="0">
    <tr>
      <td align="justify" class="style2">
      <div align="justify">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Certificamos que o(a) funcion&aacute;rio(a) <b><?PHP echo $func[nome_func];?></b>, portador(a) do <b>CTPS:</b>
      <b><?PHP echo $func[num_ctps_func];?></b> <b>S&eacute;rie: </b><b><?PHP echo $func[serie_ctps_func];?></b>,
      participou
      <?PHP
      if($tr[data_inicio] != $tr[data_termino])
          echo " do dia ".date("d/m/Y", strtotime($tr[data_inicio]))." &agrave; ".date("d/m/Y", strtotime($tr[data_termino])).", ";
      else
          echo " no dia ".date("d/m/Y", strtotime($tr[data_inicio])).", ";
          
      if($tr[tipo_treinamento] == "Curso")
          echo "do curso de ";
      else
         echo "da palestra sobre ";

      echo "<b>$curso[curso]</b>, $curso[exigencia], ";
      if($tr[tipo_treinamento] == "Curso")
          echo "ministrado por <b>$tr[nome_instrutor]</b>, ";
      else
         echo "monitorado por <b>$tr[nome_instrutor]</b>, ";
      ?>
      registro no <?PHP echo $tr[reg_instrutor];?>, com dura&ccedil;&atilde;o de
      <b><?PHP echo $curso[carga_horaria];?> horas</b>.
      </div>
      </td>
    </tr>
  </table>
  <p>
  <table width="900" border="0">
    <tr>
      <td align="center" class="style2">Rio de Janeiro, <?PHP echo date("d", strtotime($tr[data_termino]));?> de <?PHP echo $mes[date("n", strtotime($tr[data_termino]))];?> de <?PHP echo date("Y", strtotime($tr[data_termino]));?>.</td>
    </tr>
  </table>
  <p>
  <table width="950" border="0">
    <tr>
      <td valign="bottom" align="right" class="style2">&nbsp;<BR>____________________________<br /><b>Portador do Certificado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
      <td valign="bottom" align="center" class="style2"><div style="position: relative;"><img src="http://sesmt-rio.com/erp/img/ass_pedro333.png" border=0></div><BR>______________________________<br /><b>Coordenador</b></td>
	  <td width="250">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </center>
  </td>
</tr>
</table></center>
