<?php
session_start();
require 'db_connect.php';

// NOTE: This page is ONLY for displaying products & cart actions.
//       NO file uploads happen here. Remove any $_FILES usage from here.

// Search handle
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM products";
if (!empty($search)) {
    $searchEsc = mysqli_real_escape_string($conn, $search);
    $sql .= " WHERE name LIKE '%$searchEsc%' OR sku LIKE '%$searchEsc%' OR description LIKE '%$searchEsc%'";
}
$sql .= " ORDER BY id ASC";

$result = mysqli_query($conn, $sql);


// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart action (only when logged in)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user'])) {
        echo "<script>document.addEventListener('DOMContentLoaded',function(){
            alert('Please login to add products to your cart.');
            const b=document.getElementById('openPopup');
            if(b) b.click();
        });</script>";
    } else {
        $product_name = htmlspecialchars(trim($_POST['product_name'] ?? ''));
        $price_raw    = $_POST['price'] ?? '0';
        $price_raw    = str_replace([',',' '], '', $price_raw);
        $price        = (float)$price_raw;
        $quantity     = max(1, (int)($_POST['quantity'] ?? 1));
        $net_wt       = htmlspecialchars(trim($_POST['net_wt'] ?? ''));  

        if ($product_name !== '' && $price > 0) {
            // ✅ Use array push, no overwrite
            $_SESSION['cart'][] = [
            'name' => $product_name,
            'price' => $price,
            'quantity' => $quantity,
            'net_wt' => $net_wt   // ✅ naya field
              ];

            header("Location: products.php?added=" . urlencode($product_name));
            exit;
        }
    }
}

