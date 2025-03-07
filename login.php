<?php
require_once 'inc/storage.php';
session_start();
$errors=[];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

 
        if ($_POST['emailAdress'] === 'admin@ikarrental.hu' && $_POST['password'] === 'admin') {
            $_SESSION['admin'] = true;
            header('Location: admin/index.php');
            exit;
        }
    
    
    $fields = [ "emailAdress" => "email adress is missing", "password" => "password is missing"];
    foreach($fields as $key=>$message)
    {
        if(empty($_POST[$key]))
        {
            $errors[$key] = $message;
        }
    }

    if(empty($errors))
    {
        $email = $_POST['emailAdress'];
        $password =$_POST['password'];
        
        $file = new JsonIO('data/user.json');
        $userData = $file->loadUser($email);
        if($userData && password_verify($password, $userData['password']))
        {
            $_SESSION['user'] = $userData;
            header("Location: index.php");
            exit;
        }else{
    
            $errors['login'] = "invalid user data";
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
            <div>
                <button onclick = "window.location.href = 'register.php'">registeration</button>
            </div>
    </nav>
    <form action="" method="post" class="login-form">
        <h1>Login</h1>
        
        <p>Email address</p>
        <input type="text" name="emailAdress" id="emailAdress" class="email-adress" placeholder="enter your email">
        <?php if(isset($errors['emailAdress'])):?>
            <div style="color: red;"><?php echo $errors['emailAdress']; ?></div>
        <?php endif; ?>
        
        <p>Password</p>
        <input type="password" name="password" id="password" placeholder="enter your password">
        <?php if(isset($errors['password'])):?>
            <div style="color: red;"><?php echo $errors['password']; ?></div>
        <?php endif; ?>
        <button type="submit">login</button>
        <?php if(isset($errors['login'])):?>
            <div style="color: red;"><?php echo $errors['login']; ?></div>
        <?php endif; ?>
    </form>

</body>
</html>