<?php include('server.php') ?>
<!doctype html>
<html>
<head><title> VIEW ITEMS</title></head>
<link rel="stylesheet" type="text/css" href="style.css">
<body>
<div class="header"> <h2>View Items</h2>
<table border=0 style="margin: 0 auto;text-transform: uppercase">
<tr> <th>item</th><th>Description</th><th>Location</th><th>Date Found</th><th>Contact</th><th>Image</th></tr>
<?php
$query = mysqli_query($db, "SELECT * from items");
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
    $image=$row['image'];
	echo '<tr><td>'.$row['item'].'</td>';
	echo '<td>'.$row['description'].'</td>';
	echo '<td>'.$row['location'].'</td>';
	echo '<td>'.$row['datefound'].'</td>';
	echo '<td>'.$row['contact'].'</td>';
	echo "<td><img src='$image' height='80' width='90'/></td></tr>";
//	echo ".$image.";
}
?>

</table>
</div>
</body>
</html>