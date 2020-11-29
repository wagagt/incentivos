<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_create');
    }

    public function rules()
    {
        return [
            'name'          => [
                'string',
                'required',
            ],
            'date'          => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'qr_code'       => [
                'string',
                'nullable',
            ],
            'verification'  => [
                'string',
                'nullable',
            ],
            'tracking_code' => [
                'string',
                'required',
                'unique:orders',
            ],
            'customer_id'   => [
                'required',
                'integer',
            ],
        ];
    }
}
