<?php

use Illuminate\Support\Facades\Route;
use Uasoft\Badaso\Middleware\ApiRequest;
use Uasoft\Badaso\Middleware\BadasoAuthenticate;
use Uasoft\Badaso\Middleware\BadasoCheckPermissions;
use Uasoft\Badaso\Module\Commerce\Helper\Route as HelperRoute;

$api_route_prefix = \config('badaso.api_route_prefix');

Route::group(['prefix' => $api_route_prefix, 'as' => 'badaso.', 'middleware' => [ApiRequest::class]], function () {
    Route::group(['prefix' => 'module/commerce/v1'], function () {
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', HelperRoute::getController('ProductController@browse'))->middleware(BadasoCheckPermissions::class.':browse_products');
            Route::get('/bin', HelperRoute::getController('ProductController@browseBin'))->middleware(BadasoCheckPermissions::class.':browse_products_bin');
            Route::get('/read', HelperRoute::getController('ProductController@read'))->middleware(BadasoCheckPermissions::class.':read_products');
            Route::get('/read-slug', HelperRoute::getController('ProductController@readBySlug'))->middleware(BadasoCheckPermissions::class.':read_products');
            Route::post('/restore', HelperRoute::getController('ProductController@restore'))->middleware(BadasoCheckPermissions::class.':restore_products');
            Route::post('/restore-multiple', HelperRoute::getController('ProductController@restoreMultiple'))->middleware(BadasoCheckPermissions::class.':restore_products');
            Route::post('/add', HelperRoute::getController('ProductController@add'))->middleware(BadasoCheckPermissions::class.':add_products');
            Route::put('/edit', HelperRoute::getController('ProductController@edit'))->middleware(BadasoCheckPermissions::class.':edit_products');
            Route::delete('/delete', HelperRoute::getController('ProductController@delete'))->middleware(BadasoCheckPermissions::class.':delete_products');
            Route::delete('/delete-multiple', HelperRoute::getController('ProductController@deleteMultiple'))->middleware(BadasoCheckPermissions::class.':delete_products');
            Route::delete('/force-delete', HelperRoute::getController('ProductController@forceDelete'))->middleware(BadasoCheckPermissions::class.':delete_permanent_products');
            Route::delete('/force-delete-multiple', HelperRoute::getController('ProductController@forceDeleteMultiple'))->middleware(BadasoCheckPermissions::class.':delete_permanent_products');
        });

        Route::group(['prefix' => 'product-detail'], function () {
            Route::post('/add', HelperRoute::getController('ProductDetailController@add'))->middleware(BadasoCheckPermissions::class.':add_product_details');
            Route::put('/edit', HelperRoute::getController('ProductDetailController@edit'))->middleware(BadasoCheckPermissions::class.':edit_product_details');
            Route::delete('/delete', HelperRoute::getController('ProductDetailController@delete'))->middleware(BadasoCheckPermissions::class.':delete_product_details');
        });

        Route::group(['prefix' => 'product-category'], function () {
            Route::get('/', HelperRoute::getController('ProductCategoryController@browse'))->middleware(BadasoCheckPermissions::class.':browse_product_categories');
            Route::get('/bin', HelperRoute::getController('ProductCategoryController@browseBin'))->middleware(BadasoCheckPermissions::class.':browse_product_categories_bin');
            Route::get('/read', HelperRoute::getController('ProductCategoryController@read'))->middleware(BadasoCheckPermissions::class.':read_product_categories');
            Route::get('/read-slug', HelperRoute::getController('ProductCategoryController@readBySlug'))->middleware(BadasoCheckPermissions::class.':read_product_categories');
            Route::post('/restore', HelperRoute::getController('ProductCategoryController@restore'))->middleware(BadasoCheckPermissions::class.':restore_product_categories');
            Route::post('/restore-multiple', HelperRoute::getController('ProductCategoryController@restoreMultiple'))->middleware(BadasoCheckPermissions::class.':restore_product_categories');
            Route::post('/add', HelperRoute::getController('ProductCategoryController@add'))->middleware(BadasoCheckPermissions::class.':add_product_categories');
            Route::put('/edit', HelperRoute::getController('ProductCategoryController@edit'))->middleware(BadasoCheckPermissions::class.':edit_product_categories');
            Route::delete('/delete', HelperRoute::getController('ProductCategoryController@delete'))->middleware(BadasoCheckPermissions::class.':delete_product_categories');
            Route::delete('/delete-multiple', HelperRoute::getController('ProductCategoryController@deleteMultiple'))->middleware(BadasoCheckPermissions::class.':delete_product_categories');
            Route::delete('/force-delete', HelperRoute::getController('ProductCategoryController@forceDelete'))->middleware(BadasoCheckPermissions::class.':delete_permanent_product_categories');
            Route::delete('/force-delete-multiple', HelperRoute::getController('ProductCategoryController@forceDeleteMultiple'))->middleware(BadasoCheckPermissions::class.':delete_permanent_product_categories');
        });

        Route::group(['prefix' => 'discount'], function () {
            Route::get('/', HelperRoute::getController('DiscountController@browse'))->middleware(BadasoCheckPermissions::class.':browse_discounts');
            Route::get('/bin', HelperRoute::getController('DiscountController@browseBin'))->middleware(BadasoCheckPermissions::class.':browse_discounts_bin');
            Route::get('/read', HelperRoute::getController('DiscountController@read'))->middleware(BadasoCheckPermissions::class.':read_discounts');
            Route::post('/restore', HelperRoute::getController('DiscountController@restore'))->middleware(BadasoCheckPermissions::class.':restore_discounts');
            Route::post('/restore-multiple', HelperRoute::getController('DiscountController@restoreMultiple'))->middleware(BadasoCheckPermissions::class.':restore_discounts');
            Route::post('/add', HelperRoute::getController('DiscountController@add'))->middleware(BadasoCheckPermissions::class.':add_discounts');
            Route::put('/edit', HelperRoute::getController('DiscountController@edit'))->middleware(BadasoCheckPermissions::class.':edit_discounts');
            Route::delete('/delete', HelperRoute::getController('DiscountController@delete'))->middleware(BadasoCheckPermissions::class.':delete_discounts');
            Route::delete('/delete-multiple', HelperRoute::getController('DiscountController@deleteMultiple'))->middleware(BadasoCheckPermissions::class.':delete_discounts');
            Route::delete('/force-delete', HelperRoute::getController('DiscountController@forceDelete'))->middleware(BadasoCheckPermissions::class.':delete_permanent_discounts');
            Route::delete('/force-delete-multiple', HelperRoute::getController('DiscountController@forceDeleteMultiple'))->middleware(BadasoCheckPermissions::class.':delete_permanent_discounts');
        });

        Route::group(['prefix' => 'payment'], function () {
            Route::get('/', HelperRoute::getController('PaymentController@browse'))->middleware(BadasoCheckPermissions::class.':browse_payments');
            Route::get('/read', HelperRoute::getController('PaymentController@read'))->middleware(BadasoCheckPermissions::class.':read_payments');
            Route::post('/add', HelperRoute::getController('PaymentController@add'))->middleware(BadasoCheckPermissions::class.':add_payments');
            Route::put('/edit', HelperRoute::getController('PaymentController@edit'))->middleware(BadasoCheckPermissions::class.':edit_payments');
            Route::delete('/delete', HelperRoute::getController('PaymentController@delete'))->middleware(BadasoCheckPermissions::class.':delete_payments');
            Route::get('/option', HelperRoute::getController('PaymentController@browseOption'))->middleware(BadasoCheckPermissions::class.':browse_payment_options');
            Route::post('/option/add', HelperRoute::getController('PaymentController@addOption'))->middleware(BadasoCheckPermissions::class.':add_payment_options');
            Route::put('/option/edit', HelperRoute::getController('PaymentController@editOption'))->middleware(BadasoCheckPermissions::class.':edit_payment_options');
            Route::delete('/option/delete', HelperRoute::getController('PaymentController@deleteOption'))->middleware(BadasoCheckPermissions::class.':delete_payment_options');
            Route::put('/option/arrange', HelperRoute::getController('PaymentController@arrangeOption'))->middleware(BadasoCheckPermissions::class.':edit_payment_options');

            Route::group(['prefix' => 'public'], function () {
                Route::get('/', HelperRoute::getController('PublicController\PaymentController@browse'));
                Route::get('/read', HelperRoute::getController('PublicController\PaymentController@read'));
            });
        });

        Route::group(['prefix' => 'order', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', HelperRoute::getController('OrderController@browse'))->middleware(BadasoCheckPermissions::class.':browse_orders');
            Route::get('/read', HelperRoute::getController('OrderController@read'))->middleware(BadasoCheckPermissions::class.':read_orders');
            Route::post('/confirm', HelperRoute::getController('OrderController@confirm'))->middleware(BadasoCheckPermissions::class.':confirm_orders');
            Route::post('/reject', HelperRoute::getController('OrderController@reject'))->middleware(BadasoCheckPermissions::class.':confirm_orders');
            Route::post('/ship', HelperRoute::getController('OrderController@ship'))->middleware(BadasoCheckPermissions::class.':confirm_orders');
            Route::post('/done', HelperRoute::getController('OrderController@done'))->middleware(BadasoCheckPermissions::class.':confirm_orders');
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', HelperRoute::getController('CartController@browse'))->middleware(BadasoCheckPermissions::class.':browse_carts');
            Route::get('/read', HelperRoute::getController('CartController@read'))->middleware(BadasoCheckPermissions::class.':read_carts');
        });

        Route::group(['prefix' => 'user-address'], function () {
            Route::get('/', HelperRoute::getController('UserAddressController@browse'))->middleware(BadasoCheckPermissions::class.':browse_user_addresses');
            Route::get('/read', HelperRoute::getController('UserAddressController@read'))->middleware(BadasoCheckPermissions::class.':read_user_addresses');
        });

        Route::group(['prefix' => 'review', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', HelperRoute::getController('ReviewController@browse'))->middleware(BadasoCheckPermissions::class.':browse_product_reviews');
            Route::get('/read', HelperRoute::getController('ReviewController@read'))->middleware(BadasoCheckPermissions::class.':read_product_reviews');
            Route::delete('/delete', HelperRoute::getController('ReviewController@delete'))->middleware(BadasoCheckPermissions::class.':delete_product_reviews');
        });

        Route::group(['prefix' => 'product/public'], function () {
            Route::get('/', HelperRoute::getController('PublicController\ProductController@browse'));
            Route::get('/browse-category-slug', HelperRoute::getController('PublicController\ProductController@browseByCategorySlug'));
            Route::get('/browse-similar', HelperRoute::getController('PublicController\ProductController@browseSimilar'));
            Route::get('/read', HelperRoute::getController('PublicController\ProductController@read'));
            Route::get('/read-by-cart', HelperRoute::getController('PublicController\ProductController@readSimple'));
            Route::get('/search', HelperRoute::getController('PublicController\ProductController@search'));
            Route::get('/best-selling', HelperRoute::getController('PublicController\ProductController@browseBestSellingProduct'));
        });

        Route::group(['prefix' => 'product-category/public'], function () {
            Route::get('/', HelperRoute::getController('PublicController\ProductCategoryController@browse'));
            Route::get('/read', HelperRoute::getController('PublicController\ProductCategoryController@read'));
        });

        Route::group(['prefix' => 'cart/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', HelperRoute::getController('PublicController\CartController@browse'));
            Route::post('/add', HelperRoute::getController('PublicController\CartController@add'));
            Route::put('/edit', HelperRoute::getController('PublicController\CartController@edit'));
            Route::put('/edit-cart', HelperRoute::getController('PublicController\CartController@editCart'));
            Route::delete('/delete', HelperRoute::getController('PublicController\CartController@delete'));
            Route::post('/validate', HelperRoute::getController('PublicController\CartController@validate'));
        });

        Route::group(['prefix' => 'order/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', HelperRoute::getController('PublicController\OrderController@browse'));
            Route::get('/read', HelperRoute::getController('PublicController\OrderController@read'));
            Route::put('/pay', HelperRoute::getController('PublicController\OrderController@pay'));
            Route::post('/finish', HelperRoute::getController('PublicController\OrderController@finish'));
        });

        Route::group(['prefix' => 'review/public'], function () {
            Route::get('/', HelperRoute::getController('PublicController\ReviewController@browse'));
            Route::post('/submit', HelperRoute::getController('PublicController\ReviewController@submit'));
            Route::get('/read', HelperRoute::getController('PublicController\ReviewController@read'));
        });

        Route::group(['prefix' => 'user-address/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', HelperRoute::getController('PublicController\UserAddressController@browse'));
            Route::get('/read', HelperRoute::getController('PublicController\UserAddressController@read'));
            Route::post('/add', HelperRoute::getController('PublicController\UserAddressController@add'));
            Route::put('/edit', HelperRoute::getController('PublicController\UserAddressController@edit'));
            Route::delete('/delete', HelperRoute::getController('PublicController\UserAddressController@delete'));
            Route::post('/main', HelperRoute::getController('PublicController\UserAddressController@setMain'));
        });

        Route::group(['prefix' => 'user/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::put('/edit', HelperRoute::getController('PublicController\UserController@edit'));
            Route::post('/change', HelperRoute::getController('PublicController\UserController@changePassword'));
        });

        Route::group(['prefix' => 'notification/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', HelperRoute::getController('PublicController\NotificationController@browse'));
            Route::post('/read', HelperRoute::getController('PublicController\NotificationController@read'));
            Route::post('/read-all', HelperRoute::getController('PublicController\NotificationController@readAll'));
        });

        Route::group(['prefix' => 'configurations', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::put('/edit', HelperRoute::getController('ConfigurationController@edit'))->middleware(BadasoCheckPermissions::class.':edit_configurations');
            Route::put('/edit-multiple', HelperRoute::getController('ConfigurationController@editMultiple'))->middleware(BadasoCheckPermissions::class.':edit_configurations');
            Route::post('/add', HelperRoute::getController('ConfigurationController@add'))->middleware(BadasoCheckPermissions::class.':add_configurations');
            Route::delete('/delete', HelperRoute::getController('ConfigurationController@delete'))->middleware(BadasoCheckPermissions::class.':delete_configurations');
        });

        Route::group(['prefix' => 'configurations'], function () {
            Route::get('/', HelperRoute::getController('ConfigurationController@browse'));
            Route::get('/read', HelperRoute::getController('ConfigurationController@read'));
        });
    });
});
