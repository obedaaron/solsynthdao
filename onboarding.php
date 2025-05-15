<?php
session_start();
// Check if the user has a wallet address stored in the session
$walletAddress = isset($_SESSION['wallet_address']) ? $_SESSION['wallet_address'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SolSynth DAO - Create New DAO</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
      top: 1.1rem;
      right: 10.5rem;
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

    /* Create DAO Content */
    .create-dao-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .create-dao-header {
      margin-bottom: 2rem;
    }

    .section-title {
      font-size: 1.75rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .section-subtitle {
      color: var(--light-gray);
      font-size: 1rem;
      max-width: 700px;
    }

    /* Mode Selector Tabs */
    .mode-selector {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding-bottom: 1rem;
    }

    .mode-button {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: transparent;
      border: none;
      color: var(--light-gray);
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1rem;
      font-weight: 500;
      padding: 0.75rem 1.5rem;
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: var(--transition);
    }

    .mode-button:hover {
      background: rgba(255, 255, 255, 0.05);
      color: white;
    }

    .mode-button.active {
      background: rgba(153, 69, 255, 0.1);
      color: white;
      box-shadow: 0 2px 0 var(--primary);
    }

    /* Card styles */
    .card {
      background: rgba(26, 26, 26, 0.7);
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.05);
      padding: 1.5rem;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
      transition: var(--transition);
      margin-bottom: 1.5rem;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.25rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .card-title {
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* AI Mode Styles */
    .ai-input-container {
      margin-bottom: 1.5rem;
    }

    .ai-textarea {
      width: 100%;
      min-height: 180px;
      background: rgba(45, 45, 45, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 1rem;
      color: white;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1rem;
      resize: vertical;
      transition: var(--transition);
    }

    .ai-textarea::placeholder {
      color: var(--very-light-gray);
    }

    .ai-textarea:focus {
      outline: none;
      border-color: var(--primary-lighter);
    }

    .ai-submit-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 1rem;
      margin-bottom: 2rem;
    }

    .ai-hint {
      color: var(--light-gray);
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn {
      padding: 0.7rem 1.5rem;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 0.95rem;
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

    /* Preview Container */
    .preview-container {
      background: rgba(33, 33, 33, 0.7);
      border-radius: var(--radius);
      border: 1px solid rgba(153, 69, 255, 0.2);
      padding: 1.5rem;
      margin-bottom: 2rem;
      display: none;
    }

    .preview-container.visible {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .preview-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .preview-title {
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .preview-edit-button {
      padding: 0.4rem 1rem;
      border-radius: var(--radius-sm);
      font-size: 0.85rem;
    }

    .preview-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    .preview-item {
      margin-bottom: 1.25rem;
    }

    .preview-label {
      font-size: 0.85rem;
      color: var(--light-gray);
      margin-bottom: 0.25rem;
    }

    .preview-value {
      font-size: 1rem;
      font-weight: 500;
    }

    .preview-dao-name {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .preview-dao-description {
      color: var(--light-gray);
      margin-bottom: 1.5rem;
    }

    .preview-section {
      margin-bottom: 1.5rem;
    }

    .preview-section-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .tag {
      display: inline-block;
      background: rgba(153, 69, 255, 0.1);
      color: white;
      border-radius: 4px;
      padding: 0.25rem 0.75rem;
      font-size: 0.85rem;
      margin-right: 0.5rem;
      margin-bottom: 0.5rem;
    }

    .role-item {
      background: rgba(45, 45, 45, 0.7);
      border-radius: var(--radius-sm);
      padding: 0.75rem 1rem;
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .role-name {
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .role-permissions {
      font-size: 0.85rem;
      color: var(--light-gray);
    }

    /* Form Styles */
    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-weight: 500;
      margin-bottom: 0.5rem;
    }

    .form-hint {
      display: block;
      font-size: 0.85rem;
      color: var(--light-gray);
      margin-top: 0.25rem;
    }

    .form-input, .form-select, .form-textarea {
      width: 100%;
      background: rgba(45, 45, 45, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 0.75rem 1rem;
      color: white;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .form-textarea {
      min-height: 120px;
      resize: vertical;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--primary-lighter);
    }

    .form-input::placeholder, .form-textarea::placeholder {
      color: var(--very-light-gray);
    }

    .form-actions {
      padding-top: 1rem;
      margin-top: 2rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
    }

    .form-full-width {
      grid-column: span 2;
    }

    /* Toggle Switch */
    .toggle-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .toggle-label {
      font-weight: 500;
    }

    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(45, 45, 45, 0.7);
      transition: .4s;
      border-radius: 24px;
    }

    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .toggle-slider {
      background-color: var(--primary);
    }

    input:checked + .toggle-slider:before {
      transform: translateX(26px);
    }

    /* Role Management */
    .roles-container {
      margin-top: 1rem;
    }

    .role-row {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
      background: rgba(45, 45, 45, 0.7);
      border-radius: var(--radius-sm);
      padding: 0.75rem 1rem;
    }

    .role-input {
      flex: 1;
    }

    .role-action {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: white;
      width: 32px;
      height: 32px;
      border-radius: 4px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    .role-action:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    .add-role-button {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: transparent;
      border: 1px dashed rgba(153, 69, 255, 0.3);
      color: white;
      padding: 0.75rem 1rem;
      border-radius: var(--radius-sm);
      width: 100%;
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
    }

    .add-role-button:hover {
      background: rgba(153, 69, 255, 0.05);
    }

    .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
  }

  .modal-overlay.visible {
    opacity: 1;
    visibility: visible;
  }

  .modal-container {
    background: linear-gradient(145deg, rgba(33, 33, 33, 0.95), rgba(26, 26, 26, 0.95));
    border-radius: var(--radius);
    border: 1px solid rgba(153, 69, 255, 0.2);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    animation: modal-appear 0.4s ease-out forwards;
    position: relative;
  }

  @keyframes modal-appear {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .modal-header {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .modal-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0;
    background: linear-gradient(45deg, var(--primary), var(--tertiary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .modal-close {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
  }

  .modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
  }

  .modal-body {
    padding: 1.5rem;
  }

  .modal-message {
    color: var(--light-gray);
    margin-bottom: 1.5rem;
    font-size: 1rem;
  }

  .dao-details-container {
    background: rgba(18, 18, 18, 0.4);
    border-radius: var(--radius-sm);
    padding: 1.25rem;
    margin-bottom: 1rem;
  }

  .dao-details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.25rem;
  }

  .dao-detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .detail-label {
    font-size: 0.85rem;
    color: var(--light-gray);
  }

  .detail-value {
    font-size: 1rem;
    font-weight: 500;
    color: white;
  }

  .dao-roles-section {
    margin-top: 0.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  .roles-list {
    margin-top: 0.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  .role-tag {
    background: rgba(153, 69, 255, 0.1);
    border: 1px solid rgba(153, 69, 255, 0.2);
    border-radius: 4px;
    padding: 0.25rem 0.75rem;
    font-size: 0.9rem;
    color: white;
  }

  .deployment-cost {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-weight: 600;
  }

  .cost-label {
    color: var(--light-gray);
  }

  .cost-value {
    color: var(--secondary);
    font-size: 1.1rem;
  }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  .modal-deploy {
    background: linear-gradient(45deg, var(--primary), var(--primary-lighter));
    padding: 0.7rem 1.75rem;
  }

  .modal-deploy:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(153, 69, 255, 0.3);
  }

  .deployment-status {
    padding: 0 1.5rem 1.5rem;
    text-align: center;
    font-weight: 500;
    min-height: 24px;
  }

  .deployment-status.success {
    color: var(--secondary);
  }

  .deployment-status.loading {
    color: var(--primary-lighter);
  }

  .deployment-status.error {
    color: #ff5252;
  }

  .loader {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: var(--primary);
    animation: spin 1s ease-in-out infinite;
    margin-right: 8px;
    vertical-align: middle;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  @media (max-width: 768px) {
    .dao-details-grid {
      grid-template-columns: 1fr;
    }
    
    .modal-footer {
      flex-direction: column;
    }
    
    .modal-footer button {
      width: 100%;
    }
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
      .form-grid {
        grid-template-columns: 1fr;
      }
      
      .form-full-width {
        grid-column: span 1;
      }
      
      .preview-grid {
        grid-template-columns: 1fr;
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
      .header-right {
        gap: 0.75rem;
      }
      
      .search-container {
        display: none;
      }
      
      .wallet-button span {
        display: none;
      }
      
      .mode-selector {
        flex-direction: column;
        gap: 0.5rem;
      }
      
      .mode-button {
        width: 100%;
        justify-content: center;
      }
      
      .ai-submit-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
      
      .ai-submit-container .btn {
        width: 100%;
      }
      
      .footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
      }
      
      .footer-links {
        justify-content: center;
        flex-wrap: wrap;
      }
    }

    /* Custom scrollbar */
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
  <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Function to shorten the wallet address
    function displayWalletAddress(walletAddress) {
        const shortenedAddress = walletAddress.slice(0, 6) + '...' + walletAddress.slice(-4); // Show first 6 and last 4 characters
        const walletAddressSpan = document.getElementById('wallet-address');

        if (walletAddressSpan) {
            walletAddressSpan.textContent = shortenedAddress;
        }
    }

    // Assuming the wallet address is fetched from PHP or a session variable
    <?php if ($walletAddress): ?>
        const walletAddress = "<?php echo $walletAddress; ?>";
        displayWalletAddress(walletAddress);
    <?php endif; ?>
});

  </script>
</head>
<body>
  <!-- Grid Background -->
  <div class="grid-background"></div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <a href="#" class="sidebar-logo">Sol<span>Synth</span></a>
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a href="dashboard.php" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="grid"></i></span>
          Dashboard
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link">
          <span class="sidebar-icon"><i data-feather="layers"></i></span>
          Manage DAOs
        </a>
      </li>
      <li class="sidebar-item">
        <a href="#" class="sidebar-link active">
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
    <h1 class="page-title">Create DAO</h1>
    <div class="header-right">
      <div class="search-container">
      <i data-feather="search" class="search-icon"></i>
        <input type="text" class="search-input" placeholder="Search...">
      </div>
      <button class="wallet-button">
    <i data-feather="credit-card"></i>
    <!-- Display wallet address if session exists, otherwise show 'Connect Wallet' -->
    <span id="wallet-address">
      <?php echo $walletAddress ? $walletAddress : "Connect Wallet"; ?>
    </span>
</button>

      <div class="user-dropdown">
        <div class="user-avatar">JS</div>
        <div class="user-menu">
          <a href="#" class="user-menu-item">
            <i data-feather="user"></i>
            My Profile
          </a>
          <a href="#" class="user-menu-item">
            <i data-feather="settings"></i>
            Settings
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
    <div class="create-dao-container">
      <!-- Page Header -->
      <div class="create-dao-header">
        <h2 class="section-title">
          <i data-feather="plus-circle"></i>
          Create New DAO
        </h2>
        <p class="section-subtitle">Setup and deploy your own DAO on Solana blockchain with customizable governance, tokenomics, and roles.</p>
      </div>

      <!-- Mode Selector Tabs -->
      <div class="mode-selector">
        <button class="mode-button active" data-mode="ai">
          <i data-feather="cpu"></i>
          🧠 Use AI Assistant
        </button>
        <button class="mode-button" data-mode="manual">
          <i data-feather="edit-3"></i>
          ✍️ Manual Setup
        </button>
      </div>

      <!-- AI Mode Content -->
      <div class="mode-content" id="ai-mode">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <i data-feather="cpu"></i>
              AI-Powered DAO Creator
            </div>
          </div>
          <div class="ai-input-container">
            <textarea class="ai-textarea" placeholder="Describe the DAO you want to create in natural language. For example: 'I want a token-gated DAO for artists with voting every Friday and 3 days voting period. The DAO should focus on funding digital art projects with a treasury managed by a 3-member council.'"></textarea>
          </div>
          <div class="ai-submit-container">
            <div class="ai-hint">
              <i data-feather="info"></i>
              The AI will generate a complete DAO configuration based on your description.
            </div>
            <button class="btn btn-primary" id="generate-dao-btn">
              <i data-feather="zap"></i>
              Generate DAO
            </button>
          </div>
        </div>

        <!-- Preview Section (Hidden by default, shown after AI generation) -->
        <div class="preview-container" id="preview-container">
          <div class="preview-header">
            <div class="preview-title">
              <i data-feather="eye"></i>
              Preview DAO Configuration
            </div>
            <button class="btn btn-outline preview-edit-button">
              <i data-feather="edit-2"></i>
              Edit Details
            </button>
          </div>

          <div class="preview-dao-name">ArtistCollective DAO</div>
          <div class="preview-dao-description">A decentralized organization for digital artists to fund, collaborate, and promote innovative art projects on the blockchain.</div>

          <div class="preview-grid">
            <div class="preview-section">
              <div class="preview-section-title">Token Configuration</div>
              <div class="preview-item">
                <div class="preview-label">Token Name</div>
                <div class="preview-value">ArtistCollective Token</div>
              </div>
              <div class="preview-item">
                <div class="preview-label">Token Symbol</div>
                <div class="preview-value">ACT</div>
              </div>
              <div class="preview-item">
                <div class="preview-label">Initial Supply</div>
                <div class="preview-value">1,000,000 ACT</div>
              </div>
              <div class="preview-item">
                <div class="preview-label">Governance Token</div>
                <div class="preview-value">Yes (1 token = 1 vote)</div>
              </div>
            </div>

            <div class="preview-section">
              <div class="preview-section-title">Governance Settings</div>
              <div class="preview-item">
                <div class="preview-label">Voting Days</div>
                <div class="preview-value">Friday (Weekly)</div>
              </div>
              <div class="preview-item">
                <div class="preview-label">Voting Duration</div>
                <div class="preview-value">3 days</div>
              </div>
              <div class="preview-item">
                <div class="preview-label">Approval Threshold</div>
                <div class="preview-value">60%</div>
              </div>
              <div class="preview-item">
                <div class="preview-label">Quorum Required</div>
                <div class="preview-value">25% of token supply</div>
              </div>
            </div>
          </div>

          <div class="preview-section">
            <div class="preview-section-title">Roles and Permissions</div>
            <div class="role-item">
              <div class="role-name">
                <i data-feather="shield"></i>
                Council Member
              </div>
              <div class="role-permissions">Treasury management, proposal creation, voting</div>
            </div>
            <div class="role-item">
              <div class="role-name">
                <i data-feather="users"></i>
                Artist
              </div>
              <div class="role-permissions">Proposal creation, voting</div>
            </div>
            <div class="role-item">
              <div class="role-name">
                <i data-feather="user"></i>
                Community Member
              </div>
              <div class="role-permissions">Voting only</div>
            </div>
          </div>

          <div class="preview-section">
            <div class="preview-section-title">Tags</div>
            <div class="tag">Art</div>
            <div class="tag">Creative</div>
            <div class="tag">Community</div>
            <div class="tag">Treasury</div>
            <div class="tag">Token-gated</div>
          </div>

          <div class="form-actions">
            <button class="btn btn-secondary">
              <i data-feather="refresh-cw"></i>
              Regenerate
            </button>
            <button class="btn btn-primary">
              <i data-feather="check-circle"></i>
              Confirm & Deploy
            </button>
          </div>
        </div>
      </div>

      <!-- Manual Mode Content -->
      <div class="mode-content" id="manual-mode" style="display: none;">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <i data-feather="settings"></i>
              Manual DAO Configuration
            </div>
          </div>

          <form id="manual-dao-form">
            <div class="form-grid">
              <!-- Basic Information Section -->
              <div class="form-group">
                <label for="dao-name" class="form-label">DAO Name</label>
                <input type="text" id="dao-name" name="dao_name" class="form-input" placeholder="Enter DAO name">
                <span class="form-hint">Choose a unique name for your organization</span>
              </div>

              <div class="form-group">
                <label for="dao-symbol" class="form-label">DAO Symbol</label>
                <input type="text" id="dao-symbol" name="dao_symbol" class="form-input" placeholder="3-5 letters (e.g. BTC, ETH)">
                <span class="form-hint">Short symbol for your DAO</span>
              </div>

              <div class="form-group form-full-width">
                <label for="dao-description" class="form-label">Description</label>
                <textarea id="dao-description" name="dao_description" class="form-textarea" placeholder="Describe your DAO's purpose and goals"></textarea>
                <span class="form-hint">Write a clear description to attract members</span>
              </div>

              <!-- Token Configuration -->
              <div class="form-group">
                <label for="token-name" class="form-label">Token Name</label>
                <input type="text" id="token-name" name="token_name" class="form-input" placeholder="Enter token name">
              </div>

              <div class="form-group">
                <label for="token-symbol" class="form-label">Token Symbol</label>
                <input type="text" id="token-symbol" name="token_symbol" class="form-input" placeholder="3-5 letters (e.g. BTC, ETH)">
              </div>

              <div class="form-group">
                <label for="token-supply" class="form-label">Initial Supply</label>
                <input type="number" id="token-supply" name="token_supply" class="form-input" placeholder="Enter total supply" min="1">
              </div>

              <div class="form-group">
                <div class="toggle-container">
                  <div class="toggle-label">Enable Governance Token</div>
                  <label class="toggle-switch">
                    <input type="checkbox" id="governance-enabled" name="governance_enabled" checked>
                    <span class="toggle-slider"></span>
                  </label>
                </div>
                <span class="form-hint">Token holders can vote on proposals</span>
              </div>

              <!-- Governance Settings -->
              <div class="form-group">
                <label for="vote-quorum" class="form-label">Quorum (%)</label>
                <input type="number" id="vote-quorum" name="vote_quorum" class="form-input" placeholder="Min. participation %" value="25" min="1" max="100">
                <span class="form-hint">Minimum % of tokens that must vote</span>
              </div>

              <div class="form-group">
                <label for="vote-threshold" class="form-label">Approval Threshold (%)</label>
                <input type="number" id="vote-threshold" name="vote_threshold" class="form-input" placeholder="Required % to pass" value="60" min="51" max="100">
                <span class="form-hint">% of votes needed to approve</span>
              </div>

              <div class="form-group">
                <label for="vote-duration" class="form-label">Voting Duration (days)</label>
                <input type="number" id="vote-duration" name="vote_duration" class="form-input" placeholder="Number of days" value="3" min="1" max="30">
                <span class="form-hint">How long voting remains open</span>
              </div>

              <div class="form-group">
                <label for="vote-days" class="form-label" name="vote_days">Voting Days</label>
                <select id="vote-days" name="vote_days"
                class="form-select">
                  <option value="any">Any day</option>
                  <option value="weekdays">Weekdays only</option>
                  <option value="weekends">Weekends only</option>
                  <option value="monday">Monday</option>
                  <option value="friday">Friday</option>
                </select>
                <span class="form-hint">When voting can take place</span>
              </div>

              <!-- Roles Management -->
              <div class="form-group form-full-width">
                <label class="form-label">Roles</label>
                <div class="roles-container" id="roles-container">
                  <div class="role-row">
                    <input type="text" class="form-input role-input" name="roles[]" placeholder="Role name" value="Admin">
                    <button type="button" class="role-action remove-role"><i data-feather="trash-2"></i></button>
                  </div>
                  <div class="role-row">
                    <input type="text" class="form-input role-input" name="roles[]" placeholder="Role name" value="Member">
                    <button type="button" class="role-action remove-role"><i data-feather="trash-2"></i></button>
                  </div>
                </div>
                <button type="button" class="add-role-button" id="add-role-btn">
                  <i data-feather="plus"></i>
                  Add Role
                </button>
              </div>
            </div>

            <div class="form-actions">
              <button type="reset" class="btn btn-secondary">
                <i data-feather="refresh-cw"></i>
                Reset
              </button>
              <button type="submit" class="btn btn-primary">
                <i data-feather="check-circle"></i>
                Create DAO
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Add this at the end of your body tag, before the closing </body> -->
<div id="dao-confirmation-modal" class="modal-overlay">
  <div class="modal-container">
    <div class="modal-header">
      <h2>DAO Created Successfully!</h2>
      <button class="modal-close" id="modal-close">
        <i data-feather="x"></i>
      </button>
    </div>
    <div class="modal-body">
      <p class="modal-message">Your DAO has been configured. Review the details below and deploy to the Solana blockchain.</p>
      
      <div class="dao-details-container">
        <div class="dao-details-grid">
          <div class="dao-detail-item">
            <div class="detail-label">DAO Name</div>
            <div class="detail-value" id="modal-dao-name">-</div>
          </div>
          <div class="dao-detail-item">
            <div class="detail-label">DAO Symbol</div>
            <div class="detail-value" id="modal-dao-symbol">-</div>
          </div>
          <div class="dao-detail-item">
            <div class="detail-label">Token Supply</div>
            <div class="detail-value" id="modal-token-supply">-</div>
          </div>
          <div class="dao-detail-item">
            <div class="detail-label">Governance Token</div>
            <div class="detail-value" id="modal-governance">-</div>
          </div>
          <div class="dao-detail-item">
            <div class="detail-label">Voting Quorum</div>
            <div class="detail-value" id="modal-quorum">-</div>
          </div>
          <div class="dao-detail-item">
            <div class="detail-label">Approval Threshold</div>
            <div class="detail-value" id="modal-threshold">-</div>
          </div>
        </div>
        
        <div class="dao-roles-section">
          <div class="detail-label">Roles</div>
          <div class="roles-list" id="modal-roles">
            <!-- Roles will be injected here -->
          </div>
        </div>
        
        <div class="deployment-cost">
          <div class="cost-label">Deployment Cost:</div>
          <div class="cost-value">0.025 SOL</div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary modal-cancel">Cancel</button>
      <button class="btn btn-primary modal-deploy" id="deploy-dao-btn">
        <i data-feather="upload-cloud"></i>
        Deploy to Solana
      </button>
    </div>
    <div class="deployment-status" id="deployment-status"></div>
  </div>
</div>

    <!-- Footer -->
    <footer class="footer">
      <div>&copy; 2025 SolSynth DAO. All rights reserved.</div>
      <div class="footer-links">
        <a href="#" class="footer-link">Terms</a>
        <a href="#" class="footer-link">Privacy</a>
        <a href="#" class="footer-link">Docs</a>
        <a href="#" class="footer-link">Support</a>
      </div>
    </footer>
  </div>

  <script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("manual-dao-form");

  form.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent full page reload

    const formData = new FormData(form);

    fetch("dao_creation.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      console.log("DAO saved:", data);

      // Now show the preview popup
      const previewContainer = document.getElementById("preview-container");
      previewContainer.style.display = "block";
      previewContainer.scrollIntoView({ behavior: "smooth" });

      // Optional: update the preview section dynamically with the submitted data
    })
    .catch(error => {
      console.error("Error saving DAO:", error);
      alert("There was an error creating the DAO.");
    });
  });
});
</script>
</body>
</html>