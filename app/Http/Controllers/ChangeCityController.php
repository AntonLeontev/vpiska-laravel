<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeCityRequest;
use Illuminate\Support\Facades\Response;

class ChangeCityController extends Controller
{
    public function __invoke(ChangeCityRequest $request)
    {
        if ($request->input('make_default') === 'on') {
            auth()->user()->updateOrFail($request->only(['city_name', 'city_fias_id']));
        }
        $request->session()->put('city_fias_id', $request->input('city_fias_id'));
        $request->session()->put('city_name', $request->input('city_name'));

        return Response::json(['status' => 'ok', 'redirect' => url()->previous()]);
    }
}
