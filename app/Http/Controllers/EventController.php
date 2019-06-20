<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use JWTAuth;

class EventController extends Controller
{
    public function getAll(Request $request)
    {
        return Event::all();
    }

    public function get(Request $request)
    {
        try {
            return Event::findOrFail($request->id);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Invalid ID'], 404);
            }
        }
    }

    protected function getToken()
    {
        return JWTAuth::decode(JWTAuth::getToken())->toArray();
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = self::getToken()['user']->id;
        $event = new Event;
        $event->fill($input);
        $event->save();

        return response()->json($event->toArray());
    }

    public function update(Request $request)
    {
        $event = null;
        try {
            $event = Event::findOrFail($request->id);
            $event->update($request->all());
            $event->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Invalid ID'], 404);
            }
        }

        return response()->json(['message' => 'Event updated successfully', 'event' => $event->toArray()]);
    }

    public function delete(Request $request)
    {
        try {
            Event::findOrFail($request->id)->delete();
            return [
                "message" => "Deleted event having ID:{$request->id}",
            ];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Invalid ID'], 404);
            }
        }
    }
}
