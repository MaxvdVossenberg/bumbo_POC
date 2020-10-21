<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $departments = Department::all();
        return view('department.index')
            ->with('departments', $departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('department.create')->with('departments', Department::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'color' => 'required|string|unique:departments,color',
        ]);

        $department = new Department();
        $department->title = $request->title;
        $department->color = $request->color;
        $department->save();

        return redirect()->route('departments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return Renderable
     */
    public function edit(Department $department)
    {
        return view('department.edit')->with('department', $department)->with('departments', Department::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'title' => 'required|string',
            'color' => 'required|string|unique:departments,color',
        ]);

        $department->title = $request->title;
        $department->color = $request->color;
        $department->save();

        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back();
    }
}
