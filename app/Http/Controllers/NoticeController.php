<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getAll(Request $request)
    {
        return ['success' => true, 'notice'=>Notice::all()];
    }

    public function get(Request $request)
    {
        try {
            return ['success' => true, 'notice'=>Notice::findOrFail($request->id)];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success'=>false,'message' => 'Invalid ID'], 404);
            }
        }
    }

    public function create(Request $request)
    {
        $notice = new Notice;
        $notice->fill($request->all());
        $notice->save();

        return ['success' => true, 'notice'=>$notice->toArray()];
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
                return response(['success'=>false,'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, 'notice'=> $notice,'message' => 'Notice updated successfully'];
    }

    public function delete(Request $request)
    {
        try {
            Notice::findOrFail($request->id)->delete();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success'=>false,'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, "message" => "Deleted notice #{$request->id}",
    }
}
