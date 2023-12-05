<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "conturi";

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn) {
    die("Connection to the database failed: " . mysqli_connect_error());
  }

  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  // Check if the email format is valid using regular expressions
  $emailRegex = "/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/";
  if (!preg_match($emailRegex, $email)) {
    echo "Invalid email format.";
    mysqli_close($conn);
    exit();
  }

  // Check if the email already exists in the database
  $sql = "SELECT * FROM conturi WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
  }

  if (mysqli_num_rows($result) > 0) {
    echo "Email already exists.";
    mysqli_close($conn);
    exit();
  }

  // Hash the password before storing it in the database
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert the email and hashed password into the database
  $sql = "INSERT INTO conturi (email, password) VALUES ('$email', '$hashedPassword')";
  if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    echo "<script>";
    echo "localStorage.setItem('email', '$email');";
    echo "localStorage.setItem('isLoggedIn', true);";
    echo "window.location.href = 'Principal.html';";
    echo "</script>";
    exit();
  } else {
    echo "Error inserting data into the database: " . mysqli_error($conn);
  }
}

?>
