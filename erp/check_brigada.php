<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "./config/connect.php";
include "./config/funcoes.php";

$quantidade = $_GET['nf'];
$classe     = $_GET['classe'];
$cnae       = $_GET['cnae'];


if(!empty($cnae)){
	$query_cnae="select cnae_id from cnae where cnae='$cnae'";
	$result_cnae=pg_query($query_cnae)
		or die("Erro na pesquisa de CNAE $query_cnae".pg_last_error($connect));
	$qtd_cnae=pg_num_rows($result_cnae);
	if($qtd_cnae==1){
		$row_cnae=pg_fetch_array($result_cnae);
		$cnae_id=$row_cnae[cnae_id];
	}
}


if($classe != ""){
	$query_clac="select * from brigadistas where classe = '$classe'";
	$result_calc=pg_query($query_clac) or die("Erro na query: $query_clac".pg_last_error($connect));
	$row_calc=pg_fetch_array($result_calc);
	
	 $menor=$row_calc[ate_10];
	 $maior=$row_calc[mais_10];

		if($quantidade<=10)
		{
			$calculo=$quantidade*($menor/100);
		}
		else
		{
			$calculo=10*($menor/100)+($quantidade-10)*($maior/100);
		}

	if($membros=round($calculo, 0) <= 0)
	{
		$membros="0";
	}
	else
	{
		$membros=round($calculo, 0);
	}
}

if($cnae_id != ""){
	 $query_cnae="select * from cnae where cnae_id='".$cnae_id."'";
	 $result_cnae=pg_query($query_cnae);
	 $row_cnae=pg_fetch_array($result_cnae);

	 $query_cont="select * from cipa where grupo='".$row_cnae[grupo_cipa]."'";
	 $result_cont=pg_query($query_cont)or die("Erro na consulta de contigente".pg_last_error($conect));
	while($row_cont=pg_fetch_array($result_cont)){
 		$numero=explode(" a ", $row_cont[numero_empregados]);
		if($quantidade>$numero[0] && $numero[1]>$quantidade || $quantidade==$numero[0] || $quantidade==$numero[1]){
			if($row_cont[numero_membros_cipa]>="19"){
				$menor=true;
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
			}

		  }
 		}
$total1 = $efetivo_empregador+$suplente_empregador;
$total2 = $efetivo_empregado+$suplente_empregado;
}

$tmp = $membros."|".$total1."|".$total2;

if(!empty($cnae) &&  $classe != "" &&  $cnae_id != ""){
   echo $tmp;
}else{
   echo "0";
}

?>
