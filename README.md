# Filament v3 Installation Guide

### Step 1: Install Filament

Use Composer to require Filament v3 in your project. Run the following command in your terminal:

bashCopy code

`composer require filament/filament:"^3.0-stable" -W` 

This command will fetch the Filament package and add it to your project. The `-W` flag ensures that you won't accidentally install incompatible dependencies.

### Step 2: Run Migrations

After successfully installing Filament, you need to run migrations to set up the required database tables. Execute the following command:

bashCopy code

`php artisan migrate` 

This command will create the necessary tables in your database to support Filament.

### Step 3: Run Seeder (Optional)

If you want to populate the database with some sample data for testing or demonstration purposes, run the following command:

bashCopy code

`php artisan db:seed` 

This command will execute the database seeder, filling your tables with predefined data.

That's it! Your Filament v3 installation is now complete, and you're ready to start using this powerful admin panel in your Laravel project. If you encounter any issues during the installation process, refer to the [Filament documentation](https://filamentadmin.com/docs) for additional assistance.

Happy coding!
