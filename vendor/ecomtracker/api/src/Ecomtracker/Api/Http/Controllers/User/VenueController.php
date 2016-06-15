<?php namespace Ecomtracker\Api\Http\Controllers\User;

use Ecomtracker\User\Http\Requests\Venue\ShowRequest;

class VenueController extends \Ecomtracker\User\Http\Controllers\VenueController
{

    /**
     * Return Venue Collection based on the user id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/user/{id}/venues",
     *     description="Returns a collection of venue objects related to user by user id",
     *     operationId="api1.user.venue.show",
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
        return parent::show($request, $id);
    }

}