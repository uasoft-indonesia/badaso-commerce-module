<?php

/**
 * @OA\Get(
 *      path="/module/commerce/v1/provider/public",
 *      operationId="browsePaymentProviderPublic",
 *      tags={"payment-provider"},
 *      summary="Browse Payment Provider (Public)",
 *      description="Returns list of payment provider for public use",
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
