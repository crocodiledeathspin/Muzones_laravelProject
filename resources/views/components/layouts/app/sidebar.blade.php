<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-blue-200 bg-gradient-to-b from-blue-50 to-sky-50 dark:border-blue-900/30 dark:bg-gradient-to-b dark:from-zinc-800 dark:to-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 mb-6 flex items-center space-x-3 rtl:space-x-reverse px-2" wire:navigate>
                <div class="rounded-lg bg-gradient-to-r from-blue-500 to-teal-500 p-2 flex-shrink-0">
                    <x-app-logo />
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-base font-bold bg-gradient-to-r from-blue-600 to-teal-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-teal-400 line-clamp-1">Muzones EduStaff</h2>
                    <div class="text-xs text-gray-600 dark:text-gray-400 leading-tight">
                        <p>Employee</p>
                        <p>Manager</p>
                    </div>
                </div>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('📊 Main Navigation')" class="grid">
                   <flux:navlist.item
                        icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        class="rounded-lg transition-all hover:bg-blue-100 dark:hover:bg-blue-900/30"
                        wire:navigate>
                        <span class="font-semibold">{{ __('Dashboard') }}</span>
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="book-open"
                        :href="route('departments.index')"
                        :current="request()->routeIs('departments.*')"
                        class="rounded-lg transition-all hover:bg-emerald-100 dark:hover:bg-emerald-900/30"
                        wire:navigate>
                        <span class="font-semibold">{{ __('Departments') }}</span>
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="trash"
                        :href="route('employees.trash')"
                        :current="request()->routeIs('employees.trash')"
                        class="rounded-lg transition-all hover:bg-red-100 dark:hover:bg-red-900/30"
                        wire:navigate>
                        <span class="font-semibold">{{ __('Trash') }}</span>
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:navlist>

            <!-- Quick Stats -->
            <div class="mx-3 my-4 rounded-lg bg-gradient-to-r from-blue-100 to-teal-100 p-4 dark:from-blue-900/20 dark:to-teal-900/20">
                <h3 class="text-xs font-bold text-blue-900 dark:text-blue-300 mb-3">📈 Quick Stats</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 dark:text-gray-400">Total Employees:</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ \App\Models\Employee::count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 dark:text-gray-400">Departments:</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ \App\Models\Department::count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 dark:text-gray-400">In Trash:</span>
                        <span class="font-bold text-red-600 dark:text-red-400">{{ \App\Models\Employee::onlyTrashed()->count() ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    class="rounded-lg bg-blue-100/50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-gradient-to-r from-blue-400 to-teal-400 text-white font-bold dark:bg-gradient-to-r dark:from-blue-600 dark:to-teal-600"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="text-gray-700 dark:text-gray-300">{{ __('⚙️ Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-red-600 dark:text-red-400">
                            {{ __('🚪 Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden border-b border-blue-200 bg-gradient-to-r from-blue-50 to-sky-50 dark:border-blue-900/30 dark:bg-gradient-to-r dark:from-zinc-800 dark:to-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    class="rounded-lg bg-blue-100/50 dark:bg-blue-900/30"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-gradient-to-r from-blue-400 to-teal-400 text-white font-bold dark:bg-gradient-to-r dark:from-blue-600 dark:to-teal-600"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('⚙️ Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('🚪 Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>


