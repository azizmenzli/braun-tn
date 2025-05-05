#!/bin/bash

# Convert MySQL dump to SQLite format
sed -i 's/`//g' /var/www/html/braun-tn-0205.sql
sed -i 's/ENGINE=InnoDB//g' /var/www/html/braun-tn-0205.sql
sed -i 's/DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci//g' /var/www/html/braun-tn-0205.sql
sed -i 's/AUTO_INCREMENT//g' /var/www/html/braun-tn-0205.sql
sed -i 's/UNSIGNED//g' /var/www/html/braun-tn-0205.sql

# Import into SQLite
sqlite3 /var/www/html/database/database.sqlite < /var/www/html/braun-tn-0205.sql 