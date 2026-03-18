<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventoController extends Controller
{
    /**
     * Mostrar todos los eventos
     */
    public function index()
    {
        $eventos = Evento::with(['ponentes', 'asistentes'])->get();

        return response()->json([
            'eventos' => $eventos,
            'status' => 200
        ]);
    }

    /**
     * Crear un nuevo evento
     */
    public function store(Request $request)
    {
        // Validación
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos faltantes o inválidos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Crear evento
        $evento = Evento::create($request->all());

        return response()->json([
            'evento' => $evento,
            'status' => 201
        ], 201);
    }

    /**
     * Mostrar un evento específico
     */
    public function show($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'evento' => $evento,
            'status' => 200
        ]);
    }

    /**
     * Actualizar un evento
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
                'status' => 404
            ], 404);
        }

        // Validación
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'ubicacion' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        // Actualizar
        $evento->update($request->all());

        return response()->json([
            'evento' => $evento,
            'status' => 200
        ]);
    }

    /**
     * Eliminar un evento
     */
    public function destroy($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json([
                'message' => 'Evento no encontrado',
                'status' => 404
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'message' => 'Evento eliminado correctamente',
            'status' => 200
        ]);
    }
}