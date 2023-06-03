<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $parts = Part::with('car')->get();

        if ($request->wantsJson()) {
            return response()->json($parts);
        } else {
            return view('parts.index', compact('parts'));
        }
    }

    public function store(Request $request)
    {
        if(!$request->validate(Part::rules())) {
            return response()->json(['message' => 'Validation not successful']);
        }
        $part = Part::create($request->all());
        return response()->json($part, 201);
    }

    public function show($id)
    {
        $part = Part::findOrFail($id);

        return response()->json($part);
    }

    public function destroy($id)
    {
        $part = Part::find($id);
        if (!$part) {
            return response()->json(['message' => 'Part not found'], 404);
        }
        $part->delete();
        return response()->json(null, 204);
    }

    public function update(Request $request, $id)
    {
        if(!$request->validate(Part::rules())) {
            return response()->json(['message' => 'Validation not successful']);
        }
        $part = Part::findOrFail($id);
        $part->update($request->all());
        return response()->json(['message' => 'Car updated successfully']);
    }
}
