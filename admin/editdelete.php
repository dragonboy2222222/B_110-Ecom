<?php
require_once("dbconnect.php");
 try {  
     $sql ="select * from category";
     $stmt=$conn-> prepare($sql);
     $stmt->execute();
     $categories =$stmt->fetchAll(PDO::FETCH_ASSOC);
 }
 catch (PDOException $e) { 

    echo  $e->getMessage();
 }

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['eid'])) {
   $productId = $_GET['eid'];
   try{ 
    $sql = "SELECT p.productId, p.productName,c.catName,p.category,p.price,p.description,p.qty,p.imgPath FROM product p,category c where p.category =c.catID AND p.productId= ?";
      $statement= $conn->prepare($sql); 
      $statement->execute([$productId]);
      $product=$statement->fetch();
      $_SESSION["product"] = $product;

   }
   catch(PDOException $e){
} 

}
else if (isset($_GET['did'])) {
    try {
        $productId = $_GET['did'];
        $sql = 'DELETE FROM product WHERE productId = ?';  // fixed typo here
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$productId]);

        if ($status) {
            $_SESSION['message'] = "Product ID $productId has been deleted";
            header("Location: viewProduct.php");
            exit();  // Important: stop further execution after redirect
        } else {
            $message = "Failed to delete product ID $productId";
            echo $message;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    

}

else if (isset($_POST['updateBtn'])) {
    $pid = $_POST['pid'];
    $productName = $_POST['pname'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];   
    $quantity = $_POST['quantity'];
    $filesImage = $_FILES["file"];

    $status = false; // Default to false

    if (!empty($filesImage['name'])) {
        $filePath = "productimage/" . basename($filesImage['name']);
        $status = move_uploaded_file($filesImage['tmp_name'], $filePath);
    } else {
        // If no new file uploaded, keep old image path
        $filePath = $_SESSION["product"]["imgPath"];
        $status = true; // Allow update even if no new file
    }

    if ($status) { $_SESSION['updateMessage']="Product with product id $pid is updated!!!";
        try {
            $sql = "UPDATE product 
                    SET productName = ?, 
                        category = ?, 
                        price = ?, 
                        description = ?, 
                        qty = ?, 
                        imgPath = ?
                    WHERE productId = ?";
            $stmt = $conn->prepare($sql);
            $updateStatus = $stmt->execute([$productName, $category, $price, $description, $quantity, $filePath, $pid]);

            if ($updateStatus) {
                echo "Update success";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}


    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid">

    <div class="row">
        <?php require_once "navbarcopy.php" ?>

    </div>

    <div class="row">
        <div class="col-md-2">



        </div>

        <div class="col-md-10 p-3">
        <div class="row my-5">
            <form action="editDelete.php" class="form card p-4" method="post" enctype="multipart/form-data">
                <input type="hidden"  name="pid" value="<?php echo $product['productId']  ?>">
            
            <div class="row mb-3">
                <div class="col-md-6">

                      <div class="mb-2">
                        <label for="pname" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="pname" value="<?php if(isset($product)){echo $product['productName'];}?>">
                      </div>

                       <div class="mb-2">

                        <p class="alert alert-info"><?php echo "Previous selected category $product[catName]";?></p>
                        <select name="category" id="category" class="form-select">
                            <option value="">Choose Category</option>
                           <?php
                                if(isset($categories))

                                    {
                                        foreach($categories as $category)
                                        {
                                            echo "<option value=$category[catId]>$category[catName] </option>";
                                        }
                                    }

                            ?>
                        </select>        
                      </div>

                       <div class="mb-2">
                            <label for="price" class="form-label">Price</label> 
                            <input type="number" id="price" class="form-control" name="price" value="<?php if(isset($product)){echo $product['productName'];}?>">   
                       </div>



                </div>

                <div class="col-md-6">

                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label> 
                           <textarea name="description" id="description" class="form-control" placeholder="write description here"></textarea>
                            
                       </div>

                         <div class="mb-2">
                            <label for="quantity" class="form-label">Quantity</label> 
                            <input type="number" class="form-control" name="quantity" id="quantity" value="<?php if(isset($product)){echo $product['productName'];}?>">   
                        </div>

                        <div class="mb-2">
                           <?php if (isset($product)) {
    echo "<img src='{$product['imgPath']}' class='img-responsive' style='width:150px; height:auto; object-fit:contain;' alt='Product Image'>";
} ?>
                           <label for="file" class="form-label">Product Image</label> 
                            <input type="file" class="form-control" name="file" id="img" >   

                        </div>

                        <div class="mb-2">
                         <button type="submit" class="btn btn-primary" name="updateBtn">Update</button>

                        </div>



                </div>
                </div>
            </form>

        </div>

        </div>

    </div>




    </div>







</body>
</html>