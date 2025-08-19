
<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "dbconnect.php";

 try{
        $sql = "select * from category";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();
    }catch(PDOException $e)
    {
        echo "". $e->getMessage();
    }

try {
    $sql = "SELECT p.productId, p.productName, 
                   p.price, p.description, p.qty, 
                   p.imgPath, c.catName AS category
            FROM product p
            JOIN category c ON p.category = c.catId";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch (Exception $e) {
    echo $e->getMessage();
}

if(isset($_GET['bsearch']))
{$text = $_GET['tsearch'];
   try{
        $sql="SELECT p.productId, p.productName, 
                    p.price, p.description, p.qty, 
                    p.imgPath, c.catName AS category
                    FROM product p
                    JOIN category c ON p.category = c.catId and
                    p.productName like?";
        $stmt=$conn->prepare($sql);
        $stmt->execute(["%".$text."%"]);
        $products=$stmt->fetchAll();
   }catch(PDOException $e){
    echo $e->getMessage();
   }
}
else if(isset($_GET['csearch'])){
    $cid=$_GET['category'];
    try{
        $sql="SELECT p.productId, p.productName, 
                    p.price, p.description, p.qty, 
                    p.imgPath, c.catName AS category
                    FROM product p
                    JOIN category c ON p.category = c.catId and
                    c.catId=?";
        $stmt=$conn->prepare($sql);
        $stmt->execute([$cid]);
        $products=$stmt->fetchAll();
   }catch(PDOException $e){
    echo $e->getMessage();
   }


}

else if(isset($_POST['radioBtn']))
{
    $price= $_POST['price'];
    if($price=='first')
    {
     $lower =200;
     $upper=300;

    }
    else if($price='second')
    {
    $lower =301;
    $upper =500;
    }
    try{
       $sql ="SELECT p.productId,p.productName,p.price,p.description,p.qty,p.imgPath,c.catName as category FROM product p,category c where p.price BETWEEN ? and ? and c.catId=p.category";
       $stmt =$conn->prepare($sql);
       $stmt->execute([$lower,$upper]);
       $products= $stmt->fetchAll();

    }
    catch(PDOException $e)
    {
           echo $e ->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- Navbar -->
        <div class="row">
            <?php require_once "navbarcopy.php"; ?>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 py-5 px-4">
                <a href="insertProduct.php" class="btn btn-outline-primary w-100 mb-3">New Product</a>
                
                <!-- Category Search -->
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="get" action="viewProduct.php">
                            <select name="category" class="form-select mb-2">
                                <?php
                                foreach($categories as $category){
                                    echo "<option value='{$category['catId']}'>{$category['catName']}</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" name="csearch" class="btn btn-outline-primary w-100 rounded-pill">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card mb-3">
                    <form class="form" action="" method="post">
                    <div class="form-check">
                     <input type="radio" name="price" value="first" class="form-check-input">
                     <label for="" class="form-check-label">$200-$300</label>

                            </div>
                    <div class="form-check">
                     <input type="radio" name="price" value="second" class="form-check-input">
                     <label for="" class="form-check-label">$301-$500</label>

                            </div>

                        <div class="mb-2">
                            <button name="radioBtn" class="btn btn-outline-primary rounded-pill">Search</button>
                        </div>


                      </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 py-5">
                <?php
                // Flash messages
                if (isset($_SESSION["message"])) {
                    echo "<p class='alert alert-success'>{$_SESSION["message"]}</p>";
                    unset($_SESSION["message"]);
                } else if (isset($_SESSION["deleteSuccess"])) {
                    echo "<p class='alert alert-success'>{$_SESSION["deleteSuccess"]}</p>";
                    unset($_SESSION["deleteSuccess"]);
                } else if (isset($_SESSION['updateMessage'])) {
                    echo "<p class='alert alert-success'>{$_SESSION['updateMessage']}</p>";
                    unset($_SESSION['updateMessage']);
                }
                ?>

                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (!empty($products)) {
                                foreach ($products as $product) {
                                    echo "<tr>
                                        <td>{$product['productName']}</td>
                                        <td>{$product['category']}</td>
                                        <td>{$product['price']}</td>
                                        <td>{$product['qty']}</td>
                                        <td style='max-width:200px; word-wrap:break-word;'>{$product['description']}</td>
                                        <td><img src='{$product['imgPath']}' style='width:80px;height:80px;' class='img-thumbnail'></td>
                                        <td><a href='editDelete.php?eid={$product['productId']}' class='btn btn-sm btn-primary'>Edit</a></td>
                                        <td><a href='editDelete.php?did={$product['productId']}' class='btn btn-sm btn-danger'>Delete</a></td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No products found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- End Main Content -->
        </div> <!-- End Content Row -->
    </div> <!-- End Container -->
</body>
</html>
