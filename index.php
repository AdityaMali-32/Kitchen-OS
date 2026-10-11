<?php include 'includes/header.php'; ?>

<!-- ===== MODERN HERO SECTION ===== -->
<section class="hero-section-modern">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Left Hero Content -->
            <div class="col-lg-6">
                <div class="hero-pill-badge">
                    <i class="fas fa-sparkles text-warning"></i> Next-Gen Kitchen & Pantry Management
                </div>
                <h1 class="hero-title">
                    Master Your Stock. <br>
                    <span class="gradient-text">Zero Spoilage.</span> <br>
                    Cook with Peace of Mind.
                </h1>
                <p class="hero-desc">
                    The complete culinary operating system for modern home cooks and professional kitchens. Track airtight pantry containers, monitor farm-fresh produce with 7-day expiry radar, and reorder staples before you run out.
                </p>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-primary btn-lg px-4 py-3 shadow-lg">
                            <i class="fas fa-chart-pie"></i> Open Dashboard
                        </a>
                        <a href="inventory.php" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-boxes-stacked"></i> View Inventory
                        </a>
                    <?php else: ?>
                        <a href="register.php" class="btn btn-primary btn-lg px-4 py-3 shadow-lg">
                            <i class="fas fa-rocket"></i> Get Started Free
                        </a>
                        <a href="login.php" class="btn btn-outline-light btn-lg px-4 py-3">
                            <i class="fas fa-arrow-right-to-bracket"></i> Login Account
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Live Quick Chips -->
                <div class="hero-stat-chips">
                    <span class="hero-chip"><i class="fas fa-shield-halved"></i> 100% Expiry Protection</span>
                    <span class="hero-chip"><i class="fas fa-barcode"></i> 12+ Food Categories</span>
                    <span class="hero-chip"><i class="fas fa-truck-fast"></i> Supplier Reorders</span>
                </div>
            </div>

            <!-- Right Hero Media Showcase -->
            <div class="col-lg-6">
                <div class="hero-showcase-wrapper">
                    <!-- Floating Top Badge -->
                    <div class="hero-floating-card top-right">
                        <div class="floating-icon-circle emerald">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Expiry Radar Active</div>
                            <div class="text-muted" style="font-size:0.75rem;">7 items protected today</div>
                        </div>
                    </div>

                    <!-- Main Showcase Card (Picture 1: Chef with Tablet & Fresh Ingredients) -->
                    <div class="hero-main-card">
                        <img src="images/hero-chef.jpg" alt="Chef using digital tablet in kitchen inventory" class="img-fluid">
                        <div class="hero-overlay-tag">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-pill px-2 py-1"><i class="fas fa-wifi"></i> Live System</span>
                                <span class="text-white small fw-bold">Commercial & Home Ready</span>
                            </div>
                            <span class="text-warning small"><i class="fas fa-star"></i> Pro Kitchen Edition</span>
                        </div>
                    </div>

                    <!-- Floating Bottom Badge -->
                    <div class="hero-floating-card bottom-left">
                        <div class="floating-icon-circle orange">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Pantry Shelves Synced</div>
                            <div class="text-muted" style="font-size:0.75rem;">Real-time stock threshold</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== VISUAL STORAGE SHOWCASE (THE 4 USER PICTURES) ===== -->
