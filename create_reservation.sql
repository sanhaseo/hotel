DROP TABLE IF EXISTS reservation;

CREATE TABLE IF NOT EXISTS reservation (
reservation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
idUser INT UNSIGNED NOT NULL,
room_id INT UNSIGNED NOT NULL,
date CHAR(10) NOT NULL,
num_of_guests INT UNSIGNED NOT NULL,
card_type VARCHAR(11) NOT NULL,
card_number CHAR(16) NOT NULL,
PRIMARY KEY (reservation_id)
);