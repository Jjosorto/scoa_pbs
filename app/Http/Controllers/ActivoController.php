<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    public function index(){
        try{
        $activos = Activo::with("producto.modelos.marca", "producto.modelos.categoria", "cliente", "departamento")->get();
        return view("activos.index",compact("activos"));
        // return response()->json(["error"=> $activos],200); 
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }


    

    public function create(){
        try{
            $clientes = Cliente::where("estado",1)->get();
            $departamentos = Departamento::where("estado",1)->get();
            $productos = Producto::where("estadoProductos",1)->get();
            return view("activos.create", compact("clientes","departamentos","productos"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'fechaCompra'=> 'required',
                'idContabilidad'=> 'required',
                'estadoActivo'=> 'required',
                'ciudad'=> 'required',
                'cliente_id'=> 'required',
                'departamento_id'=> 'required',
                'producto_id'=> 'required',
            ]);
            $activo = new Activo();
            $activo -> fechaDeCompra = $request-> fechaCompra;
            $activo-> idContabilidad = $request-> idContabilidad;
            $activo-> estadoActivo = $request->estadoActivo;
            $activo-> estado = 1;
            $activo-> cliente_id = $request -> cliente_id;
            $activo-> departamento_id = $request -> departamento_id;
            $activo-> producto_id = $request -> producto_id;
            $activo-> ciudad = $request -> ciudad;
            $activo-> save();
            // return response()->json(['message'=> 'creado correctamente'], 200);
        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $clientes = Cliente::where("estado",1)->get();
            $departamentos = Departamento::where("estado",1)->get();
            $productos = Producto::where("estadoProductos",1)->get();
            $activo = Activo::find($id);
            return view("activos.edit",compact("clientes","departamentos","productos","activo"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'fechaCompra'=> 'required',
                'idContabilidad'=> 'required',
                'estadoActivo'=> 'required',
                'ciudad'=> 'required',
                'cliente_id'=> 'required',
                'departamento_id'=> 'required',
                'producto_id'=> 'required',
                'estado'=> 'required',
            ]);
            $activo = Activo::find($id);
            $activo -> fechaDeCompra = $request->fechaCompra;
            $activo -> idContabilidad = $request-> idContabilidad;
            $activo-> estadoActivo = $request->estadoActivo;
            $activo-> cliente_id = $request -> cliente_id;
            $activo-> estado = $request -> estado;
            $activo-> departamento_id = $request -> departamento_id;
            $activo-> producto_id = $request -> producto_id;
            $activo -> save();
            return response()->json(['message'=> 'Actualizado correctamente'], 200);

        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
    public function desactive($id){
        try{
            $modelo = Modelo ::find($id);
            $modelo -> estadoModelo = 0;
            $modelo -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
}
