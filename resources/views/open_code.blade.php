<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-4">
                                    Box Code
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b odd:bg-white even:bg-gray-100">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {!! QrCode::size(200)->generate($box->code); !!}
                                    </th>
                                </tr>
                                <tr class="border-b odd:bg-white even:bg-gray-100">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Mobile number: {{ $box->mobile_number }}
                                    </th>
                                </tr>
                                <tr class="border-b odd:bg-white even:bg-gray-100">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <a href="/{{ $box->box_name }}/close" class="font-medium text-red-600 mt-3 hover:underline">Close box</a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>