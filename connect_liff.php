<?php
   $accessToken = "eXfc2yorldMU6wdiaqrjWdaBkZKyfVIWk1rpGzms5BFj+Z8agphZ5tliqnt7TunqJbIOjvYK/KiM0Yrzaaqd4A53t95aNBpnRVW2Y0rC4jplDrEVuu3GXoOF4u3QlAl8w4yPcp2yce/t3saO44Ea3gdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";

	  //$arrayPostData['to'] = $id;
      $arrayPostData['view'][0]['type'] = "full";
      $arrayPostData['view'][0]['url'] = "https://testliffnow.herokuapp.com/";


	  pushMsg($arrayHeader,$arrayPostData);


   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/liff/v1/apps";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);


	if(curl_error($ch)) 
	{ 
           echo 'error:' . curl_error($ch); 
	} 
	else { 
	$result_ = json_decode($result, true); 
	   //echo "status : ".$result_['status']; echo "message : ". $result_['message'];
	   echo $result ;
        } 
	curl_close( $ch );   
}

   exit;
?>

