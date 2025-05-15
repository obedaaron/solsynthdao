<?php
session_start();
if (!isset($_SESSION['wallet_address'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SolSynth DAO - Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
  <style>
    :root {
      --primary: #9945FF;
      --primary-lighter: #a35aff;
      --primary-darker: #8030e0;
      --secondary: #14F195;
      --secondary-lighter: #2fffa5;
      --tertiary: #00C2FF;
      --dark: #121212;
      --dark-lighter: #1a1a1a;
      --dark-medium: #212121;
      --gray: #2d2d2d;
      --light-gray: rgba(255, 255, 255, 0.7);
      --very-light-gray: rgba(255, 255, 255, 0.5);
      --text-color: #ffffff;
      --radius: 12px;
      --radius-sm: 8px;
      --transition: all 0.3s ease;
      --shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
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
      background-image: 
        radial-gradient(circle at top right, rgba(153, 69, 255, 0.08), transparent 50%),
        radial-gradient(circle at bottom left, rgba(20, 241, 149, 0.08), transparent 50%);
      background-attachment: fixed;
    }

    /* Grid background */
    .grid-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: 40px 40px;
      background-image: 
        linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
      z-index: -1;
      pointer-events: none;
    }

    .container {
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background: rgba(26, 26, 26, 0.7);
      backdrop-filter: blur(10px);
      border-right: 1px solid rgba(255, 255, 255, 0.05);
      padding: 2rem 0;
      position: fixed;
      height: 100vh;
      top: 0;
      left: 0;
      z-index: 900;
      transition: transform 0.3s ease;
      transform: translateX(0);
    }

    .sidebar-logo {
      padding: 0 1.5rem 2rem;
      display: flex;
      align-items: center;
      font-size: 1.5rem;
      font-weight: 700;
      color: white;
      text-decoration: none;
    }

    .sidebar-logo span {
      background: linear-gradient(45deg, var(--primary), var(--tertiary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-left: 0.25rem;
    }

    .sidebar-nav {
      list-style: none;
    }

    .sidebar-item {
      margin-bottom: 0.5rem;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      padding: 0.75rem 1.5rem;
      color: var(--light-gray);
      text-decoration: none;
      transition: var(--transition);
      font-weight: 500;
      gap: 0.75rem;
      position: relative;
    }

    .sidebar-link:hover {
      background: rgba(255, 255, 255, 0.05);
      color: white;
    }

    .sidebar-link.active {
      color: white;
      background: rgba(153, 69, 255, 0.1);
      border-left: 3px solid var(--primary);
    }

    .sidebar-link.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 3px;
      background: var(--primary);
    }

    .sidebar-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 20px;
    }

    /* Toggle Menu Button (Mobile) */
    .menu-toggle {
      display: none;
      cursor: pointer;
      background: none;
      border: none;
      color: white;
      position: fixed;
      top: 1.5rem;
      right: 1.5rem;
      z-index: 1000;
      padding: 0.5rem;
      border-radius: 50%;
      background: rgba(26, 26, 26, 0.7);
      backdrop-filter: blur(5px);
    }

    /* Main Content */
    .main-content {
      flex: 1;
      padding: 2rem;
      padding-top: 80px;
      margin-left: 260px;
      transition: var(--transition);
    }

    /* Header/Navbar */
    .header {
      position: fixed;
      top: 0;
      left: 260px;
      right: 0;
      height: 70px;
      background: rgba(26, 26, 26, 0.7);
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      z-index: 800;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      transition: var(--transition);
    }

    .page-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .search-container {
      position: relative;
    }

    .search-input {
      background: rgba(45, 45, 45, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 0.6rem 1rem 0.6rem 2.5rem;
      color: white;
      font-family: 'Space Grotesk', sans-serif;
      width: 240px;
      transition: var(--transition);
    }

    .search-input::placeholder {
      color: var(--very-light-gray);
    }

    .search-input:focus {
      outline: none;
      border-color: var(--primary-lighter);
      width: 300px;
    }

    .search-icon {
      position: absolute;
      left: 0.8rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--light-gray);
      pointer-events: none;
    }

    .wallet-button {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(153, 69, 255, 0.1);
      border: 1px solid rgba(153, 69, 255, 0.3);
      border-radius: var(--radius-sm);
      padding: 0.5rem 1rem;
      color: white;
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
    }

    .wallet-button:hover {
      background: rgba(153, 69, 255, 0.2);
    }

    .user-dropdown {
      position: relative;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: linear-gradient(45deg, var(--primary), var(--tertiary));
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1rem;
      transition: var(--transition);
    }

    .user-avatar:hover {
      box-shadow: 0 0 0 3px rgba(153, 69, 255, 0.3);
    }

    .user-menu {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 220px;
      background: var(--dark-medium);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius);
      padding: 0.75rem 0;
      box-shadow: var(--shadow);
      display: none;
      z-index: 100;
      backdrop-filter: blur(10px);
    }

    .user-dropdown:hover .user-menu {
      display: block;
    }

    .user-menu-item {
      padding: 0.75rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: var(--light-gray);
      text-decoration: none;
      transition: var(--transition);
    }

    .user-menu-item:hover {
      background: rgba(255, 255, 255, 0.05);
      color: white;
    }

    .user-menu-divider {
      height: 1px;
      background: rgba(255, 255, 255, 0.1);
      margin: 0.5rem 0;
    }

    /* Dashboard Layout */
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .dashboard-header {
      grid-column: span 12;
      margin-bottom: 1rem;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .section-subtitle {
      color: var(--light-gray);
      font-size: 1rem;
      margin-bottom: 1.5rem;
    }

    /* Cards & Components */
    .card {
      background: rgba(26, 26, 26, 0.7);
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      padding: 1.5rem;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      height: 100%;
    }

    .card:hover {
      border-color: rgba(153, 69, 255, 0.2);
      transform: translateY(-2px);
    }

    .card-glow::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: conic-gradient(
        from 0deg at 50% 50%,
        transparent 0%,
        rgba(153, 69, 255, 0.03) 25%,
        rgba(20, 241, 149, 0.03) 50%,
        rgba(0, 194, 255, 0.03) 75%,
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

    .stats-card {
      grid-column: span 3;
      position: relative;
    }

    .stats-value {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .stats-label {
      color: var(--light-gray);
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .stats-icon {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .stats-icon svg {
      width: 20px;
      height: 20px;
      color: white;
    }

    .icon-purple {
      background: rgba(153, 69, 255, 0.15);
    }

    .icon-green {
      background: rgba(20, 241, 149, 0.15);
    }

    .icon-blue {
      background: rgba(0, 194, 255, 0.15);
    }

    .icon-orange {
      background: rgba(255, 171, 69, 0.15);
    }

    .chart-card {
      grid-column: span 6;
    }

    .chart-container {
      width: 100%;
      height: 240px;
      margin-top: 1rem;
    }

    .activity-card {
      grid-column: span 6;
    }

    .activity-list {
      list-style: none;
      margin: 1rem 0 0;
    }

    .activity-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 1rem 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .activity-item:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .activity-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .activity-content {
      flex: 1;
    }

    .activity-title {
      font-weight: 500;
      margin-bottom: 0.25rem;
    }

    .activity-meta {
      color: var(--light-gray);
      display: flex;
      align-items: center;
      gap: 1rem;
      font-size: 0.85rem;
    }

    .activity-time {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    .dao-card {
      grid-column: span 4;
      position: relative;
      overflow: hidden;
      transition: var(--transition);
    }

    .dao-card:hover {
      transform: translateY(-5px);
    }

    .dao-banner {
      width: 100%;
      height: 120px;
      background: linear-gradient(145deg, rgba(153, 69, 255, 0.2), rgba(0, 194, 255, 0.2));
      border-radius: var(--radius-sm);
      margin-bottom: 1rem;
      overflow: hidden;
      position: relative;
    }

    .dao-banner img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.8;
    }

    .dao-logo {
      position: absolute;
      bottom: -20px;
      left: 20px;
      width: 60px;
      height: 60px;
      border-radius: 12px;
      background: linear-gradient(145deg, var(--primary), var(--tertiary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.2rem;
      border: 3px solid var(--dark-lighter);
    }

    .dao-content {
      padding-top: 1rem;
    }

    .dao-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .dao-badge {
      font-size: 0.7rem;
      background: rgba(153, 69, 255, 0.2);
      padding: 0.2rem 0.5rem;
      border-radius: 4px;
      color: white;
    }

    .dao-description {
      color: var(--light-gray);
      font-size: 0.9rem;
      margin-bottom: 1rem;
      line-height: 1.5;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .dao-meta {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .dao-meta-item {
      display: flex;
      flex-direction: column;
      font-size: 0.85rem;
    }

    .dao-meta-value {
      font-weight: 600;
    }

    .dao-meta-label {
      color: var(--light-gray);
      font-size: 0.75rem;
    }

    .dao-actions {
      display: flex;
      gap: 0.5rem;
    }

    .create-dao-card {
      border: 1px dashed rgba(153, 69, 255, 0.3);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
    }

    .create-dao-card:hover {
      background: rgba(153, 69, 255, 0.05);
    }

    .create-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: rgba(153, 69, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
    }

    .create-icon svg {
      width: 24px;
      height: 24px;
      color: var(--primary-lighter);
    }

    .create-title {
      font-weight: 600;
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }

    .create-text {
      color: var(--light-gray);
      font-size: 0.9rem;
      max-width: 80%;
    }

    /* Buttons */
    .btn {
      padding: 0.6rem 1rem;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 0.9rem;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      text-decoration: none;
      border: none;
      font-family: 'Space Grotesk', sans-serif;
    }

    .btn-sm {
      padding: 0.4rem 0.8rem;
      font-size: 0.85rem;
    }

    .btn-primary {
      background: linear-gradient(45deg, var(--primary), var(--primary-lighter));
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 15px rgba(153, 69, 255, 0.3);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-outline {
      background: transparent;
      color: white;
      border: 1px solid rgba(153, 69, 255, 0.3);
    }

    .btn-outline:hover {
      background: rgba(153, 69, 255, 0.1);
      border-color: rgba(153, 69, 255, 0.5);
    }

    /* Tabs */
    .tabs {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding-bottom: 0.5rem;
    }

    .tab-item {
      padding: 0.75rem 1.25rem;
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: var(--transition);
      font-weight: 500;
      position: relative;
    }

    .tab-item.active {
      background: rgba(153, 69, 255, 0.1);
      color: white;
    }

    .tab-item.active::after {
      content: '';
      position: absolute;
      bottom: -0.5rem;
      left: 0;
      width: 100%;
      height: 3px;
      background: var(--primary);
      border-radius: 3px 3px 0 0;
    }

    .tab-item:hover:not(.active) {
      background: rgba(255, 255, 255, 0.05);
    }

    /* Footer */
    .footer {
      margin-top: 2rem;
      padding: 1.5rem 0;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      color: var(--light-gray);
      font-size: 0.9rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .footer-links {
      display: flex;
      gap: 1.5rem;
    }

    .footer-link {
      color: var(--light-gray);
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-link:hover {
      color: white;
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .stats-card {
        grid-column: span 6;
      }
      
      .chart-card {
        grid-column: span 12;
      }
      
      .activity-card {
        grid-column: span 12;
      }
      
      .dao-card {
        grid-column: span 6;
      }
    }

    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
        z-index: 1000;
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
        padding-top: 90px;
      }
      
      .header {
        left: 0;
      }
      
      .menu-toggle {
        display: block;
      }
      
      .search-input {
        width: 200px;
      }
      
      .search-input:focus {
        width: 240px;
      }
    }

    @media (max-width: 768px) {
      .stats-card {
        grid-column: span 12;
      }
      
      .dao-card {
        grid-column: span 12;
      }
      
      .header-right {
        gap: 0.75rem;
      }
      
      .search-container {
        display: none;
      }
      
      .wallet-button span {
        display: none;
      }
      
      .tabs {
        overflow-x: auto;
        padding-bottom: 1rem;
      }
      
      .footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
      }
      
      .footer-links {
        justify-content: center;
      }
    }

    /* Custom glassmorphism effect for scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(18, 18, 18, 0.1);
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(to bottom, var(--primary), var(--tertiary));
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <!-- Grid Background -->
  <div class="grid-background"></div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="#" class="sidebar-logo">Sol<span>Synth</span></a>
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a href="#" class="sidebar-link active">
          <span class="sidebar-icon"><i data-feather="grid"></i></span>
          Dashboard
        </a>
      </li>
      <li class="sidebar-item">
        <a href="manage_dao.php" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="layers"></i></span>
          Manage DAOs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="onboarding.php" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="plus-circle"></i></span>
          Create DAO
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="compass"></i></span>
          Discover
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="file-text"></i></span>
          Proposals
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="zap"></i></span>
          Rewards
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="settings"></i></span>
          Settings
        </a>
      </li>
    </ul>
  </div>

  <!-- Mobile menu toggle -->
  <button class="menu-toggle" id="menu-toggle">
    <i data-feather="menu"></i>
  </button>

  <!-- Header -->
  <header class="header">
    <h1 class="page-title">Dashboard</h1>
    <div class="header-right">
      <div class="search-container">
        <i data-feather="search" class="search-icon"></i>
        <input type="text" class="search-input" placeholder="Search DAOs, proposals...">
      </div>
      <button class="wallet-button">
        <i data-feather="link-2"></i>
        <span>3GHn...7Vpo</span>
      </button>
      <div class="user-dropdown">
        <div class="user-avatar">AS</div>
        <div class="user-menu">
          <a href="#" class="user-menu-item">
            <i data-feather="user"></i>
            Profile
          </a>
          <a href="#" class="user-menu-item">
            <i data-feather="shield"></i>
            My DAOs
          </a>
          <a href="#" class="user-menu-item">
            <i data-feather="bell"></i>
            Notifications
          </a>
          <div class="user-menu-divider"></div>
          <a href="#" class="user-menu-item">
            <i data-feather="settings"></i>
            Settings
          </a>
          <a href="#" class="user-menu-item">
            <i data-feather="help-circle"></i>
            Help
          </a>
          <div class="user-menu-divider"></div>
          <a href="#" class="user-menu-item">
            <i data-feather="log-out"></i>
            Logout
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-grid">
      <div class="dashboard-header">
        <h2 class="section-title">Welcome back, Alex!</h2>
        <p class="section-subtitle">Here's what's happening with your DAOs today</p>
      </div>

      <!-- Stats Cards -->
      <div class="stats-card card">
        <div class="stats-icon icon-purple">
          <i data-feather="layers"></i>
        </div>
        <div class="stats-value">5</div>
        <div class="stats-label">
          Active DAOs
          <span style="color: var(--secondary); font-weight: 600;">+2 this week</span>
        </div>
      </div>

      <div class="stats-card card">
        <div class="stats-icon icon-green">
          <i data-feather="file-text"></i>
        </div>
        <div class="stats-value">12</div>
        <div class="stats-label">
          Active Proposals
          <span style="color: var(--secondary); font-weight: 600;">+3 today</span>
        </div>
      </div>

      <div class="stats-card card">
        <div class="stats-icon icon-blue">
          <i data-feather="users"></i>
        </div>
        <div class="stats-value">287</div>
        <div class="stats-label">
          DAO Members
          <span style="color: var(--secondary); font-weight: 600;">+15 this week</span>
        </div>
      </div>

      <div class="stats-card card">
        <div class="stats-icon icon-orange">
          <i data-feather="award"></i>
        </div>
        <div class="stats-value">45.8</div>
        <div class="stats-label">
          SOL in Treasury
          <span style="color: var(--secondary); font-weight: 600;">+2.5 today</span>
        </div>
      </div>

      <!-- Charts -->
      <div class="chart-card card card-glow">
        <div class="card-header">
          <h3>Treasury Growth</h3>
          <div class="tabs">
            <div class="tab-item active">Week</div>
            <div class="tab-item">Month</div>
            <div class="tab-item">Year</div>
          </div>
        </div>
        <div class="chart-container">
          <canvas id="treasuryChart"></canvas>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="activity-card card">
        <div class="card-header">
          <h3>Recent Activity</h3>
          <a href="#" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <ul class="activity-list">
          <li class="activity-item">
            <div class="activity-icon icon-purple">
              <i data-feather="check-circle"></i>
            </div>
            <div class="activity-content">
              <div class="activity-title">Treasury allocation proposal passed</div>
              <div class="activity-meta">
                <span class="activity-dao">SolDevs DAO</span>
                <span class="activity-time"><i data-feather="clock" style="width: 14px; height: 14px;"></i> 2 hours ago</span>
              </div>
            </div>
          </li>
          <li class="activity-item">
            <div class="activity-icon icon-green">
              <i data-feather="user-plus"></i>
            </div>
            <div class="activity-content">
              <div class="activity-title">You joined MetaDAO collective</div>
              <div class="activity-meta">
                <span class="activity-dao">MetaDAO</span>
                <span class="activity-time"><i data-feather="clock" style="width: 14px; height: 14px;"></i> 5 hours ago</span>
              </div>
            </div>
          </li>
          <li class="activity-item">
            <div class="activity-icon icon-blue">
              <i data-feather="file-plus"></i>
            </div>
            <div class="activity-content">
              <div class="activity-title">New proposal submitted: "Community Fund Increase"</div>
              <div class="activity-meta">
                <span class="activity-dao">DeFi Builders</span>
                <span class="activity-time"><i data-feather="clock" style="width: 14px; height: 14px;"></i> Yesterday</span>
              </div>
            </div>
          </li>
          <li class="activity-item">
            <div class="activity-icon icon-orange">
              <i data-feather="award"></i>
            </div>
            <div class="activity-content">
              <div class="activity-title">You earned 5 SOL from treasury distribution</div>
              <div class="activity-meta">
                <span class="activity-dao">SolDevs DAO</span>
                <span class="activity-time"><i data-feather="clock" style="width: 14px; height: 14px;"></i> 2 days ago</span>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- My DAOs Section -->
      <div class="dashboard-header" style="grid-column: span 12; margin-top: 1rem;">
        <h2 class="section-title">My DAOs</h2>
        <p class="section-subtitle">DAOs you're participating in</p>
      </div>

      <!-- DAO Cards -->
      <div class="dao-card card">
        <div class="dao-banner">
          <img src="/api/placeholder/400/120" alt="DAO Banner">
          <div class="dao-logo">SD</div>
        </div>
        <div class="dao-content">
          <div class="dao-title">
            SolDevs DAO
            <span class="dao-badge">Active</span>
          </div>
          <div class="dao-description">A community of Solana developers building the future of decentralized applications.</div>
          <div class="dao-meta">
            <div class="dao-meta-item">
              <span class="dao-meta-value">56</span>
              <span class="dao-meta-label">Members</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">12.5 SOL</span>
              <span class="dao-meta-label">Treasury</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">3</span>
              <span class="dao-meta-label">Proposals</span>
            </div>
          </div>
          <div class="dao-actions">
            <a href="#" class="btn btn-primary btn-sm">Manage</a>
            <a href="#" class="btn btn-outline btn-sm">Vote</a>
          </div>
        </div>
      </div>

      <div class="dao-card card">
        <div class="dao-banner">
          <img src="/api/placeholder/400/120" alt="DAO Banner">
          <div class="dao-logo">MD</div>
        </div>
        <div class="dao-content">
          <div class="dao-title">
            MetaDAO
            <span class="dao-badge">New</span>
          </div>
          <div class="dao-description">Bridging the gap between virtual worlds and blockchain governance models.</div>
          <div class="dao-meta">
            <div class="dao-meta-item">
              <span class="dao-meta-value">124</span>
              <span class="dao-meta-label">Members</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">28.3 SOL</span>
              <span class="dao-meta-label">Treasury</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">5</span>
              <span class="dao-meta-label">Proposals</span>
            </div>
          </div>
          <div class="dao-actions">
            <a href="#" class="btn btn-primary btn-sm">Manage</a>
            <a href="#" class="btn btn-outline btn-sm">Vote</a>
          </div>
        </div>
      </div>

      <div class="dao-card card create-dao-card">
        <div class="create-icon">
          <i data-feather="plus"></i>
        </div>
        <h3 class="create-title">Create new DAO</h3>
        <p class="create-text">Use our AI-powered tools to start your own decentralized organization</p>
      </div>

      <!-- Featured DAOs Section -->
      <div class="dashboard-header" style="grid-column: span 12; margin-top: 1rem;">
        <h2 class="section-title">Featured DAOs</h2>
        <p class="section-subtitle">Discover trending communities on SolSynth</p>
      </div>

      <!-- Featured DAO Cards -->
      <div class="dao-card card">
        <div class="dao-banner">
          <img src="/api/placeholder/400/120" alt="DAO Banner">
          <div class="dao-logo">DB</div>
        </div>
        <div class="dao-content">
          <div class="dao-title">
            DeFi Builders
            <span class="dao-badge">Trending</span>
          </div>
          <div class="dao-description">Collaborative community focused on developing next-gen DeFi protocols on Solana.</div>
          <div class="dao-meta">
            <div class="dao-meta-item">
              <span class="dao-meta-value">89</span>
              <span class="dao-meta-label">Members</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">45.2 SOL</span>
              <span class="dao-meta-label">Treasury</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">8</span>
              <span class="dao-meta-label">Proposals</span>
            </div>
          </div>
          <div class="dao-actions">
            <a href="#" class="btn btn-primary btn-sm">Join</a>
            <a href="#" class="btn btn-outline btn-sm">Learn More</a>
          </div>
        </div>
      </div>

      <div class="dao-card card">
        <div class="dao-banner">
          <img src="/api/placeholder/400/120" alt="DAO Banner">
          <div class="dao-logo">NC</div>
        </div>
        <div class="dao-content">
          <div class="dao-title">
            NFT Collective
            <span class="dao-badge">Popular</span>
          </div>
          <div class="dao-description">United NFT enthusiasts curating collections and supporting digital artists worldwide.</div>
          <div class="dao-meta">
            <div class="dao-meta-item">
              <span class="dao-meta-value">212</span>
              <span class="dao-meta-label">Members</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">67.8 SOL</span>
              <span class="dao-meta-label">Treasury</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">12</span>
              <span class="dao-meta-label">Proposals</span>
            </div>
          </div>
          <div class="dao-actions">
            <a href="#" class="btn btn-primary btn-sm">Join</a>
            <a href="#" class="btn btn-outline btn-sm">Learn More</a>
          </div>
        </div>
      </div>

      <div class="dao-card card">
        <div class="dao-banner">
          <img src="/api/placeholder/400/120" alt="DAO Banner">
          <div class="dao-logo">SN</div>
        </div>
        <div class="dao-content">
          <div class="dao-title">
            Solana Nodes
            <span class="dao-badge">Technical</span>
          </div>
          <div class="dao-description">A technical DAO focused on improving Solana network performance and validator operations.</div>
          <div class="dao-meta">
            <div class="dao-meta-item">
              <span class="dao-meta-value">76</span>
              <span class="dao-meta-label">Members</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">132.5 SOL</span>
              <span class="dao-meta-label">Treasury</span>
            </div>
            <div class="dao-meta-item">
              <span class="dao-meta-value">6</span>
              <span class="dao-meta-label">Proposals</span>
            </div>
          </div>
          <div class="dao-actions">
            <a href="#" class="btn btn-primary btn-sm">Join</a>
            <a href="#" class="btn btn-outline btn-sm">Learn More</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <div class="footer-copyright">
        © 2025 SolSynth DAO Platform. All rights reserved.
      </div>
      <div class="footer-links">
        <a href="#" class="footer-link">Documentation</a>
        <a href="#" class="footer-link">Discord</a>
        <a href="#" class="footer-link">GitHub</a>
        <a href="#" class="footer-link">Privacy</a>
        <a href="#" class="footer-link">Try Demo DAO</a>
      </div>
    </div>
  </div>

  <script>
    // Initialize Feather Icons
    feather.replace();

    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });

    // Treasury Chart
    const ctx = document.getElementById('treasuryChart').getContext('2d');
    const treasuryChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: 'Treasury Growth (SOL)',
          data: [38.5, 39.8, 40.2, 42.5, 43.1, 44.7, 45.8],
          backgroundColor: 'rgba(153, 69, 255, 0.2)',
          borderColor: '#9945FF',
          borderWidth: 2,
          pointBackgroundColor: '#9945FF',
          pointBorderColor: '#9945FF',
          pointRadius: 4,
          pointHoverRadius: 6,
          tension: 0.4,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(26, 26, 26, 0.9)',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: 'rgba(153, 69, 255, 0.3)',
            borderWidth: 1,
            padding: 10,
            cornerRadius: 8,
            displayColors: false
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: {
              color: 'rgba(255, 255, 255, 0.05)',
              drawBorder: false
            },
            ticks: {
              color: 'rgba(255, 255, 255, 0.7)',
              font: {
                family: "'Space Grotesk', sans-serif",
                size: 11
              }
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: 'rgba(255, 255, 255, 0.7)',
              font: {
                family: "'Space Grotesk', sans-serif",
                size: 11
              }
            }
          }
        }
      }
    });
  </script>
</body>
</html>