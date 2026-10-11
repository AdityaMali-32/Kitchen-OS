    <!-- Modern Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="brand-icon-wrapper" style="width:32px; height:32px; font-size:0.95rem;">
                            <i class="fas fa-kitchen-set"></i>
                        </span>
                        <h5 class="mb-0 text-white">Kitchen<span style="color:var(--primary);">OS</span></h5>
                    </div>
                    <p class="text-muted small pe-lg-4">
                        A modern culinary stock and pantry management platform built to prevent food spoilage, track storage thresholds, and streamline commercial & household kitchens.
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <span class="badge bg-dark border border-secondary text-secondary"><i class="fab fa-php text-primary"></i> PHP 8+</span>
                        <span class="badge bg-dark border border-secondary text-secondary"><i class="fas fa-database text-warning"></i> MySQL</span>
                        <span class="badge bg-dark border border-secondary text-secondary"><i class="fab fa-bootstrap text-info"></i> Bootstrap 5</span>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-3 col-6">
                    <h5>Navigation</h5>
                    <ul class="list-unstyled small mb-0 d-flex flex-direction-column flex-column gap-2">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="inventory.php">Pantry Inventory</a></li>
                        <li><a href="alerts.php">Expiry Radar</a></li>
                        <li><a href="reports.php">Analytics</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 col-6">
                    <h5>Storage Modules</h5>
                    <ul class="list-unstyled small mb-0 d-flex flex-direction-column flex-column gap-2">
                        <li><a href="inventory.php">Dry Containers</a></li>
                        <li><a href="inventory.php">Fresh Produce</a></li>
                        <li><a href="inventory.php">Spices & Grains</a></li>
                        <li><a href="suppliers.php">Supplier Network</a></li>
                        <li><a href="purchases.php">Order Logs</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>System Status</h5>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                        <div class="d-flex align-items-center gap-2 mb-2 text-success small">
                            <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span>
                            <strong>Database Active & Synced</strong>
                        </div>
                        <p class="small text-muted mb-0">
                            Automated 7-day expiry warnings & minimum stock threshold alerts operational.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="mb-0 small text-muted">
                    © <?php echo date('Y'); ?> <strong>KitchenOS</strong>. All rights reserved.
                </p>
                <p class="mb-0 small text-muted">
                    Designed & Engineered with <i class="fas fa-heart text-danger"></i> by <strong>Aditya</strong>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>
