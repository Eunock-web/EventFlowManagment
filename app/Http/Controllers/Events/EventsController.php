<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Events\CreateEventRequest;
use App\Models\Event;
use Carbon\Carbon;

class EventsController extends Controller
{
    //Fonction pour recuperer toutes les evenments créer
    public function index(){
        $data = Event::all();

        if(!$data){
            return new JsonResponse([
                'response' => 'Aucune donnée récupérée'
            ], );
        }else{
            return new JsonResponse([
                'response' => 'Donnée reçu avec success',
                'data' => $data
            ]);
        }
    }


    //Fonction de recuperation d'un evenement specifique
    public function event($id){
        $event = Event::find($id);
        if(!$event){
            return new JsonResponse(['response' => 'Erreur lors de la recuperation de l\'évènemet'], 404);
        }
        return new JsonResponse([
            'response' => 'Donnee recuperer avec successxx',
            'data' => $event
        ]);
    }

    //Fonction de creation d'un évènement
    public function create(CreateEventRequest $request){
        $data = $request->validated();
        $url_image = null;

            //  Formater les dates pour MySQL (Y-m-d)
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
            $data['user_id'] = Auth::id();
            //Enregistrement du chemain de l'image dans la base de donnée
                $event = Event::create($data);

                if ($event) {
                    return response()->json([
                        'response' => 'Événement créé avec succès',
                        'data' => $event,
                        'image_url' => asset('storage/' . $event->url_image)
                    ], 201);
                }else{
                    return new JsonResponse([
                        'response' => 'Erreur lors de la creation de l\'evenement',                        
                    ], 500);
                }
    }   

    //Fonction pour mettre a jour un evenement
    public function updateEvent($id, CreateEventRequest $request){
        $event = Event::find($id);
        if(!$event){
            return new JsonResponse(['response' => 'Erreur lors de la recuperation de la donnée', 404]);
        }
            $data = $request->validated();
            
            //Mis a jour de l'image
                if($request->hasFile('image')){
                    $image = $request->file('image');
                    
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('events', $filename, 'public');

                    $data['url_image'] = $path;
                }
                $data['user_id'] = 1;
            
            //  Formater les dates pour MySQL (Y-m-d)
                if (isset($data['start'])) {
                    $data['start'] = Carbon::parse($data['start'])->format('Y-m-d');
                }
                if (isset($data['end'])) {
                    $data['end'] = Carbon::parse($data['end'])->format('Y-m-d');
                }

            //Proceder a la mise a jour
                $dataUpdate = $event->update($data);

            if(!$dataUpdate){
                return new JsonResponse(['response' => 'Erreur lors de la mis a jour de la donnée', 404]);
            }
            return new JsonResponse([
                'response' => 'Donnée mis a jour avec success',
                'data' => $dataUpdate
            ]);
    }

    //Fonction de suppression d'un évènement
    public function deleteEvent($id){
        $event = Event::find($id);

        if(!$event){
            return new JsonResponse([
                'response' => 'Donnée innexistant',
            ]);
        }

        $dataDelete = $event->delete();

        if(!$dataDelete){
            return new JsonResponse([
                'response' => 'Erreur lors de la suppression de la donnée'
            ]);
        }

        return new JsonResponse([
            'response' => 'Donnée supprimé avec success'
        ]);
    }

}
