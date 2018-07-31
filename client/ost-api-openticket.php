<?php
#!/usr/bin/php -q
#
# Configuration: Enter the url and key. That is it.
#  url => URL to api/task/cron e.g #  http://yourdomain.com/support/api/tickets.json
#  key => API's Key (see admin panel on how to generate a key)
#  $data add custom required fields to the array.
#
#  Originally authored by jared@osTicket.com
#  Modified by ntozier@osTicket / tmib.net



$useropen=$_POST['useropen'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$select_topic=$_POST['select_topic'];
$subject=$_POST['subject'];
$message=$_POST['message'];

$AssetNumber=$_POST['AssetNumber'];

echo "$useropen : $email : $phone : $select_topic : $subject : $message";




// If 1, display things to debug.
$debug="0";

// You must configure the url and key in the array below.

$config = array(
        //'url'=>'http://127.0.0.1:8080/osTicket/upload/api/http.php/tickets.json',  // URL to site.tld/api/tickets.json
		'url'=>'http://13.250.151.174/itsm/upload/api/http.php/tickets.json',  // URL to site.tld/api/tickets.json

		//'key'=>'D1B7EABC38D658881CBA523F2CFC13F8'  // API Key goes here
		'key'=>'176BA99B5E94CE7E24A2C4D11AE81791'
);
# NOTE: some people have reported having to use "http://your.domain.tld/api/http.php/tickets.json" instead.

if($config['url'] === 'http://your.domain.tld/api/tickets.json') {
  echo "<p style=\"color:red;\"><b>Error: No URL</b><br>You have not configured this script with your URL!</p>";
  echo "Please edit this file ".__FILE__." and add your URL at line 18.</p>";
  die();  
}		
if(IsNullOrEmptyString($config['key']) || ($config['key'] === 'PUTyourAPIkeyHERE'))  {
  echo "<p style=\"color:red;\"><b>Error: No API Key</b><br>You have not configured this script with an API Key!</p>";
  echo "<p>Please log into osticket as an admin and navigate to: Admin panel -> Manage -> Api Keys then add a new API Key.<br>";
  echo "Once you have your key edit this file ".__FILE__." and add the key at line 19.</p>";
  die();
}

//$jsonfile = "http://127.0.0.1:8080/osTicket/upload/api/tickets.json";
//$jsondata = file_get_contents($jsonfile);
//$json = json_decode($jsondata, true);

//print_r($json['subject']);
//$json_name=$v[0];

//$json_subject=$json['subject'];
		
# Fill in the data for the new ticket, this will likely come from $_POST.
# NOTE: your variable names in osT are case sensiTive. 
# So when adding custom lists or fields make sure you use the same case
# For examples on how to do that see Agency and Site below.
$data = array(
    'name'      =>      $useropen,  // from name aka User/Client Name
    'email'     =>      $email,  // from email aka User/Client Email
	'phone' 	=>		$phone,  // phone number aka User/Client Phone Number
    'subject'   =>      $subject,  // test subject, aka Issue Summary
    'message'   =>      $message,  // test ticket body, aka Issue Details.
    'ip'        =>      $_SERVER['REMOTE_ADDR'], // Should be IP address of the machine thats trying to open the ticket.
	'topicId'   =>      $select_topic, // the help Topic that you want to use for the ticket 
	'AssetNumber' =>	$AssetNumber,
	//'Agency'  =>		'58', //this is an example of a custom list entry. This should be the number of the entry.
	//'Site'	=>		'Bermuda'; // this is an example of a custom text field.  You can push anything into here you want.	
    //'attachments' => array(),
	/*'attachments' =>  array(
                array(
					// BUGFIX: there was a semi-colon instead of comma after base64
                    'attachment.'.$info => 'data:'.$type.';base64,' . base64_encode(file_get_contents($attachment)),

                )
            ),*/
	 'AddRegions'	=> 'Asia',
     'AddCountry'	=> 'Thailand'
);

# more fields are available and are documented at:
# https://github.com/osTicket/osTicket-1.8/blob/develop/setup/doc/api/tickets.md

if($debug=='1') {
  print_r($data);
 // die();
}

# Add in attachments here if necessary
# Note: there is something with this wrong with the file attachment here it does not work.

/*
$data['attachments'][] =


array('file.txt' =>
        'data:text/plain;base64;'
            .base64_encode(file_get_contents('./file.txt')));  // replace ./file.txt with /path/to/your/test/filename.txt
*/ 





#pre-checks
function_exists('curl_version') or die('CURL support required');
function_exists('json_encode') or die('JSON support required');

#set timeout
set_time_limit(30);

#curl post
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $config['url']);
//curl_setopt($ch, CURLOPT_PORT, 8080);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//curl_setopt($ch, CURLOPT_POSTFIELDS, $config['url']);
curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.8');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result=curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($code != 201)
    die('Unable to create ticket: '.$result.$code);

echo "Ticket Number : $result "; //Ticket Other Format 

$ticket_id = (int) $result;


# Continue onward here if necessary. $ticket_id has the ID number of the
# newly-created ticket

$ticket_id=sprintf("%08d",$ticket_id);
//echo "ticket_id=#$ticket_id"; //Ticket Format Number Only

function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}
?>
