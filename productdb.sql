
CREATE DATABASE IF NOT EXISTS productdb;
USE productdb;

-- Users table
CREATE TABLE IF NOT EXISTS users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100),
  password VARCHAR(100),
  user_tel VARCHAR(20),
  user_adr VARCHAR(200)
);

-- Category table
CREATE TABLE IF NOT EXISTS category (
  id_category INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(50) NOT NULL
);

-- Products table
CREATE TABLE IF NOT EXISTS producttb (
  productid INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(100) NOT NULL,
  productOldPrice FLOAT,
  productNewPrice FLOAT,
  product_image VARCHAR(255),
  product_rate INT,
  Qte INT,
  product_description TEXT,
  product_category INT,
  FOREIGN KEY (product_category) REFERENCES category(id_category)
);

-- Reviews table
CREATE TABLE IF NOT EXISTS review (
  rev_id INT AUTO_INCREMENT PRIMARY KEY,
  prod_id INT,
  user_id INT,
  rate INT,
  commentaire TEXT,
  review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (prod_id) REFERENCES producttb(productid),
  FOREIGN KEY (user_id) REFERENCES users(id_user)
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  order_products TEXT,
  order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  order_total_Price FLOAT,
  order_Methode VARCHAR(50),
  Paypal_order_Id VARCHAR(100),
  FOREIGN KEY (user_id) REFERENCES users(id_user)
);

-- OrderProduct table
CREATE TABLE IF NOT EXISTS orderProduct (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  product_id INT,
  qte INT,
  FOREIGN KEY (order_id) REFERENCES orders(order_id),
  FOREIGN KEY (product_id) REFERENCES producttb(productid)
);

-- Hot Deals table
CREATE TABLE IF NOT EXISTS productHotDeal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  deal_description TEXT,
  FOREIGN KEY (product_id) REFERENCES producttb(productid)
);

-- User Activity table
CREATE TABLE user_activity (
  activity_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  category_id INT NOT NULL,
  product_id INT NOT NULL,
  activity_type VARCHAR(50) DEFAULT 'view',
  activity_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id_user),
  FOREIGN KEY (category_id) REFERENCES category(id_category),
  FOREIGN KEY (product_id) REFERENCES producttb(productid)
);


-- Admins table
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- Product Views table
CREATE TABLE product_views (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT,
  view_time INT, -- seconds e time thakbe
  viewed_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- View Time Tracking table
CREATE TABLE IF NOT EXISTS view_time (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  product_id INT,
  view_duration INT DEFAULT 0,
  last_view TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id_user),
  FOREIGN KEY (product_id) REFERENCES producttb(productid)
);


