<?php

include("../../2.0/common/database/conn.php");
include("../../2.0/common/functions.php");
include("../../2.0/common/globals.php");
		
?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="content-Type" content="text/html; charset=iso-8859-1" />
		<title>Curso EPI</title>
        
        <style type="text/css">
		
			body{
				width:1000px;
				
			}
		
			.tudo{
				margin-left:10%;
				width:900px;
				}
				
			section{
				
				}
				
			.logo2{
				margin-left:75%;
				
				}
				
			.data{
				width:100%;
				margin-left:210%;
				
			}
				
			header{
				
				}
				
			article{
				text-align:center;
				}
        	
			footer{
				
			}
			
			.logo4{
				margin-left:340%;
				
				}
		
		
        </style>
        
        
<?php


$dia = date("d");
$mes = date("m");
$ano = date("Y");

$sql = "SELECT * FROM funcionario WHERE funcionario_id = ".$_SESSION['funcionario_id']."";
$funcquery = pg_query($sql);
$funcarray = pg_fetch_array($funcquery);

?>
        
	</head>

	<body>
    	
    <div class="tudo">
    
    <section>
    
    	<table>
    		<tr>
        	<td>
        		<img src="logo.jpg">
            </td>
            <td>
            	<div class="logo2"><img src="logo2.jpg"></div>
            </td>
            </tr>
        </table>
    
    </section>
    
    <header>
    
    <table>
    	<tr>
        <td>
   			<small>Raz&atilde;o Social: Redoma Servi&ccedil;os de Conserva&ccedil;&atilde;o e Reformas Ltda, <?php echo"$funcarray[funcionario_id]"; ?> </small>
        </td>
        <td>
        	<div class="data">Data: <?php echo"$dia/$mes/$ano"?></div>
        </td>
        </tr>
    </table>
    
    <br>
    
    </header>
        
    <aside>
        
		<table border="1" style="border:medium" width="90%" cellpadding="5px">
			<tr>
			<td>
				Curso NR 18 - Londrina Topografia Ltda
			</td>
			</tr>
		</table>
        
	</aside>
    
		<br>
        
	<article>

		<table border="1" width="90%" style="border:medium" cellspacing="0px">
			<tr>
			<td width="2%">
            	N&deg; Ordem
			</td>
            <td width="20%">
            	Candidato
            </td>
            <td width="20%">
            	Fun&ccedil;&atilde;o
            </td>
            <td width="10%">
            	CTPS
            </td>
            <td width="10%">
            	S&eacute;rie
            </td>
            <td width="15%">
            	Rubrica
            </td>
			</tr>
            <?php
			
				for($x=1;$x<16;$x++){
					echo"<tr>
            <td width='2%'>
            	".$x."
            </td>
            <td width='20%'>
            </td>
            <td width='20%'>
            </td>
            <td width='10%'>
            </td>
            <td width='10%'>
            </td>
            <td width='10%'>
            </td>
            </tr>";
				}
			
			
			?>
            
		</table>

	</article>        
	
        <br>
        
    <footer>
    
    	<table border="1" style="border:medium; float:left" width="90%" cellpadding="5px">
			<tr>
			<td>
            	Instrutor: <?php echo "$funcarray[nome]"; ?>
			</td>
			</tr>
		</table>
        
        	<br>
            <br>
            <br>
        
        <table>
        	<tr>
            <td>
            	<img src="logo3.jpg">
			</td>
            <td>
            	<div class="logo4"><img src="logo4.jpg"></div>
            </td>
            </tr>
        </table>
        
    </footer>
    
        </div>
	</body>
</html>