<?php
	//Database db = new Database();
	//DBStatement dbStm = new DBStatement("Select event_id from ps.SeasonEvent");
	//
	/*** mysql hostname ***/
	$hostname = 'localhost';

	/*** mysql username ***/
	$username = 'perseus_user';

	/*** mysql password ***/
	$password = '123';

	foreach(PDO::getAvailableDrivers() as $driver) {
    	echo $driver.'<br />';
    }
	try {
		//$db = new PDO("mysql:host=$hostname;dbname=ps", $username, $password);
		$db = new PDO("pgsql:dbname=perseus;host=localhost", $username, $password );
    	echo "PDO connection object created";
    	$sql = "SELECT external_id,name,address,zone_id FROM t_site where city_id=1077 and zone_id is not null limit 70";   
    	// Where city_id=1077 and geodata is not null limit 100
    	echo "<form id='fm_1' action='callRouting.php' method='POST'>";
    	$index=0;
    	echo '<table border="1">'
    	foreach( $db->query($sql) as $row){ 
    		echo '<tr>' 
        	echo "<td><input type='checkbox' name='cb_".$index."' value='".$row['external_id']."' checked></td>";
        	echo "<td>".$row['external_id']."</td>";
        	echo '<td>'.$row['address']."</td>";
        	echo "<input type='hidden' name='extId_".$index."' value='".$row['external_id']."' ></type>";
        	echo "<input type='hidden' name='address_".$index."' value='".$row['address']."' ></type>";
        	echo '</input><br/>';
        	echo '</tr>';
        	$index++;
		}
		echo '<table>'
		echo "<input type='hidden' name='total' value='".$index."' ></type>"; 
		echo '<input type="submit" name="Geocode" value="Geocode"></input>';
		echo "</form>";
    }
	catch(PDOException $e)
    {
    	echo $e->getMessage();
    }
	
	function callGeocoding(){
	}
	
	function callRouting(){
	}
	
	function processResult(){
	}
	
?>