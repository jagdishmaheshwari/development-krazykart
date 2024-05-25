<?php
use Illuminate\Support\Facades\DB;

if (!function_exists('prd')) {
    function prd($a, $die = null)
    {
        echo "<pre>";
        if (is_array($a) && $a === null) {
            echo "NULL ARRAY";
        } else {
            if (is_array($a)) {
                print_r($a);
            } else {
                echo $a;
            }
        }
        echo "</pre>";
        if(!$die){
            die();
        }
    }
}
if (!function_exists('handleDataTablesRequest')) {
    function handleDataTablesRequest(Request $request, $queryBuilder, $columns)
    {
        $requestData = $request->all();

        $query = $queryBuilder(new Builder()); // Invoke the callback to get the query builder

        // Handle search query
        if (!empty($requestData['search']['value'])) {
            $searchValue = $requestData['search']['value'];
            $query->where(function ($query) use ($columns, $searchValue) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%$searchValue%");
                }
            });
        }

        // Handle column sorting
        if (!empty($requestData['order'][0]['column'])) {
            $sortColumnIndex = $requestData['order'][0]['column'];
            $sortDirection = $requestData['order'][0]['dir'];
            $sortColumn = $columns[$sortColumnIndex];
            $query->orderBy($sortColumn, $sortDirection);
        }

        // Perform pagination
        $start = $requestData['start'];
        $length = $requestData['length'];
        $query->offset($start)->limit($length);

        // Get data for DataTables response
        $data = $query->get();

        // Get total count of records (for pagination)
        $totalRecords = $query->count();

        // Prepare response data in DataTables.js format
        $response = [
            'draw' => intval($requestData['draw']),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ];

        return response()->json($response);
    }
}

if (!function_exists('updateStatus')) {
    function updateStatus($tableName, $primaryKey, $id)
    {
        $record = DB::table($tableName)->where($primaryKey, $id)->first();

        if ($record) {
            $newStatus = $record->status == 0 ? 1 : 0;
            DB::table($tableName)->where($primaryKey, $id)->update(['status' => $newStatus]);
            return true;
        }

        return false;
    }
}