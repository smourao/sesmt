<?php
$cnae = $_POST['cnae'];
$quantidade = $_POST['quantidade'];

if($_SESSION[cod_cliente]){
	$ses = "SELECT c.*, cn.* FROM cliente c, cnae cn WHERE c.cliente_id = {$_SESSION[cod_cliente]} AND c.cnae_id = cn.cnae_id";
	$ss = pg_query($ses);
	$row = pg_fetch_array($ss);
}
if($_POST){
	$row[cnae] = $cnae;	
	$row[numero_funcionarios] = $quantidade;
}
?>
<form method="post" onsubmit="return cp(this);">
<table align="center" border="0">
	<tr>
		<td align="center" class="fontebranca22bold"><p><br>CONTINGENTE DA CIPA</td>
	</tr>
</table><br />
Todos os campos são de preenchimento obrigatório.
<table align="center" width="100%" border="0" bordercolor="#FFFFFF">
	<tr>
		<td width="50%" align=right>CNAE:</td>
		<td width="50%"><input type="text" class="required" name="cnae" size="5" maxlength="7" OnKeyPress="formatar(this, '##.##-#');" onkeydown="return only_number(event);" value="<?php echo $row[cnae]; ?>" ></td>
	</tr>
	<tr>
		<td width="50%" align=right>Nº de Colaboradores:</td>
		<td width="50%"><input type="text" class="required" name="quantidade" size="5" onkeydown="return only_number(event);" value="<?php echo $row[numero_funcionarios]; ?>" ></td>
	</tr>
	<tr>
		<th colspan="2"><input type="submit" class="button" value="Buscar" name="btn_enviar"></th>
	</tr>
</table>
<?php

if($_POST['cnae']!="" && $_POST['quantidade']!=""){
	 if($quantidade > 10000){
		 $quantidade_maior=$quantidade;
		 $quantidade=10000;
	 }

	 $query_cnae="select * from cnae where cnae='".$cnae."'";
	 $result_cnae=pg_query($query_cnae)or die("Erro na query $query_cnae".pg_last_error($conn));
	 $row_cnae=pg_fetch_array($result_cnae);

     if(pg_num_rows($result_cnae)<=0){
         echo "<script>alert('CNAE não econtrado!');</script>";
         exit;
     }

	 $query_cont="select * from cipa where grupo='".$row_cnae[grupo_cipa]."'";
	 $result_cont=pg_query($query_cont)or die("Erro na consulta de contigente".pg_last_error($conect));

	while($row_cont=pg_fetch_array($result_cont)){
 		$numero=explode(" a ", $row_cont[numero_empregados]);
		if($quantidade>$numero[0] && $numero[1]>$quantidade || $quantidade==$numero[0] || $quantidade==$numero[1]){
			if($row_cont[numero_membros_cipa]>="19"){
				$menor=true;
		 		$mensagem="1 membro conforme NR. 5.6.4 da Portaria 3214/78 Lei 6514/77";
				$efetivo_empregador=1;
				$suplente_empregador=0;
				$efetivo_empregado=0;
				$suplente_empregado=0;
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
//para o flash
$total1=$efetivo_empregador+$suplente_empregador;
$total2=$efetivo_empregado+$suplente_empregado;
echo "<table align=center width=100% border=0 cellpadding=5 cellspacing=2>
	<tr>
		<td align=center colspan=2 class=bgTitle >São necessários como participantes da CIPA:</td>
	</tr>
	<tr>
		<td class=bgContent1 >Representante do Empregador (indicado pelo empregador)</td>
		<td class=bgContent1 width=50  align=center>$total1</td>
	</tr>
	<tr>
		<td class=bgContent2 >Efetivo (Presidente)</td>
		<td class=bgContent2 width=50 align=center >$efetivo_empregador</td>
	</tr>
	<tr>
		<td class=bgContent1 >Suplente do (Presidente)</td>
		<td class=bgContent1 width=50 align=center >$suplente_empregador</td>
	</tr>
	<tr>
		<td class=bgContent2 >Representantes dos Empregados (Eleito através do voto)</td>
		<td class=bgContent2 width=50 align=center >$total2</td>
	</tr>
	<tr>
		<td class=bgContent1 >Efetivo - O Vice-Presidente será escolhido entre os titulares - NR 5.11</td>
		<td class=bgContent1 width=50 align=center >$efetivo_empregado</td>
	</tr>
	<tr>
		<td class=bgContent2 >Suplente - Substituirá eventualmente sempre que for preciso o seu titular.</td>
		<td class=bgContent2 width=50 align=center >$suplente_empregado</td>
	</tr>
</table>";
}
?>
</form>