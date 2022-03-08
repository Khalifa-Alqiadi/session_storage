<?php
ob_start();
session_start();
// session_destroy();
// $pageTitle = 'HomePage';

include 'init.php';

if(isset($_GET['cart']) == 'add'){
    $id = $_GET['id'];
    if(isset($_SESSION['mycart'][$id])){
        $provi = $_SESSION['mycart'][$id]['quantity'];
        $_SESSION['mycart'][$id] = array(
            "itemid" => $id, 
            "name"=> $_POST['name'],
            "description"=> $_POST['descr'],
            "price"=> $_POST['price'],
            "images"=> $_POST['images'],
            "quantity" => $provi+$_POST['quantity']);
    }else{
        $_SESSION['mycart'][$id] = array(
            "itemid"=>$id,
            "name"=> $_POST['name'],
            "description"=> $_POST['descr'],
            "price"=> $_POST['price'],
            "images"=> $_POST['images'],
            "quantity"=> $_POST['quantity']
        );
    }
    header("location: index.php");
}
?>

<div class="container view-item">
    <h1 class="text-title">
        <?php
        if(isset($_SESSION['mycart'])){
            echo "<a href='cart.php'>" . count($_SESSION['mycart']) . "</a>";
        }else{
            echo 0;
        }
        ?>
    </h1>
    <a href="newad.php" class="btn btn-primary">Add</a>
    <div class="row row-cols-1 col-items row-cols-md-4 rwo-cols-sm-2">
        
        <?php  
        $query = "SELECT * FROM items";
        $result = mysqli_query($db, $query) or die (mysqli_error($db));
            while($item = mysqli_fetch_assoc($result)){
                
                ?>
                <form action="index.php?cart=add&id=<?php echo  $item['ItemID']?>" method="POST">
                    <input type="hidden" name="name" value="<?php echo  $item['Name']?>">
                    <input type="hidden" name="descr" value="<?php echo  $item['Description']?>">
                    <input type="hidden" name="price" value="<?php echo  $item['price']?>">
                    <input type="hidden" name="images" value="<?php echo  $item['images']?>">
                    <input type="hidden" name="quantity" value="1">
                    <div class="card">
                        <div class="card-header">
                            <span class='price-items'>$<?php echo  $item['price']?></span>
                            <div class='img-items'>
                                <?php echo "<img src='upload/images/" . $item['images'] ."' alt='' class='img-top'>";?>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3><a href='items.php?itemid=<?php echo $item['Item_ID']?>'> <?php echo $item['Name']?></a></h3>
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="submit" value="Add to cart" class="btn btn-danger">
                        </div>
                    </div>
                </form>
            <?php }?>
    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>