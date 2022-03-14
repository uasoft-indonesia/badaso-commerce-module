<?php

namespace Uasoft\Badaso\Module\Commerce\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Commerce\Models\Discount;
use Uasoft\Badaso\Module\Commerce\Models\Product;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;

class BadasoCommerceApiProductDetailTest extends TestCase
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

    public function testInsertProductDetail()
    {
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/product-detail/add', [
            'product_id' => $product_id,
            'discount_id' => $discount_id,
            'name' => 'name test',
            'quantity'  => 12,
            'price' => '1000000',
            's_k_u'  => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
        ]);
        $response->assertSuccessful();
        $response_product_detail = $response->json('data.id');
        $data = ProductDetail::find($response_product_detail);
        $this->assertNotEmpty($data);
        $data->forceDelete();
    }

    public function testEditProductDetail()
    {
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;

        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;

        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
        ]);
        $product_detail_id = $product_detail->id;

        $request_product_detail = [
            'id' => $product_detail_id,
            'product_id' => $product_id,
            'discount_id' => $discount_id,
            'name' => 'Intel Core i7-4790K update',
            'quantity' => '100',
            'price' => '10000000',
            'SKU' => '',
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fkumparan.com%2Fberita-terkini%2Fcara-foto-aesthetic-mudah-menggunakan-handphone-1x1gfvs9lVO&psig=AOvVaw36mQDD7OwrnMAadVPHM_bD&ust=1644547347891000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCNijqLaO9PUCFQAAAAAdAAAAABAF',

        ];

        $response = CallHelperTest::withAuthorizeBearer($this)->json('PUT', '/badaso-api/module/commerce/v1/product-detail/edit', $request_product_detail);
        $response->assertSuccessful();

        $data = ProductDetail::find($product_detail_id);

        $this->assertNotEmpty($data);
        $this->assertTrue($request_product_detail['product_id'] == $data->product_id);
        $this->assertTrue($request_product_detail['discount_id'] == $data->discount_id);
        $this->assertTrue($request_product_detail['name'] == $data->name);
        $this->assertTrue($request_product_detail['quantity'] == $data->quantity);
        $this->assertTrue($request_product_detail['price'] == $data->price);
        $this->assertTrue($request_product_detail['SKU'] == $data->SKU);
        $this->assertTrue($request_product_detail['product_image'] == $data->product_image);

        $data->forceDelete();
    }

    public function testDeleteProductDetail()
    {
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;

        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;

        $product = Product::create([
            'product_category_id' =>  $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;

        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
        ]);
        $product_detail_id = $product_detail->id;

        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product-detail/delete', [
            'id' =>  $product_detail_id,
        ]);
        $response->assertSuccessful();
        $product_detail->forceDelete();
    }
}
