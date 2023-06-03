@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="text-center">

        <div class="row mt-5 justify-content-center">
            <div class="col-lg-4 mb-3" data-aos="zoom-in">
                <a class="card-link" href="{{ route('cars') }}">
                    <div class="card">
                        <div class="fill">
                            <img class="img-fluid" src="{{ asset('img/home/icon-cars.png') }}" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Cars</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 mb-3" data-aos="zoom-in">
                <a class="card-link" href="{{ route('parts') }}">
                    <div class="card">
                        <div class="fill">
                            <img class="img-fluid" src="{{ asset('img/home/icon-parts.png') }}" />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Parts</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </section>
@endsection
