<?php
    require_once('config.php');
    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $user_type = 'user';
        $has = md5($_POST['cpassword']);


        if(empty($username)){
            $error[] = 'please enter email address';
        }elseif(empty($email)){
            $error[] = 'please enter email address';
        }else if(empty($password)){
            $error[] = 'please enter password';
        }else if(empty($cpassword)){
            $error[] = 'please enter confirm password';
        }else{
            $select = $db->prepare("SELECT * FROM `users` WHERE name = ? OR email = ?");
            $select->execute([$username, $email]);
            $row = $select->fetch(PDO::FETCH_ASSOC);
            if($username != $row['name']){
                if($email != $row['email']){
                    if(strlen($password) >= 6 AND strlen($cpassword) >= 6){
                        if($password == $cpassword){
                                $insert = $db->prepare("INSERT INTO `users` (name, email, password, image) VALUES (?,?,?,?)");
                                $insert->execute([$username, $email, $has, $image]);
                            if($insert){
                                if($image_size > 2000000){
                                    $error[] = 'image size is to large';
                                }else{
                                    move_uploaded_file($image_tmp_name, $image_folder);
                                    $insertMsg = 'register success';
                                }
                            }   
                    }else{
                        $error[] = 'password is not match';
                    }
                }else{
                    $error[] = 'password must be 6 character';
                    }
                }else{
                    $error[] = 'email is already exits';
                }
            }else{  
                $error[] = 'username is already exits';
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
    <title>register</title>
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
        if(isset($insertMsg)){
    ?>
    <div class="alert alert-success" role="alert">
    <?php echo $insertMsg ?>
    </div>
    <?php
            }
    ?>
  

    <div class="container" style=" margin-top: 100px;">
        <div class="row">
            <h1>register</h1>
            <form  enctype="multipart/form-data" method="post">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="xxx@gmail.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">username</label>
                    <input type="text" name="username" class="form-control" placeholder="please enter username">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="please enter password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="cpassword" class="form-control" placeholder="please confirm password">
                </div>
                <div class="mb-3">
                    <label class="form-label">image</label>
                    <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png" >
                </div>
                <button type="submit" name="register" class="btn btn-warning">register</button>
                <p>you  have account <a href="index.php" >Login now</a></p>
            </form>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>