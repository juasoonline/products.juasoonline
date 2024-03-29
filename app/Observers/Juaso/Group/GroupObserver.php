<?php

namespace App\Observers\Juaso\Group;

use App\Models\Juaso\Group\Group;
use Illuminate\Support\Str;

class GroupObserver
{
    /**
     * @param Group $group
     */
    public function creating( Group $group )
    {
        $group -> resource_id = uniqid();
        $group -> slug = Str::slug( $group -> name );
    }
}
