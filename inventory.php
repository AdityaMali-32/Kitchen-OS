<?php
include 'config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all items with category and supplier names
$items_query = $conn->query("
    SELECT i.*, c.name as category_name, s.name as supplier_name 
    FROM items i 
    LEFT JOIN categories c ON i.category_id = c.id 
    LEFT JOIN suppliers s ON i.supplier_id = s.id 
    WHERE i.user_id = $user_id 
    ORDER BY i.created_at DESC
");

// Fetch into array so we can iterate twice (for cards & for table)
$items_list = [];
$categories_present = [];
if ($items_query && $items_query->num_rows > 0) {
    while ($row = $items_query->fetch_assoc()) {
        $items_list[] = $row;
        if (!empty($row['category_name'])) {
            $categories_present[$row['category_name']] = true;
        }
    }
}

// Category emoji / icon helper
function getCategoryIcon($cat) {
    $cat = strtolower($cat ?? '');
    if (strpos($cat, 'grain') !== false || strpos($cat, 'rice') !== false || strpos($cat, 'pulse') !== false) return ['icon' => 'fa-wheat-awn', 'emoji' => '🌾', 'color' => '#f59e0b'];
    if (strpos($cat, 'dairy') !== false || strpos($cat, 'milk') !== false) return ['icon' => 'fa-cheese', 'emoji' => '🥛', 'color' => '#3b82f6'];
    if (strpos($cat, 'vegetable') !== false || strpos($cat, 'fresh') !== false) return ['icon' => 'fa-carrot', 'emoji' => '🥕', 'color' => '#10b981'];
    if (strpos($cat, 'fruit') !== false) return ['icon' => 'fa-apple-whole', 'emoji' => '🍎', 'color' => '#ef4444'];
    if (strpos($cat, 'spice') !== false || strpos($cat, 'masala') !== false) return ['icon' => 'fa-pepper-hot', 'emoji' => '🌶️', 'color' => '#ea580c'];
    if (strpos($cat, 'meat') !== false || strpos($cat, 'chicken') !== false || strpos($cat, 'egg') !== false) return ['icon' => 'fa-drumstick-bite', 'emoji' => '🍗', 'color' => '#e11d48'];
    if (strpos($cat, 'beverage') !== false || strpos($cat, 'tea') !== false || strpos($cat, 'coffee') !== false) return ['icon' => 'fa-mug-hot', 'emoji' => '☕', 'color' => '#8b5cf6'];
    if (strpos($cat, 'bakery') !== false || strpos($cat, 'bread') !== false) return ['icon' => 'fa-bread-slice', 'emoji' => '🍞', 'color' => '#d97706'];
    if (strpos($cat, 'frozen') !== false) return ['icon' => 'fa-snowflake', 'emoji' => '🧊', 'color' => '#06b6d4'];
    return ['icon' => 'fa-box', 'emoji' => '📦', 'color' => '#64748b'];
}
?>
<?php include 'includes/header.php'; ?>

<div class="container my-4">
    <!-- Top Header & Actions -->
    <div class="page-header">
        <div>
            <h2><i class="fas fa-boxes-stacked text-primary"></i> Pantry Inventory</h2>
            <p class="text-muted small mb-0 mt-1">Manage kitchen stock, inspect expiry states, and restock staples.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- View Mode Switcher -->
            <div class="btn-group shadow-sm" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm active" id="btnViewCards" onclick="switchView('cards')">
                    <i class="fas fa-grip"></i> Card Deck
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnViewTable" onclick="switchView('table')">
                    <i class="fas fa-table-list"></i> Table List
                </button>
            </div>
            <a href="add_item.php" class="btn btn-primary btn-sm px-3">
                <i class="fas fa-plus"></i> Add Item
            </a>
        </div>
    </div>

    <!-- Feedback Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show shadow-sm">
            <i class="fas fa-circle-check me-2"></i> <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
    <?php endif; ?>

    <!-- Search & Category Filters -->
    <div class="card p-3 mb-4 shadow-sm border-0">
        <div class="row g-3 align-items-center">
            <div class="col-lg-5 col-md-6">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search by item name, category, or supplier...">
                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="d-flex gap-2 flex-wrap justify-content-md-end" id="categoryPillFilters">
                    <button class="category-pill-btn active py-1 px-3" data-cat="all">
                        <i class="fas fa-border-all"></i> All (<?php echo count($items_list); ?>)
                    </button>
                    <?php foreach (array_keys($categories_present) as $catName): ?>
                        <button class="category-pill-btn py-1 px-3" data-cat="<?php echo htmlspecialchars(strtolower($catName)); ?>">
                            <?php echo htmlspecialchars($catName); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- EMPTY STATE -->
    <?php if (empty($items_list)): ?>
        <div class="card p-5 text-center shadow-sm">
            <div class="mb-3" style="font-size: 4rem;">🧺</div>
            <h4 class="fw-bold">Your Pantry is Empty!</h4>
            <p class="text-muted max-w-500 mx-auto" style="max-width: 480px;">
                You haven't added any kitchen items yet. Start adding your grains, dairy, fresh vegetables, and spices to track inventory and expiry warnings.
            </p>
            <div class="mt-3">
                <a href="add_item.php" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-plus"></i> Add Your First Item
                </a>
            </div>
        </div>
    <?php else: ?>

        <!-- VIEW 1: PANTRY CARDS DECK (INSPIRED BY PICTURE 5) -->
        <div id="cardsViewContainer">
            <div class="pantry-card-grid" id="pantryCardsGrid">
                <?php foreach ($items_list as $item): ?>
                    <?php
                    // Status calculation
                    $status = 'Available';
                    $badge_class = 'badge-available';
                    $expiry_chip_class = 'good';
                    $expiry_label = 'Fresh';

                    if ($item['expiry_date'] && strtotime($item['expiry_date']) < time()) {
                        $status = 'Expired';
                        $badge_class = 'badge-expired';
                        $expiry_chip_class = 'danger';
                        $days_diff = ceil((time() - strtotime($item['expiry_date'])) / 86400);
                        $expiry_label = "Expired {$days_diff}d ago";
                    } elseif ($item['expiry_date'] && strtotime($item['expiry_date']) <= strtotime('+7 days')) {
                        $status = 'Expiring Soon';
                        $badge_class = 'badge-expiring';
                        $expiry_chip_class = 'warning';
                        $days_diff = ceil((strtotime($item['expiry_date']) - time()) / 86400);
                        $expiry_label = $days_diff <= 1 ? "Exp: Tomorrow" : "Exp: in {$days_diff} days";
                    } elseif ($item['quantity'] <= $item['min_stock']) {
                        $status = 'Low Stock';
                        $badge_class = 'badge-low-stock';
                        $expiry_chip_class = 'warning';
                        $expiry_label = "Stock Low";
                    } else {
                        if ($item['expiry_date']) {
                            $days_diff = ceil((strtotime($item['expiry_date']) - time()) / 86400);
                            $expiry_label = "Exp: {$days_diff} days";
                        } else {
                            $expiry_label = "No Expiry Set";
                        }
                    }

                    $catInfo = getCategoryIcon($item['category_name']);
                    ?>
                    <div class="pantry-item-card inventory-card-item" 
                         data-name="<?php echo htmlspecialchars(strtolower($item['name'])); ?>"
                         data-category="<?php echo htmlspecialchars(strtolower($item['category_name'] ?? '')); ?>"
                         data-supplier="<?php echo htmlspecialchars(strtolower($item['supplier_name'] ?? '')); ?>">
                        
                        <div class="pantry-item-top">
                            <span class="pantry-cat-icon" style="background: <?php echo $catInfo['color']; ?>18; color: <?php echo $catInfo['color']; ?>;">
                                <i class="fas <?php echo $catInfo['icon']; ?>"></i>
                            </span>
                            <span class="<?php echo $badge_class; ?>" style="font-size:0.75rem;">
                                <?php echo $status; ?>
                            </span>
                        </div>

                        <div class="pantry-item-visual">
                            <?php echo $catInfo['emoji']; ?>
                        </div>

                        <div class="pantry-item-title text-truncate" title="<?php echo htmlspecialchars($item['name']); ?>">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </div>

                        <div class="pantry-item-meta d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-tag text-muted me-1"></i><?php echo htmlspecialchars($item['category_name'] ?? 'Uncategorized'); ?></span>
                            <?php if (!empty($item['storage_location'])): ?>
                                <span class="badge bg-light text-secondary border" style="font-size:0.7rem;">📍 <?php echo htmlspecialchars($item['storage_location']); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="pantry-item-bottom">
                            <span class="expiry-tag <?php echo $expiry_chip_class; ?>">
                                <i class="fas fa-clock"></i> <?php echo $expiry_label; ?>
                            </span>
                            
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                                <?php echo $item['quantity'] . ' ' . htmlspecialchars($item['unit']); ?>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="d-flex gap-2 mt-3 pt-2 border-top">
                            <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-primary btn-sm flex-fill py-1" style="font-size: 0.8rem;">
                                <i class="fas fa-pen-to-square"></i> Edit
                            </a>
                            <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="btn btn-outline-danger btn-sm px-2 py-1 delete-btn" title="Delete" style="font-size: 0.8rem;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- VIEW 2: TABLE LIST -->
        <div id="tableViewContainer" style="display: none;">
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Location</th>
                            <th>Expiry Date</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; foreach ($items_list as $item): ?>
                            <?php
                            $status = 'Available';
                            $badge_class = 'badge-available';
                            if ($item['expiry_date'] && strtotime($item['expiry_date']) < time()) {
                                $status = 'Expired';
                                $badge_class = 'badge-expired';
                            } elseif ($item['expiry_date'] && strtotime($item['expiry_date']) <= strtotime('+7 days')) {
                                $status = 'Expiring Soon';
                                $badge_class = 'badge-expiring';
                            } elseif ($item['quantity'] <= $item['min_stock']) {
                                $status = 'Low Stock';
                                $badge_class = 'badge-low-stock';
                            }
                            $catInfo = getCategoryIcon($item['category_name']);
                            ?>
                            <tr class="inventory-table-row" 
                                data-name="<?php echo htmlspecialchars(strtolower($item['name'])); ?>"
                                data-category="<?php echo htmlspecialchars(strtolower($item['category_name'] ?? '')); ?>"
                                data-supplier="<?php echo htmlspecialchars(strtolower($item['supplier_name'] ?? '')); ?>">
                                <td><?php echo $count++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fs-5"><?php echo $catInfo['emoji']; ?></span>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo htmlspecialchars($item['category_name'] ?? 'N/A'); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo $item['quantity']; ?></strong> 
                                    <span class="text-muted small"><?php echo htmlspecialchars($item['unit']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($item['storage_location'] ?? '—'); ?></td>
                                <td>
                                    <?php if ($item['expiry_date']): ?>
                                        <i class="far fa-calendar text-muted me-1"></i>
                                        <?php echo date('d/m/Y', strtotime($item['expiry_date'])); ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['supplier_name'] ?? '—'); ?></td>
                                <td><span class="<?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
