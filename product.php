<?php 
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

            if(isset($_POST['add_product'])){
                $name = $_POST['product_name'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                $details = $_POST['details'];

                $image = $_FILES['image']['name'];
                $image_size = $_FILES['image']['size'];
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_folder = 'upload_image/'. $image;

                if($name == $row['name']){
                    $error[] = 'name is already exits';
                }else{
                    $insert = $db->prepare("INSERT INTO `product`(name, category, details, price, image) VALUES(?,?,?,?,?)");
                    $insert->execute([$name, $category, $details, $price, $image]);
                    if($insert){
                        if($image_size > 20000000){
                            $error[] = 'image size is to large';
                        }else{
                            $insertMsg[] = 'insert product success';
                            move_uploaded_file($image_tmp_name, $image_folder);
                            header('refresh:1;');
                        }
                    }
                }
            }
            if(isset($_REQUEST['delete'])){
                $id = $_REQUEST['delete'];
                $delete_id = $db->prepare("DELETE FROM `product` WHERE id = ?");
                $delete_id->execute([$id]);
                    header("refresh:1;product.php");
                    $insertMsg[] = 'delete product success';
                
                
            }

?>
<!DOCTYPE html>
<html lang="en">
<head> œ
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>product</title>
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
            if(isset($insertMsg)){
                foreach($insertMsg as $insertMsg){
        ?>
        <div class="alert alert-success" role="alert">
            <?php echo $insertMsg?>
        </div>
        <?php 
                }
            }
        ?>
        <section class="products">
        <form enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label class="form-label">image</label>
                <input type="file" class="form-control" name="image" placeholder="please enter image">
            </div>
            <div class="mb-3">
                <label  class="form-label">product name</label>
                <input type="text" class="form-control" name="product_name" placeholder="please enter product name">
            </div>
            <div class="mb-3">
                <label  class="form-label">details</label>
                <textarea type="text" class="form-control" name="details" placeholder="please enter product title"></textarea>
            </div>
            <div class="mb-3">
                <label  class="form-label">category</label>
                <input type="text" class="form-control" name="category" placeholder="please enter category name">
            </div>
            <div class="mb-3">
                <label  class="form-label">price</label>
                <input type="number" min="0" max="99999" class="form-control" name="price" placeholder="place enter product price">
            </div>
            <button type="submit" name="add_product" class="btn btn-success">add product</button>
        </form>
        </section>


        <section class="productadded" style="margin-top: 30px;">
            <?php 
                $select_product = $db->prepare("SELECT * FROM `product`");
                $select_product->execute();
                
                while($row = $select_product->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="cards">
                <div class="card" style="width: 18rem;">
                    <img src="upload_image/<?php echo  $row['image']?>" class="card-img-top" alt="...">
                   <form action="" method="post">
                        <input type="hidden"  name="old_image" value="<?php echo $row['image']?>">
                   </form>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['category']?></h5>
                        <p class="card-text"><?php echo $row['details']?></p>
                        <p class="card-text"><?php echo $row['price']?></p>
                        <a href="?delete=<?php echo $row['id']?>" class="btn btn-danger">delete</a>
                        <a href="update_product.php?update=<?php echo $row['id']?>" class="btn btn-warning">Edit</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
        

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
<?php } ?>