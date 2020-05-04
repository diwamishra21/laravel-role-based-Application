# laravel-role-based-Application

Laravel version- Laravel Framework 6.1.0
Description-
A laravel project with role based system
roles- admin, teacher, student
Admin- can create users
Teacher- can create exams
Student- can register for exams

setup-
download github code and extract
Copy .env.example file to .env and edit database credentials there
goto phpmyadmin and create a DB- laravel
Run composer install
Run php artisan key:generate
Run php artisan migrate --seed (it has some seeded data - see below)
php artisan serve
That's it: Go to http://localhost:8000/ login with default credentials-
email- admin@admin.com
password - password

routes-
C:\xampp\htdocs\e-proctoring\routes\web.php

left menu-
C:\xampp\htdocs\e-proctoring\resources\views\partials\menu.blade.php

constant values-
C:\xampp\htdocs\e-proctoring\resources\lang\en

# Deploying code on ec2 windows server

run command-
php artisan serve --host 0.0.0.0 --port 8000

Now goto ur public Ip and access ur project-
http://ec2-xxx-xxx-xxx-xxx.compute-1.amazonaws.com
(In AWS u have to allow 8000 and 80 and whatever port u want to access in inbound rules)

If port used is 8000
http://ec2-xxx-xxx-xxx-xxx.compute-1.amazonaws.com:8000