<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sortByDate($a, $b)
    {
        if (!$a->updated_at) {
            $a->updated_at = $a->created_at;
        }
        if (!$b->updated_at) {
            $b->updated_at = $b->created_at;
        }

        if ($a->updated_at == $b->updated_at) {
            return 0;
        }
        return ($a->updated_at > $b->updated_at) ? -1 : 1;
    }
}
