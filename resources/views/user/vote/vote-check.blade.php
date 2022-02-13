<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote Check') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity md:block" aria-hidden="true"></div>
            <div class="w-full relative flex items-center bg-white px-4 pt-14 pb-8 overflow-hidden shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                <div class="w-full grid grid-cols-1 gap-y-8 gap-x-6 items-start sm:grid-cols-3 lg:gap-x-8">
                    Are you sure to vote for this candidate?
                    <form action="{{ route('user.vote-result') }}" method="post">
                        @csrf
                        <button class="btn btn-primary" name="candidate" value={{$user_id}} type="submit">Yes</button>
                    </form>
                    <form action="{{ route('user.vote') }}" method="get">
                        @csrf
                        <button class="btn btn-primary" type="submit">No</button>
                    </form>
                </dev>
            </dev>
        </div>
    </div>
</x-app-layout>
