<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class ArticuloFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * Determine si el usuario está autorizado para realizar esta solicitud.
     * @return bool
     */
    public function authorize()
    {
        return true; //permite la validacion
    }

    /**
     * Get the validation rules that apply to the request.
     * Obtenga las reglas de validación que se aplican a la solicitud.
     * @return array
     */
    public function rules() //valida los objetos del formulario
    {
        return [
            'idcategoria' => 'required',
            'codigo' => 'required|max:50',
            'nombre' => 'required|max:100',
            'stock' => 'required|numeric',
            'descripcion' => 'max:512',
            'imagen' => 'mimes:jpeg,bmp,png'
        ];
    }
}
