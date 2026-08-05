<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Balingasag</title>
<style>
  body{margin:0;padding:0;font-family:Inter, sans-serif;background:#f0f4ef;color:#1a2e25;}
  .page{max-width:520px;margin:60px auto;padding:24px;background:#fff;border-radius:22px;box-shadow:0 40px 80px rgba(8,18,15,.08);}
  h1{margin:0 0 10px;font-size:2rem;}
  p{margin:0 0 26px;color:#4c6053;}
  label{display:block;margin-bottom:8px;font-size:.95rem;color:#516056;}
  input{width:100%;padding:14px 16px;border:1px solid #c7d2c6;border-radius:12px;margin-bottom:18px;background:#f7f8f5;color:#1a2e25;}
  .btn{display:inline-flex;align-items:center;justify-content:center;padding:14px 18px;border:none;border-radius:12px;background:#1e3f2f;color:#fff;font-weight:700;cursor:pointer;text-decoration:none;}
  .note{margin-top:18px;font-size:.95rem;color:#55655a;}
  .top-links{margin-bottom:24px;display:flex;gap:12px;}
  .top-links a{color:#1e3f2f;text-decoration:none;font-weight:600;}
</style>
</head>
<body>
<div class="page">
  <div class="top-links">
    <a href="/">Home</a>
    <a href="/presentation">Presentation</a>
  </div>
  <h1>Login</h1>
  <p>This simple login form demonstrates the authentication page you can defend in the lab presentation.</p>
  <form action="/presentation" method="get">
    <label for="user">Username</label>
    <input id="user" name="user" type="text" placeholder="username" required>
    <label for="pass">Password</label>
    <input id="pass" name="pass" type="password" placeholder="password" required>
    <button type="submit" class="btn">Sign In</button>
  </form>
  <p class="note">No actual backend authentication is implemented yet. Later you can replace this with a secure login flow, session handling, and password storage defenses.</p>
</div>
</body>
</html>
