# Anthony's Fast Food — Staff & Roster Management System

A PHP and MySQL web application developed as a practical database and backend project. The application runs locally with XAMPP and demonstrates staff administration, authentication, authorisation, product management, and roster availability workflows.

## Portfolio highlights

- PHP server-side application
- MySQL / MariaDB relational database
- Session-based authentication
- Password hashing and verification
- Role-based access for staff and management users
- Prepared SQL statements
- Staff and product create, read, update, and delete workflows
- Roster and employee availability management
- Bootstrap responsive interface
- Input validation and escaped HTML output

## Main application

The portfolio application is located in:

    anthonyfastfood/part2/

The repository also contains earlier exercises and XAMPP learning files. The part2 directory represents the most complete version of the staff-management application.

## Requirements

- Windows with XAMPP, or another Apache/PHP/MySQL environment
- PHP with mysqli enabled
- MySQL or MariaDB
- A modern web browser

## Local setup with XAMPP

1. Clone or copy this repository into the XAMPP htdocs directory.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Create a local database named fastfood.
4. Review and import the database schema supplied in anthonyfastfood/Anthony_fastfood.sql or the setup files under anthonyfastfood/part2.
5. Confirm the local connection settings in anthonyfastfood/part2/db.php.
6. Open the application at:

       http://localhost/htdocs/anthonyfastfood/part2/

   If the repository contents are copied directly into C:\xampp\htdocs rather than an htdocs subfolder, use:

       http://localhost/anthonyfastfood/part2/

## Security notes

This repository is intended as a local learning and portfolio project, not as a production deployment.

- Environment files, logs, and local secrets must not be committed.
- Use unique credentials rather than sample accounts before deployment.
- Keep database credentials outside source control in a production environment.
- Review authorisation on every administrative page before internet deployment.
- Add CSRF protection, secure cookie settings, and production error handling before public hosting.

## Key source files

- anthonyfastfood/part2/login.php — staff authentication
- anthonyfastfood/part2/auth.php — session and role checks
- anthonyfastfood/part2/availability.php — roster availability workflow
- anthonyfastfood/part2/staff_list.php — staff records
- anthonyfastfood/part2/product_create.php — product creation
- anthonyfastfood/part2/product_edit.php — product updates
- anthonyfastfood/part2/db.php — local MySQL connection

## Author

Madoka Thomson  
Sydney, Australia  
Japanese / English bilingual technical professional
