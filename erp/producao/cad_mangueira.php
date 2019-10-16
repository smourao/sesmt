<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
}
else{
	$cliente = $_POST["cliente"];
	$setor   = $_POST["setor"];
	$vistoria= $_POST["vistoria"];
}

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

if( $_POST["btn_enviar"]=="Gravar"){
    ppra_progress_update($cliente, $setor);
	if(!empty($_POST["cliente"]) & !empty($_POST["setor"]) ){
		$cliente 					  		  = $_POST["cliente"];
		$setor 						  		  = $_POST["setor"];
		$tipo_hidrante_id			  		  = $_POST["tipo_hidrante_id"];
		$estado_abrigo						  = $_POST["estado_abrigo"];
		$diametro_mangueira_id		  		  = $_POST["diametro_mangueira_id"];
		$quantidade_mangueira		  		  = $_POST["quantidade_mangueira"];
		$esguicho	 				  		  = $_POST["esguicho"];
		$chave_stors	 			  		  = $_POST["chave_stors"];
		$pl_ident		    		  		  = $_POST["pl_ident"];
		$demarcacao		      		  		  = $_POST["demarcacao"];
		$porta_cont_fogo	 		  		  = $_POST["porta_cont_fogo"];
		$tipo_para_raio_id			 		  = $_POST["tipo_para_raio_id"];
		$tipo_sistema_fixo_contra_incendio_id = $_POST["tipo_sistema_fixo_contra_incendio_id"];
		$alarme_contra_incendio_id			  = $_POST["alarme_contra_incendio_id"];
		$qtd_esquicho						  = $_POST["qtd_esquicho"];
		$qtd_raio							  = $_POST["qtd_raio"];
		$sprinkler							  = $_POST["sprinkler"];
		$detector							  = $_POST["detector"];
		$registro							  = $_POST["registro"];
		$repor								  = $_POST["repor"];
		$mang_reposta						  = $_POST["mang_reposta"];
		$bulbos								  = $_POST["bulbos"];
		$vistoria							  = $_POST["data"];
		$qtd_porta							  = $_POST["qtd_porta"];
		$estado_mang						  = $_POST["estado_mang"];
	
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
				WHERE id_ppra        	 		 	       = $_GET[id_ppra] and cod_setor = $_GET[setor]";

		$result = pg_query($sql);
		if ($result){
			echo "<script>alert('Dados do Setor cadastrado com sucesso!');</script>";
		}
	}else{
		echo "<script>alert('Dado do Cliente ou Setor Incorreto!');</script>";
	}
}

/****************BUSCANDO DADOS DO CLIENTE********************/
if(!empty($cliente) & !empty($setor) ){
	$query_func = "SELECT * FROM cliente_setor WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor]";
	$result_func = pg_query($query_func);
	$row_st = pg_fetch_array($result_func);
}

/*********** BUSCANDO DADOS DO CLIENTE PARA ILUSTRAR A TELA************/
if(!empty($_GET[cliente]) & !empty($_GET[setor]) ){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}

