<?php
require_once("dbconnect.php");

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['eid'])) {
   $productId = $_GET['eid'];
   try{ 
    $sql = '';
      
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
?>
