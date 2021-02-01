<?PHP
ob_start();
error_reporting(0);

//USER DATA
$sql = "SELECT * FROM reg_pessoa_juridica WHERE cod_cliente='{$_SESSION['cod_cliente']}'";
$r = pg_query($sql);
$data = pg_fetch_all($r);
//echo "aqui".$sql."<br>";
   $sql = "SELECT MAX(numero_contrato)+1 as contrato_n FROM clinicas";
   $res = pg_query($sql);
   $maxi = pg_fetch_array($res);
   if($maxi['contrato_n']==""){
       $maxi['contrato_n']=1;
   } 

//*********************************************************************************************
//    VERIFICA SE O USUÁRIO JÁ ESTÁ CADASTRADO COMO CLÍNICA
//*********************************************************************************************
//print_r($_POST);
if($_POST['lc']){

$headers  = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
mail("medicotrab@sesmt-rio.com", "Clínica cadastrada no Site ".$data[0]['razao_social'], $headers);

$sql = "SELECT max(cod_clinica)+1 FROM clinicas";
$result = pg_query($sql);
$max = pg_fetch_row($result);

   if(pg_num_rows($r)>0){
   $sql = "SELECT * FROM clinicas WHERE razao_social_clinica = '{$data[0]['razao_social']}' and cod_cliente='{$_SESSION['cod_cliente']}";
	  if(pg_num_rows(pg_query($sql))<=0){//SE CADASTRO NAO EXISTIR!
	  $tel = $_POST['ddd_responsavel']." - ".$_POST['tel_responsavel'];
	  $nextel = $_POST['ddd_nextel']." - ".$_POST['nextel_responsavel'];
   
      $sql = "INSERT INTO clinicas (cod_clinica, razao_social_clinica, nome_fantasia_clinica, inscricao_clinica, cnpj_clinica,
      endereco_clinica, bairro_clinica, tel_clinica, fax_clinica, email_clinica, cep_clinica, referencia_clinica, data_criacao,
	  cod_func_criacao, data_ultima_alt, cod_func_alt, cidade, estado, contato_clinica, id_nextel_contato, tel_contato,
	  nextel_contato, email_contato, cargo_responsavel, cargo_intermediario, ramal_responsavel, ramal_intermediario, fax_responsavel,
	  fax_intermediario, contato_intermediario, email_intermediario, tel_intermediario, nextel_intermediario, id_nextel_intermediario,
	  num_end, status, numero_contrato, ano_contrato, por_exames)
      VALUES
      ({$max[0]}, '{$data[0]['razao_social']}', '{$data[0]['nome_fantasia']}', '{$data[0]['inscricao_estadual']}', '{$data[0]['cnpj']}',
	  '{$data[0]['endereco']}', '{$data[0]['bairro']}', '{$data[0]['tel_comercial']}', '{$data[0]['fax']}', '{$data[0]['email']}',
	  '{$data[0]['cep']}', '{$_POST['referencia']}', '".date("Y,m,d")."', 0, null, 0, '{$data[0]['cidade']}', '{$data[0]['estado']}',
	  '{$_POST['responsavel']}', '{$_POST['nextel_id']}', '{$tel}', '{$nextel}', '{$_POST['email_responsavel']}', '{$_POST['cargo_responsavel']}',
	  '', '', '', '', '', '', '', '', '', '', '{$data[0]['numero']}', 'ativo', {$maxi['contrato_n']}, ".date("Y").", '{$_POST['por_exames']}')";
      $result = pg_query($sql);
      
      if($result){
         //echo "ok".$sql;
      }else{
         //echo "fudeu -> ".pg_last_error($conn);
      }
      }//endif se nao tiver cadastrado
	  //echo "ok".$sql;
   }
}

