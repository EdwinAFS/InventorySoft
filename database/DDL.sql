SET AUTOCOMMIT = 0;
START TRANSACTION;

/* ROLS */

CREATE TABLE `rols` (
	`id` int(11) NOT NULL,
	`description` varchar(100) NOT NULL,
	`code` varchar(40) NOT NULL,
	`active` char(1) NOT NULL DEFAULT '1',
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `rols`
ADD PRIMARY KEY (`id`);

ALTER TABLE `rols`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 5;

/* USERS */

CREATE TABLE `users` (
	`id` varchar(36) NOT NULL,
	`name` varchar(200) NOT NULL,
	`username` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
	`password` varchar(200) NOT NULL,
	`photo` text DEFAULT NULL,
	`active` char(1) NOT NULL,
	`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`last_login` datetime DEFAULT NULL,
	`rolID` int(11) DEFAULT NULL,
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `username` (`username`),
ADD KEY `rolID` (`rolID`);

ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rolID`) REFERENCES `rols` (`id`);

/* CATEGORIES */

CREATE TABLE `categories` (
	`CategoriesId` int(11) NOT NULL,
	`Description` varchar(50) NOT NULL,
	`Active` char(1) NOT NULL DEFAULT '1',
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
ALTER TABLE `categories`
ADD PRIMARY KEY (`CategoriesId`);
ALTER TABLE `categories`
MODIFY `CategoriesId` int(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 4;
/* PRODUCTO */

CREATE TABLE `products` (
	`ProductId` int(11) NOT NULL,
	`Cod` varchar(50) NOT NULL,
	`Description` varchar(50) NOT NULL,
	`Img` text DEFAULT NULL,
	`Stock` int(11) NOT NULL DEFAULT 0,
	`PurchasePrice` float DEFAULT NULL,
	`SalePrice` float NOT NULL,
	`NumOfSales` int(11) DEFAULT 0,
	`Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`Active` char(1) NOT NULL DEFAULT '1',
	`FK_categoryId` int(11) DEFAULT NULL,
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `products`
ADD PRIMARY KEY (`ProductId`),
ADD KEY `FK_categoryId` (`FK_categoryId`);

ALTER TABLE `products`
MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`FK_categoryId`) REFERENCES `categories` (`CategoriesId`);

/* CUSTOMER */

CREATE TABLE `customers` (
	`CustomerId` int(11) NOT NULL,
	`Name` varchar(100) NOT NULL,
	`Identification` varchar(30) NOT NULL,
	`Email` varchar(250) NOT NULL,
	`Phone` varchar(30) DEFAULT NULL,
	`Address` varchar(250) NOT NULL,
	`Birthdate` date NOT NULL,
	`Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`Active` char(1) NOT NULL DEFAULT '1',
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
ALTER TABLE `customers`
ADD PRIMARY KEY (`CustomerId`);
ALTER TABLE `customers`
MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 9;
/* PAYMENT METHOD */

CREATE TABLE `paymentmethods` (
	`PaymentMethodId` int(11) NOT NULL,
	`Description` varchar(50) NOT NULL,
	`Active` char(1) NOT NULL DEFAULT '1',
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `paymentmethods`
ADD PRIMARY KEY (`PaymentMethodId`);

ALTER TABLE `paymentmethods`
MODIFY `PaymentMethodId` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 4;

/* SALE */

CREATE TABLE `sales` (
	`SaleId` varchar(36) NOT NULL,
	`Cod` varchar(50) NOT NULL,
	`Taxes` int(11) NOT NULL,
	`NetPay` decimal(13, 4) DEFAULT NULL,
	`Total` decimal(13, 4) DEFAULT NULL,
	`FK_customerId` int(11) NOT NULL,
	`FK_sellerId` varchar(36) NOT NULL,
	`Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`Active` char(1) NOT NULL DEFAULT '1',
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `sales`
ADD PRIMARY KEY (`SaleId`),
ADD KEY `FK_customerId` (`FK_customerId`),
ADD KEY `FK_sellerId` (`FK_sellerId`);

ALTER TABLE `sales`
ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`FK_customerId`) REFERENCES `customers` (`CustomerId`),
ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`FK_sellerId`) REFERENCES `users` (`id`);

/* SALEPRODUCT */

CREATE TABLE `saleproduct` (
	`SaleProductId` int(11) NOT NULL,
	`FK_SaleId` varchar(36) DEFAULT NULL,
	`FK_ProductId` int(11) DEFAULT NULL,
	`Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`Active` char(1) NOT NULL DEFAULT '1',
	`Deleted_at` timestamp NULL DEFAULT NULL,
	`ProductQuantity` int(11) DEFAULT NULL,
	`TotalPayment` decimal(13, 4) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `saleproduct`
ADD PRIMARY KEY (`SaleProductId`),
ADD KEY `FK_ProductId` (`FK_ProductId`);

ALTER TABLE `saleproduct`
MODIFY `SaleProductId` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `saleproduct`
ADD CONSTRAINT `saleproduct_ibfk_1` FOREIGN KEY (`FK_ProductId`) REFERENCES `products` (`ProductId`);

/* SALEPAYMENTMETHOD */

CREATE TABLE `salepaymentmethod` (
	`SalePaymentMethodId` int(11) NOT NULL,
	`FK_SaleId` varchar(36) NOT NULL,
	`FK_PaymentMethodId` int(11) NOT NULL,
	`Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
	`Active` char(1) NOT NULL DEFAULT '1',
	`TransactionCode` varchar(50) DEFAULT NULL,
	`Cash` decimal(13, 4) DEFAULT NULL,
	`CashBack` decimal(13, 4) DEFAULT NULL,
	`Deleted_at` timestamp NULL DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `salepaymentmethod`
ADD PRIMARY KEY (`SalePaymentMethodId`);

ALTER TABLE `salepaymentmethod`
MODIFY `SalePaymentMethodId` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;