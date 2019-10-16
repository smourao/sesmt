<?php
include "../../common/database/conn.php";

$func = "SELECT f.*, c.nome as n, c.cargo_id
		FROM funcionario f, cargo c 
		WHERE f.funcionario_id = {$_GET[funcionario_id]}
		AND f.cargo_id = c.cargo_id";
$res = pg_query($connect, $func);
$row = pg_fetch_array($res);

?>

<html>
<head>
<title>SIST - Sistema Integrado de Segurança no Trabalho</title>
</head>

<body>
<table align="center" border="0" width="760" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr><font color="#666666">
		<td align="left" class="text" width="160"><font size="7"><b>SESMT</b></font></td>
		<td valign="top" class="text" width="15">&reg;</td>
		<td valign="bottom" class="text"><font size="2">Serviço Especializado de Segurança e Monitoramento de Atividade no Trabalho<br>CNPJ 04.722.248/0001-17 Insc. Mun. 311.213-6</font></td>
		</font>
	</tr>
</table><p>

<table align="center" border="0" width="650" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="left" class="text" ><b>Candidato(a):</b>&nbsp;<?php echo $row[nome]; ?></td>
	</tr>
	<tr>
		<td align="left" class="text" ><b>Vaga a Preencher:</b>&nbsp;<?php echo $row[n]; ?></td>
	</tr>
	<tr>
		<td align="left" class="text" ><br><b>FRDF - Ficha de Relação de Documentos dos Funcionários</b></td>
	</tr>
</table>

<table align="center" border="1" width="650" cellpadding="2" cellspacing="2" bordercolor="#000000">
	<tr>
		<td align="center" class="text" width="25" >X</td>
		<td align="center" class="text" width="25" >01</td>
		<td align="left" class="text" width="590" >&nbsp;Comprovante de residência</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >02</td>
		<td align="left" class="text" >&nbsp;ASO - atestado médico do trabalho</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >03</td>
		<td align="left" class="text" >&nbsp;CTPS - carteira de trabalho</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >04</td>
		<td align="left" class="text" >&nbsp;Cópia do cartão do PIS / PASEP</td>
	</tr>
	<tr>
		<td align="center" class="text" >&nbsp;</td>
		<td align="center" class="text" >05</td>
		<td align="left" class="text" >&nbsp;Cópia do titulo de eleitor</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >06</td>
		<td align="left" class="text" >&nbsp;03 fotos 3x4 coloridas (recente)</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >07</td>
		<td align="left" class="text" >&nbsp;Cópia da carteira de identidade</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >08</td>
		<td align="left" class="text" >&nbsp;Cópia do CPF</td>
	</tr>
	<tr>
		<td align="center" class="text" >
		<?php
		if($row[sexo] == 1){
			echo "X";
		}else{
			echo "&nbsp;";
		}
		?>
		</td>
		<td align="center" class="text" >09</td>
		<td align="left" class="text" >&nbsp;Cópia do certificado de dispensa militar</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >10</td>
		<td align="left" class="text" >&nbsp;Comprovante de escolaridade</td>
	</tr>
	<tr>
		<td align="center" class="text" >&nbsp;</td>
		<td align="center" class="text" >11</td>
		<td align="left" class="text" >&nbsp;Formulário para abertura de conta poupança do bco do brasil</td>
	</tr>
	<tr>
		<td align="center" class="text" >&nbsp;</td>
		<td align="center" class="text" >12</td>
		<td align="left" class="text" >&nbsp;Cópia da habilitação</td>
	</tr>
	<tr>
		<td align="center" class="text" >&nbsp;</td>
		<td align="center" class="text" >13</td>
		<td align="left" class="text" >&nbsp;Cópia da certidão dos filhos menores para salário família</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >14</td>
		<td align="left" class="text" >&nbsp;Cópia da certidão de nascimento / casamento</td>
	</tr>
	<tr>
		<td align="center" class="text" >X</td>
		<td align="center" class="text" >15</td>
		<td align="left" class="text" >&nbsp;Declaração de opção de vale transporte, preenchida e assinada mesmo no caso de não opçãodo funcionário</td>
	</tr>
	<tr>
		<td align="center" class="text" >
		<?php
		if((date("Y")-date("Y",strtotime($row[nascimento])))<18){
	    	echo "X";
		}else{
			echo "&nbsp;";
		}
		?>
		</td>
		<td align="center" class="text" >16</td>
		<td align="left" class="text" >&nbsp;Caso menor, apresentar declaração do(s) pai(s) (escrita de próprio punho) aprovando a cópia de identidade do mesmo</td>
	</tr>
	<tr>
		<td align="center" class="text" >&nbsp;</td>
		<td align="center" class="text" >&nbsp;</td>
		<td align="left" class="text" >&nbsp;</td>
	</tr>
</table><p>

<table align="center" border="0" width="650" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="left" class="text" >Funcionário(a) isento(a) de marcação de ponto? 
		<?php
		if($row[cargo_id] == '1' || $row[cargo_id] == '2'){
			echo "<b>Sim</b>";
		}else{
			echo "<b>Não</b>";
		}
		?>
		</td>
	</tr>
</table><p>

<table align="center" border="0" width="650" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td align="left" class="text" >Declaro ter recebido as informações básicas para o cumprimento do processo de contratação.<p></td>
	</tr>
	<tr>
		<td align="right" class="text" ><p>______________________________<br>Assinatura do Candidato&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
</table><p><br>

<table align="center" border="0" width="760" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr><font color="#666666">
		<td valign="bottom" align="center" class="text" width="500">TELEFONE: (21) 3014 4304 FAX: Ramal 7 <br> NEXTEL: (55-21) 7844 9394 - ID 55*23*31368 <br> faleprimeirocomagente@sesmt-rio.com/rh@sesmt-rio.com <br> www.sesmt-rio.com/www.shoppingsesmt.com</td>
		<td align="left" class="text" width="90"><font size="3"><b>Pensando em<br>Renovar seus<br>Programas?<br>Fale Primeiro<br>com a Gente!</b></font></td>
		</font>
	</tr>
</table><p>

</body>
</html>