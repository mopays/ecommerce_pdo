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
            $delete_user = $db->prepare("DELETE FROM `message` WHERE id = ?");
            $delete_user->execute([$user_id]);
            #unlink('upload_image/'.$old_image);
            $error[] = 'delete success';
            header('refresh:1;messages.php');
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
        <h1>user manager</h1>
        <?php 
            $select_message = $db->prepare("SELECT * FROM `message`");
            $select_message->execute();
            if($select_message->rowCount() > 0){
            while($row = $select_message->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="w3-container user_m" >
            <div class="w3-panel w3-card cds">
                <h2><?php echo $row['name']?></h2>
                <p>email : <?php echo $row['email']?></p>
                
                <p>number : <?php echo $row['number']?></p>
                <p >message : <?php echo $row['message']?></p>
                    <a href="?delete=<?php echo $row['id'];?>" class="btn btn-danger">delete</a>
            </div>
           
            </div>
            <?php
             } 
            }else{ 
                echo '<p style="text-align:center; color:red;font-size:50px; margin-top:40px;">no orders</p>';
            }
        ?>
      </section>
  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>
<?php } ?>
