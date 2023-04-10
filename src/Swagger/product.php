<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product",
 *      operationId="browseProduct",
 *      tags={"product"},
 *      summary="Browse Product",
 *      description="Returns list of Product",
 *
 *      @OA\Parameter(
 *          name="page",
 *          example="1",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="limit",
 *          example="10",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="relation",
 *          example="productDetails,productCategory",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product/bin",
 *      operationId="browseProductBin",
 *      tags={"product"},
 *      summary="Browse Product Bin",
 *      description="Returns list of deleted Product",
 *
 *      @OA\Parameter(
 *          name="page",
 *          example="1",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="limit",
 *          example="10",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="relation",
 *          example="productDetails,productCategory",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product/read",
 *      operationId="readProduct",
 *      tags={"product"},
 *      summary="Read Product",
 *      description="Returns Product based on id",
 *
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="relation",
 *          example="productDetails,productCategory",
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Post(
 *      path="/module/commerce/v1/product/restore",
 *      operationId="restoreProduct",
 *      tags={"product"},
 *      summary="Restore Deleted Product",
 *      description="Restore a deleted product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *             )
 *         )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Post(
 *      path="/module/commerce/v1/product/restore-multiple",
 *      operationId="restoreMultipleProduct",
 *      tags={"product"},
 *      summary="Restore Multiple Deleted Product",
 *      description="Restore multiple deleted product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="ids",
 *                     type="string",
 *                     example="1,2,3,..."
 *                 ),
 *             )
 *         )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Post(
 *      path="/module/commerce/v1/product/add",
 *      operationId="addProduct",
 *      tags={"product"},
 *      summary="Insert Product",
 *      description="Insert new Product into database",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="product_category_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Intel Core i7-4790"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="string",
 *                     example="intel-i7"
 *                 ),
 *                 @OA\Property(
 *                     property="product_image",
 *                     type="string",
 *                     example="files/shares/image.png"
 *                 ),
 *                 @OA\Property(
 *                     property="desc",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *
 *                     @OA\Items(
 *
 *                         @OA\Property(
 *                             property="discount_id",
 *                             type="integer",
 *                             example="1",
 *                         ),
 *                         @OA\Property(
 *                             property="name",
 *                             type="string",
 *                             example="Intel Core i7-4790K",
 *                         ),
 *                         @OA\Property(
 *                             property="quantity",
 *                             type="integer",
 *                             example="10",
 *                         ),
 *                         @OA\Property(
 *                             property="price",
 *                             type="integer",
 *                             example="10000000",
 *                         ),
 *                         @OA\Property(
 *                             property="s_k_u",
 *                             type="string",
 *                             example="INT-I7-4790-K",
 *                         ),
 *                         @OA\Property(
 *                             property="product_image",
 *                             type="string",
 *                             example="files/shares/logo.png",
 *                         ),
 *                     )
 *                 ),
 *             )
 *         )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Put(
 *      path="/module/commerce/v1/product/edit",
 *      operationId="editProduct",
 *      tags={"product"},
 *      summary="Edit Product",
 *      description="Edit an existing Product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="product_category_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Intel Core i7-4750"
 *                 ),
 *                 @OA\Property(
 *                     property="desc",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="SKU",
 *                     type="string",
 *                     example="INT-I7-4750"
 *                 ),
 *             )
 *         )
 *      ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Delete(
 *      path="/module/commerce/v1/product/delete",
 *      operationId="deleteProduct",
 *      tags={"product"},
 *      summary="Delete Product",
 *      description="Delete one record of Product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="id",
 *                     type="object",
 *                     example="1"
 *                 ),
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Delete(
 *      path="/module/commerce/v1/product/force-delete",
 *      operationId="forceDeleteProduct",
 *      tags={"product"},
 *      summary="Force Delete Product",
 *      description="Force delete one record of Product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="id",
 *                     type="object",
 *                     example="1"
 *                 ),
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Delete(
 *      path="/module/commerce/v1/product/delete-multiple",
 *      operationId="deleteMultipleProduct",
 *      tags={"product"},
 *      summary="Delete Multiple Product",
 *      description="Delete multiple record of Product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="ids",
 *                     type="object",
 *                     example="1,2,3,..."
 *                 ),
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */

/**
 * @OA\Delete(
 *      path="/module/commerce/v1/product/force-delete-multiple",
 *      operationId="forceDeleteMultipleProduct",
 *      tags={"product"},
 *      summary="Force Delete Multiple Product",
 *      description="Force delete multiple record of Product",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="ids",
 *                     type="object",
 *                     example="1,2,3,..."
 *                 ),
 *             )
 *         )
 *     ),
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */
