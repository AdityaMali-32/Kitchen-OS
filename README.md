# 🍳 Kitchen Inventory Management System

A beginner-friendly, complete Web Application for **Kitchen Inventory Management** built using **HTML5, CSS3, JavaScript, Bootstrap 5, PHP, and MySQL (XAMPP)**.

---

## 📌 Project Overview & Structure

```text
KITCHEN INVENTORY WEBSITE
                              │
              ┌───────────────┴───────────────┐
              │                               │
           USER SIDE                       ADMIN SIDE
              │                               │
       ┌──────┴──────┐                 ┌──────┴──────┐
       │             │                 │             │
    Register       Login           Admin Login    Dashboard
                      │
                      ↓
                 DASHBOARD
                      │
       ┌──────────────┼──────────────┐
       ↓              ↓              ↓
   Inventory       Suppliers       Reports
       │
 ┌─────┼─────┐
 ↓     ↓     ↓
Add   Edit  Delete
Item  Item  Item
```

---

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript (ES6+), Bootstrap 5, FontAwesome Icons
- **Backend:** PHP (MySQLi)
- **Database:** MySQL
- **Environment:** XAMPP / WAMP Server
- **IDE:** Visual Studio Code / Antigravity IDE

---

## 🚀 Key Modules & Features

### 👤 User Module
1. **Home Page (`index.php`)**: Project introduction, features grid, quick CTAs.
2. **User Registration (`register.php`)**: Signup form with password validation and duplicate check.
3. **User Login (`login.php`)**: Secure authentication with hashed passwords.
4. **Dashboard (`dashboard.php`)**: Real-time stats (*Total Items, Low Stock, Expiring Soon, Expired*), quick action buttons, and preview cards.
5. **Inventory Management (`inventory.php`)**: Complete item listing, status badges, instant search filter.
6. **Add & Edit Item (`add_item.php`, `edit_item.php`)**: Forms for item metadata (Name, Category, Quantity, Unit, Expiry, Supplier, Storage Location, Min Stock).
7. **Delete Item (`delete_item.php`)**: Safe removal of inventory items.
8. **Suppliers (`suppliers.php`)**: Add, edit, delete supplier directory with interactive modals.
9. **Purchase History (`purchases.php`)**: Purchase log automatically saved when adding items.
10. **Stock Alerts (`alerts.php`)**: Categorized view of low stock, expiring soon, and expired stock.
11. **Reports (`reports.php`)**: Visual report cards and printable table views.
12. **Profile (`profile.php`)**: Manage personal details and change account password.

### 👨‍💼 Admin Module
1. **Admin Dashboard (`admin/dashboard.php`)**: Global system overview.
2. **User Management (`admin/users.php`)**: View and manage all registered users.
3. **Category Management (`admin/categories.php`)**: Create and delete kitchen inventory categories.
4. **Admin Reports (`admin/reports.php`)**: System-wide statistics and printable summary.

---

## 📦 How to Setup & Run

1. **Install XAMPP** (if not already installed).
2. Start **Apache** and **MySQL** services from the XAMPP Control Panel.
3. Place this project folder inside your XAMPP `htdocs` directory:
   `C:\xampp\htdocs\Kitchen Inventory Aditya`
4. Open your web browser and visit:
   `http://localhost/Kitchen Inventory Aditya/`
5. The database `kitchen_inventory` and all necessary tables will **automatically initialize** on the first load!
6. *(Optional)* Alternatively, import `kitchen_inventory.sql` into **phpMyAdmin** (`http://localhost/phpmyadmin`).

---

## 🔑 Default Login Credentials

- **Admin Account**:
  - Email: `admin@kitchen.com`
  - Password: `admin123`
- **User Account**:
  - Register a new account via `register.php` or use any registered email.

---

## 📑 License & Credits

- Developed as a final project for BCA / CS Kitchen Inventory Management System.
- Designed & Developed by **Aditya**.
