<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaController extends Controller
{
    //
    public function mostrarTareas(){
        $tareas = Tarea::all();
        return response()->json(['tareas' => $tareas], 200);
    }

    public function buscarTarea(Request $request){
        $id = Tarea::find($request->id);
        return response()->json(['tareas' => $id], 200);

        $titulo = Tarea::where('titulo', $request->titulo);
        return response()->json(['tareas' => $titulo], 200);
        
        $contenido = Tarea::where('contenido', $request->contenido);
        return response()->json(['tareas' => $contenido], 200);

        $estado = Tarea::where('estado', $request->estado);
        return response()->json(['tareas' => $estado], 200);
    }

    public function crearTarea(Request $request){
        $validator = Validator::make($request ->all(), [
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'estado' => 'required|string',
            'autor' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tarea = Tarea::create($request->all());
        return response()->json(['tarea' => $tarea], 201);
    }


    public function modificarTarea(Request $request){
        $validator = Validator::make($request->all(), [
            'titulo' => 'string',
            'contenido' => 'string',
            'estado' => 'string',
            'autor' => 'string',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }
        $tarea = Tarea::find($request->id);
        if(!$tarea){
            return response()->json(['error' => 'No existe la tarea'], 404);
        }

        $tarea->update($request->all());
        return response()->json(['tarea' => $tarea], 200);
    }

    public function eliminarTarea($id){
        $tarea = Tarea::find($id);
        $tarea->delete_at = now();
        return response()->json(['tarea' => $tarea], 200);
    }
}
