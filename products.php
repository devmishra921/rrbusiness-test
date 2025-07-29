<?php
session_start();
require 'db_connect.php';

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('Please login to add products to your cart.');
                const popupBtn = document.getElementById('openPopup');
                if (popupBtn) popupBtn.click();
            });
        </script>";
    } else {
        $product_name = htmlspecialchars(trim($_POST['product_name']));
        $price = floatval($_POST['price']);
        $quantity = max(1, intval($_POST['quantity']));

        if (isset($_SESSION['cart'][$product_name])) {
            $_SESSION['cart'][$product_name]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_name] = [
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('$product_name has been added to your cart.');
            });
        </script>";
    }
}

// Calculate total quantity in cart
$cart_qty = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_qty += $item['quantity'];
}

// Fetch all products
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products | R.R. Business</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous"/>
<style>
:root{
  --brand-dark:#a83232;
  --brand-light:#ff5e5e;
  --brand-gradient:linear-gradient(135deg,var(--brand-dark) 0%,var(--brand-light) 100%);
}
/* RESET */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:#fff8f0;line-height:1.5}

/* HEADER UPGRADE */
header{background:#f8f3ef;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;position:relative}
header img {height: 75px;}
.header-center{position:absolute;left:50%;transform:translateX(-50%);text-align:center}
.header-center .title {
  font-size: 2.8rem;  /* Pehle 2.2rem tha */
  font-weight: 700;
  line-height: 1;
  color: #a83232;
  max-width: 100%;  /* full width le sake */
}
.header-center .tagline {
  font-size: 1.2rem;  /* Pehle 1rem tha */
  color: #333;
}
.header-right{display:flex;align-items:center;gap:16px;font-size:.9rem}
.header-right div{border-left:1px solid #ccc;padding-left:16px}
.header-right i{margin-right:6px;color:#a83232}
.search-bar{display:flex;max-width:600px;margin-top:10px;width:100%}
.search-bar input{flex:1;padding:10px;border:1px solid #ccc;border-radius:4px 0 0 4px;font-size:.95rem}
.search-bar button{background:#a83232;border:none;padding:0 16px;color:#fff;border-radius:0 4px 4px 0;cursor:pointer}
.header-right-wrap{display:flex;flex-direction:column;align-items:flex-end}
@media(max-width:768px){
  header{flex-direction:column;align-items:center}
  .header-center{position:static;transform:none;margin-top:10px}
  .header-right-wrap{align-items:center;margin-top:10px}
  .header-right{flex-direction:column;align-items:center;border:none;padding:0}
  .header-right div{border:none;padding:0;margin:4px 0}
  .search-bar{margin-top:10px}
}
/* ===== NAVBAR ===== */
nav{background:var(--brand-dark);padding:12px 14px;display:flex;align-items:center;justify-content:center;position:relative}
nav a{color:#fff;text-decoration:none;font-weight:600;font-size:1.07rem;margin:0 20px;padding:8px 4px;transition:.25s}
nav a:hover{color:#ffd772}
#navToggle{display:none}
/* burger for ≤768px */
@media(max-width:768px){
  #navToggle{display:block;position:absolute;left:10px;top:50%;transform:translateY(-50%);background:none;border:none;padding:6px 8px;cursor:pointer}
  #navToggle span{display:block;width:26px;height:3px;background:#fff;margin:4px 0;transition:.3s}
  .nav-links{position:absolute;top:100%;left:0;width:100%;background:var(--brand-dark);flex-direction:column;align-items:center;overflow:hidden;max-height:0;transition:max-height .35s}
  nav.open .nav-links{max-height:550px;padding:12px 0}
  nav.open #navToggle span:nth-child(1){transform:translateY(7px) rotate(45deg)}
  nav.open #navToggle span:nth-child(2){opacity:0}
  nav.open #navToggle span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
  nav a{font-size:1.05rem;margin:6px 0}
}
.image-gallery {
  display: flex;
  gap: 5px;
  overflow-x: auto;
  padding-bottom: 4px;
}
.image-gallery img {
  max-width: 80px;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.slider-container {
  position: relative;
  width: 100%;
  height: 170px;
  overflow: hidden;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.slider-container img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
}
.slider-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0, 0, 0, 0.3);
  color: white;
  border: none;
  padding: 5px 8px;
  cursor: pointer;
  border-radius: 50%;
  font-size: 14px;
  transition: background 0.3s;
  opacity: 0.5;
  z-index: 2;
}
.slider-btn:hover {
  background: rgba(0, 0, 0, 0.7);
  opacity: 1;
}
.prev {
  left: 8px;
}
.next {
  right: 8px;
}

/* ======Login/SignUp==========*/
/* Popup Modal Styles */
.modal {
  display: none; 
  position: fixed; 
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.7);
}
.modal-content {
  background-color: white;
  margin: 10% auto;
  padding: 20px;
  width: 90%;
  max-width: 400px;
  border-radius: 10px;
  position: relative;
  animation: fadeIn 0.5s;
}
.modal-content h2 {
  margin-bottom: 15px;
}
.modal-content input {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.modal-content button {
  width: 100%;
  padding: 10px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.close {
  position: absolute;
  right: 10px; top: 10px;
  font-size: 20px;
  cursor: pointer;
}
#openPopup:hover {
  color: #007BFF;
  text-decoration: underline;
}
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.9);}
  to { opacity: 1; transform: scale(1);}
}
/* ===== PRODUCT LIST ===== */
.container {
    max-width: 100%;
    padding: 0 15px;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 15px;
    gap: 5px;
}
.product-card {
    width: 21%;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    padding: 5px 8px;  /* Top-Bottom: 5px, Left-Right: 8px */
    box-sizing: border-box;
    text-align: center;
    transition: transform 0.2s;
    border: 1px solid #ddd;
    margin: 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-card:hover {
    transform: scale(1.02);
}

.product-card img {
    width: 100%;
    height: 170px;
    object-fit: contain;
    margin: 5px 5px;
    display: block;
    border-radius: 4px;
}

.product-name {
    font-weight: bold;
    font-size: 18px;
}

.product-price {
    color: green;
    font-size: 16px;
    font-weight: bold;
}

.product-desc {
    font-size: 14px;
    color: #555;
    margin: 5px 0;
}

.product-gst {
    font-size: 13px;
    color: #777;
    margin-bottom: 8px;
}

.quantity-box {
    margin: 8px 0;
}

.quantity-box input {
    width: 100%;
    padding: 5px;
    text-align: center;
    border-radius: 4px;
    border: 1px solid #ccc;
}

/* Button full width and clean */
.add-to-cart-btn {
    width: 100%;
    background: #b91d47;   /* dark red */
    color: white;
    padding: 10px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    font-size: 15px;
    transition: background 0.3s;
}

.add-to-cart-btn:hover {
    background: #991336;
}

@media (max-width: 1000px) {
    .product-card {
        width: 30%;
    }
}

@media (max-width: 600px) {
    .product-card {
        width: 45%;
    }
}
.section-title {
  text-align: center;
  padding: 20px;
  font-size: 1.6rem;               /* bada text */
  font-weight: 700;                /* bold */
  color: #a83232;                  /* brand color */
  position: relative;
  font-family: 'Segoe UI', sans-serif;
  letter-spacing: 1px;
  text-transform: uppercase;       /* capital letters */
}

.section-title::after {
  content: "";
  width: 120px;
  height: 4px;
  background: #a83232;             /* underline color */
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  bottom: 8px;                     /* distance from text */
  border-radius: 2px;
}

/* ===== FOOTER ===== */
footer {
  width: 100%;
  padding: 40px 0;
  background: #a83232;  /* Add this for brand-colored background */
  box-sizing: border-box;
  color: #fff;  /* White text for better contrast */
}
/* Container inside footer should also be full width */
.footer-container {
  width: 100%;
  max-width: 100%;
  padding: 0 20px;
  box-sizing: border-box;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around; /* Center items with space */
}

.footer-col {
  min-width: 200px;
  flex: 1 1 220px;
  margin: 10px;
}
.footer-col h4{color:#ffd772;margin-bottom:16px;font-size:1.05rem; text-align:center;}
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
  <img src="images/Logo.png" alt="Logo">
  <div class="header-center">
    <div class="title">R.R. Business</div>
    <div class="tagline">100% Shuddh Desi Masale</div>
  </div>
  <div class="header-right-wrap">
    <div class="header-right">
      <div><strong style="color:#a83232">FREE SHIPPING IN INDIA</strong><br>orders ₹500 & more*</div>
      <?php if(isset($_SESSION['user'])): ?>
      <div>
        <i class="fa fa-user"></i> <?= $_SESSION['user'] ?> | 
        <a href="logout.php" style="color:#a83232;text-decoration:underline;cursor:pointer;">Logout</a>
      </div>
      <?php else: ?>
      <div id="openPopup" style="cursor:pointer;">
        <i class="fa fa-user"></i> Login / Signup
      </div>
      <?php endif; ?>
      <div>
        <a href="order.php" style="color:#a83232;text-decoration:none;">
          <i class="fa fa-cart-shopping"></i> Cart (<?= $cart_qty ?>)
        </a>
      </div>
      <div id="clock"></div>
    </div>
    <div class="search-bar">
      <input type="text" placeholder="Search...">
      <button><i class="fa fa-search"></i></button>
    </div>
  </div>
</header>

<nav id="navbar">
  <button id="navToggle" aria-label="Toggle Navigation">
    <span></span><span></span><span></span>
  </button>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="order.php">Order Now</a>
    <a href="gallery.php">Gallery</a>
    <a href="recipes.php">Recipes</a>
  </div>
</nav>

<!-- PRODUCTS CONTENT -->
<h2 class="section-title">Our Products</h2>
<div class="product-container">
<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['id'];
        $pname = $row['name'];
        $pprice = $row['price'];
        $pdesc = $row['description'];
        $images = $row['images'];

        // Ensure images is a string before using explode
        if (!is_string($images)) {
            $images = '';
        }

        // Handle multiple images safely
        $imagePaths = explode(',', $images);
        $imagePaths = array_map('trim', $imagePaths);
        $imagePaths = array_filter($imagePaths); // Remove empty values
        $firstImage = !empty($imagePaths) ? $imagePaths[0] : 'images/default.jpg';

        // Prepare JS array string
        $jsImageArray = json_encode(array_values($imagePaths));

        echo "
        <div class='product-card'>
            <form method='post'>
                <div class='slider-container'>
                    <button type='button' class='slider-btn prev' onclick='prevImage{$pid}()'>&#10094;</button>
                    <img id='sliderImg{$pid}' src='{$firstImage}' alt='{$pname}'>
                    <button type='button' class='slider-btn next' onclick='nextImage{$pid}()'>&#10095;</button>
                </div>
                <div class='product-name'>{$pname}</div>
                <div class='product-price'>₹{$pprice}</div>
                <div class='product-desc'>{$pdesc}</div>
                <div class='quantity-box'>
                    <input id='qty_{$pid}' name='quantity' type='number' value='1' min='1'>
                </div>
                <input type='hidden' name='product_name' value='{$pname}'>
                <input type='hidden' name='price' value='{$pprice}'>
                <button type='submit' name='add_to_cart' class='add-to-cart-btn'>Add to Cart</button>
            </form>
        </div>

        <script>
        const images{$pid} = {$jsImageArray};
        let currentIndex{$pid} = 0;

        function showImage{$pid}(index) {
            const imgEl = document.getElementById('sliderImg{$pid}');
            imgEl.src = images{$pid}[index];
        }

        function prevImage{$pid}() {
            currentIndex{$pid} = (currentIndex{$pid} - 1 + images{$pid}.length) % images{$pid}.length;
            showImage{$pid}(currentIndex{$pid});
        }

        function nextImage{$pid}() {
            currentIndex{$pid} = (currentIndex{$pid} + 1) % images{$pid}.length;
            showImage{$pid}(currentIndex{$pid});
        }
        </script>
        ";
    }
} else {
    echo "<p style='text-align:center;'>No products found.</p>";
}
?>
<!-- ===== FOOTER ===== -->
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
<div id="popupForm" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
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
const modal = document.getElementById("popupForm");
const openPopup = document.getElementById("openPopup");
const closeBtn = document.getElementsByClassName("close")[0];
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

closeBtn.onclick = () => {
  modal.style.display = "none";
};

window.onclick = (event) => {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};

switchToSignup.onclick = () => {
  loginForm.style.display = "none";
  signupForm.style.display = "block";
};

switchToLogin.onclick = () => {
  signupForm.style.display = "none";
  loginForm.style.display = "block";
};

function updateClock(){document.getElementById('clock').textContent=new Date().toLocaleString();}
updateClock();setInterval(updateClock,1000);
document.getElementById('navToggle').addEventListener('click',()=>document.getElementById('navbar').classList.toggle('open'));
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;

  // Apply to all add-to-cart forms
  const cartForms = document.querySelectorAll('form');
  cartForms.forEach(form => {
    form.addEventListener('submit', function(e) {
      if (!isLoggedIn) {
        e.preventDefault(); // Stop form submission
        alert('Please login to add items to your cart.');
        const popupBtn = document.getElementById('openPopup');
        if (popupBtn) popupBtn.click(); // Open login popup
      }
    });
  });
});
</script>


</body>
</html>
