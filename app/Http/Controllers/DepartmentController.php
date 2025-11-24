<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->get();
        return view('department', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Department::create($validated);
        return redirect()->back()->with(['success' => 'Department added successfully.']);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $department->update($validated);
        return redirect()->back()->with(['success' => 'Department updated successfully.']);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back()->with(['success' => 'Department deleted successfully.'] );
    }
}
