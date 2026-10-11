<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$purchases = $conn->query("
    SELECT p.*, s.name as supplier_name 
    FROM purchases p 
    LEFT JOIN suppliers s ON p.supplier_id = s.id 
    WHERE p.user_id = $user_id 
    ORDER BY p.purchase_date DESC, p.created_at DESC
");
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="page-header">
        <h2><i class="fas fa-shopping-cart"></i> Purchase History</h2>
        <button class="btn btn-outline-primary" onclick="printReport()"><i class="fas fa-print"></i> Print</button>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search purchases...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($purchases->num_rows > 0): ?>
                    <?php $count = 1; while ($p = $purchases->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $p['purchase_date'] ? date('d/m/Y', strtotime($p['purchase_date'])) : 'N/A'; ?></td>
                            <td><strong><?php echo htmlspecialchars($p['item_name']); ?></strong></td>
                            <td><?php echo $p['quantity'] . ' ' . $p['unit']; ?></td>
                            <td><?php echo htmlspecialchars($p['supplier_name'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-shopping-cart" style="font-size:3rem;"></i>
                            <p class="mt-2">No purchase history yet.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
