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
       
    if(isset($_POST['remove'])){
        $pid = $_POST['id'];
        $delete = $db->prepare("DELETE FROM `cart` WHERE id = ?");
        $delete->execute([$pid]);
        $error[] = 'remove form cart success';
    }
    if(isset($_POST['update_qty'])){
        $qty = $_POST['pqty'];
        $pid = $_POST['id'];
        $update_qty = $db->prepare("UPDATE `cart` SET `quantity` = ? WHERE `id` = ?");
        $update_qty->execute([$qty, $pid]);
        $error[] = 'update quantity success';
    }
    
    
        

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shoping</title>
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

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">cart</h1>
                    <p class="lead fw-normal text-white-50 mb-0"></p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                    <?php 
                            $grand_total = 0;
                        $select = $db->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $select->execute([$id]);
                        if($select->rowCount() > 0){
                        while($row = $select->fetch(PDO::FETCH_ASSOC)){
                            $total_price = ($row['price'] * $row['quantity']);
                            

                    ?>
                   <?php $grand_total += $total_price;?>
                    <div class="col mb-5">
                   <form action="" method="post">
                    <input type="hidden" name="name" value="<?php echo $row['name']?>">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="image" value="<?php echo $row['image']?>">
                    <input type="hidden" name="id" value="<?php echo $row['id']?>">
                    <input type="hidden" name="category" value="<?php echo $row['category']?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']?>">
                    
                        <div class="card h-100">
                            <img class="card-img-top"  src="../upload_image/<?php echo $row['image']?>" alt="..." />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?php echo $row['name']?></h5>
                                    <h5 style="display:none ;" class="fw-bolder" ><?php echo $row['id']?></h5>
                                    
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"><input type="number" min="1" max="9999999" name="pqty" placeholder="<?php echo $row['quantity']?>"><br></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                     <p>total price :<?php echo $total_price?></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div  class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <form action="" method="post">
                                    <div class="text-center" style="margin: 10px ;"><button name="update_qty" class="btn btn-outline-dark mt-auto" href="#">update quantity</button></div>
                                    <div class="text-center" style="margin: 10px ;"><button name="remove" class="btn btn-outline-dark mt-auto" href="#">remove to cart</button></div>
                                </form>
                            </div>
                        </div>
                   </form>
                    </div>
                        <?php }
                            }
                            else{
                        ?>
                        <p style="color: red;text-align:center;">no product in cart</p>
                        <?php
                            }  
                            ?>
                        </div>
                    </div>
                </div>
            </div>   
       
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="text-center">
                    
                            <p>grand total :<?php echo $grand_total ?></p>
                    </div>
                </div>
            </div>
            <div class="text-center" style="margin: 10px ;"> <a href="checkout.php" class="btn btnses <?php echo ($grand_total > 1)? '': 'disabled'; ?>">proceed to checkout</a></div>
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