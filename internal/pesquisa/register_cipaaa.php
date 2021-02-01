<?PHP
// BUSCA DADOS DO CLIENTE
if($_SESSION[cod_cliente]){
	$ses = "SELECT c.*, cn.* FROM cliente c, cnae cn WHERE c.cliente_id = {$_SESSION[cod_cliente]} AND c.cnae_id = cn.cnae_id";
	$ss = pg_query($ses);
	$row = pg_fetch_array($ss);
}
//INSERT NA TABELA BT_TREINAMENTO
if($_POST["btn_confirm"] == "Confirmar"){
	$consulta = "SELECT a.*, f.nome_func FROM agenda_cipa_part a, funcionarios f 
				WHERE a.cod_cliente = {$_SESSION[cod_cliente]} 
				AND a.cod_cliente = f.cod_cliente 
				AND a.cod_funcionario = f.cod_func
				AND EXTRACT(Year from a.data_realizacao) = ".date("Y", strtotime($_POST[data_realizacao]));
	$consult = pg_query($consulta);
	$consul = pg_fetch_array($consult);
	if(pg_num_rows($consult) > 0){
		echo "<script>alert('O funcionário ".$consul[nome_func]." já está cadastrado no curso de designado, se quiser alterar entre em contato com a SESMT.')</script>";
	}else{
		$enter = "INSERT INTO agenda_cipa_part(cod_curso, data_realizacao, cod_funcionario, cod_cliente, status, data_inscricao)
				 VALUES(13, '{$_POST[data_realizacao]}', {$_POST[funcionario]}, {$_SESSION[cod_cliente]}, 0, '".date("Y-m-d")."')";
		$ente = pg_query($enter);
	}

$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
   <HTML>
   <HEAD>
      <TITLE>Curso Designado - CIPA</TITLE>
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
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
		  <p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Prezado(ª) Cliente: <b>{$row[nome_contato_dir]}</b>, nos dispomos para informar que foi agendado um curso de designado da CIPA para
o funcionário <b>{$consul[nome_func]}</b> no dia <b>".date("d/m/Y", strtotime($consul[data_realizacao]))."</b>, reservando assim espaço em nosso auditório para
a ministração do mesmo, conforme disposto na NR 5.6.4 lei 6.514/77 e sua Port 3.214/78.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Algumas das atribuições do designado são: Orientar a empresa de consultoria os locais onde mais se precise do MR - Mapa de Risco
que tem a finalidade de orientar aos demais colaboradores quanto aos riscos e poderem se previnir evitando a incidêncie de acidentes;
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Montar o Mapa Anual de Doença Ocupacional e Acidente do Trabalho, conforme quadros III e IV da NR 4 e
remeter para protocolo no MTE mensalmente ou anualmente se assim preferir;
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Cobrar dos fornecedores de EPI - Equipamento de Proteção Individual, os C.A's Certificado de Aprovação concedidos ao fabricante
pelo INMETRO e arquivá-lo junto com a ficha de entrega dos mesmo aos seus colaboradores;
<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Inspeção mensal dos Extintores de Incêndio;
<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Controlar para a administração as validades de: Recarga de Extintores; Limpeza dos reservatórios
de água inferior e superior; Dedetização; Desratização; Limpeza dos filtros de ar condicionados e etc.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
É de suma importância o cumprimento destes procedimentos e a participação da sua administração nesse processo a Segurança do Trabalho
tem a caracteristica de gerar organização e com isso findar os gargalos operacionais e paralização de produções, sem contar com a
liquidez que gera a sua empresa.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A SESMT prisma por cumprir o acordado entre a nossa e a sua empresa e conta com sua colaboração.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A prioridade da SESMT é levar a sua empresa a excelência da Organização administrativa objetivando assim o
sucesso pleno de sua empresa.
<p>
<br>
<p>
<BR>
<p>
<b><p align=left>
<i>SESMT VELANDO PELA SEGURANÇA NO TRABALHO<br>
E PELA SAÚDE OCUPACIONAL DA SUA EMPRESA <br></i></b>
<p>
<br>
</span>
</td>
</tr>
</table></div>
<br><p>
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

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
mail('sidneimourao@gmail.com', 'Curso de Designado - CIPA', $msg, $headers);
//echo $msg;
}
/*******************************************************************/
// BUSCA QUANTIDADE DE MEMBROS DA CIPA
     $cnae = $row['cnae'];
     $quantidade = $row['numero_funcionarios'];

	 if($quantidade > 10000){
		 $quantidade_maior=$quantidade;
		 $quantidade=10000;
	 }

	 $query_cnae="select * from cnae where cnae='".$cnae."'";
	 $result_cnae=pg_query($query_cnae);
	 $row_cnae=pg_fetch_array($result_cnae);

     if(pg_num_rows($result_cnae)<=0){
         echo "<script>alert('CNAE não econtrado!');</script>";
         exit;
     }

	 $query_cont="select * from cipa where grupo='".$row_cnae[grupo_cipa]."'";
	 $result_cont=pg_query($query_cont);
	
	$designado = 0;
	while($row_cont=pg_fetch_array($result_cont)){
 		$numero=explode(" a ", $row_cont[numero_empregados]);
		if($quantidade>=$numero[0] && $numero[1]>=$quantidade){
		
			if($row_cont[numero_membros_cipa] == 'Nenhum'){
				$menor=true;
		 		$mensagem="1 membro conforme NR. 5.6.4 da Portaria 3214/78 Lei 6514/77";
				$efetivo_empregador=1;
				$suplente_empregador=0;
				$efetivo_empregado=0;
				$suplente_empregado=0;
				$designado = 1;
			}else{
				$necessidade=$row_cont[numero_membros_cipa]+$row_cont[numero_representante_empregador]+$row_cont[suplente];
				$efetivo_empregador=$row_cont[numero_membros_cipa];
				$suplente_empregador=$row_cont[suplente];
				$efetivo_empregado=$row_cont[numero_membros_cipa];
				$suplente_empregado=$row_cont[suplente];
				if($quantidade_maior>=10000){
					$qtd_maior=explode(" ",$row_cont[maior]);
					$maior=$qtd_maior[0]+$qtd_maior[2];
					$maior_10000=1;
					$acrescentar_numero=(round($quantidade_maior/2500, 0))*$maior;
				}
			}
	    }
	}
	if($quantidade_maior>10000){
		$quantidade=$quantidade_maior;
	}
