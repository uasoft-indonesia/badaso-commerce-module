<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product-category",
 *      operationId="browseProductCategory",
 *      tags={"product-category"},
 *      summary="Browse Product Category",
 *      description="Returns list of Product Category",
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
 *      path="/module/commerce/v1/product-category/bin",
 *      operationId="browseProductCategoryBin",
 *      tags={"product-category"},
 *      summary="Browse Product Category Bin",
 *      description="Returns list of deleted Product Category",
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
 *      path="/module/commerce/v1/product-category/read",
 *      operationId="readProductCategory",
 *      tags={"product-category"},
 *      summary="Read Product Category",
 *      description="Returns Product Category based on id",
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
 *      path="/module/commerce/v1/product-category/restore",
 *      operationId="restoreProductCategory",
 *      tags={"product-category"},
 *      summary="Restore Deleted Product Category",
 *      description="Restore a deleted product category",
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
 *      path="/module/commerce/v1/product-category/restore-multiple",
 *      operationId="restoreMultipleProductCategory",
 *      tags={"product-category"},
 *      summary="Restore Multiple Deleted Product Category",
 *      description="Restore multiple deleted product category",
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
 *      path="/module/commerce/v1/product-category/add",
 *      operationId="addProductCategory",
 *      tags={"product-category"},
 *      summary="Insert Product Category",
 *      description="Insert new Product Category into database",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="parent_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Electronic"
 *                 ),
 *                 @OA\Property(
 *                     property="slug",
 *                     type="string",
 *                     example="electronic"
 *                 ),
 *                 @OA\Property(
 *                     property="desc",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="SKU",
 *                     type="string",
 *                     example="ELC"
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
 *      path="/module/commerce/v1/product-category/edit",
 *      operationId="editProductCategory",
 *      tags={"product-category"},
 *      summary="Edit Product Category",
 *      description="Edit an existing Product Category",
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
 *                     property="parent_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Electronic"
 *                 ),
 *                 @OA\Property(
 *                     property="desc",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="SKU",
 *                     type="string",
 *                     example="ELC"
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
 *      path="/module/commerce/v1/product-category/delete",
 *      operationId="deleteProductCategory",
 *      tags={"product-category"},
 *      summary="Delete Product Category",
 *      description="Delete one record of Product Category",
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
 *      path="/module/commerce/v1/product-category/force-delete",
 *      operationId="forceDeleteProductCategory",
 *      tags={"product-category"},
 *      summary="Force Delete Product Category",
 *      description="Force delete one record of Product Category",
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
 *      path="/module/commerce/v1/product-category/delete-multiple",
 *      operationId="deleteMultipleProductCategory",
 *      tags={"product-category"},
 *      summary="Delete Multiple Product Category",
 *      description="Delete multiple record of Product Category",
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
 *      path="/module/commerce/v1/product-category/force-delete-multiple",
 *      operationId="forceDeleteMultipleProductCategory",
 *      tags={"product-category"},
 *      summary="Force Delete Multiple Product Category",
 *      description="Force delete multiple record of Product Category",
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
