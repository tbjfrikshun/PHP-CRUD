<?php require_once './src/process.php'; ?>
<?php include_once './src/ChromePhp.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <title>PHP CRUD</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
<?php
//    pre_r($_SESSION);

    if (isset($_SESSION['message'])): ?>
<?php
        $theType = $_SESSION['msg_type'];
?>

    <div class="alert alert-<?php echo $theType; ?>" role="alert">

<?php
        echo $_SESSION['message'];
        unset($_SESSION['message']); // Turn off when user refreshes the page
?>

    </div>
<?php endif; ?>

    <div class="container">
<?php
        // Get list of lines in database.  Improve by removing login password and put in enviroment variables (on server).
        $mysqli = new mysqli('localhost','root','foobar1965','crud') or die(mysqli_error($mysqli));
        $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
?>
      <div class='row justify-content-center'>
        <form action="./src/process.php" method='POST' >
        <div class='form-group'>
          <table class='table'>
            <thead>
              <tr>
                <th>Name</th>
                <th>Location</th>
                <th colspan="2">Action</th>
              </tr>
            </thead>
<?php
            while( $row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['location']; ?></td>
              <td>
                <button type="submit" class="btn btn-info" value=<?php echo $row['id']; ?> name="edit">Edit</button>
                <button type="submit" class="btn btn-danger" value=<?php echo $row['id']; ?> name="delete">Delete</button>
              </td>
            </tr>
<?php endwhile; ?>
          </table>
          </div>
        </form>
      </div>
<?php
        // Get session variables (into local variables) and then unset so page refresh will clear the html
        $name = $_SESSION['name'];
        unset($_SESSION['name']);
        $location = $_SESSION['location'];
        unset($_SESSION['location']);
        $updaterecord = $_SESSION['updaterecord'];
        unset($_SESSION['updaterecord']);
        $id = $_SESSION['id'];
        unset($_SESSION['id']);

?>
      <div class='row justify-content-center' >
        <form action="./src/process.php" method='POST' >
          <div class='form-group'>
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Enter your name">
          </div>
          <div class='form-group'>
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="<?php echo $location; ?>" placeholder="Enter your location">
          </div>
          <div class='form-group'>
            <?php
            // Check to see if we are updating the database otherwise we are adding a new record
            if ($updaterecord == true):
            ?>
              <button type="submit" class="btn btn-info" value="<?php echo $id; ?>" name="update">Update</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>