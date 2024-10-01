<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('location', 'ASC')->get();
        return view('pages.department.index', compact('departments'));
    }

    public function showAdd()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('department')->with(['message' => 'Tidak diizinkan', 'alert' => 'alert-danger']);
        }

        return view('pages.department.add');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('department')->with(['message' => 'Tidak diizinkan', 'alert' => 'alert-danger']);
        }

        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        Department::create([
            'name' => $request->name,
            'location' => $request->location
        ]);

        return redirect()->route('department')->with(['message' => 'Department added', 'alert' => 'alert-success']);
    }

    public function destroy($id)
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('department')->with(['message' => 'Tidak diizinkan', 'alert' => 'alert-danger']);
        }

        $department = Department::find($id)->delete();
        return redirect()->route('department')->with(['message' => 'Department deleted', 'alert' => 'alert-danger']);
    }

    public function showEdit($id)
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('department')->with(['message' => 'Tidak diizinkan', 'alert' => 'alert-danger']);
        }

        $department = Department::find($id);
        return view('pages.department.edit', compact('department'));
    }

    public function update($id, Request $request)
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('department')->with(['message' => 'Tidak diizinkan', 'alert' => 'alert-danger']);
        }

        $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        $department = Department::find($id);
        $department->name = $request->name;
        $department->location = $request->location;
        $department->save();

        return redirect()->route('department')->with(['message' => 'Department updated', 'alert' => 'alert-success']);
    }
}
