
<style>
.city {
    float: left;
    margin: 5px;
    padding: 15px;
    max-width: 300px;
    height: 300px;
    border: 1px solid black;
} 



.panel-blue {
  border-color: #7363f0;
}
.panel-blue > .panel-heading {
  border-color: #7363f0;
  color: white;
  background-color: #7363f0;
}


.panel-green {
  border-color: #5cb85c;
}
.panel-green > .panel-heading {
  border-color: #5cb85c;
  color: white;
  background-color: #5cb85c;
}

</style>



    <!-- Bootstrap Core CSS -->
    <link href="./../../../../chart/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="./../../../../chart/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./../../../../chart/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="./../../../../chart/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./../../../../chart/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    [endif]-->







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





    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>





<?php
include('db_connect.php');




error_reporting(~E_NOTICE);

	$date1=$_POST['date1'];
	if($date1=="")
	{
		//$date1="%";
		$date1=date("Y-01-01");
		$Year1=date("Y");
		//echo "date1=$date1, Year=$Year1";
	}else{
        $condate=substr($date1,0,2);
        $conmonth=substr($date1,3,2);
        $conyear=substr($date1,6,4);
        $date1="$conyear-$condate-$conmonth";

		$Year1=$conyear;
	}


	$date2=$_POST['date2'];
	if($date2=="")
	{
		$date2=date("Y-m-d");
	}else{
        $condate=substr($date2,0,2);
        $conmonth=substr($date2,3,2);
        $conyear=substr($date2,6,4);
        $date2="$conyear-$condate-$conmonth";
	}


	$country=$_POST['country'];
	if($country=="")
	{
		$country="%";
	}



$sql_chart="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket_status` ON `ost_ticket_status`.`id`= `ost_ticket`.`status_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` where `ost_ticket_status`.`id`=1 and `ost_ticket`.`status_id`=1 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59' ";
$result = mysqli_query($link,$sql_chart);
$Num_Rows = mysqli_num_rows($result);


$sql_chart_pending="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket_status` ON `ost_ticket_status`.`id`= `ost_ticket`.`status_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` where `ost_ticket_status`.`id`=6 and `ost_ticket`.`status_id`=6 AND `ost_form_entry_values`.`field_id`=41 AND `ost_form_entry_values`.`value` LIKE '%$country%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_pending = mysqli_query($link,$sql_chart_pending);
$Num_Rows_pending = mysqli_num_rows($result_pending);



?>




<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'count'],
          ['Open',     <?php echo $Num_Rows ?>],
          ['Pending',      <?php echo $Num_Rows_pending ?>]

        ]);


        var options = {
          title: '',
          pieHole: 0.4,
		  backgroundColor: 'transparent',
	      pieSliceTextStyle: {
          //color: 'black',
          },
		  //legend: 'none'
		  legend:{position: 'bottom'},
		  chartArea:{left:10,top:0,width:'90%',height:'90%'},
		  colors: ['#c5b6e4','#9c86c9','#d0b4f6','#e1cff9']

        };
		

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>




<?php
$sql_chart_Low="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_Low = mysqli_query($link,$sql_chart_Low);
$Num_Rows_Low = mysqli_num_rows($result_Low);

$sql_chart_Low_6="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_Low_6 = mysqli_query($link,$sql_chart_Low_6);
$Num_Rows_Low_6 = mysqli_num_rows($result_Low_6);



$sql_chart_normal="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_normal = mysqli_query($link,$sql_chart_normal);
$Num_Rows_normal = mysqli_num_rows($result_normal);

$sql_chart_normal_6="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%'  and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_normal_6 = mysqli_query($link,$sql_chart_normal_6);
$Num_Rows_normal_6 = mysqli_num_rows($result_normal_6);



$sql_chart_high="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`field_id`=41 AND `ost_form_entry_values`.`value` LIKE '%$country%' and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_high = mysqli_query($link,$sql_chart_high);
$Num_Rows_high = mysqli_num_rows($result_high);

$sql_chart_high_6="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`field_id`=41 AND `ost_form_entry_values`.`value` LIKE '%$country%'  and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_high_6 = mysqli_query($link,$sql_chart_high_6);
$Num_Rows_high_6 = mysqli_num_rows($result_high_6);




$sql_chart_emergency="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_emergency = mysqli_query($link,$sql_chart_emergency);
$Num_Rows_emergency = mysqli_num_rows($result_emergency);

$sql_chart_emergency_6="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%'  and `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_emergency_6 = mysqli_query($link,$sql_chart_emergency_6);
$Num_Rows_emergency_6 = mysqli_num_rows($result_emergency_6);
?>




 <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Open', 'Pending', { role: 'annotation' }],
          ['Low',     <?php echo $Num_Rows_Low ?>,     <?php echo $Num_Rows_Low_6 ?>, ''],
          ['normal',      <?php echo $Num_Rows_normal ?>,      <?php echo $Num_Rows_normal_6 ?>, ''],
          ['high',      <?php echo $Num_Rows_high ?>,      <?php echo $Num_Rows_high_6 ?>, ''],
          ['emergency',      <?php echo $Num_Rows_emergency ?>,      <?php echo $Num_Rows_emergency_6 ?>, '']

        ]);

        var options = {
          chart: {
            title: 'Total Tickets By Priority',
            subtitle: '',
			isStacked: true,


          }

        };

		
      var options = {

        bar: { groupWidth: '75%' },
        isStacked: true,
		legend: { position: 'bottom', maxLines: 3 },
        colors: ['#FFA500', '#FF00FF'],

      };



        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>



