DROP TABLE IF EXISTS room;
DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS users;

CREATE TABLE room (
	room_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	room_name VARCHAR(50) NOT NULL,
	room_desc VARCHAR(200) NOT NULL,
	room_img VARCHAR(50) NOT NULL,
	capacity INT UNSIGNED NOT NULL,
	price DECIMAL(5,2) UNSIGNED NOT NULL,
	PRIMARY KEY (room_id)
);

CREATE TABLE users (
	user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	reg_date TIMESTAMP NOT NULL,
	PRIMARY KEY (user_id)
);

CREATE TABLE reservation (
	reservation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	user_id INT UNSIGNED NOT NULL,
	room_id INT UNSIGNED NOT NULL,
	reservation_date CHAR(10) NOT NULL,
	num_of_guests INT UNSIGNED NOT NULL,
	card_type VARCHAR(11) NOT NULL,
	card_number CHAR(16) NOT NULL,
	PRIMARY KEY (reservation_id)
);

INSERT INTO room (room_name, room_desc, room_img, capacity, price)
VALUES 
	("Red Room", "This is a red room.", "image/room_r.jpg", 6, 59.99), 
	("Orange Room", "This is a orange room.", "image/room_o.jpg", 4, 179.49),
	("Green Room", "This is a green room.", "image/room_gr.jpg", 4, 88.49),
	("Gold Room", "This is a gold room.", "image/room_go.jpg", 1, 199.99),
	("Purple Room", "This is a purple room.", "image/room_p.jpg",2, 120.00);