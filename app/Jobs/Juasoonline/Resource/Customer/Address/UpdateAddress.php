<?php

namespace App\Jobs\Juasoonline\Resource\Customer\Address;

use App\Http\Requests\Juasoonline\Resource\Customer\Address\AddressRequest;
use App\Http\Resources\Juasoonline\Resource\Customer\Address\AddressResource;
use App\Models\Juasoonline\Customer\Address\Address;

use App\Traits\apiResponseBuilder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class UpdateAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, apiResponseBuilder;
    private AddressRequest $theRequest; private Address $theModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( AddressRequest $addressRequest, Address $address )
    {
        $this -> theRequest     = $addressRequest;
        $this -> theModel       = $address;
    }

    /**
     * Execute the job.
     *
     * @return AddressResource|mixed
     */
    public function handle() : AddressResource
    {
        try
        {
            $this -> theModel -> update( $this -> theRequest -> validated()[ 'data' ][ 'attributes' ] );
            return new AddressResource( $this -> theModel );
        }
        catch ( Exception $exception )
        {
            report( $exception );
            return abort( $this -> errorResponse( null, 'Error', 'Something went wrong, please try again later', Response::HTTP_SERVICE_UNAVAILABLE ) );
        }
    }
}
