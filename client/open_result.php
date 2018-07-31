<?php
include('header.php');
//if($_SESSION['user'])
//{

   //include('db_connect.php');

    //error_reporting(~E_NOTICE);

    //$username = $_SESSION['user'];

    //$sqluser="select email, phone, phone_ext from ost_staff where username='$username'";
    //$result = mysqli_query($link,$sqluser);
    //$row = mysqli_fetch_array($result);

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

                            <div class="card-body text-center">
<h2>
<?php
    include('ost-api-openticket.php');



	include('slack.php');
?>
</h2>

    </div>
        </div>
            </div>
                </div>
                    </div>
                        </div>
                            </div>



<?php
//}else{

//    echo "Authentication failed";

//}
include('footer.php');
?>
