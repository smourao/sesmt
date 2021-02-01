<?PHP
/*******************************************************************************************************************/
// --> CREATE A NEW ORCAMENTO
/*******************************************************************************************************************/
function create_orcamento_simulador($cod_simulador, $cod_orcamento = 0){
    //include('../common/includes/database.php');
    global $conn;
    $error = 0;

    //GET THE MAX ORC_ID
    if($cod_orcamento == 0){
        $sql = "SELECT MAX(cod_orcamento) + 1 as cod_orcamento FROM site_orc_info";
        $r = pg_query($sql);
        $max = pg_fetch_array($r);
    }else{
        //DELETE THE OLD ORCAMENTO TO CREATE A NEW ONE
        $sql = "DELETE FROM site_orc_produto WHERE cod_orcamento = $cod_orcamento";
        if(pg_query($sql))
	        $error = 0;
        else
            $error = 1;

        $sql = "DELETE FROM site_orc_info WHERE cod_orcamento = $cod_orcamento";
        if(pg_query($sql))
	        $error = 0;
        else
            $error = 2;
    }
	
				
				if($cod_chave != ''){
				$sqlchave = "SELECT * FROM funcionario WHERE cod_vendedor = '$cod_chave'";
				$querychave = pg_query($sqlchave);
				$arraychave = pg_fetch_array($querychave);
				$vendedor_id = $arraychave[funcionario_id];
				}
				else{
					$vendedor_id = 18;
				}
    
    if(!$error){
        $sql = "SELECT * FROM cliente WHERE cliente_id = $cod_simulador";
        $sim = pg_fetch_array(pg_query($sql));

        $sql = "INSERT INTO site_orc_info 
		(cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, data_aprovacao, aprovado, orc_request_time, orc_request_time_sended, vendedor_id)
		VALUES
		({$max[cod_orcamento]}, {$cod_simulador}, 1, '0', '".date("Y/m/d")."', '".date("Y/m/d")."', '0', '".date("h:i:s")."', '0', '$vendedor_id')";
        if(pg_query($sql))
            $error = 0;//echo "insert ok;<BR>";
        else
            $error = 3;//echo "Error $sql<BR>";

        //--> ASO -----------------------------------------------------------
       /* if($sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 891;
    	}elseif($sim[numero_funcionarios] >= 11 && $sim[numero_funcionarios] <= 20){
        	$cod_prod = 893;
    	}elseif($sim[numero_funcionarios] >= 21 && $sim[numero_funcionarios] <= 50){
        	$cod_prod = 895;
    	}elseif($sim[numero_funcionarios] >= 51 && $sim[numero_funcionarios] <= 100){
        	$cod_prod = 928;
    	}elseif($sim[numero_funcionarios] >= 101 && $sim[numero_funcionarios] <= 150){
        	$cod_prod = 929;
    	}elseif($sim[numero_funcionarios] >= 151 && $sim[numero_funcionarios] <= 250){
        	$cod_prod = 930;
    	}elseif($sim[numero_funcionarios] >= 251 && $sim[numero_funcionarios] <= 350){
        	$cod_prod = 931;
    	}elseif($sim[numero_funcionarios] > 350){
        	$cod_prod = 932;
    	}*/
		
		//--> ASO COM VALOR UNICO INDEPEDENDO DO NUMERO DOS FUNCIONARIOS
		
		$cod_prod = 70481;
		
		
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, $cod_prod, $sim[numero_funcionarios], 0, '', $prod[preco_prod] )";
    	if(pg_query($sql))
    	    $error = 0;
        else
            $error = 4;

        //--> PPRA -----------------------------------------------------------
        if($sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 423;
    	}elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
        	$cod_prod = 966;
    	}elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
        	$cod_prod = 967;
    	}elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
        	$cod_prod = 968;
    	}elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
        	$cod_prod = 969;
    	}elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
        	$cod_prod = 970;
    	}elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
        	$cod_prod = 971;
    	}elseif($sim[numero_funcionarios] >= 351 and $sim[numero_funcionarios] <= 450){
        	$cod_prod = 990;
    	}elseif($sim[numero_funcionarios] >= 451 and $sim[numero_funcionarios] <= 500){
        	$cod_prod = 991;
    	}elseif($sim[numero_funcionarios] >= 501 and $sim[numero_funcionarios] <= 600){
        	$cod_prod = 992;
    	}elseif($sim[numero_funcionarios] >= 601 and $sim[numero_funcionarios] <= 700){
        	$cod_prod = 993;
    	}elseif($sim[numero_funcionarios] >= 701 and $sim[numero_funcionarios] <= 800){
        	$cod_prod = 994;
    	}elseif($sim[numero_funcionarios] >= 801 and $sim[numero_funcionarios] <= 900){
        	$cod_prod = 995;
    	}elseif($sim[numero_funcionarios] > 900){
        	$cod_prod = 996;
    	}
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 5;

    	//--> PPP -----------------------------------------------------------
    	/*if($sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 933;
    	}elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
        	$cod_prod = 934;
    	}elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
        	$cod_prod = 935;
    	}elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
        	$cod_prod = 936;
    	}elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
        	$cod_prod = 937;
    	}elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
        	$cod_prod = 938;
    	}elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
        	$cod_prod = 939;
    	}elseif($sim[numero_funcionarios] > 350){
        	$cod_prod = 940;
    	}*/
		
			$cod_prod = 70521;
		
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, $cod_prod, $sim[numero_funcionarios], 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 6;

        //--> PCMSO -----------------------------------------------------------
        if($sim[numero_funcionarios] <= 10 ){
            $cod_prod = 424;
        }elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
            $cod_prod = 952;
        }elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
            $cod_prod = 953;
        }elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
            $cod_prod = 954;
        }elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
            $cod_prod = 955;
        }elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
            $cod_prod = 956;
        }elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
            $cod_prod = 957;
        }elseif($sim[numero_funcionarios] >= 351 and $sim[numero_funcionarios] <= 450){
            $cod_prod = 958;
        }elseif($sim[numero_funcionarios] >= 451 and $sim[numero_funcionarios] <= 500){
            $cod_prod = 997;
        }elseif($sim[numero_funcionarios] >= 501 and $sim[numero_funcionarios] <= 600){
            $cod_prod = 998;
        }elseif($sim[numero_funcionarios] >= 601 and $sim[numero_funcionarios] <= 700){
            $cod_prod = 999;
        }elseif($sim[numero_funcionarios] >= 701 and $sim[numero_funcionarios] <= 800){
            $cod_prod = 1000;
        }elseif($sim[numero_funcionarios] >= 801 and $sim[numero_funcionarios] <= 900){
            $cod_prod = 1001;
        }elseif($sim[numero_funcionarios] > 900){
            $cod_prod = 1002;
        }
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 7;

    	//--> APGRE -----------------------------------------------------------
    	if( $sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 972;
    	}elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
        	$cod_prod = 973;
    	}elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
        	$cod_prod = 974;
    	}elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
        	$cod_prod = 975;
    	}elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
        	$cod_prod = 976;
    	}elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
        	$cod_prod = 977;
    	}elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
        	$cod_prod = 978;
    	}elseif($sim[numero_funcionarios] >= 351 and $sim[numero_funcionarios] <= 450){
        	$cod_prod = 979;
    	}elseif($sim[numero_funcionarios] >= 451 and $sim[numero_funcionarios] <= 500){
        	$cod_prod = 1003;
    	}elseif($sim[numero_funcionarios] >= 501 and $sim[numero_funcionarios] <= 600){
        	$cod_prod = 1004;
    	}elseif($sim[numero_funcionarios] >= 601 and $sim[numero_funcionarios] <= 700){
        	$cod_prod = 1005;
    	}elseif($sim[numero_funcionarios] >= 701 and $sim[numero_funcionarios] <= 800){
        	$cod_prod = 1006;
    	}elseif($sim[numero_funcionarios] >= 801 and $sim[numero_funcionarios] <= 900){
        	$cod_prod = 1007;
    	}elseif($sim[numero_funcionarios] > 900){
        	$cod_prod = 1008;
    	}
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 8;

    	//--> CURSO EPI -----------------------------------------------------------
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 431";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, 431, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 9;
			
		//--> Análise de Stress Térmico  -----------------------------------------------------------	
		$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 7320";
    	$prod = pg_fetch_array(pg_query($sql));
		$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
		VALUES
		('$max[cod_orcamento]', $cod_simulador, 1, 7320, 1, 0, '', $prod[preco_prod] )";
         if(pg_query($sql))
        	 $error = 0;
         else
             $error = 11;
			
			

        //--> LTCAT -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
        if($sim[grau_de_risco] == 3){
            if($sim[numero_funcionarios] <= 10 ){
                $cod_prod = 440;
            }elseif($sim[numero_funcionarios] >= 11 && $sim[numero_funcionarios] <= 20 ){
                $cod_prod = 441;
            }elseif($sim[numero_funcionarios] >= 21 && $sim[numero_funcionarios] <= 50 ){
                $cod_prod = 442;
            }elseif($sim[numero_funcionarios] >= 51 && $sim[numero_funcionarios] <= 100 ){
                $cod_prod = 443;
            }elseif($sim[numero_funcionarios] >= 101 && $sim[numero_funcionarios] <= 150 ){
                $cod_prod = 444;
            }elseif($sim[numero_funcionarios] >= 151 && $sim[numero_funcionarios] <= 250 ){
                $cod_prod = 445;
            }elseif($sim[numero_funcionarios] >= 251 && $sim[numero_funcionarios] <= 350 ){
                $cod_prod = 446;
            }elseif($sim[numero_funcionarios] >= 351 && $sim[numero_funcionarios] <= 450 ){
                $cod_prod = 447;
            }elseif($sim[numero_funcionarios] >= 451 && $sim[numero_funcionarios] <= 500 ){
                $cod_prod = 1009;
            }elseif($sim[numero_funcionarios] >= 501 && $sim[numero_funcionarios] <= 600 ){
                $cod_prod = 1010;
            }elseif($sim[numero_funcionarios] >= 601 && $sim[numero_funcionarios] <= 700 ){
                $cod_prod = 1011;
            }elseif($sim[numero_funcionarios] >= 701 && $sim[numero_funcionarios] <= 800 ){
                $cod_prod = 1012;
            }elseif($sim[numero_funcionarios] >= 801 && $sim[numero_funcionarios] <= 900 ){
                $cod_prod = 1013;
            }elseif($sim[numero_funcionarios] > 900 ){
                $cod_prod = 1014;
            }
        }elseif($sim[grau_de_risco] == 4){
            if($sim[numero_funcionarios] <= 10 ){
                $cod_prod = 448;
            }elseif($sim[numero_funcionarios] >= 11 && $sim[numero_funcionarios] <= 20 ){
                $cod_prod = 804;
            }elseif($sim[numero_funcionarios] >= 21 && $sim[numero_funcionarios] <= 50 ){
                $cod_prod = 805;
            }elseif($sim[numero_funcionarios] >= 51 && $sim[numero_funcionarios] <= 100 ){
                $cod_prod = 890;
            }elseif($sim[numero_funcionarios] >= 101 && $sim[numero_funcionarios] <= 150 ){
                $cod_prod = 892;
            }elseif($sim[numero_funcionarios] >= 151 && $sim[numero_funcionarios] <= 250 ){
                $cod_prod = 894;
            }elseif($sim[numero_funcionarios] >= 251 && $sim[numero_funcionarios] <= 350 ){
                $cod_prod = 896;
            }elseif($sim[numero_funcionarios] >= 351 && $sim[numero_funcionarios] <= 450 ){
                $cod_prod = 942;
            }elseif($sim[numero_funcionarios] >= 451 && $sim[numero_funcionarios] <= 500 ){
                $cod_prod = 1015;
            }elseif($sim[numero_funcionarios] >= 501 && $sim[numero_funcionarios] <= 600 ){
                $cod_prod = 1016;
            }elseif($sim[numero_funcionarios] >= 601 && $sim[numero_funcionarios] <= 700 ){
                $cod_prod = 1017;
            }elseif($sim[numero_funcionarios] >= 701 && $sim[numero_funcionarios] <= 800 ){
                $cod_prod = 1018;
            }elseif($sim[numero_funcionarios] >= 801 && $sim[numero_funcionarios] <= 900 ){
                $cod_prod = 1019;
            }elseif($sim[numero_funcionarios] > 900 ){
                $cod_prod = 1020;
            }
        }
        if($sim[grau_de_risco] >=3){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 10;
        }

    	//--> MAPA DE RISCO A3 e A4 -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
        if($sim[grau_de_risco] <= 2){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 963";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 963, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 11;

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 965";
    	    $prod = pg_fetch_array(pg_query($sql));
	    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 965, 2, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 12;
        }else{
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 422";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 422, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 13;

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 964";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 964, 2, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 14;
        }

        //--> CURSO DE CIPA -----------------------------------------------------------
        $num = explode("|", $sim['num_rep']);
        $t   = (int)($num[0] + $num[1]);
        if($t > 1){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 840";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 840, $t, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 15;

        	//acessoria a cipa - organização de processo eleitoral
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 980";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 980, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 16;

        	//acessoria a cipa - elaboração de ata ordinária (mensal) 12x
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 981";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 981, 12, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 17;
        }else{
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 897";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 897, 1, 0, '$t', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 18;
        }

        //--> CURSO DE PREVENÇÃO DE INCÊNDIO --------------------------------------------
        if($sim['membros_brigada'] > 0){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 982";
    	    $prod = pg_fetch_array(pg_query($sql));
	    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$max[cod_orcamento]', $cod_simulador, 1, 982, $sim[membros_brigada], 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 19;
        }

        //--> PCMAT ----------------------------------------------------------------------
        $sql = "SELECT * FROM cnae WHERE cnae_id = '$sim[cnae_id]' AND lower(descricao) like '%construção civil%' AND grau_risco > 2";
        $rcc = pg_query($sql);
        if(pg_num_rows($rcc)){
            $sql = "SELECT * FROM produto WHERE lower(desc_resumida_prod) LIKE '%pcmat%'
            AND $sim[numero_funcionarios] BETWEEN g_min AND g_max";
    		$rpd = pg_query($sql);
    		$prod = pg_fetch_array($rpd);
    		if(pg_num_rows($rpd)){
		    	$sql  = "INSERT INTO site_orc_produto (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
				VALUES
				('$max[cod_orcamento]', $cod_simulador, 1, $prod[cod_prod], 1, 0, '', $prod[preco_prod] )";
                if(pg_query($sql))
        	        $error = 0;
                else
                    $error = 20;
    		}
        }
    }//if no error found (delete)
    return $error;
}
?>


