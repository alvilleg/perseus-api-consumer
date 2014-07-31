<?php
	//Database db = new Database();
	//DBStatement dbStm = new DBStatement("Select event_id from ps.SeasonEvent");
	//
	/*** db hostname ***/
	$hostname = 'localhost';

	/*** db username ***/
	$username = 'perseus_user';

	/*** db password ***/
	$password = '123';

	/*
	foreach(PDO::getAvailableDrivers() as $driver) {
    	echo $driver.'<br />';
    }
    */

	try {
		//$db = new PDO("mysql:host=$hostname;dbname=ps", $username, $password);
		$db = new PDO("pgsql:dbname=perseus;host=localhost", $username, $password );
    	$sql = "SELECT external_id,name,address,zone_id FROM t_site where city_id=1077 and zone_id is null order by external_id limit 200";
    	// Where city_id=1077 and geodata is not null limit 100
    	echo "<h2> Routing </h2>";
    	echo "<form id='fm_1' action='callRouting.php' method='POST'>";
    	echo '<input type="submit" name="Geocode" value="Geocode & Route"></input>';
    	/**
    	 * Resources
    	 */
    	$resources = array(
						array('id'=>'CLU 4000 KG','req'=>array(4000,4000),'fixedCost'=>130.0,'varCost'=>0.0013),
						array('id'=>'VCQ 2500 KG','req'=>array(2500,2500),'fixedCost'=>100.0,'varCost'=>0.0010),
						array('id'=>'VCF 3000 KG','req'=>array(3000,3000),'fixedCost'=>120.0,'varCost'=>0.0011),
						array('id'=>'SPL 7000 KG','req'=>array(7000,7000),'fixedCost'=>160.0,'varCost'=>0.0015),
						array('id'=>'VCQ 5000 KG','req'=>array(5000,5000),'fixedCost'=>140.0,'varCost'=>0.0014)
						);
		$resIndex = 0;
		echo '<h2>Resources</h2>';
    	echo '<table border="1">';
    	echo '<th>Use</th>';
    	echo '<th>Id</th>';
    	echo '<th>Capacidad</th>';

    	foreach($resources as $res){
    		echo '<tr>';
    		echo "<td><input type='checkbox' name='cb_res_".$resIndex."' value='".$res['id']."' checked></input></td>";
    		echo "<td>".$res['id']."</td>";
        	echo '<td>'.$res['req'][0]."</td>";
        	echo '<td>'.$res['fixedCost']."</td>";
        	echo '<td>'.$res['varCost']."</td>";

        	echo "<input type='hidden' name='id_".$resIndex."' value='".$res['id']."' ></input>";
        	echo "<input type='hidden' name='req_".$resIndex."' value='".$res['req'][0]."' ></input>";
        	echo "<input type='hidden' name='fixedCost_".$resIndex."' value='".$res['fixedCost']."' ></input>";
        	echo "<input type='hidden' name='varCost_".$resIndex."' value='".$res['varCost']."' ></input>";
    		echo '<tr>';
    		$resIndex++;
    	}
    	echo '</table >';
    	echo "<input type='hidden' name='resTotal' value='".$resIndex."' ></input>";
    	/*** Points ***/
    	echo '<h2>Points</h2>';
    	$index=0;
    	echo '<table border="1">';
    	echo "<input type='hidden' name='total' value='200' ></input>";
    	foreach( $db->query($sql) as $row){
    		echo '<tr>';
    		echo '<td>'.($index+1).'</td>';
        	echo "<td><input type='checkbox' name='cb_".$index."' value='".$row['external_id']."' checked></input></td>";
        	echo "<td>".$row['external_id']."</td>";
        	echo '<td>'.$row['address']."</td>";
        	echo '</tr>';

        	echo "<input type='hidden' name='extId_".$index."' value='".$row['external_id']."' ></input>";
        	echo "<input type='hidden' name='address_".$index."' value='".$row['address']."' ></input>";

        	$index++;
		}
		echo '</table>';

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
