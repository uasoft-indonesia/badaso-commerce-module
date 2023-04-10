<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/cart/public",
 *      operationId="browseCartPublic",
 *      tags={"cart"},
 *      summary="Browse Cart (Public)",
 *      description="Returns list of cart for public use",
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
 *      path="/module/commerce/v1/cart/public/add",
 *      operationId="addCartPublic",
 *      tags={"cart"},
 *      summary="Insert Cart (Public)",
 *      description="Add new Cart based on user logged in for public use",
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
 *                     property="quantity",
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
 *      path="/module/commerce/v1/cart/public/edit",
 *      operationId="editCartPublic",
 *      tags={"cart"},
 *      summary="Edit Cart (Public)",
 *      description="Edit an existing Cart for public use",
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
 *                     property="quantity",
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
 * @OA\Delete(
 *      path="/module/commerce/v1/cart/public/delete",
 *      operationId="deleteCartPublic",
 *      tags={"cart"},
 *      summary="Delete Cart (Public)",
 *      description="Delete one record of Cart for public use",
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
