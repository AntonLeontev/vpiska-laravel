<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(FeedbackRequest $request, Feedback $feedback)
    {
        $feedback->create($request->validated());

        return response()->json(['status' => 'ok', 'redirect' => 'reload']);
    }
}
