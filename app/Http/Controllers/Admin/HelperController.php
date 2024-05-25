<?php
// app/Http/Controllers/StatusController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelperController extends Controller
{
    public function updateStatus(Request $request)
    {
        $tableName = $request->input('tableName');
        $primaryKey = $request->input('primaryKey');
        $id = $request->input('id');

        $success = updateStatus($tableName, $primaryKey, $id);

        return response()->json(['success' => $success]);
    }

    public static function editPriority(Request $request)
    {
        // Get data from request payload
        $tableName = $request->input('tableName');
        $primary = $request->input('primary');
        $id = $request->input('id');
        $action = $request->input('action');
        
        // Validate action parameter
        if ($action !== 'plus' && $action !== 'minus') {
            return response()->json(['error' => 'Invalid action parameter. Use "plus" or "minus".'], 400);
        }
        
        // Update priority based on the action
        try {
            // Check if the action is 'minus' and current priority is already 0
            if ($action === 'minus') {
                $currentPriority = DB::table($tableName)
                                    ->where($primary, $id)
                                    ->value('priority');
                if ($currentPriority === 0) {
                    return response()->json(['error' => 'Priority is already at its minimum value'], 200);
                }
            }

            // Update the priority
            DB::table($tableName)
                ->where($primary, $id)
                ->increment('priority', $action === 'plus' ? 1 : -1);

            return response()->json(['success' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating priority'], 500);
        }
    }
}
