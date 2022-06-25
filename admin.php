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
    
    
        <section class="cards">
            <div class="c11">
                <div class="card">
                    <?php 
                    $select_product = $db->prepare("SELECT * FROM `product`");
                    $select_product->execute();
                    $select_product_count = $select_product->rowCount();
                    ?>
                    <div  class="card-header">
                            product
                        </div>
                    <div class="card-body">
                        <h5 class="card-title">have <span><?php echo $select_product_count?>    </span> product</h5>
                    </div>
                    <div class="buttom">
                        <a href="product.php" class="btn btn-primary">see product</a>
                    </div>
                    </div>

                    <div class="card">
                        <?php 
                        $select_user = $db->prepare("SELECT * FROM `users`");
                        $select_user->execute();
                        $select_user_count = $select_user->rowCount();
                        ?>
                        <div  class="card-header">
                            user
                        </div>
                    <div class="card-body">
                        <h5 class="card-title">have <span><?php echo $select_user_count?></span> users</h5>
                    </div>
                    <div class="buttom">
                            <a href="user.php" class="btn btn-primary">see users</a>
                        </div>
                    </div>

                    <div class="card">
                    <?php 
                        $select_message = $db->prepare("SELECT * FROM `message`");
                        $select_message->execute();
                        $select_message_count = $select_message->rowCount();
                    ?>
                        <div  class="card-header">
                            message
                        </div>
                    <div class="card-body">
                        <h5 class="card-title">have <span><?php echo $select_message_count?></span> message</h5>
                    </div>
                    <div class="buttom">
                        <a href="messages.php" class="btn btn-primary">see message</a>
                    </div>
                    </div>

                    <div class="card">
                    <?php 
                        $select_order = $db->prepare("SELECT * FROM `order`");
                        $select_order->execute();
                        $select_order_count = $select_order->rowCount();
                    ?>
                        <div class="card-header">
                            order
                        </div>
                    <div class="card-body">
                        <h5 class="card-title">have <span><?php echo $select_order_count?> </span>order</h5>
                    </div>
                    <div class="buttom">
                        <a href="orders.php" class="btn btn-primary">see order</a>
                    </div>
                    </div>
            </div>
        </section>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>





</body>
</html>
<?php } ?>