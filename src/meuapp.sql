-- create database
CREATE DATABASE IF NOT EXISTS meubanco;
USE meubanco;

-- create table
CREATE TABLE IF NOT EXISTS products (
    product_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(50),
    price DOUBLE
) Engine = InnoDB;

-- insert datas
INSERT INTO products(product_name, price) VALUES ('Virtual Private Servers', '5.00');
INSERT INTO products(product_name, price) VALUES ('Managed Databases', '15.00');
INSERT INTO products(product_name, price) VALUES ('Block Storage', '10.00');
INSERT INTO products(product_name, price) VALUES ('Managed Kubernetes', '60.00');
INSERT INTO products(product_name, price) VALUES ('Load Balancer', '10.00');