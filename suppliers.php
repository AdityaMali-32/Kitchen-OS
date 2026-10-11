<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle Add Supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);

        if (!empty($name)) {
            $stmt = $conn->prepare("INSERT INTO suppliers (name, phone, email, address) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $name, $phone, $email, $address);
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Supplier added successfully!';
                $_SESSION['msg_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to add supplier.';
                $_SESSION['msg_type'] = 'danger';
            }
            $stmt->close();
        }
        header('Location: suppliers.php');
        exit();
    }

    if ($_POST['action'] == 'edit') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);

        $stmt = $conn->prepare("UPDATE suppliers SET name=?, phone=?, email=?, address=? WHERE id=?");
        $stmt->bind_param('ssssi', $name, $phone, $email, $address, $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Supplier updated successfully!';
            $_SESSION['msg_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to update supplier.';
            $_SESSION['msg_type'] = 'danger';
        }
        $stmt->close();
        header('Location: suppliers.php');
        exit();
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM suppliers WHERE id = $id");
    $_SESSION['message'] = 'Supplier deleted successfully!';
    $_SESSION['msg_type'] = 'success';
    header('Location: suppliers.php');
    exit();
}

// Get all suppliers
$suppliers = $conn->query("SELECT * FROM suppliers ORDER BY name");
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <div class="page-header">
        <h2><i class="fas fa-truck"></i> Suppliers</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
            <i class="fas fa-plus"></i> Add Supplier
        </button>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
    <?php endif; ?>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search suppliers...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Supplier Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($suppliers->num_rows > 0): ?>
                    <?php $count = 1; while ($sup = $suppliers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><strong><?php echo htmlspecialchars($sup['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($sup['phone']); ?></td>
                            <td><?php echo htmlspecialchars($sup['email']); ?></td>
                            <td><?php echo htmlspecialchars($sup['address']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="editSupplier(<?php echo htmlspecialchars(json_encode($sup)); ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="suppliers.php?delete=<?php echo $sup['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-truck" style="font-size:3rem;"></i>
                            <p class="mt-2">No suppliers added yet.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" id="edit_phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editSupplier(supplier) {
    document.getElementById('edit_id').value = supplier.id;
    document.getElementById('edit_name').value = supplier.name;
    document.getElementById('edit_phone').value = supplier.phone;
    document.getElementById('edit_email').value = supplier.email;
    document.getElementById('edit_address').value = supplier.address;
    new bootstrap.Modal(document.getElementById('editSupplierModal')).show();
}
</script>

<?php include 'includes/footer.php'; ?>
