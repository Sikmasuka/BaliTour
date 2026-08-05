<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Discover Balingasag’s natural scenery, culture, and travel options from Misamis Oriental, Philippines.">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Balingasag — Where Nature Thrives</title>
<link rel="icon" type="image/png" href="/Logo/BTLogo.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
  :root{
    --forest:#173B2B;
    --forest-dark:#0F2B1F;
    --sage:#8FB89E;
    --sage-light:#E7F1EA;
    --cream:#FBFAF6;
    --ink:#1C2A22;
    --ink-soft:#5B6D62;
    --line:#DDE5DE;
  }
  *{margin:0;padding:0;box-sizing:border-box;}
  .skip-link{position:absolute;left:-999px;top:auto;width:1px;height:1px;overflow:hidden;}
  .skip-link:focus{position:fixed;left:16px;top:16px;width:auto;height:auto;padding:12px 16px;background:#173B2B;color:#fff;border-radius:4px;z-index:999;text-decoration:none;}
  html{scroll-behavior:smooth;}
  body{
    font-family:'Inter',sans-serif;
    color:var(--ink);
    background:var(--cream);
    line-height:1.6;
  }
  h1,h2,h3,.serif{font-family:'Playfair Display',serif;}
  a{text-decoration:none;color:inherit;}
  img{display:block;width:100%;height:100%;object-fit:cover;}
  .eyebrow{
    font-size:.72rem;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:var(--sage);
    font-weight:600;
  }
  .eyebrow.dark{color:var(--forest);}
  .wrap{max-width:1240px;margin:0 auto;padding:0 40px;}

  /* NAV */
  header.nav{
    position:fixed;top:0;left:0;right:0;z-index:50;
    background:rgba(251,250,246,.92);
    backdrop-filter:blur(10px);
    border-bottom:1px solid var(--line);
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }
  header.nav.scrolled{
    background:rgba(251,250,246,.96);
    box-shadow:0 4px 20px -2px rgba(0,0,0,0.08);
    border-bottom-color:rgba(0,0,0,0.08);
  }
  .nav-inner{
    max-width:1240px;margin:0 auto;
    padding:24px 40px;
    display:flex;align-items:center;justify-content:space-between;
    transition:padding 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }
  header.nav.scrolled .nav-inner{
    padding:10px 40px;
  }
  .brand{display:flex;align-items:center;}
  .header-logo{
    height:60px;width:auto;object-fit:contain;display:block;
    transition:height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }
  header.nav.scrolled .header-logo{
    height:36px;
  }
  nav.links{display:flex;align-items:center;gap:34px;}
  nav.links a{
    font-size:0.98rem;color:var(--forest);font-weight:500;
    transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }
  header.nav.scrolled nav.links a{
    font-size:0.88rem;
  }
  nav.links a:hover{color:var(--sage);}
  .btn{
    padding:11px 20px;border-radius:2px;font-size:.86rem;font-weight:600;
    display:inline-block;white-space:nowrap;transition:all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .nav .btn-primary{
    padding:12px 24px;border-radius:4px;font-size:.9rem;font-weight:600;
    background:var(--forest);color:#fff;
  }
  header.nav.scrolled .nav .btn-primary{
    padding:8px 18px;font-size:.82rem;
  }
  .btn:hover{opacity:.85;}
  .btn-outline{border:1.5px solid var(--forest);color:var(--forest);}
  .btn-outline-light{border:1.5px solid rgba(255,255,255,.7);color:#fff;}
  .btn-light{background:#fff;color:var(--forest);}

  /* HERO */
  .hero{
    position:relative;height:92vh;min-height:640px;
    display:flex;align-items:center;
    color:#fff;overflow:hidden;
    padding-left:clamp(3rem, 6vw, 9rem);
  }
  .hero video{
    position:absolute;inset:0;
    z-index:0;
    width:100%;
    height:100%;
    object-fit:cover;
  }
  .hero::after{
    content:"";position:absolute;inset:0;
    background:linear-gradient(180deg, rgba(15,30,22,.55) 0%, rgba(15,30,22,.35) 45%, rgba(15,30,22,.75) 100%);
    z-index:1;
  }
  .hero-content{position:relative;z-index:2;max-width:760px;padding:0 40px 0 5rem;}
  .hero .eyebrow{color:#CDE3D5;margin-bottom:22px;display:block;}
  .hero h1{
    font-size:5rem;font-weight:500;line-height:1.02;letter-spacing:-.01em;max-width:11ch;
  }
  .hero h1 em{
    font-style:italic;color:#A6C4A0;font-weight:400;display:block;text-shadow:0 2px 6px rgba(0,0,0,0.22);
  }
  .hero p{
    margin:26px 0 34px;font-size:1.05rem;max-width:560px;color:#EAF1EC;
    font-weight:400;
  }
  .hero-ctas{display:flex;gap:14px;flex-wrap:wrap;}
  /* BALANCED MODERN LUXURY MODAL */
  .modal-overlay{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(12,24,17,0);backdrop-filter:blur(0px);-webkit-backdrop-filter:blur(0px);z-index:9999;opacity:0;visibility:hidden;pointer-events:none;transition:opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1), backdrop-filter 0.35s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.35s ease;}
  .modal-overlay.active{opacity:1;visibility:visible;pointer-events:auto;background:rgba(12,24,17,.68);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);}
  
  .modal{width:min(92vw,650px);max-height:90vh;overflow-y:auto;background:#ffffff;border-radius:24px;box-shadow:0 28px 72px -16px rgba(12,24,17,.32), 0 0 0 1px rgba(23,59,43,.08);padding:34px 40px;position:relative;transform:scale(0.94) translateY(16px);opacity:0;transition:transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.32s ease;}
  .modal-overlay.active .modal{transform:scale(1) translateY(0);opacity:1;}
  
  .modal-close{position:absolute;top:20px;right:20px;width:34px;height:34px;border:1px solid #e2eae4;border-radius:50%;background:#f7faf8;color:#173b2b;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s ease;}
  .modal-close:hover{background:#173b2b;color:#fff;border-color:#173b2b;transform:rotate(90deg);}
  
  .modal-header{margin-bottom:18px;}
  .modal-brand-tag{display:inline-flex;align-items:center;gap:6px;font-size:0.7rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#173b2b;background:#edf4ef;padding:3px 10px;border-radius:99px;margin-bottom:8px;}
  .brand-dot{width:6px;height:6px;border-radius:50%;background:#2e6b4e;}
  .modal h2{margin:0 0 4px;font-size:1.65rem;color:#173b2b;font-family:'Playfair Display',serif;font-weight:600;}
  .modal p{margin:0;color:#5c7365;font-size:0.85rem;line-height:1.45;}

  /* TAB SWITCHER */
  .modal-tabs{display:flex;gap:4px;background:#f0f5f1;padding:3px;border-radius:12px;margin-bottom:18px;}
  .tab-button{flex:1;padding:8px 12px;border-radius:9px;border:none;background:transparent;color:#5a7364;font-weight:600;font-size:0.85rem;cursor:pointer;transition:all 0.25s ease;}
  .tab-button:hover{color:#173b2b;}
  .tab-button.active{background:#ffffff;color:#173b2b;box-shadow:0 2px 8px rgba(0,0,0,0.06);font-weight:700;}

  .modal-body-container{position:relative;min-height:220px;}
  .tab-panel{position:absolute;top:0;left:0;right:0;opacity:0;pointer-events:none;transform:translateX(16px);transition:opacity 0.26s cubic-bezier(0.16, 1, 0.3, 1), transform 0.26s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.26s ease;visibility:hidden;}
  .tab-panel.active{position:relative;opacity:1;pointer-events:auto;transform:translateX(0);visibility:visible;}
  .tab-panel.slide-left{transform:translateX(-16px);}

  /* FORMS & INPUTS */
  .modal form{display:grid;gap:10px;}
  .form-section-header{display:flex;align-items:center;margin-top:4px;margin-bottom:-2px;}
  .section-title{font-size:0.67rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#173b2b;background:#edf4ef;padding:2px 8px;border-radius:6px;}
  .form-group{display:grid;gap:3px;}
  .form-row{display:grid;grid-template-columns:repeat(2, 1fr);gap:12px;}
  .form-row.name-row{grid-template-columns: 2fr 1.1fr 2fr;}
  @media (max-width: 540px){
    .modal { padding: 24px 20px; width: min(94vw, 480px); }
    .form-row, .form-row.name-row{grid-template-columns:1fr; gap: 10px;}
  }
  .label-row{display:flex;justify-content:space-between;align-items:center;}
  .modal label{font-size:.79rem;font-weight:600;color:#243d2e;}
  .modal label .optional-tag{font-size:0.72rem;font-weight:400;color:#7a9182;margin-left:4px;}
  .forgot-link{font-size:.78rem;color:#173b2b;text-decoration:none;font-weight:600;}
  .forgot-link:hover{text-decoration:underline;}
  .terms-link{color:#173b2b;font-weight:600;text-decoration:underline;}
  .terms-link:hover{color:#0d241a;}

  .input-container{position:relative;display:flex;align-items:center;}
  .field-icon{position:absolute;left:12px;color:#7e9687;pointer-events:none;transition:color 0.2s ease;}
  .modal input[type="text"], .modal input[type="email"], .modal input[type="password"], .modal input[type="tel"], .modal select{
    width:100%;height:38px;padding:0 12px 0 38px;border:1.5px solid #cfdbd2;border-radius:10px;background:#fbfdfb;color:#172a1f;font-size:0.85rem;font-weight:500;outline:none;transition:all 0.2s ease;
  }
  .modal select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23536d5d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 32px;
    cursor: pointer;
  }
  .input-container:focus-within .field-icon{color:#173b2b;}
  .modal input:focus, .modal select:focus{border-color:#173b2b;background:#ffffff;box-shadow:0 0 0 3px rgba(23,59,43,0.12);}

  .toggle-password{position:absolute;right:8px;background:none;border:none;cursor:pointer;color:#7e9687;padding:4px;display:flex;align-items:center;justify-content:center;transition:color 0.2s ease;}
  .toggle-password:hover{color:#173b2b;}

  .form-options{display:flex;align-items:center;margin-top:2px;}
  .checkbox-label{display:flex;align-items:center;gap:8px;font-size:0.8rem;color:#536d5d;cursor:pointer;user-select:none;}
  .checkbox-label input[type="checkbox"]{accent-color:#173b2b;width:14px;height:14px;cursor:pointer;}

  /* SUBMIT BUTTON */
  .modal .modal-submit{
    margin-top:6px;height:42px;padding:0 18px;border:none;border-radius:10px;background:#173b2b;color:#ffffff;
    font-weight:600;font-size:0.88rem;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;
    transition:all 0.25s cubic-bezier(0.16, 1, 0.3, 1);box-shadow:0 4px 14px rgba(23,59,43,0.22);
  }
  .modal .modal-submit:hover{background:#1d4835;transform:translateY(-1px);box-shadow:0 6px 20px rgba(23,59,43,0.32);}
  .modal .modal-submit:hover svg{transform:translateX(3px);}
  .modal .modal-submit svg{transition:transform 0.2s ease;}
  .modal .modal-submit:active{transform:translateY(0);}

  .form-footer{margin-top:16px;text-align:center;font-size:0.83rem;color:#5a7364;}
  .form-footer .modal-switch{color:#173b2b;font-weight:700;text-decoration:none;margin-left:4px;}
  .form-footer .modal-switch:hover{text-decoration:underline;}

  /* MEDIUM & TABLET SCREEN RESPONSIVE */
  @media (max-width: 768px) {
    .modal {
      width: min(94vw, 480px);
      padding: 24px 24px;
      border-radius: 18px;
    }
    .modal h2 { font-size: 1.45rem; }
    .modal p { font-size: 0.82rem; }
    .modal input[type="text"], 
    .modal input[type="email"], 
    .modal input[type="password"], 
    .modal input[type="tel"] {
      padding: 9px 11px 9px 36px;
      font-size: 0.85rem;
    }
    .field-icon { left: 11px; }
  }

  /* SMALL SCREEN RESPONSIVE (COMPACT) */
  @media (max-width: 576px) {
    .modal {
      width: min(94vw, 420px);
      padding: 20px 18px;
      border-radius: 16px;
    }
    .modal-header { margin-bottom: 12px; }
    .modal h2 { font-size: 1.3rem; }
    .modal p { font-size: 0.78rem; line-height: 1.35; }
    .modal-brand-tag { font-size: 0.65rem; padding: 2px 8px; margin-bottom: 6px; }
    .modal-tabs { margin-bottom: 12px; padding: 2px; }
    .tab-button { padding: 6px 8px; font-size: 0.78rem; }
    .modal form { gap: 8px; }
    .form-group { gap: 3px; }
    .form-row { grid-template-columns: 1fr; gap: 8px; }
    .modal label { font-size: 0.75rem; }
    .modal label .optional-tag { font-size: 0.68rem; }
    .modal input[type="text"], 
    .modal input[type="email"], 
    .modal input[type="password"], 
    .modal input[type="tel"] {
      padding: 8px 10px 8px 32px;
      font-size: 0.8rem;
      border-radius: 8px;
    }
    .modal input::placeholder { font-size: 0.78rem; }
    .field-icon { left: 10px; width: 15px; height: 15px; }
    .toggle-password { right: 6px; padding: 2px; }
    .toggle-password svg { width: 14px; height: 14px; }
    .checkbox-label { font-size: 0.73rem; gap: 6px; }
    .checkbox-label input[type="checkbox"] { width: 13px; height: 13px; }
    .modal .modal-submit { padding: 9px 14px; font-size: 0.83rem; border-radius: 8px; margin-top: 2px; }
    .form-footer { margin-top: 10px; font-size: 0.76rem; }
  }

  /* EXTRA SMALL MOBILE BREAKPOINT (<= 380px) */
  @media (max-width: 380px) {
    .modal {
      padding: 16px 14px;
    }
    .modal h2 { font-size: 1.2rem; }
    .modal input[type="text"], 
    .modal input[type="email"], 
    .modal input[type="password"], 
    .modal input[type="tel"] {
      padding: 7px 8px 7px 30px;
      font-size: 0.78rem;
    }
    .field-icon { left: 8px; width: 14px; height: 14px; }
    .checkbox-label { font-size: 0.7rem; }
  }
  .scroll-tag{
    position:absolute;right:40px;bottom:120px;z-index:2;
    writing-mode:vertical-rl;font-size:.72rem;letter-spacing:.2em;
    color:rgba(255,255,255,.75);display:flex;align-items:center;gap:10px;
  }
  .scroll-tag::after{content:"";width:1px;height:60px;background:rgba(255,255,255,.5);}

  /* STATS */
  .stats{background:var(--forest);color:#fff;}
  .stats-grid{
    max-width:1240px;margin:0 auto;padding:44px 40px;
    display:grid;grid-template-columns:repeat(4,1fr);gap:20px;
  }
  .stat b{
    font-family:'Playfair Display',serif;font-size:2.3rem;font-weight:500;
    color:#fff;display:block;
  }
  .stat span{
    font-size:.68rem;letter-spacing:.1em;text-transform:uppercase;
    color:#AEC9B9;display:block;margin-top:6px;
  }

  /* SECTION generic */
  section{padding:110px 0;}
  .section-tight{padding:80px 0;}
  hr.div{border:none;border-top:1px solid var(--line);margin:0;}

  /* ABOUT */
  .about-grid{
    display:grid;grid-template-columns:1fr 1fr;gap:70px;align-items:center;
  }
  .about-grid h2{font-size:2.6rem;font-weight:500;line-height:1.12;margin:16px 0 22px;}
  .about-grid h2 em{font-style:italic;color:var(--forest);font-weight:400;}
  .rule{width:56px;height:2px;background:var(--forest);margin-bottom:24px;}
  .about-grid p{color:var(--ink-soft);margin-bottom:16px;max-width:480px;}
  .about-img{position:relative;}
  .about-img .frame{
    aspect-ratio:4/3.1;overflow:hidden;border-radius:2px;
  }
  .badge{
    position:absolute;left:-40px;bottom:-30px;background:var(--sage-light);
    padding:22px 28px;
  }
  .badge .k{font-size:.72rem;letter-spacing:.08em;color:var(--ink-soft);text-transform:uppercase;}
  .badge .v{font-family:'Playfair Display',serif;font-size:1.6rem;color:var(--forest);font-weight:600;}

  /* ATTRACTIONS */
  .att-head{display:flex;justify-content:space-between;align-items:flex-end;gap:40px;margin-bottom:44px;flex-wrap:wrap;}
  .att-head h2{font-size:2.6rem;font-weight:500;}
  .att-head .note{color:var(--ink-soft);font-size:.95rem;max-width:280px;}
  .att-layout{display:grid;grid-template-columns:1.3fr 1fr;gap:0;border:1px solid var(--line);}
  .att-feature{position:relative;min-height:460px;}
  .att-feature .tag{
    position:absolute;top:24px;left:24px;color:#fff;font-size:.68rem;
    letter-spacing:.14em;text-transform:uppercase;background:rgba(23,59,43,.55);
    padding:6px 12px;
  }
  .att-feature-info{
    position:absolute;left:0;right:0;bottom:0;padding:30px;
    background:linear-gradient(0deg, rgba(10,20,15,.85), rgba(10,20,15,0));
    color:#fff;
  }
  .att-feature-info h3{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:500;margin-bottom:8px;}
  .att-feature-info p{color:#DCE9E1;font-size:.92rem;max-width:420px;}
  .att-list{display:flex;flex-direction:column;}
  .att-item{
    display:flex;align-items:center;justify-content:space-between;
    padding:22px 30px;border-bottom:1px solid var(--line);cursor:pointer;
    transition:background .2s;
  }
  .att-item:last-child{border-bottom:none;}
  .att-item:hover{background:var(--sage-light);}
  .att-item.active{background:var(--sage-light);}
  .att-item .left{display:flex;align-items:center;gap:18px;}
  .att-item .num{font-family:'Playfair Display',serif;color:var(--ink-soft);font-size:.95rem;}
  .att-item .ti{font-weight:600;font-size:.98rem;}
  .att-item .sub{font-size:.8rem;color:var(--ink-soft);}
  .att-item .arrow{color:var(--ink-soft);}

  /* LANDSCAPES */
  .land-grid{
    display:grid;
    grid-template-columns:1.55fr 1fr;
    grid-template-rows:repeat(2, 220px);
    gap:14px;
  }
  .land-grid .g1{grid-row:1/3;min-height:460px;}
  .land-grid figure{overflow:hidden;border-radius:2px;position:relative;height:100%;}
  .land-grid img{transition:transform .5s ease;}
  .land-grid figure:hover img{transform:scale(1.06);}
  .land-grid figure:nth-child(n+2){min-height:220px;}


  /* CULTURE */
  .cult-grid{display:grid;grid-template-columns:1fr 1fr;gap:70px;}
  .cult-grid h2{font-size:2.6rem;font-weight:500;line-height:1.12;margin:16px 0 22px;}
  .cult-grid h2 em{font-style:italic;color:var(--forest);font-weight:400;}
  .cult-grid > div:first-child p{color:var(--ink-soft);margin-bottom:16px;max-width:460px;}
  .fest-card{
    border:1px solid var(--line);padding:22px 26px;display:flex;gap:20px;margin-bottom:16px;
  }
  .fest-card .date{text-align:center;min-width:60px;}
  .fest-card .date .d{font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--forest);font-weight:600;}
  .fest-card .date .m{font-size:.62rem;letter-spacing:.1em;color:var(--ink-soft);text-transform:uppercase;}
  .fest-card h4{font-size:1.02rem;font-weight:700;margin-bottom:6px;}
  .fest-card p{font-size:.87rem;color:var(--ink-soft);}

  /* TRAVEL */
  .travel-hero{text-align:center;max-width:680px;margin:0 auto 56px;}
  .travel-hero h2{font-size:2.7rem;font-weight:500;}
  .travel-hero p{color:var(--ink-soft);margin-top:14px;}
  .travel-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:20px;}
  .tcard{background:var(--sage-light);padding:28px 24px;}
  .tcard .ic{font-size:1.4rem;margin-bottom:18px;}
  .tcard .lbl{font-size:.72rem;letter-spacing:.1em;font-weight:700;color:var(--forest);margin-bottom:12px;}
  .tcard p{font-size:.86rem;color:var(--ink-soft);}
  .best-time{
    background:var(--forest);color:#fff;padding:44px;
    display:grid;grid-template-columns:1.3fr 1fr;gap:40px;align-items:center;
  }
  .best-time h3{font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:500;margin-bottom:14px;}
  .best-time p{color:#D6E5DB;font-size:.92rem;}
  .season{display:flex;gap:12px;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.15);}
  .season:last-child{border-bottom:none;}
  .season .dot{width:7px;height:7px;border-radius:50%;background:var(--sage);margin-top:6px;flex-shrink:0;}
  .season b{display:block;font-size:.92rem;}
  .season span{font-size:.78rem;color:#B9D2C4;}

  /* FOOTER */
  footer{background:var(--forest-dark);color:#EAF1EC;padding:70px 0 30px;}
  .foot-logo{height:48px;width:auto;object-fit:contain;display:block;margin-bottom:14px;}
  .foot-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:50px;margin-bottom:50px;}
  footer h3{font-family:'Playfair Display',serif;font-size:1.5rem;color:#fff;margin-bottom:6px;}
  .foot-loc{font-size:.7rem;letter-spacing:.1em;color:var(--sage);text-transform:uppercase;margin-bottom:18px;}
  footer .foot-grid > div:first-child p{color:#AEC4B7;font-size:.9rem;max-width:320px;}
  .foot-h{font-size:.7rem;letter-spacing:.12em;color:var(--sage);text-transform:uppercase;margin-bottom:18px;}
  .foot-links a{display:block;color:#D3E3D9;font-size:.9rem;margin-bottom:12px;}
  .foot-links a:hover{color:#fff;}
  .foot-bottom{
    border-top:1px solid rgba(255,255,255,.12);padding-top:26px;
    display:flex;justify-content:space-between;font-size:.78rem;color:#7FA090;flex-wrap:wrap;gap:10px;
  }

  /* RESPONSIVE */
  @media (max-width:900px){
    nav.links{display:none;}
    .hero h1{font-size:3rem;}
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .about-grid,.cult-grid{grid-template-columns:1fr;gap:36px;}
    .badge{position:static;margin-top:-40px;margin-left:20px;width:fit-content;}
    .att-layout{grid-template-columns:1fr;}
    .land-grid{grid-template-columns:1fr;grid-template-rows:repeat(5,200px);}
    .land-grid .g1{grid-column:1/1;grid-row:1/2;height:auto;}
    .travel-cards{grid-template-columns:1fr 1fr;}
    .best-time{grid-template-columns:1fr;}
    .foot-grid{grid-template-columns:1fr;gap:34px;}
  }
</style>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<main id="main-content">

<header class="nav">
  <div class="nav-inner">
    <a href="/" class="brand" aria-label="BaliTour Home">
      <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="header-logo">
    </a>
    <nav class="links" aria-label="Primary navigation">
      <a href="#about">About</a>
      <a href="#attractions">Attractions</a>
      <a href="#nature">Nature</a>
      <a href="#culture">Culture</a>
      <a href="#visit">Visit</a>
    </nav>
    <button type="button" class="btn btn-primary open-modal">Plan Your Visit</button>
  </div>
</header>

<section class="hero">
  <video autoplay muted loop playsinline aria-label="Balingasag hero video background">
    <source src="/hero-video.mp4" type="video/mp4">
    Your browser does not support video playback.
  </video>
  <div class="hero-content">
    <span class="eyebrow">Municipality of Balingasag · Misamis Oriental · Philippines</span>
    <h1>Where Nature<em>Thrives.</em></h1>
    <p>Discover the unspoiled forests, thermal springs, and vibrant cultural heritage of Balingasag — a hidden gem nestled along the coast of Macajalar Bay.</p>
    <div class="hero-ctas">
      <a href="#attractions" class="btn btn-light">Explore Attractions ↓</a>
      <button type="button" class="btn btn-outline-light open-modal">Plan Your Visit</button>
    </div>
  </div>
  <div class="scroll-tag">SCROLL</div>
</section>

@include('modals.login-register-modal')

<div class="stats">
  <div class="stats-grid">
    <div class="stat"><b>6+</b><span>Tourist Destinations</span></div>
    <div class="stat"><b>28</b><span>Barangays</span></div>
    <div class="stat"><b>78km²</b><span>Total Land Area</span></div>
    <div class="stat"><b>~75k</b><span>Population (2020)</span></div>
  </div>
</div>

<section id="about">
  <div class="wrap about-grid">
    <div>
      <span class="eyebrow dark">§ 01 — About</span>
      <h2>A Municipality<br><em>of Quiet Beauty</em></h2>
      <div class="rule"></div>
      <p>Balingasag is a first-class municipality in the province of Misamis Oriental, Northern Mindanao, Philippines. Situated along the coastline of Macajalar Bay, it is flanked by the verdant Balatukan Mountain Range to the south.</p>
      <p>Known for its abundant natural resources â€” from thermal springs and pristine waterfalls to fertile agricultural land â€” Balingasag offers visitors an authentic encounter with Mindanao's untouched landscapes and warm cultural traditions.</p>
    </div>
    <div class="about-img">
      <div class="frame">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Banaue%20Philippines%20Batad-Rice-Terraces-03.jpg?width=1000" alt="Rice terraces">
      </div>
      <div class="badge">
        <div class="k">Est.</div>
        <div class="v">1854</div>
      </div>
    </div>
  </div>
</section>

<hr class="div">

<section id="attractions">
  <div class="wrap">
    <div class="att-head">
      <div>
        <span class="eyebrow dark">§ 02 — Attractions</span>
        <h2>Places to Explore</h2>
      </div>
      <div class="note">Six distinct destinations spanning mountain, forest, river, and coast.</div>
    </div>
    <div class="att-layout">
      <div class="att-feature">
        <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Banaue%20Rice%20Terraces%2C%20The%20Legacy%20Continues.jpg?width=1000" alt="Agriculture park terraces">
        <div class="att-feature-info">
          <span class="tag">Agri-Tourism</span>
          <h3 style="margin-top:14px;">Balingasag Agriculture Park</h3>
          <p>Rolling farmland showcasing the region's rice cultivation heritage, offering guided tours of traditional farming practices.</p>
        </div>
      </div>
      <div class="att-list">
        <div class="att-item"><div class="left"><span class="num">01</span><div><div class="ti">Balingasag Hot Spring</div><div class="sub">Natural Springs</div></div></div><span class="arrow">â†’</span></div>
        <div class="att-item"><div class="left"><span class="num">02</span><div><div class="ti">Balingasag Falls</div><div class="sub">Waterfall</div></div></div><span class="arrow">â†’</span></div>
        <div class="att-item"><div class="left"><span class="num">03</span><div><div class="ti">Bendum River</div><div class="sub">River & Swimming</div></div></div><span class="arrow">â†’</span></div>
        <div class="att-item"><div class="left"><span class="num">04</span><div><div class="ti">Mount Balatukan Trail</div><div class="sub">Hiking & Trek</div></div></div><span class="arrow">â†’</span></div>
        <div class="att-item active"><div class="left"><span class="num">05</span><div><div class="ti">Balingasag Agriculture Park</div><div class="sub">Agri-Tourism</div></div></div><span class="arrow">â†’</span></div>
        <div class="att-item"><div class="left"><span class="num">06</span><div><div class="ti">Balingasag Beach</div><div class="sub">Coastal</div></div></div><span class="arrow">â†’</span></div>
      </div>
    </div>
  </div>
</section>

<section id="nature">
  <div class="wrap">
      <span class="eyebrow dark">§ 03 — Natural Scenery</span>
    <h2 style="font-size:2.6rem;font-weight:500;margin-bottom:36px;">Landscapes of Balingasag</h2>
    <div class="land-grid">
      <figure class="g1"><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Palawan%2C%20Philippines%2C%20Jungle.jpg?width=800" alt="Green hills trail"></figure>
      <figure><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Rice%20Terraces%20Banaue.jpg?width=800" alt="Mountain range"></figure>
      <figure><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Palawan%2C%20Tropical%20jungle%20rainforest.jpg?width=800" alt="River and mountain"></figure>
      <figure><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Pana%20Banaue%20Rice%20Terraces.jpg?width=800" alt="Rice terraces path"></figure>
      <figure><img src="https://commons.wikimedia.org/wiki/Special:FilePath/Talagib%20Falls.jpg?width=800" alt="Blue lagoon pool"></figure>
    </div>
  </div>
</section>

<hr class="div">

<section id="culture">
  <div class="wrap cult-grid">
    <div>
      <span class="eyebrow dark">§ 04 — Culture & Heritage</span>
      <h2>Traditions<br><em>Kept Alive</em></h2>
      <div class="rule"></div>
      <p>The people of Balingasag â€” a blend of Cebuano, Higaonon, and Maranao communities â€” maintain a rich living culture of festivals, indigenous music, and traditional crafts that have endured through generations.</p>
      <p>The local weaving traditions and agricultural practices of the Higaonon indigenous peoples are recognized as integral to Balingasag's identity and continue to be practiced in upland communities today.</p>
    </div>
    <div>
      <div class="fest-card">
        <div class="date"><div class="d">01</div><div class="m">January</div></div>
        <div><h4>Kanduli Festival</h4><p>An annual celebration of Balingasag's founding anniversary featuring street dances, cultural presentations, and the coronation of local royalty.</p></div>
      </div>
      <div class="fest-card">
        <div class="date"><div class="d">02</div><div class="m">May</div></div>
        <div><h4>Feast of San Isidro</h4><p>The patron saint's feast day, marked by solemn processions, traditional Bukidnon music, and communal feasting across the municipality.</p></div>
      </div>
      <div class="fest-card">
        <div class="date"><div class="d">03</div><div class="m">October</div></div>
        <div><h4>Harvest Festival</h4><p>A thanksgiving celebration of the agricultural harvest season, featuring local produce exhibits, folk performances, and traditional craftsmanship.</p></div>
      </div>
    </div>
  </div>
</section>

<section id="visit" style="background:#fff;">
  <div class="wrap">
    <div class="travel-hero">
      <span class="eyebrow dark">Â§ 05 â€” Travel Guide</span>
      <h2>How to Get Here</h2>
      <p>Balingasag is easily accessible from Cagayan de Oro City and Laguindingan Airport, making it a natural extension of any Northern Mindanao itinerary.</p>
    </div>
    <div class="travel-cards">
      <div class="tcard"><div class="ic">âœˆï¸</div><div class="lbl">BY AIR</div><p>Fly into Laguindingan International Airport (CGY), Misamis Oriental. Balingasag is approximately 45 minutes by road from the terminal.</p></div>
      <div class="tcard"><div class="ic">ðŸšŒ</div><div class="lbl">BY BUS</div><p>Regular bus services connect Cagayan de Oro City to Balingasag daily. The journey takes approximately 1.5 hours via the Coastal Road.</p></div>
      <div class="tcard"><div class="ic">ðŸš</div><div class="lbl">BY VAN</div><p>Shared van services (v-hire) depart from Agora Market in Cagayan de Oro City throughout the day. Travel time is roughly 1 hour.</p></div>
      <div class="tcard"><div class="ic">ðŸš—</div><div class="lbl">BY PRIVATE CAR</div><p>Take the national highway eastward from Cagayan de Oro. Follow signage toward Balingasag along the Misamis Oriental coastal route.</p></div>
    </div>
    <div class="best-time">
      <div>
        <h3>Best Time to Visit</h3>
        <p>Balingasag enjoys a relatively dry season from November through April, making these months ideal for outdoor activities. The months of December through February offer cooler temperatures and clear skies, perfect for trekking the Balatukan Range.</p>
      </div>
      <div>
        <div class="season"><div class="dot"></div><div><b>Nov â€“ Feb</b><span>Dry Season Â· Ideal Trekking</span></div></div>
        <div class="season"><div class="dot"></div><div><b>Mar â€“ May</b><span>Warm Â· Festival Season</span></div></div>
        <div class="season"><div class="dot"></div><div><b>Jun â€“ Oct</b><span>Wet Season Â· Lush Scenery</span></div></div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div>
        <a href="/" aria-label="BaliTour Home">
          <img src="/Logo/BTLogo.png" alt="BaliTour Logo" class="foot-logo">
        </a>
        <div class="foot-loc">Misamis Oriental, Philippines</div>
        <p>Promoting the natural wonders and cultural heritage of Balingasag for sustainable and responsible tourism.</p>
      </div>
      <div>
        <div class="foot-h">Quick Links</div>
        <div class="foot-links">
          <a href="#about">About</a>
          <a href="#attractions">Attractions</a>
          <a href="#nature">Nature</a>
          <a href="#culture">Culture</a>
          <a href="#visit">Visit</a>
        </div>
      </div>
      <div>
        <div class="foot-h">Contact & Info</div>
        <p style="color:#D3E3D9;font-size:.9rem;margin-bottom:8px;">Municipal Hall, Balingasag</p>
        <p style="color:#D3E3D9;font-size:.9rem;margin-bottom:8px;">Misamis Oriental, 9005</p>
        <p style="color:#D3E3D9;font-size:.9rem;margin-bottom:14px;">Philippines</p>
        <p style="color:var(--sage);font-size:.9rem;">tourism@balingasag.gov.ph</p>
      </div>
    </div>
    <div class="foot-bottom">
      <span>Â© 2025 Balingasag Tourism Office. All rights reserved.</span>
      <span>Made for the people of Balingasag.</span>
    </div>
  </div>
</footer>
</main>
<script>
  const modal = document.getElementById('accessModal');
  const openButtons = document.querySelectorAll('.open-modal');
  const closeButton = modal.querySelector('.modal-close');
  const tabButtons = modal.querySelectorAll('.tab-button');
  const panels = modal.querySelectorAll('.tab-panel');
  const switchLinks = modal.querySelectorAll('.modal-switch');

  function openModal() {
    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  function activateTab(targetId) {
    const isRegister = targetId === 'registerTab';
    tabButtons.forEach(btn => {
      const isActive = btn.dataset.target === targetId;
      btn.classList.toggle('active', isActive);
      btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });
    panels.forEach(panel => {
      if (panel.id === targetId) {
        panel.classList.remove('slide-left');
        panel.classList.add('active');
      } else {
        panel.classList.remove('active');
        if (isRegister) {
          panel.classList.add('slide-left');
        } else {
          panel.classList.remove('slide-left');
        }
      }
    });
  }

  openButtons.forEach(btn => btn.addEventListener('click', event => {
    event.preventDefault();
    openModal();
  }));

  closeButton.addEventListener('click', closeModal);
  modal.addEventListener('click', event => {
    if (event.target === modal) {
      closeModal();
    }
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && modal.classList.contains('active')) {
      closeModal();
    }
  });

  tabButtons.forEach(button => {
    button.addEventListener('click', () => activateTab(button.dataset.target));
  });

  switchLinks.forEach(link => {
    link.addEventListener('click', event => {
      event.preventDefault();
      activateTab(link.dataset.switch);
    });
  });

  document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', () => {
      const input = button.previousElementSibling;
      if (input && (input.type === 'password' || input.type === 'text')) {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        button.innerHTML = isPassword 
          ? `<svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`
          : `<svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
      }
    });
  });

  // Interactive header expand/shrink on scroll
  const siteHeader = document.querySelector('header.nav');
  if (siteHeader) {
    const handleHeaderScroll = () => {
      if (window.scrollY > 40) {
        siteHeader.classList.add('scrolled');
      } else {
        siteHeader.classList.remove('scrolled');
      }
    };
    window.addEventListener('scroll', handleHeaderScroll, { passive: true });
    handleHeaderScroll();
  }
</script>

</body>
</html>
