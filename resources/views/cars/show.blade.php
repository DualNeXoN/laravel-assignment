@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/car/show.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="text-center">

        <div class="row mt-5 justify-content-center">
            <div class="col-6">
                <h5>Car</h5>
                <table class="table table-bordered bg-light">
                    <tbody>
                        <tr>
                            <th scope="row">ID</th>
                            <td>{{ $car->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Name</th>
                            <td> {{ $car->name }} </td>
                        </tr>
                        <tr>
                            <th scope="row">Registration Number</th>
                            <td> {{ $car->registration_number !== null ? $car->registration_number : '-' }} </td>
                        </tr>
                        <tr>
                            <th scope="row">Registered</th>
                            <td> {{ $car->is_registered ? 'Yes' : 'No' }} </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="" class="btn btn-info">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
