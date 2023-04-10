<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/cart",
 *      operationId="browseCart",
 *      tags={"cart"},
 *      summary="Browse Cart",
 *      description="Returns list of Cart",
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
 *      @OA\Parameter(
 *          name="limit",
 *          required=true,
 *          in="query",
 *          example="10",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="relation",
 *          required=false,
 *          in="query",
 *          example="productDetail,user",
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
 *      path="/module/commerce/v1/cart/read",
 *      operationId="readCart",
 *      tags={"cart"},
 *      summary="Read Cart",
 *      description="Return a cart",
 *
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="query",
 *          example="1",
 *
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="relation",
 *          required=false,
 *          in="query",
 *          example="productDetail,user",
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
