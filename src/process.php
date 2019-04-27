<?php // Start a session upon a form action event
if (session_status() == PHP_SESSION_NONE) {
  session_start();
};
include_once 'ChromePhp.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

ChromePhp::log('Hello console!');
$referer = $_SERVER['HTTP_REFERER'];

// Load up the application enviroment variables
$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
$dotenv->load();

$mysqli = new mysqli(getenv('HOST'),getenv('USER_NAME'),getenv('PASSWORD'),getenv('DB_NAME')) or die(mysqli_error($mysqli));

ChromePhp::log($_POST);
ChromePhp::log($_SERVER);

// When Save button pressed
if (isset($_POST['save'])){
  $name = $_POST['name'];
  $location = $_POST['location'];

  $mysqli->query("INSERT INTO data (name,location) VALUES('$name', '$location')") or die($mysqli->error);

  // Setup for Alert message
  $_SESSION['message'] = "Record has been saved!";
  $_SESSION['msg_type'] = "success";

  header("location: $referer");
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

    // Setup for Alert message
  $_SESSION['message'] = "Record has been updated!";
  $_SESSION['msg_type'] = "info";

  header("location: $referer");
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
    
    // Setup for Alert message
    $_SESSION['message'] = "Record is being edited! Press update button to commit or refresh to clear!";
    $_SESSION['msg_type'] = "warning";
    $_SESSION['name'] = $name;
    $_SESSION['location'] = $location;
    $_SESSION['id'] = $id;
    $_SESSION['updaterecord'] = true;
  }
  header("location: $referer");
};

// When delete button is pressed
if (isset($_POST['delete'])){
  $id = $_POST['delete'];
  ChromePhp::log("The id is: ".$id);
  $mysqli->query("DELETE FROM data WHERE id='$id'") or die($mysqli->error());

  // Setup for Alert message
  $_SESSION['message'] = "Record has been deleted!";
  $_SESSION['msg_type'] = "danger";
  
  header("location: $referer");
};
?>