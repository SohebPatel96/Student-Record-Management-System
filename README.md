Student Record Management System

This project aims to simplify the management of student records through a user-friendly system. The application provides fundamental features like creating new student profiles, retrieving existing records, updating information, deleting entries, and conducting efficient searches within the database.

Key Features:

Create: Add new student profiles effortlessly.

Read: Retrieve and view existing records with ease.

Update: Modify and update student information as needed.

Delete: Remove entries securely from the database.

Search: Seamlessly search and filter student data for quick access.


Technical Details:
The project employs the repository pattern to establish communication with the database. The entire system operates through APIs, ensuring a smooth and streamlined experience for users. As of now, there is no graphical user interface (UI) interaction, making it ideal for backend-focused applications.



I am attaching the postman collection with this email and link to the test : https://drive.google.com/file/d/1HI3quKi5vWDzBt8WasHX3w6yTgDDpW9E/view?usp=sharing


Following are the steps to run the project:

composer install

php artisan migrate

php artisan command:populate_countries

A default user with following credentials will be created

email        :  msohebp@gmail.com

password : 123456
