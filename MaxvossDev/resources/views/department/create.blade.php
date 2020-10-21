@extends('layouts.app')

@push('styles')

@endpush

@push('scripts')

@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <h3>{{ __('Departments') }} </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5>Gebruikte kleuren:</h5>
                                @foreach($departments as $department)
                                    <span class="badge badge-secondary" style="font-size: 18px; background-color: {{ $department->color }}">{{ $department->title }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-12">
                                <form action="{{ route('departments.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <input type="color" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color') }}" required>
                                        @error('color')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
