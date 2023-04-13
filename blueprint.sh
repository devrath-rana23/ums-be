php artisan blueprint:erase
php artisan blueprint:build
php artisan queue:table
php artisan migrate:fresh
php artisan make:job CacheingRoleMasterDataJob
php artisan make:job ExportSkillsCsvJob
php artisan make:job ExportRolesCsvJob
php artisan make:job ExportEmployeesCsvJob
