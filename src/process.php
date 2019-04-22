<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
};
include_once 'ChromePhp.php';

$mysqli = new mysqli('localhost','root','foobar1965','crud') or die(mysqli_error($mysqli));

ChromePhp::log('Hello console!');
ChromePhp::log($_POST);
ChromePhp::log($_SERVER);

// When Save button pressed
if (isset($_POST['save'])){
  $name = $_POST['name'];
  $location = $_POST['location'];

  $mysqli->query("INSERT INTO data (name,location) VALUES('$name', '$location')") or die($mysqli->error);

  $_SESSION['message'] = "Record has been saved!";
  $_SESSION['msg_type'] = "success";

  header("location: http://localhost/~Todd/PHP-CRUD/index.php");

};

// When Update button is pressed
if (isset($_POST['update'])){
  $id = $_POST['update'];
  $name = $_POST['name'];
  $location = $_POST['location'];

  ChromePhp::log("The id is: ".$id);
  ChromePhp::log("The name is: ".$name);
  ChromePhp::log("The location is: ".$location);

  $mysqli->query("UPDATE data SET name='$name',location='$location' WHERE id='$id' ") or die($mysqli->error);

  $_SESSION['message'] = "Record has been updated!";
  $_SESSION['msg_type'] = "info";

  header("location: http://localhost/~Todd/PHP-CRUD/index.php");

};

// When Edit button pressed
if (isset($_POST['edit'])){
  $id = $_POST['edit'];
  ChromePhp::log("The id is: ".$id);
  $result = $mysqli->query("SELECT * FROM data WHERE id='$id'") or die($mysqli->error());
  if (count($result) == 1) {
    $row = $result->fetch_array();
    $name = $row['name'];
    $location = $row['location'];
    
    $_SESSION['message'] = "Record is being edited! Press update button to commit or refresh to clear!";
    $_SESSION['msg_type'] = "warning";
    $_SESSION['name'] = $name;
    $_SESSION['location'] = $location;
    $_SESSION['id'] = $id;
    $_SESSION['updaterecord'] = true;
  }
  header("location: http://localhost/~Todd/PHP-CRUD/index.php");
};

// When delete button is pressed
if (isset($_POST['delete'])){
  $id = $_POST['delete'];
  ChromePhp::log("The id is: ".$id);
  $mysqli->query("DELETE FROM data WHERE id='$id'") or die($mysqli->error());

  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";
  
  header("location: http://localhost/~Todd/PHP-CRUD/index.php");

};
?>