<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\OrdenDetalle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrdenController extends Controller
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
        
        $ordenes = Orden::with(['cliente', 'detalles'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('cliente', function ($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellido', 'LIKE', "%{$search}%");
                })->orWhere('estado', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($ordenes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,procesando,completado,cancelado',
            'observaciones' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto' => 'required|string|max:200',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Crear la orden maestro
            $orden = Orden::create([
                'cliente_id' => $validatedData['cliente_id'],
                'fecha' => $validatedData['fecha'],
                'estado' => $validatedData['estado'],
                'observaciones' => $validatedData['observaciones'] ?? null,
                'total' => 0
            ]);

            // Crear los detalles
            foreach ($validatedData['detalles'] as $detalleData) {
                OrdenDetalle::create([
                    'orden_id' => $orden->id,
                    'producto' => $detalleData['producto'],
                    'cantidad' => $detalleData['cantidad'],
                    'precio_unitario' => $detalleData['precio_unitario'],
                ]);
            }

            // Calcular el total después de crear todos los detalles
            $orden->calcularTotal();
            $orden->load(['cliente', 'detalles']);
            
            DB::commit();

            return response()->json([
                'message' => 'Orden creada exitosamente',
                'data' => $orden
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la orden',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Orden $orden
     * @return JsonResponse
     */
    public function show(Orden $orden): JsonResponse
    {
        $orden->load(['cliente', 'detalles']);
        
        return response()->json([
            'data' => $orden
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Orden $orden
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Log para debugging
            \Log::info('Iniciando actualización de orden', [
                'id' => $id,
                'data' => $request->all()
            ]);
            
            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'cliente_id' => 'required|integer|exists:clientes,id',
                'fecha' => 'required|date',
                'estado' => 'required|string|in:pendiente,completado,cancelado',
                'observaciones' => 'nullable|string',
                'detalles' => 'required|array|min:1',
                'detalles.*.producto' => 'required|string|max:100',
                'detalles.*.cantidad' => 'required|integer|min:1',
                'detalles.*.precio_unitario' => 'required|numeric|min:0',
            ]);
            
            if ($validator->fails()) {
                \Log::error('Error de validación en actualización de orden', [
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            DB::beginTransaction();
            
            // Encontrar la orden
            $orden = Orden::findOrFail($id);
            
            // Calcular el total
            $total = 0;
            foreach ($request->detalles as $detalle) {
                $total += $detalle['cantidad'] * $detalle['precio_unitario'];
            }
            
            // Actualizar la orden
            $orden->update([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'total' => $total,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);
            
            // Eliminar detalles existentes
            $orden->detalles()->delete();
            
            // Crear nuevos detalles
            foreach ($request->detalles as $detalle) {
                $orden->detalles()->create([
                    'producto' => $detalle['producto'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'subtotal' => $detalle['cantidad'] * $detalle['precio_unitario'],
                ]);
            }
            
            DB::commit();
            
            \Log::info('Orden actualizada exitosamente', ['id' => $id]);
            
            return response()->json([
                'success' => true,
                'message' => 'Orden actualizada exitosamente',
                'data' => $orden->load(['cliente', 'detalles'])
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error al actualizar orden', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la orden',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        Log::info('Iniciando eliminación de orden', ['orden_id' => $id]);
        
        DB::beginTransaction();
        
        try {
            $orden = Orden::findOrFail($id);
            
            // Los detalles se eliminan automáticamente por CASCADE
            $orden->delete();
            
            DB::commit();

            Log::info('Orden eliminada exitosamente', ['orden_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Orden eliminada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Error al eliminar orden', [
                'orden_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la orden',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
