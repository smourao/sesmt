<?PHP
if($_GET[action] == "del"){
    $sql = "DELETE FROM erp_simulador_message WHERE id = ".(int)($_GET[sp]);
    if(@pg_query($sql)){
		showMessage('<p align=justify>Mensagem de atendimento deletado com sucesso!</p>', 0);
    }else{
		showMessage('<p align=justify>Erro ao deletar mensagem de atendimento!</p>', 2);
    }
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
		// OPÇÕES DO CLIENTE
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Opções</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
	
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Res. Contrato'  onmouseover=\"showtip('tipbox', '- Resumo de Contrato, exibe um resumo das cláusulas do contrato deste cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Funcionarios' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Funcionários, exibe a lista de funcionários da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr><tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Certificado'  onmouseover=\"showtip('tipbox', '- Certificado, exibe o certificado da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Localizar'  onmouseover=\"showtip('tipbox', '- Localizar, permite que seja executada uma busca por outros clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr><tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Mapa' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=mapa';\" onmouseover=\"showtip('tipbox', '- Mapa, exibe um mapa com a localização da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr><tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Relat. Atend.' onclick=\"location.href='?dir=cad_cliente&p=rel_atendimento&cod_cliente=$_GET[cod_cliente]';\"  onmouseover=\"showtip('tipbox', '- Relatório, permite o cadastro de relacionamento com o cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				//echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Mapa' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=mapa';\" onmouseover=\"showtip('tipbox', '- Mapa, exibe um mapa com a localização da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<P>";
	
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
		echo "<form method=post name=form1>";	
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		
		$sql = "SELECT * FROM cliente WHERE cliente_id = '{$cod_cliente}'";
		$result = pg_query($sql);
		$buffer = pg_fetch_array($result);
		
		if($_POST[btnSave]){
			$sql = "SELECT * FROM erp_simulador_message WHERE simulador_id = '{$cod_cliente}'";
			$r = pg_query($sql);
		
			if(pg_num_rows($r)>!0){
			
			   $sql = "UPDATE erp_simulador_message SET
			   titulo		  	  ='{$titulo}',
			   mensagem			  ='{$mensagem}',
			   data_modificacao   = '".date("Y-m-d")."'
			   WHERE simulador_id = '{$cod_cliente}'";
			   $act = pg_query($sql);
			   if($act){
				  showMessage('<p align=justify>Mensagem atualizada com sucesso.</p>');
				  makelog($_SESSION[usuario_id], 'Atualização de mensagem de atendimento, '.$_GET[cod_cliente].' - '.$_POST[razao_social], 203);
			  }else{
				  makelog($_SESSION[usuario_id], 'Erro ao atualizar mensagem de atendimento, '.$buffer[cliente_id].' - '.$_POST[razao_social], 204);
				  showMessage('<p align=justify>Não foi possível atualizar este cadastro. Por favor, verifique se todos os campos obrigatórios foram preenchidos corretamente.<BR>Em caso de dúvidas, entre em contato com o setor de suporte!</p>', 1);
			  }
			}else{
			   $sql = "INSERT INTO erp_simulador_message
			   (razao_social, simulador_id, titulo, mensagem, data_criacao, data_modificacao)
			   VALUES
			   ('{$buffer[razao_social]}', '{$cod_cliente}', '{$titulo}', '{$mensagem}', '".date("Y-m-d")."', '".date("Y-m-d")."')";
			   $act = pg_query($sql);
			   if($act){
			   	   showMessage('<p align=justify>Mensagem cadastra com sucesso.</p>');
          	       makelog($_SESSION[usuario_id], 'Novo cadastro de mensagem de atendimento, '.$buffer[cliente_id].' - '.$_POST[razao_social], 201);
			   }else{
				   makelog($_SESSION[usuario_id], 'Erro ao cadastrar mensagem de atendimento, '.$buffer[cliente_id].' - '.$_POST[razao_social], 202);
				   showMessage('<p align=justify>Não foi possível realizar este cadastro. Por favor, verifique se todos os campos obrigatórios foram preenchidos corretamente.<BR>Em caso de dúvidas, entre em contato com o setor de suporte!</p>', 1);
			   }
			}
		}
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'><b>Mensagem de Atendimento</b></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<p>";
		
		$sql = "SELECT * FROM erp_simulador_message WHERE simulador_id = {$cod_cliente}";
        $resul = pg_query($sql);
        $row = pg_fetch_array($resul);
		
		if($_GET[sp]){ 
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td width=30 class=text><b>Título</b></td>";
			echo "<td><input type=text name=titulo id=titulo value='{$row[titulo]}'></td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td width=30 class=text><b>Comentário</b></td>";
			echo "<td><textarea name=mensagem id=mensagem style='width:98%;' rows='6'>{$row[mensagem]}</textarea></td>";
			echo "</tr>";
		echo "</table>";
		}else{
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td width=30 class=text><b>Título</b></td>";
			echo "<td><input type=text name=titulo id=titulo></td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td width=30 class=text><b>Comentário</b></td>";
			echo "<td><textarea name=mensagem id=mensagem style='width:98%;' rows='6'></textarea></td>";
			echo "</tr>";
		echo "</table>";
		
		}	  
		echo "<p>";
		
		$sql = "SELECT * FROM erp_simulador_message WHERE simulador_id = {$cod_cliente}";
        $result = pg_query($sql);
        $dados = pg_fetch_all($result);
		
        for($x=0;$x<pg_num_rows($result);$x++){
           echo date("d/m/Y", strtotime($dados[$x]['data_criacao']))." <b><a class=fontebranca12 href='?dir=cad_cliente&p=add_coment&cod_cliente=$_GET[cod_cliente]&sp={$dados[$x][id]}'>"; echo "<b>".$dados[$x][titulo]."</b></a></b> 
		   - <a class=fontebranca12 href='?dir=cad_cliente&p=add_coment&action=del&cod_cliente=$_GET[cod_cliente]&sp={$dados[$x][id]}';}\">Excluir</a>";
           echo "<br>";
        }
		
		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
					//echo "<input type='submit' class='btn' name='btnSave' value='TESTE' onclick=\"return showAlert('Mensagem de teste!');\" onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
					echo "</td>";
				echo "</tr>";
				echo "</table>";
			echo "</td></tr>";
		echo "</table>";
		echo "</form>";

    echo "</td>";
