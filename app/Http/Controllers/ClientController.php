<?php

namespace App\Http\Controllers;

use App\Models\Technology;
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
    //     $clients = User::select('id', 'first_name', 'last_name', 'email', 'location')
    //     ->whereNotNull('location')
    //     ->get();

    // return response()->json($clients);
        $clients = User::query();

        // Filter by Referral Source
        if ($request->has('referral_source')) {
            $clients->where('referral_source', $request->referral_source);
        }

        // Paginated response
        return response()->json($clients->paginate(10));
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
        $report = User::groupBy('created_at', 'referral_source')
        ->select(['created_at', 'referral_source'])
        ->get()
        ->groupBy(fn($user) => $user->created_at->format('Y-m-d'))
        ->map(fn($group) => $group->groupBy('referral_source')->map->count())
        ->map(fn($sources, $date) => $sources->map(fn($count, $source) => [
            'date' => $date,
            'source' => $source,
            'total' => $count,
        ]))
        ->flatten(1)
        ->values();
        return response()->json($report);
    }

    public function technologyReport() {
        $report = Technology::withCount('users')->get(); 

    
    return response()->json($report);
    }
}
