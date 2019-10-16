<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../sessao.php";
include "config/connect.php";

function cliente_id($email){
include "config/connect.php";
$sql = "SELECT cod_cliente FROM reg_pessoa_juridica WHERE email='{$email}'";
$res = pg_query($sql);
$data = pg_fetch_all($res);
return $data[0]['cod_cliente'];
}

function filial_id($email){
include "config/connect.php";
$sql = "SELECT cod_filial FROM reg_pessoa_juridica WHERE email='{$email}'";
$res = pg_query($sql);
$data = pg_fetch_all($res);
return $data[0]['cod_filial'];
}
?>
<head>
    <link href="include/css/style.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="cipa.js"></script>
</head>
<body>
<?PHP

if($_GET['act'] == "new"){
if($_POST){

$atan = $_POST['d_atan'];
$ord = $_POST['d_ord'];
$anoi = $_POST['d_anoi'];
$anof = $_POST['d_anof'];
$empresa = $_POST['d_empresa'];
$end = $_POST['d_end'];
$num = $_POST['d_num'];
$cidade = $_POST['d_cidade'];
$municipio = $_POST['d_municipio'];
$estado = $_POST['d_estado'];
$dias = $_POST['d_dias'];
$mes = $_POST['d_mes'];
$ano = $_POST['d_ano'];
$hora = $_POST['d_hora'];
$min = $_POST['d_min'];
$sala = $_POST['d_sala'];
$pres = $_POST['d_pres'];
$vice = $_POST['d_vice'];
$svp = $_POST['d_svp'];
$sec = $_POST['d_sec'];
$topic = $_POST['d_titulos'];
$text = $_POST['d_textos'];

$sql = "INSERT INTO site_ata_cipa (d_atan, d_ord, d_anoi, d_anof, d_empresa, d_end, d_num,
d_cidade, d_municipio, d_estado, d_dias, d_mes, d_ano, d_hora, d_min, d_sala, d_pres, d_vice,
d_svp, d_sec, d_titulos, d_textos, cod_cliente, criacao) VALUES
       ('{$atan}','{$ord}','{$anoi}','{$anof}','{$empresa}','{$end}','{$num}','{$cidade}',
       '{$municipio}','{$estado}','{$dias}','{$mes}','{$ano}','{$hora}','{$min}','{$sala}',
       '{$pres}','{$vice}','{$svp}','{$sec}','{$topic}','{$text}', '".$_GET['cod_cliente']."',
       '".date("Y-m-d")."')";
$resul = pg_query($sql);

if($resul){
   $sql = "SELECT MAX(id) as max FROM site_ata_cipa";
   $r = pg_query($sql);
   $b1 = pg_fetch_array($r);

   $sql = "SELECT * FROM site_ata_cipa WHERE id={$b1[max]}";
   $result = pg_query($sql);
   $buffer = pg_fetch_array($result);

   echo "<script>location.href='ata_cipa_index.php';</script>";
}
}else{
   if($_GET['cod_cliente']){
      $sql = "SELECT * FROM cliente WHERE cliente_id={$_GET['cod_cliente']}";
      $result = pg_query($sql);
      $buffer = pg_fetch_array($result);
   }
}



?>
<form name="form1" id="form1" action="ata_cipa_index.php?act=new&cod_cliente=<?PHP echo $_GET['cod_cliente'];?>" method="post">
<table border=0 width=755 height=1122,5 ><tr><td style="vertical-align: top;">
<!-- LOGO -->
    <table border=0 width=755 height=200 align=top style="vertical-align: middle;"><tr>
        <!--MEDIDAS DO PEDRO
        <td width=491 height=189></td><td width=189 height=189 align=center><img src="cipa0.jpg" width=100% height=100%></td>-->
        <td height=200></td>
        <td width=220 height=189>
        <img src="images/cipa0.jpg" width=220 height=189>
        </td>
    </tr></table>
