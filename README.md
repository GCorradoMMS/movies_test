# Movies App
Printi Backend Developer Test. I've implemented this test in two ways:

## Pure PHP
- Simple POC made with pure PHP to display my language skills, coding style and design knowledge. I created an application that remarks some MVC Frameworks features.
- Furthermore, i added more features than the test description like a simple migration route that can be used to quickstart a database and new methods like Delete and Update.
- Can be tested running `php -S 0.0.0.0:8080/ index.php` in the project root.

## Symfony
- I've Tried to create the same POC with the Symfony framework. Never used it before, so i've tried to implement something from reading the documentation, following some tutorials and learning how it works.
- I couldn't figure out how to make the Dependency Injection work, thus leading to an error in the `MovieController` when i call the `MovieRepository`, but the application has traditional CRUD routes regarding a REST API.
- Can be tested with the Symfony cli application running `symfony server:start` and all dependencies can be installed with a `composer install` if necessary.
