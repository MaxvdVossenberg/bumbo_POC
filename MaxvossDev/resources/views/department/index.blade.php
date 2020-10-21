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
                            <a class="btn btn-primary float-right" href="{{ route('departments.create') }}">Create department</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10%">#</th>
                                <th style="width: 30%">Title</th>
                                <th style="width: 10%">Color</th>
                                <th style="width: 20%">Created At</th>
                                <th style="width: 20%">Updated At</th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <th scope="row">{{ $department->id }}</th>
                                    <td>{{ $department->title }}</td>
                                    <td><span class="badge badge-secondary" style="font-size: 14px; background-color: {{ $department->color }}">{{ $department->color }}</span></td>
                                    <td>{{ $department->created_at }}</td>
                                    <td>{{ $department->updated_at }}</td>
                                    <td>
                                        <div class="row">
                                            <a class="btn btn-warning" style="margin-right: 2px" href="{{ route('departments.edit', $department) }}"><i class="fa fa-pen"></i></a>
                                            <form method="POST" action="{{ route('departments.destroy', $department) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