<!-- CORPO -->
    <table border=0 width=755 height=120 align=top><tr>
        <td style="vertical-align: top;">
    <b>
    ATA DA REUNIÃO Nº
    <span id=spanatan OnClick="tTOs('atan', 'spanatan', 4);" onMouseOver="return overlib('Número da ATA.');" onMouseOut="return nd();"><input type=text  class=text name="atan" id="atan" size=4 OnBlur="check('atan', 'spanatan');" onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span><p>
    </b>
    Reunião
    <!--Ordinária-->
    <!--<span id=spanord OnClick="tTOs('ord', 'spanord', 14);" onMouseOver="return overlib('ATA Ordinária ou Extraordinária.');" onMouseOut="return nd();"><input type=text  class=text name="ord" id="ord" size=14 OnBlur="check('ord', 'spanord');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span>
    -->
    <select name="d_ord" id="d_ord" OnBlur=""  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }">
    <option value="Ordinária">Ordinária</option>
    <option value="Extraordinária">Extraordinária</option>
    </select>


    da CIPA Gestão
    <span id=spananoi OnClick="tTOs('anoi', 'spananoi', 4);" onMouseOver="return overlib('Ano de Gestão. Ex.: 2008/2009');" onMouseOut="return nd();"><input type=text  class=text name="anoi" id="anoi" size=4 OnBlur="check('anoi', 'spananoi');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span>/<span id=spananof OnClick="tTOs('anof', 'spananof', 4);"><input type=text  class=text name="anof" id="anof" size=4 OnBlur="check('anof', 'spananof');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span>,
    da empresa
    <b><span id=spanempresa OnClick="tTOs('empresa', 'spanempresa', 40);"><input type=text  class=text name="empresa" id="empresa" size=40 OnBlur="check('empresa', 'spanempresa');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }" value="<?PHP echo $buffer['razao_social'];?>"></span></B>,
    Endereço: <b><span id=spanend OnClick="tTOs('end', 'spanend', 50);"><input type=text  class=text name=end id=end size=50 OnBlur="check('end', 'spanend');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }" value="<?PHP echo $buffer['endereco'];?>"></span></b>,
    Nº <b><span id=spannum OnClick="tTOs('num', 'spannum', 5);"><input type=text  class=text name=num id=num size=5 OnBlur="check('num', 'spannum');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"  value="<?PHP echo $buffer['num_end'];?>"></span></b>
    Cidade: <b><span id=spancidade OnClick="tTOs('cidade', 'spancidade', 5);"><input type=text  class=text name=cidade id=cidade size=5 OnBlur="check('cidade', 'spancidade');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"  value="<?PHP echo $buffer['cidade'];?>"></span></b>
    Municípo: <b><span id=spanmunicipio OnClick="tTOs('municipio', 'spanmunicipio', 15);"><input type=text  class=text name=municipio id=municipio size=15 OnBlur="check('municipio', 'spanmunicipio');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"  value="<?PHP echo $buffer['municipio'];?>"></span></b>
    Estado: <b><span id=spanestado OnClick="tTOs('estado', 'spanestado', 5);"><input type=text  class=text name=estado id=estado size=5 OnBlur="check('estado', 'spanestado');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"  value="<?PHP echo $buffer['estado'];?>"></span></b>
        </td>
    </tr>

    <tr><td>
    Aos dias <b>
    <span id=spandias OnClick="tTOs('dias', 'spandias', 2);" onMouseOver="return overlib('Dia em que se realizou a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=dias id=dias size=2 OnBlur="check('dias', 'spandias');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> de
    <b><span id=spanmes OnClick="tTOs('mes', 'spanmes', 10);" onMouseOver="return overlib('Mes em que se realizou a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=mes id=mes size=10 OnBlur="check('mes', 'spanmes');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> de
    <b><span id=spanano OnClick="tTOs('ano', 'spanano', 5);" onMouseOver="return overlib('Ano em que se realizou a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=ano id=ano size=5 OnBlur="check('ano', 'spanano');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> às
    <b><span id=spanhora OnClick="tTOs('hora', 'spanhora', 2);" onMouseOver="return overlib('Hora em que foi realizada a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=hora id=hora size=2 OnBlur="check('hora', 'spanhora');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>h<b><span id=spanmin OnClick="tTOs('min', 'spanmin', 2);" onMouseOver="return overlib('Mensagem.');" onMouseOut="return nd();"><input type=text  class=text name=min id=min size=2 OnBlur="check('min', 'spanmin');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>min
    na sala de reunião da
    <b><span id=spansala OnClick="tTOs('sala', 'spansala', 30);"><input type=text  class=text name=sala id=sala size=30 OnChange="check('sala', 'spansala');"></span></b>
    realizou-se a reunião de nº&nbsp;<span id=n></span>&nbsp;com a presença dos Srs.
    <b><span id=spanpres OnClick="tTOs('pres', 'spanpres', 30);" onMouseOver="return overlib('Presidente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=pres id=pres size=30 OnBlur="check('pres', 'spanpres');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Presidente da CIPA;
    <b><span id=spansuplente OnClick="tTOs('suplente', 'spansuplente', 30);" onMouseOver="return overlib('Suplente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=suplente id=suplente size=30 OnBlur="check('suplente', 'spansuplente');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Suplente da CIPA;
    <b><span id=spanvice OnClick="tTOs('vice', 'spanvice', 30);" onMouseOver="return overlib('Vice Presidente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=vice id=vice size=30 OnBlur="check('vice', 'spanvice');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Vice Presidente da CIPA;
    <b><span id=spansvp OnClick="tTOs('svp', 'spansvp', 30);" onMouseOver="return overlib('Suplente Vice-Presidente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=svp id=svp size=30 OnBlur="check('svp', 'spansvp');"   onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Suplente Vice - Presidente;
    <b><span id=spansec OnClick="tTOs('sec', 'spansec', 30);" onMouseOver="return overlib('Secretária da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=sec id=sec size=30 OnBlur="check('sec', 'spansec');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Secretária da CIPA.
    </td></tr>

