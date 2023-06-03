<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::with('parts')->get();

        if ($request->wantsJson()) {
            return response()->json($cars);
        } else {
            return view('cars.index', compact('cars'));
        }
    }

    public function show(Request $request, $id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        if ($request->wantsJson()) {
            return response()->json($car);
        } else {
            return view('cars.show', compact('car'));
        }
    }

    public function store(Request $request)
    {
        if(!$request->validate(Car::rules())) {
            return response()->json(['message' => 'Validation not successful']);
        }
        $car = Car::create($request->all());
        return response()->json($car, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(Car::rules());
        $car = Car::findOrFail($id);
        $car->update($request->all());
        return response()->json(['message' => 'Car updated successfully']);
    }

    public function destroy($id)
    {
        $car = Car::find($id);
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        $car->delete();
        return response()->json(null, 204);
    }

    public function getCarParts(Car $car)
    {
        $carParts = $car->parts;

        return response()->json($carParts);
    }

    public function addPartToCar($carId, $partId)
    {
        $car = Car::find($carId);

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $part = Part::find($partId);

        if (!$part) {
            return response()->json(['error' => 'Part not found'], 404);
        }

        if ($part->car_id !== null) {
            return response()->json(['error' => 'Part is already assigned to a car'], 400);
        }

        $part->car_id = $carId;
        $part->update();

        return response()->json(['message' => 'Part added to car'], 200);
    }


    public function removePartFromCar($carId, $partId)
    {
        $car = Car::find($carId);

        if (!$car) {
            return response()->json(['error' => 'Car not found'], 404);
        }

        $part = $car->parts()->find($partId);

        if (!$part) {
            return response()->json(['error' => 'Part not found'], 404);
        }

        $part->car_id = null;
        $part->save();

        return response()->json(['message' => 'Part removed from car'], 200);
    }
}