<?php

$Num_Rows_Low_total=$Num_Rows_Low+$Num_Rows_Low_6;
$Num_Rows_normal_total=$Num_Rows_normal+$Num_Rows_normal_6;
$Num_Rows_high_total=$Num_Rows_high+$Num_Rows_high_6;
$Num_Rows_emergency_total=$Num_Rows_emergency+$Num_Rows_emergency_6;


?>


<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'count'],
          ['emergency',      <?php echo $Num_Rows_emergency_total ?>],
          ['high',      <?php echo $Num_Rows_high_total ?>],
          ['normal',      <?php echo $Num_Rows_normal_total ?>],
	      ['Low',     <?php echo $Num_Rows_Low_total ?>]
        ]);


        var options = {
          title: '',
          pieHole: 0.4,
		  backgroundColor: 'transparent',
		  //legend: 'none',
		  legend:{position: 'bottom'},	
          pieSliceTextStyle: {
            //color: 'black',
          },
		  colors: ['#706583', '#958ba5', '#bbb3ca', '#d6cce7'],
		  chartArea:{left:10,top:0,width:'90%',height:'90%'}
        };
		

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_1'));
        chart.draw(data, options);
      }
    </script>





<?php
$Dep1sql_chart="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6 or `ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`)and (`ost_ticket`.`dept_id`=1) AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and (`ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59')";
$Dep1result = mysqli_query($link, $Dep1sql_chart);
$Dep1Num_Rows = mysqli_num_rows($Dep1result);

$Dep2sql_chart="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6 or `ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`)and (`ost_ticket`.`dept_id`=2) AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and (`ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59')";
$Dep2result = mysqli_query($link, $Dep2sql_chart);
$Dep2Num_Rows = mysqli_num_rows($Dep2result);

$Dep3sql_chart="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6 or `ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`)and (`ost_ticket`.`dept_id`=3) AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' and (`ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59')";
$Dep3result = mysqli_query($link, $Dep3sql_chart);
$Dep3Num_Rows = mysqli_num_rows($Dep3result);

$Dep4sql_chart="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` WHERE (`ost_ticket`.`status_id` =6 or `ost_ticket`.`status_id` =1) and (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`)and (`ost_ticket`.`dept_id`=4) AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%'and (`ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59')";
$Dep4result = mysqli_query($link, $Dep4sql_chart);
$Dep4Num_Rows = mysqli_num_rows($Dep4result);
?>


<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Department', 'count'],
          ['Support',     <?php echo $Dep1Num_Rows ?>],
          ['Sales',      <?php echo $Dep2Num_Rows ?>],
          ['Maintenance',      <?php echo $Dep3Num_Rows ?>],
          ['Maketing',      <?php echo $Dep4Num_Rows ?>]
        ]);


        var options = {
          title: '',
          pieHole: 0.4,
		  backgroundColor: 'transparent',
		  //legend: 'none',
		  legend:{position: 'bottom'},	
          pieSliceTextStyle: {
            //color: 'black',
          },
		  chartArea:{left:10,top:0,width:'90%',height:'90%'},
		  colors: ['#6e78bd', '#8a92c9', '#a5acdb', '#b8bfeb'],
        };
		

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_2'));
        chart.draw(data, options);
      }
    </script>










<?php
$Dep1sql_chart_Low="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE  (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=1) and (`ost_ticket`.`dept_id`=1)";
$Dep1result_Low = mysqli_query($link, $Dep1sql_chart_Low);
$Dep1Num_Rows_Low = mysqli_num_rows($Dep1result_Low);

$Dep1sql_chart_normal="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=2) and (`ost_ticket`.`dept_id`=1)";
$Dep1result_normal = mysqli_query($link,$Dep1sql_chart_normal);
$Dep1Num_Rows_normal = mysqli_num_rows($Dep1result_normal);

$Dep1sql_chart_high="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE  (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=3) and (`ost_ticket`.`dept_id`=1)";
$Dep1result_high = mysqli_query($link,$Dep1sql_chart_high);
$Dep1Num_Rows_high = mysqli_num_rows($Dep1result_high);

$Dep1sql_chart_emergency="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE  (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=4) and (`ost_ticket`.`dept_id`=1)";
$Dep1result_emergency = mysqli_query($link,$Dep1sql_chart_emergency);
$Dep1Num_Rows_emergency = mysqli_num_rows($Dep1result_emergency);





$Dep2sql_chart_Low="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=1) and (`ost_ticket`.`dept_id`=2)";
$Dep2result_Low = mysqli_query($link,$Dep2sql_chart_Low);
$Dep2Num_Rows_Low = mysqli_num_rows($Dep2result_Low);

$Dep2sql_chart_normal="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=2) and (`ost_ticket`.`dept_id`=2)";
$Dep2result_normal = mysqli_query($link,$Dep2sql_chart_normal);
$Dep2Num_Rows_normal = mysqli_num_rows($Dep2result_normal);

$Dep2sql_chart_high="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=3) and (`ost_ticket`.`dept_id`=2)";
$Dep2result_high = mysqli_query($link,$Dep2sql_chart_high);
$Dep2Num_Rows_high = mysqli_num_rows($Dep2result_high);

