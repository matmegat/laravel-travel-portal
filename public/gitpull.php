<?php

system('git pull origin master');
system('git fetch');
system('cd ../; php artisan migrate --env=visitsdiving');
