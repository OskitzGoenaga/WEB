use db_erronka2;

create user "kudeatzailea"@"%" identified by "1234";
grant all privileges on db_erronka2.* to "kudeatzailea"@"%";

INSERT INTO hornitzaileak (enpresa, telefonoa, email) VALUES
('TechSuply', '600111222', 'contact@techsuply.com'),
('Mendi Elektronika', '688223344', 'info@mendielektronika.eus'),
('GauTech', '645556677', 'support@gau-tech.com'),
('Ibertronik', '912345678', 'ventas@ibertronik.es'),
('EuskHardware', '943112233', 'info@euskhardware.eus'),
('DigitalBase', '622998877', 'sales@digitalbase.com'),
('NorteComponentes', '944556644', 'contact@nortecomp.es'),
('BlueWave Tech', '677889900', 'info@bluewave-tech.com'),
('BasqueDevices', '699334455', 'service@basquedevices.eus'),
('ElectroPoint', '611778899', 'sales@electropoint.com')
;


INSERT INTO produktuak (mota, izena, prezioa, stock, argazkia, hornitzaile_id) VALUES
('Ordenagailua', 'Acer Aspire 5', 549.99, 12, 'AcerAspire5.jpg', 4),
('Tablet', 'Apple iPad mini 6', 649.00, 8, 'Apple iPad mini 6.jpg', 1),
('Ordenagailua', 'Apple MacBook Air', 1199.00, 5, 'Apple Macbook Air.jpg', 5),
('Tablet', 'Apple iPad 10.2', 389.00, 10, 'AppleiPad10.2.jpg', 6),
('Telefonoa', 'iPhone 14 Pro', 1299.00, 7, 'iphone14pro.jpg', 10),
('Ordenagailua', 'Lenovo ThinkPad T14 Gen 2', 999.00, 6, 'Lenovo ThinkPad T14 Gen 2.jpg', 7),
('Ordenagailua', 'HP EliteBook 840 G7', 1100.00, 4, 'HP EliteBook 840 G7.jpg', 7),
('Telefonoa', 'Samsung Galaxy S21', 499.00, 15, 'Samsung Galaxy S21.jpg', 8),
('Telefonoa', 'Samsung Galaxy S23 Ultra', 1199.00, 9, 'Samsung Galaxy S23 Ultra.jpg', 9),
('Tablet', 'Samsung Galaxy Tab S9', 849.00, 5, 'Samsung Galaxy Tab S9.jpg', 6),
('Telefonoa', 'Google Pixel 8 Pro', 999.00, 6, 'Google Pixel 8 Pro.jpg', 3),
('Ordenagailua', 'Microsoft Surface Pro 9', 1350.00, 3, 'Microsoft Surface Pro 9.jpg', 4)
;



