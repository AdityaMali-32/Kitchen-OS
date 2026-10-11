<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$total_users = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='user'")->fetch_assoc()['c'];
$total_items = $conn->query("SELECT COUNT(*) as c FROM items")->fetch_assoc()['c'];
$total_suppliers = $conn->query("SELECT COUNT(*) as c FROM suppliers")->fetch_assoc()['c'];
$total_purchases = $conn->query("SELECT COUNT(*) as c FROM purchases")->fetch_assoc()['c'];
$low_stock = $conn->query("SELECT COUNT(*) as c FROM items WHERE quantity <= min_stock")->fetch_assoc()['c'];
$expired = $conn->query("SELECT COUNT(*) as c FROM items WHERE expiry_date IS NOT NULL AND expiry_date < CURDATE()")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports - Kitchen Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php"><i class="fas fa-utensils"></i> Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link active" href="reports.php">Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="page-header">
            <h2><i class="fas fa-chart-bar"></i> System Reports</h2>
            <button class="btn btn-outline-primary" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="report-card">
                    <i class="fas fa-users"></i>
                    <h5>Total Users</h5>
                    <h2 class="text-primary"><?php echo $total_users; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card">
                    <i class="fas fa-box"></i>
                    <h5>Total Items</h5>
                    <h2 class="text-primary"><?php echo $total_items; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card">
                    <i class="fas fa-truck"></i>
                    <h5>Total Suppliers</h5>
                    <h2 class="text-primary"><?php echo $total_suppliers; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card">
                    <i class="fas fa-shopping-cart"></i>
                    <h5>Total Purchases</h5>
                    <h2 class="text-primary"><?php echo $total_purchases; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card">
                    <i class="fas fa-exclamation-triangle" style="color: #f39c12;"></i>
                    <h5>Low Stock Items</h5>
                    <h2 class="text-warning"><?php echo $low_stock; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="report-card">
                    <i class="fas fa-calendar-times" style="color: #e74c3c;"></i>
                    <h5>Expired Items</h5>
                    <h2 class="text-danger"><?php echo $expired; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
