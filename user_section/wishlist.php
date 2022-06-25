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
        
       
       /* if(isset($_POST['add_to_wishlist'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            $user_id  = $id;
            $pid = $_POST['id'];
            $image = $_POST['image'];
        
            $insert_to_cart = $db->prepare("INSERT INTO `wishlist` (user_id,pid,name,price,image) VALUES(?,?,?,?,?)");
            $insert_to_cart->execute([$user_id,$pid,$name,$price,$image]);
            $error[] = 'add to cart success';
        }*/

        if(isset($_POST['delete_to_wishlist'])){
            $pid = $_POST['id'];
            $delete = $db->prepare("DELETE FROM `wishlist` WHERE id = ?");
            $delete->execute([$pid]);
            $error[] = 'remove form cart success';
        }
        if(isset($_POST['add_to_cart'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            $user_id  = $id;
            $pid = $_POST['id'];
            $image = $_POST['image'];
            $quantity = 1;

            
            $check_cart_numbers = $db->prepare("SELECT * FROM cart WHERE name = ? AND user_id = ?");
            $check_cart_numbers->execute([$name, $user_id]);
    
            
            if($check_cart_numbers->rowCount() > 0) {
                $message[] = 'already added to cart';
            }else{
                $check_wishlist_numbers = $db->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
                $check_wishlist_numbers->execute([$name, $user_id]);
        
            if($check_wishlist_numbers->rowCount() > 0){ 
                $delete_wishlist = $db->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
                $delete_wishlist->execute([$name, $user_id]);
            }
                $insert_cart = $db->prepare("INSERT INTO cart (user_id, pid, name, price, quantity, image) VALUES(?, ?, ?, ?, ?, ?)");
                $insert_cart->execute([$user_id, $pid, $name, $price, $quantity, $image]);
                $message[] = 'added to cart';
            }
        }
        /*if(isset($_POST['add_to_cart'])){
            $name = $_POST['name'];
            $price = $_POST['price'];
            $user_id  = $id;
            $pid = $_POST['id'];
            $image = $_POST['image'];
            $quantity = 1;

            $select_wishlist = $db->prepare("SELECT * FROM `wishlist` WHERE pid = ?");
            $select_wishlist->execute([$pid]);
            $delete_wishlist = $db->prepare("DELETE FROM `wishlist` WHERE name = ? pid = ? ");
            $select_wishlist->execute([$name,$pid]);
            $insert_to_cart = $db->prepare("INSERT INTO `cart` (user_id,pid,name,price,quantity) VALUES(?,?,?,?,?)");
            $insert_to_cart->execute([$user_id,$pid,$name,$price,$quantity]);
            $error[] = 'add to cart success';
        }
            */

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="styles.css" rel="stylesheet" />
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
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                    <?php 
                        $select = $db->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                        $select->execute([$id]);
                        if($select->rowCount() > 0){
                        while($row = $select->fetch(PDO::FETCH_ASSOC)){
                    ?>
                   
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
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                   <p name="price"> $<?php echo $row['price']?></p>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div  class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <form action="" method="post">
                                    <div class="text-center" style="margin: 10px ;"><button name="add_to_cart" class="btn btn-outline-dark mt-auto" href="#">Add to cart</button></div>
                                    <div class="text-center"><button name="delete_to_wishlist" class="btn btn-outline-dark mt-auto" href="#">delete to whishlist</button></div>
                                </form>
                            </div>
                        </div>
                   </form>
                    </div>
                        <?php }
                            }
                            else{
                        ?>
                        <p style="color: red;text-align:center;">no product in wishlist</p>
                        <?php
                            }  
                            ?>
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