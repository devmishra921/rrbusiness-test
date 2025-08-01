<?php
session_start();  // ✅ Yeh upar hona chahiye
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>R.R. Business | Shuddh Masale</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font‑Awesome -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      crossorigin="anonymous"/>

<style>
:root{
  --brand-dark:#a83232;
  --brand-light:#ff5e5e;
  --brand-gradient:linear-gradient(135deg,var(--brand-dark) 0%,var(--brand-light) 100%);
}
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
nav a {
    font-size: 1.05rem;
    margin: 6px 0;
    color: #000;
}
nav a:hover {
    color: #a83232;
}

/* Mobile Navigation Styles */
#navToggle {
    display: none;
}

@media(max-width: 768px) {
  /* Toggle button (3 lines) */
  #navToggle {
    display: block;
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    padding: 6px;
    z-index: 1001;
  }

  #navToggle span {
    display: block;
    width: 24px;
    height: 3px;
    background: #000;
    margin: 4px 0;
    transition: 0.3s;
  }

  /* Mobile Menu */
  .nav-links {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.9); /* transparent */
    backdrop-filter: blur(2px);
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.3s ease;
    z-index: 999;
  }

  .mobile-nav-container.open .nav-links {
    max-height: 350px;
  }

  /* Toggle close animation */
  .mobile-nav-container.open #navToggle span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
  }
  .mobile-nav-container.open #navToggle span:nth-child(2) {
    opacity: 0;
  }
  .mobile-nav-container.open #navToggle span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
  }

  .nav-links a {
    font-size: 1.05rem;
    margin: 8px 0;
    color: #000;
  }

  .nav-links a:hover {
    color: #a83232;
  }
}

/* ===== BANNER ===== */
.banner-slider{position:relative;width:100%;height:320px;overflow:hidden;z-index:1;}
.banner-slider img{width:100%;height:100%;object-fit:cover;transition:transform 8s}
.banner-slider:hover img{transform:scale(1.05)}
.banner-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.4),rgba(0,0,0,.7));z-index:1}
.banner-text {
  position: absolute;
  bottom: 20px;  /* niche shift */
  left: 50%;
  transform: translateX(-50%);
  color: rgba(255,255,255,0.3);  /* watermark effect */
  font-size: 1.7rem;
  text-align: center;
  z-index: 2;
  padding: 0 10px;
  font-weight: 600;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
}
.banner-text span {
  color: rgba(255,255,255,0.4);  /* lighter for span */
}
@media(max-width:768px){
  .banner-text{font-size:1.1rem;bottom:15px}
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
      /* Mobile View Fixes */
@media (max-width: 768px) {
  /* Header Top Bar */
  .top-bar {
    flex-direction: column;
    align-items: center;
    font-size: 12px;
    padding: 5px;
  }

  #datetime {
    margin-top: 5px;
  }

  /* Logo + Title + Search stacking */
  .logo-title {
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 10px;
  }

  .logo {
    width: 50px;
    margin-bottom: 8px;
  }

  .title-text h1 {
    font-size: 20px;
    margin: 5px 0;
  }

  .title-text p {
    font-size: 14px;
    margin-bottom: 8px;
  }

  .search-bar {
    width: 90%;
    display: flex;
    justify-content: center;
  }

  .search-bar input {
    width: 70%;
    font-size: 14px;
  }

  .search-bar button {
    font-size: 14px;
    padding: 5px 10px;
  }

  /* Navigation Menu */
  .menu-bar {
    flex-wrap: wrap;
    justify-content: center;
    padding: 8px;
  }

  .menu-bar a {
    font-size: 14px;
    margin: 5px 10px;
  }
}


@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.9);}
  to { opacity: 1; transform: scale(1);}
}

