<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/order/public",
 *      operationId="browseOrderPublic",
 *      tags={"order"},
 *      summary="Browse Order (Public)",
 *      description="Returns list of order for public use",
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
 *      path="/module/commerce/v1/order/public/pay",
 *      operationId="payOrderPublic",
 *      tags={"order"},
 *      summary="Pay Order (Public)",
 *      description="Insert a proof of transaction of the order",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="id",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="upload",
 *                     type="string",
 *                     example="1",
 *                     format="binary"
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
 *      path="/module/commerce/v1/order/public/finish",
 *      operationId="finishOrderPublic",
 *      tags={"order"},
 *      summary="Finish Order (Public)",
 *      description="Finish a checkout for public use",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *
 *                     @OA\Items(
 *
 *                         @OA\Property(property="id", type="string"),
 *                     ),
 *                 ),
 *                 @OA\Property(
 *                     property="provider_id",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="user_address_id",
 *                     type="object",
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
 * @OA\Put(
 *      path="/module/commerce/v1/order/public/edit-address",
 *      operationId="editOrderAddressPublic",
 *      tags={"order"},
 *      summary="Edit Order Address (Public)",
 *      description="Edit an existing order address for public use",
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
 *                 @OA\Property(
 *                     property="recipient_name",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="address_line1",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="address_line2",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="city",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="postal_code",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="country",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="telephone",
 *                     type="object",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="mobile",
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
