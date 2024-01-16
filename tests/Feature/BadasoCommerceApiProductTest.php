<?php

namespace Uasoft\Badaso\Module\Commerce\Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;

class BadasoCommerceApiProductTest extends TestCase
{
    public function testInitStart()
    {
        CallHelperTest::handleUserAdminAuthorize($this);
    }

    public function testStoreProduct()
    {
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/product-category/add', [
            'name' => 'test',
            'slug' => Str::uuid(),
            'desc' => 'decription',
            'SKU' => Str::uuid(),
        ]);
        $response->assertSuccessful();
        $get_response = $response->json('data.id');
        $data = ProductCategory::find($get_response);
        $this->assertNotEmpty($data);
        $data->delete();
    }

    public function testEditProductCategory()
    {
        $model = ProductCategory::create([
            'name' => 'coba',
            'slug' => Str::uuid(),
            'desc' => 'decription',
            'SKU' => Str::uuid(),
        ]);
        $product_category_id = $model->id;

        $request_data = [
            'id' => $product_category_id,
            'name' => 'coba edit afdhal',
            'desc' => 'decription edit',
            'SKU' => Str::uuid(),
        ];
        $response = CallHelperTest::withAuthorizeBearer($this)->json('PUT', '/badaso-api/module/commerce/v1/product-category/edit', $request_data);
        $response->assertSuccessful();

        $get_response = $response->json('data.id');

        // from database
        $data = ProductCategory::find($product_category_id);
        $this->assertNotEmpty($data);

        // check data
        $this->assertTrue($request_data['name'] == $data->name);
        $this->assertTrue($request_data['desc'] == $data->desc);
        $this->assertTrue($request_data['SKU'] == $data->SKU);

        $data->delete();
    }

    public function testReadProductCategory()
    {
        //  from database
        $model = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU' => Str::uuid(),
        ]);

        $product_category_id = $model->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product-category/read', [
            'id' => $product_category_id,
        ]);
        $response->assertSuccessful();

        $product_category_id = $response->json('data.productCategory.id');
        $product_category = ProductCategory::find($product_category_id);
        $this->assertNotEmpty($product_category);
        $model->delete();
    }

    public function testBrowseProductCategory()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU' => Str::uuid(),
        ]);

        $product_category_2 = ProductCategory::create([
            'name' => 'coba 2',
            'slug' => Str::uuid(),
            'desc' => 'decription 2',
            'SKU' => Str::uuid(),
        ]);
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product-category');
        $response->assertSuccessful();
        $data = $response->json('data.productCategories');
        foreach ($data as $value) {
            $kategori = ProductCategory::find($value['id']);

            $this->assertNotEmpty($kategori);
            $kategori->delete();
        }
    }

    public function testDeleteProductCategory()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU' => Str::uuid(),
        ]);

        //  get id from database
        $product_category_id = $product_category->id;

        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product-category/delete', [
            'id' => $product_category_id,
        ]);
        $response->assertSuccessful();
        $product_category->delete();
    }

    public function testDeleteMultipleProductCategory()
    {
        $ids = [];
        for ($index = 0; $index < 5; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba '.$index,
                'slug' => Str::uuid(),
                'desc' => 'decription '.$index,
                'SKU' => Str::uuid(),
            ]);
            $ids[] = $product_category->id;
        }
        $join_ids_product_category = join(',', $ids);

        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product-category/delete-multiple', [
            'ids' => $join_ids_product_category,
        ]);
        $response->assertSuccessful();

        $product_category->forceDelete();
    }

    public function testForceDeleteProductCategory()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU' => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product_category->delete();

        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/product-category/force-delete', [
            'id' => $product_category_id,
        ]);
        $response->assertSuccessful();

        $product_category_trans = ProductCategory::withTrashed()->find($product_category_id);
        $this->assertEmpty($product_category_trans);
        $product_category->forceDelete();
    }

    public function testBrowseBinProductCategory()
    {
        $ids = [];
        for ($index = 0; $index < 3; $index++) {
            $product_category = ProductCategory::create([
                'name' => 'coba '.$index,
                'slug' => Str::uuid(),
                'desc' => 'decription '.$index,
                'SKU' => Str::uuid(),
            ]);
            $ids[] = $product_category->id;
        }
        $product_category_trans_count = ProductCategory::withTrashed()->count();
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/product-category/bin', [
            'page' => 1,
            'limit' => $product_category_trans_count,
        ]);
        $response->assertSuccessful();
        $product_category->delete();
    }
}
