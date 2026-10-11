<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get counts for report cards
$total_items = $conn->query("SELECT COUNT(*) as c FROM items WHERE user_id = $user_id")->fetch_assoc()['c'];
$low_stock_count = $conn->query("SELECT COUNT(*) as c FROM items WHERE user_id = $user_id AND quantity <= min_stock")->fetch_assoc()['c'];
$expired_count = $conn->query("SELECT COUNT(*) as c FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date < CURDATE()")->fetch_assoc()['c'];
$purchase_count = $conn->query("SELECT COUNT(*) as c FROM purchases WHERE user_id = $user_id")->fetch_assoc()['c'];
$supplier_count = $conn->query("SELECT COUNT(*) as c FROM suppliers")->fetch_assoc()['c'];

// Determine which report to show
$report = isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="page-header">
        <h2><i class="fas fa-chart-bar"></i> Reports</h2>
        <?php if ($report): ?>
            <a href="reports.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Back to Reports</a>
        <?php else: ?>
            <button class="btn btn-outline-primary" onclick="printReport()"><i class="fas fa-print"></i> Print Report</button>
        <?php endif; ?>
    </div>

    <?php if (empty($report)): ?>
    <!-- Report Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <a href="reports.php?type=inventory" class="text-decoration-none">
                <div class="report-card">
                    <i class="fas fa-box"></i>
                    <h5>Total Inventory</h5>
                    <p class="text-muted"><?php echo $total_items; ?> Items</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="reports.php?type=lowstock" class="text-decoration-none">
                <div class="report-card">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h5>Low Stock Report</h5>
                    <p class="text-muted"><?php echo $low_stock_count; ?> Items</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="reports.php?type=expired" class="text-decoration-none">
                <div class="report-card">
                    <i class="fas fa-calendar-times"></i>
                    <h5>Expired Items</h5>
                    <p class="text-muted"><?php echo $expired_count; ?> Items</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="purchases.php" class="text-decoration-none">
                <div class="report-card">
                    <i class="fas fa-shopping-cart"></i>
                    <h5>Purchase History</h5>
                    <p class="text-muted"><?php echo $purchase_count; ?> Records</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="suppliers.php" class="text-decoration-none">
                <div class="report-card">
                    <i class="fas fa-truck"></i>
                    <h5>Suppliers</h5>
                    <p class="text-muted"><?php echo $supplier_count; ?> Suppliers</p>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($report == 'inventory'): ?>
    <!-- Full Inventory Report -->
    <h4 class="mb-3">📦 Full Inventory Report</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>#</th><th>Item</th><th>Category</th><th>Quantity</th><th>Expiry Date</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php
                $items = $conn->query("SELECT i.*, c.name as cat_name FROM items i LEFT JOIN categories c ON i.category_id = c.id WHERE i.user_id = $user_id ORDER BY i.name");
                $n = 1;
                while ($item = $items->fetch_assoc()):
                    $status = 'Available';
                    if ($item['expiry_date'] && strtotime($item['expiry_date']) < time()) $status = 'Expired';
                    elseif ($item['quantity'] <= $item['min_stock']) $status = 'Low Stock';
                ?>
                <tr>
                    <td><?php echo $n++; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['cat_name'] ?? 'N/A'); ?></td>
                    <td><?php echo $item['quantity'] . ' ' . $item['unit']; ?></td>
                    <td><?php echo $item['expiry_date'] ? date('d/m/Y', strtotime($item['expiry_date'])) : 'N/A'; ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($report == 'lowstock'): ?>
    <h4 class="mb-3">⚠️ Low Stock Report</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>#</th><th>Item</th><th>Current Qty</th><th>Min Stock</th><th>Shortage</th></tr>
            </thead>
            <tbody>
                <?php
                $items = $conn->query("SELECT * FROM items WHERE user_id = $user_id AND quantity <= min_stock ORDER BY quantity ASC");
                $n = 1;
                while ($item = $items->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $n++; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['quantity'] . ' ' . $item['unit']; ?></td>
                    <td><?php echo $item['min_stock'] . ' ' . $item['unit']; ?></td>
                    <td class="text-danger"><?php echo ($item['min_stock'] - $item['quantity']) . ' ' . $item['unit']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($report == 'expired'): ?>
    <h4 class="mb-3">🔴 Expired Items Report</h4>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>#</th><th>Item</th><th>Expiry Date</th><th>Days Since Expired</th></tr>
            </thead>
            <tbody>
                <?php
                $items = $conn->query("SELECT * FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date < CURDATE() ORDER BY expiry_date ASC");
                $n = 1;
                while ($item = $items->fetch_assoc()):
                    $days = floor((time() - strtotime($item['expiry_date'])) / 86400);
                ?>
                <tr>
                    <td><?php echo $n++; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($item['expiry_date'])); ?></td>
                    <td class="text-danger"><?php echo $days; ?> days ago</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
