<?php
include('header.php');
if($_SESSION['user'])
{

   include('db_connect.php');

    error_reporting(~E_NOTICE);

    $username = $_SESSION['user'];

    $sqluser="select email, phone, phone_ext from ost_staff where username='$username'";
    $result = mysqli_query($link,$sqluser);
    $row = mysqli_fetch_array($result);

    //echo "$username $row[0] , $row[1] , $row[2]";




?>


    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8 mx-auto">

                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="mb-0">New ticket</h3>
                            </div>

                            <div class="card-body">
                                <form class="was-validated" name="myForm" action="open_result.php" method="post">
                                    <label class="my-1 mr-2 text-danger" for="SelectType">
                                       
                                    </label>
                                    <br>






<?php
$a_json = array();
$a_json_row = array();
$sql_user="SELECT ost_user.id, ost_user.name, ost_user_email.address, ost_user__cdata.phone FROM `ost_user` INNER JOIN ost_user_email ON ost_user.default_email_id = ost_user_email.id INNER JOIN `ost_user__cdata` ON ost_user.id = ost_user__cdata.user_id";
$result_user = mysqli_query($link,$sql_user);

while ($row_user = mysqli_fetch_array($result_user))
{
$user_id=htmlentities(stripslashes($row_user['id']));
$name=htmlentities(stripslashes($row_user['name']));
$email=htmlentities(stripslashes($row_user['address']));
$phone=htmlentities(stripslashes($row_user['phone']));


//$rows[] = $row_user;
$a_json_row["id"] = $user_id;
$a_json_row["value"] = $email;
$a_json_row["label"] = $name;
$a_json_row["phone"] = $phone;
array_push($a_json, $a_json_row);
}

$jsondata = json_encode($a_json);
?>





<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/start/jquery-ui.min.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>


    <label class="my-1 mr-2" for="date">Select User</label>
		<input class="form-control" id="autocomplete2" type="text" name="useropen" placeholder="e.g. Smith" required>

     <label class="my-1 mr-2" for="date">Email</label>
		<input class="form-control" id="autocomplete2-value" type="text" name="email" placeholder="e.g. sample@email.com" required>

     <label class="my-1 mr-2" for="date">phone</label>
		<input class="form-control" id="autocomplete3-value" type="text" name="phone" placeholder="e.g. 012345678" required>

	<script>
		/*
		 * jQuery UI Autocomplete: Using Label-Value Pairs
		 * https://salman-w.blogspot.com/2013/12/jquery-ui-autocomplete-examples.html
		 */
		var data = <?php echo $jsondata;?>;
		$(function() {
			$("#autocomplete1").autocomplete({
				source: data
			});
			$("#autocomplete2").autocomplete({
				source: data,
				focus: function(event, ui) {
					// prevent autocomplete from updating the textbox
					event.preventDefault();
					// manually update the textbox
					$(this).val(ui.item.label);
				},
				select: function(event, ui) {
					// prevent autocomplete from updating the textbox
					event.preventDefault();
					// manually update the textbox and hidden field
					$(this).val(ui.item.label);
					$("#autocomplete2-value").val(ui.item.value);
                    $("#autocomplete3-value").val(ui.item.phone);
				}
			});
		});
	</script>











                                    <label class="my-1 mr-2" for="SelectType">Topic</label>

                                    <select class="custom-select my-1 mr-sm-2" id="select_topic" name="select_topic" onchange="Selectdata_parent()" required>
                                        <option value="">-- Please Select --</option>
<?php
    $sqltopic="SELECT topic_id, topic_pid, topic FROM `ost_help_topic`WHERE isactive=1";
    $result_topic = mysqli_query($link,$sqltopic);
while ($row_topic = mysqli_fetch_array($result_topic))
{
    $topic_id = $row_topic["topic_id"];
    $topic_pid = $row_topic["topic_pid"];
    $topic = $row_topic["topic"];
    if(!$topic_pid){
    //echo "$topic_id : $topic_pid : $topic<br>";
?>
    <option value="<?php echo $topic_id;?>"><?php echo $topic;?></option>
<?php
    }else{
        $sqltopic_main="SELECT topic_id, topic_pid, topic FROM `ost_help_topic`WHERE topic_id='$topic_pid'";
        $result_topic_main = mysqli_query($link,$sqltopic_main);
        $row_main = mysqli_fetch_array($result_topic_main);
    //echo "$topic_id : $topic_pid : $row_main[2] / $topic<br>";
?>
    <option value="<?php echo $topic_id;?>"><?php echo "$row_main[2] / $topic";?></option>
<?php
    }
}
?>

                                    </select>





									<label class="my-1 mr-2" for="AssetNumber">Asset Number</label>
                                    <input class="form-control" id="AssetNumber" name="AssetNumber" placeholder="Input subject" type="text" required />

                                    <label class="my-1 mr-2" for="Refno">Subject</label>
                                    <input class="form-control" id="subject" name="subject" placeholder="Input subject" type="text" required />


                                    <label class="my-1 mr-2" for="Description">Description</label>
                                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                    <input class="form-control" id="createBy" name="createBy" type="hidden" value="<%=User.name%>" />
                                    <br>
                                    <button id="btnSave" name="Save" class="btn btn-primary" type="submit">Save</button>

                                </form>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




<?php
}else{

    echo "Authentication failed";

}
include('footer.php');
?>