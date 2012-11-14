<?php

	// Her oprettes forbindelsen til databasen
		$con = mysql_connect("host", "un", "pw");
				mysql_select_db("db_name");

		$DBnavn = 'ooo';

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
	
   