<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="shops.php">logo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link " aria-current="page" href="shops.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="user.php">user</a></li>
                        <li class="nav-item"><a class="nav-link" href="message.php">message</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link " href="shops.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="cart.php">
                    <?php
                         $count_cart_items = $db->prepare("SELECT * FROM cart WHERE user_id = ?");
                         $count_cart_items->execute([$id]);
                         $count_whishlist_items = $db->prepare("SELECT * FROM wishlist WHERE user_id = ?");
                         $count_whishlist_items->execute([$id]);
                    ?>
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $count_cart_items->rowCount(); ?></span>
                        </button>
                    </form>
                   
                    <a style="margin:0 10px;"href="wishlist.php" class="btn btn-success">wishlist(<?php echo $count_whishlist_items->rowCount(); ?>)</a>
                    <a style="margin:0 10px;"href="../logout.php" class="btn btn-danger">log out</a>
                </div>
            </div>
        </nav>