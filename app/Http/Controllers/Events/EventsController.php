<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Events\CreateEventRequest;

class EventsController extends Controller
{
    public function create(CreateEventRequest $request){
        $credentials = $request->validated();
        $url_image = $credentials['image'];

        return new Jsonresponse([
            
        ]);
    }   
}
