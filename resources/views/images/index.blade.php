<!-- resources/views/images/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your Images') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($images->count() > 0)
                        <ul>
                            <div class="d-flex flex-wrap w-100">
                            @foreach ($images as $image)
                            <div class="col-md-4 mb-3 p-2" >
                                <div class="card">
                                    <a href="{{ asset('storage/' . $image->path) }}" data-lightbox="gallery" data-title="{{ $image->name }}">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="img-thumbnail" alt="{{ $image->name }}">
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">{{ $image->name }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </ul>
                    @else
                        <p>No images uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
