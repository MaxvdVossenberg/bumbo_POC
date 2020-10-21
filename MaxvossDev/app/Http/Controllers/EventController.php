<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Models\Department;
use App\Models\Event;
use Exception;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $events = Event::all();
        return $events->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEvent  $request
     */
    public function store(StoreEvent $request)
    {
        Event::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $event
     * @return string
     */
    public function show(Event $event)
    {
        return $event->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param int $department
     * @return string
     */
    public function getGroup(int $department)
    {
        $events = Department::find($department)->events;
        return $events->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEvent  $request
     * @param  int  $event
     * @return JsonResponse
     */
    public function update(UpdateEvent $request, int $event)
    {
        Event::find($event)->update($request->validated());
        return response()->json(['success' => 'Edited Event']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => 'Deleted Event']);
    }
}
