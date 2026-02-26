Welcome to the Inventory Task
Live check url: https://beta.reworqx.com
1. Installation Guide
Follow these steps to run the application

    # 1. Clone the repository
    git clone https://github.com/ini-kaisarmonir/inventory.git

    # 2. Install PHP dependencies
    composer install

    # 3. Folder Permissions
    (If you use linux or vps)
    chmod -R 775 storage/logs/
    chmod -R 775 storage/framework/
    chmod -R 775 bootstrap/cache/
    (If you use cpanel or other panel change it manually)

    # 4. Install and compile Frontend assets
    npm install
    npm run build

    # 5. Environment Setup
    Copy the example env file and name it (.env) by running `cp .env.example .env` command (If you use cpanel or other panel copy it manually).

    # 6. Database Setup (Ensure your .env has correct DB credentials)(Currently using mysql, you can change it as per your need)
    run `php artisan migrate:fresh --seed` (If you use cpanel or other panel import the `task.sql` (it's in project root) file manually in the database)
    
2. Usage guide
    Used simple gate based authorization system for access control and used separate table for customer. By logging in as admin you can access to the dashboard where you will find Products, Sales add option and report option. Here is the credentials to test:
    Admin: admin@example.com / 123456

3. Style Used
    #Used enum for consistency in data handling.
    #Used custom Request classes for validation and handling.
    #Big business logic implemented in service classes.
    #DB transactions used for data consistency.
4. Accounting
    #Used account types for financial tracking and reporting.
    #Journal vouchers for financial transactions.
    #Journal entries used.
