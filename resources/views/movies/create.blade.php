@extends('layouts.app')

@section('content')

    <div class="row mb-5">
        <div class="col d-flex justify-content-between align-items-center">
            <span class="fs-4">Create Movie</span>
            <a class="btn btn-primary" href="{{ route('movies') }}">Home</a>
        </div>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('movie.store') }}" method="POST">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <label for="movieName" class="form-label">Movie Name</label>
                <input type="text" class="form-control @error('movieName') is-invalid @enderror" name="movieName" id="movieName" placeholder="Enter movie name" value="{{ old('movieName') }}">
                @error('movieName')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>    
            <div class="col-xs-12 col-sm-12 col-md-6">
                <label for="movieDuration" class="form-label">Movie Duration (in Mins)</label>
                <input type="number" class="form-control @error('movieDuration') is-invalid @enderror" name="movieDuration" id="movieDuration" placeholder="Enter movie duration (in minutes)." value="{{ old('movieDuration') }}">
                @error('movieDuration')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row g-0 mb-4">
            <div class="col-12" id="castAddRemove">
                <div class="row g-3 mb-3">
                    <div class="col-xs-12">
                        <span class="badge bg-success fs-6 px-5">Casts Details</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="castName" class="form-label">Cast Name</label>
                        <input type="text" class="form-control" name="cast[0][name]" id="castName" placeholder="Enter cast name" required>    
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="castGender" class="form-label">Cast Gender</label>
                        <select class="form-select" name="cast[0][gender]" id="castGender" required>
                            <option value="">Select</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Others</option>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <label for="castCharacter" class="form-label">Cast Character</label>
                        <input type="text" class="form-control" name="cast[0][character]" id="castCharacter" placeholder="Enter cast character" required>    
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 d-flex justify-content-center align-items-end">
                        {{-- <button type="button" class="btn btn-danger castRemoveBtn">Remove Cast</button> --}}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                    
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
            
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
            
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 d-flex justify-content-center align-items-end">
                <button type="button" class="btn btn-success ms-2" id="addCastBtn">Add New Cast</button>
            </div>
        </div>
        
        <div class="row g-3 mb-4">
            <div class="col-xs-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg px-4">Save</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col">
            <form method="POST" action="">
                @csrf
            </form>
        </div>
    </div>

@endsection

@push('footerScripts')
<script>
    var i = 0;
    $("#addCastBtn").click(function(){
        ++i;
        $("#castAddRemove").append('<div class="row removable g-3 mb-3"><div class="col-xs-12 col-sm-12 col-md-3"><label for="castName" class="form-label">Cast Name</label><input type="text" class="form-control" name="cast['+i+'][name]" id="castName" placeholder="Enter cast name"></div><div class="col-xs-12 col-sm-12 col-md-3"><label for="castGender" class="form-label">Cast Gender</label><select class="form-select" name="cast['+i+'][gender]" id="castGender"><option value="">Select</option><option value="M">Male</option><option value="F">Female</option><option value="O">Others</option></select></div><div class="col-xs-12 col-sm-12 col-md-3"><label for="castCharacter" class="form-label">Cast Character</label><input type="text" class="form-control" name="cast['+i+'][character]" id="castCharacter" placeholder="Enter cast character"></div><div class="col-xs-12 col-sm-12 col-md-3 d-flex justify-content-center align-items-end"><button type="button" class="btn btn-danger castRemoveBtn">Remove Cast</button></div></div>');
    });
    $(document).on('click', '.castRemoveBtn', function(){  
        $(this).parents('.removable').remove();
    });
</script>
@endpush