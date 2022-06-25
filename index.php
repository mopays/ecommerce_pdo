<?php
    require_once('config.php');
    session_start();

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        if(empty($email)){
            $error[] = 'please enter email address';
        }else if(empty($password)){
            $error[] = 'please enter password';
        }else{
            $select = $db->prepare("SELECT * FROM `users` WHERE email = ? ");
            $select->execute([$email]);
            $row = $select->fetch(PDO::FETCH_ASSOC);
            
            if($email == $row['email']){
                if($password == $row['password']){
                    if($row['user_type'] == 'user'){
                        $_SESSION['user'] = $row['id'];
                        header('refresh:1;user_section/shops.php');
                        $loginMsg[] = 'login success';
                    }elseif($row['user_type'] == 'admin'){
                        $_SESSION['admin'] = $row['id'];
                        header('refresh:1;admin.php');
                        $loginMsg[] = 'login success';
                    }
                }else{  
                    $error[] = 'wrong password please try again';
                }
            }else{
                $error[] = 'wrong email please try again';
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <?php 
        if(isset($error)){
            foreach($error as $error){
    ?>
    <div class="alert alert-danger" role="alert">
    <?php echo $error?>
    </div>
    <?php 
        }
            }
        ?>
    <?php 
        if(isset($loginMsg)){
            foreach($loginMsg as $loginMsg){
    ?>
    <div class="alert alert-success" role="alert">
    <?php echo $loginMsg ?>
    </div>
    <?php 
            }
        }
        ?>

    <div class="container">
        <div class="row">
            <h1>login</h1>
            <p>admin@gmail.com password 111111</p>
            <p>test@gmail.com password 111111</p>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="xxx@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="please enter password">
                </div>
                <button type="submit" name="login" class="btn btn-warning">login</button>
                <p>you don't have account <a href="register.php">register now</a></p>
            </form>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>