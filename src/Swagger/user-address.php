<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/user-address",
 *      operationId="browseUserAddress",
 *      tags={"user-address"},
 *      summary="Browse User Address",
 *      description="Returns list of User Address",
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
 *          example="user",
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
 *      path="/module/commerce/v1/user-address/read",
 *      operationId="readUserAddress",
 *      tags={"user-address"},
 *      summary="Read User Address",
 *      description="Returns User Address based on id",
 *
 *      @OA\Parameter(
 *          name="id",
 *          required=true,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="relation",
 *          example="user",
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
