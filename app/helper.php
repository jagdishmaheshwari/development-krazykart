<?php
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ItemImage;
use App\Http\Controllers\Admin\ItemsController;

if (!function_exists('prd')) {
    function prd($a, $die = null)
    {
        echo "<pre>";
        if (is_null($a)) {
            echo "NULL";
        } elseif (is_array($a)) {
            print_r($a);
        } elseif (is_object($a)) {
            print_r($a); // You can also use var_dump($a) for more detailed information
        } else {
            echo $a;
        }
        echo "</pre>";
        if (!$die) {
            die();
        }
    }
}
if (!function_exists('pr')) {
    function pr($a)
    {
        echo "<pre>";
        if (is_null($a)) {
            echo "NULL";
        } elseif (is_array($a)) {
            print_r($a);
        } elseif (is_object($a)) {
            print_r($a); // You can also use var_dump($a) for more detailed information
        } else {
            echo $a;
        }
        echo "</pre>";
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
if (!function_exists('getItemImages')) {
    function getItemImages($itemId){
        $ItemImage = new ItemImage();
        return $ItemImage->where('fk_item_id', $itemId)->orderBy('priority')->pluck('url', 'image_id')->map(function ($filename) {
            return asset('storage') . '/' . $filename;
        })->toArray();
    }
}
if (!function_exists('getItem')) {
    function getItem($itemId=[], $admin = false)
    {
        $Detail = ItemsController::getItems(["items.item_id" => $itemId], [], $admin);
        return reset($Detail);
    }
}
if (!function_exists('getItems')) {
    function getItems($condition = [], $orderBy = [], $admin = false)
    {
        return ItemsController::getItems($condition, $orderBy, $admin);
    }
}
if (!function_exists('getColumnValueByPrimaryKey')) {
    function getColumnValueByPrimaryKey($table, $column, $primary)
    {
        [$key, $value] = $primary;
        $Response = DB::table($table)->where($key, $value)->value($column);
        return $Response;
    }
}