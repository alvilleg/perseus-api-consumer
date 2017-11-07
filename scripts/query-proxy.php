<?php
  require_once('RequestCaller.php');

  //$city_code = "76001";
  //$city_name = $_GET["city"];
  //$address = $_GET["address"];
  //

  //print_r($_POST);
  $api_key = 'ff80808143fdfc620143fdfdaea00001';//'ff8080814065db570140b75fcfac0001';
  $user='test-user2';
  $server_url = 'https://portal.tracksalesonline.com/gda/getdata.jsp?' ;// 'http://localhost:8071'; //
  $zoning_api_url =   $server_url.""; //
  $input = $_POST['input'];
  $cda = $_POST['cda'];
  $id = $_POST['id'];
  $rep = $_POST['rep'];
  $output = $_POST['output'];
  $Parametros = $_POST['Parametros'];
  $idsesion = $_POST['idsesion'];
  $req_caller = new RequestCaller();

  $data = 'input='.$input.'&cda='.$cda.'&id='.$id.'&rep='.$rep.'&idsesion='.$idsesion.'&output='.$output.'&Parametros='.urlencode ($Parametros);

  
  $url = $server_url.$data;

  $result = $req_caller->doGet($url, "");

	echo $result;
  //*/
  /**
    3.45212,"lng":-76.52893

  ***/
?>
