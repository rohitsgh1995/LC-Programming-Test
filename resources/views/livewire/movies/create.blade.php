<div class="container" style="padding: 90px;">

    <div class="row mb-5">
        <div class="col d-flex justify-content-between align-items-center">
            <span class="fs-4">Create Movie</span>
            <a class="btn btn-primary" href="{{ route('movies') }}">Home</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <label for="movie_name" class="form-label">Movie Name</label>
            <input type="text" class="form-control @error('movie_name') is-invalid @enderror" wire:model="movie_name" id="movie_name" placeholder="Enter movie name">
            @error('movie_name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>    
        <div class="col-xs-12 col-sm-12 col-md-6">
            <label for="movie_duration" class="form-label">Movie Duration (in Mins)</label>
            <input type="number" class="form-control @error('movie_duration') is-invalid @enderror" wire:model="movie_duration" id="movie_duration" placeholder="Enter movie duration (in minutes).">
            @error('movie_duration')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row g-0 mb-4">
        <div class="col-12">
            <span class="badge bg-success fs-6 px-5">Casts Details</span>
        </div>
        <div class="col-12">
            @foreach($casts as $key => $value)
                <div class="row g-2 mb-4">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="castName" class="form-label">Cast Name</label>
                            <input type="text" class="form-control @error('casts.'.$key.'.name') is-invalid @enderror" placeholder="name of services" wire:model="casts.{{ $key }}.name">                
                            @error('casts.'.$key.'.name') <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>@enderror                
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="castName" class="form-label">Cast Gender</label>
                            <select class="form-select @error('casts.'.$key.'.gender') is-invalid @enderror" id="castGender" wire:model="casts.{{ $key }}.gender">
                                <option>Select</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                            @error('casts.'.$key.'.gender') <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div>@enderror                
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label for="castName" class="form-label">Cast Character</label>
                            <input type="text" class="form-control @error('casts.'.$key.'.character') is-invalid @enderror serv_character" wire:model="casts.{{ $key }}.character" placeholder="character">                
                            @error('casts.'.$key.'.character') <div class="fv-plugins-message-container invalid-feedback"> {{ $message }} </div> @enderror                
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 d-flex justify-content-center align-items-center">
                        <button class="btn btn-danger" title="Remove" wire:click.prevent="removeCastField({{$key}})">Remove Cast</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
                
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
        
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3">
        
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 d-flex justify-content-center align-items-end">
            <button wire:click="addCastField" class="btn btn-success ms-2" id="addCastBtn">Add New Cast</button>
        </div>
    </div>
    
    <div class="row g-3 mb-4">
        <div class="col-xs-12 text-center">
            <button wire:click.prevent="createMovie" class="btn btn-primary btn-lg px-4">Save</button>
        </div>
    </div>

</div>