<section class="gallery-section">
    <div class="container">
        <div class="text-center">
            <span class="section-tag"><i class="fas fa-camera"></i> Kitchen Visual Architecture</span>
            <h2 class="section-title">Designed for Every Corner of Your Kitchen</h2>
            <p class="section-subtitle">
                From organized walk-in cupboards to farm-fresh countertops and vibrant spice racks, see how our visual inventory structure keeps your kitchen spotless.
            </p>
        </div>

        <div class="row g-4">
            <!-- Card 1: Organized Pantry -->
            <div class="col-lg-3 col-md-6">
                <div class="kitchen-showcase-card">
                    <div class="showcase-img-box">
                        <span class="showcase-category-badge"><i class="fas fa-jar"></i> Dry Pantry</span>
                        <img src="images/organized-pantry.jpg" alt="Organized pantry shelf with labeled containers">
                    </div>
                    <div class="showcase-body">
                        <h4>Airtight Container Shelving</h4>
                        <p>Track pasta, flours, grains, and dry staples stored in labeled jars. Set minimum thresholds to restock before your container runs dry.</p>
                        <ul class="showcase-features-list">
                            <li><i class="fas fa-check-circle"></i> Transparent shelf inventory</li>
                            <li><i class="fas fa-check-circle"></i> Custom units (kg, g, packs)</li>
                            <li><i class="fas fa-check-circle"></i> Low stock yellow alerts</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card 2: Fresh Produce -->
            <div class="col-lg-3 col-md-6">
                <div class="kitchen-showcase-card">
                    <div class="showcase-img-box">
                        <span class="showcase-category-badge" style="background: rgba(16, 185, 129, 0.9);"><i class="fas fa-carrot"></i> Fresh Market</span>
                        <img src="images/fresh-produce.jpg" alt="Fresh fruits and vegetables in kitchen baskets">
                    </div>
                    <div class="showcase-body">
                        <h4>Farm-Fresh Produce Radar</h4>
                        <p>Keep fruits, greens, and perishable vegetables in check. Our intelligent 7-day countdown ensures ingredients are consumed at peak freshness.</p>
                        <ul class="showcase-features-list">
                            <li><i class="fas fa-check-circle"></i> 7-day expiry countdown</li>
                            <li><i class="fas fa-check-circle"></i> Prevents grocery waste</li>
                            <li><i class="fas fa-check-circle"></i> Color-coded danger warnings</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card 3: Indian Spices & Staples -->
            <div class="col-lg-3 col-md-6">
                <div class="kitchen-showcase-card">
                    <div class="showcase-img-box">
                        <span class="showcase-category-badge" style="background: rgba(234, 88, 12, 0.9);"><i class="fas fa-pepper-hot"></i> Aromatics</span>
                        <img src="images/spices-grains.jpg" alt="Rice, lentils, turmeric and Indian spices">
                    </div>
                    <div class="showcase-body">
                        <h4>Grains, Pulses & Spices</h4>
                        <p>Dedicated management for whole spices, lentils, cooking oils, basmati rice, and aromatics. Connect each item directly to trusted local suppliers.</p>
                        <ul class="showcase-features-list">
                            <li><i class="fas fa-check-circle"></i> Dal, rice & oil tracking</li>
                            <li><i class="fas fa-check-circle"></i> Masala & spice box control</li>
                            <li><i class="fas fa-check-circle"></i> Supplier directory linking</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card 4: Digital App Card Interface -->
            <div class="col-lg-3 col-md-6">
                <div class="kitchen-showcase-card">
                    <div class="showcase-img-box">
                        <span class="showcase-category-badge" style="background: rgba(14, 165, 233, 0.9);"><i class="fas fa-mobile-screen"></i> Modern UI</span>
                        <img src="images/pantry-ui-preview.jpg" alt="Pantry mobile application interface cards">
                    </div>
                    <div class="showcase-body">
                        <h4>Intuitive Visual Card View</h4>
                        <p>Experience an ultra-clean card-based pantry interface with instant quantity steppers, category filtering pills, and clean expiry chips.</p>
                        <ul class="showcase-features-list">
                            <li><i class="fas fa-check-circle"></i> Quick +/- quantity steppers</li>
                            <li><i class="fas fa-check-circle"></i> Instant category tabs</li>
                            <li><i class="fas fa-check-circle"></i> Mobile and desktop responsive</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== INTERACTIVE PANTRY PREVIEW (PICTURE 5 LIVE DEMO) ===== -->
