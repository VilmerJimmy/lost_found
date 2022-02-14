<?php include('server.php') ?>
<html>
<head>
<title> ITEM REGISTRATION </title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header"><h2><u>ADD MATERIALS</u></h2> </div>
<form method="post" action="ItemRegister.php" enctype="multipart/form-data">
<?php include('errors.php'); ?>
<div class="input-group">
<label>ISSUE</label>
<input type="text" name="item"  placeholder="Issue" autocomplete="off" >
</div>
<div class="input-group">
<label>DESCRIPTION</label>
<input type="text" name="description"  placeholder="Description of the Issue "autocomplete="off" >
</div>
<div class="input-group">
<label>IMAGE (optional)</label>
<input type="file" name="image" >
</div>
<div class="input-group">
<button type="submit" name="savelost" class="btn">SAVE</button>
</div>
<div class="input-group">
<input type =button onClick="location.href='index.php'" value='Back'>
</div>
</form>

</body>
</html>