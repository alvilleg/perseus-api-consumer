<?php
  require_once('RequestCaller.php');

  //$city_code = "76001";
  //$city_name = $_GET["city"];
  //$address = $_GET["address"];
  //

  //print_r($_POST);
  $api_key = 'ff80808143fdfc620143fdfdaea00001';//'ff8080814065db570140b75fcfac0001';
  $user='test-user2';
  $server_url = 'http://pbi.tracksalesonline.com/gda/getdata.jsp?' ;// 'http://localhost:8071'; //
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

  // input=gda&cda=conftabla&id=13&rep=TSOL&&Parametros='.urlencode ($Parametros)
  $url = $server_url.'idsesion=ebfbe46d05a111da1285f45b73d85fb9cb14c01900bac758e7d25a85702c4c33b8abcadd0b50f7e0056d188085099813421f85e6dff9b4309b71d718f2ea4ffe053c8e32e03ccf6323f66cd27d80c9f8';

  $result = $req_caller->doGet($url, "");

	echo $result;
  //*/
  /**
    3.45212,"lng":-76.52893

  ***/
?>
