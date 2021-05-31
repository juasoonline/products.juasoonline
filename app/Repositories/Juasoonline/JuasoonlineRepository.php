<?php

namespace App\Repositories\Juasoonline;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product\Product;
use App\Traits\apiResponseBuilder;
use App\Traits\Relatives;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class JuasoonlineRepository implements JuasoonlineRepositoryInterface
{
    use apiResponseBuilder, Relatives;

    /**
     * @return AnonymousResourceCollection
     */
    public function products() : AnonymousResourceCollection
    {
        $Product = Product::query() -> when( $this -> loadRelationships(), function ( Builder $builder ) { return $builder -> with ( $this -> relationships ); }) -> paginate('100');
        return ProductResource::collection( $Product );
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function product( Product $product ) : JsonResponse
    {
        if ( $this -> loadRelationships() ) { $product -> load( $this -> relationships ); }
        return $this -> successResponse( new ProductResource( $product ), "Success", null, Response::HTTP_OK );
    }

    /**
     * @param $product
     * @return JsonResponse
     */
    public function recommendations( $product ) : JsonResponse
    {
//        $result = Product::with('categories' ) -> findOrFail(1 );
//        $categoryIds = $result -> categories -> pluck( 'id' ) -> toArray();
//
//        $similarProducts = Product::has('categories', function ( $query ) use ( $categoryIds )
//        {
//            return $query->whereIn('id', $categoryIds);
//        })->whereNot( 'id', $product -> id ) -> limit(10) -> get();
//
//        return $similarArtists;
    }
}