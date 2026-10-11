<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitchenOS — Smart Kitchen & Pantry Inventory Management</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="brand-icon-wrapper">
                    <i class="fas fa-kitchen-set"></i>
                </span>
                <span>Kitchen<span class="highlight">OS</span></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                                <i class="fas fa-chart-pie"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'inventory.php' || $current_page == 'add_item.php' || $current_page == 'edit_item.php') ? 'active' : ''; ?>" href="inventory.php">
                                <i class="fas fa-boxes-stacked"></i> Inventory
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'suppliers.php') ? 'active' : ''; ?>" href="suppliers.php">
                                <i class="fas fa-truck-ramp-box"></i> Suppliers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'purchases.php') ? 'active' : ''; ?>" href="purchases.php">
                                <i class="fas fa-receipt"></i> Purchases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'alerts.php') ? 'active' : ''; ?>" href="alerts.php">
                                <i class="fas fa-bell"></i> Alerts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>" href="reports.php">
                                <i class="fas fa-file-invoice"></i> Reports
                            </a>
                        </li>
                        <li class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">
                            <a class="nav-link dropdown-toggle d-inline-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-avatar-badge">
                                    <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
                                </span>
                                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li class="px-3 py-2 text-muted small border-bottom">
                                    <i class="fas fa-shield-alt text-primary"></i> Role: <strong><?php echo ucfirst($_SESSION['role'] ?? 'User'); ?></strong>
                                </li>
                                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-gear"></i> Account Profile</a></li>
                                <li><a class="dropdown-item" href="inventory.php"><i class="fas fa-boxes-stacked"></i> My Pantry Items</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-arrow-right-from-bracket"></i> Sign Out</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">
                                <i class="fas fa-house"></i> Home
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>" href="login.php">
                                <i class="fas fa-arrow-right-to-bracket"></i> Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-primary btn-sm px-3 text-white" href="register.php">
                                <i class="fas fa-user-plus"></i> Get Started
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