/*******************************************************************************/
if($designado){
	echo "<form method=post >
	<table align=center border=0>
		<tr>
			<td><p align=justify>
				&nbsp;&nbsp;&nbsp;Em conformidade a NR 5.6.4 da lei 5.614 Dez / 77 e Port. 3.214 Jul / 78, Quando o estabelecimento não se enquadrar no Quadro I, a empresa (*)designará um responsável pelo cumprimento dos objetivos desta NR, podendo ser adotados mecanismos de participação dos empregados, através de negociação (**)coletiva.
			</td>
		</tr>
	</table>
<table width=100% border=0>
    <tr>
        <td width=180>Selecione o Candidato: </td>
        <td align=left>
            <select name=funcionario id=funcionario class=required onchange=\"check_funcionario(this.options[this.selectedIndex].text);\">
            <option></option>";
                $sql = "SELECT * FROM funcionarios WHERE cod_cliente = '{$_SESSION[cod_cliente]}'";
                $result = pg_query($sql);
                while($buffer = pg_fetch_array($result)){
                	echo "<option value='$buffer[cod_func]'>{$buffer[nome_func]}</option>";
                }
            
            echo "</select>
			<span id=load></span>
        </td>
    </tr>
	<tr>
		<td >Função:</td>
		<td align=left><input type=text name=nome_funcao id=nome_funcao size=20 class=required value=''></td>
	</tr>
	<tr>
		<td >CTPS:</td>
		<td align=left><input type=text name=ctps id=ctps size=10 class=required value=''></td>
	</tr>
	<tr>
		<td >Série:</td>
		<td align=left><input type=text name=serie id=serie size=10 class=required value=''></td>
	</tr>
    <tr>
		<td colspan=2><br>Em seguida escolha a data que será realizado o curso de designado.</td>
	</tr>
	<tr>
        <td >Data de Realização: </td>
        <td align=left>
            <select name=data_realizacao id=data_realizacao class=required>";
            
                $datas = next_days(10);
                for($x=0;$x<10;$x++){
                    echo "<option value='".date("Y-m-d", strtotime($datas[$x]))."'>".date("d/m/Y", strtotime($datas[$x]))."</option>";
                }
           
            echo "</select>
        </td>
    </tr>
    <tr>
    	<td colspan=2><p><b>Duração do Curso:<br>09:00 às 12:00 hs<br>13:00 às 16:00 hs</b></td>
    </tr>
	<tr>
    	<td colspan=2 align=center><p><input type=submit name=btn_confirm value=Confirmar class=button></td>
    </tr>
	<tr>
    	<td colspan=2><p>* Atentar para o termo ".'"Designará"'." está no imperativo portanto pode gerar multa pelo fiscal auditor do trabalho.<br>** Observar a convenção coletiva do seu sindicato.</td>
    </tr>
</table>
</form>";

}elseif($_POST['btn_enviar'] == "Avançar"){

echo"<center>INSTALAÇÃO E POSSE DA CIPA</center>
<form name=\"form\" id=\"form\" action=\"internal/pesquisa/print_register_cipa.php\" onsubmit=\"return posse(this);\" method=\"post\" target=\"_blank\">
<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=\"center\" colspan=\"2\" >
			Preencha os Campos Para Formar a ATA de Instalação e Posse da CIPA.<p>
			Comissão Eleitoral (CE)<br>&nbsp;
		</td>
	</tr>
	<tr>
		<td width=\"130\">Data:</td>
		<td><input type=\"text\" name=\"data\" id='data' size=\"10\" maxlength=\"10\" OnKeyPress=\"formatar(this, '##/##/####');\" onkeydown=\"return only_number(event);\" class=\"required\">&nbsp;<font color=\"red\">DD/MM/AAAA</font></td>
	</tr>
	<tr>
		<td >Horas:</td>
		<td><input type=\"text\" name=\"hora\" id='hora' size=\"5\" maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\"></td>
	</tr>
	<tr>
		<td >Presidente da CE:</td>
		<td><input type=\"text\" class='required' name=\"gerente\" id='gerente' size=\"40\"></td>
	</tr>
	<tr>
		<td >Secretário(a) da CE:</td>
		<td><input type=\"text\" class='required' name=\"secretario\" id=\"secretario\" size=\"40\"></td>
	</tr>
</table>
<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=\"center\" colspan=\"2\" >
			<br>Representantes do Empregador<br>&nbsp;
		</td>
	</tr>";
		echo "<tr>
			<td width=130>Presidente:</td>
			<td><input type='text' class='required' name='presidente' id='presidente' size='40'></td>
		</tr>";
	if($efetivo_empregador >= 1){
		for($x=0;$x<$efetivo_empregador-1;$x++){
			echo "<tr>
				<td width=130>Titular</td>
				<td><input type='text' class='required' name='titular[]' id='titular' size='40' value=''><br></td>
			</tr>";
		}
	}
	if($suplente_empregador >= 1){
		for($x=0;$x<$suplente_empregador;$x++){
			echo"<tr>
				<td >Suplente:</td>
				<td><input type='text' class='required' name='suplente[]' size='40'></td>
			</tr>";
		}
	}
	if($efetivo_empregado >= 1){
		echo"<tr>
			<td align=\"center\" colspan=\"2\" ><br>Representantes do Empregado<br>&nbsp;</td>
		</tr>";
		echo "<tr>
			<td width=130>Vice-Presidente:</td>
			<td><input type='text' class='required' name='presidente_vice' size='40'></td>
		</tr>";
		for($x=0;$x<$efetivo_empregado-1;$x++){
			echo "<tr>
				<td >Titular:</td>
				<td><input type='text' class='required' name='titular_vice[]' size='40'></td>
			</tr>";
		}
	}
	if($suplente_empregado >= 1){
		for($x=0;$x<$suplente_empregado;$x++){
			echo "<tr>
				<td >Suplente:</td>
				<td><input type='text' class='required' name='suplente_vice[]' size='40'></td>
			</tr>";
		}
	}
	if($efetivo_empregado >= 1){
		echo "<tr>
			<td >Secretário(a):</td>
			<td><input type='text' class='required' name='secre' size='40'></td>
		</tr>";
	}
echo "</table><p>";

echo "<center>Em seguida selecione uma data no calendário abaixo e digite a hora para formar o calendário anual das reuniões.</center><p>";

// -> DIV DO CALENDÁRIO CIPA
echo "<center><span onclick=\"dat('jan');\" id='menujan' class='selectedDate curhand' style=\"font-size: 10px;\"><b>Jan</b></span> | ";
echo "<span onclick=\"dat('fev');\" id='menufev' class='curhand' style=\"font-size: 10px;\"><b>Fev</b></span> | ";
echo "<span onclick=\"dat('mar');\" id='menumar' class='curhand' style=\"font-size: 10px;\"><b>Mar</b></span> | ";
echo "<span onclick=\"dat('abr');\" id='menuabr' class='curhand' style=\"font-size: 10px;\"><b>Abr</b></span> | ";
echo "<span onclick=\"dat('mai');\" id='menumai' class='curhand' style=\"font-size: 10px;\"><b>Mai</b></span> | ";
echo "<span onclick=\"dat('jun');\" id='menujun' class='curhand' style=\"font-size: 10px;\"><b>Jun</b></span> | ";
echo "<span onclick=\"dat('jul');\" id='menujul' class='curhand' style=\"font-size: 10px;\"><b>Jul</b></span> | ";
echo "<span onclick=\"dat('ago');\" id='menuago' class='curhand' style=\"font-size: 10px;\"><b>Ago</b></span> | ";
echo "<span onclick=\"dat('set');\" id='menuset' class='curhand' style=\"font-size: 10px;\"><b>Set</b></span> | ";
echo "<span onclick=\"dat('out');\" id='menuout' class='curhand' style=\"font-size: 10px;\"><b>Out</b></span> | ";
echo "<span onclick=\"dat('nov');\" id='menunov' class='curhand' style=\"font-size: 10px;\"><b>Nov</b></span> | ";
echo "<span onclick=\"dat('dez');\" id='menudez' class='curhand' style=\"font-size: 10px;\"><b>Dez</b></span></center>";

// -> DIV DE JANEIRO
echo "<p>";
echo "<div id='jan' style=\"display:block\">";	
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(1, date("Y")+1, 'jan'); 
		echo "<br>Hora: <input type=text name=hjan id=hjan size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=djan id=djan value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE FEVEREIRO
echo "<p>";
echo "<div id='fev' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(2, date("Y")+1, 'fev'); 
		echo "<br>Hora: <input type=text name=hfev id=hfev size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dfev id=dfev value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE MARÇO
echo "<p>";
echo "<div id='mar' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(3, date("Y")+1, 'mar'); 
		echo "<br>Hora: <input type=text name=hmar id=hmar size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dmar id=dmar value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE ABRIL
echo "<p>";
echo "<div id='abr' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(4, date("Y")+1, 'abr'); 
		echo "<br>Hora: <input type=text name=habr id=habr size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dabr id=dabr value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE MAIO
echo "<p>";
echo "<div id='mai' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(5, date("Y")+1, 'mai'); 
		echo "<br>Hora: <input type=text name=hmai id=hmai size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dmai id=dmai value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE JUNHO
echo "<p>";
echo "<div id='jun' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(6, date("Y")+1, 'jun'); 
		echo "<br>Hora: <input type=text name=hjun id=hjun size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=djun id=djun value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE JULHO
echo "<p>";
echo "<div id='jul' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(7, date("Y")+1, 'jul'); 
		echo "<br>Hora: <input type=text name=hjul id=hjul size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=djul id=djul value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE AGOSTO
echo "<p>";
echo "<div id='ago' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(8, date("Y")+1, 'ago'); 
		echo "<br>Hora: <input type=text name=hago id=hago size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dago id=dago value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE SETEMBRO
echo "<p>";
echo "<div id='set' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(9, date("Y")+1, 'set'); 
		echo "<br>Hora: <input type=text name=hset id=hset size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dset id=dset value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE OUTUBRO
echo "<p>";
echo "<div id='out' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(10, date("Y")+1, 'out'); 
		echo "<br>Hora: <input type=text name=hout id=hout size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dout id=dout value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE NOVEMBRO
echo "<p>";
echo "<div id='nov' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(11, date("Y")+1, 'nov'); 
		echo "<br>Hora: <input type=text name=hnov id=hnov size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=dnov id=dnov value=''>
		</td>
	</tr>
</table></div>";

// -> DIV DE DEZEMBRO
echo "<p>";
echo "<div id='dez' style=\"display:none\">";
echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=center>"; calendar(12, date("Y")+1, 'dez'); 
		echo "<br>Hora: <input type=text name=hdez id=hdez size=10 maxlength=\"5\" OnKeyPress=\"formatar(this, '##:##');\" onkeydown=\"return only_number(event);\" class=\"required\">
						<input type=hidden name=ddez id=ddez value=''>
		</td>
	</tr>
</table></div>";

echo "<table border=\"0\" width=\"500\" align=\"center\">
	<tr>
		<td align=\"center\" colspan=\"2\"><br>
			<input type=\"button\" class=button name=\"back\" id=\"back\" value=\"Voltar\" OnClick=\"location.href='?do=reg_cipa';\">
			&nbsp;&nbsp;&nbsp;
			<input type=\"submit\" class=button name=\"imprimir\" id=\"imprimir\" value=\"Enviar\" OnClick=\"return Imprimir();\">
		</td>
	</tr>
</table>";
//Imprimir() -> chama a tela print_register_cipa
echo "</form>";

}else{
	
?>
<form method="post" onsubmit="return regi(this);">
<table align="center" border="0">
<tr>
<td align="center" class="fontebranca22bold"><p><br>REGISTRO DA CIPA</td>
</tr>
</table><br />
Todos os campos são obrigatórios.
<table align="center" width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td width="18%" >Razão Social:</td>
		<td><input type="text" name="razao_social" id="razao_social" size="60" class="required" value="<?php echo $row[razao_social]; ?>" ></td>
	</tr>
	<tr>
		<td >CNPJ:</td>
		<td><input type="text" name="cnpj" id="cnpj" size="15" maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##');" onkeydown="return only_number(event);" class="required" value="<?php echo $row[cnpj]; ?>" ></td>
	</tr>
	<tr>
		<td >CNAE:</td>
		<td><input type="text" name="cnae" id="cnae" size="15" maxlength="7" OnKeyPress="formatar(this, '##.##-#');" onkeydown="return only_number(event);" class="required" value="<?php echo $row[cnae]; ?>" ></td>
	</tr>
	<tr>
		<td >Nº de Colaboradores:</td>
		<td><input type="text" name="colaborador" id="colaborador" size="15" onkeydown="return only_number(event);" class="required" value="<?php echo $row[numero_funcionarios]; ?>" ></td>
	</tr>
	<tr>
		<td >Grau de Risco:</td>
		<td><input type="text" name="grau" id="grau" size="15" maxlength="1" class="required" value="<?php echo $row[grau_de_risco]; ?>" ></td>
	</tr>
	<tr>
		<td >CEP:</td>
		<td><input type="text" id="cep" name="cep" size="15" maxlength="9" OnKeyPress="formatar(this, '#####-###');" class="required" onblur="check_cep(this);" value="<?php echo $row[cep]; ?>" ></td>
	</tr>
	<tr>
		<td >Endereço:</td>
		<td><input type="text" id="endereco" name="endereco" size="30" class="required" value="<?php echo $row[endereco]; ?>" > Nº: <input type="text" name="numero" id="numero" size="5" class="required" value="<?php echo $row[num_end]; ?>" ></td>
	</tr>
	<tr>
		<td >Bairro:</td>
		<td><input type="text" id="bairro" name="bairro" size="15" class="required" value="<?php echo $row[bairro]; ?>" >
		<input type="hidden" name="cidade" id="cidade" />
		<input type="hidden" name="estado" id="estado" />
		</td>
	</tr>
	<tr>
		<th colspan="2">
        <br><input type="submit" value="Avançar" name="btn_enviar" class="button" ></th>
	</tr>
</table>
</form>
<?php
}
?>