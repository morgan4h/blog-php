<?php

// echo "login page";

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
    <style>
        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}

body {
  height: 100vh;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-container {
  width: 100%;
  max-width: 400px;
}

.login-card {
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.login-card h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.input-group {
  margin-bottom: 15px;
}

.input-group label {
  display: block;
  margin-bottom: 5px;
  color: #555;
}

.input-group input {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  outline: none;
}

.input-group input:focus {
  border-color: #667eea;
}

button {
  width: 100%;
  padding: 10px;
  border: none;
  background: #667eea;
  color: #fff;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

button:hover {
  background: #5a67d8;
}

.signup-text {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
}

.signup-text a {
  color: #667eea;
  text-decoration: none;
}

.signup-text a:hover {
  text-decoration: underline;
}

    </style>
</head>
<body>

  <div class="login-container">
    <form class="login-card">
      <h2>Login</h2>

      <div class="input-group">
        <label>Email</label>
        <input type="email" placeholder="Enter your email" required>
      </div>

      <div class="input-group">
        <label>Password</label>
        <input type="password" placeholder="Enter your password" required>
      </div>

      <button type="submit">Login</button>

      <p class="signup-text">
        Don’t have an account? <a href="sing.php">Sign up</a>
      </p>
    </form>
  </div>

</body>
</html>
