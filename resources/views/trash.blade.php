<x-layouts.app :title="__('Trash')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl bg-gradient-to-b from-sky-50 to-blue-50 dark:from-neutral-900 dark:to-neutral-800">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent dark:from-red-400 dark:to-orange-400">
                    🗑️ Trash & Deleted Employees
                </h1>
                <p class="mt-2 text-lg text-neutral-600 dark:text-neutral-400">
                    Manage deleted employees - restore or permanently delete
                </p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="rounded-lg bg-gradient-to-r from-blue-500 to-teal-600 px-6 py-3 text-sm font-bold text-white transition-all hover:shadow-lg hover:scale-105">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Trash Stats Card -->
        <div class="rounded-2xl border border-red-200 bg-gradient-to-r from-red-400 to-orange-400 p-6 shadow-lg dark:border-red-700 dark:from-red-600 dark:to-orange-600">
            <div class="flex items-center gap-4">
                <div class="rounded-full bg-white/20 p-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="text-white">
                    <p class="text-sm font-medium text-red-100">🗑️ Employees in Trash</p>
                    <h3 class="mt-1 text-3xl font-bold">{{ $employees->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="relative flex-1 overflow-hidden rounded-2xl border border-red-200 bg-white/90 backdrop-blur-sm shadow-xl dark:border-neutral-700 dark:bg-neutral-800/90">
            <div class="flex h-full flex-col p-8">
                <h2 class="mb-6 text-2xl font-bold text-red-700 dark:text-red-400">📋 Deleted Employees List</h2>

                @if($employees->isEmpty())
                    <div class="flex flex-1 items-center justify-center rounded-2xl border-2 border-dashed border-red-200 p-12 dark:border-red-700">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 text-red-300 dark:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-4 text-lg font-bold text-red-700 dark:text-red-400">✨ Trash is Empty</h3>
                            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">No deleted employees found. Great job keeping things tidy!</p>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto rounded-xl border border-red-100 dark:border-neutral-700">
                        <table class="w-full">
                            <thead class="border-b border-red-100 bg-gradient-to-r from-red-50 to-orange-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-700 dark:text-red-400">Photo</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-700 dark:text-red-400">Employee</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-700 dark:text-red-400">Contact</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-700 dark:text-red-400">Department</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-red-700 dark:text-red-400">Deleted At</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-red-700 dark:text-red-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100 dark:divide-neutral-700 bg-white/50 dark:bg-neutral-800/30">
                                @foreach($employees as $employee)
                                    <tr class="transition-all hover:bg-red-50/50 dark:hover:bg-neutral-700/50">
                                        <td class="px-6 py-4">
                                            @if($employee->photo)
                                                <img src="{{ Storage::url($employee->photo) }}"
                                                     alt="{{ $employee->name }}"
                                                     class="h-12 w-12 rounded-full object-cover ring-2 ring-red-200 dark:ring-red-900">
                                            @else
                                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-red-400 to-orange-400 text-sm font-semibold text-white">
                                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                                                {{ $employee->name }}
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-500">
                                                {{ $employee->position }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                                {{ $employee->email }}
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-500">
                                                {{ $employee->phone }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($employee->department)
                                                <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                    {{ $employee->department->department_name }}
                                                </span>
                                            @else
                                                <span class="text-xs text-neutral-500 dark:text-neutral-500">No department</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-red-700 dark:text-red-400">
                                                {{ $employee->deleted_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-neutral-500">
                                                {{ $employee->deleted_at->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-3">
                                                <form method="POST" action="{{ route('employees.restore', $employee->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-2 text-xs font-bold text-white transition-all hover:shadow-lg hover:scale-105"
                                                            onclick="return confirm('Restore this employee?')">
                                                        ♻️ Restore
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('employees.forceDelete', $employee->id) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="rounded-lg bg-gradient-to-r from-red-500 to-orange-600 px-4 py-2 text-xs font-bold text-white transition-all hover:shadow-lg hover:scale-105"
                                                            onclick="return confirm('⚠️ PERMANENTLY delete this employee? This cannot be undone!')">
                                                        💀 Delete Forever
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>