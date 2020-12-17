
SET AUTOCOMMIT = 0;
START TRANSACTION;

INSERT INTO 
	`rols` (`id`, `description`, `code`, `active`, `Deleted_at`) 
VALUES
	(1, 'Administrador', 'Admin', '1', NULL),
	(2, 'Vendedor', 'Seller', '1', NULL),
	(4, 'Administrador de inventario', 'InventoryManager', '1', NULL);
	

INSERT 
	INTO users (id, name, username, password, photo, active, created_at, last_login, rolID)
VALUES (
	'c4a67fb7-6d37-4609-ab04-858eb30f050e',
	'Admin',
	'Admin',
	'$2a$07$usesomesillystringforeOPDP9VCfaTl1aKeSkfq9n.hPkgfFeGC',
	NULL,
	1,
	NOW(),
	NOW(),
	1
);

INSERT INTO 
	`paymentmethods` (`PaymentMethodId`, `Description`, `Active`, `Deleted_at`) 
VALUES
	(1, 'Debido', '1', NULL),
	(2, 'Credito', '1', NULL),
	(3, 'Efectivo', '1', NULL);

COMMIT;


	