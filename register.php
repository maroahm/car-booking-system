<?php
include_once 'inc/storage.php';
session_start();
$errors=[];

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $fields = ["emailAdress" =>"email adress is missing", "password" =>"password is missing",
     "fullName"=>"fullName is missing","rePassword"=>"re-enter your password"];
    foreach($fields as $key=>$message){
        if(empty($_POST[$key]))
        {
            $errors[$key] = $message;
        }
    }
    
    
    if(empty($errors)){
        $email = $_POST['emailAdress'];
        $name = $_POST['fullName'];
        $password = $_POST['password'];
        $rePassword = $_POST['rePassword'];
        if($password != $rePassword)
        {
            $errors['rePassword'] = "password doesnt match";
        }else{
            $file = new JsonIO('data/user.json');    
            if($file->userExists($email))
            {
                $errors['emailAdress'] = "email already exists";
            }else
            {
                $userData = ['fullname' => $name , 'email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)];
                $file->save($userData);
                $_SESSION['user'] = $userData;
                header("Location: index.php");
                exit;
            }

        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <button class="homeButton" onclick = "window.location.href = 'index.php'">ikarRental</button>
            <!-- <form method="GET" action="register.php" class="registration-buttons">
                <button type="submit" >registration</button>
            </form>
            <form action="login.php" method="GET" class="registration-buttons">
            <button type="submit">login</button> -->
        <div>
            <button onclick = "window.location.href = 'login.php'">Login</button>
        </div>
    </nav>

    <h1>registration</h1>
    <form action="" method="post">
        <div class="full-name">
            <p>Full Name</p>
            <input type="text" name="fullName" id="fullName" placeholder="enter your name">
            <?php if(isset($errors['fullName'])):?>
                <div style="color: red;"><?php echo $errors['fullName']; ?></div>
            <?php endif; ?>
        </div>
        <div class="email-adress">
            <p>Email address</p>
            <input type="text" name="emailAdress" id="emailAdress" class="email-adress" placeholder="enter your email address">
            <?php if(isset($errors['emailAdress'])):?>
                <div style="color: red;"><?php echo $errors['emailAdress']; ?></div>
            <?php endif; ?>
        </div>
        <div class="password">
            <p>Password</p>
            <input type="password" name="password" id="password" placeholder="enter your password">
            <?php if(isset($errors['password'])):?>
                <div style="color: red;"><?php echo $errors['password']; ?></div>
            <?php endif; ?>
        </div>
        <div class="re-password">
            <p>Re-enter your Password</p>
            <input type="password" name="rePassword" id="rePassword" placeholder="renter your password">  
            <?php if(isset($errors['rePassword'])):?>
                <div style="color: red;"><?php echo $errors['rePassword']; ?></div>
            <?php endif; ?>
        </div>
        <button type="submit">register</button>
    </form>

</body>
</html>