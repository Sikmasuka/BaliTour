<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Security Presentation — Balingasag</title>
<style>
  :root{font-family:Inter, sans-serif;line-height:1.6;color:#1c2a22;background:#f7f7f3;}
  body{margin:0;padding:0;background:#f7f7f3;color:#1c2a22;}
  .page{max-width:980px;margin:0 auto;padding:40px 24px;}
  header{margin-bottom:32px;}
  header h1{font-size:3rem;margin:0 0 12px;}
  header p{max-width:700px;color:#425047;font-size:1rem;}
  .nav{display:flex;gap:16px;flex-wrap:wrap;margin-top:18px;}
  .nav a{color:#173b2b;text-decoration:none;font-weight:600;padding:10px 14px;border:1px solid transparent;border-radius:6px;transition:all .2s;}
  .nav a:hover{background:#e5f0e7;border-color:#c5d7c8;}
  .panel{background:#fff;border:1px solid #dce1dc;border-radius:18px;padding:28px;box-shadow:0 24px 60px rgba(21,32,25,.08);margin-bottom:24px;}
  h2{margin-top:0;font-size:1.7rem;color:#173b2b;}
  h3{margin-bottom:10px;font-size:1.2rem;color:#173b2b;}
  ul{padding-left:1.25rem;margin:0 0 0.8rem;color:#3a4a41;}
  li{margin-bottom:.65rem;}
  .login-box{display:grid;gap:16px;max-width:420px;margin-top:16px;}
  .login-box label{display:block;font-size:.94rem;color:#4f6055;}
  .login-box input{width:100%;padding:12px 14px;border:1px solid #c8d3ca;border-radius:10px;background:#f7f7f3;color:#1c2a22;}
  .btn{display:inline-flex;align-items:center;justify-content:center;padding:14px 20px;border-radius:10px;border:none;background:#173b2b;color:#fff;font-weight:700;cursor:pointer;text-decoration:none;}
  .note{font-size:.95rem;color:#46524b;margin-top:12px;}
  footer{margin-top:40px;padding-top:24px;border-top:1px solid #dbe2dc;color:#4f6055;font-size:.95rem;}
</style>
</head>
<body>
<div class="page">
  <header>
    <h1>ITP 401 Security Audit Presentation</h1>
    <p>Use this page as your initial presentation summary. It covers the required presentation expectations and includes a simple login form to demonstrate the authentication flow you will defend.</p>
    <div class="nav">
      <a href="/">Home</a>
      <a href="/login">Login</a>
    </div>
  </header>

  <section class="panel">
    <h2>Presentation Guidelines & Expectations</h2>
    <ul>
      <li><strong>Time Limit:</strong> 15 minutes maximum. Manage time efficiently around Data Flow, Authentication, API Protection, and Gap Analysis.</li>
      <li><strong>Q&A Session:</strong> Be ready to explain backend configuration choices, remediation planning, and technical code decisions.</li>
      <li><strong>Attendance:</strong> Full group participation is mandatory. Each member should speak to the components they contributed or audited.</li>
    </ul>
    <p class="note">This is a simple presentation page. Later you can replace the text with slide links, diagrams, and audited architecture details.</p>
  </section>

  <section class="panel">
    <h2>What to Defend</h2>
    <div>
      <h3>Data Flow</h3>
      <p>Explain how data moves through the system, where sensitive information is validated, and how trust zones are separated.</p>
      <!-- Defense note: describe input validation, encryption boundaries, and secure data handling on the backend. -->
    </div>
    <div>
      <h3>Authentication</h3>
      <p>Show how user credentials are protected, how sessions or tokens are issued, and how login attempts are hardened.</p>
      <!-- Defense note: explain the authentication mechanism, password hashing, and session/token protection. -->
    </div>
    <div>
      <h3>API Protection</h3>
      <p>Demonstrate how API endpoints are secured, which endpoints are public, and which require authorization.</p>
      <!-- Defense note: mention middleware, rate limiting, CORS, and access control. -->
    </div>
    <div>
      <h3>Gap Analysis</h3>
      <p>Identify remaining weaknesses, remediation steps, and how the final deployment will reduce risk.</p>
      <!-- Defense note: list gaps, proposed fixes, and evidence of improved security posture. -->
    </div>
  </section>

  <section class="panel">
    <h2>Login Demonstration</h2>
    <form class="login-box" action="/login" method="get">
      <label for="username">Username</label>
      <input id="username" name="username" type="text" placeholder="Enter your username" required>
      <label for="password">Password</label>
      <input id="password" name="password" type="password" placeholder="Enter your password" required>
      <button type="submit" class="btn">Login (demo)</button>
    </form>
    <p class="note">This login form is a placeholder. In your defense, explain how real authentication is implemented and how credentials are secured in the production system.</p>
  </section>

  <footer>
    <p>Present this page as the initial briefing. Later, add diagrams, data flow charts, and code snippets for the architecture defense.</p>
  </footer>
</div>
</body>
</html>
