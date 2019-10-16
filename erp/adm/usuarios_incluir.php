<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($login!=""){
$query_incluir="INSERT into usuario (usuario_id, funcionario_id, contato_id, funcionario_cliente_id, grupo_id, contador_id, associada_id, login, senha) values ($usuario_id, $funcionario_id, $contato_id, $funcionario_cliente_id, $grupo_id, $contador_id, $associada_id, '$login', '$senha')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('Usuario Incluído com Sucesso!');</script>";
header("location: usuarios_adm.php");
}

?>
<html>	
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</header>
<title>Cadastro de Usu&aacute;rio</title><body bgcolor="#006633">
<form name="form1" method="post" action="">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Usu&aacute;rios</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <?
			$query_max = "SELECT max(usuario_id) as usuario_id FROM usuario";
			
			$result_max = pg_query($query_max) or die
					("Erro na busca da tabela usuario!" . pg_last_error($connect));
					
			$row_max = pg_fetch_array($result_max);
		?>
		  <tr>
            <td width="97" class="fontebranca12">Código</td>
            <td width="303"><input name="usuario_id" type="text" id="usuario_id" size="5" value="<?=($row_max[usuario_id] + 1)?>" 
			readonly="true"></td>
          </tr>
		  <tr>
            <td width="97" class="fontebranca12">Login</td>
            <td width="303"><input name="login" type="text" id="login" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Senha</td>
            <td><input name="senha" type="text" id="senha" size="10"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Contato</td>
            <td><select name="contato_id" class="camposform" id="contato_id">
			<option value="NULL">Contato</option>
			<?php
			$query_contato="select * from contato";
			$result_contato=pg_query($query_contato) or die("Erro na query: $query_contato".pg_last_error($connect));
			while($row_contato=pg_fetch_array($result_contato)){ 
			 ?>
			<option value="<?=$row_contato[contato_id]?>"><?=$row_contato[nome]?></option>
			<?php
			}
			?>
            </select>            </td>
          </tr>
          <tr>
            <td class="fontebranca12">Funcionario</td>
            <td>
			<select name="funcionario_cliente_id" class="camposform" id="funcionario_cliente_id">
             <option value="NULL">Funcionário</option>
			 <?php
			$query_funcionario_cliente="select * from funcionario_cliente";
			$result_funcionario_cliente=pg_query($query_funcionario_cliente) or die("Erro na query: $query_funcionario_cliente".pg_last_error($connect));
			while($row_funcionario_cliente=pg_fetch_array($result_funcionario_cliente)){ 
			?>
			<option value="<?=$row_funcionario_cliente[funcionario_cliente_id]?>"><?=$row_funcionario_cliente[nome]?></option>
			<?php
			}
			?>
			</select>
			</td>
          </tr>
          <tr>
            <td class="fontebranca12">Contador</td>
            <td>
			<select name="contador_id" class="camposform" id="contador_id">
			 <option value="NULL">Contador</option>
			<?php
			$query_contador="select * from contador";
			$result_contador=pg_query($query_contador) or die("Erro na query: $query_contador".pg_last_error($connect));
			while($row_contador=pg_fetch_array($result_contador)){ 
			 ?>
			<option value="<?=$row_contador[contador_id]?>"><?=$row_contador[nome]?></option>
			<?php
			}
			?>
                        </select></td>
          </tr>
          <tr>
            <td class="fontebranca12">Associada</td>
            <td><select name="associada_id" class="camposform" id="associada_id">
			 <option value="NULL">Associada</option>
						<?php
			$query_associada="select * from associada";
			$result_associada=pg_query($query_associada) or die("Erro na query: $query_associada".pg_last_error($connect));
			while($row_contador=pg_fetch_array($result_associada)){ 
			 ?>
			<option value="<?=$row_contador[associada_id]?>"><?=$row_associada[nome]?></option>
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
			<option value="<?=$row_grupo[grupo_id]?>"><?=$row_grupo[nome]?></option>
			<?php
			}
			?>
                        </select></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
			<td colspan="4" class="fontebranca12"><br>
			<table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr>
            <td class="fontebranca12"><input type="submit" name="Submit" value="Incluir"></td>
			<td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick=			 "MM_goToURL('parent','usuarios_adm.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></td>
		  </tr>
		  </table>
		  </td></tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

