<?php

// session_start();

// $pageTitle = 'Create New Item';

include 'init.php';

// if(isset($_SESSION['user'])){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Upload Variable
                    
        $imagesName = $_FILES['images']['name'];
        $imagesType = $_FILES['images']['type'];
        $imagesSize = $_FILES['images']['size'];
        $imagesTmp  = $_FILES['images']['tmp_name'];

        // List Of Allowed File Typed To Upload

        $imagesAllowedExtension = array("jpeg", "jpg", "png", "gif");

        // Get Avatar Extension

        @$imagesExtension = strtolower(end(explode('.', $imagesName)));

        $formErrors = array();

        $name      = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);

        if(strlen($name) < 4){
            $formErrors[] = 'Item Name Must Be At Least 4 Characters';
        }
        if(strlen($desc) < 10){
            $formErrors[] = 'Item Description Must Be At Least 4 Characters';
        }
        if(empty($price)){
            $formErrors[] = 'Item Price Must Be Not Empty';
        }
        if(! empty($imagesName) && ! in_array($imagesExtension, $imagesAllowedExtension)){
            $formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
        }
        if(empty($imagesName)){
            $formErrors[] = 'images Is <strong>Required</strong>';
        }
        if($imagesSize > 4194304){
            $formErrors[] = 'images Cant Be Larger Than <strong>4MB</strong>';
        }

        if(empty($formErrors)){
            $images = rand(0, 100000) . '_' . $imagesName;
            move_uploaded_file($imagesTmp, "upload\images\\" . $images);

            $query = "INSERT INTO items
					    VALUES (NULL,'".$name."','".$desc."', '".$price."', '".$images."')";
			mysqli_query($db,$query)or die(mysqli_error($db));

            if($query){
                $successMas = "Item Added";
            }

        }

    }

?>
    <h1 class="text-center">Add</h1>
    <div class="information block">
        <div class="container ">
            <div class="card">
                <div class="card-header bg-primary text-white">Add Product</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                                <!-- Start Name Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live"
                                            type="text" 
                                            name="name"  
                                            placeholder="Name Of The Item"
                                            required>
                                    </div>
                                </div>
                                <!-- End Name Field -->
                                <!-- Start Description Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control" 
                                            type="text" 
                                            name="description" 
                                            placeholder="Description of The Item"
                                            required>
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Price Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control" 
                                            type="text" 
                                            name="price" 
                                            placeholder="Price of The Item"
                                            required>
                                    </div>
                                </div>
                                <!-- End Price Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Images</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input
                                            class="form-control" 
                                            type="file"
                                            name="images">
                                    </div>
                                </div>
                                <!-- End Tags Field -->
                                <!-- Start Submit Field -->
                                <div class="mb-2 row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="submit" value="Add Item" class="btn btn-primary">
                                    </div>
                                </div>
                                <!-- End Submit Field -->
                            </form>
                        </div>
                        
                    </div>
                    <!-- Start Looping Through Errors -->
                    <?php 
                        if(! empty($formErrors)){
                            foreach($formErrors as $error){

                                echo "<div class='alert alert-danger'>" . $error . "</div>";
                            }
                        }

                        if(isset($successMas)){

                            echo "<div class='alert alert-success'>" . $successMas . "</div>";
        
                        }
                    ?>
                    <!-- End Looping Through Errors -->
                </div>
            </div>
        </div>
    </div>

<?php
// }else{

//     header('Location: login.php');

//     exit();

// }

include $tepl . 'footer.php';

ob_end_flush();
?>