<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index() {
        $areas = Area::all();

        if($areas->isEmpty()) {
            $data = [
                'message' => 'No hay areas registradas',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'areas' => $areas,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre_area' => 'required|max:100',
            'descripcion' => 'nullable'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $area = Area::create([
            'nombre_area' => $request->nombre_area,
            'descripcion' => $request->descripcion
        ]);

        if(!$area) {
            $data = [
                'message' => 'Error al crear el area',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Area creada',
            'area' => $area,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function show($id) {
        $area = Area::find($id);

        if(!$area) {
            $data = [
                'message' => 'Area no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $area,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id) {
        $area = Area::find($id);

        if(!$area) {
            $data = [
                'message' => 'Area no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $area->delete();

        $data = [
            'message' => 'Area eliminada',
            'statis' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $area = Area::find($id);

        if(!$area) {
            $data = [
                'message' => 'Area no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre_area' => 'required|max:100',
            'descripcion' => 'nullable',
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $area->nombre_area = $request->nombre_area;
        $area->descripcion = $request->descripcion;

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $area,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
