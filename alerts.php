<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Low stock items
$low_stock = $conn->query("SELECT id, name, quantity, unit, min_stock FROM items WHERE user_id = $user_id AND quantity <= min_stock ORDER BY quantity ASC");

// Expiring soon (within 7 days)
$expiring = $conn->query("SELECT id, name, expiry_date, quantity, unit FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND expiry_date >= CURDATE() ORDER BY expiry_date ASC");

// Expired items
$expired = $conn->query("SELECT id, name, expiry_date, quantity, unit FROM items WHERE user_id = $user_id AND expiry_date IS NOT NULL AND expiry_date < CURDATE() ORDER BY expiry_date ASC");

$total_warnings = ($expired ? $expired->num_rows : 0) + ($expiring ? $expiring->num_rows : 0) + ($low_stock ? $low_stock->num_rows : 0);
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="page-header">
        <div>
            <h2><i class="fas fa-bell text-warning"></i> Expiry & Stock Radar</h2>
            <p class="text-muted small mb-0 mt-1">Real-time alerts to prevent food spoilage and avoid stock shortages.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge <?php echo $total_warnings > 0 ? 'bg-danger' : 'bg-success'; ?> px-3 py-2 fs-6">
                <i class="fas <?php echo $total_warnings > 0 ? 'fa-triangle-exclamation' : 'fa-check'; ?> me-1"></i>
                <?php echo $total_warnings; ?> Active Attention Needed
            </span>
            <a href="inventory.php" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-boxes-stacked"></i> All Inventory
            </a>
        </div>
    </div>

    <!-- Expired Items Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-danger text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-ban me-2"></i> Expired Items (Immediate Action)</h5>
            <span class="badge bg-white text-danger fw-bold"><?php echo $expired ? $expired->num_rows : 0; ?> Items</span>
        </div>
        <div class="card-body p-3">
            <?php if ($expired && $expired->num_rows > 0): ?>
                <?php while ($item = $expired->fetch_assoc()): ?>
                    <div class="alert-box expired d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fs-4 text-danger"><i class="fas fa-circle-exclamation"></i></span>
                            <div>
                                <strong class="fs-6"><?php echo htmlspecialchars($item['name']); ?></strong>
                                <div class="small text-danger opacity-75">
                                    Remaining: <?php echo $item['quantity'] . ' ' . htmlspecialchars($item['unit']); ?> • Expired on <?php echo date('d M Y', strtotime($item['expiry_date'])); ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm delete-btn">
                                <i class="fas fa-trash"></i> Discard
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="p-3 text-center text-success">
                    <i class="fas fa-circle-check fs-2 mb-2 d-block"></i>
                    <strong>Clean Pantry!</strong> No expired items found in your kitchen.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Expiring Soon Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header py-3 d-flex justify-content-between align-items-center text-white" style="background: #ea580c;">
            <h5 class="mb-0 fw-bold"><i class="fas fa-hourglass-half me-2"></i> Expiring Soon (Within Next 7 Days)</h5>
            <span class="badge bg-white text-dark fw-bold"><?php echo $expiring ? $expiring->num_rows : 0; ?> Items</span>
        </div>
        <div class="card-body p-3">
            <?php if ($expiring && $expiring->num_rows > 0): ?>
                <?php while ($item = $expiring->fetch_assoc()): ?>
                    <?php
                    $days = ceil((strtotime($item['expiry_date']) - time()) / 86400);
                    $urgencyText = $days <= 1 ? "Expires Tomorrow!" : "Expires in {$days} days";
                    ?>
                    <div class="alert-box expiring d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fs-4" style="color: #ea580c;"><i class="fas fa-clock"></i></span>
                            <div>
                                <strong class="fs-6"><?php echo htmlspecialchars($item['name']); ?></strong>
                                <div class="small" style="color: #c2410c;">
                                    <?php echo $item['quantity'] . ' ' . htmlspecialchars($item['unit']); ?> • Expiry Date: <?php echo date('d M Y', strtotime($item['expiry_date'])); ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="badge bg-warning text-dark px-3 py-2 fw-bold">
                                <?php echo $urgencyText; ?>
                            </span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="p-3 text-center text-success">
                    <i class="fas fa-shield-heart fs-2 mb-2 d-block"></i>
                    <strong>Fresh & Safe!</strong> No items approaching expiry in the next 7 days.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Low Stock Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-triangle-exclamation me-2"></i> Low Stock Threshold Alerts</h5>
            <span class="badge bg-dark text-white fw-bold"><?php echo $low_stock ? $low_stock->num_rows : 0; ?> Items</span>
        </div>
        <div class="card-body p-3">
            <?php if ($low_stock && $low_stock->num_rows > 0): ?>
                <?php while ($item = $low_stock->fetch_assoc()): ?>
                    <div class="alert-box low-stock d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fs-4 text-warning"><i class="fas fa-box-open"></i></span>
                            <div>
                                <strong class="fs-6"><?php echo htmlspecialchars($item['name']); ?></strong>
                                <div class="small text-muted">
                                    Current: <strong><?php echo $item['quantity'] . ' ' . htmlspecialchars($item['unit']); ?></strong> (Min threshold: <?php echo $item['min_stock'] . ' ' . htmlspecialchars($item['unit']); ?>)
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-warning btn-sm text-dark fw-bold">
                                <i class="fas fa-cart-plus"></i> Restock Item
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="p-3 text-center text-success">
                    <i class="fas fa-boxes-packing fs-2 mb-2 d-block"></i>
                    <strong>Stocked Up!</strong> All kitchen items are above minimum inventory levels.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
