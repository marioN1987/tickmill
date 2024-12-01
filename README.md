# Instructions

#### Open terminal and write:

1. git clone git@github.com:marioN1987/tickmill.git
2. composer install => composer installs dependencies which are inside composer.json
3. npm ci => install packages from package.json
4. copy/paste .env.example and rename to .env file and update with your database credentials like db_name, db_username and db_pass
5. generate app key by typing => php artisan key:generate
6. php artisan migrate => creates tables and relationships, but first will ask to create database if doesn't exist.
7. php artisan db:seed => fill db tables with dummy data
8. php artisan serve => shows that web server started, ex. INFO  Server running on [http://127.0.0.1:8000].
9. open new terminal and type npm run dev => Running Vite Command to build Asset Files