?>
<html>
<head>
<title>Sugestões</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_medida_mang" method="POST">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
		<th bgcolor="#009966" colspan=6>
			<br> CADASTRO DE MANGUEIRAS DE INCÊNDIO <br>&nbsp;		</th>
    </tr>
	<?php 
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=6>
				<br> <font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b><?php echo $row_cli[razao_social]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: 		<b><?php echo $row_cli[endereco]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Bairro:   		<b><?php echo $row_cli[bairro]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: 		<b><?php echo $row_cli[telefone];     ?></b> <br>
				&nbsp;&nbsp;&nbsp; E-mail:   		<b><?php echo $row_cli[email]; 		  ?></b> <hr>			
				</font> </td>
		</tr>
	<?php 
	}
	?>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
	  <td align="center" class="fontebranca12" bgcolor="#009966" colspan="6"><b>Dados da Mangueira</b></td>
	</tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
      <td class="fontebranca10">Tipo de Hidrante </td>
	  <td class="fontebranca10">Est. do Abrigo</td>
      <td class="fontebranca10">Capacidade </td>
	  <td class="fontebranca10">Registro </td>
      <td class="fontebranca10"> Qtd. Mang. </td>
    </tr>
    <tr>
    <td class="fontebranca10"><select name="tipo_hidrante_id" id="tipo_hidrante_id" onBlur="narin(tipo_hidrante_id);">
	  <?php
	    $tipo = "SELECT * FROM tipo_hidrante order by tipo_hidrante_id";
		$result_tipo = pg_query($tipo);
	  while($row_tipo = pg_fetch_array($result_tipo)) {
			if($row_st[tipo_hidrante_id]<>$row_tipo[tipo_hidrante_id]){
				echo "<option value=\"$row_tipo[tipo_hidrante_id]\">". $row_tipo[tipo_hidrante]."</option>";
			}else{
				echo "<option value=\"$row_tipo[tipo_hidrante_id]\" selected=\"selected\">". $row_tipo[tipo_hidrante]."</option>";
			}
		}
	  ?>
    </select></td>
	<td class="fontebranca10"><select name="estado_abrigo" id="estado_mangueira">
	<option value="Bom" <?php if($row_st[estado_abrigo]=="Bom") echo "selected";?>>Bom</option>
	<option value="Ruim" <?php if($row_st[estado_abrigo]=="Ruim") echo "selected";?>>Ruim</option>
	</select>
	</td>
    <td class="fontebranca10"><select name="diametro_mangueira_id" id="diametro_mangueira_id">
      <?php
	  $diam = "SELECT * FROM diametro_mangueira order by diametro_mangueira_id";
	  $result_diam = pg_query($diam);
	  while ($row_diam = pg_fetch_array($result_diam)){
		  if($row_st[diametro_mangueira_id]<>$row_diam[diametro_mangueira_id]){
				echo "<option value=\"$row_diam[diametro_mangueira_id]\">". $row_diam[diametro_mangueira]."</option>";
			}else{
				echo "<option value=\"$row_diam[diametro_mangueira_id]\" selected=\"selected\">". $row_diam[diametro_mangueira]."</option>";
			}
	  }  
	  ?>
        </select></td>
	<td class="fontebranca10">
		<select name="registro" id="registro">
          <option value="nenhum" <?php if($row_st[registro]=="nenhum") echo "selected";?>>Nenhum</option>
		  <option value="gaveta" <?php if($row_st[registro]=="gaveta") echo "selected";?>>Gaveta</option>
          <option value="capota" <?php if($row_st[registro]=="capota") echo "selected";?>>Capota</option>
        </select>
	</td>
    <td class="fontebranca10"><input name="quantidade_mangueira" type="text" id="quantidade_mangueira" onChange="hidrante();" value="<?php echo $row_st[quantidade_mangueira]?>" size="5"></td>
  </tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
      <td class="fontebranca10">Repor Mang. </td>
	  <td class="fontebranca10">Qtd. </td>
	  <td class="fontebranca10">DT. Vistoria</td>
	  <td class="fontebranca10">Est. Mang.</td>
	  <td class="fontebranca10">Esguicho</td>
	  <td class="fontebranca10">Qtd. Esguicho</td>
	</tr>
	<tr>
	  <td class="fontebranca10"><select name="repor" id="repor">
	  	<option value="nenhum" <?php if($row_st[repor]=="nenhum") echo "selected";?>>Nenhum</option>
        <option value="redimensionar" <?php if($row_st[repor]=="redimensionar") echo "selected";?>>Redimensionar</option>
        <option value="aquis" <?php if($row_st[repor]=="aquis") echo "selected";?>>Aquisição de Mang.</option>
      </select></td>
      <td class="fontebranca10"><input name="mang_reposta" type="text" id="mang_reposta" value="<?php echo $row_st[mang_reposta]?>" size="5"></td>
	  <td class="fontebranca10"><input name="vistoria" id="vistoria" type="text" value="<?php if($row_st[vistoria]){ echo date("m/Y", strtotime($row_st[vistoria])); }?>" size="6"></td>
	  <td class="fontebranca10"><select name="estado_mang" id="estado_mang">
	  <option value="Bom" <?php if($row_st[estado_mang]=="Bom") echo "selected";?>>Bom</option>
	  <option value="Ruim" <?php if($row_st[estado_mang]=="Ruim") echo "selected";?>>Ruim</option>
	  </select>
	  </td>
	  <td class="fontebranca10"><select name="esguicho" id="esquicho">
		  <option value="nenhum" <?php if($row_st[esguicho]=="nenhum")echo "selected";?>>Nenhum</option>
		  <option value="esguicho elkart de 1 1/2" <?php if($row_st[esguicho]=="esguicho elkart de 1 1/2")echo "selected";?>>Esguicho Elkart de 1" 1/2</option>
		  <option value="esguicho elkart de 2 1/2" <?php if($row_st[esguicho]=="esguicho elkart de 2 1/2")echo "selected";?>>Esguicho Elkart de 2" 1/2</option>
		  <option value="esguicho 13mm" <?php if($row_st[esguicho]=="esguicho 13mm")echo "selected";?>>Esguicho Jato Sólido de 1" 1/2 13mm</option>
		  <option value="esguicho 13m" <?php if($row_st[esguicho]=="esguicho 13m")echo "selected";?>>Esguicho Jato Sólido de 2" 1/2 13mm</option>
		  <option value="esguicho 16mm" <?php if($row_st[esguicho]=="esguicho 16mm")echo "selected";?>>Esguicho Jato Sólido de 1" 1/2 16mm</option>
  		  <option value="esguicho 16m" <?php if($row_st[esguicho]=="esguicho 16m")echo "selected";?>>Esguicho Jato Sólido de 2" 1/2 16mm</option>
		  <option value="esguicho 19m" <?php if($row_st[esguicho]=="esguicho 19m")echo "selected";?>>Esguicho Jato Sólido de 1" 1/2 19mm</option>
		  <option value="esguicho 19mm" <?php if($row_st[esguicho]=="esguicho 19mm")echo "selected";?>>Esguicho Jato Sólido de 2" 1/2 19mm</option>
		  <option value="esguicho 25m" <?php if($row_st[esguicho]=="esguicho 25m")echo "selected";?>>Esguicho Jato Sólido de 1" 1/2 25mm</option>
		  <option value="esguicho 25mm" <?php if($row_st[esguicho]=="esguicho 25mm")echo "selected";?>>Esguicho Jato Sólido de 2" 1/2 25mm</option>
		  </select>	  
	  </td>
      <td class="fontebranca10"><input name="qtd_esquicho" id="qtd_esquicho" type="text" value="<?php echo $row_st[qtd_esquicho]?>" size="5"></td>
    </tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
      <td class="fontebranca10">C. Stors </td>
      <td class="fontebranca10">Sinalização</td>
      <td class="fontebranca10">Demarcação</td>
	  <td class="fontebranca10">P. Corta Fogo </td>
	  <td class="fontebranca10">Qtd. P. Corta Fogo</td>
      <td class="fontebranca10">Para Raio </td>
	  <td class="fontebranca10">Qtd Para Raio</td>
    </tr>
    <tr>
      <td class="fontebranca10"><select name="chave_stors" id="chave_stors">
	  <option value="Sim" <?php if($row_st[chave_stors]=="Sim") echo "selected";?>>Sim</option>
	  <option value="Não" <?php if($row_st[chave_stors]=="Não") echo "selected";?>>Não</option>
	  </select>
	  </td>
	  <td class="fontebranca10"><select name="pl_ident" id="pl_ident">
	  <option value="Sim" <?php if($row_st[pl_ident]=="Sim") echo "selected";?>>Sim</option>
	  <option value="Não" <?php if($row_st[pl_ident]=="Não") echo "selected";?>>Não</option>
	  </select>
	  </td>
      <td class="fontebranca10"><select name="demarcacao" id="demarcacao">
	  <option value="Fita" <?php if($row_st[demarcacao]=="Fita") echo "selected";?>>Fita</option>
	  <option value="Tinta" <?php if($row_st[demarcacao]=="Tinta") echo "selected";?>>Tinta</option>,
	  <option value="Cimentado" <?php if($row_st[demarcacao]=="Cimentado") echo "selected";?>>Cimentado</option>
	  </select>
	  </td>
	  <td class="fontebranca10">
        <select name="porta_cont_fogo" id="porta_cont_fogo">
          <option value="sim" <?php if($row_st[porta_cont_fogo]=="sim") echo "selected";?>>Sim</option>
          <option value="nao" <?php if($row_st[porta_cont_fogo]=="nao") echo "selected";?>>Não</option>
        </select>      
	  </td>
  	  <td class="fontebranca10"><input type="text" name="qtd_porta" id="qtd_porta" value="<?php echo $row_st[qtd_porta]?>" size="5"></td>
      <td class="fontebranca10"><select name="tipo_para_raio_id" id="tipo_para_raio_id">
        <?php
		$raio = "SELECT * FROM tipo_para_raio order by tipo_para_raio_id";
		$result_raio = pg_query($raio);
	    while ($row_raio = pg_fetch_array($result_raio)){
		    if($row_st[tipo_para_raio_id]<>$row_raio[tipo_para_raio_id]){
			    echo "<option value=\"$row_raio[tipo_para_raio_id]\">". $row_raio[tipo_para_raio]."</option>";
		    }else{
		        echo "<option value=\"$row_raio[tipo_para_raio_id]\" selected=\"selected\">". $row_raio[tipo_para_raio]."</option>";
			}
	    }
	  ?>
      </select></td>
      <td class="fontebranca10"><input name="qtd_raio" id="qtd_raio" type="text" value="<?php echo $row_st[qtd_raio]?>" size="5"></td>
    </tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
        <td class="fontebranca10">Sis. Fixo Contra Incêndio </td>
        <td class="fontebranca10">Alarme contra Incêndio </td>
		<td class="fontebranca10">Sprinkler</td>
		<td class="fontebranca10">Qtd. Bulbos </td>
		<!--td class="fontebranca10">Detector de Fumaça</td-->
	</tr>
	<tr>
	    <td class="fontebranca10"><select name="tipo_sistema_fixo_contra_incendio_id" id="tipo_sistema_fixo_contra_incendio_id">
        <?php
		$fixo = "SELECT * FROM tipo_sistema_fixo_contra_incendio order by tipo_sistema_fixo_contra_incendio_id"; 
		$result_fixo = pg_query($fixo);
	  while ($row_fixo = pg_fetch_array($result_fixo)){
		  if($row_st[tipo_sistema_fixo_contra_incendio_id]<>$row_fixo[tipo_sistema_fixo_contra_incendio_id]){
				echo "<option value=\"$row_fixo[tipo_sistema_fixo_contra_incendio_id]\">". ucwords(strtolower($row_fixo[tipo_sistema_fixo_contra_incendio]))."</option>";
			}else{
				echo "<option value=\"$row_fixo[tipo_sistema_fixo_contra_incendio_id]\" selected=\"selected\">". ucwords(strtolower($row_fixo[tipo_sistema_fixo_contra_incendio]))."</option>";
			}
	  }	    
	  ?>
        </select>
	  </td>
      <td class="fontebranca10"><select name="alarme_contra_incendio_id" id="alarme_contra_incendio_id">
		  <?php
			$alar = "SELECT * FROM alarme_contra_incendio order by alarme_contra_incendio_id";
			$result_alar = pg_query($alar);
		  while($row_alar = pg_fetch_array($result_alar)){
			  if($row_st[alarme_contra_incendio_id]<>$row_alar[alarme_contra_incendio_id]){
					echo "<option value=\"$row_alar[alarme_contra_incendio_id]\">". $row_alar[alarme_contra_incendio]."</option>";
				}else{
					echo "<option value=\"$row_alar[alarme_contra_incendio_id]\" selected=\"selected\">". $row_alar[alarme_contra_incendio]."</option>";
				}
		  }  
		  ?>
        </select>
	  </td>
	  <td class="fontebranca10"><select name="sprinkler" id="sprinkler">
		<option value="Sim" <?php if($row_st[sprinkler]=="Sim") echo "selected";?>>Sim</option>
		<option value="Não" <?php if($row_st[sprinkler]=="Não") echo "selected";?>>Não</option>
		</select>
	  </td>
      <td class="fontebranca10"><input name="bulbos" id="bulbos" type="text" value="<?php echo $row_st[bulbos]?>" size="5"></td>
	</tr>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
		<td align="center" colspan="6">
			<br>
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='cad_extintor.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&y=<?php echo $_GET['y']; ?>&fid=<?PHP echo $_GET[fid];?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_enviar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="continuar" value="Continuar >>" onClick="location.href='placa_sugestao.php?cliente=<?php echo $cliente; ?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&y=<?php echo $ano; ?>&fid=<?PHP echo $_GET[fid];?>';" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>