echo "</tr>";
echo "</table>";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";

$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
   <HTML>
   <HEAD>
      <TITLE>Informativo</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
<META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
<style type=\"text/css\">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style13 {font-size: 14px}
.style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.style16 {font-size: 9px}
.style17 {font-family: Arial, Helvetica, sans-serif}
.style18 {font-size: 12px}
</style>
   </HEAD>
   <BODY>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho ltda.</span>
		  </font><br><br>
		  <p class=\"style18\">
		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
		  <p>
</td>
	</tr>
</table></div>
<p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"left\" class=\"fontepreta12\"><br />
		  <div class=\"style2 fontepreta12\" style=\"font-size:14px;\">
<center><u><strong>Atualização de Relatório de Atendimento</strong></u></center>
<p>
<br>
<table border=0 width=100%>
<tr>
<td width=100><b>Cód. Cliente:</b> </td><td>".$buffer[cliente_id]."</td>
</tr>
<tr>
<td><b>Razão Social:</b> </td><td>".$buffer[razao_social]."</td>
</tr>
<!--
<tr>
<td><b>Vendedor:</b> </td><td>".$quem."</td>
</tr>
-->
<tr>
<td><b>Atualizado:</b> </td><td>".date("d/m/Y H:i:s")."</td>
</tr>
</table>
<p>

<table border=0 width=100%>
<tr><td><b>Informações do atendimento:</b></td></tr>
<tr>
<td bgcolor='#d5d5d5'>".addslashes(nl2br($mensagem))."</td>
</tr>
</table>
          </div>
           </td>
	</tr>
</table></div>
<p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<p>
		<tr>
		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
		<br /><br /><br /><br /><br /><br />
		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
          <p class=\"style17\">
		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />

	    </td>
		<td width=\"35%\" align=\"right\">
        <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
	</tr>
</table></div>
   </BODY>
</HTML>  ";
  mail("comercial@sesmt-rio.com", "SESMT - Relatório de atendimento - {$buffer[razao_social]}", $msg, $headers);

?>