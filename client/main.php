<?php
include('header.php');

if($_SESSION['user'])
{
?>


<script>
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}
window.onload = timedRefresh(60000);
  </script>







<?php
include('mainscript.php');
?>




<form name="ReportForm1" method="post" action="#">

    <div class="row">
        <div class="col-md-3">

<!-- datepicker -->

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  

  <script>
  $(document).ready(function () {
    var daysToAdd = 0;
    $("#txtFromDate").datepicker({
        onSelect: function (selected) {
            var dtMax = new Date(selected);
            dtMax.setDate(dtMax.getDate() + daysToAdd); 
            var dd = dtMax.getDate();
            var mm = dtMax.getMonth() + 1;
            var y = dtMax.getFullYear();
            var dtFormatted = mm + '/'+ dd + '/'+ y;
			//var dtFormatted = y + '-'+ mm + '-'+ dd;
            $("#txtToDate").datepicker("option", "minDate", dtFormatted);
        }
    });
    
    $("#txtToDate").datepicker({
        onSelect: function (selected) {
            var dtMax = new Date(selected);
            dtMax.setDate(dtMax.getDate() - daysToAdd); 
            var dd = dtMax.getDate();
            var mm = dtMax.getMonth() + 1;
            var y = dtMax.getFullYear();
            var dtFormatted = mm + '/'+ dd + '/'+ y;
			//var dtFormatted = y + '-'+ mm + '-'+ dd;
            $("#txtFromDate").datepicker("option", "maxDate", dtFormatted)
        }
    });
});
  </script>


<!-- datepicker -->

    

            From Date: <input type="text" class="form-control" id="txtFromDate" name="date1" AUTOCOMPLETE="OFF" placeholder="Input From Date"> 
        </div>
        <div class="col-md-3">
            To Date: <input type="text" class="form-control" id="txtToDate" name="date2" AUTOCOMPLETE="OFF" placeholder="Input To Date">
        </div>
    </div>

    <div class="row">   
         <div class="col-md-3">
            Country: <select name="country" class="form-control">
		    <option value="">== All Country ==</option>
			<option value="Thailand">Thailand</option>
			<option value="Indonesia">Indonesia</option>
			<option value="Malaysia">Malaysia</option>
			<option value="Philippines">Philippines</option>
			<option value="Singapore">Singapore</option>
			<option value="New Zealand">New Zealand</option>
			<option value="Australia">Australia</option>
		</select>
 
        </div>
        <div class="col-md-1 align-self-end"><br>
            <button name="Submit" id="Submit" type="Submit" class="form-control btn btn-primary" value="Submit">Submit</button>
        </div>
    </div>

    <div class="row">   
        <div class="col-md-12">
			<?php 	
		
			if($date1=="%"){
			$showdate1="All";
			}else{
			$showdate1=$date1;
			}


			if($country=="%"){
			$showcountry="All";
			}else{
			$showcountry=$country;
			}

			echo "<br><b>From Date:</b> $showdate1 To Date: $date2 (YYYY-MM-DD),  <b>Country:</b> $showcountry <br><br>"; 
			
            ?>
        </div>
    </div>
</form>



<div class="row">
  <div class="col-md-3">
    <div class="card bg-primary text-white">
        <div class="card-body row text-right">
            <div class="col-4 text-left">
                <span class="fa fa-list fa-2x"></span>
            </div>
            <div class="col-8">
                <h1><?php echo $Num_Rows_incomming; ?></h1>
                <h5 class="card-title text-right">Incomming Tickets</h5>
            </div>           
      </div>
    </div>
    <div class="card bg-success text-white">
      <div class="card-body row text-right">

            <div class="col-4 text-left">
                <span class="fa fa-check-square fa-2x"></span>
            </div>
            <div class="col-8">
                <h1><?php echo $Num_Rows_closed; ?></h1>
                <h5 class="card-title text-right">Closed Tickets</h5>
            </div> 
      </div>
    </div>
  </div>

    <div class="col-md-3" >
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-2 text-left">
                        <span class="fa fa-pie-chart fa-2x"></span>
                    </div>

                    <div class="col-10 text-right" >
                        <h1><?php $Num_pending=$Num_Rows_incomming-$Num_Rows_closed; echo $Num_pending; ?></h1>
                        <h5 class="card-title text-right">&nbsp;&nbsp;Pending By Status</h5>
                    </div> 
                </div>
            </div>
            <div class="card-body text-center" >
                <div id="donutchart" ></div>
            </div>
        </div>
  </div>


    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-2 text-left">
                        <span class="fa fa-pie-chart fa-2x"></span>
                    </div>

                    <div class="col-10 text-right">
                        <h1><?php echo $Num_pending; ?></h1>
                        <h5 class="card-title text-right">Pending By Priority</h5>
                    </div> 
                </div>
            </div>
            <div class="card-body text-center">
                <div id="donutchart_1"></div>
            </div>
        </div>
  </div>


    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="row">
                    <div class="col-2 text-left">
                        <span class="fa fa-pie-chart fa-2x"></span>
                    </div>

                    <div class="col-10 text-right">
                        <h1><?php echo $Num_pending; ?></h1>
                        <h5 class="card-title text-right">Pending By Department</h5>
                    </div> 
                </div>
            </div>
            <div class="card-body text-center">
                <div id="donutchart_2"></div>
            </div>
        </div>
  </div>

</div>

<br>

<div class="row">
  <div class="col-md-6">
      <div class="card">
            <div class="card-header">
                <h5 class="card-title text-left">Pending By Country</h5>
                <div id="columnchart_material_country" ></div>

            </div>
        </div>
    </div>

  <div class="col-md-6">
      <div class="card">
            <div class="card-header">
                <h5 class="card-title text-left">Top 5 Topic Chart</h5>
                <div id="barchart_values" ></div>

            </div>
        </div>
    </div>
</div>



<br>

<div class="row">
  <div class="col-md-12">
      <div class="card">
            <div class="card-header">
                <h5 class="card-title text-left">Trend Chart <?php echo $Year1;?></h5>
                <div id="curve_chart"></div>

            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
  <div class="col-md-6">
      <div class="card">
            <div class="card-header">
                <h5 class="card-title text-left">Region Asia GeoCharts</h5>
                <div id="regions_div"></div>

            </div>
        </div>
    </div>

  <div class="col-md-6">
      <div class="card">
            <div class="card-header">
                <h5 class="card-title text-left">Thailand GeoCharts</h5>
                <div id="regions_thai"></div>

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
