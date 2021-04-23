<?php

namespace App\Jobs\Product\Review;

use App\Http\Requests\Product\Review\ReviewRequest;
use App\Http\Resources\Product\Review\ReviewResource;
use App\Models\Product\Review\Review;
use App\Traits\apiResponseBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class CreateReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, apiResponseBuilder;
    private ReviewRequest $theRequest;

    /**
     * Create a new job instance.
     *
     * @param ReviewRequest $reviewRequest
     */
    public function __construct( ReviewRequest $reviewRequest )
    {
        return $this -> theRequest = $reviewRequest;
    }

    /**
     * Execute the job.
     *
     * @return ReviewResource|mixed
     */
    public function handle(): ReviewResource
    {
        try
        {
            $Review = new Review( $this -> theRequest -> input( 'data.attributes' ) );
            $Review -> product() -> associate( $this -> theRequest [ 'data.relationships.product.product_id' ] );
            $Review -> save();

            $Review -> refresh();
            return ( new ReviewResource( $Review ) );
        }
        catch ( Exception $exception )
        {
            report( $exception );
            return abort( $this -> errorResponse( null, 'Error', 'Something went wrong, please try again later', Response::HTTP_SERVICE_UNAVAILABLE ) );
        }
    }
}
