<?php
// Menu items
$menuItems = [
    [
        'icon' => 'home',
        'title' => 'Dashboard',
        'link' => '#'
    ],
    [
        'icon' => 'shopping_cart',
        'title' => 'Inventory',
        'link' => '#'
    ],
    [
        'icon' => 'signal_cellular_alt',
        'title' => 'Reports',
        'link' => '#'
    ],
    [
        'icon' => 'person',
        'title' => 'Invoices',
        'link' => '#'
    ],
    [
        'icon' => 'shopping_bag',
        'title' => 'Orders',
        'link' => '#'
    ],
    [
        'icon' => 'format_list_bulleted',
        'title' => 'Manage Store',
        'link' => '#'
    ],
    [
        'icon' => 'tune',
        'title' => 'Settings',
        'link' => '#'
    ],
    [
        'icon' => 'logout',
        'title' => 'Log Out',
        'link' => 'login'
    ]
];
?>

<style>
    
@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

       body{
         font-family: "Inter", sans-serif;
       }
    
    .logo-container {
  position: relative;
  display: inline-block;
  vertical-align: middle;
}

.polygon-bg {
  width: 40px; /* Adjust size as needed */
  height: 40px;
}

.logo-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 29px; /* Adjust size as needed */
  z-index: 1;}
.nav-link {
  display: flex;
  align-items: center;
  padding: 10px;
  color: #333;
  text-decoration: none;
  border-radius: 5px;
  transition: all 0.3s ease;
}

.icon-wrapper {
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;

 

}

.nav-icon {
  max-width: 24px;
  max-height: 24px;
  transition: transform 0.2s ease;
}

.menu-title {
  font-size: 20px;
  font-weight: 400;
}
.metismenu{
    gap:30px;
}
.material-icons-outlined{
 
  font-variation-settings:
  'FILL' 0,
  'wght' 100,
  'GRAD' 0,
  'opsz' 24

}

</style>   <!--start sidebar--><aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <!-- <img src="Dash-assets/images/logo-icon.png" class="logo-img" alt=""> -->
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0" style="color:#1570EF;">
                <div class="logo-container">
                    <img src="assets/img/polygon.png" alt="polygon" class="polygon-bg">
                    <img src="assets/img/logo.svg" alt="logo" class="logo-icon">
                </div>
                QuickBuy
            </h5>
        </div>
    </div>
    <div class="sidebar-nav">
        <ul class="metismenu" id="sidenav">
            <?php foreach ($menuItems as $item): ?>
                <li>
                    <a href="<?php echo $item['link']; ?>" class="nav-link">
                        <div class="parent-icon">
                            <i class="material-icons-outlined"><?php echo $item['icon']; ?></i>
                        </div>
                        <div class="menu-title"><?php echo $item['title']; ?></div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>
<!--end sidebar-->