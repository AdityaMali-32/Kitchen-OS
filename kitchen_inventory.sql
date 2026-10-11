-- ========================================================
-- Kitchen Inventory Management System - Database SQL Export
-- Database: kitchen_inventory
-- Tech Stack: PHP, MySQL, HTML5, CSS3, Bootstrap 5, JavaScript
-- Created for: College Project Submission
-- ========================================================

CREATE DATABASE IF NOT EXISTS `kitchen_inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `kitchen_inventory`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `mobile` VARCHAR(15),
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin') DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping default admin user (password: admin123)
INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `role`) VALUES
(1, 'Admin', 'admin@kitchen.com', '9999999999', '$2y$10$wT0XoFp2J2K3J/j3eN9lCeX1jN/11w9Y08K1Y.7Z7N98Y3K4W5X6Y', 'admin');

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping default categories
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Grains', 'Rice, Wheat, Dal, Pulses, Oats'),
(2, 'Dairy', 'Milk, Butter, Cheese, Yogurt, Paneer'),
(3, 'Vegetables', 'Fresh vegetables and greens'),
(4, 'Fruits', 'Fresh fruits and dry fruits'),
(5, 'Spices', 'Salt, Pepper, Turmeric, Masala'),
(6, 'Beverages', 'Tea, Coffee, Juices, Soft drinks'),
(7, 'Snacks', 'Biscuits, Chips, Namkeen'),
(8, 'Grocery', 'Cooking Oil, Sugar, Flour'),
(9, 'Meat', 'Chicken, Mutton, Fish, Eggs'),
(10, 'Frozen Foods', 'Ice Cream, Frozen Peas, Nuggets'),
(11, 'Bakery', 'Bread, Buns, Cakes, Cookies'),
(12, 'Others', 'Miscellaneous household kitchen items');

-- --------------------------------------------------------
-- Table structure for table `suppliers`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(15),
  `email` VARCHAR(100),
  `address` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping sample suppliers
INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`) VALUES
(1, 'ABC Foods Ltd', '9876543210', 'contact@abcfoods.com', '123 Market Street, City'),
(2, 'XYZ Dairy Farm', '9988776655', 'sales@xyzdairy.com', '45 Green Valley Farm, Suburbs');

-- --------------------------------------------------------
-- Table structure for table `items`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `category_id` INT,
  `quantity` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `unit` ENUM('Kg','L','Pieces','Grams','ml') DEFAULT 'Kg',
  `purchase_date` DATE,
  `expiry_date` DATE,
  `supplier_id` INT,
  `storage_location` VARCHAR(100),
  `min_stock` DECIMAL(10,2) DEFAULT 5,
  `status` ENUM('Available','Low Stock','Expired') DEFAULT 'Available',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `purchases`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `purchases` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `item_id` INT,
  `item_name` VARCHAR(100),
  `quantity` DECIMAL(10,2),
  `unit` VARCHAR(20),
  `supplier_id` INT,
  `purchase_date` DATE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `items`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
