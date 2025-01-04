<?php include 'db_config.php'; ?> 
<!DOCTYPE html>
<html>
<head>
  <title>Manage Store</title>
  <style>
    /* CSS styles for the cards container and individual cards */
    .cards-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive columns */
      grid-gap: 20px;
    }
    .card {
      border: 1px solid #ccc;
      padding: 20px;
    }
    .card-section {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<h2>Manage Store</h2>

<div class="cards-container"> 
  <?php
  try {
    // Fetch data from the 'manage_store' table
    $stmt = $conn->query("SELECT * FROM manage_store");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="card"> 
        <div class="card-section">
          <p>Store Branch</p> 
        </div>
        <div class="card-section">
          <p><strong>Store Name:</strong> <?php echo $row['store_name']; ?></p>
          <p><strong>Street Address:</strong> <?php echo $row['street_address']; ?></p>
          <p><strong>City:</strong> <?php echo $row['city']; ?></p>
          <p><strong>Postcode:</strong> <?php echo $row['postcode']; ?></p>
          <p><strong>Country:</strong> <?php echo $row['country']; ?></p>
        </div>
      </div>
      <?php
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null; 
  ?>
</div>

</body>
</html>