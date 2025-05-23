<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Aroma Senja</title>
  <link rel="icon" type="image" href="img/3.svg" />
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
      font-family: sans-serif;
    }

    body {
      background-image: url('img/bg4.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-form {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 10px;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      margin-left: 700px;
    }

    .login-form h2 {
      text-align: center;
      margin-bottom: 10px;
      color: #fff;
    }

    .login-form p {
      text-align: center;
      margin-bottom: 20px;
      color: #ccc;
    }

    .form-control {
      background-color: #4a4a4a;
      border: 1px solid #666;
      color: #fff;
      border-radius: 10px;
      padding: 12px;
      width: 100%;
      margin-bottom: 15px;
      margin-left: -12px;
    }

    .form-control::placeholder {
      color: #bbb;
    }

    .btn-primary {
      background-color: #007bff;
      border-radius: 10px;
      font-weight: bold;
      padding: 12px;
      transition: 0.3s;
      border: none;
      width: 107%;
      color: white;
      cursor: pointer;
      margin-left: -12px;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    @media (max-width: 768px) {
      .login-form {
        margin: 20px;
      }
      .btn-primary {
        width: 108%;
      }
    }

    .popup {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #f44336;
      color: white;
      padding: 16px 24px;
      border-radius: 8px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.2);
      z-index: 1000;
      animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
      from { transform: translateY(-100%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>

  <div class="login-form">
    <h2><strong>Aroma Senja</strong></h2>
    <p>Selamat Datang Admin</p>
    <form method="post" action="login.php">
      <input
        type="text"
        class="form-control"
        name="username"
        placeholder="Username"
        required
      />
      <input
        type="password"
        class="form-control"
        name="password"
        placeholder="Password"
        required
      />
      <button type="submit" class="btn-primary">Login</button>
    </form>
  </div>

  <div id="popup" class="popup hidden">
    <p id="popup-message"></p>
  </div>

  <script>
    window.onload = function () {
      const params = new URLSearchParams(window.location.search);
      const error = params.get("error");

      if (error) {
        const popup = document.getElementById("popup");
        const message = document.getElementById("popup-message");
        message.textContent = decodeURIComponent(error.replace(/\+/g, " "));
        popup.classList.remove("hidden");

        setTimeout(() => {
          popup.classList.add("hidden");
        }, 4000);
      }
    };
  </script>
</body>
</html>