$Dep2sql_chart_emergency="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE  (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=4) and (`ost_ticket`.`dept_id`=2)";
$Dep2result_emergency = mysqli_query($link,$Dep2sql_chart_emergency);
$Dep2Num_Rows_emergency = mysqli_num_rows($Dep2result_emergency);




$Dep3sql_chart_Low="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=1) and (`ost_ticket`.`dept_id`=3)";
$Dep3result_Low = mysqli_query($link,$Dep3sql_chart_Low);
$Dep3Num_Rows_Low = mysqli_num_rows($Dep3result_Low);

$Dep3sql_chart_normal="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE  (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=2) and (`ost_ticket`.`dept_id`=3)";
$Dep3result_normal = mysqli_query($link,$Dep3sql_chart_normal);
$Dep3Num_Rows_normal = mysqli_num_rows($Dep3result_normal);

$Dep3sql_chart_high="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=3) and (`ost_ticket`.`dept_id`=3)";
$Dep3result_high = mysqli_query($link,$Dep3sql_chart_high);
$Dep3Num_Rows_high = mysqli_num_rows($Dep3result_high);

$Dep3sql_chart_emergency="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=4) and (`ost_ticket`.`dept_id`=3)";
$Dep3result_emergency = mysqli_query($link,$Dep3sql_chart_emergency);
$Dep3Num_Rows_emergency = mysqli_num_rows($Dep3result_emergency);



$Dep4sql_chart_Low="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=1) and (`ost_ticket`.`dept_id`=4)";
$Dep4result_Low = mysqli_query($link,$Dep4sql_chart_Low);
$Dep4Num_Rows_Low = mysqli_num_rows($Dep4result_Low);

$Dep4sql_chart_normal="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=2) and (`ost_ticket`.`dept_id`=4)";
$Dep4result_normal = mysqli_query($link,$Dep4sql_chart_normal);
$Dep4Num_Rows_normal = mysqli_num_rows($Dep4result_normal);

$Dep4sql_chart_high="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=3) and (`ost_ticket`.`dept_id`=4)";
$Dep4result_high = mysqli_query($link,$Dep4sql_chart_high);
$Dep4Num_Rows_high = mysqli_num_rows($Dep4result_high);

