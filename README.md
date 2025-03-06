Car Booking Website

Description

This PHP-based web application allows users to browse and book rental cars. It uses JSON files for
 data storage instead of a traditional database. Users can register, log in, and book cars for specific 
 time periods. Administrators have the ability to manage car listings and view all bookings.

Features

Guest Users

Browse available cars without logging in.

View car details including images, brand, type, passenger capacity, transmission type, and daily price.

Apply filters to search for cars based on:

Availability within a specific time range.

Transmission type (Automatic/Manual).

Passenger capacity.

Daily rental price.

Registered Users

Register and log in to book cars.

Book a car for a specified time period.

View their own past bookings (feature in development).

Log out securely.

Administrator Functions

Log in with a dedicated admin account.

Add new cars to the listing.

Edit existing car details.

Delete cars (removing related bookings as well).

View all bookings made by users.

Technology Stack

Backend: PHP (without frameworks)

Frontend: HTML, CSS (custom styles and optional CSS frameworks)

Data Storage: JSON files

Installation & Setup

Ensure you have a local server running (e.g., XAMPP, WAMP, or built-in PHP server).

Clone or download the project files.

Place the project folder in your server’s document root (e.g., htdocs for XAMPP).

Start the server and navigate to http://localhost/car-booking/.

Usage Guide

Register & Login

Navigate to the registration page.

Provide full name, email, and password.

Log in with your registered credentials.

Booking a Car

Browse available cars on the homepage.

Select a car to view its details.

If logged in, proceed with booking by selecting a time period.

A confirmation page will indicate success or failure (if the car is already booked for that time).

Admin Panel

Log in using the default admin credentials (admin@ikarrental.hu, admin).

Manage car listings (add/edit/remove cars).

View all user bookings.

Future Enhancements

Implement user booking history on their profile page.

Improve UI responsiveness and design.

Add email notifications for bookings.

Screenshots

(Add relevant screenshots of the homepage, booking page, admin panel, etc.)

License

This project is for educational purposes and does not include a license for commercial use.

Author
Omar Abdelkader