# create project

# composer require --dev laravel-shift/blueprint

# php artisan blueprint:init

# php artisan blueprint:new

# cofigure draft.yaml

# make sqlite configuration in .env

# create builder.sh

# sudo chmod +x builder.sh

# ./builder.sh

# configure seeder files

# create seeder.sh

# sudo chmod +x ./seeder.sh

# ./seeder.sh

# make resource controller for Employee, skill, and role

php artisan make:controller Api/RoleController --resource
php artisan make:controller Api/SkillController --resource
php artisan make:controller Api/EmployeeController --resource

# make controller for authentication, authorization flow

php artisan make:controller Api/AuthController

# configure api.php routes file

# configure and install predis
composer require predis/predis

# integrate socialite
composer require laravel/socialite

# Run scheduler locally
php artisan schedule:work