$Dep4sql_chart_emergency="SELECT `ost_ticket`.`ticket_id`, `ost_ticket`.`status_id`, `ost_ticket__cdata`.`priority`, `ost_ticket`.`dept_id` FROM `ost_ticket` LEFT JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id` WHERE (`ost_ticket`.`ticket_id`=`ost_ticket__cdata`.`ticket_id`) and (`ost_ticket__cdata`.`priority`=4) and (`ost_ticket`.`dept_id`=4)";
$Dep4result_emergency = mysqli_query($link,$Dep4sql_chart_emergency);
$Dep4Num_Rows_emergency = mysqli_num_rows($Dep4result_emergency);
?>



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Department', 'Low', 'Normal', 'High', 'Emergency'],
          ['Support', <?php echo $Dep1Num_Rows_Low ?>, <?php echo $Dep1Num_Rows_normal ?>, <?php echo $Dep1Num_Rows_high ?>, <?php echo $Dep1Num_Rows_emergency ?>],
          ['Sales', <?php echo $Dep2Num_Rows_Low ?>, <?php echo $Dep2Num_Rows_normal ?>, <?php echo $Dep2Num_Rows_high ?>, <?php echo $Dep2Num_Rows_emergency ?>],
          ['Maintenance', <?php echo $Dep3Num_Rows_Low ?>, <?php echo $Dep3Num_Rows_normal ?>, <?php echo $Dep3Num_Rows_high ?>, <?php echo $Dep3Num_Rows_emergency ?>],
          ['Maketing', <?php echo $Dep4Num_Rows_Low ?>, <?php echo $Dep4Num_Rows_normal ?>, <?php echo $Dep4Num_Rows_high ?>, <?php echo $Dep4Num_Rows_emergency ?>]
        ]);

        var options = {
          chart: {
            title: 'Total Tickets by Department(All Status)',
            subtitle: '',
			isStacked: true,
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>









<form name="ReportForm1" method="post" action="#">


<center>
<table border="0" width="100%">
<tbody>
<tr><td>




                    <h1>Dashboard</h1>
                
                <!-- /.col-lg-12 -->
				From Date: <input type="text" id="txtFromDate" name="date1" AUTOCOMPLETE="OFF"> To Date: <input type="text" id="txtToDate" name="date2" AUTOCOMPLETE="OFF">
			
				Country: <select name="country">
							<option value="">== All Country ==</option>
							<option value="Thailand">Thailand</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Philippines">Philippines</option>
							<option value="Singapore">Singapore</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Australia">Australia</option>
						</select>

				<input name="Submit" type="submit" value="Submit"><br><br>
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

			echo "<b>From Date:</b> $showdate1 To Date: $date2 (YYYY-MM-DD),  <b>Country:</b> $showcountry <br><br>"; 
			
			?>
</form>
            
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-3 col-md-6">
                    <div class="panel-blue">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-2x"></i>
                                </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">

<?php
$sql_chart_incomming = "SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id`  WHERE `ost_ticket`.`created` BETWEEN '$date1 00:00:00.000000' AND '$date2 23:59:59' AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' ";
$result_incomming = mysqli_query($link,$sql_chart_incomming);
$Num_Rows_incomming = mysqli_num_rows($result_incomming);									


echo $Num_Rows_incomming;
?>
									
								        </div>
                                            <div>Incomming Tickets</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check-square fa-2x"></i>
                                </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
<?php
$sql_chart_closed = "SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id`  WHERE `ost_ticket`.`status_id` = 3 AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00.000000' AND '$date2 23:59:59' AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' ";
$result_closed = mysqli_query($link,$sql_chart_closed);
$Num_Rows_closed = mysqli_num_rows($result_closed);									


echo $Num_Rows_closed;
?>									
									
							            </div>
                                            <div>Closed Tickets</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-pie-chart fa-2x"></i>
                                </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
	<?php 
	$Numpending=$Num_Rows+$Num_Rows_pending;
	echo $Numpending ?>								
									
									
									    </div>
                                            <div>Pending By Status</div>
                                    </div>
                                </div>
                            </div>
                                <div class="panel-footer">
                                    <div id="donutchart" style="width: 100%; "></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-pie-chart fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
<?php 
$Numpending_priority_total=$Num_Rows_Low_total+$Num_Rows_normal_total+$Num_Rows_high_total+$Num_Rows_emergency_total;

echo $Numpending_priority_total;
?>									
									
									</div>
                                    <div>Pending By Priority</div>
                                </div>
                            </div>
                        </div>

                            <div class="panel-footer">
<div id="donutchart_1" style="width: 100%; "></div>

                            </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-pie-chart fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
<?php 
$Numpending_Dep=$Dep1Num_Rows+$Dep2Num_Rows+$Dep3Num_Rows+$Dep4Num_Rows;

echo $Numpending_Dep;
?>		
									</div>
                                    <div>Pending By Department</div>
                                </div>
                            </div>
                        </div>
                        
                            <div class="panel-footer">
<div id="donutchart_2" style="width: 100%; "></div>

								
								<div class="clearfix"></div>
                            </div>
                    
                    </div>
                </div>

				

                </div>
            </div>
            </div>




</td></tr>



<?php

if($country=="%" or $country=="Thailand")
{
//Thai
$sql_chart_thai_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%Thailand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_thai_1 = mysqli_query($link,$sql_chart_thai_1);
$Num_Rows_thai_1 = mysqli_num_rows($result_thai_1);

$sql_chart_thai_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%Thailand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_thai_2 = mysqli_query($link,$sql_chart_thai_2);
$Num_Rows_thai_2 = mysqli_num_rows($result_thai_2);

$sql_chart_thai_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%Thailand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_thai_3 = mysqli_query($link,$sql_chart_thai_3);
$Num_Rows_thai_3 = mysqli_num_rows($result_thai_3);


$sql_chart_thai_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%Thailand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_thai_4 = mysqli_query($link,$sql_chart_thai_4);
$Num_Rows_thai_4 = mysqli_num_rows($result_thai_4);
}


if($country=="%" or $country=="Indonesia")
{
//Indo
$sql_chart_indo_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%Indonesia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_indo_1 = mysqli_query($link,$sql_chart_indo_1);
$Num_Rows_indo_1 = mysqli_num_rows($result_indo_1);


$sql_chart_indo_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%Indonesia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_indo_2 = mysqli_query($link,$sql_chart_indo_2);
$Num_Rows_indo_2 = mysqli_num_rows($result_indo_2);

$sql_chart_indo_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%Indonesia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_indo_3 = mysqli_query($link,$sql_chart_indo_3);
$Num_Rows_indo_3 = mysqli_num_rows($result_indo_3);


$sql_chart_indo_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%Indonesia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_indo_4 = mysqli_query($link,$sql_chart_indo_4);
$Num_Rows_indo_4 = mysqli_num_rows($result_indo_4);

}




if($country=="%" or $country=="Malaysia")
{
//Malay
$sql_chart_malay_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%Malaysia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_malay_1 = mysqli_query($link,$sql_chart_malay_1);
$Num_Rows_malay_1 = mysqli_num_rows($result_malay_1);

$sql_chart_malay_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%Malaysia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_malay_2 = mysqli_query($link,$sql_chart_malay_2);
$Num_Rows_malay_2 = mysqli_num_rows($result_malay_2);

$sql_chart_malay_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%Malaysia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_malay_3 = mysqli_query($link,$sql_chart_malay_3);
$Num_Rows_malay_3 = mysqli_num_rows($result_malay_3);

$sql_chart_malay_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%Malaysia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_malay_4 = mysqli_query($link,$sql_chart_malay_4);
$Num_Rows_malay_4 = mysqli_num_rows($result_malay_4);
}



if($country=="%" or $country=="Philippines")
{
//Philippines
$sql_chart_phi_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%Philippines%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_phi_1 = mysqli_query($link,$sql_chart_phi_1);
$Num_Rows_phi_1 = mysqli_num_rows($result_phi_1);

$sql_chart_phi_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%Philippines%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_phi_2 = mysqli_query($link,$sql_chart_phi_2);
$Num_Rows_phi_2 = mysqli_num_rows($result_phi_2);

$sql_chart_phi_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%Philippines%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_phi_3 = mysqli_query($link,$sql_chart_phi_3);
$Num_Rows_phi_3 = mysqli_num_rows($result_phi_3);

$sql_chart_phi_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%Philippines%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_phi_4 = mysqli_query($link,$sql_chart_phi_4);
$Num_Rows_phi_4 = mysqli_num_rows($result_phi_4);
}



if($country=="%" or $country=="Singapore")
{
//Singapore
$sql_chart_sin_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%Singapore%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_sin_1 = mysqli_query($link,$sql_chart_sin_1);
$Num_Rows_sin_1 = mysqli_num_rows($result_sin_1);

$sql_chart_sin_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%Singapore%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_sin_2 = mysqli_query($link,$sql_chart_sin_2);
$Num_Rows_sin_2 = mysqli_num_rows($result_sin_2);

$sql_chart_sin_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%Singapore%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_sin_3 = mysqli_query($link,$sql_chart_sin_3);
$Num_Rows_sin_3 = mysqli_num_rows($result_sin_3);

$sql_chart_sin_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%Singapore%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_sin_4 = mysqli_query($link,$sql_chart_sin_4);
$Num_Rows_sin_4 = mysqli_num_rows($result_sin_4);
}



if($country=="%" or $country=="New Zealand")
{
//New Zealand
$sql_chart_new_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%New Zealand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_new_1 = mysqli_query($link,$sql_chart_new_1);
$Num_Rows_new_1 = mysqli_num_rows($result_new_1);

$sql_chart_new_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%New Zealand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_new_2 = mysqli_query($link,$sql_chart_new_2);
$Num_Rows_new_2 = mysqli_num_rows($result_new_2);

$sql_chart_new_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%New Zealand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_new_3 = mysqli_query($link,$sql_chart_new_3);
$Num_Rows_new_3 = mysqli_num_rows($result_new_3);

$sql_chart_new_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%New Zealand%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_new_4 = mysqli_query($link,$sql_chart_new_4);
$Num_Rows_new_4 = mysqli_num_rows($result_new_4);
}

if($country=="%" or $country=="Australia")
{
//Australia
$sql_chart_aus_1="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=1 AND `ost_form_entry_values`.`value` LIKE '%Australia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_aus_1 = mysqli_query($link,$sql_chart_aus_1);
$Num_Rows_aus_1 = mysqli_num_rows($result_aus_1);

$sql_chart_aus_2="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=2 AND `ost_form_entry_values`.`value` LIKE '%Australia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_aus_2 = mysqli_query($link,$sql_chart_aus_2);
$Num_Rows_aus_2 = mysqli_num_rows($result_aus_2);

$sql_chart_aus_3="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=3 AND `ost_form_entry_values`.`value` LIKE '%Australia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_aus_3 = mysqli_query($link,$sql_chart_aus_3);
$Num_Rows_aus_3 = mysqli_num_rows($result_aus_3);

$sql_chart_aus_4="SELECT * FROM `ost_form_entry_values` INNER JOIN `ost_form_entry` on `ost_form_entry_values`.`entry_id`= `ost_form_entry`.`id` INNER JOIN `ost_ticket` on `ost_ticket`.`ticket_id` = `ost_form_entry`.`object_id` INNER JOIN `ost_ticket__cdata` on `ost_ticket`.`ticket_id` = `ost_ticket__cdata`.`ticket_id` where `ost_form_entry_values`.`field_id` = 41 and (`ost_ticket`.`status_id` = 1 OR `ost_ticket`.`status_id` =6) AND `ost_ticket__cdata`.`priority`=4 AND `ost_form_entry_values`.`value` LIKE '%Australia%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";
$result_aus_4 = mysqli_query($link,$sql_chart_aus_4);
$Num_Rows_aus_4 = mysqli_num_rows($result_aus_4);
}
?>



 <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Emergency', 'High', 'Normal', 'Low', { role: 'annotation' }],
          ['Thailand',     <?php echo $Num_Rows_thai_4 ?>,     <?php echo $Num_Rows_thai_3 ?>,     <?php echo $Num_Rows_thai_2 ?>,     <?php echo $Num_Rows_thai_1 ?>, ''],
          ['Indonesia',      <?php echo $Num_Rows_indo_4?>,     <?php echo $Num_Rows_indo_3 ?>,     <?php echo $Num_Rows_indo_2 ?>,     <?php echo $Num_Rows_indo_1 ?>, ''],
          ['Malaysia',      <?php echo $Num_Rows_malay_4 ?>,     <?php echo $Num_Rows_malay_3 ?>,     <?php echo $Num_Rows_malay_2 ?>,     <?php echo $Num_Rows_malay_1 ?>, ''],
          ['Philippines',      <?php echo $Num_Rows_phi_4 ?>,     <?php echo $Num_Rows_phi_3 ?>,     <?php echo $Num_Rows_phi_2 ?>,     <?php echo $Num_Rows_phi_1 ?>, ''],
		  ['Singapore',     <?php echo $Num_Rows_sin_4 ?>,     <?php echo $Num_Rows_sin_3 ?>,     <?php echo $Num_Rows_sin_2 ?>,     <?php echo $Num_Rows_sin_1 ?>, ''],
          ['New Zealand',      <?php echo $Num_Rows_new_4 ?>,     <?php echo $Num_Rows_new_3 ?>,     <?php echo $Num_Rows_new_2 ?>,     <?php echo $Num_Rows_new_1 ?>, ''],
          ['Australia',      <?php echo $Num_Rows_aus_4 ?>,     <?php echo $Num_Rows_aus_3 ?>,     <?php echo $Num_Rows_aus_2 ?>,     <?php echo $Num_Rows_aus_1 ?>, '']
        ]);

        var options = {
          chart: {
            title: 'Total Tickets By Country',
            subtitle: '',
			isStacked: true,
          }
        };
		
      var options = {

        bar: { groupWidth: '75%' },
        isStacked: true,
		legend: { position: 'bottom', maxLines: 3 },
        colors: ['#bfbcf8', '#bfbcf8'],

      };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_country'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

