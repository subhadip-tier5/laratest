<?php namespace Ecomtracker\Api\Http\Controllers\Venue;

use Ecomtracker\Venue\Http\Requests\Config\ShowRequest;
use Ecomtracker\Venue\Http\Requests\Config\UpdateRequest;

class ConfigController extends \Ecomtracker\Venue\Http\Controllers\ConfigController
{

    /**
     * Return Venue Collection based on the user id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/venue/{id}/config",
     *     description="Returns a configuration object related to the venue",
     *     operationId="api1.user.venue.config.show",
     *     produces={"application/json"},
     *     tags={"venue"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *          description="Auth Token"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
     *          description="Venue Id"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */


    public function show(ShowRequest $request, $venue_id = null)
    {
        return parent::show($request, $venue_id);
    }


    /**
     * Update a venue's config
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/venue/{id}/config",
     *     description="Update a venue config, create it if it doesn't exist",
     *     operationId="api.venue.config.update",
     *     produces={"application/json"},
     *     tags={"venue"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *          description="Auth Token"
     *      ),
     *      @SWG\Parameter(
     *          name="SellerId",
     *          in="formData",
     *          type="string",
     *          description="Amazon Seller Id",
     *          required=false
     *      ),
     *      @SWG\Parameter(
     *          name="MWSAuthToken",
     *          in="formData",
     *          type="string",
     *          description="Amazon MWSAuthToken",
     *          required=false
     *      ),
     *      @SWG\Parameter(
     *          name="AWSAccessKeyId",
     *          in="formData",
     *          type="string",
     *          description="Amazon AWSAccessKeyId",
     *          required=false
     *      ),
     *      @SWG\Parameter(
     *          name="SecretKey",
     *          in="formData",
     *          type="string",
     *          description="Amazon Secret Key",
     *          required=false
     *      ),
     *      @SWG\Parameter(
     *          name="data",
     *          in="formData",
     *          type="string",
     *          description="Amazon Secret Key"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
     *          description="Venue Id"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */
    public function update(UpdateRequest $request, $venue_id = null)
    {
        try{
            return parent::update($request, $venue_id);
        } catch (\Exception $e)
        {
            return response('Failure in updating venue configuration: ' . $e->getMessage(),500);
        }

    }
}