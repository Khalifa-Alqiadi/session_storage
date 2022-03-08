<?php
ob_start();
session_start();

// $pageTitle = 'HomePage';

include 'init.php';
?>

<div class="container view-item">
    <h1 class="text-title">
        <?php
        if(isset($_SESSION['mycart'])){
            echo count($_SESSION['mycart']);
        }else{
            echo 0;
        }
        ?>
    </h1>
    <div class="row">
        <?php
        foreach($_SESSION['mycart'] as $key => $value){?>
            <div class="card cart">
                <div class="card-header">
                    <span class='price-items'>$<?php echo @$value['quantity'] *  $value['price']?></span>
                    <div class='img-items'>
                        <?php echo "<img src='upload/images/" . $value['images'] ."' alt='' class='img-top'>";?>
                    </div>
                </div>
                <div class="card-body">
                    <h1><a href='#'> <?php echo $value['name']?></a></h1>
                    <p><?php echo $value['description']?></p>
                    <p>Quantity: <?php echo $value['quantity']?></p>
                    <a href="cart.php?do=e&id=<?php echo $value['itemid']?>>" class="btn btn-primary">Edit</a>
                </div>
                <div class="card-footer">
                <a href="?delete=<?php echo $key?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
            <?php 
            if(isset($_GET['do']) == 'id' ){?>
                <form class="form-horizontal main-form" action="cart.php?do=update&id=<?php echo $value['itemid'] ?>" method="POST" enctype="multipart/form-data">
                    <!-- Start Name Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Edit Quantity</label>
                        <div class="col-sm-10 col-md-10">
                            <input type="hidden" name="name" value="<?php echo  $value['name']?>">
                            <input type="hidden" name="descr" value="<?php echo  $value['description']?>">
                            <input type="hidden" name="price" value="<?php echo  $value['price']?>">
                            <input type="hidden" name="images" value="<?php echo  $value['images']?>">
                            <input class="form-control" type="text" name="quantity" value="<?php echo $value['quantity']?>">
                            <input type="submit" name="submit" value="edit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            <?php } ?>
        <?php }?>
    </div>
</div> 

<?php
if(isset($_GET['do']) == 'update'){
    $id = $_GET['id'];
    if(isset($_SESSION['mycart'][$id])){
        $provi = $_SESSION['mycart'][$id]['quantity'];
        if($_POST['quantity'] < $provi){
            $_SESSION['mycart'][$id] = array(
                "itemid" => $id, 
                "name"=> $_POST['name'],
                "description"=> $_POST['descr'],
                "price"=> $_POST['price'],
                "images"=> $_POST['images'],
                "quantity" => $provi-$_POST['quantity']);
                header("location: cart.php");
        }
        // header("location: cart.php");
    }
    
    
}elseif(isset($_GET['delete'])){
    $id = $_GET['delete'];
    unset($_SESSION['mycart'][$id]);
    header("location: cart.php");
}
include $tepl . 'footer.php';
ob_end_flush();
?>