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

     
        if(isset($_REQUEST['update'])){
            $id = $_REQUEST['update'];
            $select = $db->prepare("SELECT * FROM `product` WHERE id = ?");
            $select->execute([$id]);
            $row = $select->fetch(PDO::FETCH_ASSOC);
        }

        if(isset($_POST['update_product'])){
            $new_product_name = $_POST['new_product_name'];
            $new_details = $_POST['new_details'];
            $new_category = $_POST['new_category'];
            $new_price = $_POST['new_price'];
            $old_image = $_POST['old_image'];

            $new_image = $_FILES['new_image']['name'];
            $image_size = $_FILES['new_image']['size'];
            $image_tmp_name = $_FILES['new_image']['tmp_name'];
            $image_folder = 'upload_image/'. $new_image;
            

            if(empty($new_product_name)){
                $error[] = 'please enter product name';
            }else if(empty($new_details)){
                $error[] = 'please enter product details';
            }else if(empty($new_category)){
                $error[] = 'please enter product category';
            }else if(empty($new_price)){
                $error[] = 'please enter product price';
            }else{
                $insert = $db->prepare("UPDATE `product` SET name = ?, category = ? ,details = ?, price = ? ,image = ? WHERE id = ?");
                $insert->execute([$new_product_name, $new_category, $new_details, $new_price, $new_image, $id]);
                if($insert){
                    if($image_size > 20000000){
                        $error[] = 'image size is to large';
                    }else{
                        if(move_uploaded_file($image_tmp_name , $image_folder)){
                            unlink('upload_image/'.$old_image);
                            header('refresh:1;product.php');
                            $message[] = 'update image success';
                        }
                    }
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
                <input type="file" class="form-control" name="new_image" id="" placeholder="change images">
                
                <input type="hidden"  name="old_image" value="<?php echo $row['image']?>">
            </div>
            <div class="mb-3"style="text-align:center;" >
                <img src="upload_image/<?php echo $row['image']?>" alt="">
            </div>
            <div class="mb-3">
                <label  class="form-label">product name</label>
                <input type="text" class="form-control" name="new_product_name" placeholder="<?php echo $row['name']?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">details</label>
                <textarea type="text" class="form-control" name="new_details" placeholder="<?php echo $row['category']?>"></textarea>
            </div>
            <div class="mb-3">
                <label  class="form-label">category</label>
                <input type="text" class="form-control" name="new_category" placeholder="<?php echo $row['category']?>">
            </div>
            <div class="mb-3">
                <label  class="form-label">price</label>
                <input type="number" min="0" max="99999" class="form-control" name="new_price" placeholder="<?php echo $row['price']?>">
            </div>
            <button type="submit" name="update_product" class="btn btn-success">edit product</button>
            <a href="product.php" class="btn btn-info">back to product</a>
        </form>
        </section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
<?php } ?>