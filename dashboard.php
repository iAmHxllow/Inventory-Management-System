
<style>
  .card-body {
  padding: 20px;
}

.purchaseCard, .costCard, .cancelCard, .returnCard {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.icon {
  width: 30px;
  height: 30px;
  margin-bottom: 5px;
}

.value {
  font-size: 16px; /* Larger font for the main value */
  color: #5D6679;
}

.label {
  font-size: 0.875rem;
  color: #666;
}

.vr {
  width: 1px;
  height: 50px;
  background-color: #e0e0e0;
}
.text{
  
  margin-top:10px;
  width: 100%;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:16px;
}
.fs-4{
  font-size:20px;
}
           .chart-container1 {
            width: 100%;
            
        }
  .chart-container {
      max-width: 100%;
      margin: auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
    
    }
    .chart-container h2 {
      text-align: left;
      margin-bottom: 0;
      font-size: 1.2em;
    }
    .weekly-btn {
      float: right;
      padding: 5px 10px;
      font-size: 0.9em;
      border: 1px solid #ccc;
      border-radius: 5px;
      cursor: pointer;
      background: #fff;
    }
</style><?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<?php include('Dash-assets/include/head.php');?>

<body>
    <!-- start -->
<?php include('Dash-assets/include/nav.php');?>
    <!--  -->
<!-- sidebar -->
<?php include('Dash-assets/include/sidebar.php');?>

<!-- end sidebar -->

  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
		     
        <div class="row">
      <div class="col-xxl-8 d-flex align-items-stretch">
  <div class="card w-100  overflow-hidden rounded-4" style="height:170px;">
    <div class="card-body position-relative p-3">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center mb-3">
            <h4 class="fw-semibold  mb-0" style="font-size:20px;">Purchase Overview</h4>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-3 gap-5">
            <!-- Purchase Item -->
            <div class="purchaseCard text-center">
              <img src="assets/img/Purchase.svg" alt="Purchase Icon" class="icon">
              <div class="text">
                <span class="value fw-bold">82</span>
                <span class="label d-block">Purchase</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Cost Item -->
            <div class="costCard text-center">
              <img src="assets/img/Cost.svg" alt="Cost Icon" class="icon">
              <div class="text">
                <span class="value fw-bold">£13,573</span>
                <span class="label d-block">Cost</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Cancel Item -->
            <div class="cancelCard text-center">
              <img src="assets/img/Cancel.svg" alt="Cancel Icon" class="icon">
              <div class="text">
                <span class="value fw-bold">5</span>
                <span class="label d-block">Cancel</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Return Item -->
            <div class="returnCard text-center">
              <img src="assets/img/return.svg" alt="Return Icon" class="icon">
              <div class="text">
                <span class="value fw-bold">£17,432</span>
                <span class="label d-block">Return</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


          <!-- <div class="col-xl-6 col-xxl-4 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-1">
                  <div class="">
                    <h5 class="mb-0">42.5K</h5>
                    <p class="mb-0">Active Users</p>
                  </div>
                  <div class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                      data-bs-toggle="dropdown">
                      <span class="material-icons-outlined fs-5">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                    </ul>
                  </div>
                </div>
                <div class="chart-container2">
                  <div id="chart1"></div>
                </div>
                <div class="text-center">
                  <p class="mb-0 font-12">24K users increased from last month</p>
                </div>
              </div>
            </div>
          </div>
         -->

<!-- Inventory Summary -->
                <div class="col-xl-6 col-xxl-4 d-flex align-items-stretch">
  <div class="card w-100  overflow-hidden rounded-4" style="height:170px;">
    <div class="card-body position-relative p-3">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center mb-3">
            <h4 class="fw-semibold  mb-0" style="font-size:20px;">Inventory Summary</h4>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-3 gap-5">
            <!-- Purchase Item -->
            <div class="purchaseCard text-center">
              <img src="assets/img/Quantity.svg" alt="Purchase Icon" class="icon">
              <div class="text-center">
                <span class="value fw-bold">868</span>
                <span class="label d-block">Quantity in Hand</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Cost Item -->
            <div class="costCard text-center w-full">
              <img src="assets/img/Pending.svg" alt="Cost Icon" class="icon">
              <div class="text-center">
                <span class="value fw-bold">200</span>
                <span class="label d-block">To be received</span>
              </div>
            </div>
          </div>
        </div>
      </div>
            </div>
  </div>
</div>





<!-- sales Overciew -->
                <div class="col-xxl-8 d-flex align-items-stretch">
  <div class="card w-100  overflow-hidden rounded-4" style="height:170px;">
    <div class="card-body position-relative p-3">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center mb-3">
            <h4 class="fw-semibold  mb-0" style="font-size:20px;">Sales Overview</h4>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-3 gap-5">
            <!-- Purchase Item -->
            <div class="purchaseCard text-center">
              <img src="assets/img/Sales.svg" alt="Purchase Icon" class="icon">
              <div class="text">
                <span class="value fw-bold"> 832</span>
                <span class="label d-block">Sales</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Cost Item -->
            <div class="costCard text-center">
              <img src="assets/img/Revenue.svg" alt="Cost Icon" class="icon">
              <div class="text">
                <span class="value fw-bold"> £18,300</span>
                <span class="label d-block">Revenue</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Cancel Item -->
            <div class="cancelCard text-center">
              <img src="assets/img/return.svg" alt="Cancel Icon" class="icon">
              <div class="text">
                <span class="value fw-bold">£868</span>
                <span class="label d-block">Profit</span>
              </div>
            </div>

            <!-- Divider -->
            <div class="vr"></div>

            <!-- Return Item -->
            <div class="returnCard text-center">
              <img src="assets/img/Cost.svg" alt="Return Icon" class="icon">
              <div class="text">
                <span class="value fw-bold">£17,432</span>
                <span class="label d-block">Cost</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- sales overview -->
                <div class="col-xl-6 col-xxl-4 d-flex align-items-stretch">
  <div class="card w-100  overflow-hidden rounded-4" style="height:170px;">
    <div class="card-body position-relative p-3">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="fw-semibold mb-0" style="font-size:20px;">Low Quantity  Stock</h4>
            <a href="" style="text-decoration:none;" class="text-primary">See More</a>
          </div>
          <div class="section">
            <!-- img -->
            <img src="assets/img/tataSalt.svg" alt="svg">
            <!-- sectionarea -->
         <div class="sectionContent">
          <span>Tata Salt</span>
          <span>Remaining Quantity : 10 Packet</span>
         </div>
         <!-- status -->
          <div class="status"><span>low</span></div>
             
        
        

    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



          <div class="col-xxl-7 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
              <div class="card-body">
                 <div class="chart-container">
    <h2>Sales & Purchase <button class="weekly-btn">Weekly</button></h2>
    <canvas id="salesPurchaseChart"></canvas>
  </div>
              </div>
            </div>
          </div>
   
          <div class="col-xxl-5 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
              <div class="card-body">
                    <h4 style="font-size:20px;">Order Summary</h4>
            <div class="chart-container ">
                <canvas id="orderSummaryChart"></canvas>
            </div>
                      
              </div>
            </div>
          </div>
   

       
          <div class="col-lg-12 col-xxl-8 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
              <div class="card-body">
               <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0">Top Selling Stock</h5>
                  </div>
                  <div class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                      data-bs-toggle="dropdown">
                      <span class=" text-primary">See All</span>
                    </a>
                 
                  </div>
                </div>
              
                 <div class="table-responsive">
                     <table class="table align-middle">
                       <thead>
                        <tr>
                          <th> Name</th>
                          <th>Sold Quantity</th>
                          <th>Remaining Quantity</th>
                          <th>Remaining Quantity</th>
                   
                        </tr>
                       </thead>
                        <tbody>
                          <tr>
                            <td>
                             Surf Excel
                            </td>
                            <td>30</td>
                            <td>12</td>
                            <td>£100</td>
                           
                          </tr>
                        
                          

                        </tbody>
                     </table>
                 </div>
              </div>
            </div>
          </div>
        </div>



    </div>
  </main>
  <!--end main wrapper-->

  <!--start overlay-->
     <div class="overlay btn-toggle"></div>
  <!--end overlay-->

  <!--end footer-->

  <!--start cart-->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header border-bottom h-70">
      <h5 class="mb-0" id="offcanvasRightLabel">8 New Orders</h5>
      <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
        <i class="material-icons-outlined">close</i>
      </a>
    </div>
    <div class="offcanvas-body p-0">
      <div class="order-list">
        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/01.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">White Men Shoes</h5>
            <p class="mb-0 order-price">$289</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/02.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Red Airpods</h5>
            <p class="mb-0 order-price">$149</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/03.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Men Polo Tshirt</h5>
            <p class="mb-0 order-price">$139</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/04.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Blue Jeans Casual</h5>
            <p class="mb-0 order-price">$485</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/05.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Fancy Shirts</h5>
            <p class="mb-0 order-price">$758</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/06.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Home Sofa Set </h5>
            <p class="mb-0 order-price">$546</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/07.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Black iPhone</h5>
            <p class="mb-0 order-price">$1049</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>

        <div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
          <div class="order-img">
            <img src="Dash-assets/images/orders/08.png" class="img-fluid rounded-3" width="75" alt="">
          </div>
          <div class="order-info flex-grow-1">
            <h5 class="mb-1 order-title">Goldan Watch</h5>
            <p class="mb-0 order-price">$689</p>
          </div>
          <div class="d-flex">
            <a class="order-delete"><span class="material-icons-outlined">delete</span></a>
            <a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
          </div>
        </div>
      </div>
    </div>
    <div class="offcanvas-footer h-70 p-3 border-top">
      <div class="d-grid">
        <button type="button" class="btn btn-grd btn-grd-primary" data-bs-dismiss="offcanvas">View Products</button>
      </div>
    </div>
  </div>
  <!--end cart-->



 

  <!--start switcher-->
<?php include('Dash-assets/include/footer.php');?>
<script>// Get context for Sales & Purchase chart
const salesCtx = document.getElementById('salesPurchaseChart').getContext('2d');
const salesPurchaseChart = new Chart(salesCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
            {
                label: 'Purchase',
                data: [50000, 60000, 45000, 30000, 50000, 60000, 45000, 40000, 45000, 30000, 40000, 45000],
                backgroundColor: '#817AF3', // Light blue color
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 10 // Add rounded corners
            },
            {
                label: 'Sales',
                data: [40000, 50000, 35000, 25000, 45000, 55000, 40000, 35000, 40000, 25000, 35000, 40000],
                backgroundColor: '#46A46C', // Light green color
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 10 // Add rounded corners
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 10000
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            }
        }
    }
});

// Get context for Order Summary chart
const orderCtx = document.getElementById('orderSummaryChart').getContext('2d');
const orderSummaryChart = new Chart(orderCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [
            {
                label: 'Ordered',
                data: [2000, 1500, 1800, 2200, 2100],
                borderColor: 'rgba(218, 165, 32, 1)', // Brown color
                backgroundColor: 'rgba(218, 165, 32, 0.1)', // Light brown background
                fill: true,
                tension: 0.4,
            },
            {
                label: 'Delivered',
                data: [2500, 3000, 2800, 3200, 3300],
                borderColor: 'rgba(135, 206, 250, 1)', // Light blue color
                backgroundColor: 'rgba(135, 206, 250, 0.1)', // Light blue background
                fill: true,
                tension: 0.4,
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 4000
            }
        },
        plugins: {
            legend: {
                position: 'bottom', // Position the legend at the bottom
                labels: {
                    usePointStyle: true, // Use circular point style
                    pointStyle: 'circle'
                }
            }
        }
    }
});




  </script>



</body>
</html>