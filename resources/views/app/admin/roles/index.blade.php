<x-app-layout>
    @section('pageTitle')
        {{ __('roles.index.title') }}
    @endsection
    @section('metaDesc')
        {{ __('roles.index.meta_description') }}
    @endsection
    @section('breadcrumb')
        <x-breadcrumb-item wire:navigate href="{{ route('admin.dashboard') }}">
            {{ __('common.admin') }}
        </x-breadcrumb-item>
        <x-breadcrumb-current-item>
            {{ __('roles.index.title') }}
        </x-breadcrumb-current-item>
    @endsection

    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('roles.index.headline') }}
        </h1>
    </x-slot>

    <div class="pt-4 pb-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">

                @livewire('app.admin.users.role-management-component')

            </div>
        </div>
    </div>
</x-app-layout>