<!--
    <tr><td>
    <br>
    <div class=title1>Acidente de trabalho</div>
    </td></tr>
    <tr><td>
        <div id=spanacidente OnClick="tTOa('acidente', 'spanacidente', 10);">
        <textarea name=acidente id=acidente cols=100% rows=10 OnChange="check('acidente', 'spanacidente');"></textarea>
        </div>
    </td></tr>


    <tr><td>
    <br>
    <div class=title1>Medidas de Segurança Sugeridas</div>
    </td></tr>
    <tr><td>
        <div id=spansug OnClick="tTOa('sug', 'spansug', 10);">
        <textarea name=sug id=sug cols=100% rows=10 OnChange="check('sug', 'spansug');"></textarea>
        </div>
    </td></tr>
-->
    <tr><td id="tdelements" >
    <br> <center>
   <!--     <div id="elements" align=center>
        </div>
        <br>-->

    </td></tr>


    <tr><td align=center>
    <br>
    <div id="finalizar" class=title1>
       <input class=button type="button" name="cria" id="cria" value="Adicionar Tópico" OnClick="addTopic();"> <input class=button type="button" name="finish" id="finish" value="Finalizar" OnClick="Finish();">
    </div>
    </td></tr>


    <!-- FINALIZAR -->
    <tr><td> <br>
     Nada mais havendo a relatar ou discutir o Sr. Presidente deu por encerrada a reunião,
     sendo lavrada a presente Ata, que após discutida e aprovada passa a ser assinada pelos
     membros representantes.
    </td></tr>

    <tr><td> <br> <br>
        <table border=0 align=center width=755>
        <tr>
           <td><center>________________________<br>Presidente - CIPA</td>
           <td><center>________________________<br>Vice - Presidente - CIPA</td>
           <td><center>________________________<br>1º Secretária da CIPA</td>
        </tr>
        </table><br><br><br><br>
        <table border=0 align=center width=755>
        <tr>
           <td><center>________________________<br>Suplente do Pres.</td>
           <td><center>________________________<br>Suplente do Vice - Pres.</td>
        </tr>
        </table>
        <br><br><br><br>
        <table border=0 align=center width=755>
        <tr>
           <td>
           <div id="tosend" align=center></div>
           </td>
        </tr>
        </table>
    </td></tr>

</table>
<!-- /CORPO -->

</td></tr></table>

<!--<input type=hidden name=send_ata id=send_ata value="">
<input type=hidden name=data[] id=data value="">          -->

