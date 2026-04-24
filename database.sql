CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('Men', 'Women') DEFAULT 'Men'
);

CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, price, image, description, category) VALUES
('Classic White T-Shirt', 999.00, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=800&q=80', 'A versatile classic white t-shirt.', 'Men'),
('Vintage Denim Jacket', 3499.00, 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&w=800&q=80', 'A timeless denim jacket featuring a classic fit.', 'Men'),
('Black Skinny Jeans', 2490.00, 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=800&q=80', 'Skinny fit jeans with a slight stretch.', 'Men'),
('Floral Summer Dress', 2899.00, 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80', 'A light and breathable floral maxi dress.', 'Women'),
('Leather Biker Jacket', 7999.00, 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=800&q=80', 'Genuine women''s leather biker jacket.', 'Women'),
('Running Sneakers', 4599.00, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80', 'Lightweight running shoes.', 'Women');
