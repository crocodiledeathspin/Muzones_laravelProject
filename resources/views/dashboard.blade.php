<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl bg-gradient-to-b from-sky-50 to-blue-50 dark:from-neutral-900 dark:to-neutral-800">

        <!-- Success Message -->
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-teal-400">
                📊 Employee Dashboard
            </h1>
            <p class="mt-2 text-lg text-neutral-600 dark:text-neutral-400">
                Welcome back! Manage your team with ease
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-6 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-400 to-cyan-400 p-6 shadow-lg dark:from-blue-600 dark:to-cyan-600">
                <div class="absolute -bottom-4 -right-4 opacity-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="relative z-10 text-white">
                    <p class="text-sm font-medium text-blue-100">👥 Total Employees</p>
                    <h3 class="mt-2 text-3xl font-bold">{{ $employees->count() }}</h3>
                    <p class="mt-1 text-xs text-blue-100">Active team members</p>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-400 to-teal-400 p-6 shadow-lg dark:from-emerald-600 dark:to-teal-600">
                <div class="absolute -bottom-4 -right-4 opacity-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="relative z-10 text-white">
                    <p class="text-sm font-medium text-emerald-100">📁 Active Departments</p>
                    <h3 class="mt-2 text-3xl font-bold">{{ $activeDepartments }}</h3>
                    <p class="mt-1 text-xs text-emerald-100">Operational departments</p>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-400 to-pink-400 p-6 shadow-lg dark:from-purple-600 dark:to-pink-600">
                <div class="absolute -bottom-4 -right-4 opacity-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="relative z-10 text-white">
                    <p class="text-sm font-medium text-purple-100">📈 Hiring Rate</p>
                    <h3 class="mt-2 text-3xl font-bold">94%</h3>
                    <p class="mt-1 text-xs text-purple-100">Success rate</p>
                </div>
            </div>
        </div>

        <!-- Employee Management Section -->
        <div class="relative flex-1 overflow-hidden rounded-2xl border border-blue-200 bg-white/90 backdrop-blur-sm shadow-xl dark:border-neutral-700 dark:bg-neutral-800/90">
            <div class="flex h-full flex-col p-8">

                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-teal-800 dark:text-teal-300">👨‍💼 Manage Employees</h2>
                        <p class="mt-1 text-sm text-teal-600 dark:text-teal-400">Add, edit, or manage your team members</p>
                    </div>
                    <form method="GET" action="{{ route('employees.export') }}" class="inline">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="department_filter" value="{{ request('department_filter') }}">

                        <button type="submit"
                                class="flex items-center gap-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-2 text-sm font-medium text-white transition-all hover:shadow-lg hover:scale-105">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export to PDF
                        </button>
                    </form>
                </div>

                <!-- Add New Employee Form -->
                <div class="mb-8 rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-teal-50 p-8 dark:border-neutral-700 dark:from-neutral-900/50 dark:to-neutral-800/50">
                    <h3 class="mb-4 text-xl font-bold text-teal-800 dark:text-teal-300">➕ Add New Employee</h3>

                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter employee name" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('name') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('email') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('phone') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter address" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('address') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}" placeholder="Enter position" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('position') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Department</label>
                            <select name="department_id" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="">Select a department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }} ({{ $department->description }})
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>

                        <!-- Photo Upload -->
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">
                                📷 Employee Photo (Optional)
                            </label>
                            <input
                                type="file"
                                name="photo"
                                accept="video/mp4,video/webm,video/ogg,image/jpeg,image/png,image/jpg"
                                class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-teal-700 hover:file:bg-teal-100 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 dark:file:bg-teal-900/20 dark:file:text-teal-400"
                            >
                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                JPG, PNG, JPEG, MP4, WebM or OGG. Max 2MB.
                            </p>
                            @error('photo')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="rounded-lg bg-gradient-to-r from-teal-500 to-blue-600 px-8 py-2 text-sm font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                                ✨ Add Employee
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Search & Filter Section -->
                <div class="rounded-2xl border border-blue-100 bg-white/80 p-6 mb-8 dark:border-neutral-700 dark:bg-neutral-800/80">
                    <h3 class="mb-4 text-lg font-bold text-teal-800 dark:text-teal-300">🔍 Search & Filter Employees</h3>

                    <form action="{{ route('dashboard') }}" method="GET" class="grid gap-4 md:grid-cols-3">
                        <!-- Search Input -->
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Search</label>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name or email"
                                class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                            >
                        </div>

                        <!-- Department Filter Dropdown -->
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Filter by Department</label>
                            <select
                                name="department_filter"
                                class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                            >
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department_filter') == $department->id ? 'selected' : '' }}>
                                        {{ $department->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2 md:col-span-1">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-gradient-to-r from-blue-500 to-teal-600 px-4 py-2 text-sm font-bold text-white transition-all hover:shadow-lg"
                            >
                                🔎 Apply Filters
                            </button>
                            <a
                                href="{{ route('dashboard') }}"
                                class="rounded-lg border border-teal-300 px-4 py-2 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700"
                            >
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Employee List Table -->
                <div class="flex-1 overflow-auto">
                    <h3 class="mb-4 text-lg font-bold text-teal-800 dark:text-teal-300">📋 Employee List</h3>
                    <div class="overflow-x-auto rounded-xl border border-blue-100 dark:border-neutral-700">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-blue-100 bg-gradient-to-r from-blue-50 to-teal-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-teal-600 dark:text-teal-400">Photo</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">Email</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">Phone</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">Position</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">Department</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-teal-700 dark:text-teal-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100 dark:divide-neutral-700 bg-white/50 dark:bg-neutral-800/30">
                                @forelse($employees as $employee)
                                    <tr class="transition-all hover:bg-blue-50/50 dark:hover:bg-neutral-700/50">
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">
                                            @if($employee->photo)
                                                <img
                                                    src="{{ Storage::url($employee->photo) }}"
                                                    alt="{{ $employee->name }}"
                                                    class="h-12 w-12 rounded-full object-cover ring-2 ring-blue-200 dark:ring-blue-900"
                                                >
                                            @else
                                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-blue-400 to-teal-400 text-sm font-bold text-white">
                                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $employee->name }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $employee->email }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $employee->phone }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $employee->position }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ $employee->department ? $employee->department->department_name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <button onclick="editEmployee({{ $employee->id }}, '{{ addslashes($employee->name) }}', '{{ addslashes($employee->email) }}', '{{ addslashes($employee->phone) }}', '{{ addslashes($employee->address) }}', '{{ addslashes($employee->position) }}', {{ $employee->department_id ?? 'null' }}, '{{ $employee->photo }}')"
                                                    class="text-blue-600 transition-colors hover:text-blue-800 font-medium dark:text-blue-400 dark:hover:text-blue-300">
                                                ✏️ Edit
                                            </button>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-800 font-medium dark:text-red-400 dark:hover:text-red-300">🗑️ Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            📭 No employees found. Add your first employee above!
                                        </td>
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
    <div id="editEmployeeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-2xl border border-blue-200 bg-white p-8 shadow-2xl dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-6 text-2xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent dark:from-teal-400 dark:to-blue-400">✏️ Edit Employee</h2>

            <form id="editEmployeeForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Name</label>
                        <input type="text" id="edit_name" name="name" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Email</label>
                        <input type="email" id="edit_email" name="email" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Phone</label>
                        <input type="tel" id="edit_phone" name="phone" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Address</label>
                        <input type="text" id="edit_address" name="address" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Position</label>
                        <input type="text" id="edit_position" name="position" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Department</label>
                        <select id="edit_department_id" name="department_id" required class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Photo Upload in Edit Modal -->
                <div class="mt-4 md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">
                        📷 Employee Photo
                    </label>

                    <!-- Current Photo Preview -->
                    <div id="currentPhotoPreview" class="mb-3"></div>

                    <input
                        type="file"
                        id="edit_photo"
                        name="photo"
                        accept="video/mp4,video/webm,video/ogg,image/jpeg,image/png,image/jpg"
                        class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-teal-700 hover:file:bg-teal-100 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100 dark:file:bg-teal-900/20 dark:file:text-teal-400"
                    >
                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                        Leave empty to keep current photo. JPG, PNG, JPEG, MP4, WebM or OGG. Max 2MB.
                    </p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditEmployeeModal()" class="rounded-lg border border-teal-300 px-6 py-2 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg bg-gradient-to-r from-teal-500 to-blue-600 px-6 py-2 text-sm font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        ✨ Update Employee
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editEmployee(id, name, email, phone, address, position, departmentId, photo) {
            document.getElementById('editEmployeeModal').classList.remove('hidden');
            document.getElementById('editEmployeeModal').classList.add('flex');
            document.getElementById('editEmployeeForm').action = `/employees/${id}`;
            document.getElementById('edit_name').value = name || '';
            document.getElementById('edit_email').value = email || '';
            document.getElementById('edit_phone').value = phone || '';
            document.getElementById('edit_address').value = address || '';
            document.getElementById('edit_position').value = position || '';
            document.getElementById('edit_department_id').value = departmentId || '';

            const photoPreview = document.getElementById('currentPhotoPreview');
            if (photo) {
                photoPreview.innerHTML = `
                    <div class="flex items-center gap-3 rounded-lg border border-neutral-200 p-3 dark:border-neutral-700">
                        <img src="/storage/${photo}" alt="${name}" class="h-16 w-16 rounded-full object-cover">
                        <div>
                            <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Current Photo</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Upload new photo to replace</p>
                        </div>
                    </div>
                `;
            } else {
                photoPreview.innerHTML = `
                    <div class="rounded-lg border border-dashed border-neutral-300 p-4 text-center dark:border-neutral-600">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No photo uploaded</p>
                    </div>
                `;
            }
        }

        function closeEditEmployeeModal() {
            document.getElementById('editEmployeeModal').classList.add('hidden');
            document.getElementById('editEmployeeModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>