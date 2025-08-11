-- Database: projek_guys
CREATE DATABASE IF NOT EXISTS nawala;
USE nawala;

-- Tabel untuk menyimpan data domain
CREATE TABLE IF NOT EXISTS domains (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domain_name VARCHAR(255) NOT NULL UNIQUE,
    status ENUM('Aman', 'Nawala') DEFAULT 'Aman',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan data short links
CREATE TABLE IF NOT EXISTS short_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_code VARCHAR(20) NOT NULL UNIQUE,
    original_url TEXT NOT NULL,
    clicks INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan data user (untuk login)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    level ENUM('basic', 'premium', 'admin') DEFAULT 'basic',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan log klik short link
CREATE TABLE IF NOT EXISTS click_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_link_id INT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    referer VARCHAR(255),
    clicked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (short_link_id) REFERENCES short_links(id) ON DELETE CASCADE
);

-- Tabel untuk menyimpan pengaturan
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data contoh untuk domain
INSERT INTO domains (domain_name, status) VALUES
('example.com', 'Aman'),
('test.net', 'Nawala'),
('demo.org', 'Nawala'),
('projek.link', 'Aman');

-- Insert data contoh untuk short links
INSERT INTO short_links (short_code, original_url, clicks, status) VALUES
('abc123', 'https://example.com/very-long-url-here', 245, 'active'),
('xyz789', 'https://another-example.com/another-long-url', 89, 'active'),
('qwe456', 'https://demo-site.com/super-long-url-path', 156, 'active');

-- Insert data contoh untuk user
INSERT INTO users (username, email, password_hash, level) VALUES
('admin', 'admin@nawala.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user1', 'user1@nawal.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'basic');

-- Insert data contoh untuk settings
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Projek Guys Panel'),
('site_description', 'Panel manajemen domain dan short link'),
('max_links_per_user', '100'),
('default_expiry_days', '30');