<tr><td>






            <!-- /.row -->
            <div >
                <div >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Total Tickets Pending By Country Chart
                            <div class="pull-right">
                                <div class="btn-group">
                               </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart">
							
							<div id="columnchart_material_country" style="height: 400px;"></div>
														
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->



</td></tr>

<tr><td>



<?php

$sql_topic="SELECT `topic_id`,`topic` FROM `ost_help_topic`";
$result_topic = mysqli_query($link,$sql_topic);

$row = mysqli_fetch_array($result_topic, MYSQLI_ASSOC);
$i=1;
while($row_topic = mysqli_fetch_array($result_topic,MYSQLI_ASSOC))
{
	$result_topic_id=$row_topic['topic_id'];
	$result_topic_text=$row_topic['topic'];

//	echo "['";
//	echo $row_topic['topic'];
//	echo "', 8.94, 'gold'],";
//	echo "<br>";

$sql_topic_num="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket__cdata` on `ost_ticket__cdata`.`ticket_id`= `ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` INNER JOIN `ost_help_topic` ON `ost_ticket`.`topic_id`= `ost_help_topic`.`topic_id` WHERE `ost_ticket`.`status_id` LIKE '%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59' AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' AND `ost_ticket`.`topic_id`= $result_topic_id";

$result_topic_num = mysqli_query($link,$sql_topic_num);
$Num_Rows_topic_num = mysqli_num_rows($result_topic_num);





$row_topic_text = $row_topic_text."['$result_topic_text', $Num_Rows_topic_num, 'gold'],";


	$i++;
}

