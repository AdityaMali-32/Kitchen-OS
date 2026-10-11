<?php
include '../config/database.php';
session_start();

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Get stats
$total_users = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='user'")->fetch_assoc()['c'];
$total_items = $conn->query("SELECT COUNT(*) as c FROM items")->fetch_assoc()['c'];
$total_suppliers = $conn->query("SELECT COUNT(*) as c FROM suppliers")->fetch_assoc()['c'];
$total_categories = $conn->query("SELECT COUNT(*) as c FROM categories")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kitchen Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-utensils"></i> Admin Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="page-header">
            <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
            <span class="badge bg-primary">Admin</span>
        </div>

        <!-- Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card stat-card info">
                    <div class="stat-number"><?php echo $total_users; ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="stat-number"><?php echo $total_items; ?></div>
                    <div class="stat-label">Total Items</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card success">
                    <div class="stat-number"><?php echo $total_suppliers; ?></div>
                    <div class="stat-label">Suppliers</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card warning">
                    <div class="stat-number"><?php echo $total_categories; ?></div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>

        <!-- Management Cards -->
        <h4 class="fw-bold mb-3">Manage</h4>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="users.php" class="text-decoration-none">
                    <div class="admin-card">
                        <i class="fas fa-users"></i>
                        <h5>Users</h5>
                        <p class="text-muted small">Manage all users</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="../inventory.php" class="text-decoration-none">
                    <div class="admin-card">
                        <i class="fas fa-box"></i>
                        <h5>Inventory</h5>
                        <p class="text-muted small">View all items</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="categories.php" class="text-decoration-none">
                    <div class="admin-card">
                        <i class="fas fa-tags"></i>
                        <h5>Categories</h5>
                        <p class="text-muted small">Manage categories</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="../suppliers.php" class="text-decoration-none">
                    <div class="admin-card">
                        <i class="fas fa-truck"></i>
                        <h5>Suppliers</h5>
                        <p class="text-muted small">Manage suppliers</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="reports.php" class="text-decoration-none">
                    <div class="admin-card">
                        <i class="fas fa-chart-bar"></i>
                        <h5>Reports</h5>
                        <p class="text-muted small">View reports</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0 small">🍳 Kitchen Inventory Management — Admin Panel | © <?php echo date('Y'); ?> Aditya</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
