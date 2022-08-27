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
    <div class="row g-0 mb-4">
        <div class="col-12 mb-3">
            <span class="badge bg-dark fs-6 px-5">Casts Details</span>
        </div>
        <div class="col-12">
            @foreach($casts as $key => $value)
                <div class="row g-2 mb-4">
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cast Name</label>
                            <input type="text" class="form-control @error('casts.'.$key.'.name') is-invalid @enderror" placeholder="Enter cast name" 
                            wire:model="casts.{{ $key }}.name">                
                            @error('casts.'.$key.'.name') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror                
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="form-group">
                            <label class="form-label">Cast Gender</label>
                            <select class="form-select @error('casts.'.$key.'.gender') is-invalid @enderror" wire:model="casts.{{ $key }}.gender">
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
                            wire:model="casts.{{ $key }}.character">                
                            @error('casts.'.$key.'.character') <div class="d-block invalid-feedback"> {{ $message }} </div> @enderror                
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 d-flex justify-content-end align-items-center">
                        <button class="btn btn-danger" title="Remove" wire:click.prevent="removeCastField({{$key}})">Remove Cast</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12 d-flex justify-content-end align-items-center">
            <button wire:click="addCastField" class="btn btn-success ms-2">Add New Cast</button>
        </div>
    </div>
    <div class="row g-0 mb-4">
        <div class="col-12 mb-3">
            <span class="badge bg-dark fs-6 px-5">Dialouge List</span>
        </div>
        <div wire:ignore.self class="col-12">
            @foreach($dialougeList as $key => $value)
                <div class="row g-2 mb-4">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-label">Dialouge</label>
                            <textarea rows="5" class="form-control @error('dialougeList.'.$key.'.dialouge') is-invalid @enderror" placeholder="Enter dialouge" 
                            wire:model="dialougeList.{{ $key }}.dialouge"></textarea>
                            @error('dialougeList.'.$key.'.dialouge') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror                
                        </div>
                    </div>
                    <div class="col-5 d-flex flex-column gap-3 justify-content-center align-items-center">
                        <div class="form-group w-100">
                            <label class="form-label">Character</label>
                            <select class="form-select @error('dialougeList.'.$key.'.character') is-invalid @enderror" wire:model="dialougeList.{{ $key }}.character">
                                <option value="" @if($dialougeList[$key]['character'] === '') selected @endif>-- Select Character --</option>
                                @forelse ($casts as $c)
                                    <option value="{{ $c['character'] }}" @if($dialougeList[$key]['character'] === $c['character']) selected @endif>{{ $c['character'] }}</option>
                                @empty
                                    <option>First add cast</option>
                                @endforelse
                            </select>
                            @error('dialougeList.'.$key.'.character') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror                
                        </div>
                        <div class="form-group w-100">
                            <label class="form-label">Start & End Time</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('dialougeList.'.$key.'.start') is-invalid @enderror time-picker"
                                wire:model.debounce.4000ms="dialougeList.{{ $key }}.start">
                                <input type="text" class="form-control @error('dialougeList.'.$key.'.end') is-invalid @enderror time-picker"
                                wire:model.debounce.4000ms="dialougeList.{{ $key }}.end">
                            </div>
                            @error('dialougeList.'.$key.'.start') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror
                            @error('dialougeList.'.$key.'.end') <div class="d-block invalid-feedback"> {{ $message }} </div>@enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 d-flex justify-content-end align-items-center">
                        <button class="btn btn-danger" title="Remove" wire:click.prevent="removeDialougeFields({{$key}})">Remove Dialouge</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12 d-flex justify-content-end align-items-center">
            <button wire:click="addDialougeFields" class="btn btn-success ms-2">Add New Dialouge</button>
        </div>
    </div>
    
    <div class="row g-3 mb-4">
        <div class="col-xs-12 text-center">
            <button wire:click.prevent="updateMovie" class="btn btn-warning btn-lg px-4">Update</button>
        </div>
    </div>

</div>