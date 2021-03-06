<?php

class RequestCaller{

	function __construct(){
    }

	// JSON helper 172.16.0.2
	function json_encode_ex($data) {
  		return json_encode($data, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
	}
		
	// Rest helper
	//  'Accept: application/json',
	//    'Content-Type: application/json'

	/**
	 * Returns a JSON object with the response 
	 */

	function executeRest($url, $method,$data = "") {
		//
  		$headers = array(
  		);
  		$handle = curl_init(); // $url
  		curl_setopt($handle, CURLOPT_URL, 'http://pbi.tracksalesonline.com/gda/getdata.jsp?idsesion=ebfbe46d05a111da1285f45b73d85fb9cb14c01900bac758e7d25a85702c4c33b8abcadd0b50f7e0056d188085099813421f85e6dff9b4309b71d718f2ea4ffe053c8e32e03ccf6323f66cd27d80c9f8');
  		//curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
  		curl_setopt($handle, CURLOPT_VERBOSE, true);
  		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  		//curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
  		//curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
  		//curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
  		//curl_setopt($handle, CURLOPT_TIMEOUT, 360);

  		echo 'URL:'.$url.'
  		';
  		echo 'DATA:'.$data.'
  		';

  		switch($method)
  		{
    		case 'GET':
    			break;

    		case 'POST':
    			curl_setopt($handle, CURLOPT_POST, true);
    			curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    			break;

    		case 'PUT':
    			curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
    			curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
    			break;

    		case 'DELETE':
    			curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
    			break;
  		}

  		$response = curl_exec($handle);
  		$status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
  		
  		$respObj = json_decode(utf8_encode($response),true);

  		echo $response;
  		echo $status;

  		curl_close($handle);

  		
  		echo 'status::'.$status;


  		return $respObj;
	}
	
	/*
	 * Execute the POST method	
	 */	
	function doPost($url,$data = ""){		
		return $this->executeRest($url,'POST',$data);
	}


	/*
	 * Execute the POST method	
	 */	
	function doGet($url,$data = ""){
		return $this->executeRest($url,'GET',$data);
	}


}
?>