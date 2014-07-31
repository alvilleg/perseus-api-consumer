<?php
  require_once('RequestCaller.php');

  $city_code = "76001";
  $city_name = $_GET["city"];
  $address = $_GET["address"];
  //

  $api_key = 'ff80808143fdfc620143fdfdaea00001';//'ff8080814065db570140b75fcfac0001';
  $user='test-user2';
  $server_url = 'http://perseus.bgx.me' ;// 'http://localhost:8071'; //
  $zoning_api_url =   $server_url."/action/zoning"; //

  $req_caller = new RequestCaller();
  $req_data =  'user='.$user.'&apiKey='.$api_key.'&cityCode='.$city_code.'&addresses='.
  urlencode ($req_caller->json_encode_ex($data));
  //
  $data = array();
  $data[0] = array
        (
          'extId'=>'',
          'address' => $address,
          'cityName'=> strtoupper($city_name)
        );

  $req_data =  'user='.$user.'&apiKey='.$api_key.'&cityCode='.$city_code.'&addresses='.
  urlencode ($req_caller->json_encode_ex($data));

  $result = $req_caller->doPost($zoning_api_url,$req_data);
  echo json_encode($result);
  /**
    3.45212,"lng":-76.52893

  ***/
?>
