<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product-category/public",
 *      operationId="browseProductCategoryPublic",
 *      tags={"product-category"},
 *      summary="Browse Product Category (Public)",
 *      description="Returns list of product category for public use",
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product-category/public/read",
 *      operationId="readProductCategoryPublic",
 *      tags={"product-category"},
 *      summary="Browse Product Category (Public)",
 *      description="Read a product category for public use",
 *
 *      @OA\Parameter(
 *          name="slug",
 *          required=true,
 *          in="query",
 *          example="slug-category-product",
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
 * )
 */
