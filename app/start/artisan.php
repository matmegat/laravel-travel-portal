<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new DevCommand());

Artisan::add(new TravelCommand());
Artisan::add(new TravelUpdateCommand());
Artisan::add(new J6Command());
Artisan::add(new TravelCategoriesCommand());
