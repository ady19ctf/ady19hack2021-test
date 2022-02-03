<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="/vote-check" method="post">
                @csrf
                <button class="btn btn-primary" name="candidate" value="candidate A" type="submit">candidate A</button>
            </form>
            <form action="/vote-check" method="post">
                @csrf
                <button class="btn btn-primary" name="candidate" value="candidate B" type="submit">candidate B</button>
            </form>
            <form action="/vote-check" method="post">
                @csrf
                <button class="btn btn-primary" name="candidate" value="candidate C" type="submit">candidate C</button>
            </form>
        </div>
    </div>
</x-app-layout>
