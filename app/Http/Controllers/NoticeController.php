<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getAll(Request $request)
    {
        return Notice::all();
    }

    public function get(Request $request)
    {
        try {
            return Notice::findOrFail($request->id);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Invalid ID'], 404);
            }
        }
    }

    public function create(Request $request)
    {
        $notice = new Notice;
        $notice->fill($request->all());
        $notice->save();

        return response()->json($notice->toArray());
    }

    public function update(Request $request)
    {
        $notice = null;
        try {
            $notice = Notice::findOrFail($request->id);
            $notice->update($request->all());
            $notice->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Invalid ID'], 404);
            }
        }

        return response()->json(['message' => 'Notice updated successfully', 'notice' => $notice->toArray()]);
    }

    public function delete(Request $request)
    {
        try {
            Notice::findOrFail($request->id)->delete();
            return [
                "message" => "Deleted notice having ID:{$request->id}",
            ];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Invalid ID'], 404);
            }
        }
    }
}
