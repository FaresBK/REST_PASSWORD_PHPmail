<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <?php
    if(!isset($_GET['code'])){
      echo '<div class="container">
      <form method="POST">
       <div class="mt-3">EMAIL:</div>
        <input class="form-control" type="email" name="mail"  require><br> 
       <button class="btn btn-success mt-3 " type="submit" name="click">Send</button>   
      </form>
      </div>';
    }else if(isset($_GET['code'])&& isset($_GET['email'])){
      echo '<div class="container">
            <form method="POST">   
             <div class="mt-3"> NEW PASSWORD :</div>
             <input class="form-control" type="text" name="password"  require><br>
             <button class="btn btn-success mt-3 " type="submit" name="updato">UPDATE PASS</button>  
           </form>
            </div>';      
           
    }
  ?>



<?php
if(isset($_POST['click'])){
 $username="root";
 $password="";
 $database=new PDO("mysql:host=localhost;dbname=users;charset=utf8",$username,$password);
 $rest=$database->prepare("SELECT email,security FROM user WHERE email=:mail");
 $rest->bindParam("mail",$_POST['mail']);
 $rest->execute();
 if($rest->rowCount()>0){
   $test=$rest->fetchObject();
   require_once 'mail.php';
   $mail->SetFrom('faresoz122@gmail.com','dz موقع شوبي ');
   $mail->AddAddress($_POST['mail']);     // Add a recipien
   $mail->Subject = 'تحديث كلمة المرور ';
   $mail->Body  =  '<h1> شكرا لتسجيلك في موقعنا</h1>'
   . "<div> رابط تحقق من حساب" . "<div>" . 
   "<a href='http://localhost:1313/serveur/restpassword.php?email=".$_POST['mail']."&code=".$test->security."'>
    " . "http://localhost:1313/serveur/restpassword.php?email=".$_POST['mail']."&code=".$test->security."</a>";

  $mail->Send();
 }else{
    echo '<br><div class="container mt-3" >
    <div class="alert alert-warning container">
    <strong>Warning!</strong> EMAIL NOT EXISTE .
    </div>
    </div>';
 }
}
?>
<?php 
 if(isset($_POST['updato'])){
  $username="root";
  $password="";
  $database=new PDO("mysql:host=localhost;dbname=users;charset=utf8",$username,$password);
  $update=$database->prepare("UPDATE user SET password =:pass WHERE email=:mail");
  $update->bindParam("pass",$_POST['password']);
  $update->bindParam("mail",$_GET['email']);
 if($update->execute()){
  echo '<div class="container">
            <div class="alert alert-success container mt-3">
            <strong>Success!</strong> New Password IS Success.
          </div>
          </div><br>';
          session_unset();
          session_destroy();
          header("location:http://localhost:1313/serveur/login.php",true);
          die("");
 }else{
  echo '<div class="container">
  <div class="alert alert-warning container mt-3">
  <strong>EROR!</strong> New Password is NOT Success.
  </div>
  </div>
  <br>';

 }
 }

?>
    
</body>
</html>