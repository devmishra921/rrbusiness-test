<?php 
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Recipes | R.R. Business</title>

  <!-- Font‑Awesome -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-BxRHU0Qq6wS5fXPy2N3IPndv7x6ZnP/7smJv+Z6xBuBx7s7TEQJAjhByWvT6r4jmHC7eS7+93RHQW4M2rFyzKg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    :root{
      --brand-dark:#a83232;
      --brand-light:#ff5e5e;
      --brand-gradient:linear-gradient(135deg,var(--brand-dark) 0%,var(--brand-light) 100%);
      --menu-bg:#ffd5d5;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif}

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
    /* ===== CONTENT ===== */
    .recipe{max-width:800px;margin:60px auto;line-height:1.8}

    /* ===== FOOTER ===== */
    footer{
  background:var(--brand-gradient);
  color:#f1f1f1;
  padding:45px 20px 30px;
  margin-top:60px;
  box-shadow:0 -6px 15px rgba(0,0,0,.3);
  font-size:.95rem;
  clear:both;
}
    .footer-container{
      display:flex;
      flex-wrap:wrap;
      justify-content:center;
      gap:60px;
      max-width:1200px;
      margin:auto;
    }
    .footer-col{
      flex:1 1 220px;
      min-width:220px;
      text-align:center;
    }
    .footer-col h4{
      margin-bottom:18px;
      font-size:1.1rem;
      color:#ffd772;
    }
    .footer-col ul{list-style:none}
    .footer-col li{margin-bottom:10px;display:flex;justify-content:center;gap:8px}
    .footer-col a{
      color:#f1f1f1;
      text-decoration:none;
      transition:color .25s,text-shadow .25s;
    }
    .footer-col a:hover{color:#fff;text-shadow:0 0 4px #fff}
    .footer-bottom{
      text-align:center;
      margin-top:40px;
      color:#e0e0e0;
      font-size:.9rem;
    }
    .footer-bottom p{color:#ffd772;margin:4px 0;font-size: .9rem}
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
    <i class="fa fa-cart-shopping"></i> 
    <a href="order.php" style="color:#a83232;text-decoration:underline;">
      Cart (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)
    </a>
  </div>

  <div id="clock"></div>
</div>

    <!-- Login/Signup Popup Modal -->
<div id="popupForm" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <div id="formContainer">
      <!-- Login Form -->
      <form id="loginForm" method="POST" action="Login_website_backend.php">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="#" id="switchToSignup">Sign Up</a></p>
      </form>

      <!-- Signup Form -->
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
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="order.php">Order Now</a>
    <a href="gallery.php">Gallery</a>
    <a href="recipes.php">Recipes</a>
  </div>
</nav>
  <!-- CONTENT -->
  <div class="recipe">
    <h1>Popular Masala Recipes</h1>

    <h3>1. Haldi Doodh (Turmeric Milk)</h3>
    <p>Garm doodh me 1 chamach haldi powder milayein. Sehat aur immunity ke liye best.</p>

    <h3>2. Dahi Dhania Chutney</h3>
    <p>Dhaniya powder, dahi, namak, mirch aur nimbu ras se banayein ek tasty chutney.</p>
  </div>
  <div class="recipe">
    <h1>Popular Masala Recipes</h1>

    <h3>1. Haldi Doodh (Turmeric Milk)</h3>
    <p>Garm doodh me 1 chamach haldi powder milayein. Sehat aur immunity ke liye best.</p>

    <h3>2. Dahi Dhania Chutney</h3>
    <p>Dhaniya powder, dahi, namak, mirch aur nimbu ras se banayein ek tasty chutney.</p>
  </div>
  </div>

  <!-- FOOTER -->
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
          <li><a href="dashboard.php"><i class="fa fa-chart-line"></i> Dashboard</a></li>
          <li><a href="admin_pannel.php"><i class="fa fa-boxes-stacked"></i> Manage Products</a></li>
          <li><a href="view_order.php"><i class="fa fa-receipt"></i> Orders</a></li>
          <li><a href="customer_queries.php"><i class="fa fa-question-circle"></i> Queries</a></li>
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
      <p>🚀 Developed by <strong>V.G Technologies Pvt. Ltd.</strong></p>
    </div>
  </footer>
  <script>
function updateClock(){document.getElementById('clock').textContent = new Date().toLocaleString();}
updateClock();setInterval(updateClock, 1000);
</script>
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
</body>
</html>
