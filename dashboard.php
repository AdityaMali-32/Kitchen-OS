<?php
include 'config/database.php';
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get total items
$result = $conn->query("SELECT COUNT(*) as total FROM items WHERE user_id = $user_id");
$total_items = $result->fetch_assoc()['total'];

// Get low stock items (quantity <= min_stock)
$result = $conn->query("SELECT COUNT(*) as total FROM items WHERE user_id = $user_id AND quantity <= min_stock");
$low_stock_count = $result->fetch_assoc()['total'];

// Get expiring soon items (within 7 days)
$result = $conn->query("SELECT COUNT(*) as total FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND expiry_date >= CURDATE()");
$expiring_count = $result->fetch_assoc()['total'];

// Get expired items
$result = $conn->query("SELECT COUNT(*) as total FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date < CURDATE()");
$expired_count = $result->fetch_assoc()['total'];

// Get low stock items list
$low_stock_items = $conn->query("SELECT id, name, quantity, unit, min_stock FROM items WHERE user_id = $user_id AND quantity <= min_stock ORDER BY quantity ASC LIMIT 5");

// Get expiring soon items list
$expiring_items = $conn->query("SELECT id, name, expiry_date, quantity, unit FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND expiry_date >= CURDATE() ORDER BY expiry_date ASC LIMIT 5");
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <!-- Welcome Header Banner -->
    <div class="dashboard-welcome-banner">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark px-3 py-1 mb-2 fw-bold">
                    <i class="fas fa-utensils"></i> Kitchen Command Center
                </span>
                <h2 class="text-white fw-bold mb-2">
                    Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!
                </h2>
                <p class="text-light opacity-75 mb-0" style="max-width: 550px;">
                    Your pantry status overview: <strong><?php echo $total_items; ?></strong> total items tracked. 
                    <?php if ($low_stock_count > 0 || $expiring_count > 0): ?>
                        <span class="text-warning fw-semibold">Attention needed: <?php echo ($low_stock_count + $expiring_count); ?> items require restocking or consumption soon.</span>
                    <?php else: ?>
                        <span class="text-success fw-semibold">All kitchen stock is fresh and in optimal quantities!</span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-inline-flex flex-column align-items-lg-end">
                    <span class="badge bg-dark border border-secondary text-light px-3 py-2 mb-2">
                        <i class="far fa-calendar-check me-1"></i> <?php echo date('l, d M Y'); ?>
                    </span>
                    <a href="inventory.php" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-boxes-stacked"></i> Manage Inventory
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Items -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number"><?php echo $total_items; ?></div>
                        <div class="stat-label">Total Inventory Items</div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: rgba(249, 115, 22, 0.12); color: var(--primary);">
                        <i class="fas fa-box-archive"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small">In stock & cataloged</span>
                    <a href="inventory.php" class="text-primary small fw-semibold">View all <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number text-warning"><?php echo $low_stock_count; ?></div>
                        <div class="stat-label">Low Stock Alerts</div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: var(--warning);">
                        <i class="fas fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Below min threshold</span>
                    <a href="alerts.php" class="text-warning small fw-semibold">Review alerts <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Expiring Soon -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card danger">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number" style="color: #ea580c;"><?php echo $expiring_count; ?></div>
                        <div class="stat-label">Expiring within 7 Days</div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: rgba(234, 88, 12, 0.12); color: #ea580c;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Consume soon</span>
                    <a href="alerts.php" class="text-danger small fw-semibold">Inspect <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Expired Items -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="border-left-color: #ef4444;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number text-danger"><?php echo $expired_count; ?></div>
                        <div class="stat-label">Expired Items</div>
                    </div>
                    <div class="stat-icon-wrapper" style="background: rgba(239, 68, 68, 0.12); color: var(--danger);">
                        <i class="fas fa-circle-xmark"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Needs disposal</span>
                    <a href="alerts.php" class="text-danger small fw-semibold">Take action <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Cards -->
    <div class="mb-4">
        <h5 class="fw-bold mb-3"><i class="fas fa-bolt text-warning me-2"></i>Quick Kitchen Operations</h5>
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <a href="add_item.php" class="quick-action-btn h-100">
                    <i class="fas fa-circle-plus"></i>
                    <span>Add New Item</span>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="inventory.php" class="quick-action-btn h-100">
                    <i class="fas fa-boxes-stacked"></i>
                    <span>Pantry Deck</span>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="suppliers.php" class="quick-action-btn h-100">
                    <i class="fas fa-truck-ramp-box"></i>
                    <span>Suppliers Directory</span>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="reports.php" class="quick-action-btn h-100">
                    <i class="fas fa-file-invoice"></i>
                    <span>Inventory Reports</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Visual Kitchen Tips Banner Featuring Picture Assets -->
    <div class="card p-3 p-md-4 mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);">
        <div class="row align-items-center g-3">
            <div class="col-md-3 d-none d-md-block">
                <div class="rounded-3 overflow-hidden shadow-sm" style="height: 120px;">
                    <img src="images/organized-pantry.jpg" alt="Pantry organization" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-warning text-dark"><i class="fas fa-lightbulb"></i> Chef Pro Tip</span>
                    <strong class="text-dark">Airtight Storage & FIFO Rotation</strong>
                </div>
                <p class="small text-muted mb-0">
                    Organize your flour, pulses, and dry spices in labeled airtight containers. Place newest groceries at the back and older ones in front (First In, First Out) to keep zero waste!
                </p>
            </div>
            <div class="col-md-3 text-md-end">
                <a href="inventory.php" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-eye"></i> View Card Deck
                </a>
            </div>
        </div>
    </div>

    <!-- Two-Column Priority Action Tables -->
    <div class="row g-4">
        <!-- Low Stock Items Table -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="fas fa-triangle-exclamation text-warning me-2"></i> Low Stock Items
                    </h6>
                    <a href="alerts.php" class="small text-primary fw-semibold">View All Alerts</a>
                </div>
                <div class="card-body p-0">
                    <?php if ($low_stock_items && $low_stock_items->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Current Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($item = $low_stock_items->fetch_assoc()): ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td>
                                                <span class="badge-low-stock">
                                                    <?php echo $item['quantity'] . ' ' . htmlspecialchars($item['unit']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-primary btn-sm py-1 px-2" title="Restock / Edit">
                                                    <i class="fas fa-plus"></i> Restock
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-check-circle text-success fs-3 mb-2 d-block"></i>
                            <p class="small mb-0">All items are sufficiently stocked above minimum levels!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Expiring Soon Items Table -->
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="fas fa-clock text-danger me-2"></i> Expiring Soon (Within 7 Days)
                    </h6>
                    <a href="alerts.php" class="small text-danger fw-semibold">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php if ($expiring_items && $expiring_items->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Stock</th>
                                        <th>Expiry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($item = $expiring_items->fetch_assoc()): ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td><?php echo $item['quantity'] . ' ' . htmlspecialchars($item['unit']); ?></td>
                                            <td>
                                                <span class="badge-expiring">
                                                    <i class="fas fa-hourglass-start me-1"></i>
                                                    <?php echo date('d/m/Y', strtotime($item['expiry_date'])); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-shield-check text-success fs-3 mb-2 d-block"></i>
                            <p class="small mb-0">No perishable items expiring within the next 7 days!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
