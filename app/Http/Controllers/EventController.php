<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventRegistrant;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    use \App\Traits\JWTUtilTrait;

    public function getAll(Request $request)
    {
        return ['success' => true, 'event' => Event::all()];
    }

    public function get(Request $request)
    {
        try {
            return ['success' => true, 'event' => Event::findOrFail($request->id)];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'end_time' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|numeric|between:1,1000',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        $input = $request->all();
        $input['user_id'] = static::getToken()['user']->id;
        $event = new Event;
        $event->fill($input);
        $event->save();

        return ['success' => true, 'event' => $event];
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'end_time' => 'nullable|date|date_format:Y-m-d',
            'amount' => 'nullable|numeric|between:1,1000',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        $event = null;
        try {
            $event = User::findOrFail(static::getUserId())->events()->findOrFail($request->id);
            $event->update($request->all());
            $event->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, 'event' => $event, 'message' => 'Event updated successfully'];
    }

    public function registerUser(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = static::getUserId();
        $input['event_id'] = $request->id;

        $validator = Validator::make($input, [
            'event_id' => 'required|exists:event,id',
            'no_of_people' => 'required|gte:1',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $registration = new EventRegistrant;
        $registration->fill($input);
        $registration->save();

        return ['success' => true, 'message' => 'Register successfully for the event'];
    }

    public function delete(Request $request)
    {
        try {
            User::findOrFail(static::getUserId())->events()->findOrFail($request->id)->delete();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, "message" => "Deleted event #{$request->id}"];
    }
}
