<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use \App\Traits\JWTUtilTrait;

    public function getAll(Request $request)
    {
        return ['success' => true, 'event'=>Event::all()];
    }

    public function get(Request $request)
    {
        try {
            return ['success' => true, 'event'=>Event::findOrFail($request->id)];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success'=>false,'message' => 'Invalid ID'], 404);
            }
        }
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = static::getToken()['user']->id;
        $event = new Event;
        $event->fill($input);
        $event->save();

        return ['success' => true, 'event'=>$event];
    }

    public function update(Request $request)
    {
        $event = null;
        try {
            $event = User::findOrFail(static::getUserId())->events()->findOrFail($request->id);
            $event->update($request->all());
            $event->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success'=>false,'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, 'event'=>$event,'message' => 'Event updated successfully'];
    }

    public function delete(Request $request)
    {
        try {
            User::findOrFail(static::getUserId())->events()->findOrFail($request->id)->delete();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success'=>false,'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, "message" => "Deleted event #{$request->id}"
    }
}
