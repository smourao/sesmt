<?PHP
include "../config/connect.php";
include "../functions.php";

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
<center><p><br /><p><table width=950 height=582 cellspacing=0 cellpadding=0 border=0>
<tr>
<td width=865 height=580><center>

  <table width="900" border="0">
    <tr>
      <td align="center" class="style1">CERTIFICADO</td>
    </tr>
  </table>
  
  <table width="950" border="0">
    <tr>
      <!--td width="432"><span class="style9">&nbsp;</span></td>
      <td width="189"><span class="style9">&nbsp;</span></td-->
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
      participou do dia <?PHP echo date("d/m/Y", strtotime($tr[data_inicio]));?> &agrave;
      <?PHP echo date("d/m/Y", strtotime($tr[data_termino]));?>, do curso de <b>
      <?PHP echo $curso[curso];?></b>, <?PHP echo $curso[exigencia];?>,
      ministrado por <b><?PHP echo $tr[nome_instrutor];?></b>,
      registro no <?PHP echo $tr[reg_instrutor];?>, com dura&ccedil;&atilde;o de
      <b><?PHP echo $curso[carga_horaria];?> horas</b>.
      </div>
      </td>
    </tr>
  </table>
  <p>
  <table width="900" border="0">
    <tr>
      <td align="center" class="style2">Rio de Janeiro, 08 de Outubro de 2009.</td>
      <!--td width="306"><span class="style9">Profissão: </span></td-->
    </tr>
  </table>
  <p><br /><p><br /><p>
  <table width="950" border="0">
    <tr>
      <td valign="bottom" align="right" class="style2">&nbsp;<BR>____________________________<br /><b>Portador do Certificado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
      <td valign="bottom" align="center" class="style2"><img src="http://sesmt-rio.com/erp/img/ass_pedro.png" border=0><BR>______________________________<br /><b>Coordenador</b></td>
	  <td width="250">&nbsp;</td>
    </tr>
  </table>

  <!--table width="900" border="1">
    <tr>
      <td width="411" height="292"><p align="center" class="style6"><strong>REGIME E CRIT&Eacute;RIOS ADOTADOS</strong></p>
        <div align="justify" class="style2">O presente curso cumpriu todas as disposições da lei de diretrizes e base da Educação Nacional nº 9394/96 e Resolução CNE/CE nº 24 de 18/12/2002; </div>
        <p align="justify" class="style2">Avaliação formativa e somativa, por disciplina, aferida através de trabalhos, provas e exercícios; 
        <p class="style2">Aproveitamento mínimo de 70% (Setenta por cento); <p align="justify" class="style2">Freqüência de pelo menos 75% (Setenta e cinco por cento) da carga horária, por disciplina</td>
      <td width="415"><div align="center"><span class="style2"><strong>SESMT Serviços Especializados de Segurança
        e Monitoramento de Atividades no Trabalho Ltda<br />
  <br />
        </strong></span>
      </div>
        <p align="justify"><span class="style2">Certificado registrado sob o nº 000090 no Livro III da folha 02 nos termo
do disposto no parágrafo 1º do art. 48 da lei 9.393, de 20/12/1996, que
estabelece as diretrizes e base da Educação Nacional e da Resolução
CNE/CES nº 24, de 18/12/2000</span>.        
        <p>        
        <p>        
        <p></td>
    </tr>
  </table-->
  <p>&nbsp;</p>
  </center>
  
  
  </td>
</tr>
</table></center>
