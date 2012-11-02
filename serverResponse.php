 <?php

include('config.php'); //Forbindelsen til Databasen
ini_set('display_errors', 0);

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

// This ID parameter is sent by our javascript client.
$id = $_GET['input'];


$tree = array();
$tree['nodes'] = array();
$tree['links'] = array();

//echo('i serverresponse');

getRelationships($id);



function getRelationships($val){
			
		  $interest_cpts = explode(',',$val);  	
	foreach($interest_cpts as $cptId){  	
			$array = getRelations($cptId);
			}
						
	$jsonArray = json_encode($array);	

//echo("JSONARRAY: ");
//echo "<pre>";
//print_r($array);
//echo "</pre>";

echo $jsonArray;
}



function getRelations($cpt_id)
{
$query = "SELECT tmp_tc1.supertypeId, sct2_description.Term
FROM `tmp_tc1` INNER JOIN `sct2_description`
ON tmp_tc1.supertypeId= sct2_description.conceptId WHERE tmp_tc1.subtypeId ='$cpt_id' AND sct2_description.typeId=900000000000003001 AND sct2_description.active=1;";		
	
// Her sættes variablen $tnavn der indeholder POST'en af den valgte tabel	
$result = mysql_query($query ) 
or die(mysql_error());  


// Her læses hvilke felter tabellen indeholder
$rows = mysql_num_rows($result);
global $tree;	

if($rows >0){
	while($row = mysql_fetch_assoc($result)) 
	{ 
	$parentId = $row['supertypeId'];
		
	$idExist = multi_in_array($parentId, $tree);	
		
	if($idExist == false){	
		$node = createNode($row);
		$link = createLink($cpt_id, $row);
		$tree['nodes'][] = $node;
		$tree['links'][] = $link;
		getRelations($node['id']);		
	}
	}
}


// Her lukkes forbindelsen til databasen eller "det huskede" slettes fra hukommelsen
mysql_free_result($result);

return $tree;
}



	function getTerm($id){
$termQ = mysql_query("SELECT Term FROM `sct2_description` WHERE conceptId ='$id' AND typeId=900000000000003001 AND active=1 LIMIT 1;")or die(mysql_error());
	while ($row1 = mysql_fetch_array($termQ)){ 
   $term = $row1['Term'];   
} 
	return $term;
	}


function multi_in_array($value, $array) 
{ 
    foreach ($array AS $item) 
    { 
        if (!is_array($item)) 
        { 
            if ($item == $value) 
            { 
                return true; 
            } 
            continue; 
        } 

        if (in_array($value, $item)) 
        { 
            return true; 
        } 
        else if (multi_in_array($value, $item)) 
        { 
            return true; 
        } 
    } 
    return false; 
} 


 	function createNode($row){
		$node=  array ( 
    	'id' => $row['supertypeId'],
		'term' => $row['Term'], 
    	'group' => '1');
	return $node;
	}
	
	function createLink($source, $target){
		$link=  array ( 
    	'sourceId' => $source,
		'targetId' => $target['supertypeId'], 
    	'linkName' => '1');
	return $link;
	}



	
/*echo("PHPARRAY: ");
	 echo "<pre>";
print_r($array);
echo "</pre>";
	
	 echo "<pre>";
print_r($value);
echo "</pre>";*/
	
	
?> 



