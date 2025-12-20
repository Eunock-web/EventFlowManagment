<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Events\CreateEventRequest;
use App\Models\Event;
use Carbon\Carbon;

class EventsController extends Controller
{

    public function index(){
        $data = Events::all();

        if(!$data){
            return new JsonResponse([
                'message' => 'Aucune donnée récupérée'
            ], );
        }else{
            return new JsonResponse([
                'message' => 'Donnée reçu avec success',
                'data' => $data
            ]);
        }
    }

    public function create(CreateEventRequest $request){
        $data = $request->validated();
        $url_image = null;

            // 1. Formater les dates pour MySQL (Y-m-d)
        if (isset($data['start'])) {
            $data['start'] = Carbon::parse($data['start'])->format('Y-m-d');
        }
        if (isset($data['end'])) {
            $data['end'] = Carbon::parse($data['end'])->format('Y-m-d');
        }

        if($request->hasFile('image')){
            $image =  $request->file('image');

            //Enregistrement physique
                $filename = time() . '.' . $image->getClientOriginalExtension(); 
                $path = $image->storeAs('events',$filename, 'public');
                $data['url_image'] = $path;

        }
            $data['user_id'] = 1;
            //Enregistrement du chemain de l'image dans la base de donnée
                $event = Event::create($data);

                if ($event) {
                    return response()->json([
                        'message' => 'Événement créé avec succès',
                        'data' => $event,
                        'image_url' => asset('storage/' . $event->url_image)
                    ], 201);
                }else{
                    return new JsonResponse([
                        'response' => 'Erreur lors de la creation de l\'evenement',                        
                    ], 500);
                }
    }   
}
