-- DonaMart Database Schema

CREATE DATABASE IF NOT EXISTS `donamart_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `donamart_db`;

-- Admins Table
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `description` TEXT NOT NULL,
  `sizes` VARCHAR(255) NOT NULL, -- e.g., "6 inch, 8 inch, 10 inch"
  `material` VARCHAR(100) NOT NULL, -- e.g., "Areca Leaf", "Sal Leaf"
  `moq` INT NOT NULL DEFAULT 1000, -- Minimum Order Quantity
  `image` VARCHAR(255) NOT NULL,
  `is_featured` TINYINT(1) DEFAULT 0,
  `status` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Gallery Table
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `image` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) DEFAULT NULL,
  `type` VARCHAR(50) DEFAULT 'product', -- 'factory', 'process', 'product'
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Bulk Enquiries Table
CREATE TABLE IF NOT EXISTS `bulk_enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `company_name` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `product_name` VARCHAR(150) DEFAULT NULL, -- Can be manual input or selected product
  `quantity` INT NOT NULL,
  `address` TEXT NOT NULL,
  `message` TEXT DEFAULT NULL,
  `status` VARCHAR(20) DEFAULT 'pending', -- 'pending', 'replied', 'closed'
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `status` VARCHAR(20) DEFAULT 'unread', -- 'unread', 'read', 'replied'
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Newsletter Subscribers Table
CREATE TABLE IF NOT EXISTS `newsletter_subscribers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert Default Admin (username: admin, password: admin123 (hashed))
INSERT INTO `admins` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$yF29Q6U3L4vUeP/Wj9w1Z.c9LqC7fM1kF3R18XJ.8s8.Bw5bA6R1m', 'admin@donamart.com')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Default Categories
INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Dona', 'dona'),
(2, 'Pattal', 'pattal'),
(3, 'Areca Leaf Plates', 'areca-leaf-plates'),
(4, 'Bowls', 'bowls'),
(5, 'Compartment Plates', 'compartment-plates'),
(6, 'Disposable Glasses', 'disposable-glasses')
ON DUPLICATE KEY UPDATE `id`=`id`;
