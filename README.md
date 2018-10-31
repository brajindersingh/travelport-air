# Travelport 
Laravel wrapper for Travelport Flight Booking using LowFareSearch

#This is still in devlopment phase and not ready for use in production.

# Api Documentation
For documentation on the api please refer to https://support.travelport.com/webhelp/uapi/Subsystems/Schemas/Content/Schemas/LowFareSearchReq.html
for register and login visit http://www.travelport.com/

## Installation

Open `composer.json` and add this line below.

```json
{
    "require": {
        "thedevlogs/travelport": "^1.0.0"
    }
}
```

Or you can run this command from your project directory.

```console
composer require thedevlogs/travelport
```

## Configuration

Open the `config/app.php` and add this line in `providers` section.

```php
Thedevlogs\Travelport\TravelportServiceProvider::class,
```

add this line in the `aliases` section.

```php
'Travelport' => Thedevlogs\Travelport\TravelportFacade::class

```

get the `config` by running this command.

```console
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=logs
```

config option can be found `app/travelport.php`

```
    'TARGETBRANCH' => '',
    'CREDENTIALS' => '',
    'PROVIDER' => '',
    'DEBUG' => FALSE,
    'USER' => 'admin',
```

## Basic Usage

Under your controller namespace add:
use \Travelport;

You can use the function like this.

```php

$book = app(Travelport::class);
$origin = 'JFK';
$destination = 'SAN';
$deptime = '2018-10-31';
$book::checkAirAvailability($origin, $destination, $deptime);
                               
                         
                                                                     


```