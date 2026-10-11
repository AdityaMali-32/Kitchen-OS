<?php
include 'config/database.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: dashboard.php');
    }
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $conn->prepare("SELECT id, name, email, mobile, password, role FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_mobile'] = $user['mobile'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header('Location: admin/dashboard.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit();
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'Email not found. Please register first.';
        }
        $stmt->close();
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="auth-split-wrapper">
    <div class="auth-split-card">
        <!-- Left Visual Side with Picture (Chef in Kitchen) -->
        <div class="auth-visual-side" style="background-image: url('images/hero-chef.jpg');">
            <div class="auth-visual-content">
                <span class="badge bg-warning text-dark px-3 py-1 mb-3 fw-bold">
                    <i class="fas fa-kitchen-set"></i> Kitchen Command Center
                </span>
                <h3>Streamline Every Recipe & Shelf</h3>
                <p>
                    "Organization in the pantry is the foundation of exceptional cooking and zero food waste."
                </p>
                <div class="d-flex gap-2 pt-2">
                    <span class="badge bg-dark bg-opacity-75 border border-secondary text-light">✓ Real-time Tracking</span>
                    <span class="badge bg-dark bg-opacity-75 border border-secondary text-light">✓ Expiry Radar</span>
                </div>
            </div>
        </div>

        <!-- Right Form Side -->
        <div class="auth-form-side">
            <div class="auth-brand-badge">
                <i class="fas fa-arrow-right-to-bracket"></i> Sign In to KitchenOS
            </div>
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-subtitle">Enter your credentials to access your pantry inventory.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                    <i class="fas fa-circle-exclamation me-1"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="name@kitchen.com" required
                            value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label d-flex justify-content-between">
                        <span>Password</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Enter password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('loginPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                    <i class="fas fa-sign-in-alt me-1"></i> Sign In
                </button>
            </form>

            <div class="text-center mt-4 pt-2 border-top">
                <p class="text-muted small mb-2">
                    Don't have an account yet? <a href="register.php" class="text-primary fw-bold">Create Account</a>
                </p>
                <div class="p-2 bg-light rounded text-muted small" style="font-size: 0.78rem;">
                    <i class="fas fa-key text-warning me-1"></i> Demo Admin: <code>admin@kitchen.com</code> / <code>admin123</code>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
