<?php
include "../sessao.php";
include "../config/connect.php";

ob_start();
if($alterar!=""){
$query_alterar="update funcionario set cargo_id=".$cargo_id.", associada_id=".$associada_id.", grupo_id=".$grupo_id.", nome='$nome', cpf='$cpf', ctps='$ctps', telefone='$telefone', celular='$celular', email='$email', msn='$msn', skype='$skype', assinatura='$assinatura' where funcionario_id=".$id."";
pg_query($query_alterar) or die ("Erro na query:$query_alterar".pg_last_error($connect));

$query_alterar_usuario="update usuario SET grupo_id=".$grupo_id.", login='$login', senha='$senha' where funcionario_id=".$id."";
pg_query($query_alterar_usuario) or die ("Erro na query:$query_alterar_usuario".pg_last_error($connect));

echo"<script>alert('Funcionário Alterado com Sucesso!');</script>";
}

$query="select * from funcionario where funcionario_id=".$id.$funcionario_id[0]."";
$result=pg_query($query)or die("Erro na query $query".pg_last_error($connect));
$row=pg_fetch_array($result);

$query_usuario="select * from usuario where funcionario_id=".$id.$funcionario_id[0]."";
$result_usuario=pg_query($query_usuario)or die("Erro na query $query_usuario".pg_last_error($connect));
$row_usuario=pg_fetch_array($result_usuario);

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>


<title>Alterar Funcionário</title><body bgcolor="#006633">
<form action="funcionario_sesmt_alterar.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Funcionario SESMT </font></div></td>
    </tr>
	<tr>
		<td width="97" class="fontebranca12">Nome </td>
		<td width="303"><input name="nome" type="text" id="nome" value="<?=$row[nome]?>" size="40"></td>
	</tr>
	<tr>
		<td class="fontebranca12">CPF</td>
		<td><input name="cpf" type="text" id="cpf" value="<?=$row[cpf]?>" size="15">
		<input name="id" type="hidden" id="id" value="<?=$row[funcionario_id]?>">
		<input name="alterar" type="hidden" id="alterar" value="1"></td>
	</tr>
	<tr>
		<td width="97" class="fontebranca12">CTPS</td>
		<td width="303"><input name="ctps" type="text" id="ctps" value="<?=$row[ctps]?>" size="15"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Telefone</td>
		<td><input name="telefone" type="text" id="telefone" value="<?=$row[telefone]?>" size="15"></td>
	</tr>
	<tr>
		<td width="97" class="fontebranca12">Celular</td>
		<td width="303"><input name="celular" type="text" id="celular" value="<?=$row[celular]?>" size="15"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Email</td>
		<td><input name="email" type="text" id="email" value="<?=$row[email]?>" size="30"></td>
	</tr>
	<tr>
		<td width="97" class="fontebranca12">MSN </td>
		<td width="303"><input name="msn" type="text" id="msn" value="<?=$row[msn]?>" size="30"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Skype</td>
		<td><input name="skype" type="text" id="skype" value="<?=$row[skype]?>" size="30"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Assinatura</td>
		<td><input name="assinatura" type="file" id="assinatura"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Login</td>
		<td><input name="login" type="text" id="login" value="<?=$row_usuario[login]?>"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Senha</td>
		<td><input name="senha" type="password" id="senha" value="<?=$row_usuario[senha]?>"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Cargo</td>
		<td>
		<select name="cargo_id" class="camposform" id="cargo_id">
		 <option value="NULL">Cargo</option>
		 <?php
		$query_cargo="select * from cargo";
		$result_cargo=pg_query($query_cargo) or die("Erro na query: $query_cargo".pg_last_error($connect));
		while($row_cargo=pg_fetch_array($result_cargo)){ 
		if($row_cargo[cargo_id]==$row[cargo_id]){$selected="selected";}else{$selected="";}
		?>
		<option value="<?=$row_cargo[cargo_id]?>"<?=$selected?>><?=$row_cargo[nome]?></option>
		<?php
		}
		?>
		</select></td>
	</tr>
	<tr>
		<td class="fontebranca12">Associada</td>
		<td>
		<select name="associada_id" class="camposform" id="associada_id">
		 <option value="NULL">Associada</option>
		<?php
		$query_associada="select * from associada";
		$result_associada=pg_query($query_associada) or die("Erro na query: $query_associada".pg_last_error($connect));
		while($row_associada=pg_fetch_array($result_associada)){ 
		if($row_associada[associada_id]==$row[associada_id]){$selected2="selected";}else{$selected2="";}
		 ?>
		<option value="<?=$row_associada[associada_id]?>" <?=$selected2?>><?=$row_associada[nome]?></option>
		<?php
		}
		?>
		</select></td>
	</tr>
	<tr>
		<td class="fontebranca12">Grupo</td>
		<td><select name="grupo_id" class="camposform" id="grupo_id">
		 <option value="NULL">Grupo</option>
		<?php
		$query_grupo="select * from grupo";
		$result_grupo=pg_query($query_grupo) or die("Erro na query: $query_grupo".pg_last_error($connect));
		while($row_grupo=pg_fetch_array($result_grupo)){ 
		if($row_grupo[grupo_id]==$row_usuario[grupo_id]){$selected3="selected";}else{$selected3="";}
		 ?>
		<option value="<?=$row_grupo[grupo_id]?>" <?=$selected3?>><?=$row_grupo[nome]?></option>
		<?php
		}
		?>
		</select></td>
	</tr>
	</table><br>
	<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="submit" name="Submit" value="Alterar">
	<input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','funcionario_sesmt_adm.php');return document.MM_returnValue" value="Sair"></td>
	</tr>
      </table></td>
</form>
</html>