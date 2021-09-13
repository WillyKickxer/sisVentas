<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class PersonaFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * Determine si el usuario está autorizado para realizar esta solicitud.
     * @return bool
     */
    public function authorize()
    {
        return true; //autoriza al usuario
    }

    /**
     * Get the validation rules that apply to the request.
     * Obtenga las reglas de validación que se aplican a la solicitud.
     * @return array
     */
    public function rules() //valida los objetos del formulario
    {
        return [
        'nombre'=>'required|max:100',
        'tipo_documento'=>'required|max:20',
        'num_documento'=>'required|max:15',
        'direccion'=>'max:70',
        'telefono'=>'max:15',
        'email'=>'max:50'
        ];
    }
}
