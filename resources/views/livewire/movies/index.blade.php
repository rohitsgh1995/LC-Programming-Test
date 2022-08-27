<div class="container" style="padding: 90px 15px;">

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <p class="m-0 p-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="m-0 p-0">{{ $message }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @forelse ($movies as $m)                    
        <div class="row g-0 mb-5">
            <div class="col">
                <div class="row g-0">
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset('assets/img/movie.jpg') }}" alt="{{ $m->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $m->name }}</h5>
                                <p class="card-text">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $this->setTime($m->duration, '%02dh %02dm') }}</small>
                                    <div class="d-flex gap-3 align-items-center">
                                        <a href="{{ route('movie.edit', ['movie_id' => $m->id]) }}" class="btn btn-outline-warning">Edit</a>
                                        <button wire:click="destroy({{ $m->id }})" class="btn btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Casts</h5>
                                <div class="px-3 h-auto">
                                    <div class="center slider">
                                        @forelse ($m->casts as $mc)
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img class="mb-1" src="{{ asset('assets/img/user.png') }}" width="50">
                                                <strong>{{ $mc->character_name }}</strong>
                                                <small class="text-wrap">{{ $mc->name }}</small>
                                                <small>({{ $mc->gender }})</small>
                                            </div>
                                        @empty
                                            <div class="d-flex justify-content-center align-items-center">
                                                <h5 class="text-muted">No casts found</h5>
                                            </div>
                                        @endforelse                                                                                    
                                    </div>
                                </div>
                                <hr>
                                <h5 class="card-title">Dialouges</h5>
                                <div class="mt-3" style="max-height:33.7vh; overflow-y: scroll;">
                                    <ol class="list-group h-auto w-100">
                                        @forelse ($m->dialouges as $md)
                                            <li class="list-group-item d-flex justify-content-start align-items-start py-3">
                                                <div class="ms-2 me-auto w-100 d-flex flex-column justify-content-between align-items-start">
                                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                                        <div class="fw-bold">{{ $md->cast->character_name }}</div>
                                                        <div class="d-flex gap-3 justify-content-center align-items-center">
                                                            <span class="badge bg-success rounded-pill" title="Start Time">{{ $md->start }}</span>
                                                            <span class="badge bg-danger rounded-pill" title="End Time">{{ $md->end }}</span>
                                                        </div>
                                                    </div>
                                                    <p class="m-0 p-0">{{ $md->dialouge }}</p>
                                                </div>                                                                                                                        
                                            </li>
                                        @empty
                                            <li class="list-group-item d-flex justify-content-start align-items-start py-3">
                                                <div class="ms-2 me-auto w-100 d-flex flex-column justify-content-center align-items-center">
                                                    <p class="m-0 p-0 text-center">No dialouges found</p>
                                                </div>
                                            </li>
                                        @endforelse                                                   
                                    </ol>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    @empty
        <div class="row">
            <div class="col p-5 d-flex flex-column gap-3 justify-content-center align-items-center">
                <h5 class="text-muted">No movies found</h5>
                <a href="{{ route('movie.create') }}" class="btn btn-lg btn-success">
                    Create Movie
                </a>
            </div>
        </div>
    @endforelse
</div>