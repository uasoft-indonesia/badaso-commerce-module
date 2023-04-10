<?php

/**
 * @OA\Post(
 *      path="/module/commerce/v1/product-detail/add",
 *      operationId="addProductDetail",
 *      tags={"product-detail"},
 *      summary="Insert Product Detail",
 *      description="Insert new Product Detail into database",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="product_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="discount_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Intel Core i7-4790K"
 *                 ),
 *                 @OA\Property(
 *                     property="quantity",
 *                     type="string",
 *                     example="100"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="string",
 *                     example="10000000"
 *                 ),
 *                 @OA\Property(
 *                     property="s_k_u",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="product_image",
 *                     type="string",
 *                     example="files/shares/image.png"
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
 *      path="/module/commerce/v1/product-detail/edit",
 *      operationId="editProductDetail",
 *      tags={"product-detail"},
 *      summary="Edit Product Detail",
 *      description="Edit an existing Product Detail",
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
 *                     property="product_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="discount_id",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Intel Core i7-4790K"
 *                 ),
 *                 @OA\Property(
 *                     property="quantity",
 *                     type="string",
 *                     example="100"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="string",
 *                     example="10000000"
 *                 ),
 *                 @OA\Property(
 *                     property="s_k_u",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="product_image",
 *                     type="string",
 *                     example="files/shares/image.png"
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
 *      path="/module/commerce/v1/product-detail/delete",
 *      operationId="deleteProductDetail",
 *      tags={"product-detail"},
 *      summary="Delete Product Detail",
 *      description="Delete one record of Product Detail",
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
