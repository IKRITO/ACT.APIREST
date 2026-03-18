<?php
use Illuminate\Support\Facades\Validator;

 public function store(Request $request){
        $validator =Validator::make($request->all(),[
            'nombre'=>'required',
            'biografia'=>'nullable',
            'especialidad'=>'nullable',
        ]);

        if($validator->fails()){
            return redirect()->route('ponentes.vista')->with('error','Faltan datos obligatorios');
        }

        Ponente::create($request->all());

        return redirect()->route('ponentes.vista')->with('success','Ponente agregado correctamente');
    }