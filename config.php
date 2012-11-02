<?php

	// Her oprettes forbindelsen til databasen
		$con = mysql_connect("studdb01.hst.aau.dk", "arra", "Z9CFri8h");
				mysql_select_db("arra");

		$DBnavn = 'arra';

		if (!$con) 
		{
		   echo "Kunne ikke få kontakt med mysql på \n";
		   exit;
		}
		else if ($con) 
		{
		   //echo "Forbindelsen er oprettet \n";
		}
	?>
	
   