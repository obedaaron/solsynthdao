<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SolSynth DAO - Manage DAOs</title>
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

    /* Manage DAO Layout */
    .manage-grid {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .manage-header {
      grid-column: span 12;
      margin-bottom: 1.5rem;
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

    /* DAO Selector */
    .dao-selector {
      grid-column: span 12;
      margin-bottom: 1.5rem;
    }

    .dao-selector-dropdown {
      background: rgba(26, 26, 26, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius);
      padding: 1rem 1.5rem;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      position: relative;
    }

    .dao-selector-current {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .dao-selector-logo {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      background: linear-gradient(145deg, var(--primary), var(--tertiary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.2rem;
    }

    .dao-selector-info {
      display: flex;
      flex-direction: column;
    }

    .dao-selector-name {
      font-weight: 600;
      font-size: 1.2rem;
    }

    .dao-selector-meta {
      color: var(--light-gray);
      font-size: 0.9rem;
    }

    .dao-selector-dropdown-menu {
      position: absolute;
      top: calc(100% + 10px);
      left: 0;
      width: 100%;
      background: var(--dark-medium);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius);
      padding: 0.75rem 0;
      box-shadow: var(--shadow);
      z-index: 100;
      backdrop-filter: blur(10px);
      display: none;
    }

    .dao-selector-dropdown.active .dao-selector-dropdown-menu {
      display: block;
    }

    .dao-option {
      padding: 0.75rem 1.25rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      color: var(--light-gray);
      transition: var(--transition);
      cursor: pointer;
    }

    .dao-option:hover {
      background: rgba(255, 255, 255, 0.05);
      color: white;
    }

    .dao-option-logo {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(145deg, var(--primary), var(--tertiary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1rem;
    }

    .dao-option.active {
      background: rgba(153, 69, 255, 0.1);
    }

    /* Overview Card */
    .overview-card {
      grid-column: span 12;
      background: rgba(26, 26, 26, 0.7);
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      padding: 1.5rem;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
      transition: var(--transition);
      display: flex;
      gap: 2rem;
      margin-bottom: 1.5rem;
    }

    .overview-card:hover {
      border-color: rgba(153, 69, 255, 0.2);
    }

    .overview-logo {
      width: 100px;
      height: 100px;
      border-radius: 16px;
      background: linear-gradient(145deg, var(--primary), var(--tertiary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 2.5rem;
      flex-shrink: 0;
    }

    .overview-content {
      flex: 1;
    }

    .overview-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
    }

    .overview-title {
      font-size: 1.8rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .overview-status {
      padding: 0.35rem 0.75rem;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .status-active {
      background: rgba(20, 241, 149, 0.15);
      color: var(--secondary);
    }

    .status-suspended {
      background: rgba(255, 69, 69, 0.15);
      color: #FF4545;
    }

    .overview-actions {
      display: flex;
      gap: 0.75rem;
    }

    .overview-description {
      color: var(--light-gray);
      margin-bottom: 1.5rem;
      max-width: 80%;
    }

    .overview-stats {
      display: flex;
      gap: 2.5rem;
    }

    .overview-stat {
      display: flex;
      flex-direction: column;
    }

    .overview-stat-value {
      font-size: 1.8rem;
      font-weight: 700;
    }

    .overview-stat-label {
      color: var(--light-gray);
      font-size: 0.95rem;
    }

    /* Tabs */
    .tabs {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding-bottom: 0.5rem;
      grid-column: span 12;
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

    /* Tab Content */
    .tab-content {
      grid-column: span 12;
      margin-bottom: 2rem;
    }

    .tab-pane {
      display: none;
    }

    .tab-pane.active {
      display: block;
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
      margin-bottom: 1.5rem;
    }

    .card:hover {
      border-color: rgba(153, 69, 255, 0.2);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .card-title {
      font-size: 1.2rem;
      font-weight: 600;
    }

    /* Tables */
    .table-container {
      overflow-x: auto;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      padding: 1rem;
      text-align: left;
    }

    .table th {
      background: rgba(255, 255, 255, 0.05);
      font-weight: 600;
      color: white;
    }

    .table tr {
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table tr:last-child {
      border-bottom: none;
    }

    .table td {
      color: var(--light-gray);
    }

    .table tr:hover td {
      background: rgba(255, 255, 255, 0.02);
      color: white;
    }

    /* Form Elements */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    .form-control {
      width: 100%;
      background: rgba(45, 45, 45, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 0.75rem 1rem;
      color: white;
      font-family: 'Space Grotesk', sans-serif;
      transition: var(--transition);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary-lighter);
    }

    .form-control::placeholder {
      color: var(--very-light-gray);
    }

    .form-row {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .form-col {
      flex: 1;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 2rem;
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

    .btn-danger {
      background: rgba(255, 69, 69, 0.15);
      color: #FF4545;
      border: 1px solid rgba(255, 69, 69, 0.3);
    }

    .btn-danger:hover {
      background: rgba(255, 69, 69, 0.25);
    }

    .btn-success {
      background: rgba(20, 241, 149, 0.15);
      color: var(--secondary);
      border: 1px solid rgba(20, 241, 149, 0.3);
    }

    .btn-success:hover {
      background: rgba(20, 241, 149, 0.25);
    }

    /* Badges */
    .badge {
      padding: 0.35rem 0.75rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
    }

    .badge-primary {
      background: rgba(153, 69, 255, 0.15);
      color: var(--primary-lighter);
    }

    .badge-success {
      background: rgba(20, 241, 149, 0.15);
      color: var(--secondary);
    }

    .badge-info {
      background: rgba(0, 194, 255, 0.15);
      color: var(--tertiary);
    }

    .badge-warning {
      background: rgba(255, 171, 69, 0.15);
      color: #FFAB45;
    }

    .badge-danger {
      background: rgba(255, 69, 69, 0.15);
      color: #FF4545;
    }

    /* Member Cards */
    .member-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .member-card {
      background: rgba(26, 26, 26, 0.7);
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      padding: 1.5rem;
      transition: var(--transition);
      position: relative;
    }

    .member-card:hover {
      border-color: rgba(153, 69, 255, 0.2);
      transform: translateY(-3px);
    }

    .member-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .member-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: linear-gradient(145deg, var(--primary), var(--tertiary));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      font-size: 1.2rem;
    }

    .member-info {
      flex: 1;
    }

    .member-name {
      font-weight: 600;
      margin-bottom: 0.2rem;
    }

    .member-wallet {
      color: var(--light-gray);
      font-size: 0.85rem;
    }

    .member-role {
      margin-top: 0.5rem;
    }

    .member-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 1.5rem;
    }

    /* Treasury Chart */
    .treasury-chart {
      width: 100%;
      height: 300px;
    }

    /* Treasury Stats */
    .treasury-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .treasury-stat-card {
      background: rgba(26, 26, 26, 0.7);
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      padding: 1.5rem;
      transition: var(--transition);
    }

    .treasury-stat-card:hover {
      border-color: rgba(153, 69, 255, 0.2);
    }

    .treasury-stat-value {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .treasury-stat-label {
      color: var(--light-gray);
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
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
      .treasury-stats {
        grid-template-columns: repeat(3, 1fr);
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

      .treasury-stats {
        grid-template-columns: repeat(2, 1fr);
      }

      .overview-card {
        flex-direction: column;
        gap: 1.5rem;
      }
      .overview-card {
        flex-direction: column;
        gap: 1.5rem;
      }
      
      .overview-description {
        max-width: 100%;
      }
      
      .overview-stats {
        flex-wrap: wrap;
        gap: 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .manage-grid {
        gap: 1rem;
      }
      
      .treasury-stats {
        grid-template-columns: 1fr;
      }
      
      .overview-stats {
        flex-direction: column;
        gap: 1rem;
      }
      
      .form-row {
        flex-direction: column;
        gap: 1.5rem;
      }
      
      .tabs {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 0.75rem;
      }
      
      .form-actions {
        flex-direction: column;
      }
      
      .form-actions .btn {
        width: 100%;
      }
      
      .search-container {
        display: none;
      }
    }

    @media (max-width: 576px) {
      .main-content {
        padding: 1rem;
        padding-top: 80px;
      }
      
      .member-grid {
        grid-template-columns: 1fr;
      }
      
      .header {
        padding: 0 1rem;
      }
      
      .wallet-button span {
        display: none;
      }
      
      .section-title {
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <div class="grid-background"></div>
  
  <!-- Sidebar -->
  <aside class="sidebar">
    <a href="#" class="sidebar-logo">
      Sol<span>Synth</span>
    </a>
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="grid"></i>
          </span>
          Dashboard
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link active">
          <span class="sidebar-icon">
            <i data-feather="briefcase"></i>
          </span>
          Manage DAOs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="box"></i>
          </span>
          Create DAO
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="file-text"></i>
          </span>
          Proposals
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="users"></i>
          </span>
          Members
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="database"></i>
          </span>
          Treasury
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="activity"></i>
          </span>
          Analytics
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon">
            <i data-feather="settings"></i>
          </span>
          Settings
        </a>
      </li>
    </ul>
  </aside>

  <!-- Mobile Menu Toggle -->
  <button class="menu-toggle" id="menuToggle">
    <i data-feather="menu"></i>
  </button>

  <!-- Header -->
  <header class="header">
    <div class="page-title">Manage DAOs</div>
    <div class="header-right">
      <div class="search-container">
        <input type="text" class="search-input" placeholder="Search...">
        <i data-feather="search" class="search-icon"></i>
      </div>
      <button class="wallet-button">
        <i data-feather="credit-card"></i>
        <span>Connect Wallet</span>
      </button>
      <div class="user-dropdown">
        <div class="user-avatar">JS</div>
        <div class="user-menu">
          <a href="#" class="user-menu-item">
            <i data-feather="user"></i>
            Profile
          </a>
          <a href="#" class="user-menu-item">
            <i data-feather="bell"></i>
            Notifications
          </a>
          <a href="#" class="user-menu-item">
            <i data-feather="settings"></i>
            Account Settings
          </a>
          <div class="user-menu-divider"></div>
          <a href="#" class="user-menu-item">
            <i data-feather="log-out"></i>
            Sign Out
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main-content">
    <div class="manage-grid">
      <!-- Header Section -->
      <div class="manage-header">
        <h1 class="section-title">Manage Your DAOs</h1>
        <p class="section-subtitle">View and manage all the DAOs you have created or have administrative rights to.</p>
      </div>

      <!-- DAO Selector -->
      <div class="dao-selector">
        <div class="dao-selector-dropdown" id="daoSelector">
          <div class="dao-selector-current">
            <div class="dao-selector-logo">DS</div>
            <div class="dao-selector-info">
              <div class="dao-selector-name">DeFi Synergy DAO</div>
              <div class="dao-selector-meta">24 members • Created 3 months ago</div>
            </div>
          </div>
          <i data-feather="chevron-down"></i>
          <div class="dao-selector-dropdown-menu">
            <div class="dao-option active">
              <div class="dao-option-logo">DS</div>
              <div class="dao-selector-info">
                <div class="dao-selector-name">DeFi Synergy DAO</div>
                <div class="dao-selector-meta">24 members</div>
              </div>
            </div>
            <div class="dao-option">
              <div class="dao-option-logo">NF</div>
              <div class="dao-selector-info">
                <div class="dao-selector-name">NFT Collectors Guild</div>
                <div class="dao-selector-meta">78 members</div>
              </div>
            </div>
            <div class="dao-option">
              <div class="dao-option-logo">SC</div>
              <div class="dao-selector-info">
                <div class="dao-selector-name">Smart Contract Alliance</div>
                <div class="dao-selector-meta">16 members</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- DAO Overview Card -->
      <div class="overview-card">
        <div class="overview-logo">DS</div>
        <div class="overview-content">
          <div class="overview-header">
            <h2 class="overview-title">
              DeFi Synergy DAO
              <span class="overview-status status-active">Active</span>
            </h2>
            <div class="overview-actions">
              <button class="btn btn-outline btn-sm">
                <i data-feather="edit-2"></i>
                Edit
              </button>
              <button class="btn btn-danger btn-sm">
                <i data-feather="alert-circle"></i>
                Suspend
              </button>
            </div>
          </div>
          <p class="overview-description">
            A decentralized autonomous organization focused on creating synergies between DeFi protocols and maximizing yield opportunities through collaborative governance and shared resources.
          </p>
          <div class="overview-stats">
            <div class="overview-stat">
              <div class="overview-stat-value">24</div>
              <div class="overview-stat-label">Members</div>
            </div>
            <div class="overview-stat">
              <div class="overview-stat-value">156.8 SOL</div>
              <div class="overview-stat-label">Treasury Balance</div>
            </div>
            <div class="overview-stat">
              <div class="overview-stat-value">4</div>
              <div class="overview-stat-label">Active Proposals</div>
            </div>
            <div class="overview-stat">
              <div class="overview-stat-value">82%</div>
              <div class="overview-stat-label">Participation Rate</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs -->
      <div class="tabs" id="manageTabs">
        <div class="tab-item active" data-tab="proposals">Proposals</div>
        <div class="tab-item" data-tab="treasury">Treasury</div>
        <div class="tab-item" data-tab="members">Members</div>
        <div class="tab-item" data-tab="settings">Settings</div>
      </div>

      <!-- Tab Content -->
      <div class="tab-content">
        <!-- Proposals Tab -->
        <div class="tab-pane active" id="proposals">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Active Proposals</h3>
              <button class="btn btn-primary btn-sm">
                <i data-feather="plus"></i>
                New Proposal
              </button>
            </div>
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Votes</th>
                    <th>Ends In</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Increase Treasury Allocation for Q3</td>
                    <td><span class="badge badge-primary">Treasury</span></td>
                    <td><span class="badge badge-info">Voting</span></td>
                    <td>
                      <div>Yes: 78%</div>
                      <div>No: 22%</div>
                    </td>
                    <td>2 days</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                      <button class="btn btn-outline btn-sm">Edit</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Add Community Grants Program</td>
                    <td><span class="badge badge-success">Governance</span></td>
                    <td><span class="badge badge-info">Voting</span></td>
                    <td>
                      <div>Yes: 92%</div>
                      <div>No: 8%</div>
                    </td>
                    <td>1 day</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                      <button class="btn btn-outline btn-sm">Edit</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Revise Membership Requirements</td>
                    <td><span class="badge badge-warning">Membership</span></td>
                    <td><span class="badge badge-info">Voting</span></td>
                    <td>
                      <div>Yes: 45%</div>
                      <div>No: 55%</div>
                    </td>
                    <td>5 days</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                      <button class="btn btn-outline btn-sm">Edit</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Partner with SolanaStake Protocol</td>
                    <td><span class="badge badge-primary">Partnership</span></td>
                    <td><span class="badge badge-info">Voting</span></td>
                    <td>
                      <div>Yes: 67%</div>
                      <div>No: 33%</div>
                    </td>
                    <td>3 days</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                      <button class="btn btn-outline btn-sm">Edit</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Past Proposals</h3>
            </div>
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Result</th>
                    <th>Final Votes</th>
                    <th>Ended</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Update DAO Constitution</td>
                    <td><span class="badge badge-primary">Governance</span></td>
                    <td><span class="badge badge-success">Passed</span></td>
                    <td>
                      <div>Yes: 85%</div>
                      <div>No: 15%</div>
                    </td>
                    <td>1 week ago</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Create Marketing Fund</td>
                    <td><span class="badge badge-primary">Treasury</span></td>
                    <td><span class="badge badge-success">Passed</span></td>
                    <td>
                      <div>Yes: 72%</div>
                      <div>No: 28%</div>
                    </td>
                    <td>2 weeks ago</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Expand Member Rewards</td>
                    <td><span class="badge badge-warning">Membership</span></td>
                    <td><span class="badge badge-danger">Failed</span></td>
                    <td>
                      <div>Yes: 42%</div>
                      <div>No: 58%</div>
                    </td>
                    <td>3 weeks ago</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">View</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Treasury Tab -->
        <div class="tab-pane" id="treasury">
          <div class="treasury-stats">
            <div class="treasury-stat-card">
              <div class="treasury-stat-value">156.8 SOL</div>
              <div class="treasury-stat-label">
                <i data-feather="dollar-sign"></i>
                Total Treasury Balance
              </div>
            </div>
            <div class="treasury-stat-card">
              <div class="treasury-stat-value">24.5 SOL</div>
              <div class="treasury-stat-label">
                <i data-feather="arrow-up-right"></i>
                Monthly Income
              </div>
            </div>
            <div class="treasury-stat-card">
              <div class="treasury-stat-value">18.2 SOL</div>
              <div class="treasury-stat-label">
                <i data-feather="arrow-down-right"></i>
                Monthly Expenses
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Treasury Balance History</h3>
            </div>
            <canvas id="treasuryChart" class="treasury-chart"></canvas>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Treasury Assets</h3>
              <button class="btn btn-primary btn-sm">
                <i data-feather="plus"></i>
                Send Funds
              </button>
            </div>
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th>Asset</th>
                    <th>Amount</th>
                    <th>Value (USD)</th>
                    <th>Allocation</th>
                    <th>7d Change</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>SOL</td>
                    <td>125.4 SOL</td>
                    <td>$11,286.00</td>
                    <td>80%</td>
                    <td>+5.4%</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">Send</button>
                      <button class="btn btn-outline btn-sm">Swap</button>
                    </td>
                  </tr>
                  <tr>
                    <td>USDC</td>
                    <td>2,450 USDC</td>
                    <td>$2,450.00</td>
                    <td>15.6%</td>
                    <td>0%</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">Send</button>
                      <button class="btn btn-outline btn-sm">Swap</button>
                    </td>
                  </tr>
                  <tr>
                    <td>RAY</td>
                    <td>320 RAY</td>
                    <td>$704.00</td>
                    <td>4.4%</td>
                    <td>-2.1%</td>
                    <td>
                      <button class="btn btn-secondary btn-sm">Send</button>
                      <button class="btn btn-outline btn-sm">Swap</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recent Transactions</h3>
            </div>
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>From/To</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Transaction ID</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><span class="badge badge-success">Inbound</span></td>
                    <td>0x7a23...45df</td>
                    <td>5.2 SOL</td>
                    <td>May 1, 2025</td>
                    <td><span class="badge badge-success">Completed</span></td>
                    <td>4x8z9...r3f2 <i data-feather="external-link" size="14"></i></td>
                  </tr>
                  <tr>
                    <td><span class="badge badge-danger">Outbound</span></td>
                    <td>0xd45f...78ad</td>
                    <td>1.8 SOL</td>
                    <td>Apr 28, 2025</td>
                    <td><span class="badge badge-success">Completed</span></td>
                    <td>9j2k3...f5d7 <i data-feather="external-link" size="14"></i></td>
                  </tr>
                  <tr>
                    <td><span class="badge badge-danger">Outbound</span></td>
                    <td>0xb67c...12ef</td>
                    <td>250 USDC</td>
                    <td>Apr 25, 2025</td>
                    <td><span class="badge badge-success">Completed</span></td>
                    <td>6h4j2...p9s3 <i data-feather="external-link" size="14"></i></td>
                  </tr>
                  <tr>
                    <td><span class="badge badge-success">Inbound</span></td>
                    <td>0x3f4d...90bc</td>
                    <td>12.5 SOL</td>
                    <td>Apr 22, 2025</td>
                    <td><span class="badge badge-success">Completed</span></td>
                    <td>2n5m7...k8l4 <i data-feather="external-link" size="14"></i></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Members Tab -->
        <div class="tab-pane" id="members">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Member Management</h3>
              <button class="btn btn-primary btn-sm">
                <i data-feather="user-plus"></i>
                Invite Member
              </button>
            </div>
            <div class="member-grid">
              <div class="member-card">
                <div class="member-header">
                  <div class="member-avatar">JS</div>
                  <div class="member-info">
                    <div class="member-name">John Smith</div>
                    <div class="member-wallet">0x7a23...45df</div>
                  </div>
                </div>
                <div class="member-role">
                  <span class="badge badge-primary">Admin</span>
                </div>
                <div class="member-actions">
                  <button class="btn btn-outline btn-sm">
                    <i data-feather="edit-2"></i>
                    Edit Role
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i data-feather="user-minus"></i>
                    Remove
                  </button>
                </div>
              </div>
              <div class="member-card">
                <div class="member-header">
                  <div class="member-avatar">AJ</div>
                  <div class="member-info">
                    <div class="member-name">Alice Johnson</div>
                    <div class="member-wallet">0xd45f...78ad</div>
                  </div>
                </div>
                <div class="member-role">
                  <span class="badge badge-info">Moderator</span>
                </div>
                <div class="member-actions">
                  <button class="btn btn-outline btn-sm">
                    <i data-feather="edit-2"></i>
                    Edit Role
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i data-feather="user-minus"></i>
                    Remove
                  </button>
                </div>
              </div>
              <div class="member-card">
                <div class="member-header">
                  <div class="member-avatar">ML</div>
                  <div class="member-info">
                    <div class="member-name">Mike Lee</div>
                    <div class="member-wallet">0xb67c...12ef</div>
                  </div>
                </div>
                <div class="member-role">
                  <span class="badge badge-info">Moderator</span>
                </div>
                <div class="member-actions">
                  <button class="btn btn-outline btn-sm">
                    <i data-feather="edit-2"></i>
                    Edit Role
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i data-feather="user-minus"></i>
                    Remove
                  </button>
                </div>
              </div>
              <div class="member-card">
                <div class="member-header">
                  <div class="member-avatar">SR</div>
                  <div class="member-info">
                    <div class="member-name">Sarah Rodriguez</div>
                    <div class="member-wallet">0x3f4d...90bc</div>
                  </div>
                </div>
                <div class="member-role">
                  <span class="badge badge-success">Member</span>
                </div>
                <div class="member-actions">
                  <button class="btn btn-outline btn-sm">
                    <i data-feather="edit-2"></i>
                    Edit Role
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i data-feather="user-minus"></i>
                    Remove
                  </button>
                </div>
              </div>
              <div class="member-card">
                <div class="member-header">
                  <div class="member-avatar">KW</div>
                  <div class="member-info">
                    <div class="member-name">Kevin Wang</div>
                    <div class="member-wallet">0x2c8e...56fd</div>
                  </div>
                </div>
                <div class="member-role">
                  <span class="badge badge-success">Member</span>
                </div>
                <div class="member-actions">
                  <button class="btn btn-outline btn-sm">
                    <i data-feather="edit-2"></i>
                    Edit Role
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i data-feather="user-minus"></i>
                    Remove
                  </button>
                </div>
              </div>
              <div class="member-card">
                <div class="member-header">
                  <div class="member-avatar">ED</div>
                  <div class="member-info">
                    <div class="member-name">Emily Davis</div>
                    <div class="member-wallet">0x9a1b...23cd</div>
                  </div>
                </div>
                <div class="member-role">
                  <span class="badge badge-success">Member</span>
                </div>
                <div class="member-actions">
                  <button class="btn btn-outline btn-sm">
                    <i data-feather="edit-2"></i>
                    Edit Role
                  </button>
                  <button class="btn btn-danger btn-sm">
                    <i data-feather="user-minus"></i>
                    Remove
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Member Roles & Permissions</h3>
              <button class="btn btn-primary btn-sm">
                <i data-feather="plus"></i>
                Add Role
              </button>
            </div>
            <div class="table-container">
              <table class="table">
                <thead>
                  <tr>
                    <th>Role</th>
                    <th>Members</th>
                    <th>Create Proposals</th>
                    <th>Vote</th>
                    <th>Manage Treasury</th>
                    <th>Invite Members</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Admin</td>
                    <td>1</td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td>
                      <button class="btn btn-outline btn-sm">Edit</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Moderator</td>
                    <td>2</td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="x" size="16" color="#FF4545"></i></td>
                    <td>
                      <button class="btn btn-outline btn-sm">Edit</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Member</td>
                    <td>21</td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="check" size="16" color="#14F195"></i></td>
                    <td><i data-feather="x" size="16" color="#FF4545"></i></td>
                    <td><i data-