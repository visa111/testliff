<html>
<head>
<title>ThaiCreate.Com Tutorials</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>

<input type="button" name="btnGetLocation" id="btnGetLocation" value="Get Location">
<br/> <br />
<div id="location"></div>


<script type="text/javascript">

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else { 
			$('#location').html("Geolocation is not supported by this browser.");
		}
	}

	function showPosition(position) {
		var location = "Latitude: " + position.coords.latitude +  "<br>Longitude: " + position.coords.longitude;
		$('#location').html(location);
	}

	$(document).ready(function() {
		
		$("#btnGetLocation").click(function() {	
				getLocation();
		});

	});
</script>

</body>
</html>