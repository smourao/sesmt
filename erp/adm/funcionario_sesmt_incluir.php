<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/funcoes.php";

$cod_vendedor = rand(1000,9999);

ob_start();
if($nome!=""){
$query_incluir="INSERT into funcionario (funcionario_id, cargo_id, associada_id, grupo_id, nome, cpf, ctps, telefone, celular, email, msn, skype, assinatura, cod_vendedor, registro)
				values ($funcionario_id, $cargo_id, $associada_id, $grupo_id, '$nome', '$cpf', '$ctps', '$telefone', '$celular', '$email', '$msn', '$skype', '$assinatura', $cod_vendedor, '$registromtb')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

$query_funcionario = "select funcionario_id from funcionario where nome='$nome' and cpf='$cpf'";
$result_funcionario = pg_query($query_funcionario) or die("Erro na consulta".pg_last_error($connect));
$row_funcionario=pg_fetch_array($result_funcionario);

$query_incluir_usuario="INSERT into usuario (usuario_id, funcionario_id, grupo_id, login, senha) values ($row_funcionario[funcionario_id], $row_funcionario[funcionario_id], $grupo_id, '$login', '$senha')";
pg_query($query_incluir_usuario) or die ("Erro na query:$query_incluir_usuario".pg_last_error($connect));

echo"<script>alert('Funcionário Incluído com Sucesso!');</script>";
header("location: funcionario_sesmt_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</header>
<title>Cadastrar Funcio&aacute;rio SESMT</title><body bgcolor="#006633">
<form action="funcionario_sesmt_incluir.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Funcionario SESMT </font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12">
          <?php
			$query_max = "SELECT max(funcionario_id) as funcionario_id FROM funcionario";
			
			$result_max = pg_query($query_max) or die
					("Erro na busca da tabela funcionario!" . pg_last_error($connect));
					
			$row_max = pg_fetch_array($result_max);
		?>
		</td>
		</tr>
		<tr>
			<td width="97" class="fontebranca12">Código</td>
			<td width="303"><input name="funcionario_id" type="text" id="funcionario_id" size="5" value="<?php echo ($row_max[funcionario_id] + 1)?>" 
			readonly="true"></td>
		</tr>
		<tr>
			<td width="97" class="fontebranca12">Nome </td>
			<td width="303"><input name="nome" type="text" id="nome" size="40"></td>
		</tr>
		<tr>
			<td class="fontebranca12">CPF</td>
			<td><input name="cpf" type="text" id="cpf" size="15"></td>
		</tr>
		<tr>
			<td width="97" class="fontebranca12">CTPS</td>
			<td width="303"><input name="ctps" type="text" id="ctps" size="15"></td>
		</tr>
		<tr>
			<td width="97" class="fontebranca12">Registro MTB</td>
			<td width="303"><input name="registromtb" type="text" id="registromtb" size="15"></td>
		</tr>
		<tr>
			<td class="fontebranca12">Telefone</td>
			<td><input name="telefone" type="text" id="telefone" size="15"></td>
		</tr>
		<tr>
			<td width="97" class="fontebranca12">Celular</td>
			<td width="303"><input name="celular" type="text" id="celular" size="15"></td>
		</tr>
		<tr>
			<td class="fontebranca12">Email</td>
			<td><input name="email" type="text" id="email" size="30"></td>
		</tr>
		<tr>
			<td width="97" class="fontebranca12">MSN </td>
			<td width="303"><input name="msn" type="text" id="msn" size="30"></td>
		</tr>
		<tr>
			<td class="fontebranca12">Skype</td>
			<td><input name="skype" type="text" id="skype" size="30"></td>
		</tr>
		<tr>
			<td class="fontebranca12">Assinatura</td>
			<td><input name="assinatura" type="file" id="assinatura"></td>
		</tr>
		<tr>
			<td class="fontebranca12">Login</td>
			<td><input name="login" type="text" id="login"></td>
		</tr>
		<tr>
			<td class="fontebranca12">Senha</td>
			<td><input name="senha" type="password" id="senha"></td>
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
			?>
			<option value="<?php echo $row_cargo[cargo_id]?>"><?php echo $row_cargo[nome]?></option>
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
			 ?>
			<option value="<?php echo $row_associada[associada_id]?>"><?php echo $row_associada[nome]?></option>
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
			 ?>
			<option value="<?php echo $row_grupo[grupo_id]?>"><?php echo $row_grupo[nome]?></option>
			<?php
			}
			?>
			</select></td>
		</tr> 
	</table><br>
	<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td class="fontebranca12"><input type="submit" name="Submit" value="Incluir"></td>
			<td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','funcionario_sesmt_adm.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></td>
		</tr>
	</table>   
</form>
</html>
