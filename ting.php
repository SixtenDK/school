<?php

//key array - den offline database | user er marcus, password er md5, salt er thisissalt
$data = array("user"=>"marcus", "password"=>"526cf5e4ab2b48cc25993b0095813966", "salt"=>"thisisthesalt");
//starter en session
session_start();

// når der klikkes submit, når der sker noget (er $_POST sat?)
if (isset($_POST)) {
  //hvis "login" ikke er tom (!)
  if (!empty($_POST['login'])) {
    //tjekker om der er username og password
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
      //laver en variabel for username
      $username = $_POST['username'];
      //laver en variabel for password
      $password = $_POST['password'];
      //laver en variabel for salt
      $salt = $data['salt'];
      //hvis den kan finde $username i arrayen $data
      if (in_array($username, $data)) {
        //assigner $username fra arrayen til $user
        $user = $username;
        //ellers gør
      } else {
        //sig en tekst
        echo "The username is not the right one!";
      }
      //definerer at $password er et password + en salt
      $password = md5($password . $salt);
      //hvis passwordet matcher det password i arrayen
      if ($password == $data['password']) {
        //så laver den en session for user
        $_SESSION['user'] = $user;
        //ellers gør
      } else {
        //sig en tekst
        echo "The password was wrong!";
      }


      //ellers gør
    } else {
      //sig en tekst
      echo "Either username or password is empty!";
    }
  }
}
//hvis sessionen er tom (ikke logget ind)
if (empty($_SESSION['user']) && !isset($_SESSION['user'])) {
  //sig en tekst (i dette tilfælde html)
  echo '
  <form method="POST">
  <input type="text" name="username" placeholder="username"/></br>
  <input type="password" name="password" placeholder="password"/></br>
  <input type="submit" name="login" value="login"/>
  </form>
  ';
  //ellers
} else {
  //hvis clearsession er startet
  if (isset($_POST['clearsession'])) {
    //lukker sessionen
    session_destroy();
    //variabel for sidens givne fil
    $site = $_SERVER['PHP_SELF'];
    // gå til $site
    header("Location: $site");
  }
  //vi har fattet at den siger en tekst, ikke?
  echo "You are loggedin ". $_SESSION['user'] . "</br>";
  // x2
  echo '<form method="POST"><input type="submit" name="clearsession" value="logout"></form>';
}



?>
