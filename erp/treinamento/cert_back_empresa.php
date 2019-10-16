<?PHP
include "../config/connect.php";
include "../functions.php";

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");


$sql = "SELECT * FROM bt_treinamento WHERE id=$_GET[tid]";
$result = pg_query($sql);
$tr = pg_fetch_array($result);

//?
$sql = "SELECT * FROM funcionarios WHERE cod_func = $tr[cod_funcionario] AND cod_cliente = $tr[cod_cliente]";
$result = pg_query($sql);
$func = pg_fetch_array($result);

$sql = "SELECT * FROM bt_cursos WHERE id = $tr[cod_curso]";
$result = pg_query($sql);
$curso = pg_fetch_array($result);

$sql = "SELECT * FROM funcao WHERE cod_funcao = $func[cod_funcao]";
$result = pg_query($sql);
$funcao = pg_fetch_array($result);

$sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
$result = pg_query($sql);
$empresa = pg_fetch_array($result);

$query_cnae="select * from cnae where cnae_id=".$empresa[cnae_id]."";
$result_cnae=pg_query($query_cnae);
$row_cnae=pg_fetch_array($result_cnae);
	  
$query_grupo="select grupo_cipa, grau_risco, descricao from cnae where cnae_id=".$empresa[cnae_id]."";
$result_grupo=pg_query($query_grupo);
$row_grupo=pg_fetch_array($result_grupo);