//*********************************************************************************************
//    VERIFICA SE O USUÁRIO JÁ ESTÁ CADASTRADO COMO CLÍNICA
//*********************************************************************************************
if($data[0]['cnae'] == '86.10-1' || $data[0]['cnae'] == '86.21-6' || $data[0]['cnae'] == '86.22-4' || $data[0]['cnae'] == '86.30-5' || $data[0]['cnae'] == '86.40-2' || $data[0]['cnae'] == '86.50-0' || $data[0]['cnae'] == '86.60-7' || $data[0]['cnae'] == '86.90-9' || $data[0]['cnae'] == '87.11-5' || $data[0]['cnae'] == '87.12-3' || $data[0]['cnae'] == '87.20-4' || $data[0]['cnae'] == '87.30-1'){

	$sql = "SELECT c.*, r.* FROM clinicas c, reg_pessoa_juridica r WHERE r.email = c.email_clinica AND r.cod_cliente='{$_SESSION['cod_cliente']}'";
	$result = pg_query($sql);
	$cd = pg_fetch_all($result);
	$n = pg_num_rows($result);
	if($n == 0){
	
	?>
	<center>
	CADASTRO DE CLÍNICAS E EXAMES<p>
	Preencha os campos abaixo para completar seu cadastro<p>
	<form method="POST" action="?do=cad_clin" onsubmit="return cln(this);">
	<table border="0" width="500">
		<tr>
			<td width=150 align=left>Nome do Responsável: </td>
			<td><input class=text type="text" name="responsavel" id="responsavel" size=49 value='<?PHP echo $data[0]['responsavel'];?>'></td>
		</tr>
		<tr>
			<td width=150 align=left>Cargo do Responsável: </td>
			<td><input class=text type="text" name="cargo_responsavel" id="cargo_responsavel" value='<?PHP echo $data[0]['cargo'];?>'></td>
		</tr>
		<tr>
			<td width=150 align=left>Email do Responsável: </td>
			<td><input class=text type="text" name="email_responsavel" id="email_responsavel" value='<?PHP echo $data[0]['email_pessoal'];?>'></td>
		</tr>
		<tr>
			<td width=150 align=left>% Sobre Exames: </td>
			<td><input class=text type="text" name="por_exames" id="por_exames" size="5" maxlength="5" OnKeyPress="formatar(this, '##.##');"> Ex. 05.00 para 5%</td>
		</tr>
		<tr>
			<td width=150 align=left>Tel. do Responsável: </td>
			<td><input class=text type="text" name="ddd_responsavel" id="ddd_responsavel" size=3 maxlength=3 onkeyup="if(this.value.length>=3){document.getElementById('tel_responsavel').focus();}"> -
			<input class=text type="text" name="tel_responsavel" id="tel_responsavel" size=11 maxlength=9 onkeyup="if(this.value.length == 4){this.value = this.value + '-';}"></td>
		</tr>
		<tr>
			<td width=150 align=left>Nextel do Responsável: </td>
			<td><input class=text type="text" name="ddd_nextel" id="ddd_nextel" size=3 maxlength=3  onkeyup="if(this.value.length>=3){document.getElementById('nextel_responsavel').focus();}"> -
			<input class=text type="text" name="nextel_responsavel" id="nextel_responsavel" size=11  maxlength=9 onkeyup="if(this.value.length == 4){this.value = this.value + '-';}">
			Id: <input class=text type="text" name="nextel_id" id="nextel_id" size=5></td>
		</tr>
		<tr>
			<td width=150 align=left>Ponto de Referência: </td>
			<td><input class=text type="text" name="referencia" id="referencia" size="49"></td>
		</tr>
	</table>
	<p>
	<center><input type="submit" name="lc" value="Continuar" class="button"></center>
	</form>
	</center><p>
	<?PHP
		
	}else{
	/* CADASTRO DE EXAMES */
	$cod_clinica = $cd[0]['cod_clinica'];
	
	if( !empty($_GET[exame]) ){
		$exame = $_GET[exame];
	
		$query_excluir = $query_excluir . "DELETE FROM clinica_exame WHERE cod_exame = $exame and cod_clinica = $cod_clinica;";
		$result_excluir = pg_query($query_excluir);
	
		if ($result_excluir){
			echo '<script> alert("O Exame foi EXCLUIDO com sucesso!");</script>';
		}
	}
	
	if( (!empty($_POST[editpreco])) && (!empty($_GET[editar]))  ){
		
		
		$sqltakecodcli2 = "SELECT c.razao_social_clinica, c.cod_clinica FROM clinicas c, reg_pessoa_juridica r WHERE c.cnpj_clinica = r.cnpj AND r.cod_cliente='{$_SESSION['cod_cliente']}'";
		$querytakecodcli2 = pg_query($sqltakecodcli2);
		$takecodcli2 = pg_fetch_array($querytakecodcli2);
		$editcod_clinica2 = $takecodcli2[cod_clinica];
		$editrazao_social2 = $takecodcli2['razao_social_clinica'];
		
		
		
		$precoedit = str_replace(",",".",$_POST['editpreco']);
		
		
		
		$testarupsql = "SELECT * FROM clinica_exame WHERE cod_exame = $_GET[editar] AND cod_clinica = $editcod_clinica2";
		$testarupquery = pg_query($testarupsql);
		$testaruparray = pg_fetch_array($testarupquery);
		$testarup = pg_num_rows($testarupquery);
		$preco_exame_anti = $testaruparray[preco_exame];
		
		
		if($testarup == 1){
		
		$updateprecosql = "UPDATE clinica_exame SET preco_exame = $precoedit WHERE cod_exame = $_GET[editar] AND cod_clinica = $editcod_clinica2";

		
		
		if($updatepreco = pg_query($updateprecosql)){
		
		$codigo_exame = $_GET[editar];	
			
		$sqlexaedtt2 = "SELECT cod_exame, especialidade FROM exame WHERE cod_exame = $codigo_exame";
		$queryexaedtt2 = pg_query($sqlexaedtt2);
		$exaedtt2 = pg_fetch_array($queryexaedtt2);
		$nome_examee2 = $exaedtt2['especialidade'];
		
		
		$msg = "";
		$msg .= "Clínica: ";
		$msg .= "<b>";
		$msg .= "".$editrazao_social2."";
		$msg .= "</b>";
		$msg .= "<br>";
		$msg .= "<br>";
		$msg .= "Exame: ";
		$msg .= "<b>";
		$msg .= "".$nome_examee2."";
		$msg .= "</b>";
		$msg .= "<br>";
		$msg .= "<br>";
		$msg .= "Preço Anterior: ";
		$msg .= "<b> R$ ";
		$msg .= "".$preco_exame_anti."";
		$msg .= "</b>";
		$msg .= "<br>";
		$msg .= "<br>";
		$msg .= "Preço Atual: ";
		$msg .= "<b> R$ ";
		$msg .= "".$precoedit."";
		$msg .= "</b>";
		
		
		
		
		$titulo = "SESMT: Mudança de preço de exame ";
		
				
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= 'From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
			
			if(mail("financeiro@sesmt-rio.com;suporte@ti-seg.com", $titulo, $msg, $headers)){
				
				echo "ok";
			}
		
		
		
		$script = '<script language="javascript">location.href="?do=cad_clin";</script>';
		echo $script;
		
		
		}
		
		
		}
		
		
	}
	
	
	
	if(!empty($cod_clinica) and $_POST[btn_gravar]){
		$z = count($_POST['exame']);
			for($x=0;$x<$z-1;$x++){
			$exame = $_POST['exame'][$x];
			$preco = str_replace(",",".",$_POST['preco_exame'][$x]);
			
				$sql_verifica = "SELECT * FROM clinica_exame WHERE cod_clinica = $cod_clinica and cod_exame = $exame";
				$result_verifica = pg_query($sql_verifica);
				$n = pg_num_rows($result_verifica);
				
				if($n==0 && $preco!="" && $exame!=""){
				$query_exame = "INSERT INTO clinica_exame(cod_clinica, cod_exame, preco_exame, data)
							   VALUES
							   ($cod_clinica, $exame, $preco, '".date("Y/m/d")."');";
				$result_exame = pg_query($query_exame);
				}
			}
	}
	
	?>
	<center>
	CADASTRO DE EXAMES<p>
    
    <?php
	
    if(!empty($_GET[editar])){
		
		
		$codigo_exame = $_GET[editar];
		
		$sqltakecodcli = "SELECT c.cod_clinica FROM clinicas c, reg_pessoa_juridica r WHERE c.cnpj_clinica = r.cnpj AND r.cod_cliente='{$_SESSION['cod_cliente']}'";
		$querytakecodcli = pg_query($sqltakecodcli);
		$takecodcli = pg_fetch_array($querytakecodcli);
		$editcod_clinica = $takecodcli[cod_clinica];
		
		
		$sqlexaedt = "SELECT cod_exame, especialidade FROM exame WHERE cod_exame = $codigo_exame";
		$queryexaedt = pg_query($sqlexaedt);
		$exaedt = pg_fetch_array($queryexaedt);
		$nome_exame = $exaedt[especialidade];
		
		
		$sql_exameedit = "SELECT DISTINCT ce.preco_exame
					 FROM clinica_exame ce, exame e, clinicas c
					 where ce.cod_exame = e.cod_exame AND ce.cod_clinica = c.cod_clinica AND ce.cod_clinica = $cod_clinica AND ce.cod_exame = $codigo_exame";
		$result_exameedit = pg_query($sql_exameedit);
		$examesedit = pg_fetch_all($result_exameedit);
		
		$precoexame = $examesedit[preco_exame];
		
		
		
		
		echo "<form action='?do=cad_clin&editar={$codigo_exame}' method='post' name='formedit'>";
		echo "<table width=100% border=0>";
		echo "<tr>";
		echo "<td align='center'>";
		echo "$nome_exame";
		echo "</td>";
		
		echo "<td align='center'>";
		echo "Preço: <input type='text' name='editpreco' id='editpreco' style='width:80px;' onkeypress=\"return FormataReais(this, '.', ',', event);\">";
		echo "</td>";
		
		echo "<td align='center'>";
		echo "<input type='submit' value='Editar'>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	}
	
	
	?>
	
	<form action="?do=cad_clin" method="post" name="form1">
	<?php
	echo "";
	if($cd[0]['ativo']==0){
		echo "  <table width=100% border=0>";
		echo "	<tr>";
		echo "		<td colspan=2>";
		echo "			<table width=\"100%\" border=\"1\" align=\"center\">";
		echo "				<tr>";
		echo "					<td>";
	
		echo "<center>PENDÊNCIAS</center><p>";
		echo "<p align=justify style=\"line-height: 150%;\">
		Prezado(ª) Sr(ª) {$cd[0]['contato_clinica']}, solicito imprimir o contrato em duas vias, ler o contrato atentamente e rubricar cada folha, porém, a última deverá ser assinada, reconhecido firma da assinatura e envida à SESMT via correios.";
		echo "<br>";
		echo "Remeter junto com a nossa via do contrato, e cópia da primeira e última folha do contrato social ou estatuto.";
		echo "<p>";
		echo "Faça o download do contrato <a href='contratos/clinica.php?cnpj={$cd[0]['cnpj_clinica']}'>clicando aqui</a>.";
		echo "<p>";
		
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		echo "<p>";
	}
		$sql = "SELECT * FROM clinicas WHERE cod_clinica = $cod_clinica";
		$result = pg_query($sql);
		$buffer = pg_fetch_array($result);
	
		$sql_exame = "SELECT DISTINCT ce.cod_clinica, ce.cod_exame, e.especialidade, ce.preco_exame
					 FROM clinica_exame ce, exame e, clinicas c
					 where ce.cod_exame = e.cod_exame and ce.cod_clinica = c.cod_clinica and ce.cod_clinica = $cod_clinica";
		$result_exame = pg_query($sql_exame);
		$exames = pg_fetch_all($result_exame);
		
	if(pg_num_rows($result_exame)>0){
		echo "  <table width=100% border=0>";
		echo "	<tr>";
		echo "		<td colspan=2>";
		echo "			<table width=\"100%\" border=\"1\" align=\"center\">";
		echo "				<tr>";
		echo "					<th>Ações</th>";
		echo "					<th>Exames já cadastrados</th>";
		echo "					<th width=90 class='text curhand' alt='Valor repassado ao cliente' title='Valor repassado ao cliente'>Preço</th>";
		echo "					<th width=90 class='text curhand' alt='Valor repassado a SESMT' title='Valor repassado a SESMT'>% cobrado</th>";
		echo "					<th width=90 class='text curhand' alt='Valor que fica com a clínia' title='Valor que fica com a clínica'>Clínica</th>";
		echo "				</tr>";
		$total = 0;
		//while($row_exame = pg_fetch_array($result_exame)){
		for($x=0;$x<pg_num_rows($result_exame);$x++){
		$per = ($exames[$x]['preco_exame'] * $buffer[por_exames])/100;
		echo "				<tr>";
		echo "					<th><a href=\"?do=cad_clin&exame={$exames[$x][cod_exame]}\"><u>Excluir</u></a> / <a href=\"?do=cad_clin&editar={$exames[$x][cod_exame]}\"><u>Editar</u></a></th>";
		echo "					<td align=left>{$exames[$x][especialidade]}</td>";
		echo "			        <td align=left>&nbsp;&nbsp; R$ ".number_format($exames[$x][preco_exame], 2, ',', '.')."</td>";
		echo "			        <td align=left>&nbsp;&nbsp; R$ ".number_format($per, 2, ',', '.')."</td>";
		echo "			        <td align=left>&nbsp;&nbsp; R$ ".number_format(($exames[$x]['preco_exame']-$per), 2, ',','.')."</td>";
		echo "				</tr>";
			$exame_fora = $exame_fora . ", $exames[cod_exame]";
	/***************************/
		}
		echo "			</table>";
		echo "		</td>";
		echo "	</tr>";
		echo "	<tr>";
		echo "		<th colspan=2>&nbsp;</th>";
		echo "	</tr>";
	}
	
		if (!empty($cod_clinica) ) {
			$sql_tem_exame = "SELECT cod_exame, cod_clinica FROM clinica_exame WHERE cod_clinica = $cod_clinica";
			$result_tem_exame = pg_query($sql_tem_exame);
			if ( pg_num_rows($result_tem_exame)==0 ){ // se NÃO tiver nada cadastrado
				$query_exame = "SELECT cod_exame, especialidade FROM exame";
			}
			else{ // se tiver cadastrado
				while ( $exame_fora = pg_fetch_array($result_tem_exame) ){ // monta variável com valores que serão excluídos da consulta
					$row_fora = $row_fora . ", $exame_fora[cod_exame]";
				}
				$query_exame = "SELECT cod_exame, especialidade FROM exame where cod_exame not in (" . substr($row_fora,2,500) . ")"; /* como o primeiro caracter é vígula, pegar a partir do segundo para não dar erro na consulta*/
			}
			$result_exame = pg_query($query_exame);
	
			echo "<table width=\"100%\" border=\"0\" align=\"center\">
				   <tr>
					<th bgcolor=\"#FFFFFF\" colspan=\"2\"><center>Cadastro de Preços dos Exames</center></th>
				  </tr><p>";
					while($row_exame=pg_fetch_array($result_exame)){
					echo "<tr>
							<td width=\"50%\" align=\"left\" class=\"fontebranca10 style1\">
								<input type=\"hidden\" name=\"exame[]\" value=\"$row_exame[cod_exame]\">&nbsp;&nbsp; $row_exame[especialidade]
							</td>
							<td width=\"50%\" align=\"left\" class=\"fontebranca10 style1\">
								R$&nbsp;<input class=text type=\"text\" name=\"preco_exame[]\" size='18' onkeypress=\"return FormataReais(this, '.', ',', event);\" >&nbsp;&nbsp;<br>
							</td>
						</tr>";
					}
				echo " </table>";
		}
		?><br />
	<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" align="center">
		<tr>
			<th>
				<input type="submit" name="btn_gravar" value="Confirmar Preços" class=button style="width:100;" >
				<!--input type="button" name="btn_visitar" value="Agendar Visíta" class=button style="width:100;" onclick="location.href='site.php?page=fornecedores&p=agendar_visita_clinica';"-->
				<input type="hidden" name="cod_clinica" value="<?php echo $cod_clinica; ?>" />
				<input type="hidden" name="exame[]" value="<?php echo $exame; ?>" />
			</th>
		</tr>
	</table>
	</form>  <p>
	<?PHP
	}
}else{
	echo "- Você não tem permissão para acessar essa página.";
}
?>