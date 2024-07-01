<?php
  session_start();
  require "../includes/database_connect_hide_error.php";

  if( $con ) 
  {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password = sha1($password);

    $sql_query = " SELECT * FROM users WHERE email='$email' AND password='$password'; ";
    $result = mysqli_query($con,$sql_query);
    if( $result )
    {
      $row_count = mysqli_num_rows($result);


      if( $row_count == 1 ){
        $row = mysqli_fetch_assoc($result);

        $_SESSION["user_id"] = $row["id"];
        $_SESSION["full_name"] = $row["full_name"];

        $response = array("success" => true, "message" => "Successfully Logged IN!");
        echo json_encode($response);
        return;
      }
      elseif( $row_count == 0 ){
        $response = array("success" => false, "message" => "Incorrect Username or Password!");
        echo json_encode($response);
        return;
      }
    }
    else{
      $response = array("success" => false, "message" => "We couldn't log you in at the moment!");
      echo json_encode($response);
      return;
    }
  }
  else{
    $response = array("success" => false, "message" => "Database Connectivity Error!");
    echo json_encode($response);
    return;
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      <?php

      ?>
    </title>

    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet" />
    <link href="../css/common.css" rel="stylesheet" />
    <!-- <link href="css/index.css" rel="stylesheet" /> -->
</head>

<body>
  <?php require "../includes/header.php"; ?>

  <div class="login-content mx-4 my-5">
    <?php
      if( !$con ){
        echo "
          <h2>Database Connectivity Error!</h2>
          <hr />
          <p>Account Creation Unsuccessfull!</p>
        ";
        echo "<h5> ".mysqli_connect_error()." </h5>";
      }
      elseif( !$result ){
        echo "
          <h2>We couldn't log you in!</h2>;
          <hr />
        ";
        echo "<h5>".mysqli_error($con)."</h5>";
      }
    ?>

    <?php
      if( $row_count == 0 )
      {
  
    ?>
      <div class="">
        <h2>Email or Password do not match!</h2>
        <hr>
        <p>Try again logging in with different email or password...</p>
      </div>

    <?php
      }
    ?>

  </div>


  <?php require "../includes/signup_modal.php"; ?>
  <?php require "../includes/login_modal.php" ?>
  <?php require "../includes/footer.php" ?>

  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/common.js"></script>
</body>

</html>

<?php mysqli_close($con); ?>
