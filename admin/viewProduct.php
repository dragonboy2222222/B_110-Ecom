<?php 
if(!isset($_SESSION)) {
    session_start();
}
require_once("dbconnect.php");
try {
    $sql="SELECT p.productID,p.productName,p.price,p.description,p.qty,p.imgPath,c.catName as category from product p, category c WHERE p.category =catId";
  $stmt = $conn->prepare($sql);
  $conn=$stmt->execute();
  $products=$stmt->fetchAll();
  
}
catch (PDOException $e) {
   echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navbarcopy.php";
            ?>
            <div class="row">
                <div class="col-md-3 py-5">
                   <a href="insertproduct.php" class="btn btn-outline-primary">New Product</a>


                </div>
                <div class="col-md-9 py-5">
                    <?php
                   if(isset($_SESSION['message'])) {
            echo "<p class='alert alert-success' style='width:500px'>{$_SESSION['message']}</p>";
          unset($_SESSION["message"]); // Clear after showing
          }
                    ?>

                    <table class="table table-striped">
                    <thead> 
                    <tr>
                        <td>Name</td>
                        <td>Category</td>
                        <td>price</td>
                        <td>quantity</td>
                        <td>description</td>
                        <td>image</td>
                    </tr>


                    </thead>
                    <tbody>
                    <?php
                    foreach($products as $product)
                    {$desc = substr($product['description'],0,30);
                      echo"<tr>
                        <td>$product[productName]</td>
                        <td>$product[category]</td>
                        <td>$product[price]</td>
                        <td>$product[qty]</td>
                        <td class='text=wrap'>$product[description]</td>
                        <td><img src=$product[imgPath] style=width:100px;</td>
                        <td><a href=insert.php class='btn btn-primary rounded pill'>Edit</a></td>
                        <td><a href=delete.php 'btn btn-danger rounded pill'>Delete</a></td>

                        </tr>";


                    }
                         

                    
                        

                    
                ?> 
                </tbody>
                    </table>
                    
                    

                </div>
            </div>

        </div>
    </div>
</body>

</html>