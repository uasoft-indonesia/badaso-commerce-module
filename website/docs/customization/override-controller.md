---
sidebar_position: 1
---

# Override Controller

To override the controller, you can follow the following steps:

- Create a new controller by using below command.

`php artisan make:controller ExampleController`

- After the new controller is created, you can override the controller by registering the controller in the `config/badaso-commerce.php` file in `controllers` section. For example:

```php
return [
    ...,

    'controllers' => [
        'PublicController\ProductController@browse' => 'App\Http\Controllers\ExampleController@browse',
    ],
];
```

- You can see the available keys of overrides in the `vendor/badaso/commerce-module/src/Routes/api.php` file.