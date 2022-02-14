<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'lost');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = password_hash($password_1,PASSWORD_BCRYPT);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ... 
// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$passwordcheck = password_hash($password,PASSWORD_BCRYPT);
  	$query = "SELECT * FROM users WHERE username='$username' ";

  	$results = mysqli_query($db, $query);
  	if(mysqli_affected_rows($db)>0){
  	    $row=mysqli_fetch_array($results);
  	    if(password_verify($passwordcheck,$row['password'])){
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }else{
            array_push($errors, "Wrong password combination");

        }
    } else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}
//register a lost item
if (isset($_POST['savelost'])) {
  // receive all input values from the form
  $item = mysqli_real_escape_string($db, $_POST['item']);
  $description = mysqli_real_escape_string($db, $_POST['description']);
 $image = "images/".$_FILES['image']['name'];
 $moved=move_uploaded_file($_FILES['image']['tmp_name'],$image);
 if(!$moved){
     $_SESSION['success'] = "image not Saved";
     header('location: index.php');
 }
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($item)) { array_push($errors, "Item is required"); }
  if (empty($description)) { array_push($errors, "Description of the Item is required"); }
  if (count($errors) == 0) {
  	$query = "INSERT INTO items (username, item, description, image) 
  			  VALUES('$username', '$item', '$description', '$image')";
  	$res=mysqli_query($db, $query);
	if(mysqli_affected_rows($db)>0){
  	$_SESSION['success'] = "Item Saved";
  	header('location: index.php');}
	else{
		$_SESSION['success'] = "Item not Saved";
  	header('location: index.php');}
		
	}
  }

?>