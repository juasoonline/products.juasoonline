<?php

namespace App\Repositories\Juasoonline\Juaso\Group;

use App\Http\Resources\Juaso\Resource\Group\GroupResource;
use App\Models\Juaso\Group\Group;

use App\Traits\apiResponseBuilder;
use App\Traits\Relatives;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JuasoonlineGroupRepository implements JuasoonlineGroupRepositoryInterface
{
    use apiResponseBuilder, Relatives;

    /**
     * @return JsonResponse
     */
    public function getGroups() : JsonResponse
    {
        $Group = Group::query() -> when( $this -> loadRelationships(), function ( Builder $builder ) { return $builder -> with ( $this -> relationships ); } ) -> get();
        return $this -> successResponse( GroupResource::collection( $Group ), "Success", null, Response::HTTP_OK );
    }

    /**
     * @param Group $group
     * @return JsonResponse
     */
    public function getGroup( Group $group ) : JsonResponse
    {
        if ( $this -> loadRelationships() ) { $group -> load( $this -> relationships ); }
        return $this -> successResponse( new GroupResource( $group ), "Success", null, Response::HTTP_OK );
    }
}
