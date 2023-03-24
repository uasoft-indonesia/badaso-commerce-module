<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/discount",
 *      operationId="browseDiscount",
 *      tags={"discount"},
 *      summary="Browse Discount",
 *      description="Returns list of Discount",
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
 *      path="/module/commerce/v1/discount/bin",
 *      operationId="browseDiscountBin",
 *      tags={"discount"},
 *      summary="Browse Discount Bin",
 *      description="Returns list of deleted Discount",
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
 *      path="/module/commerce/v1/discount/read",
 *      operationId="readDiscount",
 *      tags={"discount"},
 *      summary="Get Discount based on id",
 *      description="Returns Discount based on id",
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
 *      path="/module/commerce/v1/discount/restore",
 *      operationId="restoreDiscount",
 *      tags={"discount"},
 *      summary="Restore Deleted Discount",
 *      description="Restore a deleted discount",
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
 *      path="/module/commerce/v1/discount/restore-multiple",
 *      operationId="restoreMultipleDiscount",
 *      tags={"discount"},
 *      summary="Restore Multiple Deleted Discount",
 *      description="Restore multiple deleted discount",
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
 *      path="/module/commerce/v1/discount/add",
 *      operationId="addDiscount",
 *      tags={"discount"},
 *      summary="Insert Discount",
 *      description="Insert new Discount into database",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="New Year Discount"
 *                 ),
 *                 @OA\Property(
 *                     property="desc",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="discount_type",
 *                     type="string",
 *                     example="fixed"
 *                 ),
 *                 @OA\Property(
 *                     property="discount_percent",
 *                     type="integer",
 *                     example="0"
 *                 ),
 *                 @OA\Property(
 *                     property="discount_fixed",
 *                     type="integer",
 *                     example="10000"
 *                 ),
 *                 @OA\Property(
 *                     property="active",
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
 * @OA\Put(
 *      path="/module/commerce/v1/discount/edit",
 *      operationId="editDiscount",
 *      tags={"discount"},
 *      summary="Edit Discount",
 *      description="Edit an existing Discount",
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
 *                     property="name",
 *                     type="string",
 *                     example="New Year Discount"
 *                 ),
 *                 @OA\Property(
 *                     property="desc",
 *                     type="string",
 *                     example=""
 *                 ),
 *                 @OA\Property(
 *                     property="discount_type",
 *                     type="string",
 *                     example="fixed"
 *                 ),
 *                 @OA\Property(
 *                     property="discount_percent",
 *                     type="integer",
 *                     example="0"
 *                 ),
 *                 @OA\Property(
 *                     property="discount_fixed",
 *                     type="integer",
 *                     example="10000"
 *                 ),
 *                 @OA\Property(
 *                     property="active",
 *                     type="integer",
 *                     example="0"
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
 *      path="/module/commerce/v1/discount/delete",
 *      operationId="deleteDiscount",
 *      tags={"discount"},
 *      summary="Delete Discount",
 *      description="Delete one record of Discount",
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
 *      path="/module/commerce/v1/discount/force-delete",
 *      operationId="forceDeleteDiscount",
 *      tags={"discount"},
 *      summary="Force Delete Discount",
 *      description="Force delete one record of Discount",
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
 *      path="/module/commerce/v1/discount/delete-multiple",
 *      operationId="deleteMultipleDiscount",
 *      tags={"discount"},
 *      summary="Delete Multiple Discount",
 *      description="Delete multiple record of Discount",
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
 *      path="/module/commerce/v1/discount/force-delete-multiple",
 *      operationId="forceDeleteMultipleDiscount",
 *      tags={"discount"},
 *      summary="Force Delete Multiple Discount",
 *      description="Force delete multiple record of Discount",
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
