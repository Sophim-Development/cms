# CMS
Clinic Management System

How to run the Auto/Taxi Stand Management Project Using PHP and MySQL

1. Clone project
2. cd projectName
3. Run: ```yarn install```
4. Run: ```./build.sh```, run ```chmod +x build.sh``` to give permission then run build again
5. Create a database with name hms
7.Run the script ```php -S localhost:3000 -t public/```, open http://localhost/3000 (frontend)
8. If see any error with config.php please following this:
  -  ```mysql -u root -p``` enter you root password if have
  -  ```SHOW DATABASES;``` will see "cms_db" if not create one
  -  ```USE cms_db```
  -  ```SHOW TABLES``` then will see all tables here if not run this
  -  ```mysql -u root -p cms_db < cms_db.sql```
Login Details
Login Details for admin : admin/Admin@2025
Login Details for Patient: phandy@dydy.com/Dydy@2025
Login Details for Doctor: sophim@doc.com/Test@2025
