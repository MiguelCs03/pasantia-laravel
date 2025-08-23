<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource with pagination.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');
        
        $clientes = Cliente::when($search, function ($query, $search) {
                return $query->where('nombre', 'LIKE', "%{$search}%")
                           ->orWhere('apellido', 'LIKE', "%{$search}%")
                           ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClienteRequest $request
     * @return JsonResponse
     */
    public function store(ClienteRequest $request): JsonResponse
    {
        $cliente = Cliente::create($request->validated());

        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'data' => $cliente
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Cliente $cliente
     * @return JsonResponse
     */
    public function show(Cliente $cliente): JsonResponse
    {
        return response()->json([
            'data' => $cliente
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClienteRequest $request
     * @param Cliente $cliente
     * @return JsonResponse
     */
    public function update(ClienteRequest $request, Cliente $cliente): JsonResponse
    {
        $cliente->update($request->validated());

        return response()->json([
            'message' => 'Cliente actualizado exitosamente',
            'data' => $cliente->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cliente $cliente
     * @return JsonResponse
     */
    public function destroy(Cliente $cliente): JsonResponse
    {
        $cliente->delete();

        return response()->json([
            'message' => 'Cliente eliminado exitosamente'
        ]);
    }
}
