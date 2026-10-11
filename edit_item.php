<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';

// Get item ID
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch item
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
$stmt->bind_param('ii', $item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['message'] = 'Item not found.';
    $_SESSION['msg_type'] = 'danger';
    header('Location: inventory.php');
    exit();
}

$item = $result->fetch_assoc();
$stmt->close();

// Get categories
$categories = $conn->query("SELECT * FROM categories ORDER BY name");

// Get suppliers
$suppliers = $conn->query("SELECT * FROM suppliers ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
    $quantity = floatval($_POST['quantity']);
    $unit = $_POST['unit'];
    $purchase_date = !empty($_POST['purchase_date']) ? $_POST['purchase_date'] : null;
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
    $supplier_id = !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null;
    $storage_location = trim($_POST['storage_location']);
    $min_stock = !empty($_POST['min_stock']) ? floatval($_POST['min_stock']) : 5;

    if (empty($name) || $quantity <= 0) {
        $error = 'Please enter item name and valid quantity.';
    } else {
        $stmt = $conn->prepare("UPDATE items SET name=?, category_id=?, quantity=?, unit=?, purchase_date=?, expiry_date=?, supplier_id=?, storage_location=?, min_stock=? WHERE id=? AND user_id=?");
        $stmt->bind_param('sidsssisdii', $name, $category_id, $quantity, $unit, $purchase_date, $expiry_date, $supplier_id, $storage_location, $min_stock, $item_id, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = 'Item updated successfully!';
            $_SESSION['msg_type'] = 'success';
            header('Location: inventory.php');
            exit();
        } else {
            $error = 'Failed to update item.';
        }
        $stmt->close();
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="page-header">
        <h2><i class="fas fa-edit"></i> Edit Item</h2>
        <a href="inventory.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Back to Inventory</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                <?php while ($cat = $categories->fetch_assoc()): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $item['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" step="0.01" min="0.01" value="<?php echo $item['quantity']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit</label>
                            <select name="unit" class="form-select">
                                <option value="Kg" <?php echo ($item['unit']=='Kg') ? 'selected' : ''; ?>>Kg</option>
                                <option value="L" <?php echo ($item['unit']=='L') ? 'selected' : ''; ?>>L (Liters)</option>
                                <option value="Pieces" <?php echo ($item['unit']=='Pieces') ? 'selected' : ''; ?>>Pieces</option>
                                <option value="Grams" <?php echo ($item['unit']=='Grams') ? 'selected' : ''; ?>>Grams</option>
                                <option value="ml" <?php echo ($item['unit']=='ml') ? 'selected' : ''; ?>>ml</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Min Stock Alert</label>
                            <input type="number" name="min_stock" class="form-control" step="0.01" value="<?php echo $item['min_stock']; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Date</label>
                            <input type="date" name="purchase_date" class="form-control" value="<?php echo $item['purchase_date']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control" value="<?php echo $item['expiry_date']; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supplier</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">Select Supplier</option>
                                <?php while ($sup = $suppliers->fetch_assoc()): ?>
                                    <option value="<?php echo $sup['id']; ?>" <?php echo ($sup['id'] == $item['supplier_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($sup['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Storage Location</label>
                            <input type="text" name="storage_location" class="form-control" value="<?php echo htmlspecialchars($item['storage_location']); ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fas fa-save"></i> Update Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
