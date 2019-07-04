@extends('layouts.base')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/events"><i class="fas fa-book"></i></a></li>
    <li class="breadcrumb-item"><a href="/events/create">Events</a></li>
    <li class="breadcrumb-item active" aria-current="page">End Event</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">End Event</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="/events/end/{{ $event->id }}">
                        @csrf

                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="institute_funding" placeholder="Institute Funding" class="form-control @error('institute_funding') is-invalid @enderror">{{ $event->institute_funding }}</textarea>
                            </div>
                            @error('institute_funding')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="sponsor_funding" placeholder="Sponsor Funding" class="form-control @error('sponsor_funding') is-invalid @enderror">{{ $event->sponsor_funding }}</textarea>
                            </div>
                            @error('sponsor_funding')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="expenditure" placeholder="Expenditure" class="form-control @error('expenditure') is-invalid @enderror">{{ $event->expenditure }}</textarea>
                            </div>
                            @error('expenditure')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="internal_participants_count"  placeholder="Internal Participants Count" class="form-control @error('internal_participants_count') is-invalid @enderror">{{ $event->internal_participants_count }}</textarea>
                            </div>
                            @error('internal_participants_count')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="external_participants_count"  placeholder="External Participants Count" class="form-control @error('external_participants_count') is-invalid @enderror">{{ $event->external_participants_count }}</textarea>
                            </div>
                            @error('external_participants_count')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">End Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section ('custom-script')
    <script src="{{ asset("/js/shape/add-shape.js") }}"></script>

    @if(session()->has('type'))
        <script>
            $.notify({
                // options
                title: '<h4 style="color:white">{{ session('title') }}</h4>',
                message: '{{ session('message') }}',
            },{
                // settings
                type: '{{ session('type') }}',
                allow_dismiss: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
        </script>
    @endif
@endsection