// Calculate total quantity in cart
$cart_qty = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_qty += (int)$item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products | R.R. Business</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous"/>
<style>
:root{ --brand-dark:#a83232; --brand-light:#ff5e5e; --brand-gradient:linear-gradient(135deg,var(--brand-dark) 0%,var(--brand-light) 100%); }
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:#fff8f0;line-height:1.5}
header{background:#f8f3ef;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;position:relative}
header img {height: 75px;}
.header-center{position:absolute;left:50%;transform:translateX(-50%);text-align:center}
.header-center .title {font-size: 2.8rem;font-weight: 700;line-height: 1;color: #a83232;max-width: 100%;}
.header-center .tagline {font-size: 1.2rem;color: #333;}
.header-right{display:flex;align-items:center;gap:16px;font-size:.9rem}
.header-right div{border-left:1px solid #ccc;padding-left:16px}
.header-right i{margin-right:6px;color:#a83232}
.search-bar{display:flex;max-width:600px;margin-top:10px;width:100%}
.search-bar input{flex:1;padding:10px;border:1px solid #ccc;border-radius:4px 0 0 4px;font-size:.95rem}
.search-bar button{background:#a83232;border:none;padding:0 16px;color:#fff;border-radius:0 4px 4px 0;cursor:pointer}
.header-right-wrap{display:flex;flex-direction:column;align-items:flex-end}
@media(max-width:768px){header{flex-direction:column;align-items:center}.header-center{position:static;transform:none;margin-top:10px}.header-right-wrap{align-items:center;margin-top:10px}.header-right{flex-direction:column;align-items:center;border:none;padding:0}.header-right div{border:none;padding:0;margin:4px 0}.search-bar{margin-top:10px}}
/* ===== NAVBAR ===== */
nav {
  background: var(--brand-dark);
  padding: 12px 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

nav a {
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 1.05rem;
  margin: 0 16px;
  padding: 10px 6px;
  transition: .25s;
  display: flex;
  align-items: center;
  gap: 8px;
}
nav a i {
  font-size: 1rem;
}
nav a:hover { 
  color: #ffd772; 
  transform: translateY(-2px);
}

/* ===== TOGGLE (MOBILE ONLY) ===== */
#navToggle {
  display: none;
  flex-direction: column;
  justify-content: center;
}
#navToggle span {
  display: block;
  width: 26px;
  height: 3px;
  background: #fff;
  margin: 4px 0;
  transition: .3s;
}

/* ===== DESKTOP ===== */
@media(min-width:769px){
  .nav-links {
    display: flex;
    gap: 20px;
  }
}
/* ===== MOBILE NAVBAR (FIX) ===== */
@media(max-width:768px){
  #navToggle {
    display:flex;
    background:none;
    border:none;
    cursor:pointer;
    z-index:1001;
    margin-right:10px;
  }

  /* Nav-links ko search bar ke neeche drop-down banaya */
  .nav-links {
    display:flex;
    flex-direction:column;
    align-items:flex-start;
    position:static;   /* ✅ FIXED: absolute ki jagah static */
    width:100%;
    background:var(--brand-dark);
    overflow:hidden;
    max-height:0;
    padding:0;
    transition:max-height .35s ease, padding .35s ease;
  }

  #navbar.open .nav-links {
    max-height:500px;  /* enough space for all items */
    padding:12px 0;
  }

  .nav-links a {
    font-size:1rem;
    width:100%;
    border-bottom:1px solid rgba(255,255,255,0.2);
    padding:12px 18px;
    margin:0;
  }
  .nav-links a:last-child {
    border-bottom:none;
  }
}

.slider-container {position: relative;width: 100%;height: 170px;overflow: hidden;border-radius: 6px;box-shadow: 0 2px 6px rgba(0,0,0,0.1)}
.slider-container img {width: 100%;height: 100%;object-fit: contain;display: block}
.slider-btn {position: absolute;top: 50%;transform: translateY(-50%);background: rgba(0, 0, 0, 0.3);color: white;border: none;padding: 5px 8px;cursor: pointer;border-radius: 50%;font-size: 14px;transition: background 0.3s;opacity: 0.5;z-index: 2}
.slider-btn:hover {background: rgba(0, 0, 0, 0.7);opacity: 1}
.prev {left: 8px}
.next {right: 8px}
.container {max-width: 100%;padding: 0 15px}
h2 {text-align: center;margin-bottom: 20px}

.product-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  padding: 20px;
}

.product-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 6px 14px rgba(0,0,0,0.08);
  padding: 15px;
  text-align: center;
  transition: all 0.35s ease;
  border: 1px solid #eee;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.product-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.12);
}

.product-card img {
  width: 100%;
  height: 190px;
  object-fit: contain;
  border-radius: 12px;
  transition: transform 0.3s ease;
}

.product-card:hover img {
  transform: scale(1.08);
}

.product-name {
  font-size: 1.2rem;
  font-weight: 600;
  margin-top: 12px;
  color: #333;
}

.product-price {
  margin: 6px 0;
  font-size: 1.05rem;
}

.product-price .mrp {
  text-decoration: line-through;
  color: #999;
  margin-right: 8px;
}

.product-price .selling {
  color: #27ae60;
  font-weight: bold;
  font-size: 1.2rem;
}

.net-wt {
  font-size: 0.9rem;
  color: #444;
  margin-bottom: 8px;
}

.product-desc {
  font-size: 0.9rem;
  color: #666;
  margin: 6px 0 12px;
  min-height: 40px;
}

.quantity-box input {
  width: 80px;
  padding: 6px;
  border-radius: 6px;
  border: 1px solid #ccc;
  text-align: center;
  margin: 8px auto;
  display: block;
}

.add-to-cart-btn {
  background: linear-gradient(135deg, #a83232, #ff5e5e);
  border: none;
  color: white;
  padding: 12px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 15px;
  transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
  background: linear-gradient(135deg, #911d1d, #e64545);
  transform: scale(1.03);
}
@media (max-width: 600px) {
  .product-container {
    grid-template-columns: 1fr;
  }
}
.section-title {text-align: center;padding: 20px;font-size: 1.6rem;font-weight: 700;color: #a83232;position: relative;letter-spacing: 1px;text-transform: uppercase}
.section-title::after {content: "";width: 120px;height: 4px;background: #a83232;position: absolute;left: 50%;transform: translateX(-50%);bottom: 8px;border-radius: 2px}
footer {width: 100%;padding: 40px 0;background: #a83232;color:#fff}
.footer-container {width: 100%;max-width: 100%;padding: 0 20px;display: flex;flex-wrap: wrap;justify-content: space-around}
.footer-col {min-width: 200px;flex: 1 1 220px;margin: 10px}
.footer-col h4{color:#ffd772;margin-bottom:16px;font-size:1.05rem;text-align:center}
.footer-col ul{list-style:none}
.footer-col li{margin-bottom:8px;display:flex;justify-content:center;gap:6px}
.footer-col a{color:#f1f1f1;text-decoration:none;transition:.25s}
.footer-col a:hover{text-shadow:0 0 4px #fff}
.footer-bottom{text-align:center;margin-top:35px;font-size:.85rem}
.footer-bottom p{color:#ffd772;margin:4px 0;font-size:.9rem}
</style>
</head>
<body>
<header>
  <img src="images/Logo.png" alt="R.R. Business Logo" class="logo" />
  <div class="header-center">
    <div class="title">R.R. Business</div>
    <div class="tagline">100% Shuddh Desi Masale</div>
  </div>
  <div class="header-right-wrap">
    <div class="header-right">
      <div><strong style="color:#a83232">FREE SHIPPING IN INDIA</strong><br>orders ₹500 & more*</div>
      <?php if(isset($_SESSION['user'])): ?>
      <div>
        <i class="fa fa-user"></i> <?= htmlspecialchars($_SESSION['user']) ?> |
        <a href="logout.php" style="color:#a83232;text-decoration:underline;cursor:pointer;">Logout</a>
      </div>
      <?php else: ?>
      <div id="openPopup" style="cursor:pointer;">
        <i class="fa fa-user"></i> Login / Signup
      </div>
      <?php endif; ?>
      <div>
        <a href="order.php" style="color:#a83232;text-decoration:none;">
          <i class="fa fa-cart-shopping"></i> Cart (<?= (int)$cart_qty ?>)
        </a>
      </div>
      <div id="clock"></div>
    </div>
    <form class="search-bar" method="get" action="">
  <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
  <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  </div>
</header>

<nav id="navbar">
  <button id="navToggle" aria-label="Toggle Navigation">
    <span></span><span></span><span></span>
  </button>
  <div class="nav-links">
    <a href="index.php"><i class="fa fa-home"></i> Home</a>
    <a href="products.php"><i class="fa fa-box-open"></i> Products</a>
    <a href="about.php"><i class="fa fa-info-circle"></i> About Us</a>
    <a href="contact.php"><i class="fa fa-phone"></i> Contact Us</a>
    <a href="order.php"><i class="fa fa-shopping-cart"></i> Order Now</a>
    <a href="gallery.php"><i class="fa fa-image"></i> Gallery</a>
    <a href="recipes.php"><i class="fa fa-utensils"></i> Recipes</a>
  </div>
</nav>

<h2 class="section-title">Our Products</h2>
<div class="product-container">
<?php 
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()):
        // Decode images JSON or fallback to comma-separated
        $rawImages = json_decode($row['images'], true);
        if (!is_array($rawImages)) {
            $rawImages = array_filter(array_map('trim', explode(',', (string)$row['images'])));
        }
        // Build browser-usable URLs. DB stores like "images/filename.ext" relative to project root.
        $images = [];
        foreach ($rawImages as $img) {
            $img = trim((string)$img);
            if ($img === '') continue;
            // If already absolute URL or starts with '/' leave as-is
            if (preg_match('#^https?://#i', $img) || substr($img, 0, 1) === '/') {
                $images[] = $img;
            } else {
                // Page sits in rr_business_web/, images folder is one level up => prefix '../'
                $images[] = '../' . ltrim($img, '/');
            }
        }

        $firstImage = $images[0] ?? '../images/placeholder.png';
        $pid   = (int)$row['id'];
        $pname = htmlspecialchars($row['name'] ?? '');
        $pdesc = htmlspecialchars($row['description'] ?? '');
        $priceDisplay = number_format((float)$row['selling_price'], 2);
        $priceRaw = (float)$row['selling_price'];
        $jsImageArray = json_encode($images);

    ?>
    <div class='product-card'>
    <form method='post'>
        <div class='slider-container'>
            <button type='button' class='slider-btn prev' onclick='prevImage<?= $pid ?>()'>&#10094;</button>
            <img id='sliderImg<?= $pid ?>' src='<?= $firstImage ?>' alt='<?= $pname ?>'>
            <button type='button' class='slider-btn next' onclick='nextImage<?= $pid ?>()'>&#10095;</button>
        </div>

        <div class='product-name'><?= $pname ?></div>
        <div class='product-price'>
            <span class="mrp">₹<?= number_format((float)$row['mrp'], 2) ?></span>
            <span class="selling">₹<?= $priceDisplay ?></span>
        </div>

        <div class='net-wt'>Net Wt: <?= htmlspecialchars($row['net_wt'] ?? '') ?></div>
        <div class='product-desc'><?= $pdesc ?></div>

        <div class='quantity-box'>
            <input id='qty_<?= $pid ?>' name='quantity' type='number' value='1' min='1'>
        </div>

        <!-- Hidden Fields -->
        <input type='hidden' name='product_name' value='<?= $pname ?>'>
        <input type='hidden' name='price' value='<?= $priceRaw ?>'>
        <input type='hidden' name='net_wt' value='<?= htmlspecialchars($row['net_wt'] ?? '') ?>'> <!-- ✅ FIX -->

        <button type='submit' name='add_to_cart' class='add-to-cart-btn'>Add to Cart</button>
    </form>
</div>   

    <script>
    const images<?= $pid ?> = <?= $jsImageArray ?>;
    let currentIndex<?= $pid ?> = 0;
    function showImage<?= $pid ?>(index) { document.getElementById('sliderImg<?= $pid ?>').src = images<?= $pid ?>[index]; }
    function prevImage<?= $pid ?>() { currentIndex<?= $pid ?> = (currentIndex<?= $pid ?> - 1 + images<?= $pid ?>.length) % images<?= $pid ?>.length; showImage<?= $pid ?>(currentIndex<?= $pid ?>); }
    function nextImage<?= $pid ?>() { currentIndex<?= $pid ?> = (currentIndex<?= $pid ?> + 1) % images<?= $pid ?>.length; showImage<?= $pid ?>(currentIndex<?= $pid ?>); }
    </script>
<?php 
    endwhile;
} else {
    echo "<p style='text-align:center;'>No products found.</p>";
}
?>
</div>

<footer>
  <div class="footer-container">
    <div class="footer-col">
      <h4>📞 Contact Us</h4>
      <ul>
        <li><i class="fa fa-phone"></i> +91 76788 53017</li>
        <li><i class="fa fa-envelope"></i> support@rrbusiness.com</li>
        <li><i class="fa fa-envelope-open"></i> care@rrbusiness.com</li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>🔗 Quick Links</h4>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="admin_pannel.php">Manage Products</a></li>
        <li><a href="view_order.php">Orders</a></li>
        <li><a href="customer_queries.php">Queries</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>📱 Follow Us</h4>
      <ul>
        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
        <li><a href="https://www.instagram.com/rrbusiness2025" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
        <li><a href="https://wa.me/917678853017" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>🛍️ Our Products</h4>
      <ul>
        <li>✨ Haldi Powder</li>
        <li>✨ Mirch Powder</li>
        <li>✨ Garam Masala</li>
        <li>✨ Chat Masala</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?=date('Y')?> <strong>R.R. Business</strong> — All Rights Reserved</p>
    <p>🚀 Developed by <strong>V.G Technologies Pvt. Ltd.</strong></p>
  </div>
</footer>

<!-- Login/Signup Popup Modal -->
<div id="popupForm" class="modal" style="display:none;position:fixed;z-index:999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.7)">
  <div class="modal-content" style="background:#fff;margin:10% auto;padding:20px;width:90%;max-width:400px;border-radius:10px;position:relative">
    <span class="close" style="position:absolute;right:10px;top:10px;font-size:20px;cursor:pointer">&times;</span>
    <div id="formContainer">
      <form id="loginForm" method="POST" action="Login_website_backend.php">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="#" id="switchToSignup">Sign Up</a></p>
      </form>
      <form id="signupForm" method="POST" action="signup_backend.php" style="display:none;">
        <h2>Sign Up</h2>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Sign Up</button>
        <p>Already have an account? <a href="#" id="switchToLogin">Login</a></p>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // 🔹 Clock update
  function updateClock() {
    const c = document.getElementById('clock');
    if (c) c.textContent = new Date().toLocaleString();
  }
  updateClock();
  setInterval(updateClock, 1000);

  // 🔹 Navbar toggle
  const navToggle = document.getElementById('navToggle');
  if (navToggle) {
    navToggle.addEventListener('click', () => {
      document.getElementById('navbar').classList.toggle('open');
    });
  }

  // 🔹 Login/Signup modal
  const modal = document.getElementById("popupForm");
  const openPopup = document.getElementById("openPopup");
  const closeBtn = document.querySelector(".close");
  const loginForm = document.getElementById("loginForm");
  const signupForm = document.getElementById("signupForm");
  const switchToSignup = document.getElementById("switchToSignup");
  const switchToLogin = document.getElementById("switchToLogin");

  if(openPopup){
    openPopup.onclick = () => {
      modal.style.display = "block";
      loginForm.style.display = "block";
      signupForm.style.display = "none";
    };
  }
  if(closeBtn){ closeBtn.onclick = () => { modal.style.display = "none"; }; }
  window.onclick = (e) => { if (e.target === modal) modal.style.display = "none"; };
  if(switchToSignup){ switchToSignup.onclick = (e) => { e.preventDefault(); loginForm.style.display = "none"; signupForm.style.display = "block"; }; }
  if(switchToLogin){ switchToLogin.onclick = (e) => { e.preventDefault(); signupForm.style.display = "none"; loginForm.style.display = "block"; }; }

  // 🔹 Prevent add-to-cart when not logged in
  const isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;
  document.querySelectorAll('.product-card form').forEach(form => {
    form.addEventListener('submit', function(e) {
      if (!isLoggedIn) {
        e.preventDefault();
        alert('Please login to add items to your cart.');
        if (openPopup) openPopup.click();
      }
    });
  });

  // 🔹 SweetAlert after add
  <?php if (isset($_GET['added'])): ?>
  Swal.fire({
      title: '✅ Success!',
      text: "<?= addslashes($_GET['added']) ?> has been added to your cart.",
      icon: 'success',
      confirmButtonColor: '#a83232',
      confirmButtonText: 'OK'
  });
  <?php endif; ?>
});

</script>
</body>
</html>
