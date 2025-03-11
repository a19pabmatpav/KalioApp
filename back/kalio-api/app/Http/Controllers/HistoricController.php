<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoricController extends Controller
{
    public function addConsum(Request $request)
    {
        $request->validate([
            'data' => 'required',
            'data.*.id' => 'required|integer',
            'data.*.consum' => 'required|integer',
        ]);

        $user = $request->user();
        $user->historics()->createMany($request->data);

        return response()->json(['message' => 'Consums registrats correctament']);
    }
}
