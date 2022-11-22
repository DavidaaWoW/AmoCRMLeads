<?php

namespace App\View\Composers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

class UserComposer
{

    public function __construct()
    {
    }

    public function compose(ViewView $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $view->with('user', $user);
        }
        else{
            $view->with('user', null);
        }
    }
}
