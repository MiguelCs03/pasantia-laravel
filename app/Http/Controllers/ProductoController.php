<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $query = Producto::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('categoria', 'like', "%{$search}%");
            });
        }
        
        $productos = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'required|string|max:50|unique:productos,codigo',
            'categoria' => 'required|string|max:100',
            'estado' => 'required|in:activo,inactivo'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $producto = Producto::create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente',
            'data' => $producto
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Producto $producto
     * @return JsonResponse
     */
    public function show(Producto $producto): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Producto $producto
     * @return JsonResponse
     */
    public function update(Request $request, Producto $producto): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
            'categoria' => 'required|string|max:100',
            'estado' => 'required|in:activo,inactivo'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $producto->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => $producto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Producto $producto
     * @return JsonResponse
     */
    public function destroy(Producto $producto): JsonResponse
    {
        try {
            $producto->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active products for forms
     *
     * @return JsonResponse
     */
    public function productosActivos(): JsonResponse
    {
        try {
            $productos = Producto::where('estado', 'activo')
                ->where('stock', '>', 0)
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'codigo', 'precio', 'stock']);
                
            return response()->json([
                'success' => true,
                'data' => $productos,
                'count' => $productos->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
