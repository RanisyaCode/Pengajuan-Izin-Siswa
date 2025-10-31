<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="description" content="Aplikasi Pengajuan Izin Siswa berbasis web untuk mempermudah siswa, wali kelas, dan admin dalam proses perizinan.">
  <meta name="keywords" content="izin siswa, absensi, sekolah digital, e-perizinan">
  <title>E-SiswaIzin - Aplikasi Pengajuan Izin Siswa Digital</title>

  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />
  <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="{{ asset('arsha/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('arsha/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('arsha/assets/css/style.css') }}" rel="stylesheet">

  <style>
    :root {
      --primary: #a2d5f2;
      --secondary: #ffd6a5;
      --accent: #ffb3c1;
      --highlight: #3b82f6;
      --text: #164c98;
      --heading: #3263a7;
      --nav-text: #5b7087;
      --nav-hover: #ff9aa2;
      --light-bg: #f9fcfe;
      --card-bg: #a8c8e8;
      --white: #ffffff;
      --gradient-primary: linear-gradient(135deg, var(--highlight), var(--accent));
      --gradient-hero: linear-gradient(135deg,rgb(80, 105, 212) 0%,rgb(195, 49, 173) 100%);
      --gradient-card: linear-gradient(145deg, rgba(168, 200, 232, 0.3), rgba(255, 255, 255, 0.95));
      --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      --transition-base: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --shadow-sm: 0 2px 10px rgba(162, 213, 242, 0.08);
      --shadow-md: 0 10px 40px rgba(162, 213, 242, 0.15);
      --shadow-lg: 0 20px 60px rgba(162, 213, 242, 0.25);
      --spacing-sm: 1rem;
      --spacing-md: 2rem;
      --spacing-lg: 3rem;
      --spacing-xl: 4rem;
      --spacing-2xl: 6rem;
      --radius-sm: 10px;
      --radius-md: 20px;
      --radius-lg: 30px;
      --radius-full: 9999px;
    }
  
    *, *::before, *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
  
    html {
      scroll-behavior: smooth;
      -webkit-font-smoothing: antialiased;
    }
  
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      color: var(--text);
      background: var(--light-bg);
      overflow-x: hidden;
      line-height: 1.7;
      font-size: 16px;
    }
  
    a {
      text-decoration: none !important;
      color: inherit;
    }
  
    .section {
      padding: var(--spacing-2xl) 0;
      position: relative;
    }
  
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 var(--spacing-md);
    }
  
    /* Header */
    .header {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      box-shadow: var(--shadow-sm);
      padding: 1.2rem 0;
      transition: var(--transition-base);
    }
  
    .header.scrolled {
      padding: 0.8rem 0;
      box-shadow: 0 4px 25px rgba(162, 213, 242, 0.18);
    }
  
    .logo h1 {
      color: var(--heading);
      font-weight: 800;
      font-size: clamp(1.3rem, 4vw, 1.6rem);
      margin: 0;
      letter-spacing: -0.5px;
      background: var(--gradient-primary);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .navmenu ul {
      list-style: none;
      display: flex;
      gap: 2.5rem;
      margin: 0;
      align-items: center;
    }
  
    .navmenu a {
      color: var(--nav-text);
      font-weight: 500;
      font-size: 0.95rem;
      position: relative;
      padding: 0.5rem 0;
      transition: var(--transition-base);
    }
  
    .navmenu a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: var(--gradient-primary);
      transition: width 0.3s ease;
    }
  
    .navmenu a:hover,
    .navmenu a.active {
      color: var(--nav-hover);
    }
  
    .navmenu a:hover::after,
    .navmenu a.active::after {
      width: 100%;
    }
  
    .btn-login {
      background: var(--gradient-primary);
      color: white;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: var(--transition-base);
      padding: 0.7rem 1.8rem;
      border-radius: var(--radius-full);
      font-size: 0.9rem;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
    }
  
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(59, 130, 246, 0.35);
      color: white;
    }
  
    .mobile-toggle {
      display: none;
      font-size: 1.8rem;
      color: var(--heading);
      cursor: pointer;
      transition: var(--transition-fast);
    }

    /* Hero Section - Updated */
    .hero {
      min-height: 100vh;
      background: var(--gradient-hero);
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      padding: 120px 2rem 4rem;
    }

    .hero::before,
    .hero::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      opacity: 0.15;
    }

    .hero::before {
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent 70%);
      top: -200px;
      right: -150px;
      animation: float 20s ease-in-out infinite;
    }

    .hero::after {
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%);
      bottom: -100px;
      left: -100px;
      animation: float 15s ease-in-out infinite reverse;
    }

    @keyframes float {
      0%, 100% {
        transform: translate(0, 0) rotate(0deg);
      }
      33% {
        transform: translate(30px, -30px) rotate(120deg);
      }
      66% {
        transform: translate(-20px, 20px) rotate(240deg);
      }
    }

    .hero-content {
      position: relative;
      z-index: 10;
    }

    .hero-content h1 {
      font-size: clamp(2.5rem, 6vw, 5rem);
      font-weight: 900;
      color: white;
      margin-bottom: 1.5rem;
      line-height: 1.1;
      text-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 0.8s ease;
    }

    .hero-content p {
      font-size: clamp(1rem, 2vw, 1.3rem);
      color: rgba(255, 255, 255, 0.95);
      margin-bottom: 2.5rem;
      line-height: 1.7;
      animation: fadeInUp 0.8s ease 0.2s both;
    }

    .cta-buttons {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      animation: fadeInUp 0.8s ease 0.4s both;
    }

    .btn-hero {
      padding: 1.2rem 2.5rem;
      border-radius: 50px;
      font-weight: 700;
      font-size: 1.1rem;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-primary-hero {
      background: white;
      color: #667eea;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    }

    .btn-primary-hero:hover {
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
      color: #667eea;
    }

    .btn-secondary-hero {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary-hero:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateY(-3px);
      color: white;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero-visual {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
      animation: fadeIn 1s ease 0.6s both;
      position: relative;
      z-index: 10;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .icon-card {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 25px;
      padding: 2rem 1.5rem;
      text-align: center;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .icon-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
      transform: translateY(100%);
      transition: transform 0.4s ease;
    }

    .icon-card:hover {
      transform: translateY(-15px) scale(1.05);
      background: rgba(255, 255, 255, 0.25);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
    }

    .icon-card:hover::before {
      transform: translateY(0);
    }

    .icon-card i {
      font-size: 3rem;
      color: white;
      margin-bottom: 1rem;
      display: block;
      transition: all 0.3s ease;
    }

    .icon-card:hover i {
      transform: scale(1.2) rotate(5deg);
    }

    .icon-card h5 {
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
      margin: 0;
    }

    .icon-card:nth-child(1) {
      animation: floatCard 3s ease-in-out infinite;
    }

    .icon-card:nth-child(2) {
      animation: floatCard 3s ease-in-out 0.5s infinite;
    }

    .icon-card:nth-child(3) {
      animation: floatCard 3s ease-in-out 1s infinite;
    }

    .icon-card:nth-child(4) {
      animation: floatCard 3s ease-in-out 1.5s infinite;
    }

    @keyframes floatCard {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .stats-bar {
      margin-top: 3rem;
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
      animation: fadeInUp 0.8s ease 0.6s both;
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 900;
      color: white;
      display: block;
      text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    }

    .stat-label {
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.9rem;
      margin-top: 0.5rem;
    }
  
    /* Section Title */
    .section-title {
      margin-bottom: var(--spacing-xl);
      text-align: center;
    }
  
    .section-title h2 {
      font-size: clamp(2rem, 6vw, 2.8rem);
      font-weight: 800;
      background: var(--gradient-primary);
      background-clip: text;             
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: var(--spacing-sm);
      position: relative;
      display: inline-block;
    }
  
    .section-title h2::after {
      content: "";
      position: absolute;
      width: 60%;
      height: 4px;
      bottom: -12px;
      left: 20%;
      background: linear-gradient(90deg, transparent, var(--highlight), transparent);
      border-radius: 2px;
    }
  
    .section-title p {
      font-size: clamp(1rem, 2.5vw, 1.15rem);
      color: var(--text);
      max-width: 700px;
      margin: 1.5rem auto 0;
      line-height: 1.8;
    }
  
    /* Cards */
    .card-box {
      background: rgba(255, 255, 255, 0.95);
      padding: var(--spacing-lg);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
      backdrop-filter: blur(10px);
      height: 100%;
      border: 1px solid rgba(255, 255, 255, 0.5);
      transition: var(--transition-base);
    }
  
    .card-box:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-lg);
    }
  
    .card-box.gradient {
      background: var(--gradient-card);
    }
  
    .card-box h5 {
      color: var(--heading);
      font-weight: 700;
      font-size: 1.4rem;
      margin-bottom: 1.5rem;
    }
  
    .info-list {
      list-style: none;
      padding: 0;
    }
  
    .info-list li {
      padding: var(--spacing-sm) 0;
      display: flex;
      align-items: flex-start;
      border-bottom: 1px solid rgba(162, 213, 242, 0.2);
      transition: var(--transition-fast);
    }
  
    .info-list li:last-child {
      border-bottom: none;
    }
  
    .info-list li:hover {
      padding-left: 0.5rem;
    }
  
    .info-list i {
      color: var(--highlight);
      font-size: 1.6rem;
      margin-right: 1.2rem;
      flex-shrink: 0;
      margin-top: 0.2rem;
    }
  
    .process-step {
      display: flex;
      align-items: center;
      padding: 1.8rem;
      background: rgba(255, 255, 255, 0.8);
      border-radius: var(--radius-md);
      margin-bottom: 1.2rem;
      border-left: 4px solid transparent;
      cursor: pointer;
      transition: var(--transition-base);
    }
  
    .process-step:hover {
      transform: translateX(8px);
      border-left-color: var(--highlight);
      background: rgba(255, 255, 255, 1);
      box-shadow: 0 8px 30px rgba(59, 130, 246, 0.15);
    }
  
    .step-num {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: var(--gradient-primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 1.4rem;
      margin-right: 1.8rem;
      flex-shrink: 0;
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
    }
  
    .process-step h6 {
      color: var(--heading);
      font-weight: 700;
      margin-bottom: 0.5rem;
      font-size: 1.1rem;
    }
  
    .process-step p {
      margin: 0;
      font-size: 0.95rem;
      line-height: 1.6;
      color: var(--text);
    }
  
    .feature-card {
      background: linear-gradient(135deg, rgba(168, 200, 232, 0.25), rgba(255, 255, 255, 0.95));
      border-radius: 25px;
      padding: 2.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
      cursor: pointer;
      border: 1px solid rgba(255, 255, 255, 0.6);
      transition: var(--transition-base);
    }
  
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: var(--gradient-primary);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.3s ease;
    }
  
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }
  
    .feature-card:hover::before {
      transform: scaleX(1);
    }
  
    .feature-card h3 {
      color: var(--heading);
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 0;
      display: flex;
      align-items: center;
    }
  
    .feature-num {
      display: inline-flex;
      width: 48px;
      height: 48px;
      background: var(--gradient-primary);
      color: white;
      border-radius: 12px;
      align-items: center;
      justify-content: center;
      margin-right: 1.2rem;
      font-size: 1.1rem;
      font-weight: 700;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
      flex-shrink: 0;
    }
  
    .faq-toggle {
      position: absolute;
      top: 2.5rem;
      right: 2.5rem;
      font-size: 1.6rem;
      color: var(--highlight);
      transition: var(--transition-base);
    }
  
    .feature-card.active .faq-toggle {
      transform: rotate(90deg);
    }
  
    .feature-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), padding-top 0.3s;
      padding-top: 0;
    }
  
    .feature-card.active .feature-content {
      max-height: 600px;
      padding-top: 1.5rem;
    }
  
    .feature-content p {
      line-height: 1.8;
      margin-bottom: 1.5rem;
      color: var(--text);
    }
  
    .demo-box {
      background: white;
      border-radius: 18px;
      padding: 1.5rem;
      margin-top: 1.2rem;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
      border: 1px solid rgba(162, 213, 242, 0.2);
      transition: var(--transition-base);
    }
  
    .demo-box:hover {
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
  
    .demo-screen {
      background: #f8fafc;
      border: 2px solid #e2e8f0;
      border-radius: 14px;
      padding: 1.5rem;
      font-size: 0.9rem;
      color: var(--heading);
    }
  
    .demo-screen .fw-bold {
      font-size: 1rem;
      margin-bottom: var(--spacing-sm);
    }
  
    .demo-btn {
      padding: 0.8rem 1.5rem;
      border-radius: var(--radius-sm);
      font-size: 0.9rem;
      font-weight: 600;
      margin-top: var(--spacing-sm);
      width: 100%;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
      background: var(--gradient-primary);
      color: white;
      border: none;
      cursor: pointer;
      transition: var(--transition-base);
    }
  
    .demo-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
    }
  
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: var(--spacing-sm);
    }
  
    .stat-box {
      background: rgba(255, 255, 255, 0.9);
      padding: 1.5rem;
      border-radius: 18px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid rgba(162, 213, 242, 0.2);
      transition: var(--transition-base);
    }
  
    .stat-box:hover {
      background: white;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      transform: translateY(-3px);
    }
  
    .stat-num {
      font-size: clamp(1.8rem, 5vw, 2.2rem);
      font-weight: 800;
      background: var(--gradient-primary);
      background-clip: text;             
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 0.3rem;
      line-height: 1;
    }
  
    .info-card {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(168, 200, 232, 0.2));
      border-radius: var(--radius-lg);
      padding: var(--spacing-lg);
      box-shadow: 0 15px 50px rgba(162, 213, 242, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.6);
    }
  
    .info-item {
      padding: var(--spacing-md) 0;
      border-bottom: 1px solid rgba(162, 213, 242, 0.2);
      display: flex;
      align-items: flex-start;
      transition: var(--transition-fast);
    }
  
    .info-item:last-child {
      border-bottom: none;
    }
  
    .info-item:hover {
      transform: translateX(5px);
    }
  
    .info-icon {
      background: var(--gradient-primary);
      color: white;
      width: 65px;
      height: 65px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: var(--spacing-md);
      font-size: 1.6rem;
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
      flex-shrink: 0;
    }
  
    .info-item h3 {
      color: var(--heading);
      font-weight: 700;
      margin-bottom: 0.5rem;
      font-size: 1.3rem;
    }
  
    .info-item p {
      margin: 0;
      line-height: 1.7;
      color: var(--text);
    }
  
    .footer {
      background: var(--gradient-primary);
      color: white;
      padding: 3.5rem 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
  
    .footer::before {
      content: '';
      position: absolute;
      width: 350px;
      height: 350px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent 70%);
      bottom: -120px;
      left: -80px;
      border-radius: 50%;
      pointer-events: none;
    }
  
    .footer p {
      font-weight: 600;
      margin-bottom: 0.8rem;
      font-size: 1.05rem;
      position: relative;
      z-index: 2;
    }
  
    .footer .opacity-75 {
      font-weight: 400;
      font-size: 1rem;
      opacity: 0.75;
    }
  
    @media (max-width: 991px) {
      .hero {
        padding: 100px 1.5rem 4rem;
      }
    
      .section {
        padding: 4.5rem 0;
      }
    }
  
    @media (max-width: 768px) {
      .mobile-toggle {
        display: block;
      }
    
      .navmenu {
        position: fixed;
        top: 80px;
        right: -100%;
        width: 75%;
        max-width: 320px;
        height: calc(100vh - 80px);
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(25px);
        box-shadow: -6px 0 30px rgba(0, 0, 0, 0.1);
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 2.5rem 0;
      }
    
      .navmenu.active {
        right: 0;
      }
    
      .navmenu ul {
        flex-direction: column;
        gap: 0;
        padding: 0 var(--spacing-md);
      }
    
      .navmenu ul li {
        width: 100%;
        border-bottom: 1px solid rgba(91, 112, 135, 0.1);
      }
    
      .navmenu a {
        display: block;
        padding: 1.2rem 0;
      }
    
      .navmenu a::after {
        display: none;
      }

      .hero-visual {
        grid-template-columns: 1fr;
        margin-top: 3rem;
      }

      .stats-bar {
        justify-content: space-around;
      }
    
      .card-box,
      .info-card {
        padding: var(--spacing-md);
      }
    
      .info-item {
        flex-direction: column;
        align-items: flex-start;
      }
    
      .info-icon {
        margin-right: 0;
        margin-bottom: var(--spacing-sm);
      }
    
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  
    @media (max-width: 576px) {
      .btn-login {
        padding: 0.6rem 1.3rem;
        font-size: 0.85rem;
      }

      .cta-buttons {
        flex-direction: column;
      }

      .btn-hero {
        width: 100%;
        justify-content: center;
      }
    
      .feature-card,
      .card-box {
        padding: 1.8rem;
      }
    
      .faq-toggle {
        top: 2rem;
        right: 2rem;
      }
    }
  </style>
</head>

<body>
    <header id="header" class="header" role="banner">
        <div class="container-fluid container-xl">
            <div class="d-flex align-items-center justify-content-between">
                <a href="#" class="logo">
                    <h1>E-SiswaIzin</h1>
                </a>
                <nav id="navmenu" class="navmenu" role="navigation">
                    <ul>
                        <li><a href="#hero" class="active">Beranda</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                </nav>
                
                <div class="d-flex">
                    @auth
                    <a href="{{ route('dashboard') }}" class="btn-login">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    @endauth
                </div>
                <i class="mobile-toggle bi bi-list" role="button"></i>
            </div>
        </div>
    </header>

    <main id="main">
        <section id="hero" class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 hero-content">
                        <h1>E-SiswaIzin</h1>
                        <p>Kelola izin siswa dengan mudah, cepat, dan transparan. Solusi modern untuk mengajukan izin yang efisien.</p>
                        
                        <div class="cta-buttons">
                            <a href="{{ route('register') }}" class="btn-hero btn-primary-hero">
                                Daftar Sekarang
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#about" class="btn-hero btn-secondary-hero">
                                <i class="bi bi-play-circle"></i>
                                Pelajari Lebih
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-visual">
                            <div class="icon-card">
                                <i class="bi bi-calendar-check"></i>
                                <h5>Pengajuan Cepat</h5>
                            </div>
                            <div class="icon-card">
                                <i class="bi bi-shield-check"></i>
                                <h5>Aman Terpercaya</h5>
                            </div>
                            <div class="icon-card">
                                <i class="bi bi-clock-history"></i>
                                <h5>Real-time Update</h5>
                            </div>
                            <div class="icon-card">
                                <i class="bi bi-people-fill"></i>
                                <h5>Multi-user</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Tentang Aplikasi</h2>
                    <p>Solusi modern untuk manajemen perizinan siswa, mengurangi birokrasi, dan meningkatkan akuntabilitas.</p>
                </div>

                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="card-box">
                            <h5>Memperkenalkan E-SiswaIzin</h5>
                            <p>E-SiswaIzin adalah aplikasi berbasis web yang dirancang untuk menyederhanakan proses pengajuan izin ketidakhadiran siswa. Ini menciptakan jembatan digital antara siswa, wali kelas, dan admin sekolah untuk proses perizinan yang cepat, terdokumentasi, dan transparan.</p>
                            <ul class="info-list">
                                <li>
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Pengajuan izin lebih cepat dan praktis dari mana saja</span>
                                </li>
                                <li>
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Data izin tersimpan rapi dan aman di database sekolah</span>
                                </li>
                                <li>
                                    <i class="bi bi-check2-circle"></i>
                                    <span>Proses persetujuan dan pemantauan mudah bagi wali kelas dan admin</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card-box gradient">
                            <div class="text-center mb-4">
                                <i class="bi bi-gear-fill" style="font-size:3.5rem; color:var(--highlight);"></i>
                                <h5 class="mt-3">Alur Kerja Sistem</h5>
                            </div>

                            <div class="process-step">
                                <div class="step-num">1</div>
                                <div>
                                    <h6><i class="bi bi-person-plus me-2"></i>Login Siswa</h6>
                                    <p>Siswa masuk menggunakan akun unik dan mengajukan izin</p>
                                </div>
                            </div>

                            <div class="process-step">
                                <div class="step-num">2</div>
                                <div>
                                    <h6><i class="bi bi-file-earmark-text me-2"></i>Pilih Menu Sidebar Ajukan Izin Siswa dan Klik Button Ajukan Izin Untuk Isi Formulir</h6>
                                    <p>Lengkapi formulir izin dengan alasan dan upload bukti pendukung</p>
                                </div>
                            </div>

                            <div class="process-step">
                                <div class="step-num">3</div>
                                <div>
                                    <h6><i class="bi bi-check-circle me-2"></i>Review & Approval</h6>
                                    <p>Wali kelas meninjau dan memberikan persetujuan atau penolakan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="section" style="background:var(--light-bg);">
            <div class="container">
                <div class="section-title">
                    <h2>Fitur Utama</h2>
                    <p>Fitur-fitur inovatif yang menjadikan proses perizinan siswa lebih efisien dan terkelola</p>
                </div>

                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card" data-feature="1">
                            <h3><span class="feature-num">01</span> Pengajuan Izin Online</h3>
                            <div class="feature-content">
                                <p>Siswa dapat mengajukan izin dari perangkat apa pun tanpa perlu surat fisik. Formulir digital memudahkan pengisian data dan proses upload dokumen pendukung.</p>
                                <div class="demo-box">
                                    <div class="demo-screen">
                                        <div class="fw-bold mb-2">📱 Form Pengajuan Izin</div>
                                        <div class="text-sm">
                                            <ul style="margin-left: 1rem;">
                                                <li>Isi Nama Siswa, Kelas, dan Tanggal Pengajuan Izin dengan Lengkap dan Jujur</li>
                                                <li>Berikan Alasan Lengkap & Jelas</li>
                                                <li>Upload Bukti Pendukung</li>
                                            </ul>
                                        </div>
                                        <button class="demo-btn">Kirim Izin</button>
                                    </div>
                                </div>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card" data-feature="2">
                            <h3><span class="feature-num">02</span> Persetujuan Wali Kelas</h3>
                            <div class="feature-content">
                                <p>Wali kelas memiliki dashboard khusus untuk melihat semua pengajuan siswa. Keputusan persetujuan dapat dilakukan secara instan dengan fitur catatan.</p>
                                <div class="demo-box">
                                    <div class="demo-screen">
                                        <div class="fw-bold mb-2">👨‍🏫 Dashboard Wali Kelas</div>
                                        <div class="text-sm mb-3">
                                            <div class="mb-1">• Ahmad Rizki - Sakit (15 Jan)</div>
                                            <div class="mb-1">• Sinta Dewi - Keperluan Keluarga</div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button class="demo-btn" style="width:50%; background:linear-gradient(135deg, #43e97b, #38f9d7);">✓ Setuju</button>
                                            <button class="demo-btn" style="width:50%; background:linear-gradient(135deg, #f093fb, #f5576c);">✗ Tolak</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card" data-feature="3">
                            <h3><span class="feature-num">03</span> Formulir Izin Digital Cepat</h3>
                            <div class="feature-content">
                                <p>Ucapkan selamat tinggal pada surat kertas! Pengajuan izin bisa dilakukan kapan saja, di mana saja, langsung dari HP. Cukup isi formulir singkat, lampirkan bukti foto (jika perlu), dan kirim. Beres dalam semenit!</p>
                                <div class="demo-box">
                                    <div class="stats-grid">
                                        <div class="stat-box">
                                            <div class="stat-num">1</div>
                                            <p class="text-muted mb-0" style="font-size:0.8rem;">Langkah Pengajuan</p>
                                        </div>
                                        <div class="stat-box">
                                            <div class="stat-num">60</div>
                                            <p class="text-muted mb-0" style="font-size:0.8rem;">Detik Selesai</p>
                                        </div>
                                        <div class="stat-box">
                                            <div class="stat-num">FOTO</div>
                                            <p class="text-muted mb-0" style="font-size:0.8rem;">Upload Lampiran</p>
                                        </div>
                                        <div class="stat-box">
                                            <div class="stat-num">Paper</div>
                                            <p class="text-muted mb-0" style="font-size:0.8rem;">Less (Nihil Kertas)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                    </div>   
                </div>
            </div>
        </section>

        <section id="faq" class="section">
            <div class="container">
                <div class="section-title">
                    <h2>Pertanyaan Umum (FAQ)</h2>
                    <p>Beberapa pertanyaan yang sering diajukan untuk mempermudah pemahaman aplikasi</p>
                </div>

                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="feature-card active" data-feature="faq1">
                                    <h3><span class="feature-num">01</span> Bagaimana siswa mengajukan izin?</h3>
                                    <div class="feature-content">
                                        <p>Prosesnya mudah: Siswa login → Pilih sidebar "Ajukan Izin Siswa"→ Klik Menu Button Ajukan Izin → Isi formulir → Upload bukti → Submit. Status izin akan tampil di dashboard siswa.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="feature-card" data-feature="faq2">
                                    <h3><span class="feature-num">02</span> Bagaimana wali kelas menyetujui izin?</h3>
                                    <div class="feature-content">
                                        <p>Wali kelas login → Dashboard → Lihat daftar pengajuan → Pilih dan Klik "Disetujui" atau "Ditolak" → Tambahkan catatan bila perlu.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="feature-card" data-feature="faq3">
                                    <h3><span class="feature-num">03</span> Apakah data izin tersimpan aman?</h3>
                                    <div class="feature-content">
                                        <p>Ya, semua data pengajuan dienkripsi dan tersimpan di database sekolah yang aman. Akses data diatur berdasarkan peran (Siswa dan Admin), memastikan hanya pihak berkepentingan yang dapat melihat informasi yang relevan.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="section" style="background:var(--light-bg);">
            <div class="container">
                <div class="section-title">
                    <h2>Kontak</h2>
                    <p>Jangan ragu menghubungi tim dukungan kami untuk pertanyaan atau bantuan teknis</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="info-card">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <h3>Alamat</h3>
                                    <p>Jl. Jend. Ahmad Yani No.98, Nagri Tengah, Kec. Purwakarta, Kabupaten Purwakarta, Jawa Barat 41114</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <h3>Telepon</h3>
                                    <p>+62 812 1013 5944</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div>
                                    <h3>Email</h3>
                                    <p>projekpklpengajuanizinsiswa@gmail.com</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h4 class="fw-bold mb-3" style="color: var(--heading);">Lokasi Kami</h4>
                                <iframe src="https://maps.google.com/maps?q=Jl.+Jend.+Ahmad+Yani+No.98,+Nagri+Tengah,+Purwakarta&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                    frameborder="0" style="border:0; width:100%; height:350px; border-radius:20px;"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p class="mb-2">© <span>2025</span> <strong>E-SiswaIzin</strong> <span>- All Rights Reserved</span></p>
            <div class="opacity-75" style="font-size:0.95rem;">Dikembangkan oleh Tim IT Sekolah</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('header');
            const navMenu = document.getElementById('navmenu');
            const mobileToggle = document.querySelector('.mobile-toggle');
            const featureCards = document.querySelectorAll('.feature-card');
            const navLinks = document.querySelectorAll('.navmenu a');
            const sections = document.querySelectorAll('main section');
            const SCROLL_OFFSET = 100;

            window.addEventListener('scroll', () => {
                header.classList.toggle('scrolled', window.scrollY > 50);
            });

            mobileToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileToggle.classList.toggle('bi-list');
                mobileToggle.classList.toggle('bi-x');
            });

            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        mobileToggle.classList.add('bi-list');
                        mobileToggle.classList.remove('bi-x');
                    }
                });
            });

            featureCards.forEach(card => {
                card.addEventListener('click', () => {
                    const wasActive = card.classList.contains('active');
                    card.closest('.row').querySelectorAll('.feature-card').forEach(c => {
                        c.classList.remove('active');
                    });
                    if (!wasActive) {
                        card.classList.add('active');
                    }
                });
            });

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const id = entry.target.getAttribute('id');
                    const link = document.querySelector(`.navmenu a[href="#${id}"]`);
                    if (link && entry.isIntersecting) {
                        navLinks.forEach(l => l.classList.remove('active'));
                        link.classList.add('active');
                    }
                });
            }, { root: null, rootMargin: `-${SCROLL_OFFSET}px 0px -50% 0px`, threshold: 0 });

            sections.forEach(section => observer.observe(section));
        });
    </script>
</body>
</html>