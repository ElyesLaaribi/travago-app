-- Create the travago database
CREATE DATABASE IF NOT EXISTS travago;

--------------------------------------------------------------------------------------------------------------------------------------
-- create the companies table
CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--------------------------------------------------------------------------------------------------------------------------------------
-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    isVerified BOOLEAN DEFAULT FALSE,
    address VARCHAR(255),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_type ENUM('admin', 'user', 'agency') DEFAULT 'user' NOT NULL,
    company_id INT,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

--------------------------------------------------------------------------------------------------------------------------------------
-- create the trips table
CREATE TABLE IF NOT EXISTS trips (
    Id int(7) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Destination varchar(255) NOT NULL,
    Flight_number int(10) NOT NULL,
    Number_of_seats int(7) NOT NULL,
    Plan varchar(255) NOT NULL,
    Departure_date date NOT NULL,
    Arrival_date date NOT NULL,
    Hotel varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    company_id int(7) NOT NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

--------------------------------------------------------------------------------------------------------------------------------------
-- create the vehicles table
CREATE TABLE IF NOT EXISTS vehicles (
    id int(7) NOT NULL AUTO_INCREMENT,
    brand varchar(255) NOT NULL,
    model varchar(255) NOT NULL,
    number_of_seats int(7) NOT NULL,
    plate_number varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    company_id int(7),
    availablabity BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (company_id) REFERENCES companies(id),
    PRIMARY KEY (Id)
);

--------------------------------------------------------------------------------------------------------------------------------------
-- create the tours table
CREATE TABLE IF NOT EXISTS tours (
    id int(7) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    program varchar(255) NOT NULL,
    desciption varchar(255) NOT NULL,
    destination varchar(255) NOT NULL,
    number_of_seats int(7) NOT NULL,
    departure_date date NOT NULL,
    arrival_date date NOT NULL,
    accomodation varchar(255) NOT NULL,
    transport_type varchar(255) NOT NULL,
    price int(7) NOT NULL,
    company_id int(7) NOT NULL REFERENCES companies(id)
);

--------------------------------------------------------------------------------------------------------------------------------------
-- Seed 
-- Insert data into the companies table
INSERT INTO
    companies (name, email, phone, address)
VALUES
    (
        'TravaGo',
        'contact@TravaGo.com',
        '+1234567890',
        '123 Main Street, City, Country'
    ),
    (
        'ExploreMore',
        'contact@exploremore.com',
        '+9876543210',
        '456 Elm Street, Town, Country'
    );

-- Insert data into the users table
INSERT INTO
    users (
        username,
        email,
        password,
        address,
        phone,
        user_type,
        company_id
    )
VALUES
    (
        'Hamma Terbah',
        'hamma@travago.com',
        'password123',
        '789 Oak Avenue, City, Country',
        '+1122334455',
        'admin',
        1
    ),
    (
        'Elyes',
        'elyes@travago.com',
        'password123',
        '789 Oak Avenue, City, Country',
        '+1122334455',
        'admin',
        1
    ),
    (
        'Nermine',
        'nermine@travago.com',
        'password123',
        '789 Oak Avenue, City, Country',
        '+1122334455',
        'admin',
        1
    ),
    (
        'Mariem',
        'mariem@travago.com',
        'password123',
        '789 Oak Avenue, City, Country',
        '+1122334455',
        'admin',
        1
    ),
    (
        'Nesrine',
        'nesrine@travago.com',
        'password123',
        '789 Oak Avenue, City, Country',
        '+1122334455',
        'admin',
        1
    ),
    (
        'jane_smith',
        'jane@exploremore.com',
        'pass456',
        '567 Pine Street, Town, Country',
        '+9988776655',
        'user',
        2
    ),
    (
        'john_smith',
        'john@exploremore.com',
        'pass456',
        '567 Pine Street, Town, Country',
        '+9988776655',
        'user',
        2
    );

-- Insert data into the trips table
INSERT INTO
    trips (
        Destination,
        Flight_number,
        Number_of_seats,
        Plan,
        Departure_date,
        Arrival_date,
        Hotel,
        company_id
    )
VALUES
    (
        'Paris',
        12345,
        50,
        'Full Board',
        '2024-04-15',
        '2024-04-20',
        'Paris Hotel',
        1
    ),
    (
        'Tokyo',
        54321,
        40,
        'Half Board',
        '2024-05-10',
        '2024-05-15',
        'Tokyo Inn',
        2
    );

-- Insert data into the vehicles table
INSERT INTO
    vehicles (
        brand,
        model,
        number_of_seats,
        plate_number,
        company_id
    )
VALUES
    ('Toyota', 'Camry', 5, 'ABC123', 1),
    ('Ford', 'Explorer', 7, 'XYZ789', 2);

-- Insert data into the tours table
INSERT INTO
    tours (
        program,
        desciption,
        destination,
        number_of_seats,
        departure_date,
        arrival_date,
        accomodation,
        transport_type,
        price,
        company_id
    )
VALUES
    (
        'European Adventure',
        'Explore the best of Europe!',
        'London, Paris, Rome',
        20,
        '2024-06-01',
        '2024-06-15',
        'Luxury Hotels',
        'Bus',
        2000,
        1
    ),
    (
        'Asian Expedition',
        'Discover the wonders of Asia!',
        'Tokyo, Beijing, Bangkok',
        15,
        '2024-07-01',
        '2024-07-15',
        'Resorts',
        'Plane',
        2500,
        2
    );