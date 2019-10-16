<?PHP
//VARIAVEIS
$dt 			= 	explode('/', $_POST['data']);
$data			=	$dt[2]."-".$dt[1]."-".$dt[0];
$enviar			=	$_POST[enviar];
$hora			=	$_POST[hora];
if($_POST[ativo]){
	$c_ativo		=	$_POST[ativo];
}else{
	$c_ativo		=	0;
}
if($_POST[comercial]){
	$c_comercial	=	$_POST[comercial];
}else{
	$c_comercial	=	0;
}
if($_POST[parceria]){
	$c_parceria		=	$_POST[parceria];
}else{
	$c_parceria		=	0;
}
if($_POST[contador]){
	$c_contador 	=	$_POST[contador];
}else{
	$c_contador		=	0;
}

if($_POST[cortesia]){
	$c_cortesia		=	$_POST[cortesia];
}else{
	$c_cortesia		=	0;
}

if($_POST[todos]){
	$todos		=	$_POST[todos];
	if($todos == 1){
		$c_cortesia		=	1;
		$c_parceria		=	1;
		$c_comercial	=	1;
		$c_ativo		=	1;
		$c_contador		=	1;
		$todos			=	1;
	}
}else{
	$todos		=	0;
}
$meses			=	$_POST[meses];

//PEGAR ID DA ULTIMA MENSAGEM CADASTRADA
$sql = "SELECT cod_mensagem FROM gm_txt ORDER BY cod_mensagem DESC";
$query = pg_query($sql);
$list = pg_fetch_all($query);
$cod_mensagem = $list[0][cod_mensagem];

//CADASTRAR OPÇÕES DE ENVIO
if($_GET[sv] == 1){
	//CADASTRAR PRIMEIRA DATA
	$sql = "INSERT INTO gm_dt(cod_mensagem, enviar, data, hora, c_ativo, c_comercial, c_parceria, c_cortesia, c_contador, c_todos) VALUES('$cod_mensagem', '$enviar', '$data', '$hora', '$c_ativo', '$c_comercial', '$c_parceria', '$c_cortesia', '$c_contador', '$todos')";
	$query = pg_query($sql);
	//CADASTRAR REPETIÇÃO
	for($x=0;$x<count($meses);$x++){
		if($meses[$x] < 10){
			$meses[$x] = 0 . $meses[$x];
		}
		if($meses[$x] < date('m')){
			$ano = $dt[2] + 1;
		}elseif($meses[$x] > date('m')){
			$ano = $dt[2];
		}else{
			if($dt[0] > date('d')){
				$ano = $dt[2];
			}else{
				$ano = $dt[2] + 1;
			}
		}
		$dat = $ano."-".$meses[$x]."-".$dt[0];
		if($dt[1] != $meses[$x]){
			$sql = "INSERT INTO gm_dt(cod_mensagem, enviar, data, hora, c_ativo, c_comercial, c_parceria, c_cortesia, c_contador, c_todos) VALUES('$cod_mensagem', '$enviar', '$dat', '$hora', '$c_ativo', '$c_comercial', '$c_parceria', '$c_cortesia', '$c_contador', '$todos')";
			$query = pg_query($sql);
		}
	}
}

//DELETAR MENSAGEM
if($_GET[del] == 1){
	//FAZER UM BACKUP DA MENSAGEM
	$sql1x = "INSERT INTO gm_txt_save (cod_mensagem, titulo, mensagem, mostrar, usuario, tipo, setor) SELECT cod_mensagem, titulo, mensagem, mostrar, usuario, tipo, setor FROM gm_txt WHERE cod_mensagem = '$_GET[cod]'";
	$query1x = @pg_query($sql1x);
	//DELETAR TEXTO
	$sql1 = "DELETE FROM gm_txt WHERE cod_mensagem = '$_GET[cod]'";
	$query1 = @pg_query($sql1);
	//DELETAR CONFIGURAÇÃOES DE ENVIO
	$sql2 = "DELETE FROM gm_dt WHERE cod_mensagem = '$_GET[cod]'";
	$query2 = @pg_query($sql2);
}

