<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    public function index() {
        $personal = Personal::all();

        if($personal->isEmpty()) {
            $data = [
                'message' => 'No hay personal registrados',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'personals' => $personal,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'apellido' => 'required|max:100',
            'email' => 'required|email|max:100|unique:personal,email',
            'telefono' => 'nullable|digits:9',
            'fecha_nacimiento' => 'nullable|date|before:fecha_ingreso',
            'fecha_ingreso' => 'required|date',
            'area_id' => 'required|integer|exists:area,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $personal = Personal::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_ingreso' => $request->fecha_ingreso,
            'area_id' => $request->area_id,
            'estado' => $request->estado
        ]);

        if(!$personal) {
            $data = [
                'message' => 'Error al crear el personal',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Personal creado satisfactoriamente',
            'personal' => $personal,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    
    public function show($id) {
        $personal = Personal::find($id);

        if(!$personal) {
            $data = [
                'message' => 'Personal no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $personal,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id) {
        $personal = Personal::find($id);

        if(!$personal) {
            $data = [
                'message' => 'Personal no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $personal->delete();

        $data = [
            'message' => 'Personal eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $personal = Personal::find($id);

        if(!$personal) {
            $data = [
                'message' => 'Personal no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'apellido' => 'required|max:100',
            'email' => 'required|email|max:100|unique:personal,email',
            'telefono' => 'nullable|digits:9',
            'fecha_nacimiento' => 'nullable|date|before:fecha_ingreso',
            'fecha_ingreso' => 'required|date',
            'area_id' => 'required|integer|exists:area,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $personal->nombre = $request->nombre;
        $personal->apellido = $request->apellido;
        $personal->email = $request->email;
        $personal->telefono = $request->telefono;
        $personal->fecha_nacimiento = $request->fecha_nacimiento;
        $personal->fecha_ingreso = $request->fecha_ingreso;
        $personal->area_id = $request->area_id;
        $personal->estado = $request->estado;

        $data = [
            'message' => 'Personal actualizado',
            'student' => $personal,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
