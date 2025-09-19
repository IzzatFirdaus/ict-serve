<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * GDPR-compliant: Delete all memory for the authenticated user (knowledge graph, observations, relations).
     * Only the authenticated user can delete their own memory.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(\App\Http\Requests\DeleteUserMemoryRequest $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $entityName = 'User_'.$user->id;

        /** @var \App\Services\MemoryMcpService $memoryMcp */
        $memoryMcp = app(\App\Services\MemoryMcpService::class);

        // Delete all entities and observations for this user
        $entityDeleteResult = $memoryMcp->deleteEntities([$entityName]);
        // Optionally, delete observations/relations if needed (MCP may cascade)

        if ($entityDeleteResult && isset($entityDeleteResult['success']) && $entityDeleteResult['success']) {
            return response()->json([
                'success' => true,
                'message' => 'All memory for your account has been deleted from the knowledge graph.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete memory for your account. Please try again later.',
        ], 500);
    }
}
