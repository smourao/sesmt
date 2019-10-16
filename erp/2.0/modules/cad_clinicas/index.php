<?PHP

switch($_GET[r]){
	case 1:
	    showmessage('Exame Excluido com Sucesso!');
	break;
	case 2:
	    showmessage('Erro ao Excluir!');
	break;
	case 3:
	    showmessage('Exame Cadastrado com Sucesso!');
	break;
	case 4:
	    showmessage('Erro ao Cadastrar!');
	break;
}; 

/***************MENSAGEM VINDA DO CADASTRO DE CL�NICAS******************/
switch($_GET[a]){
	case 1:
	    showmessage('Cl�nica Cadastrada com Sucesso!');
	break;
	case 2:
	    showmessage('Erro ao Cadastrar Cl�nica!');
	break;
}; 

$data = date("Y/m/d");

/******************APAGAR CL�NICAS DO SISTEMA*********************/
if($_GET[act] == "del" and $_GET['id']){
	$dell = "DELETE FROM clinicas WHERE cod_clinica = ".$_GET['id'];
	if(@pg_query($connect, $dell)){
		$delet = "DELETE FROM clinica_exame WHERE cod_clinica = ".$_GET['id'];
		pg_query($connect, $delet);
	}
	showmessage('Cl�nica Excluido com Sucesso!');
}

/******************APAGAR EXAME DO SISTEMA*********************/
if($_GET[exame]){
	$del = "DELETE FROM clinica_exame WHERE cod_exame = {$_GET[exame]} and cod_clinica = ".$_GET['id'];
	if(@pg_query($connect, $del)){
		redirectme("?dir=cad_clinicas&p=index&act=detail&id=$_GET[id]&r=1");
	}else{
		redirectme("?dir=cad_clinicas&p=index&act=detail&id=$_GET[id]&r=2");
	}
}

/********************GRAVAR NO SISTEMA********************/
if(!empty($_GET['id']) and $_POST[btnSave]=="Gravar"){
	if(isset($_POST["exame"])) { // verifica se tem exames selecionados
		$z = count($_POST['exame']);
		for($x=0;$x<$z;$x++) {
			if( empty($_POST["preco_exame"][$x]) ){
				$preco_exame = 0;
			}else{
				$preco_exame = str_replace(".","",$_POST["preco_exame"][$x]);
				$preco_exame = str_replace(",",".",$preco_exame);
			}
			$exame = $_POST['exame'][$x];
			$sql_verifica = "SELECT * FROM clinica_exame WHERE cod_clinica = {$_GET[id]} and cod_exame = $exame";
			$result_verifica = pg_query($connect, $sql_verifica)
				or die ("Erro na query: $sql_verifica ==> " . pg_last_error($connect) );
            $n = pg_num_rows($result_verifica);
            if($n==0 && $preco_exame!="" && $exame!=""){
			$query_exame = "INSERT INTO clinica_exame(cod_clinica, cod_exame, preco_exame, data)
							VALUES 
							($_GET[id], $exame, $preco_exame, '$data');";

	            if(@pg_query($connect, $query_exame)){
					redirectme("?dir=cad_clinicas&p=index&act=detail&id=$_GET[id]&r=3");
				}else{
					redirectme("?dir=cad_clinicas&p=index&act=detail&id=$_GET[id]&r=4");
				}
			}
		}
	}
}

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_GET['acao']=="ativo"){
$sql = "UPDATE clinicas SET ativo=1 WHERE cod_clinica = ".$_GET['id'];
	if(@pg_query($connect, $sql)){
		showmessage('Status da cl�nica ativada!');
	}else{
	    showmessage('Erro ao tentar ativar status da cl�nica!');
	}
}elseif($_GET['acao']=="inativo"){
$sql = "UPDATE clinicas SET ativo=0 WHERE cod_clinica = ".$_GET['id'];
	if(@pg_query($connect, $sql)){
		showmessage('Status da cl�nica desativada!');
	}else{
	    showmessage('Erro ao tentar desativar status da cl�nica!');
	}
}



