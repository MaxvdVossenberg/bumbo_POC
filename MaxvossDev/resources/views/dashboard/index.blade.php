@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="{{ mix('js/fullcalendar.js') }}"></script>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <h3 class="float-left">{{ __('Rooster Bewerken') }}</h3>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary float-right" id="localeButton" style="margin-left: 5px">Deutsch</button>
                                <button class="btn btn-success float-right" type="button" data-toggle="modal" data-target="#eventModal">Dienst Toevoegen</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                @foreach($departments as $department)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox{{ $department->id }}" value="{{ $department->id }}" checked>
                                    <label class="form-check-label" for="inlineCheckbox{{ $department->id }}" style="margin-right: 5px; color: {{ $department->color }}">{{ $department->title }}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-5">
                                <div class="card" style="height: 650px;">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Beschikbare medewerkers</h3>
                                            </div>
                                            <div class="col-6">
                                                <input class="form-control float-right" placeholder="Zoeken..." />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Naam</th>
                                                        <th scope="col">Telefoonnummer</th>
                                                        <th scope="col">Afdeling</th>
                                                        <th scope="col">Schaal</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($users as $user)
                                                        <tr class="draggable-item" id="{{ $user->department->id }}">
                                                            <th scope="row">{{ $user->id }}</th>
                                                            <td id="name">{{ $user->name }}</td>
                                                            <td>{{ $user->phone }}</td>
                                                            <td style="color: {{ $user->department->color }}">{{ $user->department->title }}</td>
                                                            <td>{{ $user->salary }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id='calendar'></div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-1">

                            </div>
                            <div class="col-5 align-content-center">
                                {{ $users->links() }}
                            </div>
                            <div class="col-6">
                                @foreach($departments as $department)
                                    <span><span class="badge badge-secondary" style="font-size: 20px; background-color: {{ $department->color }}">{{ $department->title }}</span></span>
                                @endforeach
                                <button class="btn btn-primary float-right font-weight-bold" data-toggle="modal" data-target="#confirmationModal" style="margin-left: 10px; width: 200px;">Publiceren</button>
                                <button class="btn btn-primary float-right font-weight-bold" style="width: 200px;">Printen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    CREATE NEW EVENT MODEL    --}}
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="newEventForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Create new Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="startInput">Title</label>
                                <input class="form-control" type="text" name="title" id="title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="startInput">Start Time</label>
                                    <input class="form-control" data-id="datetime" type="datetime-local" name="start" id="startInput">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="endInput">End Time</label>
                                    <input class="form-control" data-id="datetime" type="datetime-local" name="end" id="endInput">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="url">Url (optional)</label>
                                <input class="form-control" type="text" name="url" id="url">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="allDay">All day (optional)</label>
                                <input class="form-control" type="checkbox" name="allDay" id="allDay">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="createEventButton" data-dismiss="modal">Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Publiceren</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Weet je zeker dat je het rooster wil publiceren?</p>
                    <p>Deze actie zal het rooster semi-definitief maken</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                    <button type="button" class="btn btn-primary">Publiceren</button>
                </div>
            </div>
        </div>
    </div>
@endsection
