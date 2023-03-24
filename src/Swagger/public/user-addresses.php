<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/user-address/public",
 *      operationId="browseUserAddressPublic",
 *      tags={"user-address"},
 *      summary="Browse User Address (Public)",
 *      description="Returns list of user address for public use",
 *
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Get(
 *      path="/module/commerce/v1/user-address/public/read",
 *      operationId="readUserAddressPublic",
 *      tags={"user-address"},
 *      summary="Browse User Address (Public)",
 *      description="Read a user address for public use",
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
 *      @OA\Response(response=200, description="Successful operation"),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=401, description="Unauthorized"),
 *      @OA\Response(response=402, description="Payment Required"),
 * )
 */

/**
 * @OA\Post(
 *      path="/module/commerce/v1/user-address/public/add",
 *      operationId="addUserAddressPublic",
 *      tags={"user-address"},
 *      summary="Add User Address (Public)",
 *      description="Insert new user address for public use",
 *
 *      @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                     property="recipient_name",
 *                     type="object",
 *                     example="John Doe",
 *                 ),
 *                 @OA\Property(
 *                     property="address_line1",
 *                     type="object",
 *                     example="Lorem Ipsum Street"
 *                 ),
 *                 @OA\Property(
 *                     property="address_line2",
 *                     type="object",
 *                     example="Lorem Ipsum Apt"
 *                 ),
 *                 @OA\Property(
 *                     property="city",
 *                     type="object",
 *                     example="Jakarta"
 *                 ),
 *                 @OA\Property(
 *                     property="postal_code",
 *                     type="object",
 *                     example="75512"
 *                 ),
 *                 @OA\Property(
 *                     property="country",
 *                     type="object",
 *                     example="Indonesia"
 *                 ),
 *                 @OA\Property(
 *                     property="telephone",
 *                     type="object",
 *                     example="075113231"
 *                 ),
 *                 @OA\Property(
 *                     property="mobile",
 *                     type="object",
 *                     example="+6281233213322"
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
 *      path="/module/commerce/v1/user-address/public/edit",
 *      operationId="editUserAddressPublic",
 *      tags={"user-address"},
 *      summary="Edit User Address (Public)",
 *      description="Edit an existing user address for public use",
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
 *                     example="1",
 *                 ),
 *                 @OA\Property(
 *                     property="recipient_name",
 *                     type="object",
 *                     example="John Doe",
 *                 ),
 *                 @OA\Property(
 *                     property="address_line1",
 *                     type="object",
 *                     example="Lorem Ipsum Street"
 *                 ),
 *                 @OA\Property(
 *                     property="address_line2",
 *                     type="object",
 *                     example="Lorem Ipsum Apt"
 *                 ),
 *                 @OA\Property(
 *                     property="city",
 *                     type="object",
 *                     example="Jakarta"
 *                 ),
 *                 @OA\Property(
 *                     property="postal_code",
 *                     type="object",
 *                     example="75512"
 *                 ),
 *                 @OA\Property(
 *                     property="country",
 *                     type="object",
 *                     example="Indonesia"
 *                 ),
 *                 @OA\Property(
 *                     property="telephone",
 *                     type="object",
 *                     example="075113231"
 *                 ),
 *                 @OA\Property(
 *                     property="mobile",
 *                     type="object",
 *                     example="+6281233213322"
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
 *      path="/module/commerce/v1/user-address/public/delete",
 *      operationId="deleteUserAddressPublic",
 *      tags={"user-address"},
 *      summary="Delete User Address (Public)",
 *      description="Delete an existing user address for public use",
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
 *                     example="1",
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
