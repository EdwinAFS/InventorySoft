
/* ROLS */

CREATE TABLE rols (
  id int(11) NOT NULL,
  description varchar(100) NOT NULL,
  code varchar(40) NOT NULL,
  active char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE users
ADD PRIMARY KEY (id);

ALTER TABLE rols
MODIFY id int(11) NOT NULL AUTO_INCREMENT;

/* USERS */

CREATE TABLE users (
  id varchar(36) NOT NULL,
  name varchar(200) NOT NULL,
  username varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  password varchar(200) NOT NULL,
  photo text DEFAULT NULL,
  active char(1) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  last_login datetime DEFAULT NULL,
  rolID int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE users
ADD PRIMARY KEY (id),
ADD UNIQUE KEY username (username),
ADD KEY rolID (rolID);

ALTER TABLE users 
ADD FOREIGN KEY rolID REFERENCES rols( id );

/* CATEGORIES */

CREATE TABLE Categories(
	CategoriesId int AUTO_INCREMENT,
	Description VARCHAR(50) NOT NULL,
	Active CHAR(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (CategoriesId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* PRODUCTO */

CREATE TABLE Products(
	ProductId int AUTO_INCREMENT,
	Cod VARCHAR(50) NOT NULL,
	Description VARCHAR(50) NOT NULL,
	Img text DEFAULT NULL,
	Stock int NOT NULL DEFAULT 0,
	PurchasePrice FLOAT,
	SalePrice FLOAT NOT NULL,
	NumOfSales INT DEFAULT 0,
	Created_at TIMESTAMP DEFAULT now,
	Active CHAR(1) NOT NULL DEFAULT 1,
	FK_categoryId int,
	PRIMARY KEY (productId)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE Products ADD FOREIGN KEY (FK_CategoryId) REFERENCES Categories(CategoriesId);

ALTER TABLE Products ADD COLUMN delete_at timestamp null;

ALTER TABLE Products ALTER NumOfSales SET DEFAULT 0;

/* CUSTOMER */

CREATE TABLE Customers(
	CustomerId int AUTO_INCREMENT,
	Name VARCHAR(100) NOT NULL,
	Identification VARCHAR(30) NOT NULL,
	Email VARCHAR(250) NOT NULL,
	Phone VARCHAR(30) NULL,
	Address VARCHAR(250) NOT NULL,
	Birthdate DATE NOT NULL, 
	Created_at TIMESTAMP DEFAULT now(),
	Active CHAR(1) NOT NULL DEFAULT 1,
	Deleted_at TIMESTAMP NULL,

	PRIMARY KEY (CustomerId)
); 


