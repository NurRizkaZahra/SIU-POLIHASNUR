<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - SIU Polihasnur</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* ================= LEFT SIDE (REGISTER FORM) ================= */
    .left {
      flex: 1;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .register-box {
      width: 340px;
      text-align: center;
      animation: fadeIn 1.5s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .register-box h3 {
      font-size: 26px;
      margin-bottom: 10px;
      color: #1e3c72;
    }

    .register-box p {
      color: #777;
      font-size: 14px;
      margin-bottom: 30px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 45px 12px 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
    }

    .input-group input:focus {
      border-color: #2a5298;
      box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
      outline: none;
    }

    .input-group i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #1e3c72;
      border: none;
      border-radius: 8px;
      color: #fff;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s;
    }

    button:hover {
      background: #2a5298;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(42, 82, 152, 0.3);
    }

    .footer-text {
      margin-top: 25px;
      font-size: 14px;
      color: #666;
    }

    .footer-text a {
      color: #2a5298;
      text-decoration: none;
      font-weight: 500;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }

    /* ====== LOGO ====== */
    .logo-box {
      text-align: center;
      margin-bottom: 10px;
    }

    .logo-login {
      width: 210px;
      height: auto;
      display: block;
      margin: 0 auto;
      object-fit: contain;
    }

    /* ====== TEKS LOGIN ====== */
    .login-box p {
      color: #777;
      font-size: 14px;
      margin-top: 15px;
      margin-bottom: 15px;
      line-height: 1.2;
    }

    /* ================= RIGHT SIDE (SLIDESHOW) ================= */
    .right {
      flex: 1;
      background: linear-gradient(135deg, #ffffff, #2a5298);
      background-size: 200% 200%;
      animation: gradientShift 8s ease infinite;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      padding: 20px;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .toga {
      position: absolute;
      width: 100px;
      opacity: 0.2;
      filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));
      animation: floatToga 8s ease-in-out infinite, glowToga 3s ease-in-out infinite alternate;
    }

    @keyframes floatToga {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(10deg); }
    }

    @keyframes glowToga {
      0% { filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3)); }
      100% { filter: drop-shadow(0 0 25px rgba(255, 255, 255, 0.8)); }
    }

    .toga:nth-child(1) { top: 10%; left: 15%; animation-delay: 0s; }
    .toga:nth-child(2) { top: 60%; left: 70%; animation-delay: 2s; }
    .toga:nth-child(3) { top: 30%; left: 40%; animation-delay: 4s; }

    /* ==== FOTO KAMPUS BERSINAR ==== */
    .slideshow {
      width: 320px;
      height: 320px;
      position: relative;
      overflow: hidden;
      border-radius: 20px;
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.4),
                  0 0 45px rgba(221, 199, 67, 0.5);
      margin-bottom: 30px;
      animation: glowFrame 3s ease-in-out infinite alternate;
    }

    @keyframes glowFrame {
      0% {
        box-shadow: 0 0 20px rgba(255,255,255,0.3),
                    0 0 40px rgba(221,199,67,0.4);
      }
      100% {
        box-shadow: 0 0 30px rgba(255,255,255,0.7),
                    0 0 60px rgba(221,199,67,0.8);
      }
    }

    .slide {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      transition: opacity 1.2s ease;
      object-fit: cover;
      object-position: center;
      border-radius: 20px;
    }

    .slide.active { opacity: 1; }

    .right h2 {
      font-size: 26px;
      font-weight: 600;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 900px) {
      body { flex-direction: column-reverse; height: auto; overflow-y: auto; }
      .left, .right { width: 100%; height: auto; flex: none; }
      .right { padding: 40px 20px; }
      .slideshow { width: 250px; height: 250px; }
      .register-box { width: 90%; max-width: 360px; margin-top: 20px; }
      .right h2 { font-size: 22px; }
    }

    @media (max-width: 480px) {
      .slideshow { width: 200px; height: 200px; }
      .register-box h3 { font-size: 22px; }
      .right h2 { font-size: 20px; }
    }
  </style>
</head>

<body>
  <!-- LEFT SIDE (REGISTER FORM) -->
  <div class="left">
    <div class="register-box">
      <div class="logo-box">
        <img src="{{ asset('images/technopreneur.png') }}" alt="Politeknik Hasnur" class="logo-login" />
      </div>
      <p>Join SIU Polihasnur by filling in your details</p>

      <form>
        <div class="input-group">
          <input type="text" placeholder="Full Name" required />
          <i class="fa fa-user"></i>
        </div>

        <div class="input-group">
          <input type="email" placeholder="Email" required />
          <i class="fa fa-envelope"></i>
        </div>

        <div class="input-group">
          <input type="password" placeholder="Password" required />
          <i class="fa fa-lock"></i>
        </div>

        <div class="input-group">
          <input type="password" placeholder="Confirm Password" required />
          <i class="fa fa-lock"></i>
        </div>

        <button type="submit">Register</button>

        <div class="footer-text">
          Already have an account? 
          <a href="{{ route('login') }}">Login</a>
        </div>
      </form>
    </div>
  </div>

  <!-- RIGHT SIDE (SLIDESHOW BERSINAR) -->
  <div class="right">
    <img src="images/toga.png" class="toga">
    <img src="images/toga.png" class="toga">
    <img src="images/toga.png" class="toga">

    <div class="slideshow">
      <img src="images/Polihasnur_1.png" class="slide active" alt="Gedung Polihasnur 1">
      <img src="images/Polihasnur_3.png" class="slide" alt="Gedung Polihasnur 2">
      <img src="images/Polihasnur_2.png" class="slide" alt="Gedung Polihasnur 3">
    </div>

    <h2>Welcome to SIU Polihasnur</h2>
  </div>

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script>
    const slides = document.querySelectorAll(".slide");
    let index = 0;
    function showSlide() {
      slides.forEach((s, i) => s.classList.toggle("active", i === index));
      index = (index + 1) % slides.length;
    }
    setInterval(showSlide, 4000);
  </script>
</body>
</html>
