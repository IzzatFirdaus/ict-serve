<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service for interacting with the Memory MCP server (knowledge graph).
 * Handles create_entities, add_observations, create_relations, delete_*, search, etc.
 */
class MemoryMcpService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.memory_mcp.base_url', 'http://localhost:8080');
    }

    /**
     * Create entities in the memory graph.
     */
    public function createEntities(array $entities): ?array
    {
        return $this->post('/create_entities', ['entities' => $entities]);
    }

    /**
     * Add observations to existing entities.
     */
    public function addObservations(array $observations): ?array
    {
        return $this->post('/add_observations', ['observations' => $observations]);
    }

    /**
     * Create relations between entities.
     */
    public function createRelations(array $relations): ?array
    {
        return $this->post('/create_relations', ['relations' => $relations]);
    }

    /**
     * Delete entities from the memory graph.
     */
    public function deleteEntities(array $entityNames): ?array
    {
        return $this->post('/delete_entities', ['entityNames' => $entityNames]);
    }

    /**
     * Delete observations from entities.
     */
    public function deleteObservations(array $deletions): ?array
    {
        return $this->post('/delete_observations', ['deletions' => $deletions]);
    }

    /**
     * Delete relations from the graph.
     */
    public function deleteRelations(array $relations): ?array
    {
        return $this->post('/delete_relations', ['relations' => $relations]);
    }

    /**
     * Read the entire knowledge graph.
     */
    public function readGraph(): ?array
    {
        return $this->post('/read_graph', []);
    }

    /**
     * Search for nodes in the graph.
     */
    public function searchNodes(string $query): ?array
    {
        return $this->post('/search_nodes', ['query' => $query]);
    }

    /**
     * Open specific nodes by name.
     */
    public function openNodes(array $names): ?array
    {
        return $this->post('/open_nodes', ['names' => $names]);
    }

    /**
     * Internal POST helper with error handling.
     */
    protected function post(string $endpoint, array $payload): ?array
    {
        try {
            $response = Http::timeout(5)->post($this->baseUrl.$endpoint, $payload);
            if ($response->successful()) {
                return $response->json();
            }
            Log::error('Memory MCP error', ['endpoint' => $endpoint, 'payload' => $payload, 'response' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Memory MCP exception', ['endpoint' => $endpoint, 'payload' => $payload, 'exception' => $e->getMessage()]);
        }

        return null;
    }
}
