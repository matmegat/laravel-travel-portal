#!/bin/bash

# Thankyou Vaprobash
bash <(curl -s https://raw.githubusercontent.com/fideloper/Vaprobash/master/scripts/mongodb.sh)
bash <(curl -s https://raw.githubusercontent.com/fideloper/Vaprobash/master/scripts/nodejs.sh)
bash <(curl -s https://raw.githubusercontent.com/fideloper/Vaprobash/master/scripts/rvm.sh)

# NodeJS packages
sudo npm install -g gulp

# Compass
gem install compass

# Move to app installation
cd /home/vagrant/visits.com.au/

# Migrate databases
php artisan migrate
php artisan command:loadJ6
php artisan command:loadtravel
# php artisan command:updatetravel

# Compile assets
npm install --no-bin-links
gulp
