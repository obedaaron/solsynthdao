<?php
    // Simple session check - in a real app, you'd validate the wallet connection
    session_start();
    if (!isset($_SESSION['wallet_address'])) {
        header("Location: index.php");
        exit();
    }
    
    // For demo purposes, you can simulate an address
    $wallet_address = $_SESSION['wallet_address'] ?? "0x7F4e...3A9b";
    
    // In a real app, these values would be retrieved from the session after form submissions
    // Simulate stored session data for the DAO configuration
    $dao_config = [
        'name' => $_SESSION['dao_name'] ?? 'EcoFund DAO',
        'description' => $_SESSION['dao_description'] ?? 'A decentralized organization focused on funding eco-friendly blockchain projects and initiatives.',
        'governance_model' => $_SESSION['governance_model'] ?? 'token_vote',
        'voting_period' => $_SESSION['voting_period'] ?? 7,
        'minimum_quorum' => $_SESSION['minimum_quorum'] ?? 25,
        'token_type' => $_SESSION['token_type'] ?? 'sol',
        'token_mint_address' => $_SESSION['token_mint_address'] ?? ''
    ];
    
    // Convert governance model to display text
    $governance_models = [
        'token_vote' => '1 Token = 1 Vote',
        'quadratic' => 'Quadratic Voting',
        'multisig' => 'Multi-signature'
    ];
    
    $governance_display = $governance_models[$dao_config['governance_model']] ?? $dao_config['governance_model'];
    
    // Get token display information
    $token_display = '';
    switch($dao_config['token_type']) {
        case 'sol':
            $token_display = 'SOL (Solana\'s native token)';
            break;
        case 'usdc':
            $token_display = 'USDC (USD Coin on Solana)';
            break;
        case 'custom':
            $token_display = 'Custom SPL Token<br><span class="token-address">' . $dao_config['token_mint_address'] . '</span>';
            break;
        default:
            $token_display = $dao_config['token_type'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy DAO | SolSynth DAO</title>
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

        /* Deploy Form Styling */
        .deploy-container {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #4b5563;
        }

        .summary-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #374151;
        }

        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .summary-label {
            font-size: 14px;
            color: #9ca3af;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 16px;
            word-break: break-word;
        }

        .token-address {
            font-family: monospace;
            font-size: 14px;
            color: #9ca3af;
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

        .btn-deploy {
            background-color: var(--secondary-color);
            color: white;
            padding: 16px 32px;
            font-size: 18px;
            width: 100%;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-deploy:hover {
            background-color: #0d9669;
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

        /* Deployment Process */
        .deployment-process {
            display: none;
            padding: 20px;
            background-color: var(--input-bg);
            border-radius: var(--border-radius);
            margin-top: 30px;
        }

        .deployment-process.visible {
            display: block;
        }

        .deployment-step {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .deployment-step.current {
            opacity: 1;
        }

        .deployment-step.completed {
            opacity: 1;
        }

        .step-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .step-spinner {
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .step-text {
            flex: 1;
        }

        .step-status {
            margin-left: 8px;
            font-size: 14px;
            color: #9ca3af;
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
            <h1 class="page-title">Review and Deploy</h1>
            <p class="page-subtitle">Verify your DAO configuration and deploy to Solana blockchain</p>
        </div>

        <!-- Progress Indicator -->
        <div class="progress-indicator">
            <div class="step completed">
                <div class="step-number">1</div>
                <div class="step-label">Basic Info</div>
            </div>
            <div class="step completed">
                <div class="step-number">2</div>
                <div class="step-label">Token Setup</div>
            </div>
            <div class="step active">
                <div class="step-number">3</div>
                <div class="step-label">Deploy</div>
            </div>
        </div>

        <!-- DAO Summary and Deploy Section -->
        <div class="deploy-container">
            <h2 class="summary-title">DAO Configuration Summary</h2>
            
            <!-- DAO Name -->
            <div class="summary-item">
                <div class="summary-label">DAO Name</div>
                <div class="summary-value"><?php echo htmlspecialchars($dao_config['name']); ?></div>
            </div>
            
            <!-- DAO Description -->
            <div class="summary-item">
                <div class="summary-label">Description</div>
                <div class="summary-value"><?php echo htmlspecialchars($dao_config['description']); ?></div>
            </div>
            
            <!-- Governance Model -->
            <div class="summary-item">
                <div class="summary-label">Governance Model</div>
                <div class="summary-value"><?php echo htmlspecialchars($governance_display); ?></div>
            </div>
            
            <!-- Voting Period -->
            <div class="summary-item">
                <div class="summary-label">Voting Period</div>
                <div class="summary-value"><?php echo htmlspecialchars($dao_config['voting_period']); ?> days</div>
            </div>
            
            <!-- Minimum Quorum -->
            <div class="summary-item">
                <div class="summary-label">Minimum Quorum</div>
                <div class="summary-value"><?php echo htmlspecialchars($dao_config['minimum_quorum']); ?>%</div>
            </div>
            
            <!-- Governance Token -->
            <div class="summary-item">
                <div class="summary-label">Governance Token</div>
                <div class="summary-value"><?php echo $token_display; ?></div>
            </div>
            
            <div class="btn-container">
                <a href="token_setup.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Token Setup
                </a>
                <button id="deployBtn" class="btn btn-deploy">
                    <i class="fas fa-rocket"></i> Deploy to Solana
                </button>
            </div>
            
            <!-- Deployment Process (initially hidden) -->
            <div class="deployment-process" id="deploymentProcess">
                <!-- Step 1: Connecting Wallet -->
                <div class="deployment-step" id="step1">
                    <div class="step-icon">
                        <i class="fas fa-spinner step-spinner"></i>
                    </div>
                    <div class="step-text">Connecting to wallet</div>
                    <div class="step-status">Pending...</div>
                </div>
                
                <!-- Step 2: Creating DAO Structure -->
                <div class="deployment-step" id="step2">
                    <div class="step-icon">
                        <i class="fas fa-spinner step-spinner"></i>
                    </div>
                    <div class="step-text">Creating DAO governance structure</div>
                    <div class="step-status">Pending...</div>
                </div>
                
                <!-- Step 3: Configuring Token Settings -->
                <div class="deployment-step" id="step3">
                    <div class="step-icon">
                        <i class="fas fa-spinner step-spinner"></i>
                    </div>
                    <div class="step-text">Configuring token settings</div>
                    <div class="step-status">Pending...</div>
                </div>
                
                <!-- Step 4: Finalizing Deployment -->
                <div class="deployment-step" id="step4">
                    <div class="step-icon">
                        <i class="fas fa-spinner step-spinner"></i>
                    </div>
                    <div class="step-text">Finalizing on-chain deployment</div>
                    <div class="step-status">Pending...</div>
                </div>
            </div>
        </div>
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
                document.getElementById('deployBtn').addEventListener('click', startDeployment);
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
            
            // Start deployment process
            function startDeployment() {
                // Show deployment process
                document.getElementById('deploymentProcess').classList.add('visible');
                
                // Disable deploy button
                const deployBtn = document.getElementById('deployBtn');
                deployBtn.disabled = true;
                deployBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deploying...';
                
                // Simulate step-by-step deployment
                simulateDeploymentStep(1);
            }
            
            // Simulate deployment steps
            function simulateDeploymentStep(stepNumber) {
                // Get current step element
                const stepElement = document.getElementById('step' + stepNumber);
                
                // Mark this step as current
                stepElement.classList.add('current');
                
                // Simulate processing time (would be real blockchain interaction in production)
                setTimeout(() => {
                    // Mark step as completed
                    stepElement.classList.add('completed');
                    stepElement.classList.remove('current');
                    
                    // Update step icon and status
                    const stepIcon = stepElement.querySelector('.step-icon');
                    stepIcon.innerHTML = '<i class="fas fa-check" style="color: #10b981;"></i>';
                    
                    const stepStatus = stepElement.querySelector('.step-status');
                    stepStatus.textContent = 'Completed';
                    stepStatus.style.color = '#10b981';
                    
                    // Move to next step or finish
                    if (stepNumber < 4) {
                        simulateDeploymentStep(stepNumber + 1);
                    } else {
                        // All steps completed
                        setTimeout(() => {
                            // Show success message
                            alert('DAO successfully deployed to Solana blockchain! Redirecting to your new DAO dashboard.');
                            // Redirect to DAO dashboard (in a real app)
                            window.location.href = 'dashboard.php?success=true';
                        }, 1000);
                    }
                }, 1500); // Each step takes 1.5 seconds in this simulation
            }
            
            // Call the init function to set up the page
            initPage();
        });
    </script>
</body>
</html>