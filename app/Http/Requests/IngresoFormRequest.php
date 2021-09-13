<?php

namespace sisVentas\Http\Requests;

use sisVentas\Http\Requests\Request;

class IngresoFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * Determine si el usuario está autorizado para realizar esta solicitud.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Obtenga las reglas de validación que se aplican a la solicitud.
     * @return array
     */
    public function rules() //valida los objetos del formulario
    {
        return [
            //tabla ingreso
            'idproveedor' => 'required',
            'tipo_comprobante' => 'required|max:20',
            'serie_comprobante' => 'max:7',
            'num_comprobante' => 'required|max:10',
            //tabla detalle_ingreso
            'idarticulo' => 'required',
            'cantidad' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required'
        ];
    }
}
