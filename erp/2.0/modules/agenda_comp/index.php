<?PHP
/*
$a = "SELECT * FROM gmensagem";
$aa = pg_query($a);
$aaa = pg_fetch_all($aa);
echo "<table>";
for($q=1;$q<140;$q++){
	if($aaa[$q][mensagem] != $aaa[$q-1][mensagem]){
		echo "<tr>";
		echo "<td>".$aaa[$q][setor]."</td>";
		echo "<td>".$aaa[$q][titulo]."</td>";
		echo "<td>".$aaa[$q][mensagem]."</td>";
		echo "<td>".$aaa[$q][data]."</td>";
		echo "</tr>";
	}
}
echo "</table>";
*/
echo "<script language='JavaScript'>
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
</script>";

		if($_GET[del]){
			$sql = "DELETE FROM agenda_comp WHERE id = $_GET[del]";
			$query = pg_query($sql);
			$del=$_GET[del];
		}else{
			$del=0;
		}


$usu = $_SESSION[usuario_id];
$hoje = date("Y-m-d");

$sql_jur = "SELECT * FROM agenda_comp WHERE empresa <> '' AND id <> $del";
$query_jur = @pg_query($sql_jur);
$array_jur = @pg_fetch_all($query_jur);

$sql_soc = "SELECT * FROM agenda_comp WHERE tipo <> '' AND id <> $del";
$query_soc = @pg_query($sql_soc);
$array_soc = @pg_fetch_all($query_soc);

$mod	= $_GET[mod];

$empresa	= $_POST[empresa];
$tel		= $_POST[tel];
$evento		= $_POST[evento];
$email		= $_POST[email];
$data1		= $_POST[data].'/2013';
if($_POST[horario]){
	$horario=$_POST[horario].':01';
}else{
	$horario='08:01:01';
} 
$texto		= $_POST[texto];
if(!$texto){
	$texto=' ';
} 
$tel_		= $_POST[tel_];
$tipo		= $_POST[tipo];
$evento_	= $_POST[evento_];
$email_		= $_POST[email_];
$data1_		= $_POST[data_].'/2013';
if($_POST[horario]){
	$horario_=$_POST[horario_].':01';
}else{
	$horario_='08:01:01';
} 
$texto_		= $_POST[texto_];
if(!$texto_){
	$texto_=' ';
} 

