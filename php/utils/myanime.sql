CREATE TABLE users (
  id INT(11) AUTO_INCREMENT NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  birthdate DATE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  pdw VARCHAR(90) NOT NULL,
  admin TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)  
);

CREATE TABLE messaging (
  id_messaging INT AUTO_INCREMENT,
  message_content VARCHAR(255),
  message_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  id INT,
  PRIMARY KEY (id_messaging),
  FOREIGN KEY (id) REFERENCES users(id)
);

CREATE TABLE orders (
  id_order INT AUTO_INCREMENT,
  order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  order_price DECIMAL(10,2),
  delivery_street VARCHAR(100),
  delivery_number VARCHAR(100),
  delivery_city VARCHAR(100),
  id_user INT,
  PRIMARY KEY (id_order),
  FOREIGN KEY (id_user) REFERENCES users(id_user)
);

CREATE TABLE order_product (
  order_id INT,
  product_id INT,
  PRIMARY KEY (order_id, product_id),
  FOREIGN KEY (order_id) REFERENCES orders(id_order),
  FOREIGN KEY (product_id) REFERENCES product(id_product)
);

CREATE TABLE product (
  id_product INT AUTO_INCREMENT,
  product_name VARCHAR(100),
  product_description VARCHAR(100),
  product_price DECIMAL(10,2),
  product_image VARCHAR(100) DEFAULT 'luffy-taro.jpg',
  PRIMARY KEY (id_product)
);

CREATE TABLE category (
  id_category INT AUTO_INCREMENT,
  category_name VARCHAR(50),
  product_id INT,
  PRIMARY KEY (id_category),
  FOREIGN KEY (product_id) REFERENCES product(id_product)
);
