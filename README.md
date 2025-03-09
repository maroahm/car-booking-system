# Car Booking Website

## Description

This PHP-based web application allows users to browse and book rental cars. It uses JSON files for data storage instead of a traditional database. Users can register, log in, and book cars for specific time periods. Administrators have the ability to manage car listings and view all bookings.

## Features

### Guest Users
- Browse available cars without logging in.
- View car details including images, brand, type, passenger capacity, transmission type, and daily price.
- Apply filters to search for cars based on:
  - Availability within a specific time range.
  - Transmission type (Automatic/Manual).
  - Passenger capacity.
  - Daily rental price.

### Registered Users
- Register and log in to book cars.
- Book a car for a specified time period.
- View their own past bookings (feature in development).
- Log out securely.

### Administrator Functions
- Log in with a dedicated admin account.
- Add new cars to the listing.
- Edit existing car details.
- Delete cars (removing related bookings as well).
- View all bookings made by users.

## Technology Stack
- **Backend**: PHP (without frameworks)
- **Frontend**: HTML, CSS (custom styles and optional CSS frameworks)
- **Data Storage**: JSON files

## Installation & Setup
1. Ensure you have a local server running (e.g., XAMPP, WAMP, or built-in PHP server).
2. Clone or download the project files.
3. Place the project folder in your server’s document root (e.g., `htdocs` for XAMPP).
4. Start the server and navigate to `http://localhost/car-booking/`.

## Usage Guide
![HomePage](images/screenshots/Home_page.png)
### Register & Login
1. Navigate to the registration page.
![Registeration page](images/screenshots/register.png)
2. Provide full name, email, and password.
![Register](images/screenshots/registration.png)
3. Log in with your registered credentials.
![Login](images/screenshots/Login_with_registered_account.png)


### Booking a Car
1. Browse available cars on the homepage.
![Home Page After Login](images/screenshots/registered_home_page.png)
2. Select a car to view its details.
![Car Details Page](images/screenshots/car_details_page.png)
3. If logged in, proceed with booking by selecting a time period.
![Booking a car](images/screenshots/booking_car_page.png)
![Choosing date](images/screenshots/choose_date.png)
4. A confirmation page will indicate success or failure (if the car is already booked for that time).
![Booking successful](images/screenshots/booking_successful.png)
  Or it could fail if car is already booked for that time
![bookinf failed](images/screenshots//booking_failed.png)

### Admin Panel
1. Log in using the default admin credentials (`admin@ikarrental.hu`, `admin`).
![login with admin account](images/screenshots/Login_page.png)
2. Manage car listings (add/edit/remove cars).
![admin panel](images/screenshots/admin_panel.png)

## Future Enhancements
- Implement user booking history on their profile page.
- Improve UI responsiveness and design.
- Add email notifications for bookings.
- implement all booking history to be available for admin.

## Screenshots
### using filters to choose from cars
1. set the price range.
![price setting](images/screenshots/price_filter_check.png)
2. press the filter button.
![price filteration](images/screenshots/after_price_filtration.png)

### Admin Panel: Adding a Car
1. After Logging in using the default admin credentials (`admin@ikarrental.hu`, `admin`).
![admin Panel](images/screenshots/admin_panel.png)
2. press add new car buttton.
![new car form](images/screenshots/new_car_details.png)
3. enter the new car details and import the cars image.
![Registering new car](images/screenshots/register_car_details.png)
4. choose Car image.
![Car Image](images/screenshots/choose_car_image.png)
5. Press Add car to save changes.
![Car](images/screenshots/save_new_car.png)
![Csr saved](images/screenshots/new_car_added.png) 

### Admin Panel: Editing a Car
1. Choose a car and press edit.
![Admin Panel](images/screenshots/new_car_added.png.png)
2. Make Changes(Ex: price).
![Car editing](images/screenshots/edit_car.png)
![Car editing](images/screenshots/change_car.png)
3. Press save and Car details are updated.
![Car after editing](images/screenshots/changes_applied.png)

### Admin Panel: Deleting a Car
- Choose a car and press delete button.
![Cars before](images/screenshots/changes_applied.png)
![Cars after](images/screenshots/deletation.png)
- All changes are visible in user panel(HomePage).
![HomePage](images/screenshots/visible_changes.png)
## License
This project is for educational purposes and does not include a license for commercial use.

## Author
Your Name