//DADOS PASSADOS NA PRIMEIRA ETAPA
$usuario = $_SESSION[usuario_id];
$mensagem = $_POST[mensagem];
$titulo = $_POST[titulo];
$setor = $_POST[setor];
$mostrar = $_POST[mostrar];
$tipo = $_GET[tp];
if($usuario == 1 || $usuario == 4 || $usuario == 43){
	$adm = 1;
}else{
	$adm = 0;
}

//SELECIONAR MENSAGENS CADASTRADAS
$sql = "SELECT * FROM gm_txt WHERE tipo = '$_GET[tp]'";
if($adm == 0){
$sql .= " AND usuario = '$usuario' ";
}
$queryl = @pg_query($sql);
$lista = @pg_fetch_all($queryl);

if($titulo != '' && $mensagem != '' && $setor != '' && $mostrar != '' && $_GET[act] == "new2"){
	//INSERT DA PRIMEIRA ETAPA
	$sql = "INSERT INTO gm_txt (setor, titulo, mensagem, mostrar, tipo, usuario) 
						VALUES ('$setor', '$titulo', '$mensagem', '$mostrar', '$tipo', '$usuario')";
	if(pg_query($sql)){
		showMessage('<p align=justify>Mensagem cadastrada com sucesso. Configure agora as opções de envio.</p>');
	}else{
		showMessage('<p align=justify>Houve um error ao cadastrar a mensagem.</p>');
	}
}else if($titulo != '' && $mensagem != '' && $_GET[act] == "new2"){
	//INSERT DA PRIMEIRA ETAPA
	$sql = "INSERT INTO gm_txt (setor, titulo, mensagem, mostrar, tipo, usuario) 
						VALUES ('Setor', '$titulo', '$mensagem', '0', '$tipo', '$usuario')";
	if(pg_query($sql)){
		showMessage('<p align=justify>Mensagem cadastrada com sucesso. Configure agora as opções de envio.</p>');
	}else{
		showMessage('<p align=justify>Houve um error ao cadastrar a mensagem.</p>');
	}
}
//UPDATE DO TEXTO DA MENSAGEM
if($_GET[sv] == 2){
	if($_GET[tp] == 1){
	$sql = "UPDATE gm_txt SET setor = '$setor', titulo = '$titulo', mensagem = '$mensagem', mostrar = 0 WHERE cod_mensagem = '$_GET[cod]'";
	}else{
	$sql = "UPDATE gm_txt SET setor = '$setor', titulo = '$titulo', mensagem = '$mensagem', mostrar = '$mostrar' WHERE cod_mensagem = '$_GET[cod]'";
	}
	if(pg_query($sql)){
		showMessage('<p align=justify>Mensagem editada com sucesso.</p>');
	}else{
		showMessage('<p align=justify>Houve um error ao editar a mensagem.</p>');
	}	
	echo '<script type="text/javascript">
	window.location = "?dir=gerencia_mensagens&p=index&act=list&cod='.$_GET[cod].'&tp='.$_GET[tp].'";
	</script>';
}
//UPDATE DAS OPÇÕES DE ENVIO
if($_GET[sv] == 3){
	$sql = "DELETE FROM gm_dt WHERE cod_mensagem = '$_GET[cod]'";
	$query = @pg_query($sql);
	$sql = "INSERT INTO gm_dt(cod_mensagem, enviar, data, hora, c_ativo, c_comercial, c_parceria, c_cortesia, c_contador, c_todos) VALUES('$cod_mensagem', '$enviar', '$data', '$hora', '$c_ativo', '$c_comercial', '$c_parceria', '$c_cortesia', '$c_contador', '$todos')";
	$query = pg_query($sql);
	for($x=0;$x<count($meses);$x++){
		if($meses[$x] < 10){
			$meses[$x] = 0 . $meses[$x];
		}
		if($meses[$x] < date('m')){
			$ano = $dt[2] + 1;
		}elseif($meses[$x] > date('m')){
			$ano = $dt[2];
		}else{
			if($dt[0] > date('d')){
				$ano = $dt[2];
			}else{
				$ano = $dt[2] + 1;
			}
		}
		$dat = $ano."-".$meses[$x]."-".$dt[0];
		if($dt[1] != $meses[$x]){
			$sql = "INSERT INTO gm_dt(cod_mensagem, enviar, data, hora, c_ativo, c_comercial, c_parceria, c_cortesia, c_contador, c_todos) VALUES('$cod_mensagem', '$enviar', '$dat', '$hora', '$c_ativo', '$c_comercial', '$c_parceria', '$c_cortesia', '$c_contador', '$todos')";
			$query = pg_query($sql);
		}
	}

}
echo "<html>";
echo "<head><!-- CDN hosted by Cachefly -->";
echo '
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
        tinymce.init({selector:\'textarea\'});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

';
echo "</head>";
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
		echo "<tr>";
		echo "<td><br><center>";
		if(!$_GET[tp]){
			echo '<input type="button" name="new" id="new" value="Pessoal" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index&tp=1" />';
			echo "<br><br>";
			echo '<input type="button" name="list" id="list" value="Comercial" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index&tp=2" />';
			echo "<br><br>";
			echo '<input type="button" name="list" id="list" value="Voltar" class="btn" onclick=location.href="index.php" />';
			echo "</center></td>";
			echo "</center></td>";
			echo "</tr>";
		}
		if($_GET[tp] == 1){
			echo '<input type="button" name="new" id="new" value="Nova Mensagem" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index&act=new&tp='.$_GET[tp].'" />';
			echo "<br><br>";
			echo '<input type="button" name="list" id="list" value="Ver Mensagens" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index&act=list&tp='.$_GET[tp].'" />';
			echo "<br><br>";
			echo '<input type="button" name="list" id="list" value="Voltar" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index" />';
			echo "</center></td>";
			echo "</tr>";
		}
		
		if($_GET[tp] == 2){
			echo '<input type="button" name="new" id="new" value="Nova Mensagem" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index&act=new&tp='.$_GET[tp].'" />';
			echo "<br><br>";
			echo '<input type="button" name="list" id="list" value="Ver Mensagens" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index&act=list&tp='.$_GET[tp].'" />';
			echo "<br><br>";
			echo '<input type="button" name="list" id="list" value="Voltar" class="btn" onclick=location.href="?dir=gerencia_mensagens&p=index" />';
			echo "</center></td>";
			echo "</tr>";
		}
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
			echo "<td width=50% class=text align=center >";
				//LISTAR MENSAGENS CADASTRADAS
				if($_GET[act] == "list"){
					echo "<table width=100% border=0 cellpadding=2 cellspacing=2>";
						for($x=0;$x<pg_num_rows($queryl);$x++){
							echo "<tr>";
								echo "<td width=70% align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=gerencia_mensagens&p=index&act=edit1&tp=$_GET[tp]&cod={$lista[$x][cod_mensagem]}';\">";
									echo $lista[$x][titulo];
								echo "</td>";
								echo "<td width=10% align=center class='text roundbordermix curhand' onclick=\"location.href='?dir=gerencia_mensagens&p=index&act=edit2&tp=$_GET[tp]&cod={$lista[$x][cod_mensagem]}';\">";
									echo "Configurar";
								echo "</td>";
								echo "<td width=10% align=center class='text roundbordermix curhand'
onclick=\"location.href='?dir=gerencia_mensagens&p=index&act=list&del=1&tp=$_GET[tp]&cod={$lista[$x][cod_mensagem]}';\">";
									echo "Excluir";
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				}
				//CADASTRAR NOVA MENSAGEM
				if($_GET[act] == "new"){
					echo "<form name='gm_txt' action='?dir=gerencia_mensagens&p=index&act=new2&tp=".$_GET[tp]."' method='POST'>";
					echo "<table width=100% border=0 cellpadding=2 cellspacing=2>";
						echo "<tr>";
							echo "<td width=100% colspan=4 class='text roundborderselected' align=center >";
								echo "<b>Preencha o formulário abaixo para criar uma nova mensagem para o correio on-line</b>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td width='100%' colspan=4 class='text roundborder' align=left >";
								echo "<b>Título: </b><br>";
								echo "<input name='titulo' type='text' value='' style='width:700px;' />";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class='text roundborder' colspan=4 align=left>";
								echo "<b>Mensagem: </b><br>";
								echo "<textarea  name='mensagem' id='mensagem' rows='15' size='66' style='width:700px;' /></textarea>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align=left class='text roundborder'>";
								echo "<b>Setor Remetente:</b>";
								echo "<select name='setor' style='width:125px;'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo ">";
									echo "<option value=''>  </option>";
									echo "<option value='sac'> Sac </option>";
									echo "<option value='comercial'> Comercial </option>";
									echo "<option value='financeiro'> Financeiro </option>";
									echo "<option value='juridico'> Juridico </option>";
									echo "<option value='parceria'> Parceria </option>";
									echo "<option value='marketing'> Marketing </option>";
									echo "<option value='suporte'> Suporte </option>";
									echo "<option value='medico'> Médico </option>";
									echo "<option value='tecnico'> Técnico </option>";
									echo "<option value='compras'> Compras </option>";
								echo "</select>";
							echo "</td>";
							echo "<td align=left class='text roundborder'>";
								echo "<b>Mostrar no site:</b>";
								echo "<select name='mostrar' size='1' style='width:125px;'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo ">";
									echo "<option value=''>  </option>";
									echo "<option value='0'> Não </option>";
									echo "<option value='1'> Sim </option>";
								echo "</select>";
							echo "</td>";
							echo "<td align=center class='text roundborder'>";
								echo '<input type="reset" name="reset" id="reset" value="Limpar" class="btn">';
							echo "</td>";
							echo "<td align=center class='text roundborder'>";
								echo '<input type="submit" name="new" id="new" value="Avançar >>" class="btn">';
							echo "</td>";
						echo "</tr>";
					echo "</form>";
					echo "</table>";
				//CADASTRAR OPÇÕES DE ENVIO
				}elseif($_GET[act] == "new2"){
					echo "<table width='100%'>";
					echo "<form name='gm_txt' action='?dir=gerencia_mensagens&p=index&act=list&sv=1&tp=".$_GET[tp]."' method='POST'>";
						echo "<tr>";
							echo "<td width=100% colspan=4 class='text roundborderselected' align=center >";
								echo "<b>Preencha as opções de envio da mensagem selecionada</b>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td width='50%' class='text roundborder' align=left rowspan=4>";
								echo "<b>Meses a enviar: </b><br>";
								echo "<input type='checkbox' name='meses[]' value='1' /> Janeiro<br>";
								echo "<input type='checkbox' name='meses[]' value='2' /> Fevereiro<br>";
								echo "<input type='checkbox' name='meses[]' value='3' /> Março<br>";
								echo "<input type='checkbox' name='meses[]' value='4' /> Abril<br>";
								echo "<input type='checkbox' name='meses[]' value='5' /> Maio<br>";								
								echo "<input type='checkbox' name='meses[]' value='6' /> Junho<br>";
								echo "<input type='checkbox' name='meses[]' value='7' /> Julho<br>";
								echo "<input type='checkbox' name='meses[]' value='8' /> Agosto<br>";
								echo "<input type='checkbox' name='meses[]' value='9' /> Setembro<br>";
								echo "<input type='checkbox' name='meses[]' value='10' /> Outubro<br>";
								echo "<input type='checkbox' name='meses[]' value='11' /> Novembro<br>";
								echo "<input type='checkbox' name='meses[]' value='12' /> Dezembro<br>";
							echo "</td>";
							echo "<td width='50%' class='text roundborder' align=left colspan='4'>";
							echo "<b>Data para 1° envio: </b>";
							echo "<input name='data' type='text' style='width:70px;' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"> ";
							echo "<b>Hora: </b>";
							echo "<input name='hora' type='text' style='width:50px;' maxlength=5 onkeypress=\"formatar(this, '##:##');\"> ";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
						
							echo "<td width='50%' class='text roundborder' align=left colspan='3'>";
								echo "<b>Destinatários: </b><br>";
								echo "<input type='checkbox' value='1' name='ativo' ";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo "/> Ativo<br>";
								echo "<input type='checkbox' value='1' name='comercial' ";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo "/> Comercial<br>";
								echo "<input type='checkbox' value='1' name='parceria' ";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo "/> Parceria<br>";
								echo "<input type='checkbox' value='1' name='cortesia'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo " /> Cortesia<br>";
								echo "<input type='checkbox' value='1' name='contador'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo " /> Contador<br>";
								echo "<input type='checkbox' value='1' name='todos'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo " /> Todos";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='50%' class='text roundborder' align=left colspan='3'>";
								echo "<b>Ativar envio: </b>";
								echo "<select name='enviar' size='1' style='width:125px;'>";
									echo "<option value=''>  </option>";
									echo "<option value='1'> Sim </option>";
									echo "<option value='0'> Não </option>";
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='16%' class='text roundborder' align=center>";
								echo '<input type="button" name="voltar" id="voltar" value="<< Voltar" class="btn" onClick="history.go(-1)">';
							echo "</td>";
							echo "<td width='18%' class='text roundborder' align=center>";
								echo '<input type="reset" name="reset" id="reset" value="Limpar" class="btn">';
							echo "</td>";
							echo "<td width='16%' align=center class='text roundborder'>";
								echo '<input type="submit" name="new" id="new" value="Concluir" class="btn">';
							echo "</td>";
						echo "</tr>";
					echo "</form>";	
					echo "</table>";
				//EDITAR MENSAGEM			
				}elseif($_GET[act] == "edit1"){
					$sql = "SELECT * FROM gm_txt WHERE cod_mensagem = $_GET[cod]";
					$query = pg_query($sql);
					$info = pg_fetch_array($query);					
					echo "<form name='gm_txt' action='?dir=gerencia_mensagens&p=index&act=list&sv=2&cod=".$_GET[cod]."&tp=".$_GET[tp]."' method='POST'>";
					echo "<table width=100% border=0 cellpadding=2 cellspacing=2>";
						echo "<tr>";
							echo "<td width=100% colspan=4 class='text roundborderselected' align=center >";
								echo "<b>Preencha o formulário abaixo para criar uma nova mensagem para o correio on-line</b>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td width='100%' colspan=4 class='text roundborder' align=left >";
								echo "<b>Título: </b><br>";
								echo "<input name='titulo' type='text' value='$info[titulo]' style='width:700px;' />";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td class='text roundborder' colspan=4 align=left>";
								echo "<b>Mensagem: </b><br>";
								echo "<textarea  name='mensagem' id='mensagem' rows='15' size='66' style='width:700px;' />$info[mensagem]</textarea>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align=left class='text roundborder'>";
								echo "<b>Setor Remetente:</b>";
								echo "<select name='setor' style='width:125px;'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo ">";
									echo "<option value=''>  </option>";
									echo "<option value='comercial'";
									if($info[setor] == 'comercial'){
										echo " selected='selected' ";
									}
									echo "> Comercial </option>";
									echo "<option value='sac'";
									if($info[setor] == 'sac'){
										echo " selected='selected' ";
									}
									echo "> Sac </option>";
									echo "<option value='financeiro'";
									if($info[setor] == 'financeiro'){
										echo " selected='selected' ";
									}
									echo "> Financeiro </option>";
									echo "<option value='marketing'";
									if($info[setor] == 'marketing'){
										echo " selected='selected' ";
									}
									echo "> Marketing </option>";
									echo "<option value='juridico'";
									if($info[setor] == 'juridico'){
										echo " selected='selected' ";
									}
									echo "> Jurídico </option>";
									echo "<option value='parceria'";
									if($info[setor] == 'parceria'){
										echo " selected='selected' ";
									}
									echo "> Parceria </option>";
									echo "<option value='suporte'";
									if($info[setor] == 'suporte'){
										echo " selected='selected' ";
									}
									echo "> Suporte </option>";
									echo "<option value='medico'";
									if($info[setor] == 'medico'){
										echo " selected='selected' ";
									}
									echo "> Médico </option>";
									echo "<option value='tecnico'";
									if($info[setor] == 'tecnico'){
										echo " selected='selected' ";
									}
									echo "> Técnico </option>";
									echo "<option value='compras'";
									if($info[setor] == 'compras'){
										echo " selected='selected' ";
									}
									echo "> Compras </option>";
								echo "</select>";
							echo "</td>";
							echo "<td align=left class='text roundborder'>";
								echo "<b>Mostrar no site:</b>";
								echo "<select name='mostrar' size='1' style='width:125px;'";
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo ">";
									echo "<option value=''>  </option>";
									echo "<option value='0'";
									if($info[mostrar] == 0){
										echo " selected='selected' ";
									}
									echo "> Não </option>";
									echo "<option value='1'";
									if($info[mostrar] == 1){
										echo " selected='selected' ";
									}
									echo "> Sim </option>";
								echo "</select>";
							echo "</td>";
							echo "<td align=center class='text roundborder'>";
								echo '<input type="reset" name="reset" id="reset" value="Limpar" class="btn">';
							echo "</td>";
							echo "<td align=center class='text roundborder'>";
								echo '<input type="submit" name="new" id="new" value="Concluir" class="btn">';
							echo "</td>";
						echo "</tr>";
					echo "</form>";
					echo "</table>";
				}
				
				//EDITAR OPÇOES DE ENVIO			
				elseif($_GET[act] == "edit2"){
					$sql = "SELECT * FROM gm_dt WHERE cod_mensagem = $_GET[cod] ORDER BY data";
					$query = pg_query($sql);
					$lista = pg_fetch_all($query);
					$dt1 = explode('-', $lista[0][data]);
					$data1 =	$dt1[2]."/".$dt1[1]."/".$dt1[0];
					for($x=1;$x<pg_num_rows($query);$x++){
						$dt = explode('-', $lista[$x][data]);
						$mm[$x] = $dt[1];	
					}
					echo "<table width='100%'>";
					echo "<form name='gm_txt' action='?dir=gerencia_mensagens&p=index&act=edit2&sv=3&cod=$_GET[cod]&tp=".$_GET[tp]."' method='POST'>";
						echo "<tr>";
							echo "<td width=100% colspan=4 class='text roundborderselected' align=center >";
								echo "<b>Preencha as opções de envio da mensagem selecionada</b>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td width='50%' class='text roundborder' align=left rowspan=4>";
								echo "<b>Meses a enviar: </b><br>";
								echo "<input type='checkbox' name='meses[]' value='1'";
								if(@in_array('01', $mm)){
									echo " checked='checked' ";
								}
								echo " /> Janeiro<br>";
								echo "<input type='checkbox' name='meses[]' value='2'";
								if(@in_array('02', $mm)){
									echo " checked='checked' ";
								}
								echo " /> Fevereiro<br>";
								echo "<input type='checkbox' name='meses[]' value='3' ";
								if(@in_array('03', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Março<br>";
								echo "<input type='checkbox' name='meses[]' value='4' ";
								if(@in_array('04', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Abril<br>";
								echo "<input type='checkbox' name='meses[]' value='5' ";
								if(@in_array('05', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Maio<br>";								
								echo "<input type='checkbox' name='meses[]' value='6' ";
								if(@in_array('06', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Junho<br>";
								echo "<input type='checkbox' name='meses[]' value='7' ";
								if(@in_array('07', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Julho<br>";
								echo "<input type='checkbox' name='meses[]' value='8' ";
								if(@in_array('08', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Agosto<br>";
								echo "<input type='checkbox' name='meses[]' value='9' ";
								if(@in_array('09', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Setembro<br>";
								echo "<input type='checkbox' name='meses[]' value='10'";
								if(@in_array('10', $mm)){
									echo " checked='checked' ";
								}
								echo " /> Outubro<br>";
								echo "<input type='checkbox' name='meses[]' value='11' ";
								if(@in_array('11', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Novembro<br>";
								echo "<input type='checkbox' name='meses[]' value='12' ";
								if(@in_array('12', $mm)){
									echo " checked='checked' ";
								}
								echo "/> Dezembro<br>";
							echo "</td>";
							echo "<td width='50%' class='text roundborder' align=left colspan='4'>";
							echo "<b>Data para 1° envio: </b>";
							echo "<input name='data' type='text' style='width:70px;' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" value='$data1'> ";
							echo "<b>Hora: </b>";
							echo "<input name='hora' type='text' style='width:50px;' maxlength=5 onkeypress=\"formatar(this, '##:##');\" value='{$lista[0][hora]}'> ";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
						
							echo "<td width='50%' class='text roundborder' align=left colspan='3'>";
								echo "<b>Destinatários: </b><br>";
								echo "<input type='checkbox' value='1' name='ativo' ";
								if($lista[0][c_ativo] == 1){
									echo "checked='checked'";
								}
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo "/> Ativo<br>";
								echo "<input type='checkbox' value='1' name='comercial' ";
								if($lista[0][c_comercial] == 1){
									echo "checked='checked'";
								}
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo "/> Comercial<br>";
								echo "<input type='checkbox' value='1' name='parceria' ";
								if($lista[0][c_parceria] == 1){
									echo "checked='checked'";
								}
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo "/> Parceria<br>";
								echo "<input type='checkbox' value='1' name='cortesia'";
								if($lista[0][c_cortesia] == 1){
									echo "checked='checked'";
								}
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo " /> Cortesia<br>";
								echo "<input type='checkbox' value='1' name='contador'";
								if($lista[0][c_contador] == 1){
									echo "checked='checked'";
								}
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo " /> Contador<br>";
								echo "<input type='checkbox' value='1' name='todos'";
								if($lista[0][c_todos] == 1){
									echo "checked='checked'";
								}
								if($_GET[tp] == 1){
									echo "disabled='disabled'";
								}
								echo " /> Todos";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='50%' class='text roundborder' align=left colspan='3'>";
								echo "<b>Ativar envio: </b>";
								echo "<select name='enviar' size='1' style='width:125px;'>";
									echo "<option value=''>  </option>";
									echo "<option value='1'";
									if($lista[0][enviar] == 1){
										echo " selected='selected' ";
									}
									echo "> Sim </option>";
									echo "<option value='0'";
									if($lista[0][enviar] == 0){
										echo " selected='selected' ";
									}
									echo "> Não </option>";
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='16%' class='text roundborder' align=center>";
								echo '<input type="button" name="voltar" id="voltar" value="<< Voltar" class="btn" onClick="history.go(-1)">';
							echo "</td>";
							echo "<td width='18%' class='text roundborder' align=center>";
								echo '<input type="reset" name="reset" id="reset" value="Limpar" class="btn">';
							echo "</td>";
							echo "<td width='16%' align=center class='text roundborder'>";
								echo '<input type="submit" name="new" id="new" value="Concluir" class="btn">';
							echo "</td>";
						echo "</tr>";
					echo "</form>";	
					echo "</table>";
				}
			echo "</td>";
		echo "</tr>";
	echo '</table>';
	
echo "</td>";
echo "</tr>";
echo "</table>";

?>