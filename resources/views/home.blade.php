@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form action="/process" enctype="multipart/form-data" method="POST">
                        <p>
                            <label for="photo">
                                <input type="file" name="photo" id="photo">
                            </label>
                        </p>
                        <button>Upload</button>
                        {{ csrf_field() }}
                    </form>
                    <img src="/img/d.jpeg" alt="some image">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
