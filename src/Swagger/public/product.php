<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product/public",
 *      operationId="browseProductPublic",
 *      tags={"product"},
 *      summary="Browse Product (Public)",
 *      description="Returns list of product for public use",
 *
 *      @OA\Parameter(
 *          name="page",
 *          required=true,
 *          in="query",
 *          example="1",
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
 * )
 */

/**
 * @OA\Get(
 *      path="/module/commerce/v1/product/public/read",
 *      operationId="readProductPublic",
 *      tags={"product"},
 *      summary="Browse Product (Public)",
 *      description="Read a product for public use",
 *
 *      @OA\Parameter(
 *          name="slug",
 *          required=true,
 *          in="query",
 *          example="example-product-slug",
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
