<?php
if($_POST[vistoria] == ""){
	    $data = "null";	
	}else{
	    $dt = explode("/", $_POST[vistoria]);
		if(count($dt)>2){
		   $data = "'".$dt[2]."-".$dt[1]."-".$dt[0]."'";//se for informado com 3 valores
		}else{
   		   $data = "'".$dt[1]."-".$dt[0]."-01'";//se for informado com 2 valores		
		}
	}

if( $_POST['btnSaveMang']){
	if(empty($diametro_mangueira_id)){$diametro_mangueira_id=0;}
	if(empty($tipo_sistema_fixo_contra_incendio_id)){$tipo_sistema_fixo_contra_incendio_id=0;}
	if(empty($tipo_para_raio_id)){$tipo_para_raio_id=0;}
	if(empty($alarme_contra_incendio_id)){$alarme_contra_incendio_id=0;}
	
	$sql = "UPDATE cliente_setor
			SET tipo_hidrante_id           	 	 	   = $tipo_hidrante_id
				, estado_abrigo						   = '$estado_abrigo'
				, diametro_mangueira_id      	 	   = $diametro_mangueira_id
				, quantidade_mangueira         	 	   = '$quantidade_mangueira'
				, esguicho       	 			 	   = '$esguicho'
				, chave_stors    	 			 	   = '$chave_stors'
				, pl_ident    	 				 	   = '$pl_ident'
				, demarcacao      	 			 	   = '$demarcacao'
				, porta_cont_fogo   			 	   = '$porta_cont_fogo'
				, tipo_para_raio_id				 	   = $tipo_para_raio_id
				, tipo_sistema_fixo_contra_incendio_id = $tipo_sistema_fixo_contra_incendio_id
				, alarme_contra_incendio_id		 	   = $alarme_contra_incendio_id
				, qtd_esquicho						   = '$qtd_esquicho'
				, qtd_raio							   = '$qtd_raio'
				, sprinkler							   = '$sprinkler'
				, detector							   = '$detector'
				, registro							   = '$registro'
				, repor								   = '$repor'
				, mang_reposta						   = '$mang_reposta'
				, bulbos							   = '$bulbos'
				, vistoria							   = $data
				, qtd_porta							   = '$qtd_porta'
				, estado_mang						   = '$estado_mang'
			WHERE id_ppra        	 		 	       = $_GET[cod_cgrt] and cod_setor = $_GET[cod_setor]";

	if(pg_query($sql)){
		showmessage('Dados do setor cadastrado com sucesso!');
	}
}

