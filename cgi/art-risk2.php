
<?php


	if (isset($_POST["miArray"])) { 
   	$miArray = $_POST["miArray"]; // save $foo from POST made by HTTP request
    	if(empty($miArray) || !is_array($miArray)){  
    		$output="-2.0";    // exist but it's null
    		$status="-2.0";
   	} else {
   		$input = "./art-risk2.bin";
			for ($i=0; $i<17; ++$i) {
				$input = $input." ".$miArray[$i];
			}  
			
			$input = $input." 2>&1"; 	  		
   		exec($input, $output, $status);
			//$salida = $input;
   	}
   }
   /**/
   $salida = "";
   foreach ($output as $line) {
    $salida = $salida." ".$line;
   }
   /**/
	echo "Salida: ".$salida." Status: ".$status; 
	
	exit ()   
	
	
?>

<!--
	if (isset($_POST["miArray"])) { 
   	$miArray = $_POST["miArray"]; // save $foo from POST made by HTTP request
    	if(empty($miArray)){  
    		$errMess="Vacio";    // exist but it's null
   	} else {
   		$errMess=$miArray.": Daniel";
   	}
   }
	echo "Resultado: ".$errMess; 
	exit ()   

    -->
 
 <!-- $miArray = $_POST['miArray']  -->
	<!--
	foreach($miArray as $msg){
    	echo $msg;
    	-->
    	