//echo "<br>$row_topic_text<br>";


?>



  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
		<?php echo $row_topic_text ;?>     
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Total Tickets Topic",
        //width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
							
							
														
            <!-- /.row -->
            <div >
                <div >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Total Tickets Topic Chart
                            <div class="pull-right">
                                <div class="btn-group">
                               </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart">
							
							<div id="barchart_values" ></div>
														
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->




</td></tr>


<tr><td>

<?php

for($monthcheck= 1 ; $monthcheck <= 12 ; $monthcheck++)
{

$sql_chartopen_monthcheck="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket_status` ON `ost_ticket_status`.`id`= `ost_ticket`.`status_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` where  `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' AND `ost_ticket`.`created` LIKE '$Year1-%$monthcheck-%'";
$resultopen_monthcheck = mysqli_query($link,$sql_chartopen_monthcheck);
$Num_Rowsopen_monthcheck[$monthcheck] = mysqli_num_rows($resultopen_monthcheck);



//echo "Num_Rowsopen_$monthcheck=$Num_Rowsopen_monthcheck[$monthcheck]  : ";



$sql_chartclose_monthcheck="SELECT * FROM `ost_ticket` INNER JOIN `ost_ticket_status` ON `ost_ticket_status`.`id`= `ost_ticket`.`status_id` INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` where (`ost_ticket_status`.`id`!=1 OR `ost_ticket_status`.`id`!=6) and (`ost_ticket`.`status_id`!=1 OR `ost_ticket`.`status_id`!=6) AND `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' AND `ost_ticket`.`closed` LIKE '$Year1-%$monthcheck-%'";
$resultclose_monthcheck = mysqli_query($link,$sql_chartclose_monthcheck);
$Num_Rowsclose_monthcheck[$monthcheck] = mysqli_num_rows($resultclose_monthcheck);


//echo "Num_Rowsclose_$monthcheck=$Num_Rowsclose_monthcheck[$monthcheck]<br>";

}

