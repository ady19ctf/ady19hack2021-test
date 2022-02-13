<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Vote Result') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Your voting has been successfully completed.</p>
            <div>result: {{$result}}</div>
            <a href="{{ route('dashboard') }}">Return to Dashboard.</a></br>
        </div>
    </div>
</x-app-layout>
