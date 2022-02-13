<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
            <!-- <div class="fixed z-10 inset-0 overflow-y-auto" role="dialog" aria-modal="true"> -->
                <!-- <div class="flex min-h-screen text-center md:block md:px-2 lg:px-4" style="font-size: 0"> -->
                    <!--
                    Background overlay, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                        From: "opacity-0"
                        To: "opacity-100"
                    Leaving: "ease-in duration-200"
                        From: "opacity-100"
                        To: "opacity-0"
                    -->
                    <!-- <div class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity md:block" aria-hidden="true"></div> -->

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <!-- <span class="hidden md:inline-block md:align-middle md:h-screen" aria-hidden="true">&#8203;</span> -->

                    <!--
                    Modal panel, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                        To: "opacity-100 translate-y-0 md:scale-100"
                    Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 md:scale-100"
                        To: "opacity-0 translate-y-4 md:translate-y-0 md:scale-95"
                    -->
                    <div class="flex text-base text-left transform transition w-full md:inline-block md:max-w-2xl md:px-4 md:my-8 md:align-middle lg:max-w-4xl">
                        <div class="w-full relative flex items-center bg-white px-4 pt-14 pb-8 overflow-hidden shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                            <!-- <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8">
                            <span class="sr-only">Close</span> -->
                            <!-- Heroicon name: outline/x -->
                            <!-- <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            </button> -->

                            <div class="w-full grid grid-cols-1 gap-y-8 gap-x-6 items-start sm:grid-cols-12 lg:gap-x-8">
                                <!-- <div class="aspect-w-2 aspect-h-3 rounded-lg bg-gray-100 overflow-hidden sm:col-span-4 lg:col-span-5">
                                    <img src="https://tailwindui.com/img/ecommerce-images/product-quick-preview-02-detail.jpg" alt="Two each of gray, white, and black shirts arranged on table." class="object-center object-cover">
                                </div> -->
                                <div class="sm:col-span-8 lg:col-span-7">
                                    <h2 class="text-2xl font-extrabold text-gray-900 sm:pr-12">Please choose one from the following candidates.</h2>

                                    <section aria-labelledby="information-heading" class="mt-2">
                                    <h3 id="information-heading" class="sr-only">Product information</h3>

                                    <section aria-labelledby="options-heading" class="mt-10">
                                        <h3 id="options-heading" class="sr-only">Product options</h3>

                                        <form  method="POST" action="{{ route('user.vote-check') }}">
                                            @csrf
                                            <!-- Candidates -->
                                            <div class="mt-10">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm text-gray-900 font-medium">Candidates</h4>
                                                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Candidates Info</a>
                                                </div>

                                                <fieldset class="mt-4">
                                                    <legend class="sr-only">Candidates Info</legend>
                                                    @foreach($candidate_data_with_realname as $candidate_data)
                                                    <div class="grid grid-cols-4 gap-4">
                                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                                        <label class="group relative border rounded-md py-3 px-5 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 bg-white shadow-sm text-gray-900 cursor-pointer">
                                                            <input type="radio" name="candidate" value="{{$candidate_data['name']}},{{$candidate_data['real_name']}}" type="submit">
                                                            <p id="size-choice-0-label">{{$candidate_data['real_name']}}</p>

                                                            <!--
                                                            Active: "border", Not Active: "border-2"
                                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                                            -->
                                                            <div class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></div>
                                                        </label>

                                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                                        <!-- <label class="group relative border rounded-md py-3 px-5 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 bg-white shadow-sm text-gray-900 cursor-pointer"> -->
                                                            <!-- <input type="radio" name="candidate" value="2" class="sr-only" aria-labelledby="size-choice-1-label"> -->
                                                            <!-- <p id="size-choice-1-label">Candidate B</p> -->

                                                            <!--
                                                            Active: "border", Not Active: "border-2"
                                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                                            -->
                                                            <!-- <div class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></div> -->
                                                        <!-- </label> -->

                                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                                        <!-- <label class="group relative border rounded-md py-3 px-5 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 bg-white shadow-sm text-gray-900 cursor-pointer"> -->
                                                            <!-- <input type="radio" name="candidate" value="3" class="sr-only" aria-labelledby="size-choice-2-label"> -->
                                                            <!-- <p id="size-choice-2-label">Candidate C</p> -->

                                                            <!--
                                                            Active: "border", Not Active: "border-2"
                                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                                            -->
                                                            <!-- <div class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></div> -->
                                                        <!-- </label> -->

                                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                                        <!-- <label class="group relative border rounded-md py-3 px-5 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 bg-white shadow-sm text-gray-900 cursor-pointer"> -->
                                                            <!-- <input type="radio" name="candidate" value="4" class="sr-only" aria-labelledby="size-choice-3-label"> -->
                                                            <!-- <p id="size-choice-3-label">Candidate D</p> -->

                                                            <!--
                                                            Active: "border", Not Active: "border-2"
                                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                                            -->
                                                            <!-- <div class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></div> -->
                                                        <!-- </label> -->

                                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                                        <!-- <label class="group relative border rounded-md py-3 px-5 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 bg-white shadow-sm text-gray-900 cursor-pointer"> -->
                                                            <!-- <input type="radio" name="candidate" value="5" class="sr-only" aria-labelledby="size-choice-4-label"> -->
                                                            <!-- <p id="size-choice-4-label">Candidate E</p> -->

                                                            <!--
                                                            Active: "border", Not Active: "border-2"
                                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                                            -->
                                                            <!-- <div class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></div> -->
                                                        <!-- </label> -->

                                                        <!-- Active: "ring-2 ring-indigo-500" -->
                                                        <!-- <label class="group relative border rounded-md py-3 px-5 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 bg-white shadow-sm text-gray-900 cursor-pointer"> -->
                                                            <!-- <input type="radio" name="candidate" value="6" class="sr-only" aria-labelledby="size-choice-5-label"> -->
                                                            <!-- <p id="size-choice-5-label">Candidate F</p> -->

                                                            <!--
                                                            Active: "border", Not Active: "border-2"
                                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                                            -->
                                                            <!-- <div class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></div> -->
                                                        <!-- </label> -->
                                                    </div>
                                                    @endforeach
                                                </fieldset>
                                            </div>
                                            <button type="submit" class="mt-6 w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Vote</button>
                                        </form>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            <!-- </div> -->

        </div>
    </div>
</x-app-layout>
