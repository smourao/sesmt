<?PHP
if($_GET[action] == "incluir"){
    $ativar = "UPDATE funcionarios SET cod_status = 1 WHERE id = ".(int)($_GET[id_func]);
    $upresult = @pg_query($ativar);
}

if($_GET[action] == "del"){
	
	$cod_cliente = $_GET[cod_cliente];
	
	
	
			$cadclientesql = "SELECT * FROM cliente WHERE cliente_id = ".$cod_cliente."";
			$cadclientequery = pg_query($cadclientesql);
			$cadcliente = pg_fetch_array($cadclientequery);
			
			$graurisco = $cadcliente[grau_de_risco];
			$razao_social = $cadcliente['razao_social'];
			
			
			
			
			
			$numfuncantessql = 'SELECT * FROM funcionarios WHERE cod_cliente = '.$cod_cliente.' AND cod_status = 1';

			$numfuncantesquery = pg_query($numfuncantessql);

			$numfuncantes = pg_num_rows($numfuncantesquery);	
	
	
	
	
	
    $sql = "UPDATE funcionarios SET cod_status = 0 WHERE id = ".(int)($_GET[id_func]);
    if(@pg_query($sql)){
		
		
		
		
		
		
		
		
		
		$numfuncdepoissql = 'SELECT * FROM funcionarios WHERE cod_cliente = '.$cod_cliente.' AND cod_status = 1';

			$numfuncdepoisquery = pg_query($numfuncdepoissql);

			$numfuncdepois = pg_num_rows($numfuncdepoisquery);
		   
		   
		   
		    $gruponumantessql = 'SELECT * FROM grupo_func WHERE g_min<='.$numfuncantes.' AND g_max>='.$numfuncantes.'';
			$gruponumantesquery = pg_query($gruponumantessql);
			$gruponumantes = pg_fetch_array($gruponumantesquery);



			$gruponumdepoissql = 'SELECT * FROM grupo_func WHERE g_min<='.$numfuncdepois.' AND g_max>='.$numfuncdepois.'';
			$gruponumdepoisquery = pg_query($gruponumdepoissql);
			$gruponumdepois = pg_fetch_array($gruponumdepoisquery);
			
			
			$orcacontratosql = "SELECT * FROM site_gerar_contrato WHERE cod_cliente = ".$cod_cliente." AND status = 1";
			$orcacontratoquery = pg_query($orcacontratosql);
			$orcacontrato = pg_fetch_array($orcacontratoquery);
			$orcacontranum = pg_num_rows($orcacontratoquery);


			if(($gruponumantes[grupo] > $gruponumdepois[grupo]) && $orcacontranum >= 1){
				
			
		$pegarmaxsql = "SELECT MAX(cod_orcamento) + 1 as cod_orcamento FROM site_orc_info_alter";
        $pegarmaxquery = pg_query($pegarmaxsql);
        $pegarmax = pg_fetch_array($pegarmaxquery);
			
			
			$insertnovoorcsql = "INSERT INTO site_orc_info_alter
		(cod_orcamento, cod_cliente, data_criacao)
		VALUES
		({$pegarmax[cod_orcamento]}, {$cod_cliente}, '".date("Y-m-d")."')";
        if(pg_query($insertnovoorcsql))
            $error = 0;//echo "insert ok;<BR>";
        else
            $error = 3;//echo "Error $insertnovoorcsql<BR>";
			
			$orcamento_contrato = $pegarmax[cod_orcamento];
			
			
			
			
			//--> ASO -----------------------------------------------------------
			
			
			$pesquiasosql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 891 OR cod_produto = 893 OR cod_produto = 895 OR cod_produto = 928 OR cod_produto = 929 OR cod_produto = 930 OR cod_produto = 931 OR cod_produto = 932 OR cod_produto = 70481)";

    $pesquiasoquery = pg_query($pesquiasosql);

    $pesquiaso = pg_num_rows($pesquiasoquery);

    if($pesquiaso >= 1){
			
			
			
			
      	if($numfuncdepois <= 10 ){
        	$cod_prod = 891;
    	}elseif($numfuncdepois >= 11 && $numfuncdepois <= 20){
        	$cod_prod = 893;
    	}elseif($numfuncdepois >= 21 && $numfuncdepois <= 50){
        	$cod_prod = 895;
    	}elseif($numfuncdepois >= 51 && $numfuncdepois <= 100){
        	$cod_prod = 928;
    	}elseif($numfuncdepois >= 101 && $numfuncdepois <= 150){
        	$cod_prod = 929;
    	}elseif($numfuncdepois >= 151 && $numfuncdepois <= 250){
        	$cod_prod = 930;
    	}elseif($numfuncdepois >= 251 && $numfuncdepois <= 350){
        	$cod_prod = 931;
    	}elseif($numfuncdepois > 350){
        	$cod_prod = 932;
    	}
		
		//--> ASO COM VALOR UNICO INDEPEDENDO DO NUMERO DOS FUNCIONARIOS
		if($orcacontrato['ultima_alteracao'] >= '2015-01-01'){
		$cod_prod = 70481;
		}
		
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$orcamento_contrato', ".$cod_cliente.", 1, $cod_prod, $numfuncdepois, 0, '', $prod[preco_prod] )";
    	if(pg_query($sql))
    	    $error = 0;
        else
            $error = 4;
			
    }



 //--> PPRA -----------------------------------------------------------


    $pesquipprasql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 423 OR cod_produto = 966 OR cod_produto = 967 OR cod_produto = 968 OR cod_produto = 969 OR cod_produto = 970 OR cod_produto = 971 OR cod_produto = 990 OR cod_produto = 991 OR cod_produto = 992 OR cod_produto = 993 OR cod_produto = 994 OR cod_produto = 995 OR cod_produto = 996)";

    $pesquippraquery = pg_query($pesquipprasql);

    $pesquippra = pg_num_rows($pesquippraquery);

    if($pesquippra >= 1){


        if($numfuncdepois <= 10 ){
        	$cod_prod = 423;
    	}elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
        	$cod_prod = 966;
    	}elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
        	$cod_prod = 967;
    	}elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
        	$cod_prod = 968;
    	}elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
        	$cod_prod = 969;
    	}elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
        	$cod_prod = 970;
    	}elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
        	$cod_prod = 971;
    	}elseif($numfuncdepois >= 351 and $numfuncdepois <= 450){
        	$cod_prod = 990;
    	}elseif($numfuncdepois >= 451 and $numfuncdepois <= 500){
        	$cod_prod = 991;
    	}elseif($numfuncdepois >= 501 and $numfuncdepois <= 600){
        	$cod_prod = 992;
    	}elseif($numfuncdepois >= 601 and $numfuncdepois <= 700){
        	$cod_prod = 993;
    	}elseif($numfuncdepois >= 701 and $numfuncdepois <= 800){
        	$cod_prod = 994;
    	}elseif($numfuncdepois >= 801 and $numfuncdepois <= 900){
        	$cod_prod = 995;
    	}elseif($numfuncdepois > 900){
        	$cod_prod = 996;
    	}
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$orcamento_contrato', ".$cod_cliente.", 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 5;
			
			
    }




    	//--> PPP -----------------------------------------------------------
		
		$pesquipppsql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 933 OR cod_produto = 934 OR cod_produto = 935 OR cod_produto = 936 OR cod_produto = 937 OR cod_produto = 938 OR cod_produto = 939 OR cod_produto = 940 OR cod_produto = 70521)";

    $pesquipppquery = pg_query($pesquipppsql);

    $pesquippp = pg_num_rows($pesquipppquery);

    if($pesquippp >= 1){
		
		
		
    	if($numfuncdepois <= 10 ){
        	$cod_prod = 933;
    	}elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
        	$cod_prod = 934;
    	}elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
        	$cod_prod = 935;
    	}elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
        	$cod_prod = 936;
    	}elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
        	$cod_prod = 937;
    	}elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
        	$cod_prod = 938;
    	}elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
        	$cod_prod = 939;
    	}elseif($numfuncdepois > 350){
        	$cod_prod = 940;
    	}
			if($orcacontrato['ultima_alteracao'] >= '2015-01-01'){
			$cod_prod = 70521;
			}
		
    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$orcamento_contrato', $cod_cliente, 1, $cod_prod, $numfuncdepois, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 6;
			
			
			
    }
			
			$pesquipcmsosql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 424 OR cod_produto = 952 OR cod_produto = 953 OR cod_produto = 954 OR cod_produto = 955 OR cod_produto = 956 OR cod_produto = 957 OR cod_produto = 958 OR cod_produto = 997 OR cod_produto = 998 OR cod_produto = 999 OR cod_produto = 1000 OR cod_produto = 1001 OR cod_produto = 1002)";

    $pesquipcmsoquery = pg_query($pesquipcmsosql);

    $pesquipcmso = pg_num_rows($pesquipcmsoquery);

    if($pesquipcmso >= 1){
    			
			
			

        //--> PCMSO -----------------------------------------------------------
        if($numfuncdepois <= 10 ){
            $cod_prod = 424;
        }elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
            $cod_prod = 952;
        }elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
            $cod_prod = 953;
        }elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
            $cod_prod = 954;
        }elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
            $cod_prod = 955;
        }elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
            $cod_prod = 956;
        }elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
            $cod_prod = 957;
        }elseif($numfuncdepois >= 351 and $numfuncdepois <= 450){
            $cod_prod = 958;
        }elseif($numfuncdepois >= 451 and $numfuncdepois <= 500){
            $cod_prod = 997;
        }elseif($numfuncdepois >= 501 and $numfuncdepois <= 600){
            $cod_prod = 998;
        }elseif($numfuncdepois >= 601 and $numfuncdepois <= 700){
            $cod_prod = 999;
        }elseif($numfuncdepois >= 701 and $numfuncdepois <= 800){
            $cod_prod = 1000;
        }elseif($numfuncdepois >= 801 and $numfuncdepois <= 900){
            $cod_prod = 1001;
        }elseif($numfuncdepois > 900){
            $cod_prod = 1002;
        }
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$orcamento_contrato', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 7;
			
			
			
    }
			
			$pesquiapgresql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 972 OR cod_produto = 973 OR cod_produto = 974 OR cod_produto = 975 OR cod_produto = 976 OR cod_produto = 977 OR cod_produto = 978 OR cod_produto = 979 OR cod_produto = 1003 OR cod_produto = 1004 OR cod_produto = 1005 OR cod_produto = 1006 OR cod_produto = 1007 OR cod_produto = 1008)";

    $pesquiapgrequery = pg_query($pesquiapgresql);

    $pesquiapgre = pg_num_rows($pesquiapgrequery);

    if($pesquiapgre >= 1){
			
			

    	//--> APGRE -----------------------------------------------------------
    	if( $numfuncdepois <= 10 ){
        	$cod_prod = 972;
    	}elseif($numfuncdepois >= 11 and $numfuncdepois <= 20){
        	$cod_prod = 973;
    	}elseif($numfuncdepois >= 21 and $numfuncdepois <= 50){
        	$cod_prod = 974;
    	}elseif($numfuncdepois >= 51 and $numfuncdepois <= 100){
        	$cod_prod = 975;
    	}elseif($numfuncdepois >= 101 and $numfuncdepois <= 150){
        	$cod_prod = 976;
    	}elseif($numfuncdepois >= 151 and $numfuncdepois <= 250){
        	$cod_prod = 977;
    	}elseif($numfuncdepois >= 251 and $numfuncdepois <= 350){
        	$cod_prod = 978;
    	}elseif($numfuncdepois >= 351 and $numfuncdepois <= 450){
        	$cod_prod = 979;
    	}elseif($numfuncdepois >= 451 and $numfuncdepois <= 500){
        	$cod_prod = 1003;
    	}elseif($numfuncdepois >= 501 and $numfuncdepois <= 600){
        	$cod_prod = 1004;
    	}elseif($numfuncdepois >= 601 and $numfuncdepois <= 700){
        	$cod_prod = 1005;
    	}elseif($numfuncdepois >= 701 and $numfuncdepois <= 800){
        	$cod_prod = 1006;
    	}elseif($numfuncdepois >= 801 and $numfuncdepois <= 900){
        	$cod_prod = 1007;
    	}elseif($numfuncdepois > 900){
        	$cod_prod = 1008;
    	}
        $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$orcamento_contrato', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 8;
			
			
	}
			
			
				
				
		
				

    	//--> CURSO EPI -----------------------------------------------------------
		
		$pesquiepisql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 431";

    $pesquiepiquery = pg_query($pesquiepisql);

    $pesquiepi = pg_num_rows($pesquiepiquery);

    if($pesquiepi >= 1){		

    	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 431";
    	$prod = pg_fetch_array(pg_query($sql));
    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
        VALUES
		('$orcamento_contrato', $cod_cliente, 1, 431, 1, 0, '', $prod[preco_prod] )";
        if(pg_query($sql))
    	    $error = 0;
        else
            $error = 9;
			
			
			
    }
			
			
			
			

    $pesquiltcat3sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 440 OR cod_produto = 441 OR cod_produto = 442 OR cod_produto = 443 OR cod_produto = 444 OR cod_produto = 445 OR cod_produto = 446 OR cod_produto = 447 OR cod_produto = 448 OR cod_produto = 804 OR cod_produto = 805 OR cod_produto = 890 OR cod_produto = 892 OR cod_produto = 894)";

    $pesquiltcat3query = pg_query($pesquiltcat3sql);

    $pesquiltcat3 = pg_num_rows($pesquiltcat3query);

    if($pesquiltcat3 >= 1){
    			
			
			

        //--> LTCAT -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
       
            if($numfuncdepois <= 10 ){
                $cod_prod = 440;
            }elseif($numfuncdepois >= 11 && $numfuncdepois <= 20 ){
                $cod_prod = 441;
            }elseif($numfuncdepois >= 21 && $numfuncdepois <= 50 ){
                $cod_prod = 442;
            }elseif($numfuncdepois >= 51 && $numfuncdepois <= 100 ){
                $cod_prod = 443;
            }elseif($numfuncdepois >= 101 && $numfuncdepois <= 150 ){
                $cod_prod = 444;
            }elseif($numfuncdepois >= 151 && $numfuncdepois <= 250 ){
                $cod_prod = 445;
            }elseif($numfuncdepois >= 251 && $numfuncdepois <= 350 ){
                $cod_prod = 446;
            }elseif($numfuncdepois >= 351 && $numfuncdepois <= 450 ){
                $cod_prod = 447;
            }elseif($numfuncdepois >= 451 && $numfuncdepois <= 500 ){
                $cod_prod = 1009;
            }elseif($numfuncdepois >= 501 && $numfuncdepois <= 600 ){
                $cod_prod = 1010;
            }elseif($numfuncdepois >= 601 && $numfuncdepois <= 700 ){
                $cod_prod = 1011;
            }elseif($numfuncdepois >= 701 && $numfuncdepois <= 800 ){
                $cod_prod = 1012;
            }elseif($numfuncdepois >= 801 && $numfuncdepois <= 900 ){
                $cod_prod = 1013;
            }elseif($numfuncdepois > 900 ){
                $cod_prod = 1014;
            }
			
			
			 $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 10;
			
		}
		

    $pesquiltcat4sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 896 OR cod_produto = 942 OR cod_produto = 1009 OR cod_produto = 1010 OR cod_produto = 1011 OR cod_produto = 1012 OR cod_produto = 1013 OR cod_produto = 1014 OR cod_produto = 1015 OR cod_produto = 1016 OR cod_produto = 1017 OR cod_produto = 1018 OR cod_produto = 1019 OR cod_produto = 1020)";

    $pesquiltcat4query = pg_query($pesquiltcat4sql);

    $pesquiltcat4 = pg_num_rows($pesquiltcat4query);

    if($pesquiltcat4 >= 1){

			
			
			
        
            if($numfuncdepois <= 10 ){
                $cod_prod = 448;
            }elseif($numfuncdepois >= 11 && $numfuncdepois <= 20 ){
                $cod_prod = 804;
            }elseif($numfuncdepois >= 21 && $numfuncdepois <= 50 ){
                $cod_prod = 805;
            }elseif($numfuncdepois >= 51 && $numfuncdepois <= 100 ){
                $cod_prod = 890;
            }elseif($numfuncdepois >= 101 && $numfuncdepois <= 150 ){
                $cod_prod = 892;
            }elseif($numfuncdepois >= 151 && $numfuncdepois <= 250 ){
                $cod_prod = 894;
            }elseif($numfuncdepois >= 251 && $numfuncdepois <= 350 ){
                $cod_prod = 896;
            }elseif($numfuncdepois >= 351 && $numfuncdepois <= 450 ){
                $cod_prod = 942;
            }elseif($numfuncdepois >= 451 && $numfuncdepois <= 500 ){
                $cod_prod = 1015;
            }elseif($numfuncdepois >= 501 && $numfuncdepois <= 600 ){
                $cod_prod = 1016;
            }elseif($numfuncdepois >= 601 && $numfuncdepois <= 700 ){
                $cod_prod = 1017;
            }elseif($numfuncdepois >= 701 && $numfuncdepois <= 800 ){
                $cod_prod = 1018;
            }elseif($numfuncdepois >= 801 && $numfuncdepois <= 900 ){
                $cod_prod = 1019;
            }elseif($numfuncdepois > 900 ){
                $cod_prod = 1020;
            }
			
			 $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = ".$cod_prod."";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, $cod_prod, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 10;
        
		}
	
		
       
           
       

    	//--> MAPA DE RISCO A3 e A4 -----------------------------------------------------------
        // Apenas grau de risco 3 ou 4
		
	
		
		
      
			
			
			$pesquimrga3sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 963";

			$pesquimrga3query = pg_query($pesquimrga3sql);

			$pesquimrga3 = pg_num_rows($pesquimrga3query);

			if($pesquimrga3 >= 1){
			
			
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 963";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 963, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
        	    $error = 0;
            else
                $error = 11;
				
			}
			
			//--------
			
			$pesquimrsa4sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 965";

			$pesquimrsa4query = pg_query($pesquimrsa4sql);

			$pesquimrsa4 = pg_num_rows($pesquimrsa4query);

			if($pesquimrsa4 >= 1){
			
			
			
				

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 965";
    	    $prod = pg_fetch_array(pg_query($sql));
	    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 965, 2, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 12;
				
				
			}
				
				
			//------------
				
     
			
			$pesquimrga0sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 422";
	
			$pesquimrga0query = pg_query($pesquimrga0sql);

			$pesquimrga0 = pg_num_rows($pesquimrga0query);

			if($pesquimrga0 >= 1){
			
			
			
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 422";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 422, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 13;
				
			}
				
			
			//--------------	
				
				
			$pesquimrsa3sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 964";

			$pesquimrsa3query = pg_query($pesquimrsa3sql);

			$pesquimrsa3 = pg_num_rows($pesquimrsa3query);

			if($pesquimrsa3 >= 1){
				

        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 964";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 964, 2, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 14;
				
				
				
			}
				
			
      
		
		
		

        //--> CURSO DE CIPA -----------------------------------------------------------
		
		
		
		
		
		
		
        $num = explode("|", $cadcliente['num_rep']);
        $t   = (int)($num[0] + $num[1]);
        if($t > 1){
			
			$pesquicurcipasql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 840 OR cod_produto = 70491)";

    $pesquicurcipaquery = pg_query($pesquicurcipasql);

    $pesquicurcipa = pg_num_rows($pesquicurcipaquery);

    if($pesquicurcipa >= 1){
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 840";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 840, $t, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 15;
				
				
    }
				
				//acessoria a cipa - organização de processo eleitoral
				
			$pesquigescipasql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 980 OR cod_produto = 70490)";

			$pesquigescipaquery = pg_query($pesquigescipasql);

			$pesquigescipa = pg_num_rows($pesquigescipaquery);

			if($pesquigescipa >= 1){	
				
				

        	
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 980";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 980, 1, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 16;
				
				
			}
			
			//acessoria a cipa - elaboração de ata ordinária (mensal) 12x
			
			$pesquiatacipasql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 981 OR cod_produto = 70489 OR cod_produto = 70488)";

		$pesquiatacipaquery = pg_query($pesquiatacipasql);

		$pesquiatacipa = pg_num_rows($pesquiatacipaquery);

		if($pesquiatacipa >= 1){

			
        	
        	$sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 981";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 981, 12, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 17;
				
		}
				
				
			//-----------
				
				
        }else{
			
			$pesquiminiscipasql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 897";

			$pesquiminiscipaquery = pg_query($pesquiminiscipasql);

			$pesquiminiscipa = pg_num_rows($pesquiminiscipaquery);

			if($pesquiminiscipa >= 1){
			
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 897";
    	    $prod = pg_fetch_array(pg_query($sql));
			$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 897, $t, 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 18;
			}
				
		 }

        //--> CURSO DE PREVENÇÃO DE INCÊNDIO --------------------------------------------
		
		
        if($cadcliente['membros_brigada'] > 0){
			
			$pesquicurinsql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND cod_produto = 982";

			$pesquicurinquery = pg_query($pesquicurinsql);

			$pesquicurin = pg_num_rows($pesquicurinquery);

			if($pesquicurin >= 1){
			
			
            $sql  = "SELECT preco_prod FROM produto WHERE cod_prod = 982";
    	    $prod = pg_fetch_array(pg_query($sql));
	    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
			VALUES
			('$orcamento_contrato', $cod_cliente, 1, 982, $cadcliente[membros_brigada], 0, '', $prod[preco_prod] )";
            if(pg_query($sql))
    	        $error = 0;
            else
                $error = 19;
				
				
			}
		}
		
		
		
		

        //--> PCMAT ----------------------------------------------------------------------
       
	   
	   
	   
	    $sql = "SELECT * FROM cnae WHERE cnae_id = '$cadcliente[cnae_id]' AND lower(descricao) like '%construção civil%' AND grau_risco > 2";
        $rcc = pg_query($sql);
        if(pg_num_rows($rcc)){
			
			$pesquipcmatsql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".$cod_cliente." AND (cod_produto = 432 OR cod_produto = 			433 OR cod_produto = 435 OR cod_produto = 436 OR cod_produto = 437 OR cod_produto = 438 OR cod_produto = 439 OR cod_produto = 1021 OR cod_produto = 1022 OR cod_produto = 1023 OR cod_produto = 1024 OR cod_produto = 1025 OR cod_produto = 1026 OR cod_produto = 1027)";

			$pesquipcmatquery = pg_query($pesquipcmatsql);

			$pesquipcmat = pg_num_rows($pesquipcmatquery);

			if($pesquipcmat >= 1){
			
			
            $sql = "SELECT * FROM produto WHERE lower(desc_resumida_prod) LIKE '%pcmat%'
            AND $numfuncdepois BETWEEN g_min AND g_max";
    		$rpd = pg_query($sql);
    		$prod = pg_fetch_array($rpd);
    		if(pg_num_rows($rpd)){
		    	$sql  = "INSERT INTO site_orc_produto_alter (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
				VALUES
				('$orcamento_contrato', $cod_cliente, 1, $prod[cod_prod], 1, 0, '', $prod[preco_prod] )";
                if(pg_query($sql))
        	        $error = 0;
                else
                    $error = 20;
					
					
			}
					
    		}
        }
			
			
		
				
				
				
				$link  = "<center><b><h2>NOTIFICAÇÃO DE ALTERAÇÃO EM COBRANÇA</h2></b></center>";
		$link .= "<center><p>O SIST notifica  a alteração de cobrança por grupo de colaboradores onde o cliente: ".$razao_social." ., Cód. ".$cod_cliente." , conforme proposta em simulação de orçamento alterados.</center>";
		$link .= "Desceu de Grupo: [".$gruponumdepois[g_min]." - ".$gruponumdepois[g_max]."] ";
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@ti-seg.com> \n";
	
		//$email = "peteson89@hotmail.com";
		$email = "sidneimourao@gmail.com";
		if(mail($email, "SESMT - NOTIFICAÇÃO DE ALTERAÇÃO EM COBRANÇA", $link, $headers)){
			
		}else{
			
		}



			}else{
				
				
				//Caso não tenha mudado de grupo, não acontecer nada
				
			}
				
				
		
		
		
		
    }else{
		showMessage('<p align=justify>Erro ao alterar status do funcionário!</p>', 2);
    }
}
        
        if($_POST){

        }else{
			
			
			
			if(!$_GET[filtro]){
            $sql = "SELECT f.* FROM funcionarios f
            WHERE cod_cliente = $_GET[cod_cliente]
			AND f.cod_status = 1
            ORDER BY f.nome_func";
			
			}else if($_GET[filtro] == 'ativo'){
				$sql = "SELECT f.* FROM funcionarios f
            WHERE cod_cliente = $_GET[cod_cliente]
			AND f.cod_status = 1
            ORDER BY f.nome_func";
				
			}else if($_GET[filtro] == 'inativo'){
				$sql = "SELECT f.* FROM funcionarios f
            WHERE cod_cliente = $_GET[cod_cliente]
			AND f.cod_status = 0
            ORDER BY f.nome_func";
			}
			
			
			
			
        }

        $r = pg_query($sql);
        $funcionarios = pg_fetch_all($r);
		
		echo "<table width=50% align=center>";
        echo "<tr>";	
		
		echo "<td><input type=button value='Funcionários Ativos' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]&filtro=ativo';\"></td>";
		
		echo "<td><input type=button value='Funcionários Inativos' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]&filtro=inativo';\"></td>";
		
		echo "</tr>";
		echo "</table>";

        if(pg_num_rows($r)>0){
		
        echo "<table width=100% BORDER=0 align=center>";
        echo "<tr>";
        echo "<td width=8% align=center class='text roundborder curhand'><b>Cód.</b></td>";
        echo "<td width=62% align=left class='text roundborder curhand'><b>Nome</b></td>";
        echo "<td width=10% align=center class='text roundborder curhand'><b>CTPS</b></td>";
        echo "<td width=10% align=center class='text roundborder curhand'><b>Série</b></td>";
        echo "<td width=10% align=center class='text roundborder curhand'><b>Excluir</b></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                if(empty($funcionarios[$x][num_ctps_func]) || empty($funcionarios[$x][serie_ctps_func])
                || empty($funcionarios[$x][cbo]) || empty($funcionarios[$x][cod_funcao]) ||
                empty($funcionarios[$x][sexo_func]) || empty($funcionarios[$x][data_nasc_func]) ||
                empty($funcionarios[$x][data_admissao_func])){
                    $bg = '#D75757';
                }else{
                    $bg = '#006633';
                }
                echo "<tr>";
                echo "<td align=center class='text roundborder curhand' bgcolor='$bg'><font size=1>".str_pad($funcionarios[$x][cod_func], 3, "0", 0)."</td>";
                echo "<td align=left class='text roundborder curhand' bgcolor='$bg'><font size=1><b><a class=fontebranca12 href='?dir=cad_cliente&p=detail&cod_cliente=$_GET[cod_cliente]&cod_func={$funcionarios[$x][cod_func]}'>"; print $funcionarios[$x][cod_status] ? "":"<i>[Inativo]</i> "; echo "<b>".$funcionarios[$x][nome_func]."</b></a></b></font></td>";
                echo "<td align=center class='text roundborder curhand' bgcolor='$bg'>".$funcionarios[$x][num_ctps_func]."</td>";
                echo "<td align=center class='text roundborder curhand' bgcolor='$bg'><font size=1>{$funcionarios[$x][serie_ctps_func]}</td>";
                if($_GET[filtro] == 'inativo'){
                    echo "<td align=center class='text roundborder curhand' bgcolor='$bg'><font size=1><a class=fontebranca12 href='?dir=cad_cliente&p=cadastro_func&action=incluir&cod_cliente=$_GET[cod_cliente]&id_func={$funcionarios[$x][id]}';}\">Ativar</a></td>";
                }else{
                    echo "<td align=center class='text roundborder curhand' bgcolor='$bg'><font size=1><a class=fontebranca12 href='?dir=cad_cliente&p=cadastro_func&action=del&cod_cliente=$_GET[cod_cliente]&id_func={$funcionarios[$x][id]}';}\">Inativar</a></td>";
                }
            }
        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhum registro encontrado!</b></span></center>";
        }
?>