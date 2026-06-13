<?php

namespace App\Http\Controllers;

use App\Models\EventPackage;
use Illuminate\View\View;

class EventServicesController extends Controller
{
    public function __invoke(): View
    {
        return view('event-services.index', [
            'eventPackages' => EventPackage::query()->active()->ordered()->get(),
        ]);
    }
}
