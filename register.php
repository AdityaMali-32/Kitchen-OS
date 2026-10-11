<?php
include 'config/database.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Email already registered. Please login.';
        } else {
            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, mobile, password, role) VALUES (?, ?, ?, ?, 'user')");
            $stmt->bind_param('ssss', $name, $email, $mobile, $hashed);

            if ($stmt->execute()) {
                $success = 'Account created successfully! You can now <a href="login.php" class="fw-bold alert-link">Login here</a>.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
        $stmt->close();
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="auth-split-wrapper">
    <div class="auth-split-card">
        <!-- Left Visual Side with Picture (Organized Pantry Shelves) -->
        <div class="auth-visual-side" style="background-image: url('images/organized-pantry.jpg');">
            <div class="auth-visual-content">
                <span class="badge bg-warning text-dark px-3 py-1 mb-3 fw-bold">
                    <i class="fas fa-boxes-stacked"></i> Smart Pantry Tracking
                </span>
                <h3>Keep Every Container & Shelf Synced</h3>
                <p>
                    Create your free account today and say goodbye to expired groceries, duplicated purchases, and missing spices.
                </p>
                <div class="d-flex gap-2 pt-2">
                    <span class="badge bg-dark bg-opacity-75 border border-secondary text-light">✓ 100% Free Setup</span>
                    <span class="badge bg-dark bg-opacity-75 border border-secondary text-light">✓ Dual View Mode</span>
                </div>
            </div>
        </div>

        <!-- Right Form Side -->
        <div class="auth-form-side">
            <div class="auth-brand-badge">
                <i class="fas fa-user-plus"></i> Join KitchenOS
            </div>
            <h2 class="auth-title">Create Account</h2>
            <p class="auth-subtitle">Set up your kitchen stock in under 2 minutes.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                    <i class="fas fa-circle-exclamation me-1"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                    <i class="fas fa-circle-check me-1"></i> <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row g-2 mb-3">
                    <div class="col-12">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Aditya Sharma" required
                                value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-7">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="aditya@example.com" required
                                value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Mobile</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-phone"></i></span>
                            <input type="tel" name="mobile" class="form-control" placeholder="9876543210"
                                value="<?php echo isset($mobile) ? htmlspecialchars($mobile) : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="regPassword" class="form-control" placeholder="Min 6 chars" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                    <i class="fas fa-user-plus me-1"></i> Register Free
                </button>
            </form>

            <p class="text-center text-muted small mt-4 mb-0 pt-3 border-top">
                Already registered? <a href="login.php" class="text-primary fw-bold">Sign In here</a>
            </p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