?>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style9 {font-size: 12px; font-weight: normal; font-family: Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
<link href="../../css_js/css.css" rel="stylesheet" type="text/css" />
<center>
<BR>
<table width=980 height=620 cellspacing=0 cellpadding=0 border=1>
<tr>
    <td class=style9 align=center colspan=4><b><?PHP echo $curso[curso];?></b></td>
</tr>
<tr>
    <td class=style9 align=left colspan=2 width=45%><b>Razão Social:</b></span> <?PHP echo $empresa[razao_social];?></td>
    <td class=style9 align=left colspan=1 width=170><b>CNPJ:</b></span> <?PHP echo $empresa[cnpj];?></td>
    <td class=style9 align=left colspan=1><b>C.N.A.E.:</b></span> <?PHP echo $row_cnae[cnae];?> <b>Risco:</b> <?PHP echo $row_grupo[grau_risco];?></td>
</tr>
<tr>
    <td class=style9 align=center colspan=4>
        <b>HIST&Oacute;RICO</b>
        <p>
        <b>CARGA HOR&Aacute;RIA</b>
    </td>
</tr>
<tr>
    <td class=style9 align=justify colspan=4 valign=top>
        <?PHP
         echo "<b>".$curso[descricao]."</b>";
         echo "<p>";
         $sql = "SELECT * FROM bt_treinamento WHERE cert_empresa = $tr[cert_empresa]";
         $result = pg_query($sql);
         $flist = pg_fetch_all($result);

         if(pg_num_rows($result)>=10){
             echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
             for($x=0;$x<pg_num_rows($result);$x+=2){//foreach($flist as $f){
                 echo "<tr>";
                 if($flist[$x][cod_funcionario]){
                     $sql = "SELECT * FROM funcionarios WHERE cod_func = {$flist[$x][cod_funcionario]} AND cod_cliente = {$flist[$x][cod_cliente]}";
                     $r = pg_query($sql);
                     $func = pg_fetch_array($r);
                     echo "<td><font size=1>$func[nome_func]&nbsp;&nbsp;</td><td><font size=1>CTPS: $func[num_ctps_func]&nbsp;&nbsp;</td><td><font size=1>Série: $func[serie_ctps_func]&nbsp;&nbsp;</td>";
                 }
                 if($flist[$x+1][cod_funcionario]){
                     $sql = "SELECT * FROM funcionarios WHERE cod_func = ".$flist[$x+1][cod_funcionario]." AND cod_cliente = ".$flist[$x+1][cod_cliente]."";
                     $r = pg_query($sql);
                     $func = pg_fetch_array($r);
                     echo "<td><font size=1>$func[nome_func]&nbsp;&nbsp;</td><td><font size=1>CTPS: $func[num_ctps_func]&nbsp;&nbsp;</td><td><font size=1>Série: $func[serie_ctps_func]&nbsp;&nbsp;</td>";
                 }
                 /*
                 if($flist[$x+2][cod_funcionario]){
                     $sql = "SELECT * FROM funcionarios WHERE cod_func = ".$flist[$x+2][cod_funcionario]." AND cod_cliente = ".$flist[$x+2][cod_cliente]."";
                     $r = pg_query($sql);
                     $func = pg_fetch_array($r);
                     echo "<td><font size=1>$func[nome_func]&nbsp;&nbsp;</td><td><font size=1>CTPS: $func[num_ctps_func]&nbsp;&nbsp;</td><td><font size=1>Série: $func[serie_ctps_func]&nbsp;&nbsp;</td>";
                 }
                 */
                 echo "</tr>";
             }
             echo "</table>";
         }else{
             echo "<table cellspacing=0 cellpadding=0 border=0>";
             foreach($flist as $f){
                 $sql = "SELECT * FROM funcionarios WHERE cod_func = {$f[cod_funcionario]} AND cod_cliente = {$f[cod_cliente]}";
                 $result = pg_query($sql);
                 $func = pg_fetch_array($result);
                 echo "<tr>";
                 echo "<td><font size=1>$func[nome_func]&nbsp;&nbsp;</td><td><font size=1>CTPS: $func[num_ctps_func]&nbsp;&nbsp;</td><td><font size=1>Série: $func[serie_ctps_func]</td>";
                 echo "</tr>";
             }
             echo "</table>";
         }
         /*
         echo "Carga Horária: $curso[carga_horaria] Horas;";
         echo "<p>";
         echo "Conteúdo Programático:";
         echo "<p>";
         echo nl2br($curso[conteudo_programatico]);
         */
        ?>
    </td>
</tr>
<tr>
    <td class=style9 align=left colspan=2 width=50%><b>Instrutor:</b></span> <?PHP echo $tr[nome_instrutor];?></td>
    <td class=style9 align=left colspan=2 width=50%><b>Profissão:</b></span> <?PHP echo $tr[profissao_instrutor];?></td>
</tr>
<tr>
    <td class=style9 align=left colspan=2 width=50% valign=top>
        <strong><center>REGIME E CRIT&Eacute;RIOS ADOTADOS</center></strong>
        <p>
        O presente curso cumpriu todas as disposições da lei de diretrizes e base da Educação Nacional nº 9394/96 e Resolução CNE/CE nº 24 de 18/12/2002;
        <p>
        Avaliação formativa e somativa, por disciplina, aferida através de trabalhos, provas e exercícios;
        <p>
        Aproveitamento mínimo de 70% (Setenta por cento);
        <p>
        Freqüência de pelo menos 75% (Setenta e cinco por cento) da carga horária, por disciplina.
    </td>
    <td class=style9 align=left colspan=2 width=50% valign=top>
        <p>
        <strong>
        <center>SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho Ltda</center>
        </strong>
        <p>
        Certificado registrado sob o nº <?PHP echo STR_PAD($tr[numero_certificado], 6, "0",0);?>
        no Livro <?PHP echo romano($tr[livro]);?> da folha <?PHP echo STR_PAD($tr[folha], 2, "0",0);?> no termo
        do disposto no parágrafo 1º do art. 48 da lei 9.393, de 20/12/1996, que
        estabelece as diretrizes e base da Educação Nacional e da Resolução
        CNE/CES nº 24, de 18/12/2000. <BR><p><BR>
        <center>
        Rio de Janeiro, <?PHP echo date("d", strtotime($tr[data_termino]));?> de <?PHP echo $meses[date("n", strtotime($tr[data_termino]))];?> de <?PHP echo date("Y", strtotime($tr[data_termino]));?>
        </center>
    </td>
</tr>
</table>

<!--
<p>

<table width=900 height=582 cellspacing=0 cellpadding=0 border=0>
<tr>
<td width=865 height=580><center>
  <table width="900" border="1" cellspacing=0 cellpadding=0>
    <tr>
      <td width="661" align=center class=style9><b><?PHP echo $curso[curso];?></b></td>
    </tr>
  </table>
  <table width="900" border="1" cellspacing=0 cellpadding=0>
    <tr>
      <td width="432" class=style9><span class="style9">
      <b>ALUNO(ª):</b></span> <?PHP echo $func[nome_func];?></td>
      <td width="165" class=style9>
      <span class="style9"><b>CTPS:</b></span> <?PHP echo $func[num_ctps_func];?>
      <span class="style9"><b>SÉRIE:</b></span> <?PHP echo $func[serie_ctps_func];?></td>
      <td class=style9><span class="style9"><b>Função:</b></span> <?PHP echo $funcao[nome_funcao];?></td>
    </tr>
  </table>
  <table width="900" border="1" cellspacing=0 cellpadding=0>
    <tr>
      <td align=center class=style9>
      <span class="style9">
      <b>HIST&Oacute;RICO</b>
      <p>
      <b>CARGA HOR&Aacute;RIA</b>
      </span>
      </td>
      </tr>
  </table>
  <table width="900" border="1" cellspacing=0 cellpadding=0>
    <tr>
      <td width="833" height="144" valign=top align=justify class=style9>
      <?PHP
         echo "<b>".$curso[descricao]."</b>";
         echo "<p>";
         echo "Carga Horária: $curso[carga_horaria] Horas;";
         echo "<p>";
         echo "Conteúdo Programático:";
         echo "<p>";
         echo nl2br($curso[conteudo_programatico]);
      ?>
      </td>
      </tr>
  </table>
  <table width="900" border="1" cellspacing=0 cellpadding=0>
    <tr>
      <td width="511" class=style9><span class="style9"><b>INSTRUTOR:</b></span> <?PHP echo $tr[nome_instrutor];?></td>
      <td width="306" class=style9><span class="style9"><b>Profissão:</b></span> <?PHP echo $tr[profissao_instrutor];?></td>
    </tr>
  </table>
  <table width="900" border="1" cellspacing=0 cellpadding=0>
    <tr>
      <td width="411" height="292" valign=top class=style9>
      <p><strong><center>REGIME E CRIT&Eacute;RIOS ADOTADOS</center></strong></p>
        O presente curso cumpriu todas as disposições da lei de diretrizes e base da Educação Nacional nº 9394/96 e Resolução CNE/CE nº 24 de 18/12/2002;
        <p>
        Avaliação formativa e somativa, por disciplina, aferida através de trabalhos, provas e exercícios;
        <p>
        Aproveitamento mínimo de 70% (Setenta por cento);
        <p>
        Freqüência de pelo menos 75% (Setenta e cinco por cento) da carga horária, por disciplina
      </td>
      <td width="415" valign=top class=style9>
      <p>
      <strong>
      <center>SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho Ltda</center>
      </strong>
      <p>
      Certificado registrado sob o nº <?PHP echo STR_PAD($tr[numero_certificado], 6, "0",0);?>
      no Livro <?PHP echo romano($tr[livro]);?> da folha <?PHP echo STR_PAD($tr[folha], 2, "0",0);?> nos termo
do disposto no parágrafo 1º do art. 48 da lei 9.393, de 20/12/1996, que
estabelece as diretrizes e base da Educação Nacional e da Resolução
CNE/CES nº 24, de 18/12/2000. <BR><p><BR>
<center>
Rio de Janeiro, <?PHP echo date("d", strtotime($tr[data_termino]));?> de <?PHP echo $meses[date("n", strtotime($tr[data_termino]))];?> de <?PHP echo date("Y", strtotime($tr[data_termino]));?>
</center>
      </td>
    </tr>
  </table>
  </td>
</tr>
</table>

-->
