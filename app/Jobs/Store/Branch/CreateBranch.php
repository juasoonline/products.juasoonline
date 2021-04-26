<?php

namespace App\Jobs\Store\Branch;

use App\Http\Requests\Store\Branch\BranchRequest;
use App\Http\Resources\Store\Branch\BranchResource;
use App\Models\Store\Branch\Branch;
use App\Traits\apiResponseBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class CreateBranch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use apiResponseBuilder; private BranchRequest $theRequest;

    /**
     * CreateBranch constructor.
     * @param BranchRequest $branchRequest
     */
    public function __construct( BranchRequest  $branchRequest )
    {
        $this -> theRequest = $branchRequest;
    }

    /**
     * @return BranchResource|mixed
     */
    public function handle(): BranchResource
    {
        try
        {
            $Branch = new Branch( $this -> theRequest -> input( 'data.attributes' ) );
            $Branch -> store() -> associate( $this -> theRequest [ 'data.relationships.store.store_id' ] );
            $Branch -> save();

            $Branch -> refresh();
            return ( new BranchResource( $Branch ) );
        }
        catch ( Exception $exception )
        {
            report( $exception );
            return abort( $this -> errorResponse( null, 'Error', 'Something went wrong, please try again later', Response::HTTP_SERVICE_UNAVAILABLE ) );
        }
    }
}
