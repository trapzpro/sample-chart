@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Medicare Services for Diabetic Foot Ulcer Debridements by State in 2021</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                  <highchart-dynamic  />

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
