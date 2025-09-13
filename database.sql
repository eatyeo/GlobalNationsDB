-- Countries of the World Database Schema
-- Clean SQL file for importing via phpMyAdmin

-- Create continent table
CREATE TABLE continent (
    continentid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

-- Create country table
CREATE TABLE country (
    countryid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    capital VARCHAR(100),
    continentid INT,
    population BIGINT,
    area_km2 DECIMAL(10,2),
    gdp_billions DECIMAL(10,2),
    independence_year INT,
    flag_url VARCHAR(255),
    FOREIGN KEY (continentid) REFERENCES continent(continentid)
);

-- Create language table
CREATE TABLE language (
    languageid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    language_family VARCHAR(100),
    speakers_worldwide BIGINT,
    official CHAR(1) DEFAULT 'N'
);

-- Create country_language junction table
CREATE TABLE country_language (
    relationid INT PRIMARY KEY AUTO_INCREMENT,
    countryid INT,
    languageid INT,
    speakers_in_country BIGINT,
    percentage_of_population DECIMAL(5,2),
    official_status CHAR(1) DEFAULT 'N',
    date_recorded DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (countryid) REFERENCES country(countryid),
    FOREIGN KEY (languageid) REFERENCES language(languageid)
);

-- Create religion table (optional expansion)
CREATE TABLE religion (
    religionid INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50)
);

-- Create country_religion junction table
CREATE TABLE country_religion (
    countryid INT,
    religionid INT,
    percentage DECIMAL(5,2),
    PRIMARY KEY (countryid, religionid),
    FOREIGN KEY (countryid) REFERENCES country(countryid),
    FOREIGN KEY (religionid) REFERENCES religion(religionid)
);

-- Insert sample data for continents
INSERT INTO continent (name, description) VALUES 
('Asia', 'The largest continent by both area and population'),
('Africa', 'The second largest continent'),
('North America', 'Located in the northern hemisphere'),
('South America', 'Located in the southern hemisphere'),
('Antarctica', 'The southernmost continent'),
('Europe', 'Located in the northern hemisphere'),
('Australia/Oceania', 'Includes Australia and Pacific islands');

-- Insert sample data for languages
INSERT INTO language (name, language_family, speakers_worldwide, official) VALUES 
('English', 'Germanic', 1500000000, 'Y'),
('Mandarin Chinese', 'Sino-Tibetan', 1100000000, 'Y'),
('Spanish', 'Romance', 500000000, 'Y'),
('French', 'Romance', 280000000, 'Y'),
('Arabic', 'Semitic', 420000000, 'Y'),
('Russian', 'Slavic', 260000000, 'Y'),
('Portuguese', 'Romance', 260000000, 'Y'),
('German', 'Germanic', 100000000, 'Y');

-- Insert sample countries
INSERT INTO country (name, capital, continentid, population, area_km2, gdp_billions, independence_year, flag_url) VALUES 
('United States', 'Washington D.C.', 3, 331000000, 9833517.00, 23315.00, 1776, 'https://flagcdn.com/us.svg'),
('China', 'Beijing', 1, 1439323776, 9596961.00, 14342.00, NULL, 'https://flagcdn.com/cn.svg'),
('Canada', 'Ottawa', 3, 37742154, 9984670.00, 1736.00, 1867, 'https://flagcdn.com/ca.svg'),
('Brazil', 'Brasília', 4, 212559417, 8515767.00, 1869.00, 1822, 'https://flagcdn.com/br.svg'),
('United Kingdom', 'London', 6, 67886011, 243610.00, 2829.00, NULL, 'https://flagcdn.com/gb.svg'),
('France', 'Paris', 6, 65273511, 551695.00, 2716.00, NULL, 'https://flagcdn.com/fr.svg'),
('Germany', 'Berlin', 6, 83783942, 357114.00, 3846.00, NULL, 'https://flagcdn.com/de.svg'),
('Japan', 'Tokyo', 1, 126476461, 377930.00, 4231.00, NULL, 'https://flagcdn.com/jp.svg');

-- Insert sample country-language relationships
INSERT INTO country_language (countryid, languageid, speakers_in_country, percentage_of_population, official_status) VALUES 
(1, 1, 280000000, 85.0, 'Y'),
(2, 2, 1050000000, 73.0, 'Y'),
(3, 1, 30000000, 80.0, 'Y'),
(3, 4, 7500000, 20.0, 'Y'),
(4, 7, 210000000, 99.0, 'Y'),
(5, 1, 67000000, 99.0, 'Y'),
(6, 4, 64000000, 98.0, 'Y'),
(7, 8, 82000000, 98.0, 'Y'),
(8, 1, 30000000, 24.0, 'N');