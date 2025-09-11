# GlobalNationsDB
A comprehensive PHP web application for managing and exploring global country data, languages, and geographical information.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Database Schema](#database-schema)
- [Installation](#installation)
- [File Structure](#file-structure)
- [Technologies Used](#technologies-used)

## Overview
The Countries Database is a web-based application that allows users to manage and explore information about countries, languages, and continents around the world. The system provides comprehensive CRUD (Create, Read, Update, Delete) operations for managing global data with an intuitive user interface.

## Features
### Country Management
- **Add New Countries**: Complete country profile creation with population, area, GDP, and flag data
- **View Country Details**: Comprehensive country information display with flags and statistics
- **Language Integration**: Track languages spoken in each country with speaker counts and percentages

### Language Management
- **View All Languages**: Browse and sort global language database
- **Add/Edit Languages**: Manage language families, speaker counts, and official status
- **Delete Languages**: Remove languages with referential integrity checks

### Data Analysis
- **Continental Analysis**: Identify continents without registered countries
- **Language Statistics**: View global speaker distributions and official language status
- **Sorting & Filtering**: Dynamic data sorting by multiple criteria

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
- Countries belong to continents (1:N)
- Countries can have multiple languages (N:M)
- Languages can be spoken in multiple countries (N:M)

## Installation
### Prerequisites
- PHP 7.4 or higher
- MySQL/MariaDB database server
- Web server (Apache/Nginx)
- Modern web browser

### Getting Started

### Adding a Country
1. Click "Add New Country" from the main menu
2. Fill in required information:
   - Country ID and name
   - Capital city
   - Select continent
   - Population and area data
3. Optionally add economic data (GDP, independence year)
4. Configure languages spoken with speaker counts and percentages
5. Submit the form to save

### Managing Languages
- **View Languages**: Browse all languages with sorting options
- **Edit Language**: Update language family, speaker counts, or official status
- **Delete Language**: Remove languages (checks for country dependencies)

## File Structure
```
countries-database/
├── mainmenu.php          # Main navigation
├── connecttodb.php       # Database connection configuration
├── countries.php         # Database schema and sample data
├── addcountry.php        # Country creation form and logic
├── selectcountry.php     # Country details viewer
├── showlanguages.php     # Language listing with sorting
├── editlanguage.php      # Language editing interface
├── deletelanguage.php    # Language deletion with validation
├── displaycontinents.php # Continental analysis tool
└── mainmenu.css          # Application styling
```

### Key Components
**Core Files:**
- `mainmenu.php` - Application entry point and navigation
- `connecttodb.php` - Centralized database connection management
- `countries.php` - Database schema definition and sample data

**Country Management:**
- `addcountry.php` - Comprehensive country addition with language support
- `selectcountry.php` - Detailed country information display

**Language Management:**
- `showlanguages.php` - Language database browser with sorting
- `editlanguage.php` - Language information editor
- `deletelanguage.php` - Safe language removal with dependency checks

**Analysis Tools:**
- `displaycontinents.php` - Identifies continents without countries

## Technologies Used
- **Backend**: PHP 7.4+ with MySQLi
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Styling**: Google Fonts (Quicksand), Custom CSS
- **Architecture**: MVC-style separation of concerns

## License
This project is open source and available under the [MIT License](LICENSE).

---

**Built with ❤️ for global data enthusiasts**
