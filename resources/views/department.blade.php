<x-layouts.app :title="__('Departments')">
    <style>
        :root{
            --pastel-1: linear-gradient(90deg, rgba(168,237,234,0.9), rgba(254,214,227,0.9));
            --soft-shadow: 0 6px 20px rgba(15,23,42,0.06);
            --muted: #6b7280;
            --accent-text: #0f172a;
        }

        /* keep everything crisp and white-first */
        .page-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: var(--soft-shadow);
            border: 1px solid rgba(15,23,42,0.04);
        }

        /* thin pastel stripe for section headers */
        .pastel-stripe {
            height: 6px;
            border-radius: 6px;
            background: var(--pastel-1);
            margin-bottom: 14px;
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
            box-shadow: 0 4px 12px rgba(168,237,234,0.18);
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid rgba(15,23,42,0.06);
            color: var(--muted);
        }

        /* table look: white rows, faint separators */
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
            opacity: 0.8;
        }

        /* modal */
        .modal-wrap {
            background: rgba(255,255,255,0.98);
        }

        /* keep focus states accessible and subtle */
        input:focus, textarea:focus, button:focus {
            outline: 2px solid rgba(168,237,234,0.35);
            outline-offset: 2px;
        }

    </style>

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden page-card">
            <div class="flex h-full flex-col p-6">

                <div class="mb-6 rounded-lg p-6 page-card">
                    <div class="pastel-stripe"></div>
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900">Add New Department</h2>

                    <form action="{{ route('departments.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-neutral-700">Department Name</label>
                                <input type="text" name="department_name" value="{{ old('department_name') }}"
                                       placeholder="Enter department name" required
                                       class="input-soft w-full rounded-lg px-4 py-2 text-sm focus:border-blue-300 focus:outline-none">
                                @error('department_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-neutral-700">Description</label>
                                <textarea name="description" rows="1" placeholder="Enter department description"
                                          class="input-soft w-full rounded-lg px-4 py-2 text-sm focus:border-blue-300 focus:outline-none">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg btn-primary px-6 py-2 text-sm font-medium transition-colors hover:opacity-95">
                                Add Department
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Department List Table -->
                <div class="flex-1 overflow-auto">
                    <div class="pastel-stripe" style="width:120px"></div>
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900">Department List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full dept-table">
                            <thead>
                                <tr class="border-b border-neutral-100">
                                    <th class="px-4 py-3 text-center text-sm">#</th>
                                    <th class="px-4 py-3 text-center text-sm">Department Name</th>
                                    <th class="px-4 py-3 text-center text-sm">Description</th>
                                    <th class="px-4 py-3 text-center text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100">
                                @forelse($departments as $department)
                                    <tr class="transition-colors hover:bg-neutral-50" id="department-row-{{ $department->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <span class="department-name-display">{{ $department->department_name }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600">
                                            <span class="department-description-display">{{ Str::limit($department->description, 50) ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editDepartment({{ $department->id }}, '{{ $department->department_name }}', '{{ addslashes($department->description) }}')"
                                                    class="action-link hover:underline mr-2">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-200">|</span>
                                            <form action="{{ route('departments.destroy', $department) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure? This will unassign all employees from this departments.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-link text-red-600 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-neutral-500">
                                            No departments found.
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

    <div id="editDepartmentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-100 modal-wrap p-6 page-card">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900">Edit Department</h2>

            <form id="editDepartmentForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700">Department Name</label>
                        <input type="text" id="edit_department_name" name="department_name" required
                               class="input-soft w-full rounded-lg px-4 py-2 text-sm focus:border-blue-300 focus:outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-neutral-700">Description</label>
                        <textarea id="edit_description" name="description" rows="3"
                                  class="input-soft w-full rounded-lg px-4 py-2 text-sm focus:border-blue-300 focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="rounded-lg btn-ghost px-4 py-2 text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg btn-primary px-4 py-2 text-sm font-medium">
                        Update Department
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