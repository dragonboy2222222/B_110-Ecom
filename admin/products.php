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


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: #f4f7fc; /* soft background */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      margin-top: 40px;
    }

    label {
      font-weight: 600;
      color: #0a1d37;
    }

    .form-select,
    .form-control {
      border-radius: 10px;
    }

    .form-select:focus,
    .form-control:focus {
      border-color: #0a1d37;
      box-shadow: 0 0 5px rgba(10, 29, 55, 0.5);
    }

    .btn-navy {
      background-color: #0a1d37;
      color: white;
      border-radius: 10px;
    }

    .btn-navy:hover {
      background-color: #0d2a4d;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php require("navbarcopy.php"); ?>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6 form-container">
        <h4 class="text-center mb-4 text-primary">Add New Product</h4>
        <form class="form" action="products.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="pname" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="pname" id="pname" required />
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" name="price" id="price" required />
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-select" required>
              <option value="">Choose</option>
              <?php
              if (isset($categories)) {
                  foreach ($categories as $category) {
                      echo "<option value={$category['catId']}>{$category['catName']}</option>";
                  }
              }
              ?>
            </select>
          </div>

          <button type="submit" class="btn btn-navy w-100">Submit Product</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>