if($empresa!='' && $evento!='' && $email!='' && $data!=''){
	$partes = explode('/',$data1);
	$data = $partes[2].'-'.$partes[1].'-'.$partes[0];
	$sql = "INSERT INTO agenda_comp (empresa, evento, email, data, horario, texto, tel)
			VALUES('$empresa', '$evento', '$email', '$data', '$horario', '$texto', '$tel')";
	if(pg_query($sql)){
	   showMessage('<p align=justify>Agendado com sucesso!</p>');
	}else{
		showMessage('<p align=justify>Erro no agendamento. Preencha os campos corretamente e tente novamente.</p>');
	}
}elseif($empresa && !$tipo){
	showMessage('<p align=justify>Erro no agendamento. Preencha os campos corretamente e tente novamente.</p>');
}
if($tipo!='' && $evento_!='' && $email_!='' && $data_!=''){
	$partes = explode('/',$data1_);
	$data_ = $partes[2].'-'.$partes[1].'-'.$partes[0];
	$sql = "INSERT INTO agenda_comp (tipo, evento, email, data, horario, texto, tel)
			VALUES ('$tipo', '$evento_', '$email_', '$data_', '$horario_', '$texto_', '$tel_')";
	if(pg_query($sql)){
	   showMessage('<p align=justify>Agendado com sucesso!</p>');
	}else{
		showMessage('<p align=justify>Erro no agendamento. Preencha os campos corretamente e tente novamente.</p>');
	}
}elseif($tipo && !$empresa){
	showMessage('<p align=justify>Erro no agendamento. Preencha os campos corretamente e tente novamente.</p>');
}
echo '<form id="form1" name="form1" method="post" action="?dir=agenda_comp&p=index&mod='.$_GET[mod].'">';
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
echo "<td width=250 class='text roundborder' valign=top>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td height=13 align=center class='text roundborderselected'>Opções";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
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
	
	echo "<table width=100% border=0 cellpadding=2 cellspacing=2>";
	echo "<tr>";
	echo "<td width=50% class=text align=center >
	<center>
	<table width=100% border=0 cellpadding=2 cellspacing=2><tr><td width=50% class='text roundborderselected' align=center >
	<table width=\"100%\" border=\"0\"><tr>
	<td width='10%' align=center ></td>
	<td width='15%' align=center >
	<a href=\"?dir=agenda_comp&p=index&mod=1\">";
	if($mod==1){
	echo "<font size=3><u>Social</u></font>";
	}else{
	echo "Social";
	}
	echo "</a>&nbsp;
	</td>
	<td width='15%' align=center >
	<a href=\"?dir=agenda_comp&p=index&mod=2\">";
	if($mod==2){
	echo "<font size=3><u>Jurídico</u></font>";
	}else{
	echo "Jurídico";
	}
	echo "</a>&nbsp;
	</td>
	<td width='10%' align=center ></td>
	</tr></table>
	</td></tr></table>
	</center>";
	if($mod==1){
	echo "
	<div id=\"pessoal\">
	
	<table width=\"50%\" border=\"0\" align=left>
		<tr>
			<td align=\"center\" class='text roundborder' width='15%'><b>Data</b>
			</td>
			<td align=\"center\" class='text roundborder' width='70%'><b>Título</b>
			</td>
			<td align=\"center\" class='text roundborder' width='15%'><b>Ação</b>
			</td>
			";
			
	for($x=0;$x<pg_num_rows($query_soc);$x++){
		
			$partes1 = explode('-',$array_soc[$x][data]);
			$data1 = $partes1[2].'/'.$partes1[1];
	
		echo "<tr>
				<td align=\"center\" class='text roundborder' width='15%'>".$data1."
				</td>
				<td align=\"center\" class='text roundborder' width='70%'>".$array_soc[$x][evento]."
				</td>
				<td class='text curhand roundbordermix' align=\"center\" width='15%' onclick=\"location.href='?dir=agenda_comp&p=index&mod=1&del=".$array_soc[$x][id]."';\">Excluir
				</td>
			</tr>";
	}	
	
		echo"</tr>
	</table>
	
	<table width=\"50%\" border=\"0\" align=right>
		<tr>
			<td align=\"center\" class='text roundborder'><br>";
echo '
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <label>
    <input type="radio" name="tipo" id="evento" value="evento"  />
    Evento</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
  <label>
    <input type="radio" name="tipo" id="comemorativa" value="comemorativa" />
    Data Comemorativa</label>
<p>
<table width="100%" border="0">
    <tr>
      <td width="10%"><label>Evento:</label></td>
      <td width="40%"><input type="text" name="evento_" id="evento" class="inputTextobr" size=40 /></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><label>
        <input type="text" name="email_" id="email" class="inputTextobr" size=40/></label></td>
    </tr>
    <tr>
      <td>Data:</td>
      <td><input type="text" name="data_" id="data" class="inputTextobr" size=10 maxlength=5 onkeypress="formatar(this, \'##/##\');" onkeydown="return SomenteNumero(event)"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horário:&nbsp;&nbsp;&nbsp;<input type="text" name="horario_" id="horario_" size=7 maxlength=5 onkeypress="formatar(this, \'##:##\');" onkeydown="return SomenteNumero(event)" /></td>
    </tr>
    <tr>
      <td>Tel.:</td>
      <td colspan="3" valign="top"><input size=10 type="text" name="tel_" id="tel_"  onkeypress="formatar(this, \'## ####-####\');" maxlength=12/></td>
    </tr>
    <tr>
      <td valign="top">Texto:</td>
      <td colspan="3" valign="top"><textarea name="texto_" rows="7" id="texto" class="inputText" cols="31"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center" height=50><label>
        <input type="submit" name="enviar" id="enviar" value="Enviar" class="btn" />
      </label></td>
    </tr>
  </table>';
}
if($mod==2){
	echo "	</td></tr>
	</table>
	</div>
	<div id=\"comercial\">
	
	<table width=\"50%\" border=\"0\" align=left>
		<tr>
			<td align=\"center\" class='text roundborder' width='15%'><b>Data</b>
			</td>
			<td align=\"center\" class='text roundborder' width='70%'><b>Título</b>
			</td>
			<td align=\"center\" class='text roundborder' width='15%'><b>Ação</b>
			</td>
		</tr>";
	
	for($x=0;$x<pg_num_rows($query_jur);$x++){
			$partes2 = explode('-',$array_jur[$x][data]);
			$data2 = $partes2[2].'/'.$partes2[1];
		
		echo "<tr>
				<td align=\"center\" class='text roundborder' width='15%'>".$data2."
				</td>
				<td align=\"center\" class='text roundborder' width='70%'>".$array_jur[$x][evento]."
				</td>
				<td class='text curhand roundbordermix' align=\"center\" width='15%' onclick=\"location.href='?dir=agenda_comp&p=index&mod=2&del=".$array_jur[$x][id]."';\">Excluir
			</td>
			</tr>";
	}	
		
	echo "</table>
	
	<table width=\"50%\" border=\"0\" align=right>
		<tr>
			<td align=\"center\" class='text roundborder'><br>";
			
echo '
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <label>
    <input type="radio" name="empresa" id="sesmt" value="sesmt" />
    Sesmt</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
  <label>
    <input type="radio" name="empresa" id="tiseg" value="tiseg" />
    Ti-Seg</label>
<p>
<table width="100%" border="0">
    <tr>
      <td width="10%"><label>Evento:</label></td>
      <td width="40%"><input type="text" name="evento" class="inputTextobr" id="evento"  size=40/></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><label>
        <input type="text" name="email" id="email" class="inputTextobr" size=40/>
      </label></td>
    </tr>
    <tr>
      <td>Data:</td>
      <td><input type="text" name="data" id="data" class="inputTextobr" size=10 maxlength=5 onkeypress="formatar(this, \'##/##\');" onkeydown="return SomenteNumero(event)"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horário:&nbsp;&nbsp;&nbsp;<input type="text" name="horario" id="horario" size=7 maxlength=5 onkeypress="formatar(this, \'##:##\');" onkeydown="return SomenteNumero(event)"/></td>
    </tr>
    <tr>
      <td>Tel.:</td>
      <td colspan="3" valign="top"><input size=10 type="text" name="tel" id="tel"  onkeypress="formatar(this, \'## ####-####\');" maxlength=12/></td>
    </tr>
    <tr>
      <td valign="top">Texto:</td>
      <td colspan="3" valign="top"><textarea name="texto" rows="7" id="texto" class="inputText" cols="31"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center" height=50><label>
        <input type="submit" name="enviar" id="enviar" value="Enviar" class="btn" />
      </label></td>
    </tr>
  </table>';
}

	echo "</td>
		</tr>
	</table>
	</div>
	</td>";
	
    echo "</tr>";
	echo '</table>';
	
	
echo "</td>";
echo "</tr>";
echo "</table></form>";

?>