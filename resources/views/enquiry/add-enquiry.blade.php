@extends('layouts.base')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/enquiry"><i class="ni ni-ruler-pencil"></i></a></li>
    <li class="breadcrumb-item"><a href="/enquiry">Enquiry</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Enquiry</li>
@endsection

@section('page-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Add Enquiry</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form method="post" action="/enquiry">
                        @csrf
                        <div class="form-group">
                            <input autocomplete="off" value="{{ old('student_name') }}" required name="student_name" type="text" placeholder="Name" class="form-control @error('student_name') is-invalid @enderror">
                            @error('student_name')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group @error('student_address') has-danger @enderror">
                                <input autocomplete="off" type="text" value="{{ old('student_address') }}" required name="student_address"  placeholder="Address"  class="form-control  @error('student_address') is-invalid @enderror">
                            </div>
                            @error('student_address')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input autocomplete="off" value="{{ old('student_number') }}" required name="student_number" type="number" placeholder="Contact Number"  class="form-control @error('student_number') is-invalid @enderror">
                            @error('student_number')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input autocomplete="off" value="{{ old('student_college') }}" required name="student_college" type="text" placeholder="College" class="form-control @error('student_college') is-invalid @enderror">
                            @error('student_college')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input autocomplete="off" value="{{ old('student_branch') }}" required name="student_branch" type="text" placeholder="Branch" class="form-control @error('student_branch') is-invalid @enderror">
                            @error('student_branch')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group @error('student_year') has-danger @enderror">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input type="text" value="{{ old('student_year') }}" required name="student_year"  placeholder="Year"  class="form-control datepicker @error('student_year') is-invalid @enderror">
                            </div>
                            @error('student_year')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <textarea  required name="comments"  placeholder="Comments" class="form-control @error('comments') is-invalid @enderror">{{ old('comments') }}</textarea>
                            </div>
                            @error('comments')
                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">Add Enquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section ('custom-script')


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
