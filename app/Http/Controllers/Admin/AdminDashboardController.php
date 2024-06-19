<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        // $method = $request->method();

        // Session data
        $sessionData = session()->all();

        // Input data (GET, POST, and files)
        $inputData = request()->all();
        // dd([
        //     // 'Requested Method' => $method,
        //     'Session Data' => $sessionData,
        //     'Input Data' => $inputData,
        // ]);
        return view('admin.dashboard');
    }
}