?>
 
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'open', 'closed'],
            ['Jan',  <?php echo $Num_Rowsopen_monthcheck[1];?>,      <?php echo $Num_Rowsclose_monthcheck[1];?>],
            ['Feb',  <?php echo $Num_Rowsopen_monthcheck[2];?>,      <?php echo $Num_Rowsclose_monthcheck[2];?>],
            ['Mar',  <?php echo $Num_Rowsopen_monthcheck[3];?>,      <?php echo $Num_Rowsclose_monthcheck[3];?>],
            ['Apr',  <?php echo $Num_Rowsopen_monthcheck[4];?>,      <?php echo $Num_Rowsclose_monthcheck[4];?>],
            ['May',  <?php echo $Num_Rowsopen_monthcheck[5];?>,      <?php echo $Num_Rowsclose_monthcheck[5];?>],
            ['Jun',  <?php echo $Num_Rowsopen_monthcheck[6];?>,      <?php echo $Num_Rowsclose_monthcheck[6];?>],
            ['Jul',  <?php echo $Num_Rowsopen_monthcheck[7];?>,      <?php echo $Num_Rowsclose_monthcheck[7];?>],
            ['Aug',  <?php echo $Num_Rowsopen_monthcheck[8];?>,      <?php echo $Num_Rowsclose_monthcheck[8];?>],
            ['Sep',  <?php echo $Num_Rowsopen_monthcheck[9];?>,      <?php echo $Num_Rowsclose_monthcheck[9];?>],
            ['Oct',  <?php echo $Num_Rowsopen_monthcheck[10];?>,     <?php echo $Num_Rowsclose_monthcheck[10];?>],
            ['Nov',  <?php echo $Num_Rowsopen_monthcheck[11];?>,     <?php echo $Num_Rowsclose_monthcheck[11];?>],
            ['Dec',  <?php echo $Num_Rowsopen_monthcheck[12];?>,     <?php echo $Num_Rowsclose_monthcheck[12];?>]
        ]);

        var options = {
          title: 'Trend Tickets  <?php echo $Year1;?>',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>


          <!-- /.row -->
            <div >
                <div >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-line-chart fa-fw"></i> Trend Chart <?php echo $Year1;?>
                            <div class="pull-right">
                                <div class="btn-group">
                               </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart">
							
							<div id="curve_chart"></div>
														
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->



</td></tr>




<?php

$SumNum_Rows_thai = $Num_Rows_thai_4 + $Num_Rows_thai_3 + $Num_Rows_thai_2 + $Num_Rows_thai_1;
$SumNum_Rows_indo = $Num_Rows_indo_4 + $Num_Rows_indo_3 + $Num_Rows_indo_2 + $Num_Rows_indo_1;
$SumNum_Rows_malay = $Num_Rows_malay_4 + $Num_Rows_malay_3 + $Num_Rows_malay_2 + $Num_Rows_malay_1;
$SumNum_Rows_phi = $Num_Rows_phi_4 + $Num_Rows_phi_3 + $Num_Rows_phi_2 + $Num_Rows_phi_1;
$SumNum_Rows_sin = $Num_Rows_sin_4 + $Num_Rows_sin_3 + $Num_Rows_sin_2 + $Num_Rows_sin_1;
$SumNum_Rows_new = $Num_Rows_new_4 + $Num_Rows_new_3 + $Num_Rows_new_2 + $Num_Rows_new_1;
$SumNum_Rows_aus = $Num_Rows_aus_4 + $Num_Rows_aus_3 + $Num_Rows_aus_2 + $Num_Rows_aus_1;
?>


<script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Tickets'],
          ['THAILAND', <?php echo $SumNum_Rows_thai;?>],
          ['Indonesia', <?php echo $SumNum_Rows_indo;?>],
          ['Malaysia', <?php echo $SumNum_Rows_malay;?>],
          ['Philippines', <?php echo $SumNum_Rows_phi;?>],
          ['Singapore', <?php echo $SumNum_Rows_sin;?>],
          ['New Zealand', <?php echo $SumNum_Rows_new;?>],
		  ['Australia', <?php echo $SumNum_Rows_aus;?>],
        ]);

        var options = {
           // region: getSelection()
		   //"filterColumnLabel": "region", "Asia": 035, "Oceania": 009

        };

	//options['dataMode'] = 'regions';
    options['region'] = '035';


        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>



<tr><td>


            <!-- /.row -->
            <div >
                <div >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-globe fa-fw"></i> Region South-Eastern Asia GeoCharts
                            <div class="pull-right">
                                <div class="btn-group">
                               </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart">
							
							<div id="regions_div"></div>
														
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

 


</td></tr>






<script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Tickets'],
          ['THAILAND', <?php echo $SumNum_Rows_thai;?>],
          ['Indonesia', <?php echo $SumNum_Rows_indo;?>],
          ['Malaysia', <?php echo $SumNum_Rows_malay;?>],
          ['Philippines', <?php echo $SumNum_Rows_phi;?>],
          ['Singapore', <?php echo $SumNum_Rows_sin;?>],
          ['New Zealand', <?php echo $SumNum_Rows_new;?>],
		  ['Australia', <?php echo $SumNum_Rows_aus;?>],
        ]);

        var options = {
           // region: getSelection()
		   //"filterColumnLabel": "region", "Asia": 035, "Oceania": 009

        };

	
     options['region'] = '053';
    //options['region'] = eventData.region;
    options['resolution'] = 'countries';

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div_1'));

        chart.draw(data, options);
      }
    </script>



<tr><td>


            <!-- /.row -->
            <div >
                <div >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-globe fa-fw"></i> Region Australia and New Zealand GeoCharts
                            <div class="pull-right">
                                <div class="btn-group">
                               </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart">
							
							<div id="regions_div_1"></div>
														
							</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

 
                </div>
            </div>
        </div>
    </div>
</div>
</div>


</td></tr>



</tbody>
</table>

<?php




$filName = "customer.csv";

$objWrite = fopen("../../attachments/customer.csv", "w");
fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

fwrite($objWrite, "\"ticket_number\",\"user_id\",\"user_name\",\"status_id\",\"ticket_status\",\"department\",\"topic\",\"ticket_post\",\"firstname\",\"lastname\",\"email\",\"source\",\"grace_period\",\"created\",\"closed\",\"reopened\",\"lastupdate\",\"value\" \n");


