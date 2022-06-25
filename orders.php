<?php 
    require_once('config.php');
    session_start();
    if(!isset($_SESSION['admin'])){
        header('location:index.php');
    }else{
        $id = $_SESSION['admin'];
        $select = $db->prepare("SELECT * FROM `users` WHERE id = ?");
        $select->execute([$id]);
        if(isset($_REQUEST['delete'])){
            $user_id = $_REQUEST['delete'];
            $delete_user = $db->prepare("DELETE FROM `order` WHERE id = ?");
            $delete_user->execute([$user_id]);
            #unlink('upload_image/'.$old_image);
            $error[] = 'delete success';
            header('refresh:1;orders.php');
        }
        if(isset($_REQUEST['update_order'])){
            $update_id = $_REQUEST['order_id'];
            $method = $_REQUEST['update_payment'];

            $update_method = $db->prepare("UPDATE `order` SET payment_status = ? WHERE id = ?");
            $update_method->execute([$method, $update_id]);
            header('refresh:1;orders.php');
            $error[] = 'update success';

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
    <title>user</title>
</head>
<body>
    <?php include_once('header.php')?>
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
      <section>
        <h1>order manager</h1>
        <?php 
            $select_orders = $db->prepare("SELECT * FROM `order`");
            $select_orders->execute();
            if($select_orders->rowCount()  > 0){
                while($row = $select_orders->fetch(PDO::FETCH_ASSOC)){
            
           
        ?>
        <div class="w3-container user_m" >
            <div class="w3-panel w3-card cds" style="height: 37rem ;">
                <h2><?php echo $row['name']?></h2>
                <p>email : <?php echo $row['email']?></p>
                
                <p>number : <?php echo $row['number']?></p>
                <p>address : <?php echo $row['address']?></p>
               
                <p>placed_on : <?php echo $row['placed_on']?></p>
                <p>devely : <?php echo $row['method']?></p>

                <p>total_products : <?php echo $row['total_products']?></p>
                <p>tota_price : <?php echo $row['tota_price']?></p>
                

                <form action="" method="post">
                <label>status:</label>
                <input type="hidden" name="order_id" value="<?php echo $row['id']?>">
                    <select name="update_payment" class="drop-down" id="">
                        <option value="" selected disabled><?php echo $row['payment_status']?></option>
                        <option value="pending" >pending</option>
                        <option value="completed" >completed</option>
                    </select>
                    <div class="flex-btn">
                        <br>
                        
                        <input type="submit" name="update_order" class="btn btn-warning" value="update">
                        <a href="?delete=<?php echo $row['id'];?> "onclick="return confirm('delete this order?')" class="btn btn-danger">delete</a>
                    </div>
                </form>

                <br>

            </div>
           
            </div>
            <?php } 
            }else{
                echo '<p style="text-align:center; color:red;font-size:50px; margin-top:40px;">no orders</p>';
            }
            ?>
      </section>
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
<?php } ?>
