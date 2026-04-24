CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
);

-- Note: We are using PHP Sessions for the cart to keep it simple, 
-- but a cart table structure is provided if needed later.
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, price, image, description) VALUES
('Sony WH-1000XM5 Wireless Headphones', 29990.00, 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&w=800&q=80', 'Industry leading noise cancellation, 30 hours battery life, premium sound quality.'),
('Apple Watch Series 9', 41900.00, 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=800&q=80', 'Advanced health sensors, brighter display, powerful S9 chip, carbon neutral aluminium case.'),
('Mechanical Gaming Keyboard', 12499.00, 'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&w=800&q=80', 'RGB backlit, tactile mechanical switches, aluminum frame, ergonomic design.'),
('Logitech MX Master 3S', 8995.00, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=800&q=80', 'Wireless performance mouse, ergonomic form factor, precise scrolling, customizable buttons.'),
('MacBook Air M2', 114900.00, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80', 'Supercharged by M2, incredibly thin design, all-day battery life, liquid retina display.'),
('Samsung Galaxy S24 Ultra', 129999.00, 'https://images.unsplash.com/photo-1605236453806-6ff36851218e?auto=format&fit=crop&w=800&q=80', 'Epic AI features, massive battery, 200MP camera, built-in S pen.');
