// ===== KITCHEN INVENTORY MANAGEMENT - CUSTOM JAVASCRIPT =====

document.addEventListener('DOMContentLoaded', function() {
    // 1. Auto-dismiss flash alerts after 4 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.classList.remove('show');
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 4000);
    });

    // 2. Confirm before delete
    const deleteLinks = document.querySelectorAll('.delete-btn');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this inventory item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // 3. Search filter for Inventory Page (Cards & Table)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterInventory();
        });
    }

    // 4. Category pill filters for Inventory Page
    const catPills = document.querySelectorAll('#categoryPillFilters .category-pill-btn');
    if (catPills.length > 0) {
        catPills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                catPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                filterInventory();
            });
        });
    }

    // 5. Password match validation
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            const password = document.getElementById('regPassword') ? document.getElementById('regPassword').value : document.getElementById('password').value;
            if (this.value !== password) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // 6. Interactive Demo on Landing Page (index.php)
    initLandingPageDemo();
});

// ===== INVENTORY FILTERING FUNCTION (COMBINED SEARCH & CATEGORY) =====
function filterInventory() {
    const searchInput = document.getElementById('searchInput');
    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

    const activeCatBtn = document.querySelector('#categoryPillFilters .category-pill-btn.active');
    const selectedCat = activeCatBtn ? activeCatBtn.getAttribute('data-cat') : 'all';

    // Filter Cards
    const cards = document.querySelectorAll('.inventory-card-item');
    cards.forEach(function(card) {
        const name = (card.getAttribute('data-name') || '').toLowerCase();
        const category = (card.getAttribute('data-category') || '').toLowerCase();
        const supplier = (card.getAttribute('data-supplier') || '').toLowerCase();

        const matchesQuery = query === '' || name.includes(query) || category.includes(query) || supplier.includes(query);
        const matchesCat = selectedCat === 'all' || category.includes(selectedCat);

        if (matchesQuery && matchesCat) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });

    // Filter Table Rows
    const rows = document.querySelectorAll('.inventory-table-row');
    rows.forEach(function(row) {
        const name = (row.getAttribute('data-name') || '').toLowerCase();
        const category = (row.getAttribute('data-category') || '').toLowerCase();
        const supplier = (row.getAttribute('data-supplier') || '').toLowerCase();

        const matchesQuery = query === '' || name.includes(query) || category.includes(query) || supplier.includes(query);
        const matchesCat = selectedCat === 'all' || category.includes(selectedCat);

        if (matchesQuery && matchesCat) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// ===== SWITCH INVENTORY VIEW (CARDS VS TABLE) =====
function switchView(mode) {
    const cardsView = document.getElementById('cardsViewContainer');
    const tableView = document.getElementById('tableViewContainer');
    const btnCards = document.getElementById('btnViewCards');
    const btnTable = document.getElementById('btnViewTable');

    if (!cardsView || !tableView) return;

    if (mode === 'cards') {
        cardsView.style.display = 'block';
        tableView.style.display = 'none';
        btnCards.classList.add('active');
        btnTable.classList.remove('active');
        localStorage.setItem('kitchen_inventory_view', 'cards');
    } else {
        cardsView.style.display = 'none';
        tableView.style.display = 'block';
        btnTable.classList.add('active');
        btnCards.classList.remove('active');
        localStorage.setItem('kitchen_inventory_view', 'table');
    }
}

// Restore user view preference if present
(function() {
    const savedView = localStorage.getItem('kitchen_inventory_view');
    if (savedView === 'table') {
        window.addEventListener('DOMContentLoaded', function() {
            switchView('table');
        });
    }
})();

// ===== PASSWORD VISIBILITY TOGGLE =====
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        if (icon) {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    } else {
        input.type = 'password';
        if (icon) {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
}

// ===== LANDING PAGE DEMO INTERACTION =====
function initLandingPageDemo() {
    const demoGrid = document.getElementById('demoPantryGrid');
    const demoSearch = document.getElementById('demoPantrySearch');
    const demoPills = document.querySelectorAll('.pantry-demo-section .category-pill-btn');

    if (!demoGrid) return;

    // Filter pills
    demoPills.forEach(function(pill) {
        pill.addEventListener('click', function() {
            demoPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            filterDemoCards();
        });
    });

    // Search input
    if (demoSearch) {
        demoSearch.addEventListener('input', filterDemoCards);
    }

    function filterDemoCards() {
        const query = demoSearch ? demoSearch.value.toLowerCase().trim() : '';
        const activePill = document.querySelector('.pantry-demo-section .category-pill-btn.active');
        const filterCat = activePill ? activePill.getAttribute('data-filter') : 'all';

        const cards = demoGrid.querySelectorAll('.pantry-item-card');
        cards.forEach(function(card) {
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const cat = (card.getAttribute('data-category') || '').toLowerCase();

            const matchQuery = query === '' || name.includes(query);
            const matchCat = filterCat === 'all' || cat === filterCat;

            card.style.display = (matchQuery && matchCat) ? 'flex' : 'none';
        });
    }
}

// Demo quantity adjustment stepper
function adjustDemoQty(btn, change) {
    const container = btn.parentElement;
    const qtySpan = container.querySelector('.qty-val');
    if (!qtySpan) return;

    const text = qtySpan.innerText;
    const match = text.match(/(\d+)\s*(.*)/);
    if (match) {
        let count = parseInt(match[1]);
        const unit = match[2];
        count += change;
        if (count < 0) count = 0;
        qtySpan.innerText = count + (unit ? ' ' + unit : '');
    }
}

// ===== PRINT REPORT FUNCTION =====
function printReport() {
    window.print();
}
