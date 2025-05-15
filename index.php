<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SolSynth DAO - Launch a DAO with one prompt</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/@solflare-wallet/sdk@latest/dist/solflare.iife.js"></script>
  <style>
    :root {
      --primary: #9945FF;
      --primary-lighter: #a35aff;
      --secondary: #14F195;
      --tertiary: #00C2FF;
      --dark: #121212;
      --dark-lighter: #1a1a1a;
      --gray: #2d2d2d;
      --light-gray: rgba(255, 255, 255, 0.7);
      --text-color: #ffffff;
      --radius: 12px;
      --radius-sm: 8px;
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Space Grotesk', sans-serif;
      color: var(--text-color);
      background-color: var(--dark);
      line-height: 1.6;
      overflow-x: hidden;
    }

    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    section {
      padding: 7rem 0;
      position: relative;
    }

    h1, h2, h3, h4, h5 {
      font-weight: 700;
      line-height: 1.2;
    }

    h1 {
      font-size: clamp(2.5rem, 5vw, 4rem);
      margin-bottom: 1.5rem;
    }

    h2 {
      font-size: clamp(2rem, 4vw, 3rem);
      margin-bottom: 1.5rem;
    }

    h3 {
      font-size: clamp(1.5rem, 3vw, 2rem);
      margin-bottom: 1rem;
    }

    p {
      margin-bottom: 1.5rem;
      font-size: clamp(1rem, 1.5vw, 1.2rem);
      color: var(--light-gray);
    }

    /* Nav */
    .nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 1.5rem 0;
      z-index: 1000;
      transition: var(--transition);
      background: rgba(18, 18, 18, 0.4);
      backdrop-filter: blur(10px);
    }

    .nav.scrolled {
      background: rgba(18, 18, 18, 0.9);
      padding: 1rem 0;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .nav-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      color: white;
      text-decoration: none;
    }

    .logo span {
      background: linear-gradient(45deg, var(--primary), var(--tertiary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-left: 0.25rem;
    }

    .nav-menu {
      display: flex;
      align-items: center;
      gap: 2rem;
    }

    .nav-menu a {
      color: var(--text-color);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
      position: relative;
    }

    .nav-menu a:hover {
      color: var(--primary-lighter);
    }

    .nav-menu a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(to right, var(--primary), var(--tertiary));
      transition: var(--transition);
    }

    .nav-menu a:hover::after {
      width: 100%;
    }

    .menu-toggle {
      display: none;
      cursor: pointer;
      background: none;
      border: none;
      color: white;
    }

    /* Buttons */
    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      text-decoration: none;
    }

    .btn-primary {
      background: linear-gradient(45deg, var(--primary), var(--primary-lighter));
      color: white;
      border: none;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(153, 69, 255, 0.3);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(5px);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }

    .btn-large {
      padding: 1rem 2rem;
      font-size: 1.1rem;
    }

    /* Hero Section */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
      padding-top: 8rem;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top right, rgba(153, 69, 255, 0.2), transparent 50%),
                  radial-gradient(circle at bottom left, rgba(20, 241, 149, 0.1), transparent 50%);
      z-index: -1;
    }

    .hero-grid {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background-size: 40px 40px;
      background-image: 
        linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
      z-index: -1;
    }

    .hero-particles {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -2;
    }

    .hero-content {
      text-align: center;
      max-width: 800px;
      margin: 0 auto;
      z-index: 10;
    }

    .hero-title {
      margin-bottom: 1.5rem;
    }

    .hero-description {
      margin-bottom: 2.5rem;
      font-size: clamp(1.1rem, 2vw, 1.4rem);
    }

    .cta-container {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-bottom: 4rem;
    }

    .hero-image {
      margin-top: 3rem;
      position: relative;
      width: 100%;
      height: 350px;
      border-radius: var(--radius);
      background: rgba(30, 30, 30, 0.4);
      backdrop-filter: blur(10px);
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .hero-image::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: conic-gradient(
        from 0deg at 50% 50%,
        transparent 0%,
        rgba(153, 69, 255, 0.1) 25%,
        rgba(20, 241, 149, 0.1) 50%,
        rgba(0, 194, 255, 0.1) 75%,
        transparent 100%
      );
      animation: rotate 20s linear infinite;
      z-index: -1;
    }

    @keyframes rotate {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }

    /* About Section */
    .about {
      background-color: var(--dark-lighter);
      position: relative;
      overflow: hidden;
    }

    .about::before {
      content: '';
      position: absolute;
      top: -50px;
      right: -50px;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(20, 241, 149, 0.1), transparent 70%);
      z-index: 0;
    }

    .about-content {
      display: flex;
      align-items: center;
      gap: 4rem;
      position: relative;
      z-index: 1;
    }

    .about-text {
      flex: 1;
    }

    .about-visual {
      flex: 1;
      height: 400px;
      border-radius: var(--radius);
      background: linear-gradient(145deg, var(--gray), var(--dark-lighter));
      position: relative;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .about-visual::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('/api/placeholder/600/400') center/cover no-repeat;
      opacity: 0.7;
      mix-blend-mode: lighten;
    }

    /* Features Section */
    .features {
      position: relative;
      overflow: hidden;
    }

    .features::before {
      content: '';
      position: absolute;
      bottom: -100px;
      left: -100px;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(0, 194, 255, 0.1), transparent 70%);
      z-index: 0;
    }

    .features-intro {
      text-align: center;
      max-width: 700px;
      margin: 0 auto 4rem;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      position: relative;
      z-index: 1;
    }

    .feature-card {
      background: rgba(30, 30, 30, 0.5);
      border-radius: var(--radius);
      padding: 2.5rem;
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      position: relative;
      overflow: hidden;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      border-color: rgba(153, 69, 255, 0.3);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: rgba(153, 69, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .feature-icon.code {
      background: rgba(153, 69, 255, 0.1);
    }

    .feature-icon.ai {
      background: rgba(20, 241, 149, 0.1);
    }

    .feature-icon.deploy {
      background: rgba(0, 194, 255, 0.1);
    }

    .feature-icon svg {
      color: white;
      width: 28px;
      height: 28px;
      stroke-width: 1.5;
    }

    .feature-title {
      margin-bottom: 1rem;
      font-size: 1.5rem;
    }

    .feature-description {
      color: var(--light-gray);
      font-size: 1rem;
      margin-bottom: 0;
    }

    /* How It Works Section */
    .how-it-works {
      background-color: var(--dark-lighter);
      position: relative;
      overflow: hidden;
    }

    .how-it-works::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at top right, rgba(153, 69, 255, 0.05), transparent 50%);
      z-index: 0;
    }

    .hiw-intro {
      text-align: center;
      max-width: 700px;
      margin: 0 auto 4rem;
      position: relative;
      z-index: 1;
    }

    .steps {
      display: flex;
      justify-content: space-between;
      position: relative;
      z-index: 1;
    }

    .step {
      flex: 1;
      text-align: center;
      padding: 0 1rem;
      position: relative;
    }

    .step-line {
      position: absolute;
      top: 35px;
      left: calc(50% + 35px);
      height: 2px;
      background: linear-gradient(to right, var(--primary), var(--tertiary));
      width: calc(100% - 70px);
      z-index: 0;
    }

    .step:last-child .step-line {
      display: none;
    }

    .step-number {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: linear-gradient(145deg, var(--primary), var(--tertiary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0 auto 1.5rem;
      position: relative;
      z-index: 2;
    }

    .step-content {
      background: rgba(30, 30, 30, 0.5);
      border-radius: var(--radius);
      padding: 2rem;
      height: 100%;
      border: 1px solid rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(5px);
      transition: var(--transition);
    }

    .step-content:hover {
      transform: translateY(-5px);
      border-color: rgba(153, 69, 255, 0.2);
    }

    .step-icon {
      width: 40px;
      height: 40px;
      margin: 0 auto 1rem;
      color: white;
    }

    .step-title {
      margin-bottom: 1rem;
      font-size: 1.25rem;
    }

    .step-description {
      font-size: 0.95rem;
      color: var(--light-gray);
    }

    /* Demo Section */
    .demo {
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .demo::before {
      content: '';
      position: absolute;
      bottom: -200px;
      right: -200px;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(20, 241, 149, 0.05), transparent 70%);
      z-index: 0;
    }

    .demo-content {
      max-width: 700px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .demo-video {
      width: 100%;
      height: 450px;
      background: rgba(30, 30, 30, 0.5);
      border-radius: var(--radius);
      margin: 3rem 0;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
    }

    .demo-video img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.8;
    }

    .play-btn {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 80px;
      height: 80px;
      background: rgba(153, 69, 255, 0.9);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
    }

    .play-btn:hover {
      transform: translate(-50%, -50%) scale(1.1);
      background: var(--primary);
    }

    .play-btn svg {
      width: 30px;
      height: 30px;
      color: white;
    }

    /* Social Proof */
    .social-proof {
      background-color: var(--dark-lighter);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .social-proof::before {
      content: '';
      position: absolute;
      top: -100px;
      left: -100px;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(0, 194, 255, 0.05), transparent 70%);
      z-index: 0;
    }

    .social-proof-content {
      position: relative;
      z-index: 1;
    }

    .partners {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      gap: 3rem;
      margin: 3rem 0;
    }

    .partner {
      height: 40px;
      opacity: 0.7;
      transition: var(--transition);
      filter: grayscale(100%);
    }

    .partner:hover {
      opacity: 1;
      filter: grayscale(0%);
      transform: scale(1.05);
    }

    .twitter-embed {
      max-width: 500px;
      margin: 3rem auto;
      background: rgba(30, 30, 30, 0.5);
      border-radius: var(--radius);
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .tweet {
      display: flex;
      gap: 1rem;
      text-align: left;
    }

    .tweet-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      overflow: hidden;
      flex-shrink: 0;
    }

    .tweet-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .tweet-content {
      flex: 1;
    }

    .tweet-header {
      display: flex;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .tweet-name {
      font-weight: 700;
      margin-right: 0.5rem;
    }

    .tweet-username {
      color: var(--light-gray);
      font-size: 0.9rem;
    }

    .tweet-body {
      margin-bottom: 1rem;
      font-size: 1rem;
    }

    .tweet-actions {
      display: flex;
      gap: 1.5rem;
      color: var(--light-gray);
      font-size: 0.9rem;
    }

    .tweet-action {
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    .wallet-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
  }

  .wallet-modal-content {
    position: relative;
    background: var(--dark-lighter);
    margin: 15% auto;
    padding: 0;
    border-radius: var(--radius);
    max-width: 400px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    animation: modalFadeIn 0.3s ease;
  }

  @keyframes modalFadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
  }

  .wallet-modal-header {
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .wallet-modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
  }

  .wallet-modal-close {
    color: var(--light-gray);
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
  }

  .wallet-modal-close:hover {
    color: white;
  }

  .wallet-modal-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .wallet-btn {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: var(--radius-sm);
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(30, 30, 30, 0.5);
    color: white;
    font-weight: 500;
    font-size: 1rem;
    cursor: pointer;
    transition: var(--transition);
    gap: 0.75rem;
  }

  .wallet-btn:hover {
    transform: translateY(-2px);
    border-color: rgba(153, 69, 255, 0.3);
  }

  .phantom-btn:hover {
    background: rgba(108, 50, 196, 0.1);
  }

  .solflare-btn:hover {
    background: rgba(248, 152, 27, 0.1);
  }

  .wallet-icon {
    width: 24px;
    height: 24px;
  }

    /* Footer */
    .footer {
      background-color: var(--dark);
      padding: 5rem 0 2rem;
      position: relative;
    }

    .footer-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 3rem;
      margin-bottom: 3rem;
    }

    .footer-logo {
      font-size: 1.5rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      color: white;
      text-decoration: none;
    }

    .footer-logo span {
      background: linear-gradient(45deg, var(--primary), var(--tertiary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-left: 0.25rem;
    }

    .footer-about {
      font-size: 0.95rem;
      color: var(--light-gray);
      margin-bottom: 1.5rem;
    }

    .footer-social {
      display: flex;
      gap: 1rem;
    }

    .footer-social-link {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    .footer-social-link:hover {
      background: var(--primary);
      transform: translateY(-3px);
    }

    .footer-social-link svg {
      width: 18px;
      height: 18px;
      color: white;
    }

    .footer-heading {
      font-size: 1.2rem;
      margin-bottom: 1.5rem;
      font-weight: 600;
    }

    .footer-links {
      list-style: none;
    }

    .footer-link {
      margin-bottom: 0.8rem;
    }

    .footer-link a {
      color: var(--light-gray);
      text-decoration: none;
      transition: var(--transition);
      font-size: 0.95rem;
    }

    .footer-link a:hover {
      color: white;
      padding-left: 5px;
    }

    .footer-bottom {
      padding-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .copyright {
      font-size: 0.9rem;
      color: var(--light-gray);
    }

    .legal {
      display: flex;
      gap: 1.5rem;
    }

    .legal a {
      color: var(--light-gray);
      text-decoration: none;
      font-size: 0.9rem;
      transition: var(--transition);
    }

    .legal a:hover {
      color: white;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .about-content {
        flex-direction: column;
        gap: 2rem;
      }

      .about-visual {
        width: 100%;
      }

      .steps {
        flex-direction: column;
        gap: 2rem;
      }

      .step {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
      }

      .step-line {
        top: auto;
        bottom: -1rem;
        left: 50%;
        width: 2px;
        height: 1rem;
        transform: translateX(-50%);
      }

      .footer-content {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .nav-menu {
        position: fixed;
        top: 0;
        right: -100%;
        flex-direction: column;
        background: var(--dark);
        width: 70%;
        height: 100vh;
        padding: 6rem 2rem 2rem;
        transition: 0.5s;
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.2);
        gap: 1.5rem;
        align-items: flex-start;
      }

      .nav-menu.active {
        right: 0;
      }

      .menu-toggle {
        display: block;
        z-index: 1001;
      }

      .cta-container {
        flex-direction: column;
        gap: 1rem;
      }

      .btn {
        width: 100%;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }

      .footer-bottom {
        flex-direction: column;
        text-align: center;
      }

      .legal {
        justify-content: center;
      }
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
      animation: fadeIn 1s ease forwards;
    }

    .fade-in.delay-1 {
      animation-delay: 0.2s;
    }

    .fade-in.delay-2 {
      animation-delay: 0.4s;
    }

    .fade-in.delay-3 {
      animation-delay: 0.6s;
    }

    /* Particles animation */
    .particle {
      position: absolute;
      border-radius: 50%;
      background: white;
      opacity: 0.3;
    }

    .particle:nth-child(1) {
      width: 3px;
      height: 3px;
      top: 20%;
      left: 10%;
      animation: float 15s infinite linear;
    }

    .particle:nth-child(2) {
      width: 5px;
      height: 5px;
      top: 40%;
      left: 70%;
      animation: float 20s infinite linear reverse;
    }

    .particle:nth-child(3) {
      width: 2px;
      height: 2px;
      top: 70%;
      left: 20%;
      animation: float 25s infinite linear;
    }

    .particle:nth-child(4) {
      width: 4px;
      height: 4px;
      top: 80%;
      left: 80%;
      animation: float 18s infinite linear reverse;
    }

    .particle:nth-child(5) {
      width: 3px;
      height: 3px;
      top: 30%;
      left: 50%;
      animation: float 22s infinite linear;
    }

    @keyframes float {
      0% {
        transform: translate(0, 0);
      }
      25% {
        transform: translate(50px, 50px);
      }
      50% {
        transform: translate(0, 100px);
      }
      75% {
        transform: translate(-50px, 50px);
      }
      100% {
        transform: translate(0, 0);
      }
    }

    /* Custom glassmorphism effect for scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(18, 18, 18, 0.1);
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(to bottom, var(--primary), var(--tertiary));
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="nav">
    <div class="container nav-container">
      <a href="#" class="logo">Sol<span>Synth</span></a>
      <div class="nav-menu">
        <a href="#features">Features</a>
        <a href="#how-it-works">How It Works</a>
        <a href="#demo">Demo</a>
        <a href="#" class="btn btn-secondary">
          <i data-feather="file-text"></i>
          Docs
        </a>
      </div>
      <button class="menu-toggle" id="menu-toggle">
        <i data-feather="menu"></i>
      </button>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="hero-grid"></div>
    <div class="hero-particles">
      <div class="particle"></div>
      <div class="particle"></div>
      <div class="particle"></div>
      <div class="particle"></div>
      <div class="particle"></div>
    </div>
    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title fade-in">Launch a DAO with one prompt.</h1>
        <p class="hero-description fade-in delay-1">Create decentralized organizations using AI—no code required.</p>
        <div class="cta-container fade-in delay-2">
          <a href="#" class="btn btn-primary btn-large">
            <i data-feather="lock"></i>
            Connect Wallet
          </a>
          <a href="login.php" class="btn btn-secondary btn-large">
            <i data-feather="twitter"></i>
            Login with Twitter
          </a>
        </div>
        <div class="hero-image fade-in delay-3">
          <img src="/api/placeholder/1200/600" alt="SolSynth DAO Interface" />
        </div>
      </div>
    </div>

    
<!-- Wallet Modal HTML -->
<div id="wallet-modal" class="wallet-modal">
  <div class="wallet-modal-content">
    <div class="wallet-modal-header">
      <h3>Connect Wallet</h3>
      <span class="wallet-modal-close">&times;</span>
    </div>
    <div class="wallet-modal-body">
      <button id="connect-phantom" class="wallet-btn phantom-btn">
        <img src="assets/img/Phantom-Icon_App_60x60.png" alt="Phantom" class="wallet-icon">
        Connect Phantom
      </button>
      <button id="connect-solflare" class="wallet-btn solflare-btn">
        <img src="assets/img/solflare.png" alt="Solflare" class="wallet-icon">
        Connect Solflare
      </button>
    </div>
  </div>
</div>
  </section>

  <!-- About Section -->
  <section class="about" id="about">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <h2>AI-Powered DAO Creation</h2>
          <p>SolSynth transforms how DAOs are created and managed through advanced AI. Simply describe your vision in natural language, and our AI instantly translates your ideas into a fully functional decentralized organization on Solana.</p>
          <p>The platform interprets your requirements, generates smart contracts, and handles all the technical complexity—enabling anyone to deploy sophisticated governance structures without writing a single line of code.</p>
          <a href="#how-it-works" class="btn btn-primary">
            <i data-feather="arrow-right"></i>
            See How It Works
          </a>
        </div>
        <div class="about-visual">
          <!-- Abstract visual will be positioned here -->
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="container">
      <div class="features-intro">
        <h2>Powerful Features</h2>
        <p>SolSynth combines AI, blockchain, and user-centric design to make DAO creation accessible to everyone.</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon code">
            <i data-feather="code"></i>
          </div>
          <h3 class="feature-title">No Code Required</h3>
          <p class="feature-description">Create complex DAOs through simple conversation with our AI. No technical knowledge needed—just describe what you want.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon ai">
            <i data-feather="cpu"></i>
          </div>
          <h3 class="feature-title">AI-Powered Setup</h3>
          <p class="feature-description">Our AI understands your governance needs and generates customized smart contracts tuned to your specific requirements.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon deploy">
            <i data-feather="zap"></i>
          </div>
          <h3 class="feature-title">Instant Deployment on Solana</h3>
          <p class="feature-description">Deploy your DAO immediately on Solana's high-performance blockchain with lightning-fast finality and low fees.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works" id="how-it-works">
    <div class="container">
      <div class="hiw-intro">
        <h2>How It Works</h2>
        <p>Creating your DAO is a simple, three-step process that takes minutes, not days.</p>
      </div>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <div class="step-line"></div>
          <div class="step-content">
            <div class="step-icon">
              <i data-feather="message-square"></i>
            </div>
            <h3 class="step-title">Describe your DAO</h3>
            <p class="step-description">Simply tell our AI what type of DAO you want to create, including governance structure, voting mechanisms, and treasury management.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <div class="step-line"></div>
          <div class="step-content">
            <div class="step-icon">
              <i data-feather="edit-3"></i>
            </div>
            <h3 class="step-title">Review & edit config</h3>
            <p class="step-description">Our AI generates a complete configuration for your DAO. Review the details and make any adjustments needed before deployment.</p>
          </div>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <div class="step-content">
            <div class="step-icon">
              <i data-feather="upload-cloud"></i>
            </div>
            <h3 class="step-title">Deploy on-chain</h3>
            <p class="step-description">Once you're happy with the configuration, deploy your DAO directly to the Solana blockchain with one click.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Demo Section -->
  <section class="demo" id="demo">
    <div class="container">
      <div class="demo-content">
        <h2>See SolSynth in Action</h2>
        <p>Watch how easy it is to create a fully functional DAO in minutes with just a few prompts.</p>
        <div class="demo-video">
          <img src="/api/placeholder/1200/600" alt="SolSynth Demo Video" />
          <div class="play-btn">
            <i data-feather="play"></i>
          </div>
        </div>
        <a href="#" class="btn btn-primary btn-large">
          <i data-feather="code"></i>
          Try the Demo
        </a>
        <p>See how AI can launch your DAO idea instantly.</p>
      </div>
    </div>
  </section>

  <!-- Social Proof -->
  <section class="social-proof" id="social-proof">
    <div class="container">
      <div class="social-proof-content">
        <h2>Trusted by Leaders in Web3</h2>
        <div class="partners">
          <img src="/api/placeholder/150/40" alt="Solana" class="partner" />
          <img src="/api/placeholder/150/40" alt="Phantom" class="partner" />
          <img src="/api/placeholder/150/40" alt="Partner 3" class="partner" />
          <img src="/api/placeholder/150/40" alt="Partner 4" class="partner" />
        </div>
        <div class="twitter-embed">
          <div class="tweet">
            <div class="tweet-avatar">
              <img src="/api/placeholder/48/48" alt="User Avatar" />
            </div>
            <div class="tweet-content">
              <div class="tweet-header">
                <span class="tweet-name">Solana Labs</span>
                <span class="tweet-username">@solana</span>
              </div>
              <p class="tweet-body">SolSynth is revolutionizing how DAOs are created on Solana. The AI-powered platform makes governance accessible to everyone, not just developers. Try it today!</p>
              <div class="tweet-actions">
                <span class="tweet-action">
                  <i data-feather="heart"></i> 145
                </span>
                <span class="tweet-action">
                  <i data-feather="repeat"></i> 32
                </span>
                <span class="tweet-action">
                  <i data-feather="message-circle"></i> 12
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div>
          <a href="#" class="footer-logo">Sol<span>Synth</span></a>
          <p class="footer-about">Create decentralized organizations using AI—no code required.</p>
          <div class="footer-social">
            <a href="#" class="footer-social-link">
              <i data-feather="twitter"></i>
            </a>
            <a href="#" class="footer-social-link">
              <i data-feather="github"></i>
            </a>
            <a href="#" class="footer-social-link">
              <i data-feather="discord"></i>
            </a>
            <a href="#" class="footer-social-link">
              <i data-feather="linkedin"></i>
            </a>
          </div>
        </div>
        <div>
          <h4 class="footer-heading">Product</h4>
          <ul class="footer-links">
            <li class="footer-link"><a href="#">Features</a></li>
            <li class="footer-link"><a href="#">How It Works</a></li>
            <li class="footer-link"><a href="#">Pricing</a></li>
            <li class="footer-link"><a href="#">FAQ</a></li>
          </ul>
        </div>
        <div>
          <h4 class="footer-heading">Resources</h4>
          <ul class="footer-links">
            <li class="footer-link"><a href="#">Documentation</a></li>
            <li class="footer-link"><a href="#">API</a></li>
            <li class="footer-link"><a href="#">Developers</a></li>
            <li class="footer-link"><a href="#">Blog</a></li>
          </ul>
        </div>
        <div>
          <h4 class="footer-heading">Company</h4>
          <ul class="footer-links">
            <li class="footer-link"><a href="#">About</a></li>
            <li class="footer-link"><a href="#">Careers</a></li>
            <li class="footer-link"><a href="#">Contact</a></li>
            <li class="footer-link"><a href="#">Press</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p class="copyright">© 2025 SolSynth DAO. All rights reserved.</p>
        <div class="legal">
          <a href="#">Terms of Service</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Cookie Policy</a>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://unpkg.com/@solflare-wallet/sdk@latest/dist/solflare.iife.js"></script>
  <script>
    // Initialize Feather Icons
    document.addEventListener('DOMContentLoaded', () => {
      feather.replace();
      
      // Mobile menu toggle
      const menuToggle = document.getElementById('menu-toggle');
      const navMenu = document.querySelector('.nav-menu');
      
      menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        
        // Toggle icon between menu and x
        const icon = menuToggle.querySelector('i');
        if (icon.getAttribute('data-feather') === 'menu') {
          icon.setAttribute('data-feather', 'x');
        } else {
          icon.setAttribute('data-feather', 'menu');
        }
        feather.replace();
      });
      
      // Navbar scroll effect
      const nav = document.querySelector('.nav');
      window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
          nav.classList.add('scrolled');
        } else {
          nav.classList.remove('scrolled');
        }
      });
      
      // Smooth scroll for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            window.scrollTo({
              top: target.offsetTop - 100,
              behavior: 'smooth'
            });
            
            // Close mobile menu if open
            navMenu.classList.remove('active');
            menuToggle.querySelector('i').setAttribute('data-feather', 'menu');
            feather.replace();
          }
        });
      });
    });

  </script>
  <script src="js/walletconnect.js"></script>
</body>
</html>