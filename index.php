<?php
session_start();
require_once 'class/db3.class.php';
use DB\Database as Database;

require_once 'models/cart.php';

$c = new Cart();
$cart = $c->getitems(Database::getDb());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert into Database</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
    <div>
        <h1>Items</h1>
        <div class="merch-item-flex">
        <?php foreach($cart as $cart){ ?>
            <div class="merch-item">
                <form method="post" action="index.php?id=<?=$cart->productID?>">
                    <img class="item-img" width="100px" src="img/<?= $cart->image_file; ?>">
                    <hr>
                    <input type="hidden" name="id" value= "<?= $cart->productID?>">
                    <input type="hidden" name="name" value= "<?= $cart->productname?>">
                    <input type="hidden" name="price" value= "<?= $cart->price?>">
                    <h5><?= $cart->productname; ?></h5>
                    <h6>$<?=number_format($cart->price, 2); ?></h6>
                    <input type="number" name="quantity" value="1" class="form-control">
                    <input type="submit" name="add_to_cart" type="button" class="btn btn-primary" value="Add to Cart">
                </form>
            </div>
        <?php } ?>
        </div>
     
            <h2>Shopping Cart</h2>
           
            <?php 
            if(isset($_POST['add_to_cart'])) 
            {
                if(isset($_SESSION["shopping_cart"]))
                {
                    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                    if(!in_array($_POST["id"], $item_array_id)){ //maybe post? 
                        $count = count($_SESSION["shopping_cart"]);
                        $item_array = array (
                            'item_id' => $_GET["id"],
                            'item_name' => $_POST["name"],
                            'item_price' => $_POST["price"],
                            'item_quantity' => $_POST["quantity"],
                        );
                        $_SESSION["shopping_cart"][$count] = $item_array;

                    }
                    else {

                    }
                } 
                else {
                    $item_array = array(
                        'item_id' => $_GET["id"],
                        'item_name' => $_POST["name"],
                        'item_price' => $_POST["price"],
                        'item_quantity' => $_POST["quantity"],
                        
                    );
                    $_SESSION["shopping_cart"][0] = $item_array;
                }

                ?>
                <div>
                <table>
                    <tr>
                        <th width="40%">Item Name</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Price</th>
                        <th width="10%">Subtotal</th>
                        <th width="10%">ACTION</th>
                    </tr>
           <?php    
                if(!empty($_SESSION["shopping_cart"]))
                {
                    $total = 0;
                    foreach($_SESSION["shopping_cart"] as $keys => $values)
                    {
                        $subtotal = $values["item_price"] * $values["item_quantity"];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $values["item_name"]; ?></td>
                            <td><?php echo $values["item_quantity"]; ?></td>
                            <td><?php echo $values["item_price"]; ?></td>
                            <td><?php echo $subtotal; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <div>TOTAL COST: <?=$total * 1.13?></div>
                    <?php
                }
           
        } ?>
        <a href="checkout.php"><button>Checkout</button></a>
        <a href="?emptycart"><button>Empty Cart</button></a>

        <?php   if(isset($_GET['emptycart'])) {
                session_unset();

                header('Location:index.php');
                }

           
                               

            
             
            ?>

        </div>

        