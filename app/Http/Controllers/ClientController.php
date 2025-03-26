<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $clients = User::select('id', 'first_name', 'last_name', 'email', 'location')
        ->whereNotNull('location')
        ->get();

    return response()->json($clients);
        // $clients = User::query();

        // // Filter by Referral Source
        // if ($request->has('referral_source')) {
        //     $clients->where('referral_source', $request->referral_source);
        // }

        // // Paginated response
        // return response()->json($clients->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $client)
    {
        //
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function registrationReport(Request $request) {
        $type = $request->get('type', 'daily'); // Default: Daily Report
    
        $query = User::selectRaw("
            DATE(created_at) as period, COUNT(*) as total
        ");
    
        if ($type === 'monthly') {
            $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period");
        } elseif ($type === 'yearly') {
            $query->selectRaw("YEAR(created_at) as period");
        }
    
        $report = $query->groupBy('period')->orderBy('period', 'ASC')->get();
    
        return response()->json($report);
    }

    public function technologyReport() {
        $report = DB::table('users')
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(technologies, '$[*]')) as technology")
            ->whereNotNull('technologies')
            ->get()
            ->pluck('technology')
            ->flatMap(fn($tech) => json_decode($tech, true))
            ->countBy()
            ->map(fn($count, $tech) => ['technology' => $tech, 'total' => $count])
            ->values();
    
        return response()->json($report);
    }
}