if($_GET['act']=="ativar"){
$sql = "UPDATE clinicas SET ativo=1 WHERE cod_clinica = ".$_GET['id'];
	if(@pg_query($connect, $sql)){
		$pegaremailsql = "SELECT email_clinica FROM clinicas WHERE cod_clinica = ".$_GET['id'];
		$pegaremailquery = pg_query($pegaremailsql);
		$pegaremail = pg_fetch_array($pegaremailquery);
		$email_clinica = $pegaremail['email_clinica'];		
		
		$email = $email_clinica.";comercial@sesmt-rio.com;suporte@ti-seg.com" ;
		
		$titulo = "SESMT: Comunicado Importante.";		
		
		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
	               <HTML>
	               <HEAD>
	                  <TITLE>Comunicado Importante</TITLE>
	            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
	               </HEAD>
	               <BODY>
	            <font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><p><font face='verdana,arial,sans-serif' size='3'>Prezado(s) Senhor(�), venho por meio deste comunicar que seu cadastro esta ativado em nosso sistema.</font>
	               </BODY>
	            </HTML>";		
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();						

		if(mail($email, $titulo, $msg, $headers)){			
			showmessage('Cl�nica Ativada!');
		}
	}else{
	    showmessage('Erro ao Ativar Cl�nica!');
	}
}elseif($_GET['act']=="desativar"){
$sql = "UPDATE clinicas SET ativo=0 WHERE cod_clinica = ".$_GET['id'];
	if(@pg_query($connect, $sql)){
		$pegaremailsql = "SELECT email_clinica FROM clinicas WHERE cod_clinica = ".$_GET['id'];
		$pegaremailquery = pg_query($pegaremailsql);
		$pegaremail = pg_fetch_array($pegaremailquery);
		$email_clinica = $pegaremail['email_clinica'];		
		
		$email = $email_clinica.";comercial@sesmt-rio.com;suporte@ti-seg.com" ;
		
		$titulo = "SESMT: Comunicado Importante.";		
		
		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
	               <HTML>
	               <HEAD>
	                  <TITLE>Comunicado Importante</TITLE>
	            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
	               </HEAD>
	               <BODY>
	            <font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><p><font face='verdana,arial,sans-serif' size='3'>Prezado(s) Senhor(�), venho por meio deste comunicar que seu cadastro esta desativado em nosso sistema por gentileza entrar em contato com a administra��o da empresa SESMT para tomada de conhecimento das causa, caso a desconhe�a.</font>
	               </BODY>
	            </HTML>";		
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();						

		if(mail($email, $titulo, $msg, $headers)){			
			showmessage('Cl�nica Desativada!');
		}
	}else{
		showmessage('Erro ao Desativar Cl�nica!');
	}
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Selecione uma op��o</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=cad_clinicas&p=i_clinica';\"  onmouseover=\"showtip('tipbox', '- Permite incluir uma cl�nica na lista.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Cl�nicas Cadastradas</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$sql = "SELECT * FROM clinicas ORDER BY cod_clinica";
	$res = pg_query($connect, $sql);
	$buffer = pg_fetch_all($res);
	
	if($_GET[act]!="detail"){

/**************************************************************************************************/
// --> PARTE QUE TRATA DA LISTA DE CL�NICAS DO SISTEMA
/**************************************************************************************************/
	echo "<table width=100% border=0 cellpadding=2 cellspacing=2>";
	echo "<tr>";
	echo "<td width=400 class=text align=center ><b>Raz�o Social</b></td>";
	echo "<td class=text align=center ><b>Editar</b></td>";
	echo "<td class=text align=center ><b>Excluir</b></td>";
	echo "<td class=text align=center title='Desativar cl�nica sem mandar msg de email' ><b>Status</b></td>";
	echo "<td class=text align=center ><b>A��o</b></td>";
    echo "</tr>";

	   for($x=0;$x<pg_num_rows($res);$x++){
		  echo "<tr class='text roundbordermix'>";
		  echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cad_clinicas&p=index&act=detail&id={$buffer[$x][cod_clinica]}';\" alt='Clique' title='Clique aqui para visualizar os exames cadastrados'>{$buffer[$x]['razao_social_clinica']}&nbsp;</td>";
		  echo "<td align=center class='text roundborder '><a href=\"?dir=cad_clinicas&p=a_clinica&id={$buffer[$x][cod_clinica]}\"><u>Editar</u></a></td>";
		  echo "<td align=center class='text roundborder '><a href=\"?dir=cad_clinicas&p=index&act=del&id={$buffer[$x][cod_clinica]}\"><u>Excluir</u></a></td>";
		  
		  echo "<td class='text roundborder curhand' align=center style=\"font-height: bold;\" >
		  <a href='?dir=cad_clinicas&p=index&acao=";
		  print $buffer[$x]['ativo'] == 0 ? "ativo" : "inativo";
		  echo "&id={$buffer[$x]['cod_clinica']}' class="; print $buffer[$x]['ativo'] == 0 ? "linksistema" : "linksistema";echo">";
		  print $buffer[$x]['ativo'] == 0 ? "<font color=red><b>Inativo</b></font>" : "<font color=green><b>Ativo</b></font>";
		  echo "</a></td>";
		  
		  echo "<td align=center class='text roundborder curhand' >
		  <a href='?dir=cad_clinicas&p=index&act=";
		  print $buffer[$x]['ativo'] == 0 ? "ativar" : "desativar";
		  echo "&id={$buffer[$x]['cod_clinica']}' class="; print $buffer[$x]['ativo'] == 0 ? "linksistema" : "linksistema";echo">";
		  print $buffer[$x]['ativo'] == 0 ? "Ativar" : "Desativar";
		  echo"</a> </td>";
		  echo "</tr>";
	   }
	   echo "</table>";
	}elseif($_GET['act']=='detail'){
	   $_GET['id'];
	   $sql = "SELECT * FROM clinicas WHERE cod_clinica = '{$_GET['id']}'";
	   $res = pg_query($sql);
	   $buffer = pg_fetch_array($res);
	   echo " <form name=form1 method=post action='?dir=cad_clinicas&p=index&act=detail&id=$_GET[id]'>";
/**************************************************************************************************/
// --> PARTE QUE EXIBE OS DADOS DA CL�NICA
/**************************************************************************************************/
	   echo '<center><b><font color=white>'.$buffer[razao_social_clinica].'</font></b><br>
			 <font color=white size=1><b>CNPJ: ';
	   print $buffer[cnpj_clinica] != "" ? $buffer[cnpj_clinica] : "N/D";
	   echo '</b></font></center>';
	   echo '<p>';
	   echo '<table width=100% border=0 cellpadding=2 cellspacing=2>';
	   echo '<tr>';
	   echo '    <td class="text roundborder " width=30%><b>Endere�o</b></td><td class="text roundborder " >'.$buffer[endereco_clinica].' N�'.$buffer[num_end].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Complemento</b></td><td class="text roundborder ">'.$buffer[complemento].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Bairro</b></td><td class="text roundborder ">'.$buffer[bairro_clinica].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Cidade/Estado</b></td><td class="text roundborder ">'.$buffer[cidade].'/'.$buffer[estado].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>CEP</b></td><td class="text roundborder ">'.$buffer[cep_clinica].'&nbsp;</td>';
	   echo '</tr>';
	if(!empty($buffer[referencia_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Ponto de Refer�ncia</b></td><td class="text roundborder ">'.$buffer[referencia_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[tel_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Telefone</b></td><td class="text roundborder ">'.$buffer[tel_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[fax_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Fax</b></td><td class="text roundborder ">'.$buffer[fax_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>E-Mail</b></td><td class="text roundborder "><a href="mailto:'.$buffer[email_clinica].'">'.$buffer[email_clinica].'</a>&nbsp;</td>';
	   echo '</tr>';
	if(!empty($buffer[contato_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Pessoa de Contato</b></td><td class="text roundborder ">'.$buffer[contato_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[cargo_responsavel])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Cargo Contato</b></td><td class="text roundborder ">'.$buffer[cargo_responsavel].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[tel_contato])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Tel Contato</b></td><td class="text roundborder ">'.$buffer[tel_contato].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[nextel_contato]) || !empty($buffer[id_nextel_contato])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Nextel</b></td><td class="text roundborder ">'.$buffer[nextel_contato].' - id '.$buffer[id_nextel_contato].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[email_contato])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>E-Mail Contato</b></td><td class="text roundborder "><a href="mailto:'.$buffer[email_contato].'">'.$buffer[email_contato].'</a>&nbsp;</td>';
	   echo '</tr>';
	}
	   echo '<tr>';
	   echo "    <td class='text roundborder '><b>Porcentagem Sobre Exames</b></td><td class='text roundborder '>{$buffer[por_exames]}%&nbsp;&nbsp;&nbsp;&nbsp;
	   <input type=text name=por_exames id=por_exames> exemplo: 5.00 para 5% <input type=submit class='btn' name='btnSav' value='Alterar'></td>";
	   echo '</tr>';

	   if($_POST['btnSav'] == "Alterar"){
	       $updt = "UPDATE clinicas SET por_exames = {$_POST[por_exames]} WHERE cod_clinica = {$_GET[id]}";
		   if($rupdt = pg_query($updt))
		       redirectme("?dir=cad_clinicas&p=index&act=detail&id=$_GET[id]");
	   }
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Status</b></td><td class="text roundborder ">'; print $buffer[ativo] == 0 ? "<font color=red><b>Inativo</b></font>" : "<font color=green><b>Ativo</b></font>"; echo '&nbsp;</td>';
	   echo '</tr>';
	   echo '</table>';
	   echo '<p>';

/**************************************************************************************************/
// --> PARTE QUE TRATA DOS PRE�OS J� CADASTRADOS NO SISTEMA
/**************************************************************************************************/
	   $sql_exame = "SELECT DISTINCT ce.cod_clinica, ce.cod_exame, e.especialidade, ce.preco_exame 
					 FROM clinica_exame ce, exame e, clinicas c
					 where ce.cod_exame = e.cod_exame
					 and ce.cod_clinica = c.cod_clinica
					 and ce.cod_clinica = '{$_GET['id']}' ORDER BY e.especialidade";
	   $result_exame = pg_query($sql_exame);
	   $exames = pg_fetch_all($result_exame);
	   
	   if(pg_num_rows($result_exame)>0){
		   echo '<center><b><font color=white>Exames Cadastrados</font></b></center>';
		   echo '<p>';
		   echo '<table width=100% border=0 cellpadding=2 cellspacing=2>';
		   echo '<tr>';
		   echo '    <td class="text "><b>&nbsp;</b></td>';
		   echo '    <td class="text "><b>Exame</b></td>';
		   echo '    <td class="text " width=90><b>Valor Cl�nica</b></td>';
		   echo '    <td class="text " width=90><b>% Cobrado</b></td>';
		   echo '    <td class="text " width=90><b>Valor Total</b></td>';
		   echo '</tr>';
		   for($x=0;$x<pg_num_rows($result_exame);$x++){
			  $per = ($exames[$x]['preco_exame'] *  $buffer[por_exames])/100;
			  echo '<tr class="text roundbordermix ">';
			  echo '	<td align=center class="text roundborder " ><a href="?dir=cad_clinicas&p=index&act=detail&id='.$_GET[id].'&exame='.$exames[$x][cod_exame].'"><u>Excluir</u></a></td>';
			  echo '    <td class="text roundborder ">'.$exames[$x]['especialidade'].'</td>';
			  echo '    <td class="text roundborder ">R$ '.number_format(($exames[$x]['preco_exame']-$per), 2, ',','.').'</td>';
			  echo '    <td class="text roundborder ">R$ '.number_format($per, 2, ',','.').'</td>';
			  echo '    <td class="text roundborder ">R$ '.number_format(($exames[$x]['preco_exame']), 2, ',','.').'</td>';
			  echo '</tr>';
		   }
		   echo '</table>';
		}
	}

/**************************************************************************************************/
// --> PARTE QUE TRATA DA INCLUS�O DOS PRE�OS DE EXAMES NO SISTEMA
/**************************************************************************************************/
if ($_GET['act']=='detail' and $_GET['id'] ) {

		$sql_tem_exame = "SELECT cod_exame, cod_clinica FROM clinica_exame WHERE cod_clinica =".$_GET['id'];

		$result_tem_exame = pg_query($connect, $sql_tem_exame);

		if ( pg_num_rows($result_tem_exame)==0 ){ // se N�O tiver nada cadastrado
			$query_exame = "SELECT cod_exame, especialidade FROM exame ORDER BY especialidade"; 
		}
		else{ // se tiver cadastrado
			
			
			$exame_fora = pg_fetch_all($result_tem_exame);
			$exame_fora_num = pg_num_rows($result_tem_exame);
			$row_fora = "";
			for($v=0;$v<$exame_fora_num;$v++){ // monta vari�vel com valores que ser�o exclu�dos da consulta
				$row_fora .= ", ".$exame_fora[$v][cod_exame];
			}
			
			$query_exame = "SELECT cod_exame, especialidade FROM exame where cod_exame not in (" . substr($row_fora,2,500) . ") ORDER BY especialidade"; /* como o primeiro caracter � v�gula, pegar a partir do segundo para n�o dar erro na consulta*/

		}
		
		$result_exame = pg_query($connect, $query_exame) 
			or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));
		
		echo '<center><b><font color=white>Cadastrar Pre�os dos Exames</font></b></center>';
		echo '<p>';
		echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >";
			
			while($row_exame=pg_fetch_array($result_exame)){ 
			echo "<tr class='text roundbordermix'>
					<td width=\"50%\" align=\"left\" class='text roundborder'>
						<input type=\"hidden\" name=\"exame[]\" value=\"$row_exame[cod_exame]\">&nbsp;&nbsp; $row_exame[especialidade]
					</td>
					<td width=\"50%\" align=\"left\" class='text roundborder'>
						R$&nbsp;<input type=\"text\" name=\"preco_exame[]\" size='18' onkeypress=\"return FormataReais(this, '.', ',', event);\" >&nbsp;&nbsp;<br>
					</td>
				</tr>";
			}
		echo " </table>";

		echo " <p>";

		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Gravar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar� todos os dados no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados ser�o salvos, tem certeza que deseja continuar?','');\"
					echo "</td>";
				echo "</tr>";
				echo "</table>";
			echo "</tr>";
		echo "</table>";
	}	
	
	echo " </form>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>