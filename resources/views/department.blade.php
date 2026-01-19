<x-layouts.app :title="__('Departments')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl bg-gradient-to-b from-sky-50 to-blue-50 dark:from-neutral-900 dark:to-neutral-800">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-teal-400">
                📁 Department Management
            </h1>
            <p class="mt-2 text-lg text-neutral-600 dark:text-neutral-400">
                Organize and manage your company departments
            </p>
        </div>

        <div class="relative flex-1 overflow-hidden rounded-2xl border border-blue-200 bg-white/90 backdrop-blur-sm shadow-xl dark:border-neutral-700 dark:bg-neutral-800/90">
            <div class="flex h-full flex-col p-8">

                <!-- Add New Department Form -->
                <div class="mb-8 rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-teal-50 p-8 dark:border-neutral-700 dark:from-neutral-900/50 dark:to-neutral-800/50">
                    <h2 class="mb-6 text-2xl font-bold text-teal-800 dark:text-teal-300">➕ Add New Department</h2>

                    <form action="{{ route('departments.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Department Name</label>
                                <input type="text" name="department_name" value="{{ old('department_name') }}"
                                       placeholder="e.g., Human Resources" required
                                       class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                @error('department_name')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Description</label>
                                <textarea name="description" rows="1" placeholder="Describe the department's purpose and responsibilities"
                                          class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-gradient-to-r from-teal-500 to-blue-600 px-8 py-2 text-sm font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                                ✨ Add Department
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Department List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-2xl font-bold text-teal-800 dark:text-teal-300">📋 Department List</h2>
                    <div class="overflow-x-auto rounded-xl border border-blue-100 dark:border-neutral-700">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-blue-100 bg-gradient-to-r from-blue-50 to-teal-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-6 py-4 text-center text-sm font-bold text-teal-700 dark:text-teal-300">#</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-teal-700 dark:text-teal-300">Department Name</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-teal-700 dark:text-teal-300">Description</th>
                                    <th class="px-6 py-4 text-center text-sm font-bold text-teal-700 dark:text-teal-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100 dark:divide-neutral-700 bg-white/50 dark:bg-neutral-800/30">
                                @forelse($departments as $department)
                                    <tr class="transition-all hover:bg-blue-50/50 dark:hover:bg-neutral-700/50" id="department-row-{{ $department->id }}">
                                        <td class="px-6 py-4 text-center text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-center text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                                            <span class="department-name-display">{{ $department->department_name }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-neutral-600 dark:text-neutral-400">
                                            <span class="department-description-display">{{ Str::limit($department->description, 50) ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm space-x-2">
                                            <button onclick="editDepartment({{ $department->id }}, '{{ $department->department_name }}', '{{ addslashes($department->description) }}')"
                                                    class="text-blue-600 transition-colors hover:text-blue-800 font-bold dark:text-blue-400 dark:hover:text-blue-300">
                                                ✏️ Edit
                                            </button>
                                            <span class="text-neutral-400">|</span>
                                            <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure? This will unassign all employees from this department.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-800 font-bold dark:text-red-400 dark:hover:text-red-300">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            📭 No departments found. Add your first department above!
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

    <!-- Edit Department Modal -->
    <div id="editDepartmentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-2xl border border-blue-200 bg-white p-8 shadow-2xl dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-6 text-2xl font-bold bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent dark:from-teal-400 dark:to-blue-400">✏️ Edit Department</h2>

            <form id="editDepartmentForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Department Name</label>
                        <input type="text" id="edit_department_name" name="department_name" required
                               class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-teal-700 dark:text-teal-300">Description</label>
                        <textarea id="edit_description" name="description" rows="3"
                                  class="w-full rounded-lg border border-teal-200 bg-white px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                            class="rounded-lg border border-teal-300 px-6 py-2 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-gradient-to-r from-teal-500 to-blue-600 px-6 py-2 text-sm font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                        ✨ Update Department
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editDepartment(id, name, description) {
            document.getElementById('editDepartmentModal').classList.remove('hidden');
            document.getElementById('editDepartmentModal').classList.add('flex');
            document.getElementById('editDepartmentForm').action = `/departments/${id}`;
            document.getElementById('edit_department_name').value = name;
            document.getElementById('edit_description').value = description || '';
        }

        function closeEditModal() {
            document.getElementById('editDepartmentModal').classList.add('hidden');
            document.getElementById('editDepartmentModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>