/****************************************************************************************************/
// - > BUSCA DADOS DO CLIENTE
/****************************************************************************************************/
$query_func = "SELECT * FROM cliente_setor WHERE id_ppra = $_GET[cod_cgrt] AND cod_setor = $_GET[cod_setor]";
$result_func = pg_query($query_func);
$row_st = pg_fetch_array($result_func);

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados da Mangueira:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmMangueira id=frmMangueira onsubmit=\"return mangue(this);\">";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td align=left class='text' width=100>Hidrante:</td>";
					echo "<td align=left class='text' width=150><select name='tipo_hidrante_id' id='tipo_hidrante_id' onBlur=\"narin(tipo_hidrante_id);\">";
					echo "<option value=''></option>";
					$tipo = "SELECT * FROM tipo_hidrante order by tipo_hidrante_id";
					$result_tipo = pg_query($tipo);
					while($row_tipo = pg_fetch_array($result_tipo)) {
						if($row_st[tipo_hidrante_id]<>$row_tipo[tipo_hidrante_id]){
							echo "<option value=\"$row_tipo[tipo_hidrante_id]\">". $row_tipo[tipo_hidrante]."</option>";
						}else{
							echo "<option value=\"$row_tipo[tipo_hidrante_id]\" selected=\"selected\">". $row_tipo[tipo_hidrante]."</option>";
						}
					}
				echo "</select>";
				echo "</td>";
				echo "<td align=left class='text' width=100>Est. do Abrigo:</td>";
					echo "<td align=left class='text' width=150><select name='estado_abrigo' id='estado_abrigo'>";
					echo "<option value=''></option>";
					echo "<option value='Bom'"; if($row_st[estado_abrigo] == "Bom") echo "'selected'"; echo ">Bom</option>";
					echo "<option value='Ruim'"; if($row_st[estado_abrigo] == "Ruim") echo "'selected'"; echo ">Ruim</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Capacidade:</td>";
				echo "<td class='text' ><select name='diametro_mangueira_id' id='diametro_mangueira_id' >";
					echo "<option value=''></option>";
					$diam = "SELECT * FROM diametro_mangueira order by diametro_mangueira_id";
				    $result_diam = pg_query($diam);
				    while ($row_diam = pg_fetch_array($result_diam)){
					    if($row_st[diametro_mangueira_id]<>$row_diam[diametro_mangueira_id]){
							echo "<option value=\"$row_diam[diametro_mangueira_id]\">". $row_diam[diametro_mangueira]."</option>";
						}else{
							echo "<option value=\"$row_diam[diametro_mangueira_id]\" selected=\"selected\">". $row_diam[diametro_mangueira]."</option>";
						}
				    }  
				echo "</select>";
				echo "</td>";
				echo "<td class='text' >Registro:</td>";
				echo "<td class='text' ><select name='registro' id='registro'>";
					echo "<option value=''></option>";
					echo "<option value='nenhum'"; if($row_st[registro] == "nenhum") echo "'selected'"; echo ">Nenhum</option>";
					echo "<option value='capota'"; if($row_st[registro] == "capota") echo "'selected'"; echo ">Capota</option>";
					echo "<option value='gaveta'"; if($row_st[registro] == "gaveta") echo "'selected'"; echo ">Gaveta</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Qtd. Mangueira:</td>";
				echo "<td class='text' ><input type=text name='quantidade_mangueira' id='quantidade_mangueira' size=5 onChange=\"hidrante();\" value='$row_st[quantidade_mangueira]'></td>";
				echo "<td align=left class='text' >Repor Mang.:</td>";
				echo "<td class='text' ><select name='repor' id='repor'>";
					echo "<option value=''></option>";
					echo "<option value='nenhum'"; if($row_st[repor] == "nenhum") echo "'selected'"; echo ">Nenhum</option>";
					echo "<option value='redimensionar'"; if($row_st[repor] == "redimensionar") echo "'selected'"; echo ">Redimensionar</option>";
					echo "<option value='aquis'"; if($row_st[repor] == "aquis") echo "'selected'"; echo ">Aquisição de Mang.</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Qtd:</td>";
				echo "<td class='text' ><input type=text name='mang_reposta' id='mang_reposta' size=5 value='$row_st[mang_reposta]'></td>";
				echo "<td align=left class='text' >Dt. Vistoria:</td>";
				echo "<td class='text' ><input type=text name='vistoria' id='vistoria' size=5 value='"; if($row_st[vistoria]){ echo date('m/Y', strtotime($row_st[vistoria])); } echo "' maxlength=7 OnKeyPress=\"formatar(this, '##/####')\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Estado Mang.:</td>";
				echo "<td align=left class='text'><select name='estado_mang' id='estado_mang'>";
					echo "<option value=''></option>";
					echo "<option value='Bom'"; if($row_st[estado_mang] == "Bom") echo "'selected'"; echo ">Bom</option>";
					echo "<option value='Ruim'"; if($row_st[estado_mang] == "Ruim") echo "'selected'"; echo ">Ruim</option>";
					echo "</select>"; 
				echo "</td>";
				echo "<td align=left class='text' >Esguicho:</td>";
				echo "<td align=left class='text'><select name='esguicho' id='esquicho'>";
					echo "<option value=''></option>";
					echo "<option value='nenhum'"; if($row_st[esguicho] == "nenhum")echo "'selected'"; echo ">Nenhum</option>";
				    echo "<option value='esguicho elkart de 1 1/2'"; if($row_st[esguicho] == "esguicho elkart de 1 1/2")echo "'selected'"; echo ">Esguicho Elkart de 1&quot; 1/2</option>";
				    echo "<option value='esguicho elkart de 2 1/2'"; if($row_st[esguicho] == "esguicho elkart de 2 1/2")echo "'selected'"; echo ">Esguicho Elkart de 2&quot; 1/2</option>";
				    echo "<option value='esguicho 13mm'"; if($row_st[esguicho] == "esguicho 13mm")echo "'selected'"; echo ">Esguicho Jato Sólido de 1&quot; 1/2 13mm</option>";
				    echo "<option value='esguicho 13m'"; if($row_st[esguicho] == "esguicho 13m")echo "'selected'"; echo ">Esguicho Jato Sólido de 2&quot; 1/2 13mm</option>";
				    echo "<option value='esguicho 16mm'"; if($row_st[esguicho] == "esguicho 16mm")echo "'selected'"; echo ">Esguicho Jato Sólido de 1&quot; 1/2 16mm</option>";
				    echo "<option value='esguicho 16m'"; if($row_st[esguicho] == "esguicho 16m")echo "'selected'"; echo ">Esguicho Jato Sólido de 2&quot; 1/2 16mm</option>";
				    echo "<option value='esguicho 19m'"; if($row_st[esguicho] == "esguicho 19m")echo "'selected'"; echo ">Esguicho Jato Sólido de 1&quot; 1/2 19mm</option>";
				    echo "<option value='esguicho 19mm'"; if($row_st[esguicho] == "esguicho 19mm")echo "'selected'"; echo ">Esguicho Jato Sólido de 2&quot; 1/2 19mm</option>";
				    echo "<option value='esguicho 25m'"; if($row_st[esguicho] == "esguicho 25m")echo "'selected'"; echo ">Esguicho Jato Sólido de 1&quot; 1/2 25mm</option>";
				    echo "<option value='esguicho 25mm'"; if($row_st[esguicho] == "esguicho 25mm")echo "'selected'"; echo ">Esguicho Jato Sólido de 2&quot; 1/2 25mm</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Qtd. Esguicho:</td>";
				echo "<td align=left class='text'><input type=text name='qtd_esquicho' id='qtd_esquicho' size=5 value='$row_st[qtd_esquicho]'</td>";
				echo "<td align=left class='text' >Chave Stors:</td>";
				echo "<td align=left class='text'><select name='chave_stors' id='chave_stors'>";
					echo "<option value=''></option>";
					echo "<option value='Sim'"; if($row_st[chave_stors] == "Sim") echo "'selected'"; echo ">Sim</option>";
					echo "<option value='Não'"; if($row_st[chave_stors] == "Não") echo "'selected'"; echo ">Não</option>";
					echo "</select>"; 
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Sinalização:</td>";
				echo "<td align=left class='text'><select name='pl_ident' id='pl_ident'>";
					echo "<option value=''></option>";
					echo "<option value='Sim'"; if($row_st[pl_ident] == "Sim") echo "'selected'"; echo ">Sim</option>";
					echo "<option value='Não'"; if($row_st[pl_ident] == "Não") echo "'selected'"; echo ">Não</option>";
					echo "</select>"; 
				echo "</td>";
				echo "<td align=left class='text' >Demarcação:</td>";
				echo "<td align=left class='text'><select name='demarcacao' id='demarcacao'>";
					echo "<option value=''></option>";
					echo "<option value='Cimentado'"; if($row_st[demarcacao] == "Cimentado") echo "'selected'"; echo ">Cimentado</option>";
					echo "<option value='Fita'"; if($row_st[demarcacao] == "Fita") echo "'selected'"; echo ">Fita</option>";
					echo "<option value='Tinta'"; if($row_st[demarcacao] == "Tinta") echo "'selected'"; echo ">Tinta</option>";
					echo "</select>"; 
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >P. Corta Fogo:</td>";
				echo "<td align=left class='text'><select name='porta_cont_fogo' id='porta_cont_fogo'>";
					echo "<option value=''></option>";
					echo "<option value='sim'"; if($row_st[porta_cont_fogo] == "sim") echo "'selected'"; echo ">Sim</option>";
					echo "<option value='nao'"; if($row_st[porta_cont_fogo] == "nao") echo "'selected'"; echo ">Não</option>";
					echo "</select>"; 
				echo "</td>";
				echo "<td align=left class='text' >Qtd. Porta:</td>";
				echo "<td align=left class='text'><input typa=text name='qtd_porta' id='qtd_porta' size=5 value='$row_st[qtd_porta]'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Para Raio:</td>";
				echo "<td align=left class='text'><select name='tipo_para_raio_id' id='tipo_para_raio_id'>";
					echo "<option value=''></option>";
					$raio = "SELECT * FROM tipo_para_raio order by tipo_para_raio_id";
					$result_raio = pg_query($raio);
					while ($row_raio = pg_fetch_array($result_raio)){
						if($row_st[tipo_para_raio_id]<>$row_raio[tipo_para_raio_id]){
							echo "<option value=\"$row_raio[tipo_para_raio_id]\">". $row_raio[tipo_para_raio]."</option>";
						}else{
							echo "<option value=\"$row_raio[tipo_para_raio_id]\" selected=\"selected\">". $row_raio[tipo_para_raio]."</option>";
						}
					}
					echo "</select>"; 
				echo "</td>";
				echo "<td align=left class='text' >Qtd. Para Raio:</td>";
				echo "<td align=left class='text'><input type=text name='qtd_raio' id='qtd_raio' size=5 value='$row_st[qtd_raio]'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Sist. Contra Incêndio:</td>";
				echo "<td align=left class='text'><select name='tipo_sistema_fixo_contra_incendio_id' id='tipo_sistema_fixo_contra_incendio_id'>";
					echo "<option value=''></option>";
					$fixo = "SELECT * FROM tipo_sistema_fixo_contra_incendio order by tipo_sistema_fixo_contra_incendio_id"; 
					$result_fixo = pg_query($fixo);
				    while ($row_fixo = pg_fetch_array($result_fixo)){
					  if($row_st[tipo_sistema_fixo_contra_incendio_id]<>$row_fixo[tipo_sistema_fixo_contra_incendio_id]){
							echo "<option value=\"$row_fixo[tipo_sistema_fixo_contra_incendio_id]\">". ucwords(strtolower($row_fixo[tipo_sistema_fixo_contra_incendio]))."</option>";
						}else{
							echo "<option value=\"$row_fixo[tipo_sistema_fixo_contra_incendio_id]\" selected=\"selected\">". ucwords(strtolower($row_fixo[tipo_sistema_fixo_contra_incendio]))."</option>";
						}
				    }	   
					echo "</select>"; 
				echo "</td>";
				echo "<td align=left class='text' >Alarme Contra Incêndio:</td>";
				echo "<td align=left class='text'><select name='alarme_contra_incendio_id' id='alarme_contra_incendio_id'>";
					echo "<option value=''></option>";
					$alar = "SELECT * FROM alarme_contra_incendio order by alarme_contra_incendio_id";
					$result_alar = pg_query($alar);
				    while($row_alar = pg_fetch_array($result_alar)){
					  if($row_st[alarme_contra_incendio_id]<>$row_alar[alarme_contra_incendio_id]){
							echo "<option value=\"$row_alar[alarme_contra_incendio_id]\">". $row_alar[alarme_contra_incendio]."</option>";
						}else{
							echo "<option value=\"$row_alar[alarme_contra_incendio_id]\" selected=\"selected\">". $row_alar[alarme_contra_incendio]."</option>";
						}
				    }  
					echo "</select>"; 
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Sprinkler:</td>";
				echo "<td align=left class='text'><select name='sprinkler' id='sprinkler'>";
					echo "<option value=''></option>";
					echo "<option value='Sim'"; if($row_st[sprinkler] == "Sim") echo "'selected'"; echo ">Sim</option>";
					echo "<option value='Não'"; if($row_st[sprinkler] == "Não") echo "'selected'"; echo ">Não</option>";
					echo "</select>"; 
				echo "</td>";
				echo "<td align=left class='text' >Qtd. Bulbos:</td>";
				echo "<td align=left class='text'><input typa=text name='bulbos' id='bulbos' size=5 value='$row_st[bulbos]'></td>";
			echo "</tr>";
			echo "</table>";
			
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
		echo "<input type='submit' class='btn' name='btnSaveMang' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" ></td>";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";
?>