<input type=hidden name=d_atan id=d_atan  value="">
<!--<input type=hidden name=d_ord id=d_ord  value="">-->
<input type=hidden name=d_anoi id=d_anoi  value="">
<input type=hidden name=d_anof id=d_anof  value="">
<input type=hidden name=d_empresa id=d_empresa  value="">
<input type=hidden name=d_end id=d_end  value="">
<input type=hidden name=d_num id=d_num  value="">
<input type=hidden name=d_cidade id=d_cidade  value="">
<input type=hidden name=d_municipio id=d_municipio  value="">
<input type=hidden name=d_estado id=d_estado  value="">
<input type=hidden name=d_dias id=d_dias  value="">
<input type=hidden name=d_mes id=d_mes  value="">
<input type=hidden name=d_ano id=d_ano  value="">
<input type=hidden name=d_hora id=d_hora  value="">
<input type=hidden name=d_min id=d_min  value="">
<input type=hidden name=d_sala id=d_sala  value="">
<input type=hidden name=d_pres id=d_pres  value="">
<input type=hidden name=d_vice id=d_vice  value="">
<input type=hidden name=d_svp id=d_svp  value="">
<input type=hidden name=d_sec id=d_sec  value="">
<input type=hidden name=d_titulos id=d_titulos  value="">
<input type=hidden name=d_textos id=d_textos  value="">
</form>

<?PHP
}else{

if($_GET['act'] == "del"){
   $sql = "DELETE FROM site_ata_cipa WHERE id = '{$_GET['id']}'";
   $result = pg_query($sql);
}

echo '
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIAÇÃO DE ATA DA CIPA<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
               <input name="btn_sair" type="button" id="btn_sair" onClick="location.href=\'tela_principal.php\';" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="7" class="linhatopodiresq">
<!--	  <form action="lista_orcamento.php" method="post" enctype="multipart/form-data" name="form1">-->
	  <br>
';

echo "
      <center>
      <!--
      <input type=button value='Nova Ata da Cipa' class=button onclick=\"location.href='?page=cliente&p=cipa_ata&act=new'\">
      -->
      ";

      echo '
      <table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente();">
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente();" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
      </table>

     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
     
     	 </td>
    </tr>
     ';
echo '
   <tr>
    <th colspan="7" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Atas Geradas</h3>
   <br>
    </th>
  </tr>
  
  <tr><td>
  ';


      echo "<p>";
      echo "<Table width=100% border=1 cellspacing=1 cellpading=1>
      <tr>
      <td align=center width=20><b>Cod.</b></td>
      <td align=center width=70><b>Nº ATA</b></td>
      <td align=center ><b>Empresa</b></td>
      <td align=center width=100><b>Criado em</b></td>
      <td align=center width=170><b>Ações</b></td>
      </tr> ";

      $sql = "SELECT * FROM site_ata_cipa";
      $result = pg_query($sql);
      $buffer = pg_fetch_all($result);

      for($x=0;$x<pg_num_rows($result);$x++){
         echo "<tr>";
         echo "   <td class=fontebranca12>".STR_PAD($buffer[$x]['id'], 4, "0", STR_PAD_LEFT)."</td>";
         echo "   <td class=fontebranca12>{$buffer[$x]['d_atan']}</td>";
         echo "   <td class=fontebranca12><b>{$buffer[$x]['d_empresa']}</b></td>";
         echo "   <td class=fontebranca12 align=center>".date("d/m/Y", strtotime($buffer[$x]['criacao']))."</td>";
         echo "   <td align=center class=fontebranca12><a href='http://sesmt-rio.com/print_ata_cipa.php?act=view&id={$buffer[$x]['id']}' target=_blank class=fontebranca12>Visualizar</a> | <a href='?page=cliente&p=cipa_ata&act=del&id={$buffer[$x]['id']}' onclick=\"return confirm('Tem certeza que deseja excluir este item?')\" class=excluir>Excluir</a></td>";
         echo "</tr>";
      }

    echo "</table>";
    
    echo '</td></tr>

      <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
  
    </table>';

}
?>
</body>
