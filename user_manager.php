<?php 
    error_reporting(E_ALL);
    require_once('config.php');
    session_start();
    if(!isset($_SESSION['admin'])){
        header('location:index.php');
    }else{
        $id = $_SESSION['admin'];
        $select = $db->prepare("SELECT * FROM `users` WHERE id = ?");
        $select->execute([$id]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        extract($row);
        if(isset($_POST['chang_image'])){
                $image = $_FILES['image']['name'];
                $image_size = $_FILES['image']['size'];
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_folder = 'upload_image/'. $image;
                $old_image = $_POST['old_image'];

                if(empty($image)){
                    $error[] = 'please chose files to change image';
                }else{
                    $update = $db->prepare("UPDATE `users` SET `image` = ? WHERE `id` = ?;");
                    $update->execute([$image,$id]);
                    if($image_size > 20000000){
                        $error[] = 'image size is to large';
                    }else{
                        if(move_uploaded_file($image_tmp_name , $image_folder)){
                            unlink('upload_image/'.$old_image);
                            header('refresh:1;');
                            $message[] = 'update image success';
                        }
                       
                    }
                }
        }
        if(isset($_POST['chang_password'])){
            $old_password =  md5($_POST['old_password']);
            $new_password =  $_POST['new_password'];
            $cpassword =  $_POST['cnew_password'];
            $has = md5($_POST['cnew_password']);

             if(empty($old_password)){
                $error[] = 'please enter old password';
            }else if(empty($new_password)){
                $error[] = 'please enter new password';
            }else if(empty($cpassword)){
                $error[] = 'please enter confirm password';
            }else{
                if($old_password == $row['password']){
                    if(strlen($new_password) >= 6 AND strlen($cpassword) >= 6){
                        if($new_password == $cpassword){
                            $update = $db->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?;");
                            $update->execute([$has,$id]);
                            $message[] = 'update password success';
                        }else{
                            $error[] = 'password is not match';
                        }
                    }else{
                        $error[] = 'password must be 6 character';
                    }
                }else{
                    $error[] = 'someting wrong plase enter old password again';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>admin</title>
</head>
<body>
        <?php include_once('header.php');?>        
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
            if(isset($message)){
                foreach($message as $message){
        ?>
        <div class="alert alert-success" role="alert">
            <?php echo $message ?>
        </div>
        <?php
                }
            }
        ?>

        <section class="users" encript>
                <h1>welcome</h1>
                <img src="upload_image/<?php echo $row['image']?>" alt="">
     
                
     
                <h4>user name : <?php echo $row['name']?></h4>
                <p>your position is : <?php echo $row['user_type']?></p>
                <p>your email is : <?php echo $row['email']?></p>  
                <h3>change password </h3> 
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                    <input type="hidden"  name="old_image" value="<?php echo $row['image']?>">
                        <input style="width: 20%;" type="file" name="image" id="" placeholder="change images">
                        <button class="btn btn-success"  name="chang_image">change image</button>
                    </div>
                    <div class="mb-3">
                        <label for="password">old password</label>
                        <input type="password" name="old_password" placeholder="enter old password">
                    </div>
                    <div class="mb-3">
                        <label for="password">new password</label>
                        <input type="password" name="new_password" placeholder="enter new password">
                    </div>
                    <div class="mb-3">
                        <label for="password">confirm password</label>
                        <input type="password" name="cnew_password" placeholder="confirm new password">
                    </div>
                    <button class="btn btn-success" style="margin-bottom:10px ;" name="chang_password">change infomation</button>
                </form>
                    <a href="logout.php" class="btn btn-danger">logout</a>
        </section>
      

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>





</body>
</html>
<?php } ?>