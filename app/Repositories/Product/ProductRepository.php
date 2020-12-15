<?php

namespace App\Repositories\Product;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Jobs\Product\StoreProduct;
use App\Jobs\Product\UpdateProduct;
use App\Models\Product\Product;
use App\Traits\apiResponseBuilder;
use App\Traits\Relatives;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductRepository implements ProductRepositoryInterface
{
    use apiResponseBuilder; use Relatives;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $Group = Product::query() -> when( $this -> loadRelationships(), function ( Builder $builder ) { return $builder -> with ( $this -> relationships ); } ) -> paginate( 20 );
        return $this -> successResponse( ProductResource::collection( $Group ), "Success", null, Response::HTTP_OK );
    }

    /**
     * @param ProductRequest $productRequest
     * @return JsonResponse
     */
    public function store( ProductRequest $productRequest )
    {
        return $this -> successResponse( ( new StoreProduct( $productRequest ) ) -> handle(), "Success", "Product created successfully", Response::HTTP_CREATED );
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show( Product $product )
    {
        if ( $this -> loadRelationships() ) { $product -> load( $this -> relationships ); }
        return $this -> successResponse( new ProductResource( $product ), "Success", null, Response::HTTP_OK );
    }

    /**
     * @param ProductRequest $productRequest
     * @param Product $product
     * @return JsonResponse
     */
    public function update( ProductRequest $productRequest, Product $product )
    {
        return $this -> successResponse( ( new UpdateProduct( $productRequest, $product ) ) -> handle(), 'Success', 'Product updated successfully', Response::HTTP_OK );
    }

    /**
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     */
    public function delete( Product $product )
    {
        $product -> delete();
        return $this -> successResponse( null, 'Success', 'Product deleted successfully', Response::HTTP_NO_CONTENT );
    }
}
