<x-app-layout>
    @section('pageTitle')
        {{ __('roles.create.title') }}
    @endsection
    @section('metaDesc')
        {{ __('roles.create.meta_description') }}
    @endsection
    @section('breadcrumb')
        <x-breadcrumb-item wire:navigate href="{{ route('admin.dashboard') }}">
            {{ __('common.admin') }}
        </x-breadcrumb-item>
        <x-breadcrumb-item wire:navigate href="{{ route('admin.roles.index') }}">
            {{ __('roles.index.title') }}
        </x-breadcrumb-item>
        <x-breadcrumb-current-item>
            {{ __('roles.create.title') }}
        </x-breadcrumb-current-item>
    @endsection

    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('roles.create.headline') }}
        </h1>
    </x-slot>

    <div class="pt-4 pb-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">

                @livewire('app.admin.users.roles.create-role-component')

            </div>
        </div>
    </div>
</x-app-layout>
