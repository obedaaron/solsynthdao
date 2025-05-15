<?php
    // Simple session check - in a real app, you'd validate the wallet connection
    session_start();
    if (!isset($_SESSION['wallet_address'])) {
        header("Location: index.php");
        exit();
    }
    // For demo purposes, you can simulate an address
    $wallet_address = $_SESSION['wallet_address'] ?? "0x7F4e...3A9b";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Setup | SolSynth DAO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6d28d9;
            --primary-dark: #5b21b6;
            --primary-light: #8b5cf6;
            --secondary-color: #10b981;
            --dark-bg: #111827;
            --darker-bg: #0d1117;
            --light-text: #f3f4f6;
            --card-bg: #1f2937;
            --card-hover: #2d3748;
            --input-bg: #374151;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--light-text);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header/Navbar */
        header {
            background-color: var(--darker-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 700;
            color: var(--light-text);
            text-decoration: none;
        }

        .logo i {
            margin-right: 10px;
            color: var(--primary-light);
        }

        .wallet-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .wallet-address {
            background-color: var(--card-bg);
            padding: 8px 12px;
            border-radius: var(--border-radius);
            font-family: monospace;
            font-size: 14px;
        }

        .disconnect-btn {
            background-color: transparent;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .disconnect-btn:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        /* Main Content */
        main {
            padding: 40px 0;
        }

        .page-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .page-title {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .page-subtitle {
            font-size: 16px;
            color: #9ca3af;
        }

        /* Form Styling */
        .token-setup-form {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-hint {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--input-bg);
            border: 1px solid #4b5563;
            border-radius: var(--border-radius);
            color: var(--light-text);
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--primary-light);
            outline: none;
        }

        .token-option {
            display: flex;
            align-items: center;
            padding: 16px;
            background-color: var(--input-bg);
            border: 1px solid #4b5563;
            border-radius: var(--border-radius);
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .token-option:hover {
            background-color: #42495a;
        }

        .token-option.selected {
            border-color: var(--primary-light);
            background-color: rgba(139, 92, 246, 0.1);
        }

        .token-radio {
            margin-right: 16px;
        }

        .token-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            font-weight: bold;
            font-size: 14px;
        }

        .token-icon.sol {
            background-color: #9945FF;
        }

        .token-icon.usdc {
            background-color: #2775CA;
        }

        .token-icon.custom {
            background-color: #F43F5E;
        }

        .token-details {
            flex: 1;
        }

        .token-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .token-description {
            font-size: 12px;
            color: #9ca3af;
        }

        .custom-token-input {
            margin-top: 16px;
            display: none;
        }

        .custom-token-input.visible {
            display: block;
        }

        /* Button Styling */
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: transparent;
            border: 1px solid #4b5563;
            color: var(--light-text);
        }

        .btn-secondary:hover {
            background-color: #374151;
        }

        .progress-indicator {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
        }

        .step {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }

        .step-label {
            font-size: 14px;
        }

        .step.active .step-number {
            background-color: var(--secondary-color);
        }

        .step.active .step-label {
            font-weight: 600;
        }

        .step.completed .step-number {
            background-color: var(--secondary-color);
        }

        /* Footer */
        footer {
            background-color: var(--darker-bg);
            padding: 30px 0;
            margin-top: 60px;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-links {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--light-text);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-links a {
            color: #9ca3af;
            font-size: 18px;
            transition: color 0.2s ease;
        }

        .social-links a:hover {
            color: var(--primary-light);
        }

        .copyright {
            color: #6b7280;
            font-size: 14px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .btn-container {
                flex-direction: column;
                gap: 16px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .footer-links {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Header/Navbar -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="dashboard.php" class="logo">
                    <i class="fas fa-sun"></i>
                    SolSynth DAO
                </a>
                <div class="wallet-info">
                    <div class="wallet-address" id="walletAddress"><?php echo $wallet_address; ?></div>
                    <button class="disconnect-btn" id="disconnectBtn" title="Disconnect wallet">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="page-header">
            <h1 class="page-title">Token Setup</h1>
            <p class="page-subtitle">Select the governance token that will be used for your DAO</p>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-label">Basic Info</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-label">Token Setup</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-label">Deploy</div>
            </div>
        </div>

        <!-- Token Setup Form -->
        <form class="token-setup-form" id="tokenSetupForm" method="post" action="process_token.php">
            <div class="form-group">
                <label class="form-label">Select Governance Token *</label>
                <p class="form-hint">Choose an existing token that will be used for governance in your DAO</p>
                
                <div class="token-options">
                    <!-- SOL Token Option -->
                    <div class="token-option" data-token="sol">
                        <input type="radio" name="token_type" id="tokenSol" value="sol" class="token-radio" required>
                        <div class="token-icon sol">S</div>
                        <div class="token-details">
                            <div class="token-name">SOL</div>
                            <div class="token-description">Solana's native token</div>
                        </div>
                    </div>
                    
                    <!-- USDC Token Option -->
                    <div class="token-option" data-token="usdc">
                        <input type="radio" name="token_type" id="tokenUsdc" value="usdc" class="token-radio">
                        <div class="token-icon usdc">U</div>
                        <div class="token-details">
                            <div class="token-name">USDC</div>
                            <div class="token-description">USD Coin on Solana</div>
                        </div>
                    </div>
                    
                    <!-- Custom SPL Token Option -->
                    <div class="token-option" data-token="custom">
                        <input type="radio" name="token_type" id="tokenCustom" value="custom" class="token-radio">
                        <div class="token-icon custom">C</div>
                        <div class="token-details">
                            <div class="token-name">Custom SPL Token</div>
                            <div class="token-description">Use your own existing SPL token</div>
                        </div>
                    </div>
                </div>
                
                <!-- Custom Token Input (initially hidden) -->
                <div class="custom-token-input" id="customTokenInput">
                    <div class="form-group">
                        <label for="tokenMintAddress" class="form-label">SPL Token Mint Address *</label>
                        <input type="text" id="tokenMintAddress" name="token_mint_address" class="form-input" placeholder="e.g., FidU7S6DYUATPmQ6pmDXc5hBm9WpgJB2d5pFSMFyA56">
                        <p class="form-hint">Enter the mint address of your existing SPL token</p>
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <a href="onboarding.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Basic Info
                </a>
                <button type="submit" class="btn btn-primary" id="continueBtn">
                    Continue to Deploy <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#">About</a>
                    <a href="#">Documentation</a>
                    <a href="#">Community</a>
                    <a href="#">Support</a>
                </div>
                <div class="social-links">
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Discord"><i class="fab fa-discord"></i></a>
                    <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                    <a href="#" title="Medium"><i class="fab fa-medium"></i></a>
                </div>
                <div class="copyright">
                    &copy; 2025 SolSynth DAO. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if wallet is connected
            function checkWalletConnection() {
                const walletAddress = document.getElementById('walletAddress').textContent;
                if (!walletAddress || walletAddress.trim() === '') {
                    window.location.href = 'index.php';
                }
            }
            
            // Initialize the page
            function initPage() {
                checkWalletConnection();
                
                // Set up event listeners
                document.getElementById('disconnectBtn').addEventListener('click', disconnectWallet);
                document.getElementById('tokenSetupForm').addEventListener('submit', handleFormSubmit);
                
                // Set up token selection
                const tokenOptions = document.querySelectorAll('.token-option');
                tokenOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        // Get the radio input inside this option
                        const radio = this.querySelector('input[type="radio"]');
                        radio.checked = true;
                        
                        // Remove selected class from all options
                        tokenOptions.forEach(opt => opt.classList.remove('selected'));
                        
                        // Add selected class to this option
                        this.classList.add('selected');
                        
                        // Show/hide custom token input
                        toggleCustomTokenInput();
                    });
                });
                
                // Set up radio button listeners
                const radioButtons = document.querySelectorAll('input[name="token_type"]');
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', toggleCustomTokenInput);
                });
            }
            
            // Toggle custom token input visibility
            function toggleCustomTokenInput() {
                const customTokenInput = document.getElementById('customTokenInput');
                const isCustomSelected = document.getElementById('tokenCustom').checked;
                
                if (isCustomSelected) {
                    customTokenInput.classList.add('visible');
                    document.getElementById('tokenMintAddress').setAttribute('required', 'required');
                } else {
                    customTokenInput.classList.remove('visible');
                    document.getElementById('tokenMintAddress').removeAttribute('required');
                }
            }
            
            // Disconnect wallet function
            function disconnectWallet() {
                // In a real app, you'd clear session and blockchain connection
                fetch('disconnect.php', {
                    method: 'POST'
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = 'index.php';
                    }
                })
                .catch(error => {
                    console.error('Error disconnecting wallet:', error);
                    // Fallback if the fetch fails
                    window.location.href = 'index.php';
                });
            }
            
            // Handle form submission
            function handleFormSubmit(event) {
                event.preventDefault();
                
                // Validate form
                if (validateForm()) {
                    // Show loading state
                    const submitButton = document.getElementById('continueBtn');
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    submitButton.disabled = true;
                    
                    // Simulate processing (in a real app, you'd make an API call)
                    setTimeout(() => {
                        // Redirect to next step (deploy)
                        window.location.href = 'deploy.php';
                    }, 1500);
                }
            }
            
            // Basic form validation
            function validateForm() {
                const selectedToken = document.querySelector('input[name="token_type"]:checked');
                
                if (!selectedToken) {
                    alert('Please select a governance token');
                    return false;
                }
                
                if (selectedToken.value === 'custom') {
                    const mintAddress = document.getElementById('tokenMintAddress').value.trim();
                    if (!mintAddress) {
                        alert('Please enter the SPL Token Mint Address');
                        return false;
                    }
                    
                    // Basic format validation for Solana addresses (should be better in production)
                    if (mintAddress.length < 32) {
                        alert('Please enter a valid SPL Token Mint Address');
                        return false;
                    }
                }
                
                return true;
            }
            
            // Call the init function to set up the page
            initPage();
        });
    </script>
</body>
</html>