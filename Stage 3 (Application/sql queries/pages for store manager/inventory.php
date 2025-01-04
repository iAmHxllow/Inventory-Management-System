<!-- make sure to establish a databse connection to phpmyadmin and change the db_config.php to whatever your connection page is named-->
<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Product Management</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    img {
      max-width: 100px;
      max-height: 100px;
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      grid-gap: 20px;
      margin-bottom: 20px;
    }
    .stat-card {
      border: 1px solid #ccc;
      padding: 20px;
      text-align: center;
    }
    /* Popup form styles */
    .popup {
      display: none; 
      position: fixed; 
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid #ccc;
      padding: 20px;
      background-color: white;
      z-index: 100; 
    }
    .popup-overlay {
      display: none; 
      position: fixed; 
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); 
      z-index: 99; 
    }
    .pagination {
      margin-top: 20px;
      text-align: center;
    }
  </style>
</head>
<body>

<h2>Product Management</h2>

<form action="products.php" method="get">
  <input type="text" name="search" placeholder="Search by name...">
  <button type="submit">Search</button>
</form>

<div class="stats-grid">
  <div class="stat-card">
    <h3>Total Products</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT COUNT(*) FROM products");
      $totalProducts = $stmt->fetchColumn();
      echo "<p>" . $totalProducts . "</p>";
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
  <div class="stat-card">
    <h3>Last Added Product</h3>
    <?php
    try {
      $stmt = $conn->query("SELECT created_at FROM products ORDER BY created_at DESC LIMIT 1");
      $lastAddedDate = $stmt->fetchColumn();

      if ($lastAddedDate) {
        $dateDiff = date_diff(new DateTime($lastAddedDate), new DateTime());
        $daysAgo = $dateDiff->days;
        $lastAdded = ($daysAgo == 0) ? "Today" : $daysAgo . " day(s) ago";
        echo "<p>" . $lastAdded . "</p>";
      } else {
        echo "<p>No products added yet</p>";
      }
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    ?>
  </div>
</div>

<button id="addProductBtn">Add Product</button>
<button id="filterBtn">Filter</button> 
<button id="downloadBtn">Download All</button>

<div id="filterOptions" style="display: none;"> 
  <label for="filterName">Name:</label>
  <input type="text" id="filterName"><br><br>
  <label for="filterAvailability">Availability:</label>
  <select id="filterAvailability">
    <option value="">All</option>
    <option value="In Stock">In Stock</option>
    <option value="Low Quantity">Low Quantity</option>
    <option value="Out of Stock">Out of Stock</option>
  </select><br><br>
  <button onclick="applyFilters()">Apply Filters</button>
</div>

<div class="popup-overlay" id="popupOverlay"></div>

<div class="popup" id="addProductPopup">
  <form action="products.php" method="post" enctype="multipart/form-data">
    <label for="image">Image:</label>
    <input type="file" name="image" required><br><br>
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>
    <label for="buying_price">Buying Price:</label>
    <input type="number" name="buying_price" step="0.01" required><br><br>
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required><br><br>
    <label for="threshold_value">Threshold Value:</label>
    <input type="number" name="threshold_value" required><br><br>
    <label for="expiry_date">Expiry Date:</label>
    <input type="date" name="expiry_date" required><br><br>
    <input type="submit" value="Submit"> 
  </form>
  <button onclick="closePopup()">Close</button> 
</div>

<h2>Products</h2>

<table id="productTable">
  <tr>
    <th>Image</th> 
    <th>Name</th>
    <th>Buying Price</th>
    <th>Quantity</th>
    <th>Threshold Value</th>
    <th>Expiry Date</th>
    <th>Availability</th> 
  </tr>
  <?php
  // Handle product addition 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
      // Image upload and validation
      $target_dir = "uploads/";  // Create an "uploads" folder in the same directory
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
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
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
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
          $stmt = $conn->prepare("INSERT INTO products (image_path, name, buying_price, quantity, threshold_value, expiry_date, availability) 
                                  VALUES (:image_path, :name, :buying_price, :quantity, :threshold_value, :expiry_date, :availability)");
          $stmt->bindParam(':image_path', $target_file);
          $stmt->bindParam(':name', $_POST['name']);
          $stmt->bindParam(':buying_price', $_POST['buying_price']);
          $stmt->bindParam(':quantity', $_POST['quantity']);
          $stmt->bindParam(':threshold_value', $_POST['threshold_value']);
          $stmt->bindParam(':expiry_date', $_POST['expiry_date']);
          $stmt->bindParam(':availability', $availability);
          $stmt->execute();
          echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }

    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }

  // Fetch and display products
  try {
    // Search functionality
    if (isset($_GET['search'])) {
      $search = $_GET['search'];
      $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :search");
      $stmt->bindValue(':search', '%' . $search . '%');
      $stmt->execute();
    } else {
      $stmt = $conn->query("SELECT * FROM products");
    }


    // Display product data in the table
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td><img src='" . $row['image_path'] . "' alt='" . $row['name'] . "'></td>";
      echo "<td>" . $row['name'] . "</td>";
      echo "<td>" . $row['buying_price'] . "</td>";
      echo "<td>" . $row['quantity'] . "</td>";
      echo "<td>" . $row['threshold_value'] . "</td>";
      echo "<td>" . $row['expiry_date'] . "</td>";
      echo "<td>" . $row['availability'] . "</td>";
      echo "</tr>";
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null; 
  ?>
</table>

<div class="pagination">
  <button id="prevBtn" disabled>Previous</button>
  <button id="nextBtn">Next</button>
</div>

<script>
  // Get references to the button, popup, and overlay
  const addProductBtn = document.getElementById('addProductBtn');
  const addProductPopup = document.getElementById('addProductPopup');
  const popupOverlay = document.getElementById('popupOverlay');

  // Show popup when the "Add Product" button is clicked
  addProductBtn.addEventListener('click', () => {
    addProductPopup.style.display = 'block';
    popupOverlay.style.display = 'block';
  });

  // Function to close the popup
  function closePopup() {
    addProductPopup.style.display = 'none';
    popupOverlay.style.display = 'none';
  }

  const filterBtn = document.getElementById('filterBtn');
  const filterOptions = document.getElementById('filterOptions');

  filterBtn.addEventListener('click', () => {
    if (filterOptions.style.display === 'none') {
      filterOptions.style.display = 'block';
    } else {
      filterOptions.style.display = 'none';
    }
  });

  function applyFilters() {
    const filterName = document.getElementById('filterName').value.toLowerCase();
    const filterAvailability = document.getElementById('filterAvailability').value;

    const table = document.getElementById('productTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
      const name = rows[i].cells[1].textContent.toLowerCase(); // Assuming name is in the second column (index 1)
      const availability = rows[i].cells[6].textContent; // Assuming availability is in the seventh column (index 6)

      if (
        (filterName === '' || name.includes(filterName)) &&
        (filterAvailability === '' || availability === filterAvailability)
      ) {
        rows[i].style.display = '';
      } else {
        rows[i].style.display = 'none';
      }
    }
  }

  // Function to download the table data as CSV
  function downloadTable() {
    const table = document.getElementById('productTable');
    const rows = table.querySelectorAll('tr');
    let csvContent = "data:text/csv;charset=utf-8,";

    rows.forEach(function(row) {
      const rowData = [];
      const cells = row.querySelectorAll('th, td');
      cells.forEach(function(cell) {
        rowData.push(cell.textContent);
      });
      csvContent += rowData.join(",") + "\n";
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "products.csv");
    document.body.appendChild(link); 
    link.click(); 
  }

  const downloadBtn = document.getElementById('downloadBtn');
  downloadBtn.addEventListener('click', downloadTable);

  // Pagination
  let currentPage = 1;
  const rowsPerPage = 10; // Number of rows to display per page

  function showPage(page) {
    const table = document.getElementById('productTable');
    const rows = table.getElementsByTagName('tr');
    const startIndex = (page - 1) * rowsPerPage + 1; // +1 to skip header row
    const endIndex = startIndex + rowsPerPage;

    for (let i = 1; i < rows.length; i++) {
      if (i >= startIndex && i < endIndex) {
        rows[i].style.display = '';
      } else {
        rows[i].style.display = 'none';
      }
    }

    // Update button states
    document.getElementById('prevBtn').disabled = (page === 1);
    document.getElementById('nextBtn').disabled = (endIndex >= rows.length);

    currentPage = page;
  }

  // Initial page load
  showPage(currentPage);

  // Event listeners for pagination buttons
  document.getElementById('prevBtn').addEventListener('click', () => {
    showPage(currentPage - 1);
  });

  document.getElementById('nextBtn').addEventListener('click', () => {
    showPage(currentPage + 1);
  });
</script>

</body>
</html>