$sql_export="SELECT `ost_ticket`.`ticket_id`,`ost_ticket`.`number`, `ost_ticket`.`user_id`,`ost_user`.`name` NAME1,`ost_ticket`.`status_id`,`ost_ticket_status`.`name` NAME2, `ost_department`.`name` NAME3, `ost_help_topic`.`topic`,`ost_staff`.`firstname`,`ost_staff`.`lastname`,`ost_staff`.`email`,`ost_ticket`.`source`,`ost_sla`.`grace_period`,`ost_ticket`.`created`,`ost_ticket`.`closed`,`ost_ticket`.`reopened`,`ost_ticket`.`lastupdate`,`ost_form_entry_values`.`value`
FROM `ost_ticket` 
INNER JOIN `ost_ticket_status` ON `ost_ticket_status`.`id`= `ost_ticket`.`status_id` 
INNER JOIN `ost_form_entry` ON `ost_form_entry`.`object_id`=`ost_ticket`.`ticket_id` 
INNER JOIN `ost_form_entry_values` ON `ost_form_entry_values`.`entry_id`=`ost_form_entry`.`id` 
INNER JOIN `ost_user`ON `ost_ticket`.`user_id`=`ost_user`.`id` 
INNER JOIN `ost_department` ON `ost_ticket`.`dept_id`= `ost_department`.`id`
INNER JOIN `ost_help_topic` ON `ost_ticket`.`topic_id`= `ost_help_topic`.`topic_id`
LEFT JOIN `ost_staff` ON `ost_ticket`.`staff_id`= `ost_staff`.`staff_id`
LEFT JOIN `ost_sla` ON `ost_ticket`.`sla_id`= `ost_sla`.`id`
where `ost_form_entry_values`.`field_id`=41 AND`ost_form_entry_values`.`value` LIKE '%$country%' AND `ost_ticket`.`created` BETWEEN '$date1 00:00:00' and '$date2 23:59:59'";

$result_export = mysqli_query($link,$sql_export);

$Num_Rows_export = mysqli_num_rows($result_export);



$row = mysqli_fetch_array($result_export, MYSQLI_ASSOC);
$i=1;
while($row_export = mysqli_fetch_array($result_export,MYSQLI_ASSOC))
{

$result_ticket_id=$row_export['ticket_id'];
$result_ticket_number=$row_export['number'];
$result_user_id=$row_export['user_id'];
$result_user_name=$row_export['NAME1'];
$result_status_id=$row_export['status_id'];
$result_ticket_status=$row_export['NAME2'];
$result_department=$row_export['NAME3'];
$result_topic=$row_export['topic'];
$result_firstname=$row_export['firstname'];
$result_lastname=$row_export['lastname'];
$result_email=$row_export['email'];
$result_source=$row_export['source'];
$result_grace_period=$row_export['grace_period'];
$result_created=$row_export['created'];
$result_closed=$row_export['closed'];
$result_reopened=$row_export['reopened'];
$result_lastupdate=$row_export['lastupdate'];
$result_value=$row_export['value'];


//echo "List = $result_ticket_number | $result_user_id | $result_user_name | $result_status_id | $result_ticket_status | $result_department | $result_firstname | $result_lastname | $result_email | $result_source | $result_grace_period | $result_created | $result_closed | $result_reopened | $result_lastupdate | $result_value<br>";

if(strstr($result_value,"Thailand")){ $result_value="Thailand";	}
if(strstr($result_value,"Indonesia")){ $result_value="Indonesia";	}
if(strstr($result_value,"Malaysia")){ $result_value="Malaysia";	}
if(strstr($result_value,"Philippines")){ $result_value="Philippines";	}
if(strstr($result_value,"Singapore")){ $result_value="Singapore";	}
if(strstr($result_value,"New Zealand")){ $result_value="New Zealand";	}
if(strstr($result_value,"Australia")){ $result_value="Australia";	}

$result_ticket_post1="";
$sql_post="SELECT `ost_thread`.`id`,`ost_thread`.`object_id`,`ost_thread_entry`.`body` FROM `ost_thread` INNER JOIN `ost_thread_entry` ON `ost_thread`.`id`= `ost_thread_entry`.`thread_id` WHERE `ost_thread`.`object_id`=$result_ticket_id"; 


$result_post = mysqli_query($link,$sql_post);

while($row_post = mysqli_fetch_array($result_post,MYSQLI_ASSOC))
{
	
	$result_ticket_post=$row_post['body'];
	$result_ticket_post1="$result_ticket_post1 | $result_ticket_post";

	//$result_ticket_post1=iconv("tis-620", "utf-8", $result_ticket_post1 );

//	echo "result_ticket_post=$result_ticket_post1<br>";
}

//echo "result_ticket_id=$result_ticket_id<br>";
//echo "result_ticket_post=$result_ticket_post1<br>";

fwrite($objWrite, "\"$result_ticket_number\",\"$result_user_id\",\"$result_user_name\",\"$result_status_id\",\"$result_ticket_status\",\"$result_department\",\"$result_topic\",\"$result_ticket_post1\",\"$result_firstname\",\"$result_lastname\",\"$result_email\",\"$result_source\",\"$result_grace_period\",\"$result_created\",\"$result_closed\",\"$result_reopened\",\"$result_lastupdate\",\"$result_value\" \n");



	$i++;
}


//fwrite($objWrite, "\"C002\",\"John  Smith\",\"john.smith@thaicreate.com\",\"EN\",\"2000000\",\"800000\" \n");
//fwrite($objWrite, "\"C003\",\"Jame Born\",\"jame.born@thaicreate.com\",\"US\",\"3000000\",\"600000\" \n");
//fwrite($objWrite, "\"C004\",\"Chalee Angel\",\"chalee.angel@thaicreate.com\",\"US\",\"4000000\",\"100000\" \n");
fclose($objWrite);






/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}



$files_to_zip = array(
	'../../attachments/customer.csv'
);
//if true, good; if false, zip creation failed
$result = create_zip($files_to_zip,'../../attachments/downloadcsv.zip');


?>

<!--
<button onclick="download_csv()">Download CSV</button> 
-->

<br>Generate CSV Done. (right click and save target as)<br><i class="icon-download"></i><a name="export" href="../../attachments/downloadcsv.zip" target="_top">Download</a>

