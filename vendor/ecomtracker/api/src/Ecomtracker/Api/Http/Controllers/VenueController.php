<?php namespace Ecomtracker\Api\Http\Controllers;

use EcomTracker\Exceptions\ApiException;
use Ecomtracker\Venue\Http\Requests\ShowRequest;
use Ecomtracker\Venue\Http\Requests\DestroyRequest;
use Ecomtracker\Venue\Http\Requests\StoreRequest;
use Ecomtracker\Venue\Http\Requests\UpdateRequest;


/**
 * Class VenueController
 *
 * @package Ecomtracker\Api\Http\Controllers
 */

class VenueController extends \Ecomtracker\Venue\Http\Controllers\VenueController
{
    /**
     * Show the Venue Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/venue/{id}",
     *     description="Returns a venue object",
     *     operationId="api1.venue.show",
     *     produces={"application/json"},
     *     tags={"venue"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
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


    public function show(ShowRequest $request, $id = null)
    {
        return parent::show($request,$id);
    }


    /**
     * Create a venue related to a user if the user id is present tie the user to that venue otherwise default to the auth user
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Post(
     *     path="/api1/venue",
     *     description="Create a venue object",
     *     operationId="api1.venue.store",
     *     produces={"application/json"},
     *     tags={"venue"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="user_id",
     *          in="formData",
     *          type="string",
     *          required=false,
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

    public function store(StoreRequest $request)
    {
        return parent::store($request);
    }



    /**
     * Update a venue record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Put(
     *     path="/api1/venue/{id}",
     *     description="Create a venue object",
     *     operationId="api1.venue.update",
     *     produces={"application/json"},
     *     tags={"venue"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="value",
     *          in="formData",
     *          type="string",
     *          required=true,
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

    public function update(UpdateRequest $request, $id = null)
    {
        return parent::update($request,$id);
    }



    /**
     * Destroy a venue record
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Delete(
     *     path="/api1/venue/{id}",
     *     description="Destroy a venue object",
     *     operationId="api1.venue.destroy",
     *     produces={"application/json"},
     *     tags={"venue"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
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



    public function destroy(DestroyRequest $request, $id = null)
    {
        try{
            $response = parent::destroy($request,$id);
        }catch(ApiException $e)
        {


        }


    }





}