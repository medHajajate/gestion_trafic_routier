<!DOCTYPE html>
<html>
<head>
<title>INPT TRACKING</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb-UGuXj4VnZ97yDcKgGvlE7jaAfj7wUg&signed_in=true">
</script>


<script>


var citymap = {
	<?php
$con=mysqli_connect("localhost","root","","loginregister");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM users") or die(mysqli_error($con));
if($result){
	$i=0;
 while($data = mysqli_fetch_array($result))
{

   echo 'chicago'.$i++.': {
    center: {lat:' .doubleval($data[9] ).', lng: '.doubleval($data[8]).'},
    population: 2
  },
  ';
 
}}
  
  ?>
  
  
};
var myCenter=new google.maps.LatLng(33.9864987,-6.8620733);
//var $ltlng;
function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:17,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);


    
	

	

  
 
  
  
<?php
$con=mysqli_connect("localhost","root","","loginregister");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 

$result = mysqli_query($con,"SELECT * FROM users") or die(mysqli_error($con));
if($result){
 while($data = mysqli_fetch_array($result))
{
 echo '  
 var marker=new google.maps.Marker({
  position:{lat:'.$data[7].',lng:'.$data[6].'},
      label:"'.$data[0].'" ,

  
  });

marker.setMap(map);';


}}
?> 

for (var city in citymap) {
    // Add the circle for this city to the map.
    var cityCircle = new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
      center: citymap[city].center,
      radius: Math.sqrt(citymap[city].population) * 100
    });
  }






}


  
 


google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body class="w3-blue">
    
	 
	&nbsp;<table><tr>
	<tr> <th><img src="logo_ap.png" style="width:40%"></th>
	        <form action="insert.php" method="post" >	     
			<th><label for="longitude">user_id :</label>
			<input type="text" name="user_id" id="user_id" />	
			<label for="longitude">Longitude :</label>
			<input type="text" name="longitude" id="longitude" />

			<label for="latitude">Latitude :</label>
			<input type="text" name="latitude" id="latitude" />
			<button type="submit" value="submit" class="w3-khaki">Add</button>
			<button class="w3-green">delete</button>
				</th>
				</form></tr>
	<td><table  class="w3-table w3-border">


<tr  class="w3-red">
 
  <th>User Name</th>
  <th>Vehicle Type</th>
    <th>Id_client</th>
  <th>Position</th>
 
</tr>
<?php
$con=mysqli_connect("localhost","root","","loginregister");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 

$result = mysqli_query($con,"SELECT * FROM users") or die(mysqli_error($con));
if($result){
 while($data = mysqli_fetch_array($result))
{
echo '<tr class="w3-white" id="autoRefresh()">';
echo '<th>' . $data[2] . '</th>';
echo '<th> '. $data[1] . '</th>';
echo '<th> '. $data[0] . '</th>';
echo '<th> '. $data[6] .','. $data[7] . '</th>';


echo "</tr>";
}}
?>

</table></td><td>
<div id="googleMap" style="width:700px;height:580px;"></div></td></tr></table>
</body>
</html>
