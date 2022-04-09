<x-app-layout>
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
                                    Box Type
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                    Status
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                    Code url
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                    Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b odd:bg-white even:bg-gray-100">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Food Box
                                    </th>
                                    <td class="px-6 py-4">
                                        <button type="button" class="rounded-full bg-green-400 px-2 text-white">open</button>
                                    </td>
                                    <td class="px-6 py-4">
                                    <a href="{{ route('open_code', $food_box->code) }}" class="text-indigo-600">
                                        {{ route('open_code', $food_box->code) }}
                                    </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form 
                                            method="POST"
                                            action="/food_box/generate_code"
                                        >
                                            @csrf
                                            <input type="tel" pattern="[0]{1}[0-9]{9}" required name="mobile_number" placeholder="Enter number.. 05xxxxxxxx">
                                            <button class="font-medium text-blue-600 hover:underline">Genrate code</button>
                                        </form>
                                        <a class="font-medium text-green-600 mt-3 hover:underline">Open box</a>
                                        <a class="font-medium text-red-600 mt-3 hover:underline">Close box</a>
                                    </td>
                                </tr>
                                <tr class="border-b odd:bg-white even:bg-gray-100">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    Delivery Box
                                    </th>
                                    <td class="px-6 py-4">
                                        <button type="button" class="rounded-full bg-red-400 px-2 text-white">open</button>
                                    </td>
                                    <td class="px-6 py-4">
                                    
                                    </td>
                                    <td class="px-6 py-4">
                                        <form 
                                            method="POST"
                                            action="/delivery_box/generate_code"
                                        >
                                            @csrf
                                            <input type="tel" pattern="[0]{1}[0-9]{9}" required name="mobile_number" placeholder="Enter number.. 05xxxxxxxx">
                                            <button class="font-medium text-blue-600 hover:underline">Genrate code</button>
                                        </form>
                                        <a class="font-medium text-green-600 mt-3 hover:underline">Open box</a>
                                        <a class="font-medium text-red-600 mt-3 hover:underline">Close box</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
