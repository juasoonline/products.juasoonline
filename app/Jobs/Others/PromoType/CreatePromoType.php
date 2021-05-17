<?php

namespace App\Jobs\Others\PromoType;

use App\Http\Requests\Others\PromoType\PromoTypeRequest;
use App\Http\Resources\Others\PromoType\PromoTypeResource;
use App\Http\Resources\Product\Promotion\PromotionResource;
use App\Models\Others\PromoType\PromoType;
use App\Traits\apiResponseBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class CreatePromoType implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, apiResponseBuilder;
    private PromoTypeRequest $theRequest;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( PromoTypeRequest $promoTypeRequest )
    {
        $this -> theRequest = $promoTypeRequest;
    }

    /**
     * Execute the job.
     *
     * @return PromoTypeResource|mixed
     */
    public function handle() : PromoTypeResource
    {
        try
        {
            $PromoType = new PromoType( $this -> theRequest -> input( 'data.attributes' ) );
            $PromoType -> save();

            $PromoType -> refresh();
            return ( new PromoTypeResource( $PromoType ) );
        }
        catch ( Exception $exception )
        {
            report( $exception );
            return abort( $this -> errorResponse( null, 'Error', 'Something went wrong, please try again later', Response::HTTP_SERVICE_UNAVAILABLE ) );
        }
    }
}
