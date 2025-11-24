<x-layouts.app :title="__('Dashboard')">
    <style>
        :root{
            --pastel-1: linear-gradient(90deg, rgba(168,237,234,0.95), rgba(254,214,227,0.95));
            --soft-shadow: 0 8px 24px rgba(15,23,42,0.06);
            --muted: #6b7280;
            --accent-text: #0f172a;
        }

        /* cards and panels */
        .page-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: var(--soft-shadow);
            border: 1px solid rgba(15,23,42,0.04);
        }

        .pastel-stripe {
            height: 6px;
            border-radius: 6px;
            background: var(--pastel-1);
            margin-bottom: 14px;
            width: 96px;
        }

        .input-soft {
            background: #ffffff;
            border: 1px solid rgba(15,23,42,0.06);
            color: var(--accent-text);
        }

        .btn-primary {
            background-image: var(--pastel-1);
            color: #07203a;
            border: none;
            box-shadow: 0 6px 18px rgba(168,237,234,0.12);
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid rgba(15,23,42,0.06);
            color: var(--muted);
        }

        .stat-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.9), #ffffff);
            border-radius: 12px;
            padding: 18px;
            border: 1px solid rgba(15,23,42,0.04);
        }

        .dept-table th {
            background: transparent;
            color: var(--muted);
            font-weight: 600;
        }

        .dept-table td {
            color: var(--accent-text);
        }

        .action-link {
            color: #0f172a;
            opacity: 0.85;
        }

        .modal-wrap {
            background: rgba(255,255,255,0.98);
        }

        input:focus, textarea:focus, button:focus, select:focus {
            outline: 2px solid rgba(168,237,234,0.35);
            outline-offset: 2px;
        }

        /* layout tweaks */
        .muted-50 { color: #6b7280; }
    </style>

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="stat-card page-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium muted-50">Total Employees</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900">{{ $employees->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-50 p-3">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card page-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium muted-50">Active Departments</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900">{{ $activeDepartments }}</h3>
                    </div>
                    <div class="rounded-full bg-green-50 p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card page-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium muted-50">Hiring Rate</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900">94%</h3>
                    </div>
                    <div class="rounded-full bg-purple-50 p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Management -->
        <div class="relative h-full flex-1 overflow-hidden page-card">
            <div class="flex h-full flex-col p-6">
                <div class="mb-6 rounded-lg p-6 page-card">
                    <div class="pastel-stripe"></div>
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900">Add New Employee</h2>

                    <form action="{{ route('employees.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium muted-50">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter employee name" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium muted-50">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium muted-50">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium muted-50">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter address" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                            @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium muted-50">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}" placeholder="Enter position" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                            @error('position') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium muted-50">Course</label>
                            <select name="department_id" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                                <option value="">Select a department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }} ({{ $department->description }})
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="rounded-lg btn-primary px-6 py-2 text-sm font-medium">
                                Add Employee
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex-1 overflow-auto">
                    <div class="pastel-stripe" style="width:120px"></div>
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900">Employee List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full dept-table">
                            <thead>
                                <tr class="border-b border-neutral-100">
                                    <th class="px-4 py-3 text-left text-sm">#</th>
                                    <th class="px-4 py-3 text-left text-sm">Name</th>
                                    <th class="px-4 py-3 text-left text-sm">Email</th>
                                    <th class="px-4 py-3 text-left text-sm">Phone</th>
                                    <th class="px-4 py-3 text-left text-sm">Address</th>
                                    <th class="px-4 py-3 text-left text-sm">Position</th>
                                    <th class="px-4 py-3 text-left text-sm">Department</th>
                                    <th class="px-4 py-3 text-left text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100">
                                @forelse($employees as $employee)
                                    <tr class="transition-colors hover:bg-neutral-50">
                                        <td class="px-4 py-3 text-sm muted-50">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-900">{{ $employee->name }}</td>
                                        <td class="px-4 py-3 text-sm muted-50">{{ $employee->email }}</td>
                                        <td class="px-4 py-3 text-sm muted-50">{{ $employee->phone }}</td>
                                        <td class="px-4 py-3 text-sm muted-50">{{ $employee->address }}</td>
                                        <td class="px-4 py-3 text-sm muted-50">{{ $employee->position }}</td>
                                        <td class="px-4 py-3 text-sm muted-50">{{ $employee->department ? $employee->department->department_name : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <button onclick="editEmployee({{ $employee->id }}, '{{ addslashes($employee->name) }}', '{{ addslashes($employee->email) }}', '{{ addslashes($employee->phone) }}', '{{ addslashes($employee->address) }}', '{{ addslashes($employee->position) }}', {{ $employee->department_id ?? 'null' }})"
                                                    class="action-link hover:underline mr-2">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-200">|</span>
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-link text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-sm muted-50">No employees found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-100 modal-wrap p-6 page-card">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900">Edit Employee</h2>

            <form id="editEmployeeForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium muted-50">Name</label>
                        <input type="text" id="edit_name" name="name" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium muted-50">Email</label>
                        <input type="email" id="edit_email" name="email" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium muted-50">Phone</label>
                        <input type="tel" id="edit_phone" name="phone" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium muted-50">Address</label>
                        <input type="text" id="edit_address" name="address" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium muted-50">Position</label>
                        <input type="text" id="edit_position" name="position" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium muted-50">Department</label>
                        <select id="edit_department_id" name="department_id" required class="input-soft w-full rounded-lg px-4 py-2 text-sm">
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditEmployeeModal()" class="rounded-lg btn-ghost px-4 py-2 text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg btn-primary px-4 py-2 text-sm font-medium">
                        Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editEmployee(id, name, email, phone, address, position, departmentId) {
            document.getElementById('editEmployeeModal').classList.remove('hidden');
            document.getElementById('editEmployeeModal').classList.add('flex');
            document.getElementById('editEmployeeForm').action = `/employees/${id}`;
            document.getElementById('edit_name').value = name || '';
            document.getElementById('edit_email').value = email || '';
            document.getElementById('edit_phone').value = phone || '';
            document.getElementById('edit_address').value = address || '';
            document.getElementById('edit_position').value = position || '';
            document.getElementById('edit_department_id').value = departmentId || '';
        }

        function closeEditEmployeeModal() {
            document.getElementById('editEmployeeModal').classList.add('hidden');
            document.getElementById('editEmployeeModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>