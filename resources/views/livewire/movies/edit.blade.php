<div class="container" style="padding: 90px 15px;">

    <div class="row mb-5">
        <div class="col d-flex justify-content-between align-items-center">
            <span class="fs-4">Edit Movie</span>
            <a class="btn btn-primary" href="{{ route('movies') }}">Home</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <label class="form-label">Movie Name</label>
            <input type="text" class="form-control @error('movie_name') is-invalid @enderror" wire:model="movie_name" placeholder="Enter movie name">
            @error('movie_name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>    
        <div class="col-xs-12 col-sm-12 col-md-6">
            <label class="form-label">Movie Duration (in Mins)</label>
            <input type="number" class="form-control @error('movie_duration') is-invalid @enderror" wire:model="movie_duration" placeholder="Enter movie duration (in minutes).">
            @error('movie_duration')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <hr style="height: 2px;">

    @foreach($casts as $key => $value)
        <div class="row g-2 mb-4">
            <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                <span class="badge bg-dark fs-6 px-5">{{ $key + 1 }}. Casts Details</span>
                <button class="btn btn-danger" title="Remove" wire:click.prevent="removeCastFields({{ $key }})">Remove Cast {{ $key + 1 }}</button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="form-label">Cast Name</label>
                    <input type="text" class="form-control @error('casts.'.$key.'.name') is-invalid @enderror" placeholder="Enter cast name" 
                    wire:model="casts.{{ $key }}.name" wire:change.prevent="updateCast({{ $key }})">                
                    @error('casts.'.$key.'.name') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror                
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="form-label">Cast Gender</label>
                    <select class="form-select @error('casts.'.$key.'.gender') is-invalid @enderror" wire:model="casts.{{ $key }}.gender" wire:change.prevent="updateCast({{ $key }})">
                        <option>-- Select Gender --</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="O">Others</option>
                    </select>
                    @error('casts.'.$key.'.gender') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror                
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="form-label">Cast Character</label>
                    <input type="text" class="form-control @error('casts.'.$key.'.character') is-invalid @enderror"  placeholder="Enter character name" 
                    wire:model="casts.{{ $key }}.character" wire:change.prevent="updateCast({{ $key }})">                
                    @error('casts.'.$key.'.character') <div class="d-block invalid-feedback"> {{ $message }} </div> @enderror                
                </div>
            </div>
        </div>
        <div class="row g-2 ms-5">
            <div class="col-12 mb-3">
                <span class="badge bg-info fs-6 px-5">Dialouge List</span>
            </div>
        </div>

        @foreach ($casts[$key]['dialougeList'] as $d_key => $d_value)
            <div class="row ms-5 g-2 mb-4">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Dialouge</label>
                        <textarea rows="3" class="form-control @error('casts.'.$key.'.dialougeList.'.$d_key.'.dialouge') is-invalid @enderror" placeholder="Enter dialouge" 
                        wire:model="casts.{{ $key }}.dialougeList.{{ $d_key }}.dialouge" wire:change.prevent="updateDialouge({{ $key }}, {{ $d_key }})"></textarea>
                        @error('casts.'.$key.'.dialougeList.'.$d_key.'.dialouge') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror                
                    </div>
                </div>
                <div class="col-6 d-flex flex-column gap-3 justify-content-center align-items-center">
                    <div class="form-group w-100">
                        <label class="form-label">Start & End Time</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('casts.'.$key.'.dialougeList.'.$d_key.'.start') is-invalid @enderror time-picker"
                            wire:model="casts.{{ $key }}.dialougeList.{{ $d_key }}.start" wire:change.prevent="formatStartTime({{ $key }}, {{ $d_key }})">
                            <input type="text" class="form-control @error('casts.'.$key.'.dialougeList.'.$d_key.'.end') is-invalid @enderror time-picker"
                            wire:model="casts.{{ $key }}.dialougeList.{{ $d_key }}.end" wire:change.prevent="formatEndTime({{ $key }}, {{ $d_key }})">
                        </div>
                        @error('casts.'.$key.'.dialougeList.'.$d_key.'.start') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror
                        @error('casts.'.$key.'.dialougeList.'.$d_key.'.end') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror
                    </div>
                    <button class="btn btn-warning" title="Remove" wire:click.prevent="removeDialougeFields({{ $key }}, {{ $d_key }})">Remove Dialouge</button>
                </div>
            </div>
        @endforeach

        <div class="row g-2 ms-5">
            <div class="col-12 mb-3">
                <button wire:click="addDialougeFields({{ $key }})" class="btn btn-info">Add New Dialouge for Cast {{ $key + 1 }}</button>
            </div>
        </div>

        <hr style="height: 2px;">

    @endforeach

    @if($errors->any())
        <div class="row my-5">
            <div class="col-xs-12 d-flex gap-3 justify-content-center">
                <div class="w-100 text-center d-block invalid-feedback py-1" style="font-size: 1rem; background-color: #ff00001f;">Error occured in input fields.</div>
            </div>
        </div>
    @endif
    
    <div class="row my-5">
        <div class="col-xs-12 d-flex gap-3 justify-content-center">
            <button wire:click.prevent="addCastFields" class="btn btn-success ms-2">Add New Cast</button>
            <button wire:click.prevent="updateMovie" class="btn btn-warning btn-lg px-4">Update Movie</button>
            <button wire:click.prevent="resetForm" class="btn btn-danger btn-lg px-4">Reset</button>
        </div>
    </div>    

</div>