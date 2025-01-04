<?php
include 'db_config.php';

// Function to generate a random invoice number
function generateInvoiceNumber()
{
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $invoiceNumber = '';
  for ($i = 0; $i < 10; $i++) {
    $invoiceNumber .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $invoiceNumber;
}

// Check if a product was just added
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    // Your existing code for handling product addition (from products.php)
    $target_dir = "uploads/"; // Create an "uploads" folder in the same directory
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if ($check !== false) {
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        // Determine availability based on quantity
        $quantity = $_POST['quantity'];
        if ($quantity > 10) {
          $availability = "In Stock";
        } elseif ($quantity >= 1 && $quantity <= 10) {
          $availability = "Low Quantity";
        } else {
          $availability = "Out of Stock";
        }

        // Insert product data into the database
        $stmt = $conn->prepare("INSERT INTO products (image_path, name, quantity, threshold_value, expiry_date, availability) 
                                VALUES (:image_path, :name, :quantity, :threshold_value, :expiry_date, :availability)");
        $stmt->bindParam(':image_path', $target_file);
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':quantity', $_POST['quantity']);
        $stmt->bindParam(':threshold_value', $_POST['threshold_value']);
        $stmt->bindParam(':expiry_date', $_POST['expiry_date']);
        $stmt->bindParam(':availability', $availability);
        $stmt->execute();
        echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }

    // Get the last inserted product ID
    $productId = $conn->lastInsertId();

    // Fetch the added product details from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $productId);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Generate invoice number
    $invoiceNumber = generateInvoiceNumber();

    // Calculate total (order value * quantity) - Assuming you have an 'order_value' column in your table
    $total = $product['order_value'] * $product['quantity'];

    // Display the invoice
?>
    <!DOCTYPE html>
    <html>

    <head>
      <title>Invoice</title>
      <style>
        /* Add your CSS styles for the invoice here */
        body {
          font-family: sans-serif;
        }

        .invoice-container {
          width: 800px;
          margin: 0 auto;
          padding: 20px;
          border: 1px solid #ccc;
        }

        .invoice-header {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 20px;
        }

        .invoice-details {
          margin-bottom: 20px;
        }

        .invoice-table {
          width: 100%;
          border-collapse: collapse;
          margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
          border: 1px solid #ccc;
          padding: 10px;
          text-align: left;
        }

        .invoice-summary {
          text-align: right;
        }

        .invoice-footer {
          margin-top: 20px;
          text-align: center;
          font-size: 12px;
        }
      </style>
    </head>

    <body>
      <div class="invoice-container">
        <div class="invoice-header">
          <div class="company-info">
            <h2>QuickBuy Ltd.</h2>
            <p>The Business Centre</p>
            <p>456 Enterprise Way</p>
            <p>Manchester, M2 5WP</p>
            <p>Tax ID/VAT Number: GB123456789</p>
          </div>
          <div class="invoice-number">
            <h1>Invoice</h1>
            <p><?php echo $invoiceNumber; ?></p>
          </div>
        </div>
        <div class="invoice-details">
          <p><strong>Billed to:</strong></p>
          <p>QuickBuy - Manchester Store</p>
          <p>123 High Street</p>
          <p>Manchester, M1 4SD</p>
          <p>United Kingdom</p>
        </div>
        <table class="invoice-table">
          <thead>
            <tr>
              <th>Description</th>
              <th>Qty</th>
              <th>Rate</th>
              <th>Line Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $product['name']; ?></td>
              <td><?php echo $product['quantity']; ?></td>
              <td><?php echo $product['order_value']; ?></td>
              <td><?php echo $product['quantity'] * $product['order_value']; ?></td>
            </tr>
          </tbody>
        </table>
        <div class="invoice-summary">
          <p><strong>Total due: UKE <?php echo number_format($total, 2); ?></strong></p>
        </div>
        <div class="invoice-footer">
          <p>ⓘ Please pay within 15 days of receiving this invoice.</p>
          <p>www.QuickBuy.co.uk</p>
          <p>+44 00000 00000</p>
          <p>QuickBuyGmail.com</p>
        </div>
      </div>
    </body>

    </html>
<?php
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>