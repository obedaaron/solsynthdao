<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore DAOs | SolSynth DAO</title>
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
            --filter-bg: #1a202c;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
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
            transition: var(--transition);
        }

        .disconnect-btn:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        /* Main Content */
        main {
            padding: 40px 0;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 32px;
            margin-bottom: 16px;
        }

        .page-description {
            max-width: 800px;
            margin: 0 auto;
            color: #9ca3af;
            font-size: 16px;
            line-height: 1.7;
        }

        /* Layout */
        .explore-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }

        /* Filters Sidebar */
        .filters-sidebar {
            background-color: var(--filter-bg);
            border-radius: var(--border-radius);
            padding: 24px;
            position: sticky;
            top: 90px;
            height: max-content;
            box-shadow: var(--box-shadow);
        }

        .filters-title {
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .reset-filters {
            font-size: 12px;
            color: var(--primary-light);
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: underline;
        }

        .filter-section {
            margin-bottom: 24px;
        }

        .filter-section-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .checkbox-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-option input {
            accent-color: var(--primary-color);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .checkbox-option label {
            font-size: 14px;
            cursor: pointer;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .radio-option input {
            accent-color: var(--primary-color);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .radio-option label {
            font-size: 14px;
            cursor: pointer;
        }

        .range-slider {
            width: 100%;
            margin: 8px 0;
        }

        .range-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #9ca3af;
        }

        /* Search and Sort */
        .content-area {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .search-sort-container {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .search-container {
            position: relative;
            flex-grow: 1;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            background-color: var(--card-bg);
            border: 1px solid #374151;
            border-radius: var(--border-radius);
            color: var(--light-text);
            font-size: 14px;
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .sort-container {
            min-width: 180px;
        }

        .sort-select {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--card-bg);
            border: 1px solid #374151;
            border-radius: var(--border-radius);
            color: var(--light-text);
            font-size: 14px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%239ca3af'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            cursor: pointer;
            transition: var(--transition);
        }

        .sort-select:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
        }

        /* DAO List */
        .dao-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .dao-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            position: relative;
        }

        .dao-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            background-color: var(--card-hover);
        }

        .dao-card-banner {
            height: 80px;
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-light));
            position: relative;
        }

        .dao-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--card-bg);
            position: absolute;
            bottom: -30px;
            left: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 4px solid var(--card-bg);
            z-index: 1;
        }

        .dao-logo i {
            font-size: 24px;
            color: var(--primary-light);
        }

        .dao-card-content {
            padding: 40px 20px 20px;
        }

        .dao-badges {
            position: absolute;
            top: 12px;
            right: 12px;
            display: flex;
            gap: 6px;
            z-index: 1;
        }

        .dao-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-trending {
            background-color: #ef4444;
            color: white;
        }

        .badge-new {
            background-color: var(--secondary-color);
            color: white;
        }

        .badge-popular {
            background-color: #f59e0b;
            color: white;
        }

        .dao-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .dao-description {
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 16px;
            line-height: 1.5;
            height: 65px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .dao-info {
            border-top: 1px solid rgba(156, 163, 175, 0.2);
            padding-top: 16px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .info-label {
            color: #9ca3af;
        }

        .info-value {
            color: var(--light-text);
            font-weight: 500;
        }

        .dao-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .members-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #9ca3af;
        }

        .members-info i {
            color: var(--primary-light);
        }

        .view-dao-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: var(--border-radius);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .view-dao-btn:hover {
            opacity: 0.9;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 40px;
        }

        .page-btn {
            min-width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--card-bg);
            border: none;
            border-radius: var(--border-radius);
            color: var(--light-text);
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
        }

        .page-btn:hover {
            background-color: var(--card-hover);
        }

        .page-btn.active {
            background-color: var(--primary-color);
            font-weight: 600;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Mobile Filter Toggle */
        .mobile-filter-toggle {
            display: none;
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            gap: 8px;
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
            transition: var(--transition);
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
            transition: var(--transition);
        }

        .social-links a:hover {
            color: var(--primary-light);
        }

        .copyright {
            color: #6b7280;
            font-size: 14px;
        }

        /* Loading Animation */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .loading::after {
            content: "";
            width: 40px;
            height: 40px;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary-light);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* No results state */
        .no-results {
            text-align: center;
            padding: 60px 0;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
        }

        .no-results h3 {
            font-size: 20px;
            margin-bottom: 12px;
        }

        .no-results p {
            color: #9ca3af;
            margin-bottom: 24px;
        }

        .create-dao-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            gap: 8px;
        }

        .create-dao-btn:hover {
            background-color: var(--primary-dark);
        }

        /* Media Queries */
        @media (max-width: 992px) {
            .explore-layout {
                grid-template-columns: 240px 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .mobile-filter-toggle {
                display: flex;
            }

            .explore-layout {
                grid-template-columns: 1fr;
            }

            .filters-sidebar {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1000;
                width: 100%;
                height: 100%;
                overflow-y: auto;
                border-radius: 0;
                padding-top: 60px;
            }

            .filters-sidebar.show {
                display: block;
            }

            .close-filters {
                position: absolute;
                top: 20px;
                right: 20px;
                background: transparent;
                border: none;
                color: var(--light-text);
                font-size: 20px;
                cursor: pointer;
            }

            .page-title {
                font-size: 28px;
            }

            .search-sort-container {
                flex-direction: column;
            }

            .dao-list {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .dao-list {
                grid-template-columns: 1fr;
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
                    <div class="wallet-address" id="walletAddress">0x7F4e...3A9b</div>
                    <button class="disconnect-btn" id="disconnectBtn" title="Disconnect wallet">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
    </main>

   
        </div>
            </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <div class="page-header">
            <h1 class="page-title">Explore DAOs</h1>
            <p class="page-description">
                Discover and join decentralized autonomous organizations across the Solana ecosystem. 
                Connect with like-minded communities, participate in governance, and help shape the future of Web3.
            </p>
        </div>

        <!-- Mobile Filter Toggle Button -->
        <button class="mobile-filter-toggle" id="mobileFilterToggle">
            <i class="fas fa-filter"></i> Show Filters
        </button>

        <div class="explore-layout">
            <!-- Filters Sidebar -->
            <div class="filters-sidebar" id="filtersSidebar">
                <button class="close-filters" id="closeFilters">
                    <i class="fas fa-times"></i>
                </button>
                <div class="filters-title">
                    <span>Filters</span>
                    <button class="reset-filters" id="resetFilters">Reset All</button>
                </div>

                <!-- Governance Model Filter -->
                <div class="filter-section">
                    <h3 class="filter-section-title">Governance Model</h3>
                    <div class="filter-options">
                        <div class="checkbox-option">
                            <input type="checkbox" id="governance-token" name="governance" value="token">
                            <label for="governance-token">Token-Based (1 Token = 1 Vote)</label>
                        </div>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="page-btn disabled">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <button class="page-btn">5</button>
                    <button class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <!-- No Results State (Hidden by Default) -->
                <div class="no-results" id="noResults" style="display: none;">
                    <h3>No DAOs Found</h3>
                    <p>We couldn't find any DAOs matching your search criteria.</p>
                    <a href="onboarding.php" class="create-dao-btn">
                        <i class="fas fa-plus"></i> Create Your Own DAO
                    </a>
                </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="governance-quadratic" name="governance" value="quadratic">
                            <label for="governance-quadratic">Quadratic Voting</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="governance-multisig" name="governance" value="multisig">
                            <label for="governance-multisig">Multisig</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="governance-reputation" name="governance" value="reputation">
                            <label for="governance-reputation">Reputation-Based</label>
                        </div>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="filter-section">
                    <h3 class="filter-section-title">Category</h3>
                    <div class="filter-options">
                        <div class="checkbox-option">
                            <input type="checkbox" id="category-defi" name="category" value="defi">
                            <label for="category-defi">DeFi</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="category-nft" name="category" value="nft">
                            <label for="category-nft">NFT & Art</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="category-social" name="category" value="social">
                            <label for="category-social">Social Impact</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="category-gaming" name="category" value="gaming">
                            <label for="category-gaming">Gaming</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="category-infra" name="category" value="infra">
                            <label for="category-infra">Infrastructure</label>
                        </div>
                    </div>
                </div>

                <!-- Voting Period Filter -->
                <div class="filter-section">
                    <h3 class="filter-section-title">Voting Period</h3>
                    <div class="filter-options">
                        <div class="radio-option">
                            <input type="radio" id="period-any" name="period" value="any" checked>
                            <label for="period-any">Any</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="period-short" name="period" value="short">
                            <label for="period-short">Short (< 3 days)</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="period-medium" name="period" value="medium">
                            <label for="period-medium">Medium (3-7 days)</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="period-long" name="period" value="long">
                            <label for="period-long">Long (> 7 days)</label>
                        </div>
                    </div>
                </div>

                <!-- Quorum Filter -->
                <div class="filter-section">
                    <h3 class="filter-section-title">Minimum Quorum</h3>
                    <div class="filter-options">
                        <input type="range" id="quorum-slider" class="range-slider" min="0" max="100" value="0" step="10">
                        <div class="range-labels">
                            <span>0%</span>
                            <span id="quorum-value">0%</span>
                            <span>100%</span>
                        </div>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="filter-section">
                    <h3 class="filter-section-title">Status</h3>
                    <div class="filter-options">
                        <div class="checkbox-option">
                            <input type="checkbox" id="status-active" name="status" value="active" checked>
                            <label for="status-active">Active</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="status-trending" name="status" value="trending">
                            <label for="status-trending">Trending</label>
                        </div>
                        <div class="checkbox-option">
                            <input type="checkbox" id="status-new" name="status" value="new">
                            <label for="status-new">New (< 30 days)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Search and Sort Bar -->
                <div class="search-sort-container">
                    <div class="search-container">
                        <input type="text" class="search-input" id="searchInput" placeholder="Search for DAOs...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    <div class="sort-container">
                        <select class="sort-select" id="sortSelect">
                            <option value="popular">Most Popular</option>
                            <option value="recent">Recently Added</option>
                            <option value="members">Most Members</option>
                            <option value="activity">Most Active</option>
                        </select>
                    </div>
                </div>

                <!-- DAO List -->
                <div class="dao-list" id="daoList">
                    <!-- DAO Card 1 -->
                    <div class="dao-card">
                        <div class="dao-card-banner"></div>
                        <div class="dao-logo">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="dao-badges">
                            <span class="dao-badge badge-trending">Trending</span>
                        </div>
                        <div class="dao-card-content">
                            <h3 class="dao-name">EcoFund DAO</h3>
                            <p class="dao-description">
                                Community-driven funding for ecological sustainability projects and initiatives around the globe.
                            </p>
                            <div class="dao-info">
                                <div class="info-item">
                                    <span class="info-label">Governance Model</span>
                                    <span class="info-value">1 Token = 1 Vote</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Voting Period</span>
                                    <span class="info-value">5 days</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Min. Quorum</span>
                                    <span class="info-value">25%</span>
                                </div>
                            </div>
                            <div class="dao-footer">
                                <div class="members-info">
                                    <i class="fas fa-users"></i>
                                    <span>5,781 members</span>
                                    <span>3,245 members</span>
                                </div>
                                <a href="dao.php?id=dao123" class="view-dao-btn">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- DAO Card 2 -->
                    <div class="dao-card">
                        <div class="dao-card-banner" style="background: linear-gradient(45deg, #1e40af, #3b82f6);"></div>
                        <div class="dao-logo">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="dao-badges">
                            <span class="dao-badge badge-popular">Popular</span>
                        </div>
                        <div class="dao-card-content">
                            <h3 class="dao-name">DeFi Governance</h3>
                            <p class="dao-description">
                                Decentralized decision making for protocol upgrades and treasury management across DeFi apps.
                            </p>
                            <div class="dao-info">
                                <div class="info-item">
                                    <span class="info-label">Governance Model</span>
                                    <span class="info-value">Quadratic Voting</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Voting Period</span>
                                    <span class="info-value">7 days</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Min. Quorum</span>
                                    <span class="info-value">40%</span>
                                </div>
                            </div>
                            <div class="dao-footer">
                                <div class="members-info">
                                    <i class="fas fa-users"></i>
                                    <span>5,781 members</span>
                                </div>
                                <a href="dao.php?id=dao456" class="view-dao-btn">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- DAO Card 3 -->
                    <div class="dao-card">
                        <div class="dao-card-banner" style="background: linear-gradient(45deg, #7e22ce, #c084fc);"></div>
                        <div class="dao-logo">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="dao-badges">
                            <span class="dao-badge badge-new">New</span>
                        </div>
                        <div class="dao-card-content">
                            <h3 class="dao-name">ArtBlock Collective</h3>
                            <p class="dao-description">
                                Supporting digital artists and creators through collaborative curation and funding for innovative projects.
                            </p>
                            <div class="dao-info">
                                <div class="info-item">
                                    <span class="info-label">Governance Model</span>
                                    <span class="info-value">Multisig</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Voting Period</span>
                                    <span class="info-value">3 days</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Min. Quorum</span>
                                    <span class="info-value">60%</span>
                                </div>
                            </div>
                            <div class="dao-footer">
                                <div class="members-info">
                                    <i class="fas fa-users"></i>
                                    <span>925 members</span>
                                </div>
                                <a href="dao.php?id=dao789" class="view-dao-btn">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- DAO Card 4 -->
                    <div class="dao-card">
                        <div class="dao-card-banner" style="background: linear-gradient(45deg, #b91c1c, #f87171);"></div>
                        <div class="dao-logo">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div class="dao-badges">
                            <span class="dao-badge badge-trending">Trending</span>
                            <span class="dao-badge badge-new">New</span>
                        </div>
                        <div class="dao-card-content">
                            <h3 class="dao-name">GameFi Alliance</h3>
                            <p class="dao-description">
                                A collaborative DAO focused on developing and funding innovative blockchain gaming experiences.
                            </p>
                            <div class="dao-info">
                                <div class="info-item">
                                    <span class="info-label">Governance Model</span>
                                    <span class="info-value">Reputation-Based</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Voting Period</span>
                                    <span class="info-value">4 days</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Min. Quorum</span>
                                    <span class="info-value">30%</span>
                                </div>
                            </div>
                            <div class="dao-footer">
                                <div class="members-info">
                                    <i class="fas fa-users"></i>
                                    <span>1,456 members</span>
                                </div>
                                <a href="dao.php?id=dao101" class="view-dao-btn">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- DAO Card 5 -->
                    <div class="dao-card">
                        <div class="dao-card-banner" style="background: linear-gradient(45deg, #0e7490, #22d3ee);"></div>
                        <div class="dao-logo">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="dao-card-content">
                            <h3 class="dao-name">Sol Infrastructure</h3>
                            <p class="dao-description">
                                Building and maintaining critical web3 infrastructure services to support the Solana ecosystem.
                            </p>
                            <div class="dao-info">
                                <div class="info-item">
                                    <span class="info-label">Governance Model</span>
                                    <span class="info-value">1 Token = 1 Vote</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Voting Period</span>
                                    <span class="info-value">14 days</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Min. Quorum</span>
                                    <span class="info-value">50%</span>
                                </div>
                            </div>
                            <div class="dao-footer">
                                <div class="members-info">
                                    <i class="fas fa-users"></i>
                                    <span>2,734 members</span>
                                </div>
                                <a href="dao.php?id=dao202" class="view-dao-btn">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- DAO Card 6 -->
                    <div class="dao-card">
                        <div class="dao-card-banner" style="background: linear-gradient(45deg, #166534, #4ade80);"></div>
                        <div class="dao-logo">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="dao-badges">
                            <span class="dao-badge badge-popular">Popular</span>
                        </div>
                        <div class="dao-card-content">
                            <h3 class="dao-name">Community Fund</h3>
                            <p class="dao-description">
                                A community-driven grant program funding education and outreach initiatives in emerging markets.
                            </p>
                            <div class="dao-info">
                                <div class="info-item">
                                    <span class="info-label">Governance Model</span>
                                    <span class="info-value">Quadratic Voting</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Voting Period</span>
                                    <span class="info-value">10 days</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Min. Quorum</span>
                                    <span class="info-value">35%</span>
                                </div>
                            </div>
                            <div class="dao-footer">
                                <div class="members-info">
                                    <i class="fas fa-users"></i>
                                    <span>4,217 members</span>
                                </div>
                                <a href="dao.php?id=dao303" class="view-dao-btn">
                                    View <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                
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
            // Mobile filters toggle
            const mobileFilterToggle = document.getElementById('mobileFilterToggle');
            const filtersSidebar = document.getElementById('filtersSidebar');
            const closeFilters = document.getElementById('closeFilters');
            
            if (mobileFilterToggle) {
                mobileFilterToggle.addEventListener('click', function() {
                    filtersSidebar.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            if (closeFilters) {
                closeFilters.addEventListener('click', function() {
                    filtersSidebar.classList.remove('show');
                    document.body.style.overflow = '';
                });
            }
            
            // Quorum slider
            const quorumSlider = document.getElementById('quorum-slider');
            const quorumValue = document.getElementById('quorum-value');
            
            if (quorumSlider && quorumValue) {
                quorumSlider.addEventListener('input', function() {
                    quorumValue.textContent = this.value + '%';
                });
            }
            
            // Reset filters button
            const resetFilters = document.getElementById('resetFilters');
            
            if (resetFilters) {
                resetFilters.addEventListener('click', function() {
                    // Reset checkboxes
                    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    // Reset radio buttons to default
                    document.getElementById('period-any').checked = true;
                    
                    // Reset quorum slider
                    quorumSlider.value = 0;
                    quorumValue.textContent = '0%';
                    
                    // Reset active status checkbox
                    document.getElementById('status-active').checked = true;
                });
            }
            
            // Disconnect wallet functionality
            const disconnectBtn = document.getElementById('disconnectBtn');
            
            if (disconnectBtn) {
                disconnectBtn.addEventListener('click', function() {
                    // Simulate disconnecting wallet
                    window.location.href = 'index.php';
                });
            }
            
            // Search functionality (simulated)
            const searchInput = document.getElementById('searchInput');
            
            if (searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    // Demo for UI testing, not actual filtering
                    if (e.key === 'Enter') {
                        const searchTerm = searchInput.value.toLowerCase().trim();
                        const daoCards = document.querySelectorAll('.dao-card');
                        let foundMatch = false;
                        
                        daoCards.forEach(card => {
                            const daoName = card.querySelector('.dao-name').textContent.toLowerCase();
                            const daoDescription = card.querySelector('.dao-description').textContent.toLowerCase();
                            
                            if (searchTerm === '' || daoName.includes(searchTerm) || daoDescription.includes(searchTerm)) {
                                card.style.display = '';
                                foundMatch = true;
                            } else {
                                card.style.display = 'none';
                            }
                        });
                        
                        // Show/hide no results message
                        const noResults = document.getElementById('noResults');
                        const daoList = document.getElementById('daoList');
                        const pagination = document.querySelector('.pagination');
                        
                        if (!foundMatch) {
                            noResults.style.display = 'block';
                            pagination.style.display = 'none';
                        } else {
                            noResults.style.display = 'none';
                            pagination.style.display = 'flex';
                        }
                    }
                });
            }
            
            // Sort functionality (simulated)
            const sortSelect = document.getElementById('sortSelect');
            
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    // This would be implemented with actual sorting logic in a real app
                    console.log('Sort by:', sortSelect.value);
                    
                    // For demo purposes, just show a brief loading state
                    const daoList = document.getElementById('daoList');
                    const currentHTML = daoList.innerHTML;
                    
                    daoList.innerHTML = '<div class="loading"></div>';
                    
                    setTimeout(() => {
                        daoList.innerHTML = currentHTML;
                    }, 500);
                });
            }
            
            // Pagination (simulated)
            const pageButtons = document.querySelectorAll('.page-btn');
            
            pageButtons.forEach(button => {
                if (!button.classList.contains('disabled')) {
                    button.addEventListener('click', function() {
                        // Reset active state
                        pageButtons.forEach(btn => btn.classList.remove('active'));
                        
                        // Set this button as active if it's a number button
                        if (!this.querySelector('i')) {
                            this.classList.add('active');
                        }
                        
                        // For demo purposes, show loading state
                        const daoList = document.getElementById('daoList');
                        const currentHTML = daoList.innerHTML;
                        
                        daoList.innerHTML = '<div class="loading"></div>';
                        
                        setTimeout(() => {
                            daoList.innerHTML = currentHTML;
                        }, 800);
                    });
                }
            });
        });
    </script>