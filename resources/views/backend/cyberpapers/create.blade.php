@extends('backend.layout.master')
@section('title', 'Create Cyber Paper')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Upload Cyber Document</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('cyberpapers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="file" class="d-block">File Upload</label>
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" >
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Add more fields as needed -->

                <button type="submit" class="btn btn-sm btn-primary">Upload</button>
            </form>



        </div>
    </div>
</div>

@endsection
