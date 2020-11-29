<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrderResource(Order::with(['customer'])->get());
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());

        if ($request->input('result_pdf', false)) {
            $order->addMedia(storage_path('tmp/uploads/' . $request->input('result_pdf')))->toMediaCollection('result_pdf');
        }

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrderResource($order->load(['customer']));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());

        if ($request->input('result_pdf', false)) {
            if (!$order->result_pdf || $request->input('result_pdf') !== $order->result_pdf->file_name) {
                if ($order->result_pdf) {
                    $order->result_pdf->delete();
                }

                $order->addMedia(storage_path('tmp/uploads/' . $request->input('result_pdf')))->toMediaCollection('result_pdf');
            }
        } elseif ($order->result_pdf) {
            $order->result_pdf->delete();
        }

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
