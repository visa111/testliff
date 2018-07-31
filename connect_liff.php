<?php
   $accessToken = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";

	  //$arrayPostData['to'] = $id;
      $arrayPostData['view']['type'] = "full";
      $arrayPostData['view']['url'] = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";


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

