<?php 
    error_reporting(E_ALL);
    require_once('../config.php');
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:../index.php');
    }else{
        $id = $_SESSION['user'];
        $select = $db->prepare("SELECT * FROM `users` WHERE id = ?");
        $select->execute([$id]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        extract($row);
        
        if(isset($_POST['send_message'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $number = $_POST['number'];
            $message = $_POST['message'];

            if(empty($name)){
                $error[]  = 'please enter username';
            }else if(empty($email)){
                $error[]  = 'please enter email';
            }else if(empty($number)){
                $error[]  = 'please enter number';
            }else if(empty($message)){
                $error[]  = 'please enter message';
            }else{
                $insert_msg = $db->prepare("INSERT INTO `message` (user_id,name,email,number,message) VALUES(?,?,?,?,?)");
                $insert_msg->execute([$id,$name,$email,$number,$message]);
                $insertMsg = 'send message success';
                header('refresh:1;');
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>message</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <!-- Navigation-->
       <?php 
       include_once('header.php');
       ?>
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
                <?php echo $insertMsg?>
            </div>
        <?php 
                }
        ?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">sent message</h1>
                    <p class="lead fw-normal text-white-50 mb-0">_______________________________</p>
                </div>
            </div>
        </header>
        <!-- Section-->
                <section class="messages">
                    <form action="" method="POST">
                        <div class="col-md-3">
                            <label for="">name</label>
                            <input type="text" name="name" id="" value="<?php echo $row['name']?>">
                        </div>
                        <div class="col-md-3">
                            <label for="">email</label>
                            <input type="email" name="email" id="" value="<?php echo $row['email']?>">
                        </div>
                        <div class="col-md-3">
                            <label for="">number</label>
                            <input type="number" name="number" id="" placeholder="enter your number">
                        </div>
                        <div class="col-md-3">
                            <label for="">message</label>
                            <textarea name="message" id="" cols="30" rows="10" maxlength="170" placeholder="enter message "></textarea>
                        </div>
                        <div class="col-md-3">
                            <input name="send_message" class="send_message" type="submit" value="send message">
                        </div>
                    </form>
                </section>
                <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                    <?php 
                        $select = $db->prepare("SELECT * FROM `message` WHERE user_id =?");
                        $select->execute([$id]);
                        while($row = $select->fetch(PDO::FETCH_ASSOC)){
                    ?>
                   
                    <div class="col mb-5">
                   <form action="" method="post">
                        <div class="card h-100 w-150">
                            <h5 class="fw-bolder">user id : <?php echo $row['user_id']?></h5>
                            <div class="card-body p-4">
                                <div class="text-center">
                                   
                                    <h5 class="fw-bolder">name : <?php echo $row['name']?></h5>
                                    <h5 class="fw-bolder">email : <?php echo $row['email']?></h5>
                                    <h5 class="fw-bolder">number : <?php echo $row['number']?></h5>
                                    <h5 class="fw-bolder">message : <?php echo $row['message']?></h5>
                                 
                                </div>
                            </div>
                           
                        </div>
                   </form>
                    </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->

        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>