<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/order",
 *      operationId="browseOrder",
 *      tags={"order"},
 *      summary="Browse Order",
 *      description="Returns list of Order",
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
 *          example="orderDetails,user",
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
 *      path="/module/commerce/v1/order/read",
 *      operationId="readOrder",
 *      tags={"order"},
 *      summary="Get Order based on id",
 *      description="Returns Order based on id",
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
 *          example="orderDetails,user",
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
 *      path="/module/commerce/v1/order/confirm",
 *      operationId="confirmOrder",
 *      tags={"order"},
 *      summary="Confirm An Order",
 *      description="Set an Order status to processing",
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
 *      path="/module/commerce/v1/order/reject",
 *      operationId="rejectOrder",
 *      tags={"order"},
 *      summary="Reject An Order",
 *      description="Set an Order status to failed",
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
 *      path="/module/commerce/v1/order/ship",
 *      operationId="shipOrder",
 *      tags={"order"},
 *      summary="Ship An Order",
 *      description="Set an Order status to shipping",
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
 *      path="/module/commerce/v1/order/tracking-number",
 *      operationId="trackingNumberOrder",
 *      tags={"order"},
 *      summary="Tracking Number",
 *      description="Set tracking number to the order",
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
 *                     property="tracking_number",
 *                     type="string",
 *                     example="LOREM12312323"
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
 *      path="/module/commerce/v1/order/done",
 *      operationId="doneOrder",
 *      tags={"order"},
 *      summary="Done Order",
 *      description="Set done status to the order",
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