<?PHP
/*******************************************************************************************************************/
// --> CREATE A NEW ORCAMENTO
/*******************************************************************************************************************/
/*function create_orcamento_simulador($cod_simulador, $cod_orcamento = 0){
    //include('../common/includes/database.php');
    global $conn;
    $error = 0;

    //GET THE MAX ORC_ID
    if($cod_orcamento == 0){
        $sql = "SELECT MAX(cod_orcamento)as cod_orcamento FROM site_orc_info";
        $r = pg_query($sql);
        $max = pg_fetch_array($r);
        $sql = "SELECT MAX(cod_orcamento) as cod_orcamento FROM orcamento";
    	$r2 = pg_query($sql);
    	$max2 = pg_fetch_array($r2);
    	$row_cod[cod_orcamento] = 0;
    	if($max[cod_orcamento] > $max2[cod_orcamento])
    	    $row_cod[cod_orcamento] = $max[cod_orcamento]+1;
    	else
    	    $row_cod[cod_orcamento] = $max2[cod_orcamento]+1;
        $cod_orcamento = $row_cod[cod_orcamento];
    }else{
        //DELETE THE OLD ORCAMENTO TO CREATE A NEW ONE
        $sql = "DELETE FROM orcamento_produto WHERE cod_orcamento = $cod_orcamento";
        if(pg_query($sql))
	        $error = 0;
        else
            $error = 1;

        $sql = "DELETE FROM orcamento WHERE cod_orcamento = $cod_orcamento";
        if(pg_query($sql))
	        $error = 0;
        else
            $error = 2;
    }
    
    if(!$error){
        $sql = "SELECT * FROM cliente_comercial WHERE cliente_id = $cod_simulador";
        $sim = pg_fetch_array(pg_query($sql));

        $sql = "INSERT INTO orcamento (cod_cliente, cod_orcamento, data, tipo_cliente)
        VALUES
    	($cod_simulador, $cod_orcamento, '".date("Y-m-d")."', 'Cliente Comercial')";
        //$rio = pg_query($sql);
        if(pg_query($sql))
            $error = 0;//echo "insert ok;<BR>";
        else
            $error = 3;//echo "Error $sql<BR>";

        //--> ASO -----------------------------------------------------------
        if($sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 891;
    	}elseif($sim[numero_funcionarios] >= 11 && $sim[numero_funcionarios] <= 20){
        	$cod_prod = 893;
    	}elseif($sim[numero_funcionarios] >= 21 && $sim[numero_funcionarios] <= 50){
        	$cod_prod = 895;
    	}elseif($sim[numero_funcionarios] >= 51 && $sim[numero_funcionarios] <= 100){
        	$cod_prod = 928;
    	}elseif($sim[numero_funcionarios] >= 101 && $sim[numero_funcionarios] <= 150){
        	$cod_prod = 929;
    	}elseif($sim[numero_funcionarios] >= 151 && $sim[numero_funcionarios] <= 250){
        	$cod_prod = 930;
    	}elseif($sim[numero_funcionarios] >= 251 && $sim[numero_funcionarios] <= 350){
        	$cod_prod = 931;
    	}elseif($sim[numero_funcionarios] > 350){
        	$cod_prod = 932;
    	}
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
        VALUES
    	($cod_orcamento, $cod_prod, $sim[numero_funcionarios], $prod[preco_prod], ".($sim[numero_funcionarios] * $prod[preco_prod]).")";
    	if(pg_query($sql))
    	    $error = 0;
        else
            $error = 4;

        //--> PPRA -----------------------------------------------------------
        if($sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 423;
    	}elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
        	$cod_prod = 966;
    	}elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
        	$cod_prod = 967;
    	}elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
        	$cod_prod = 968;
    	}elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
        	$cod_prod = 969;
    	}elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
        	$cod_prod = 970;
    	}elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
        	$cod_prod = 971;
    	}elseif($sim[numero_funcionarios] >= 351 and $sim[numero_funcionarios] <= 450){
        	$cod_prod = 990;
    	}elseif($sim[numero_funcionarios] >= 451 and $sim[numero_funcionarios] <= 500){
        	$cod_prod = 991;
    	}elseif($sim[numero_funcionarios] >= 501 and $sim[numero_funcionarios] <= 600){
        	$cod_prod = 992;
    	}elseif($sim[numero_funcionarios] >= 601 and $sim[numero_funcionarios] <= 700){
        	$cod_prod = 993;
    	}elseif($sim[numero_funcionarios] >= 701 and $sim[numero_funcionarios] <= 800){
        	$cod_prod = 994;
    	}elseif($sim[numero_funcionarios] >= 801 and $sim[numero_funcionarios] <= 900){
        	$cod_prod = 995;
    	}elseif($sim[numero_funcionarios] > 900){
        	$cod_prod = 996;
    	}
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
        VALUES
    	($cod_orcamento, $cod_prod, 1, $prod[preco_prod], $prod[preco_prod])";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 5;

    	//--> PPP -----------------------------------------------------------
    	if($sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 933;
    	}elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
        	$cod_prod = 934;
    	}elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
        	$cod_prod = 935;
    	}elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
        	$cod_prod = 936;
    	}elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
        	$cod_prod = 937;
    	}elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
        	$cod_prod = 938;
    	}elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
        	$cod_prod = 939;
    	}elseif($sim[numero_funcionarios] > 350){
        	$cod_prod = 940;
    	}
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
        VALUES
    	($cod_orcamento, $cod_prod, $sim[numero_funcionarios], $prod[preco_prod], ".($sim[numero_funcionarios] * $prod[preco_prod]).")";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 6;

        //--> PCMSO -----------------------------------------------------------
        if($sim[numero_funcionarios] <= 10 ){
            $cod_prod = 424;
        }elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
            $cod_prod = 952;
        }elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
            $cod_prod = 953;
        }elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
            $cod_prod = 954;
        }elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
            $cod_prod = 955;
        }elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
            $cod_prod = 956;
        }elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
            $cod_prod = 957;
        }elseif($sim[numero_funcionarios] >= 351 and $sim[numero_funcionarios] <= 450){
            $cod_prod = 958;
        }elseif($sim[numero_funcionarios] >= 451 and $sim[numero_funcionarios] <= 500){
            $cod_prod = 997;
        }elseif($sim[numero_funcionarios] >= 501 and $sim[numero_funcionarios] <= 600){
            $cod_prod = 998;
        }elseif($sim[numero_funcionarios] >= 601 and $sim[numero_funcionarios] <= 700){
            $cod_prod = 999;
        }elseif($sim[numero_funcionarios] >= 701 and $sim[numero_funcionarios] <= 800){
            $cod_prod = 1000;
        }elseif($sim[numero_funcionarios] >= 801 and $sim[numero_funcionarios] <= 900){
            $cod_prod = 1001;
        }elseif($sim[numero_funcionarios] > 900){
            $cod_prod = 1002;
        }
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
        VALUES
    	($cod_orcamento, $cod_prod, 1, $prod[preco_prod], $prod[preco_prod])";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 7;

    	//--> APGRE -----------------------------------------------------------
    	if( $sim[numero_funcionarios] <= 10 ){
        	$cod_prod = 972;
    	}elseif($sim[numero_funcionarios] >= 11 and $sim[numero_funcionarios] <= 20){
        	$cod_prod = 973;
    	}elseif($sim[numero_funcionarios] >= 21 and $sim[numero_funcionarios] <= 50){
        	$cod_prod = 974;
    	}elseif($sim[numero_funcionarios] >= 51 and $sim[numero_funcionarios] <= 100){
        	$cod_prod = 975;
    	}elseif($sim[numero_funcionarios] >= 101 and $sim[numero_funcionarios] <= 150){
        	$cod_prod = 976;
    	}elseif($sim[numero_funcionarios] >= 151 and $sim[numero_funcionarios] <= 250){
        	$cod_prod = 977;
    	}elseif($sim[numero_funcionarios] >= 251 and $sim[numero_funcionarios] <= 350){
        	$cod_prod = 978;
    	}elseif($sim[numero_funcionarios] >= 351 and $sim[numero_funcionarios] <= 450){
        	$cod_prod = 979;
    	}elseif($sim[numero_funcionarios] >= 451 and $sim[numero_funcionarios] <= 500){
        	$cod_prod = 1003;
    	}elseif($sim[numero_funcionarios] >= 501 and $sim[numero_funcionarios] <= 600){
        	$cod_prod = 1004;
    	}elseif($sim[numero_funcionarios] >= 601 and $sim[numero_funcionarios] <= 700){
        	$cod_prod = 1005;
    	}elseif($sim[numero_funcionarios] >= 701 and $sim[numero_funcionarios] <= 800){
        	$cod_prod = 1006;
    	}elseif($sim[numero_funcionarios] >= 801 and $sim[numero_funcionarios] <= 900){
        	$cod_prod = 1007;
    	}elseif($sim[numero_funcionarios] > 900){
        	$cod_prod = 1008;
    	}
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
        VALUES
    	($cod_orcamento, $cod_prod, 1, $prod[preco_prod], $prod[preco_prod])";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 8;

    	//--> CURSO EPI -----------------------------------------------------------
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 431";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
        VALUES
    	($cod_orcamento, 431, 1, $prod[preco_prod], $prod[preco_prod])";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 9;

        //--> LTCAT -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
        if($sim[grau_de_risco] == 3){
            if($sim[numero_funcionarios] <= 10 ){
                $cod_prod = 440;
            }elseif($sim[numero_funcionarios] >= 11 && $sim[numero_funcionarios] <= 20 ){
                $cod_prod = 441;
            }elseif($sim[numero_funcionarios] >= 21 && $sim[numero_funcionarios] <= 50 ){
                $cod_prod = 442;
            }elseif($sim[numero_funcionarios] >= 51 && $sim[numero_funcionarios] <= 100 ){
                $cod_prod = 443;
            }elseif($sim[numero_funcionarios] >= 101 && $sim[numero_funcionarios] <= 150 ){
                $cod_prod = 444;
            }elseif($sim[numero_funcionarios] >= 151 && $sim[numero_funcionarios] <= 250 ){
                $cod_prod = 445;
            }elseif($sim[numero_funcionarios] >= 251 && $sim[numero_funcionarios] <= 350 ){
                $cod_prod = 446;
            }elseif($sim[numero_funcionarios] >= 351 && $sim[numero_funcionarios] <= 450 ){
                $cod_prod = 447;
            }elseif($sim[numero_funcionarios] >= 451 && $sim[numero_funcionarios] <= 500 ){
                $cod_prod = 1009;
            }elseif($sim[numero_funcionarios] >= 501 && $sim[numero_funcionarios] <= 600 ){
                $cod_prod = 1010;
            }elseif($sim[numero_funcionarios] >= 601 && $sim[numero_funcionarios] <= 700 ){
                $cod_prod = 1011;
            }elseif($sim[numero_funcionarios] >= 701 && $sim[numero_funcionarios] <= 800 ){
                $cod_prod = 1012;
            }elseif($sim[numero_funcionarios] >= 801 && $sim[numero_funcionarios] <= 900 ){
                $cod_prod = 1013;
            }elseif($sim[numero_funcionarios] > 900 ){
                $cod_prod = 1014;
            }
        }elseif($sim[grau_de_risco] == 4){
            if($sim[numero_funcionarios] <= 10 ){
                $cod_prod = 448;
            }elseif($sim[numero_funcionarios] >= 11 && $sim[numero_funcionarios] <= 20 ){
                $cod_prod = 804;
            }elseif($sim[numero_funcionarios] >= 21 && $sim[numero_funcionarios] <= 50 ){
                $cod_prod = 805;
            }elseif($sim[numero_funcionarios] >= 51 && $sim[numero_funcionarios] <= 100 ){
                $cod_prod = 890;
            }elseif($sim[numero_funcionarios] >= 101 && $sim[numero_funcionarios] <= 150 ){
                $cod_prod = 892;
            }elseif($sim[numero_funcionarios] >= 151 && $sim[numero_funcionarios] <= 250 ){
                $cod_prod = 894;
            }elseif($sim[numero_funcionarios] >= 251 && $sim[numero_funcionarios] <= 350 ){
                $cod_prod = 896;
            }elseif($sim[numero_funcionarios] >= 351 && $sim[numero_funcionarios] <= 450 ){
                $cod_prod = 942;
            }elseif($sim[numero_funcionarios] >= 451 && $sim[numero_funcionarios] <= 500 ){
                $cod_prod = 1015;
            }elseif($sim[numero_funcionarios] >= 501 && $sim[numero_funcionarios] <= 600 ){
                $cod_prod = 1016;
            }elseif($sim[numero_funcionarios] >= 601 && $sim[numero_funcionarios] <= 700 ){
                $cod_prod = 1017;
            }elseif($sim[numero_funcionarios] >= 701 && $sim[numero_funcionarios] <= 800 ){
                $cod_prod = 1018;
            }elseif($sim[numero_funcionarios] >= 801 && $sim[numero_funcionarios] <= 900 ){
                $cod_prod = 1019;
            }elseif($sim[numero_funcionarios] > 900 ){
                $cod_prod = 1020;
            }
        }
        if($sim[grau_de_risco] >=3){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = $cod_prod";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, $cod_prod, 1, $prod[preco_prod], $prod[preco_prod])";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 10;
        }

    	//--> MAPA DE RISCO A3 e A4 -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
        if($sim[grau_de_risco] <= 2){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 963";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 963, 1, $prod[preco_prod], $prod[preco_prod])";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 11;

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 965";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 965, 2, $prod[preco_prod], ".(2 * $prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 12;
        }else{
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 422";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 422, 1, $prod[preco_prod], $prod[preco_prod])";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 13;

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 964";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 964, 2, $prod[preco_prod], ".(2 * $prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 14;
        }

        //--> CURSO DE CIPA -----------------------------------------------------------
        $num = explode("|", $sim[num_rep]);
        $t   = (int)($num[0] + $num[1]);
        if($t > 1){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 840";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 840, $t, $prod[preco_prod], ".($t * $prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 15;

        	//acessoria a cipa - organização de processo eleitoral
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 980";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 980, 1, $prod[preco_prod], ".($prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 16;

        	//acessoria a cipa - elaboração de ata ordinária (mensal) 12x
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 981";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 981, 12, $prod[preco_prod], ".(12 * $prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 17;
        }else{
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 897";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 897, 1, $prod[preco_prod], ".($prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 18;
        }

        //--> CURSO DE PREVENÇÃO DE INCÊNDIO --------------------------------------------
        if($sim[membros_brigada] > 0){
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 982";
    	    $prod = pg_fetch_array(pg_query($sql));
        	$sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
            VALUES
        	($cod_orcamento, 982, $sim[membros_brigada], $prod[preco_prod], ".($sim[membros_brigada] * $prod[preco_prod]).")";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 19;
        }

        //--> PCMAT ----------------------------------------------------------------------
        $sql = "SELECT * FROM cnae WHERE cnae_id = '$sim[cnae_id]' AND lower(descricao) like '%construção civil%' AND grau_risco > 2";
        $rcc = pg_query($sql);
        if(pg_num_rows($rcc)){
            $sql = "SELECT * FROM produto WHERE lower(desc_resumida_prod) LIKE '%pcmat%'
            AND $sim[numero_funcionarios] BETWEEN g_min AND g_max";
    		$rpd = pg_query($sql);
    		$prod = pg_fetch_array($rpd);
    		if(pg_num_rows($rpd)){
    		    $sql  = "INSERT INTO orcamento_produto (cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
                VALUES
            	($cod_orcamento, $prod[cod_prod], 1, $prod[preco_prod], ".($prod[preco_prod]).")";
                if(pg_query($sql))
        	        $error = 0;
                else
                    $error = 20;
    		}
        }
    }//if no error found (delete)
    return $error;
}*/
?>
