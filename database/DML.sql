INSERT INTO 
	rols (id, description, code, active)
VALUES 
	(1, 'Administrador', 'Admin', 1),
	(2, 'Vendedor', 'Seller', 1);
	(2, 'Administrador de inventario', 'inventoryManager', 1);
	

INSERT 
	INTO users (id, name, username, password, photo, active, created_at, last_login, rolID)
VALUES (
	'c4a67fb7-6d37-4609-ab04-858eb30f050e',
	'Admin',
	'Admin',
	'$2a$07$usesomesillystringforeN7/2NBfGxbAuv02IPrTFBImFJd5PJ1m',
	NULL,
	1,
	'2020-09-11 22:38:16',
	'2020-09-15 00:56:40',
	1
);

INSERT INTO 
	paymentmethods (PaymentMethodId, description, active)
VALUES 
	(NULL, 'Debido', 1),
	(NULL, 'Credito', 1),
	(NULL, 'Efectivo', 1);

	