/* ===== COMMON SECTION ===== */
.section{padding:55px 20px;text-align:center}
.section h2{color:var(--brand-dark);margin-bottom:20px;font-size:1.8rem}
.info-boxes{display:flex;flex-wrap:wrap;justify-content:center;gap:35px;margin-top:30px}
.box{background:#fff;border:1px solid #ddd;border-radius:10px;padding:22px;width:250px;box-shadow:0 2px 10px rgba(0,0,0,.12);transition:.3s}
.box:hover{transform:scale(1.05);box-shadow:0 4px 15px rgba(0,0,0,.2)}
.box h3{color:var(--brand-dark);font-size:1.2rem;margin-bottom:8px}
.box p{font-size:.9rem}
.box a{display:inline-block;margin-top:10px;padding:8px 16px;background:var(--brand-dark);color:#fff;text-decoration:none;border-radius:5px;font-size:.9rem}

/* ===== FOOTER ===== */
footer{background:var(--brand-gradient);color:#f1f1f1;padding:40px 20px;margin-top:55px;font-size:.93rem}
.footer-container{display:flex;flex-wrap:wrap;justify-content:center;gap:40px;max-width:1200px;margin:auto}
.footer-col{flex:1 1 220px;min-width:200px;text-align:center}
.footer-col h4{color:#ffd772;margin-bottom:16px;font-size:1.05rem}
.footer-col ul{list-style:none}
.footer-col li{margin-bottom:8px;display:flex;justify-content:center;gap:6px}
.footer-col a{color:#f1f1f1;text-decoration:none;transition:.25s}
.footer-col a:hover{text-shadow:0 0 4px #fff}
.footer-bottom{text-align:center;margin-top:35px;font-size:.85rem}
.footer-bottom p{color:#ffd772;margin:4px 0;font-size: .9rem}
</style>
</head>
<body>
<header>
  <img src="images/Logo.png" alt="Logo">
  <div class="header-center">
    <div class="title">RR Business</div>
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

<div class="mobile-nav-container">
  <button id="navToggle" aria-label="Toggle Navigation">
    <span></span><span></span><span></span>
  </button>
  <div class="nav-links" id="navLinks">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="order.php">Order Now</a>
    <a href="gallery.php">Gallery</a>
    <a href="recipes.php">Recipes</a>
  </div>
</div>
<div class="banner-slider">
  <img src="images/banner1.jpg" id="bannerImage" alt="Banner">
  <div class="banner-overlay"></div>
  <div class="banner-text">Taste the Purity with <span>RR Business Masale</span></div>
</div>

<!-- ===== OUR PRODUCT CATEGORIES ===== -->
<section class="section" style="background:#fff0e6">
  <h2>Our Product Categories</h2>
  <div class="info-boxes">
    <div class="box">
      <img src="images/haldi1.png" style="width:100%;height:150px;object-fit:cover;border-radius:10px">
      <h3>Powdered Spices</h3>
      <p>Haldi, Mirchi, Dhaniya, Jeera Powder & more.</p>
      <a href="products.php">View Products</a>
    </div>
    <div class="box">
      <img src="images/dhaniya.png" style="width:100%;height:150px;object-fit:cover;border-radius:10px">
      <h3>Whole Spices</h3>
      <p>Sabut masale – laung, dalchini, elaichi etc.</p>
      <a href="products.php">View Products</a>
    </div>
    <div class="box">
      <img src="images/product3.jpeg" style="width:100%;height:150px;object-fit:cover;border-radius:10px">
      <h3>Blended Spices</h3>
      <p>Garam Masala, Chaat Masala, Pav Bhaji & more.</p>
      <a href="products.php">View Products</a>
    </div>
    <div class="box">
      <img src="images/garam_masala.jpg" style="width:100%;height:150px;object-fit:cover;border-radius:10px">
      <h3>Blended Spices</h3>
      <p>Garam Masala, Chaat Masala, Pav Bhaji & more.</p>
      <a href="products.php">View Products</a>
    </div>
  </div>
</section>

<!-- ===== WHY CHOOSE US ===== -->
<section class="section">
  <h2>Why Choose Us?</h2>
  <div class="info-boxes">
    <div class="box">
      <h3>Pure Ingredients</h3>
      <p>We source only the best raw materials to ensure premium spice quality.</p>
    </div>
    <div class="box">
      <h3>Traditional Process</h3>
      <p>Our spices are ground using age‑old techniques that preserve aroma and flavor.</p>
    </div>
    <div class="box">
      <h3>Certified Quality</h3>
      <p>All products are FSSAI certified and pass through rigorous quality checks.</p>
    </div>
    <div class="box">
      <h3>Affordable Pricing</h3>
      <p>Best quality masale at reasonable rates — perfect for home & commercial use.</p>
    </div>
  </div>
</section>

<!-- ===== ABOUT SECTION ===== -->
<section class="section">
  <h2>About R.R. Business</h2>
  <div style="display:flex;flex-wrap:wrap;justify-content:center;align-items:center;gap:30px">
    <img src="images/about.jpg" style="width:300px;border-radius:10px">
    <div style="max-width:500px;text-align:left">
      <p>R.R. Business is committed to bringing 100% shuddh desi masale to every Indian kitchen. From carefully selected raw spices to hygienic packaging, our journey is guided by tradition, trust, and taste.</p>
      <p>We serve homes, restaurants, retailers, and bulk buyers with consistency and quality. Taste the difference with R.R. Business today.</p><br>
      <a href="about.php" style="background:var(--brand-dark);color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px">Read More</a>
    </div>
  </div>
</section>

<!-- ===== CERTIFICATIONS ===== -->
<section class="section" style="background:#fff0e6">
  <h2>Our Certifications</h2>
  <div class="info-boxes">
    <div class="box">
      <img src="images/fssai.png" alt="FSSAI" style="height:80px">
      <h3>FSSAI Registered</h3>
      <p>All our products comply with food safety standards.</p>
    </div>
    <div class="box">
      <img src="images/iso.png" alt="ISO" style="height:60px">
      <h3>ISO Certified</h3>
      <p>Processes follow global ISO 9001 quality management system.</p>
    </div>
    <div class="box">
      <img src="images/organic.png" alt="Organic" style="height:60px">
      <h3>Organic Choices</h3>
      <p>Now offering selected organic spices on demand.</p>
    </div>
  </div>
</section>

<!-- ===== CTA ===== -->
<section class="section">
  <h2>Have a Bulk Order? Let's Talk!</h2>
  <p>We supply to retailers, hotels, restaurants, and distributors across India.</p><br>
  <a href="contact.php" style="background:var(--brand-dark);color:#fff;padding:12px 25px;text-decoration:none;font-size:16px;border-radius:5px">Contact Us</a>
</section>

<!-- ===== EXPLORE ===== -->
<section class="section">
  <h2>Explore Our World</h2>
  <div class="info-boxes">
    <div class="box">
      <h3>About Us</h3>
      <p>Learn more about our journey, values, and how we ensure quality in every spice.</p>
      <a href="about.php">Read More</a>
    </div>
    <div class="box">
      <h3>Our Products</h3>
      <p>From turmeric to garam masala, explore our wide range of pure and fresh spices.</p>
      <a href="products.php">Explore</a>
    </div>
    <div class="box">
      <h3>Order Online</h3>
      <p>Place your order directly from our website with quick delivery options available.</p>
      <a href="order.php">Order Now</a>
    </div>
    <div class="box">
      <h3>Contact Us</h3>
      <p>Have questions? Reach out to us for bulk orders, deals, or customer support.</p>
      <a href="contact.php">Get in Touch</a>
    </div>
  </div>
</section>

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
<!-- ===== Login/SignUp ===== -->
<script>
  // Popup Modal Functionality
  const modal = document.getElementById("popupForm");
  const openPopup = document.getElementById("openPopup");
  const closeBtn = document.getElementsByClassName("close")[0];
  const loginForm = document.getElementById("loginForm");
  const signupForm = document.getElementById("signupForm");
  const switchToSignup = document.getElementById("switchToSignup");
  const switchToLogin = document.getElementById("switchToLogin");

  openPopup.onclick = () => {
    modal.style.display = "block";
    loginForm.style.display = "block";
    signupForm.style.display = "none";
  };

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

  // Clock
  function updateClock() {
    document.getElementById('clock').textContent = new Date().toLocaleString();
  }
  updateClock();
  setInterval(updateClock, 1000);

  // Banner Slider
  const imgs = ['images/banner1.jpg', 'images/banner2.jpg', 'images/banner3.jpg'];
  let idx = 0;
  setInterval(() => {
    idx = (idx + 1) % imgs.length;
    document.getElementById('bannerImage').src = imgs[idx];
  }, 4000);

  // Navbar Toggle for Mobile
  document.addEventListener("DOMContentLoaded", () => {
    const navToggle = document.getElementById('navToggle');
    const navbar = document.getElementById('navbar');
    const navLinks = document.querySelector('.nav-links');

    navToggle.addEventListener('click', () => {
      navbar.classList.toggle('open');
   
      document.addEventListener("DOMContentLoaded", () => {
  const navToggle = document.getElementById('navToggle');
  const navContainer = document.querySelector('.mobile-nav-container');

  navToggle.addEventListener('click', () => {
    navContainer.classList.toggle('open');
  });
});

</script>

<?php if (isset($_GET['added'])): ?>
<script>
  alert('Item Cart में जोड़ा गया!');
</script>
<?php endif; ?>
</body>
</html>