<section class="pantry-demo-section">
    <div class="container">
        <div class="text-center mb-4">
            <span class="section-tag"><i class="fas fa-hand-pointer"></i> Interactive Live Preview</span>
            <h2 class="section-title">Visual Pantry Management in Action</h2>
            <p class="section-subtitle">
                Try out our interactive pantry card system. Filter by category, adjust stock counters, and experience the smooth interface.
            </p>
        </div>

        <div class="pantry-ui-container">
            <!-- Top Controls -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-4">🧺</span>
                    <h4 class="mb-0 fw-bold">Live Pantry Deck</h4>
                </div>
                <div class="search-bar" style="max-width: 300px; width: 100%;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="demoPantrySearch" class="form-control form-control-sm" placeholder="Filter sample items...">
                </div>
            </div>

            <!-- Category Filter Tabs -->
            <div class="pantry-category-pills">
                <button class="category-pill-btn active" data-filter="all"><i class="fas fa-border-all me-1"></i> All Items</button>
                <button class="category-pill-btn" data-filter="fresh"><i class="fas fa-apple-whole me-1"></i> Fresh</button>
                <button class="category-pill-btn" data-filter="grains"><i class="fas fa-wheat-awn me-1"></i> Grains</button>
                <button class="category-pill-btn" data-filter="dairy"><i class="fas fa-cheese me-1"></i> Dairy</button>
                <button class="category-pill-btn" data-filter="meat"><i class="fas fa-drumstick-bite me-1"></i> Meat</button>
                <button class="category-pill-btn" data-filter="spices"><i class="fas fa-pepper-hot me-1"></i> Spices</button>
            </div>

            <!-- Interactive Demo Cards Grid -->
            <div class="pantry-card-grid" id="demoPantryGrid">
                <!-- Item 1: Chicken Breasts -->
                <div class="pantry-item-card" data-category="meat" data-name="chicken breasts">
                    <div class="pantry-item-top">
                        <div class="pantry-cat-icon"><i class="fas fa-drumstick-bite"></i></div>
                        <button class="pantry-bookmark-btn"><i class="far fa-bookmark"></i></button>
                    </div>
                    <div class="pantry-item-visual">🍗</div>
                    <div class="pantry-item-title">Chicken Breasts</div>
                    <div class="pantry-item-meta">Freezer Box • Grade A</div>
                    <div class="pantry-item-bottom">
                        <span class="expiry-tag warning"><i class="fas fa-clock"></i> Exp: 3 days</span>
                        <div class="stepper-control">
                            <button class="stepper-btn" onclick="adjustDemoQty(this, -1)">-</button>
                            <span class="fw-bold px-1 qty-val" style="font-size:0.85rem;">2 packs</span>
                            <button class="stepper-btn" onclick="adjustDemoQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Item 2: Whole Milk -->
                <div class="pantry-item-card" data-category="dairy" data-name="whole milk">
                    <div class="pantry-item-top">
                        <div class="pantry-cat-icon"><i class="fas fa-bottle-droplet"></i></div>
                        <button class="pantry-bookmark-btn"><i class="far fa-bookmark"></i></button>
                    </div>
                    <div class="pantry-item-visual">🥛</div>
                    <div class="pantry-item-title">Whole Milk</div>
                    <div class="pantry-item-meta">Dairy Chiller • Organic</div>
                    <div class="pantry-item-bottom">
                        <span class="expiry-tag danger"><i class="fas fa-triangle-exclamation"></i> Exp: Tomorrow</span>
                        <div class="stepper-control">
                            <button class="stepper-btn" onclick="adjustDemoQty(this, -1)">-</button>
                            <span class="fw-bold px-1 qty-val" style="font-size:0.85rem;">1 L</span>
                            <button class="stepper-btn" onclick="adjustDemoQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Item 3: Avocado -->
                <div class="pantry-item-card" data-category="fresh" data-name="avocado">
                    <div class="pantry-item-top">
                        <div class="pantry-cat-icon"><i class="fas fa-lemon"></i></div>
                        <button class="pantry-bookmark-btn"><i class="far fa-bookmark"></i></button>
                    </div>
                    <div class="pantry-item-visual">🥑</div>
                    <div class="pantry-item-title">Fresh Avocado</div>
                    <div class="pantry-item-meta">Fruit Basket • Ripe</div>
                    <div class="pantry-item-bottom">
                        <span class="expiry-tag good"><i class="fas fa-check"></i> Exp: 6 days</span>
                        <div class="stepper-control">
                            <button class="stepper-btn" onclick="adjustDemoQty(this, -1)">-</button>
                            <span class="fw-bold px-1 qty-val" style="font-size:0.85rem;">3 units</span>
                            <button class="stepper-btn" onclick="adjustDemoQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Item 4: Carrots -->
                <div class="pantry-item-card" data-category="fresh" data-name="carrots">
                    <div class="pantry-item-top">
                        <div class="pantry-cat-icon"><i class="fas fa-carrot"></i></div>
                        <button class="pantry-bookmark-btn"><i class="far fa-bookmark"></i></button>
                    </div>
                    <div class="pantry-item-visual">🥕</div>
                    <div class="pantry-item-title">Farm Carrots</div>
                    <div class="pantry-item-meta">Crisper Bin • Crisp</div>
                    <div class="pantry-item-bottom">
                        <span class="expiry-tag good"><i class="fas fa-check"></i> Exp: 8 days</span>
                        <div class="stepper-control">
                            <button class="stepper-btn" onclick="adjustDemoQty(this, -1)">-</button>
                            <span class="fw-bold px-1 qty-val" style="font-size:0.85rem;">1 bag</span>
                            <button class="stepper-btn" onclick="adjustDemoQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Item 5: Basmati Rice -->
                <div class="pantry-item-card" data-category="grains" data-name="basmati rice">
                    <div class="pantry-item-top">
                        <div class="pantry-cat-icon"><i class="fas fa-bowl-rice"></i></div>
                        <button class="pantry-bookmark-btn"><i class="far fa-bookmark"></i></button>
                    </div>
                    <div class="pantry-item-visual">🍚</div>
                    <div class="pantry-item-title">Basmati Rice</div>
                    <div class="pantry-item-meta">Dry Container • Jar 04</div>
                    <div class="pantry-item-bottom">
                        <span class="expiry-tag good"><i class="fas fa-check"></i> Exp: 6 months</span>
                        <div class="stepper-control">
                            <button class="stepper-btn" onclick="adjustDemoQty(this, -1)">-</button>
                            <span class="fw-bold px-1 qty-val" style="font-size:0.85rem;">5 kg</span>
                            <button class="stepper-btn" onclick="adjustDemoQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Item 6: Farm Fresh Eggs -->
                <div class="pantry-item-card" data-category="dairy" data-name="eggs">
                    <div class="pantry-item-top">
                        <div class="pantry-cat-icon"><i class="fas fa-egg"></i></div>
                        <button class="pantry-bookmark-btn"><i class="far fa-bookmark"></i></button>
                    </div>
                    <div class="pantry-item-visual">🥚</div>
                    <div class="pantry-item-title">Farm Eggs</div>
                    <div class="pantry-item-meta">Egg Rack • 12 pack</div>
                    <div class="pantry-item-bottom">
                        <span class="expiry-tag good"><i class="fas fa-check"></i> Exp: 10 days</span>
                        <div class="stepper-control">
                            <button class="stepper-btn" onclick="adjustDemoQty(this, -1)">-</button>
                            <span class="fw-bold px-1 qty-val" style="font-size:0.85rem;">12 pcs</span>
                            <button class="stepper-btn" onclick="adjustDemoQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="register.php" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-plus"></i> Set Up Your Own Kitchen Stock
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== CORE PLATFORM CAPABILITIES ===== -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag"><i class="fas fa-shield-heart"></i> Complete Toolset</span>
            <h2 class="section-title">Everything You Need for Total Kitchen Control</h2>
            <p class="section-subtitle">Streamlined features designed to save money, avoid grocery repeats, and stop food waste.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 h-100 border shadow-sm">
                    <div class="stat-icon-wrapper" style="background: rgba(249, 115, 22, 0.12); color: var(--primary);">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Category & Storage Locator</h5>
                    <p class="text-muted small mb-0">Organize items into 12+ standard culinary categories (Grains, Dairy, Produce, Spices, Meat, Bakery) with specific shelf and storage tags.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 h-100 border shadow-sm">
                    <div class="stat-icon-wrapper" style="background: rgba(239, 68, 68, 0.12); color: var(--danger);">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Dual Alert Radar</h5>
                    <p class="text-muted small mb-0">Automatic split alerts: Yellow warnings for items dropping below safe minimum stock levels, and red alarms for items approaching expiry.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 h-100 border shadow-sm">
                    <div class="stat-icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: var(--success);">
                        <i class="fas fa-truck-ramp-box"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Supplier Directory</h5>
                    <p class="text-muted small mb-0">Maintain contact books for local dairy vendors, grocery stores, wholesale grain suppliers, and butchers for quick reorders.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 h-100 border shadow-sm">
                    <div class="stat-icon-wrapper" style="background: rgba(14, 165, 233, 0.12); color: var(--info);">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Purchase Audit Log</h5>
                    <p class="text-muted small mb-0">Every inventory restock automatically logs purchase history, quantity bought, supplier source, and timestamps for accounting.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 h-100 border shadow-sm">
                    <div class="stat-icon-wrapper" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Printable Reports</h5>
                    <p class="text-muted small mb-0">Generate instant inventory summaries, low stock reports, and purchase history ready to print or export as PDF for audits.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 h-100 border shadow-sm">
                    <div class="stat-icon-wrapper" style="background: rgba(245, 158, 11, 0.12); color: var(--warning);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Multi-User & Admin Panel</h5>
                    <p class="text-muted small mb-0">Role-based access security with isolated user inventories and a master administrator panel to manage categories, users, and reports.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== ABOUT PROJECT SECTION ===== -->
