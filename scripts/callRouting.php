<?php
	require_once('RequestCaller.php');
	//
	$server_url = 'http://localhost:8071'; //'http://perseus.bgx.me' ;//
	$zoningApiUrl =   $server_url."/action/zoning"; // 
	$routingApiURL =   $server_url."/action/route/route.jsp" ; //
	//
	$viewRouteUrl = $server_url."/action/route/viewPlan.jsp"; 
	$qryRouteUrl = $server_url."/action/route/qryRoute.jsp"; 
	//
	$apiKey = 'ff8080814065db570140b75fcfac0001';
	$user='test-user2';
	$cityCode='76001';
	//	
	$cnt = $_POST['total'];
	//
	$data = array();
	$data_cnt = 0;
	for($index =0;$index<$cnt;$index++){
		
		if($_POST['cb_'.$index]){
			$data[$data_cnt] = array
						(
							'extId' => $_POST['extId_'.$index],
							'address' => $_POST['address_'.$index]
						);
			$data_cnt++;
		}
		
	}
	// Call the geocoding service for all the points
	$req_caller = new RequestCaller();
	$req_data =  'user='.$user.'&apiKey='.$apiKey.'&cityCode='.$cityCode.'&addresses='.
	urlencode ($req_caller->json_encode_ex($data)).'&zoneType=M';
	echo 'Last error'.json_last_error(); 
	//
	echo "<a href=".$zoningApiUrl.'?'.$req_data." >Zoning</a><br>";
	$result = $req_caller->doPost($zoningApiUrl,$req_data);
	/** NEW Resources **/
	$resources = array();
	$resCnt = $_POST['resTotal'];
	$res_cnt = 0;
	for($index = 0; $index<$resCnt ; $index++){
		if($_POST['cb_res_'.$index]){
			$resources[$res_cnt] = array
						(
							'id' => $_POST['id_'.$index],
							'req' => array ( intval($_POST['req_'.$index]), 
							                 intval($_POST['req_'.$index])
							    			),
							 'fixedCost' => floatVal($_POST['fixedCost_'.$index]),
							 'varCost' => floatVal($_POST['varCost_'.$index])
						);
			$res_cnt++;
		}
	}
	/*************************/
	
	echo "<h2>Geocoded points</h2>";
	echo '<table  border="1">';
	echo '<th>Id</th>';
	echo '<th>Id</th>';
	echo '<th>Address</th>';
	echo '<th>Lat</th>';
	echo '<th>Lng</th>';
	echo '<th>Zone</th>';
	echo '<th>Zone name</th>';
	//
	$points = array();
	$pntCnt = 0;
	foreach( $result as $point){
		if($point['lat']){
		echo '<tr>';
		echo '<td>'.($pntCnt+1).'</td>';
		echo '<td>'.$point['Id'].'</td>';
		echo '<td>'.$point['address'].'</td>';
		echo '<td>'.$point['lat'].'</td>';
		echo '<td>'.$point['lng'].'</td>';
		echo '<td>'.$point['zoneId'].'</td>';
		echo '<td>'.$point['zoneName'].'</td>';
		echo '</tr>';
		//
		$points[$pntCnt] =  array('id'  => $point['Id'],
  								  'url' => 'http://google.com',
								  'desc' => $point['Id']." ".$point['address'],
								  'address' => $point['address'],
								  'lng' => $point['lng'],
                                  'lat' =>$point['lat'],
              					  'et'=> '8:00',
								  'lt'=> '18:30',
                                  'st'=>10,
  								  'req'=> array(1,1)
       					);
       	$pntCnt++;
       	}else {
       		echo '<tr>';
			echo '<td>BAD</td>';
			echo '<td>'.$point['Id'].'</td>';
			echo '<td>'.$point['address'].'</td>';
			echo '<td>'.$point['normalizedAddress'].'</td>';
			
			echo '</tr>';
		}
	}
	echo '</table>';
	/// Prepare data for routing
	// ie: Vehícles
	
	//
	/**
	-76.511779990652
	3.47064383860261
	
	**/
	$opt_request = array('resources'=> $resources,
					'points'=> $points,
    				'iniLng' => -76.511779990652,
    				'iniLat' => 3.43064383860261, 
    				'initialTime' => '8:00' , 	//NEW Initial time for use the resource
    				'endTime'=>'18:30',       	//NEW End time for use the resourde at this time the resource should be free
    				'avgSpeed'=>40,				// NEW Average speed
    				"timeFlexPerc"=>0.1          // NEW Flexibility percentage in the time windows  
    				);
    //
    $route_data = 'user='.$user.'&apiKey='.$apiKey.'&cityCode='.$cityCode.'&data='.urlencode ($req_caller->json_encode_ex($opt_request));
    //
	echo "<br><a href='".$routingApiURL."?".$route_data."'>TEST</a>";
	//
	// Call the route service and take the response
	$route_result = $req_caller->doPost($routingApiURL,$route_data);
	//
	echo "<h2>Routing results</h2>";
	$viewRouteUrl = $viewRouteUrl."?cityCode=".$cityCode."&user=".$user."&apiKey=".$apiKey."&plan_id=".$route_result['id'];
	echo "<br><a href='".$viewRouteUrl."'.>Ver ruta</a>";
	echo "<iframe  src='".$viewRouteUrl."' width='900' height='700'></iframe>";
	/// Check the status of the search every 20 seconds
	$status = '';
	do{
		$qryRouteParams = "cityCode=".$cityCode."&user=".$user."&apiKey=".$apiKey."&plan_id=".$route_result['id'];
		$qryRouteUrl = $server_url."/action/route/qryRoute.jsp";
		$route_details_result = $req_caller->doPost($qryRouteUrl,$qryRouteParams);
	
		$status = $route_details_result['status'];
		echo $status."<br>";
		sleep(20);
	}while($status == 'NF');
	
	/// The search is over, so read the result
	echo 'Route result';
	foreach($route_details_result as $route){
		echo '<h2>Route id: '.$route['routeId'].' Cost: '.$route['cost']. 
				 ' Used Capacity: '.$route['usedCapacity']." (".$route['usedCapacityP']."%) " ."</h2>";;
		foreach($route['points'] as $routePoint){
			echo 'Id. '.$routePoint['id'].' Seq: '.$routePoint['seq'].' Desc: '.$routePoint['desc'] . 
				 ' Url: '.$routePoint['url']." Estimated arrival time:". $routePoint['arrivalTime'] . "<br>";
		}
	}
	///
	echo "<br><br>";
	print_r($route_details_result);
?>
