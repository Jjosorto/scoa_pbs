<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    public function index(){
        try{
           $departamentos = Departamento::all();
        return view("departamentos.index",compact("departamentos"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }
    public function create(){
        try{
            return view("departamentos.create");
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'nombreDepartamento'=> 'required',
            ]);
            $departamento = new Departamento();
            $departamento -> nombreDepartamento = $request-> nombreDepartamento;
            $departamento-> estado = 1;
            $departamento-> save();

        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $departamento = Departamento::find($id);
            return view("departamentos.edit",compact("departamento"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'nombreDepartamento'=> 'required',
            ]);
            $departamento = Departamento::find($id);
            $departamento -> nombreDepartamento = $request->nombreDepartamento;
            $departamento -> estado = $request-> estado;
            $departamento -> save();
            return response()->json(['message'=> 'Actualizado correctamente'], 200);

        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
    public function desactive($id){
        try{
            $departamento = Departamento::find($id);
            $departamento -> estado = 0;
            $departamento -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }

}
