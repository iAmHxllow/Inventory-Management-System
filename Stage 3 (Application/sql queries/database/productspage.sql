-- Create the products table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    buying_price DECIMAL(10, 2),
    quantity INT,
    unit VARCHAR(50),
    expiry_date DATE,
    threshold_value INT,
    image_path VARCHAR(255)
);

