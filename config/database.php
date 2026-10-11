<?php
// Database Configuration
$host = 'localhost';
$username = 'root';
$password = 'Aditya123';
$database = 'kitchen_inventory';

// Create connection (supports Aditya123 or default XAMPP blank password)
$conn = @new mysqli($host, $username, $password);
if ($conn->connect_error) {
    // Try default blank XAMPP password
    $conn = @new mysqli($host, $username, '');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error . '<br><small>Tip: Check if MySQL is started in XAMPP Control Panel.</small>');
    }
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $database");
$conn->select_db($database);

// Create Users table
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mobile VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Create Categories table
$conn->query("CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Insert default categories
$result = $conn->query("SELECT COUNT(*) as count FROM categories");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $conn->query("INSERT INTO categories (name) VALUES 
        ('Grains'), ('Dairy'), ('Vegetables'), ('Fruits'), 
        ('Spices'), ('Beverages'), ('Snacks'), ('Grocery'), 
        ('Meat'), ('Frozen Foods'), ('Bakery'), ('Others')");
}

// Create Suppliers table
$conn->query("CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    email VARCHAR(100),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Create Inventory Items table
$conn->query("CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    quantity DECIMAL(10,2) NOT NULL DEFAULT 0,
    unit ENUM('Kg','L','Pieces','Grams','ml') DEFAULT 'Kg',
    purchase_date DATE,
    expiry_date DATE,
    supplier_id INT,
    storage_location VARCHAR(100),
    min_stock DECIMAL(10,2) DEFAULT 5,
    status ENUM('Available','Low Stock','Expired') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
)");

// Create Purchase History table
$conn->query("CREATE TABLE IF NOT EXISTS purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT,
    item_name VARCHAR(100),
    quantity DECIMAL(10,2),
    unit VARCHAR(20),
    supplier_id INT,
    purchase_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE SET NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
)");

// Create default admin account if not exists
$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='admin'");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (name, email, mobile, password, role) VALUES 
        ('Admin', 'admin@kitchen.com', '9999999999', '$admin_password', 'admin')");
}
?>
