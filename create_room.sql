DROP TABLE IF EXISTS room;

CREATE TABLE IF NOT EXISTS room (
room_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
room_name VARCHAR(20) NOT NULL,
room_desc VARCHAR(200) NOT NULL,
room_img VARCHAR(20) NOT NULL,
capacity INT UNSIGNED NOT NULL,
price DECIMAL(5,2) UNSIGNED NOT NULL,
PRIMARY KEY (room_id)
);


INSERT INTO room
( room_name, room_desc, room_img, capacity, price )
VALUES 
( "Red Room", "This is a red room.", "image/room_r.jpg", 6, 59.99 ), 
( "Orange Room", "This is a orange room.", "image/room_o.jpg", 4, 179.49 ),
( "Green Room", "This is a green room.", "image/room_gr.jpg", 4, 88.49 ),
( "Gold Room", "This is a gold room.", "image/room_go.jpg", 1, 199.99 ),
( "Purple Room", "This is a purple room.", "image/room_p.jpg",2, 120.00 );