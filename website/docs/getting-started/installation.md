---
sidebar_position: 1
---

# Installation

1. Install [badaso](https://badaso-docs.uatech.co.id/getting-started/installation) first. After that, you can install the module with the following command.

    ```bash
    composer require badaso/commerce-module
    ```

1. Run the following command to easily setup the module.

    ```bash
    php artisan badaso-commerce:setup
    php artisan migrate
    composer dump-autoload
    php artisan db:seed --class="Database\Seeders\Badaso\Commerce\BadasoCommerceModuleSeeder"
    ```

1. Add the plugins to your `MIX_BADASO_PLUGINS` to `.env`. If you have another plugins installed, include them using delimiter comma (,).

    ```
    MIX_BADASO_PLUGINS=commerce-module
    ```

1. Add the plugins menu to your `MIX_BADASO_MENU` to `.env`. If you have another menu, include them using delimiter comma (,).

    ```
    MIX_BADASO_MENU=admin,commerce-module
    ```

1. Fill the other variables in .env file.
    - `COMMERCE_PRODUCTS_LIMIT_QUERY=10` Limit query browse on product, default is 10.
    - `MIX_PAYMENT_MODULE=commerce-module` Register the payment module.

1. Fill the payment config in `badaso-commerce.php`. For example:
    - `'payments' => ['Uasoft\Badaso\Module\Commerce\BadasoCommerceModule']`

1. Your commerce module already installed and you can see the menu at the dashboard.

1. Next you can install the theme for the frontpage, you can see the available theme [here](https://github.com/uasoft-indonesia/badaso-awesome#themes)
