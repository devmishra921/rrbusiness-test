<?php
session_start();
require 'db_connect.php';
require 'function.php'; // 👈 ye line add karo
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us | R.R. Business</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
  <style>
    :root {
      --brand-dark: #a83232;
      --brand-light: #ff5e5e;
      --brand-gradient: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-light) 100%);
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: system-ui, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
      background: #fff8f0;
      color: #333;
    }

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

    /* ===== CONTACT SECTION ===== */
    .contact-wrap {
      width: calc(100% - 80px);
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .1);
      overflow: hidden;
      display: grid;
      grid-template-columns: 1fr 1fr;
    }
    .contact-form { padding: 40px; }
    .contact-form h2 { color: #a83232; margin-bottom: 24px; text-align: center; }
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .form-grid label { display: block; margin-bottom: 6px; font-weight: 500; }
    .form-grid input, .form-grid textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }
    .form-grid textarea { grid-column: 1/-1; resize: vertical; }
    .submit-btn {
      margin-top: 20px;
      padding: 12px 28px;
      background: #a83232;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background .3s;
    }
    .submit-btn:hover { background: #8b2626; }
    .map-embed iframe { width: 100%; height: 100%; border: 0; }
    .map-embed { min-height: 100%; }

    @media(max-width:768px) {
      .contact-wrap { grid-template-columns: 1fr; }
      .contact-form { padding: 25px; }
    }

    /* ===== FOOTER ===== */
    footer {
      background: var(--brand-gradient);
      color: #f1f1f1;
      padding: 40px 20px;
      margin-top: 55px;
      font-size: .93rem;
    }
    .footer-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px;
      max-width: 1200px;
      margin: auto;
    }
    .footer-col {
      flex: 1 1 220px;
      min-width: 200px;
      text-align: center;
    }
    .footer-col h4 {
      color: #ffd772;
      margin-bottom: 16px;
      font-size: 1.05rem;
    }
    .footer-col ul {
      list-style: none;
    }
    .footer-col li {
      margin-bottom: 8px;
      display: flex;
      justify-content: center;
      gap: 6px;
    }
    .footer-col a {
      color: #f1f1f1;
      text-decoration: none;
      transition: .25s;
    }
    .footer-col a:hover {
      text-shadow: 0 0 4px #fff;
    }
    .footer-bottom {
      text-align: center;
      margin-top: 35px;
      font-size: .85rem;
    }
    .footer-bottom p {
      color: #ffd772;
      margin: 4px 0;
      font-size: .9rem;
    }
    h2{
      margin-left: 50px;
    }
    #clock{white-space:nowrap;font-weight:500;font-size:.85rem}
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
      Cart (<?php echo getCartQty($conn); ?>)

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
    <a href="index.php"><i class="fa fa-home"></i> Home</a>
    <a href="products.php"><i class="fa fa-box-open"></i> Products</a>
    <a href="about.php"><i class="fa fa-info-circle"></i> About Us</a>
    <a href="contact.php"><i class="fa fa-phone"></i> Contact Us</a>
    <a href="order.php"><i class="fa fa-shopping-cart"></i> Order Now</a>
    <a href="gallery.php"><i class="fa fa-image"></i> Gallery</a>
    <a href="recipes.php"><i class="fa fa-utensils"></i> Recipes</a>
  </div>
</nav>

<h2><br>Contact Us</h2>
<div class="contact-wrap">
  <div class="contact-form">
    <h2>Send Us a Message</h2>
    <form action="send_message.php" method="post">
      <div class="form-grid">
        <div>
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Your name" required>
        </div>
        <div>
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" placeholder="example@email.com" required>
        </div>
        <div>
          <label for="phone">Mobile Number</label>
          <input type="text" id="phone" name="phone" placeholder="10‑digit mobile no." required>
        </div>
        <div>
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" placeholder="Query topic (optional)">
        </div>
        <div>
          <label for="message">Your Message</label>
          <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
        </div>
      </div>
      <button type="submit" class="submit-btn">Send Message</button>
    </form>
  </div>
  <div class="map-embed">
    <iframe src="https://www.google.com/maps?q=Noida%20Sector%2058&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>
<footer>
  <div class="footer-container">
    <div class="footer-col">
      <h4>📞 Contact Us</h4>
      <ul>
        <li><i class="fa fa-phone"></i> +91 76788 53017</li>
        <li><i class="fa fa-envelope"></i> support@rrbusiness.com</li>
        <li><i class="fa fa-envelope-open"></i> care@rrbusiness.com</li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>🔗 Quick Links</h4>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="admin_pannel.php">Manage Products</a></li>
        <li><a href="view_order.php">Orders</a></li>
        <li><a href="customer_queries.php">Queries</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>📱 Follow Us</h4>
      <ul>
        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
        <li><a href="https://www.instagram.com/rrbusiness2025" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
        <li><a href="https://wa.me/917678853017" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>🛍️ Our Products</h4>
      <ul>
        <li>✨ Haldi Powder</li>
        <li>✨ Mirch Powder</li>
        <li>✨ Garam Masala</li>
        <li>✨ Chat Masala</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?=date('Y')?> <strong>R.R. Business</strong> — All Rights Reserved</p>
    <p>🚀 Developed by <strong>V.G Technologies Pvt. Ltd.</strong></p>
  </div>
</footer>
<script>
  // live clock – 1 बार define
  function updateClock(){
    const el=document.getElementById('clock');
    if(el) el.textContent=new Date().toLocaleString();
  }
  // DOM ready होने पर ही चालू करो
  window.addEventListener('DOMContentLoaded',()=>{
    updateClock();               // तुरंत दिखाओ
    setInterval(updateClock,1000); // फिर हर सेकंड
  });

  // burger menu वही
  document.getElementById('navToggle')
          .addEventListener('click',()=>document.getElementById('navbar').classList.toggle('open'));
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