<section class="py-5" style="background: #fdfbf7;">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-tag"><i class="fas fa-graduation-cap"></i> Academic Excellence</span>
                <h2 class="fw-bold mb-3">Kitchen Inventory Management System</h2>
                <p class="text-muted">
                    Engineered to resolve real-world food spoilage and inefficient restocking across commercial food establishments and smart households.
                </p>
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 rounded-circle bg-white shadow-sm text-primary"><i class="fas fa-check"></i></div>
                        <div>
                            <strong>Full Relational Database Architecture:</strong>
                            <p class="text-muted small mb-0">Optimized MySQL schemas with foreign-key cascades, user-isolated records, and indexed timestamps.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 rounded-circle bg-white shadow-sm text-primary"><i class="fas fa-check"></i></div>
                        <div>
                            <strong>Prepared Statements & Secure Sessions:</strong>
                            <p class="text-muted small mb-0">Built-in protection against SQL injection and password hashing via modern bcrypt algorithms.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 rounded-circle bg-white shadow-sm text-primary"><i class="fas fa-check"></i></div>
                        <div>
                            <strong>Responsive Mobile & Desktop View:</strong>
                            <p class="text-muted small mb-0">Designed with Bootstrap 5 and modular CSS for seamless use on kitchen tablets, phones, and desktops.</p>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-white rounded-3 border d-inline-block">
                    <span class="small text-muted">Project Submission: <strong>BCA Final Year Project</strong> • Developed by <strong>Aditya</strong></span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="rounded-4 overflow-hidden shadow-lg border">
                        <img src="images/organized-pantry.jpg" alt="Pantry organization" class="img-fluid" style="height: 380px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="p-3 bg-white rounded-3 shadow position-absolute bottom-0 start-0 m-4 border d-flex align-items-center gap-3">
                        <div class="stat-icon-wrapper mb-0" style="width:40px; height:40px; background: rgba(16, 185, 129, 0.15); color: var(--success);">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Zero Food Waste Goal</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Optimized stock rotation (FIFO)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CALL TO ACTION BANNER ===== -->
<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white;">
    <div class="container text-center py-4">
        <h2 class="text-white fw-bold mb-3">Ready to Transform Your Kitchen Inventory?</h2>
        <p class="text-muted max-w-600 mx-auto mb-4" style="max-width: 600px;">
            Join smart kitchens keeping their pantries fresh, organized, and budget-friendly with automated expiry and stock tracking.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="register.php" class="btn btn-primary btn-lg px-4"><i class="fas fa-user-plus"></i> Create Account</a>
            <a href="login.php" class="btn btn-outline-light btn-lg px-4"><i class="fas fa-sign-in-alt"></i> Sign In</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
