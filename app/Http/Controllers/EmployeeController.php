<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('department');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
        });
    }

         if ($request->filled('department_filter') && $request->department_filter != '') {
            $query->where('department_id', $request->department_filter);
        }

        $employees = $query->latest()->get();
        $departments = Department::all();
        $activeDepartments = Department::count();

        return view('dashboard', compact('employees', 'departments', 'activeDepartments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'position' => 'required|string|max:255', 
            'department_id' => 'required|exists:departments,id',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,webm,ogg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee_photos', 'public');
            $validated['photo'] = $path;
        }

        Employee::create($validated);

        return redirect()->back()->with('success', 'Employee added successfully.');
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,mp4,webm,ogg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $path = $request->file('photo')->store('employee_photos', 'public');
            $validated['photo'] = $path;
        }

        $employee->update($validated);

        return redirect()->back()->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        
            
            $employee->delete();
            return redirect()->back()->with('success', 'Employee successfully moved to trash.');    
        }

    public function trash()
    {
        $employees = Employee::onlyTrashed()->latest('deleted_at')->get();
        return view('trash', compact('employees'));
    }

    public function restore($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);
        $employee->restore();
        return redirect()->back()->with('success', 'Employee restored successfully.');
    }

    public function forceDelete($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        $employee->forceDelete();
        return redirect()->back()->with('success', 'Employee permanently deleted.');
    }

    public function export(Request $request)
    {
        $query = Employee::with('department');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('department_filter') && $request->department_filter != '') {
            $query->where('department_id', $request->department_filter);
        }

        $employees = $query->latest()->get();

        $filename = 'employees_export_' . date('Y-m-d_His') . '.pdf';

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Employees Export</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    padding: 40px;
                    background-color: #f8f9fa;
                    color: #1a1a1a;
                }
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    background-color: white;
                    padding: 40px;
                    border-radius: 8px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                h1 {
                    color: #333;
                    font-size: 24px;
                    font-weight: 700;
                    margin-bottom: 15px;
                }
                .export-info {
                    display: flex;
                    gap: 40px;
                    margin-bottom: 30px;
                    font-size: 14px;
                    color: #666;
                }
                .info-item {
                    flex: 1;
                }
                .info-label {
                    font-size: 12px;
                    color: #999;
                    margin-bottom: 5px;
                }
                .info-value {
                    font-size: 16px;
                    color: #333;
                    font-weight: 600;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th {
                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                    color: white;
                    padding: 12px 15px;
                    text-align: left;
                    font-weight: 600;
                    font-size: 12px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                td {
                    padding: 10px 15px;
                    border-bottom: 1px solid #e5e7eb;
                    font-size: 12px;
                    color: #333;
                }
                tbody tr:nth-child(odd) {
                    background-color: #f9fafb;
                }
                tbody tr:nth-child(even) {
                    background-color: #ffffff;
                }
                .footer {
                    margin-top: 30px;
                    padding: 15px;
                    background-color: #f0f0f0;
                    text-align: center;
                    border-radius: 6px;
                    font-weight: bold;
                    color: #333;
                }
                @media print {
                    body {
                        background-color: white;
                        padding: 0;
                    }
                    .container {
                        box-shadow: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Employees Export Report</h1>
                </div>
                
                <div class="export-info">
                    <div class="info-item">
                        <div class="info-label">Exported on</div>
                        <div class="info-value">' . now()->format('F d, Y \a\t h:i A') . '<br>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Total Records</div>
                        <div class="info-value">' . $employees->count() . '</div>
                    </div>
                </div>

                <div style="margin: 30px 0;">
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr style="background-color: #f0f0f0; border-bottom: 2px solid #333;">
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 5%;">No.</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 18%;">Name</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 20%;">Email</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 12%;">Phone</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 18%;">Address</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 14%;">Position</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 13%;">Department</td>
                            <td style="padding: 10px 15px; font-weight: bold; font-size: 13px; width: 13%;">Created At</td>
                        </tr>
                    </table>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;"></th>
                            <th style="width: 18%;"></th>
                            <th style="width: 20%;"></th>
                            <th style="width: 12%;"></th>
                            <th style="width: 18%;"></th>
                            <th style="width: 14%;"></th>
                            <th style="width: 13%;"></th>
                        </tr>
                    </thead>
                    <tbody>';

                $number = 1;
                foreach ($employees as $employee) {
                    $html .= '<tr>
                        <td>' . $number++ . '</td>
                        <td>' . htmlspecialchars($employee->name) . '</td>
                        <td>' . htmlspecialchars($employee->email) . '</td>
                        <td>' . htmlspecialchars($employee->phone) . '</td>
                        <td>' . htmlspecialchars($employee->address) . '</td>
                        <td>' . htmlspecialchars($employee->position) . '</td>
                        <td>' . htmlspecialchars($employee->department ? $employee->department->department_name : 'N/A') . '</td>
                        <td>' . $employee->created_at->format('Y-m-d H:i:s') . '</td>
                    </tr>';
                }

                $html .= '</tbody>
                </table>

                <div class="footer">
                    Total Employees: ' . $employees->count() . '
                </div>
            </div>
        </body>
        </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream($filename, ['Attachment' => true]);
    }
}