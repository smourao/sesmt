<?PHP
//CONCATENAR UM ARRAY
$ris = $_POST['brinde'];
$num = count($ris);
for($x=0;$x<$num;$x++){
	$str .= $ris[$x]."|";
}

$venc = $_POST[dia_u]."/".$_POST[mes_u]."/".$_POST[ano_u];
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
				//echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Relat. Atend.' onclick=\"location.href='?dir=cad_cliente&p=rel_atendimento&cod_cliente=$_GET[cod_cliente]';\"  onmouseover=\"showtip('tipbox', '- Relatório, permite o cadastro de relacionamento com o cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Comentário' onclick=\"location.href='?dir=cad_cliente&p=add_coment&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Comentário, permite adicionar um comntário relevante no cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'><b>Relatório de Atendimento</b></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<p>";
		
		echo "<form method=post name=form1>";	
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		
		$sql = "SELECT * FROM cliente WHERE cliente_id = '{$cod_cliente}'";
		$result = pg_query($sql);
		$buffer = pg_fetch_array($result);
		
		if($_POST[btnSave]){
			$sql = "SELECT * FROM erp_relatorio_simulador WHERE simulador_id = '{$cod_cliente}'";
			$r = pg_query($sql);
		
			if(pg_num_rows($r)>0){
			
			   $sql = "UPDATE erp_relatorio_simulador SET
			   razao_social		  ='{$buffer[razao_social]}',
			   contato			  ='{$contato_direto}',
			   apreciado		  ='{$apreciado}',
			   aceitacao		  ='{$reacao}',
			   aceitou			  ='{$visita}',
			   dia_visita		  ='{$dia}',
			   mes_visita		  ='{$mes}',
			   ano_visita		  ='{$ano}',
			   hora_visita		  ='{$hora}',
			   min_visita 		  ='{$min}',
			   contato_visita	  ='{$pessoa}',
			   telefone_visita	  ='{$telefone}',
			   referencia_visita  ='{$referencia}',
			   brindes_visita	  ='{$str}',
			   data_atualizacao   = '".date("Y-m-d")."',
			   prestadora 		  = '{$empresa}',
			   vencimento 		  = '{$venc}'
			   WHERE simulador_id = '{$cod_cliente}'";
			   $act = pg_query($sql);
			   if($act){
				  showMessage('<p align=justify>Cadastro atualizado com sucesso.</p>');
				  makelog($_SESSION[usuario_id], 'Atualização de relatório de atendimento, '.$_GET[cod_cliente].' - '.$_POST[razao_social], 203);
			  }else{
				  makelog($_SESSION[usuario_id], 'Erro ao atualizar relatório de atendimento, '.$data[cliente_id].' - '.$_POST[razao_social], 204);
				  showMessage('<p align=justify>Não foi possível atualizar este cadastro. Por favor, verifique se todos os campos obrigatórios foram preenchidos corretamente.<BR>Em caso de dúvidas, entre em contato com o setor de suporte!</p>', 1);
			  }
			}else{
			   $sql = "INSERT INTO erp_relatorio_simulador
			   (razao_social, simulador_id, contato, apreciado, aceitacao, aceitou, dia_visita, mes_visita, ano_visita, hora_visita, min_visita,
			   contato_visita, telefone_visita, referencia_visita, brindes_visita, data_criacao, data_atualizacao, prestadora, vencimento)
			   VALUES
			   ('{$buffer[razao_social]}', '{$cod_cliente}', '{$contato_direto}', '{$apreciado}', '{$reacao}', '{$visita}', '{$dia}',
			   '{$mes}', '{$ano}', '{$hora}', '{$min}', '{$pessoa}', '{$telefone}',
			   '{$referencia}', '{$str}', '".date("Y-m-d")."', '".date("Y-m-d")."', '{$empresa}', '{$venc}')";
			   $act = pg_query($sql);
			   if($act){
			   	   showMessage('<p align=justify>Cadastro realizado com sucesso.</p>');
          	       makelog($_SESSION[usuario_id], 'Novo cadastro de relatório de atendimento, '.$data[cliente_id].' - '.$_POST[razao_social], 201);
			   }else{
				   makelog($_SESSION[usuario_id], 'Erro ao cadastrar relatório de atendimento, '.$data[cliente_id].' - '.$_POST[razao_social], 202);
				   showMessage('<p align=justify>Não foi possível realizar este cadastro. Por favor, verifique se todos os campos obrigatórios foram preenchidos corretamente.<BR>Em caso de dúvidas, entre em contato com o setor de suporte!</p>', 1);
			   }
			}
		}
		$sql = "SELECT * FROM erp_relatorio_simulador WHERE simulador_id = '{$cod_cliente}'";
		$r = pg_query($sql);
		$data = pg_fetch_array($r);
		
		$venc = explode("/", $data[vencimento]);
		$bri = explode("|", $data[brindes_visita]);
		
		echo "<td align=justify class=text colspan=2>Em contato com o Sr.(ª)
		    <input type=text size=20 id=contato_direto name=contato_direto value='{$data[contato]}'>
		    foi nos relatado ter
		    <select name=apreciado id=apreciado>
		    <option value='1' "; if($data[apreciado]){ echo " selected ";} echo " >apreciado</option>
		    <option value='0' "; if(!$data[apreciado]){ echo " selected ";} echo " >não apreciado</option>
		    </select>
			nossos preços que a empresa dele foi enviado.</td>";
		echo "</tr><tr>";
		echo "<td align=left class=text colspan=2><select name=reacao id=reacao>
			<option value='0' "; if(!$data[aceitacao]){ echo " selected ";} echo " >Selecione</option>
			<option value='1' "; if($data[aceitacao] == "1"){ echo " selected ";} echo " >Contudo alegou não estar no período de renovação.</option>
			<option value='2' "; if($data[aceitacao] == "2"){ echo " selected ";} echo " >Aceitou uma visita para melhor esplanação.</option>
			<option value='3' "; if($data[aceitacao] == "3"){ echo " selected ";} echo " >Aceitou uma visita por nunca ter realizado os programas.</option>
			<option value='4' "; if($data[aceitacao] == "4"){ echo " selected ";} echo " >Aceitou uma visita por faltar informações por parte de quem os atende.</option>
			</select>
			</td>";
		echo "</tr><tr>";
		echo "<td align=left class=text colspan=2>Razão Social de empresa prestadora dos serviços:
			<input type=text name=empresa id=empresa size=23 value='{$data[prestadora]}'></td>";
		echo "</tr><tr>";
		echo "<td align=left class=text colspan=2>Data da última realização dos serviços:
			<input type=text size=2 name=dia_u id=dia_u value='{$venc[0]}' maxlength=2 onkeyup=\"if(this.value.length>=2){document.getElementById('mes_u').focus();}\">/<input type=text size=2 maxlength=2 name=mes_u id=mes_u  value='{$venc[1]}' onkeyup=\"if(this.value.length>=2){document.getElementById('ano_u').focus();}\">/<input type=text size=4 name=ano_u id=ano_u  value='{$venc[2]}' maxlength=4>
			</td>";
		echo "</tr><tr>";
		echo "<td align=left class=text colspan=2>Aceitou visita?
			<input type=radio name=visita id=visita1 value=1 onclick='visita(this.value);'  "; if($data[aceitou] == "1"){ echo " checked ";} echo " > Sim
			<input type=radio name=visita id=visita0 value=0 onclick='visita(this.value);'  "; if($data[aceitou] == "0"){ echo " checked ";} echo " > Não
			</td>";
		echo "</tr><tr>";
		echo "<td class=text width=150>Dia da visita:</td>
			<td class=text><input type=text size=2 name=dia id=dia maxlength=2 value='{$data[dia_visita]}' onkeyup=\"if(this.value.length>=2){document.getElementById('mes').focus();}\">/<input type=text size=2 name=mes id=mes value='{$data[mes_visita]}' maxlength=2  onkeyup=\"if(this.value.length>=2){document.getElementById('ano').focus();}\">/<input type=text size=4 name=ano id=ano maxlength=4 value='{$data[ano_visita]}' onkeyup=\"if(this.value.length>=4){document.getElementById('hora').focus();}\"></td>";
		echo "</tr><tr>";
		echo "<td class=text>Horário:</td>
			<td class=text><input type=text size=2 name=hora id=hora maxlength=2 value='{$data[hora_visita]}' onkeyup=\"if(this.value.length>=2){document.getElementById('min').focus();}\">:<input type=text size=2 name=min id=min maxlength=2 value='{$data[min_visita]}' onkeyup=\"if(this.value.length>=2){document.getElementById('pessoa').focus();}\"></td>";
		echo "</tr><tr>";
		echo "<td class=text>Pessoa de contato:</td><td class=textorelatorio><input type=text name=pessoa id=pessoa value='{$data[contato_visita]}'></td>";
		echo "</tr><tr>";
		echo "<td class=text>Telefone:</td><td class=textorelatorio><input type=text name=telefone id=telefone onkeypress=\"fone(this);\" value='{$data[telefone_visita]}'></td>";
		echo "</tr><tr>";
		echo "<td class=text>Ponto de referência:</td><td class=textorelatorio><input type=text name=referencia id=referencia size=50 value='{$data[referencia_visita]}'></td>";
		echo "</tr><tr>";
		echo "<td align=left class=text colspan=2>Necessidade de brinde:<br>
			<input type=checkbox name=brinde[] id=brinde_1 "; if(in_array("Porta Caneta", $bri)){ echo" checked ";} echo " value=\"Porta Caneta\">Porta Caneta
			<input type=checkbox name=brinde[] id=brinde_2 "; if(in_array("Régua", $bri)){ echo" checked ";} echo " value=\"Régua\">Régua
			<input type=checkbox name=brinde[] id=brinde_3 "; if(in_array("Risque Rabisque", $bri)){ echo" checked ";} echo " value=\"Risque Rabisque\">Risque Rabisque
			<input type=checkbox name=brinde[] id=brinde_4 "; if(in_array("Mouse Pad", $bri)){ echo" checked ";} echo " value=\"Mouse Pad\">Mouse Pad
			<input type=checkbox name=brinde[] id=brinde_5 "; if(in_array("Agenda", $bri)){ echo" checked ";} echo " value=\"Agenda\">Agenda
			<input type=checkbox name=brinde[] id=brinde_6 "; if(in_array("Adesivo", $bri)){ echo" checked ";} echo " value=\"Adesivo\">Adesivo
			<input type=checkbox name=brinde[] id=brinde_7 "; if(in_array("Caneta", $bri)){ echo" checked ";} echo " value=\"Caneta\">Caneta
			<input type=checkbox name=brinde[] id=brinde_8 "; if(in_array("Calendário de Mesa", $bri)){ echo" checked ";} echo " value=\"Calendário de Mesa\">Calendário de Mesa
			<input type=checkbox name=brinde[] id=brinde_9 "; if(in_array("Chaveiro", $bri)){ echo" checked ";} echo " value=\"Chaveiro\">Chaveiro
			<input type=checkbox name=brinde[] id=brinde_10 "; if(in_array("Relógio de Parede", $bri)){ echo" checked ";} echo " value=\"Relógio de Parede\">Relógio de Parede
			<input type=checkbox name=brinde[] id=brinde_11 "; if(in_array("Garrafa de Vinho", $bri)){ echo" checked ";} echo " value=\"Garrafa de Vinho\">Garrafa de Vinho
			</td>
			</tr>";
		
			echo "</td>";
		echo "</tr>";
		echo "</table>";
		
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

?>