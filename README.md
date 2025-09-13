# GlobalNationsDB
A comprehensive PHP web application for managing and exploring global country data, languages, and geographical information.

## Overview
GlobalNationsDB is a web-based application that allows users to manage and explore information about countries, languages, and continents. It supports full CRUD (Create, Read, Update, Delete) operations with a clean, responsive UI.

## Features
### Country Management
- Add new countries with details (population, area, GDP, flag, etc.)
- View comprehensive country profiles
- Associate languages with countries (with speaker counts & percentages)

### Language Management
- Browse and sort all languages
- Add or edit language details (family, speakers, status)
- Safely delete languages with dependency checks

### Data Analysis
- Identify continents with no registered countries
- Generate global language statistics
- Filter and sort data dynamically

### User Interface
- Responsive design with Google Fonts (Quicksand)
- Scrollable containers for large datasets
- Form validation and error handling
- Clean, modern CSS styling

## Database Schema
### Core Tables
- **continent**: Continental data (Asia, Europe, Africa, etc.)
- **country**: Country information including demographics and economics
- **language**: Global language data with speaker statistics
- **country_language**: Many-to-many relationship between countries and languages

### Key Relationships
- Continents → Countries (1:N)
- Countries ↔ Languages (N:M)

## Installation
### Prerequisites
- PHP 7.4 or higher
- MySQL or MariaDB
- Web server (Apache or Nginx)
- Browser (Chrome/Firefox/Edge/Safari)

### Setup Instructions
1. Clone this repository:
`git clone https://github.com/yourusername/GlobalNationsDB.git`
`cd GlobalNationsDB`

2. Import the database schema:
- Open `countries.php` (or a dedicated .sql file if you export one).
- Run the SQL in your MySQL/MariaDB server to create the required tables.

3. Configure your database connection:
- Open `connecttodb.php`
- Update credentials:

4. Place the project inside your web server’s document root:
XAMPP (Windows/macOS/Linux):
- Copy folder into `htdocs/GlobalNationsDB`
- Access via: `http://localhost/GlobalNationsDB/mainmenu.php`
Native Apache/Nginx:
- Point your virtual host or site config to the project folder.

### Usage
- Go to `mainmenu.php` to access the application.
- From the main menu, you can:
- Add new countries
- Browse and manage languages
- Explore continents and statistics

## File Structure
```
GlobalNationsDB/
├── mainmenu.php          # Main navigation
├── connecttodb.php       # Database connection config
├── countries.php         # Database schema + sample data
├── addcountry.php        # Add new countries
├── selectcountry.php     # View country details
├── showlanguages.php     # Browse languages
├── editlanguage.php      # Edit languages
├── deletelanguage.php    # Delete languages
├── displaycontinents.php # Continental analysis
└── mainmenu.css          # Styling
```

## Technologies Used
- Backend: PHP 7.4+ (MySQLi)
- Database: MySQL/MariaDB
- Frontend: HTML5, CSS3, JavaScript
- Styling: Google Fonts (Quicksand), Custom CSS
- Architecture: MVC-inspired separation

## Deployment
To make your project publicly accessible:
1. Shared Hosting (Beginner-Friendly)
- Most shared hosting providers (Hostinger, Bluehost, DreamHost, etc.) support PHP + MySQL.
- Upload all files to your hosting account’s /public_html folder.
- Import your database via phpMyAdmin or MySQL CLI.

2. VPS / Cloud Hosting (Advanced)
- Use a provider (DigitalOcean, AWS, Linode).
- Install Apache/Nginx + PHP + MySQL.
- Set up a virtual host to serve GlobalNationsDB.

3. Local Development
- Use XAMPP, MAMP, or Laragon to run the project locally.
- Access via `http://localhost/GlobalNationsDB.`
