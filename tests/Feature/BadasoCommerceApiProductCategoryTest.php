<?php

namespace Uasoft\Badaso\Module\Commerce\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Commerce\Models\Discount;
use Uasoft\Badaso\Module\Commerce\Models\Product;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;

class BadasoCommerceApiProductCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInitStart()
    {
        CallHelperTest::handleUserAdminAuthorize($this);
    }

    public function testBrowseProduct()
    {
        $ids = [];
        for ($index = 0; $index < 2; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba 1',
                'slug' => Str::uuid(),
                'desc' => 'decription 1',
                'SKU'  => Str::uuid(),
            ]);
            $product_category_id = $product_category->id;

            $product = Product::create([
                'product_category_id' =>  $product_category_id,
                'name' => 'product 1'.$index,
                'slug' => Str::uuid(),
                'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
                'desc' => 'description tes product'.$index,
            ]);
            $products[] = $product;
            $ids[] = $product->id;
        }
        $count_product = Product::all()->count();

        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product', [
            'page' => 1,
            'limit' => $count_product,

        ]);
        $response->assertSuccessful();
        $get_product_data = $response->json('data.products.data');
        foreach ($get_product_data as $data_product) {
            $product_id = Product::find($data_product['id']);
            $this->assertNotEmpty($product_id);
        }
        foreach ($products as $key => $product) {
            $product->forceDelete();
        }
    }

    public function testBrowseBinProduct()
    {
        $ids = [];
        $products = [];
        for ($index = 0; $index < 2; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba 1',
                'slug' => Str::uuid(),
                'desc' => 'decription 1',
                'SKU'  => Str::uuid(),
            ]);
            $product_category_id = $product_category->id;

            $product = Product::create([
                'product_category_id' =>  $product_category_id,
                'name' => 'product 1'.$index,
                'slug' => Str::uuid(),
                'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
                'desc' => 'description tes product'.$index,
            ]);
            $products[] = $product;
            $ids[] = $product->id;
        }

        $product_trans_count = Product::withTrashed()->count();
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product/bin', [
            'page' => 1,
            'limit' => $product_trans_count,
        ]);
        $response->assertSuccessful();

        foreach ($products as $key => $product) {
            $product->forceDelete();
        }
    }

    public function testReadProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'product read',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product/read', [
            'id' => $product_id,
        ]);
        $response->assertSuccessful();
        $product->forceDelete();
    }

    public function testRestoreDeletedProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'product delete restore',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $product->delete();
        $product_trashed = Product::withTrashed()->find($product_id);
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/product/restore', [
            'id' => $product_trashed->id,
        ]);
        $response->assertSuccessful();

        $product = Product::find($product_id);
        $this->assertNotEmpty($product);

        $this->assertEmpty($product->deleted_at);
    }

    public function testInsertProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;

        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/product/add', [
            'product_category_id' => $product_category_id,
            'name' => 'product insert 4',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
            'items' => [
                [
                    'discount_id' => $discount_id,
                    'name' => 'Intel Core i7-4790K',
                    'quantity' => 10,
                    'price' => 10000000,
                    's_k_u' => 'INT-I7-4790-K',
                    'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
                ],
            ],

        ]);
        $response->assertSuccessful();
        $get_response_product = $response->json('data.id');
        $data = Product::find($get_response_product);
        $this->assertNotEmpty($data);
        $data->forceDelete();

    }

    public function testEditProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'Intel Core i7-4750',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',

        ]);
        $product_id = $product->id;
        $request_data_product = [
            'id' => $product_id,
            'product_category_id' =>  $product_category_id,
            'name' => 'Intel Core i7-4750 product edit',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description edit product edit',

        ];
        $response = CallHelperTest::withAuthorizeBearer($this)->json('PUT', '/badaso-api/module/commerce/v1/product/edit', $request_data_product);

        $response->assertSuccessful();
        $data_product = Product::find($product_id);
        $this->assertNotEmpty($data_product);
        $this->assertTrue($request_data_product['product_category_id'] == $data_product->product_category_id);
        $this->assertTrue($request_data_product['name'] == $data_product->name);
        $this->assertTrue($request_data_product['product_image'] == $data_product->product_image);
        $this->assertTrue($request_data_product['desc'] == $data_product->desc);
        $data_product->forceDelete();
    }

    public function testDeleteProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'Intel Core i7-4750 delete product',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes delete product',

        ]);
        $product_id = $product->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product/delete', [
            'id' => $product_id,
        ]
        );
        $response->assertSuccessful();
        $product->forceDelete();
    }

    public function testForceDeleteProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'Intel Core i7-4750 delete product',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes delete product',

        ]);
        $product_id = $product->id;
        $product->delete();

        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product/force-delete', [
            'id' => $product_id,
        ]
        );
        $response->assertSuccessful();

        $product_trans = Product::withTrashed()->find($product_id);
        $this->assertEmpty($product_trans);
        $product->forceDelete();
    }

    public function testDeleteMultipleProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $ids = [];
        $products = [];
        for ($index = 0; $index < 3; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba 1',
                'slug' => Str::uuid(),
                'desc' => 'decription 1',
                'SKU'  => Str::uuid(),
            ]);
            $product_category_id = $product_category->id;
            $product = Product::create([
                'product_category_id' =>  $product_category_id,
                'name' => 'Intel Core i7-4750 delete multiple product'.$index,
                'slug' => Str::uuid(),
                'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
                'desc' => 'description tes delete multiple product'.$index,

            ]);
            $ids[] = $product->id;
            $products[] = $product;
        }
        $join_product = join(',', $ids);
        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product/delete-multiple', [
            'ids' =>  $join_product,
        ]);
        $response->assertSuccessful();
        $product->forceDelete();
    }

    public function testForceDeleteMultipleProduct()
    {
        $ids = [];
        $products = [];
        for ($index = 0; $index < 3; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba 1',
                'slug' => Str::uuid(),
                'desc' => 'decription 1',
                'SKU'  => Str::uuid(),
            ]);
            $product_category_id = $product_category->id;
            $product = Product::create([
                'product_category_id' =>  $product_category_id,
                'name' => 'Intel Core i7-4750 delete multiple product'.$index,
                'slug' => Str::uuid(),
                'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
                'desc' => 'description tes delete multiple product'.$index,

            ]);
            $ids[] = $product->id;
            $products[] = $product;
        }

        foreach ($products as $key => $product_key) {
            $product_key->delete();
        }

        $join_product = join(',', $ids);
        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product/force-delete-multiple', [
            'ids' =>  $join_product,
        ]);
        $response->assertSuccessful();

        $history = [];
        foreach ($products as $key => $product) {
            $delete_product_id = $product->id;
            $product_trans = Product::withTrashed()->find($delete_product_id);
            $this->assertEmpty($product_trans);
            if (isset($product_trans)) {
                $history[] = $delete_product_id;
            }
        }
    }

    public function testBrowsePublicProduct()
    {
        $ids = [];
        $products = [];
        for ($index = 0; $index < 3; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba 1',
                'slug' => Str::uuid(),
                'desc' => 'decription 1',
                'SKU'  => Str::uuid(),
            ]);
            $product_category_id = $product_category->id;
            $product = Product::create([
                'product_category_id' =>  $product_category_id,
                'name' => 'Intel Core i7-4750 delete multiple product'.$index,
                'slug' => Str::uuid(),
                'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
                'desc' => 'description tes delete multiple product'.$index,

            ]);
            $ids[] = $product->id;
            $products[] = $product;
        }
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product/public', [
            'page' =>  1,
        ]);
        $response->assertSuccessful();
        foreach ($products as $key => $product) {
            $product->forceDelete();
        }
    }

    public function testReadPublicProduct()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'Intel Core i7-4750 delete multiple product',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes delete multiple product',

        ]);

        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product/public/read', [
            'slug' => $product->slug,
        ]);
        $response->assertSuccessful();
        $product->forceDelete();
        $product_category->forceDelete();
    }
}
