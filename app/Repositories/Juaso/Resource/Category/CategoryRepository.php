<?php

namespace App\Repositories\Juaso\Resource\Category;

use App\Http\Requests\Juaso\Resource\Category\CategoryRequest;
use App\Http\Resources\Juaso\Resource\Category\CategoryResource;
use App\Jobs\Juaso\Resource\Category\CreateCategory;
use App\Jobs\Juaso\Resource\Category\UpdateCategory;
use App\Models\Juaso\Category\Category;

use App\Traits\apiResponseBuilder;
use App\Traits\Relatives;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryRepository implements CategoryRepositoryInterface
{
    use apiResponseBuilder, Relatives;

    /**
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $Category = Category::query() -> when( $this -> loadRelationships(), function ( Builder $builder ) { return $builder -> with ( $this -> relationships ); }) -> get();
        return $this -> successResponse( CategoryResource::collection( $Category ), "Success", null, Response::HTTP_OK );
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @return JsonResponse|mixed
     */
    public function store( CategoryRequest $categoryRequest ) : JsonResponse
    {
        return $this -> successResponse( ( new CreateCategory( $categoryRequest ) ) -> handle(), "Success", "Category created", Response::HTTP_CREATED );
    }

    /**
     * @param Category $category
     * @return JsonResponse|mixed
     */
    public function show( Category $category ) : JsonResponse
    {
        if ( $this -> loadRelationships() ) { $category -> load( $this -> relationships ); }
        return $this -> successResponse( new CategoryResource( $category ), "Success", null, Response::HTTP_OK );
    }

    /**
     * @param CategoryRequest $categoryRequest
     * @param Category $category
     * @return JsonResponse|mixed
     */
    public function update( CategoryRequest $categoryRequest, Category $category ) : JsonResponse
    {
        return $this -> successResponse( ( new UpdateCategory( $categoryRequest, $category ) ) -> handle(), 'Success', 'Category updated', Response::HTTP_OK );
    }

    /**
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy( Category $category ) : JsonResponse
    {
        $category -> delete();
        return $this -> successResponse( null, 'Success', 'Category deleted', Response::HTTP_NO_CONTENT );
    }
}
