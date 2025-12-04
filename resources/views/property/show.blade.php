<div>
    @extends('layouts.layout')
    @section('content')
        <div class="p-10 m-10 shadow-xl rounded">
            <div class="flex items-center gap-4">
                <a href="{{url('/')}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg></a>
                <div class="flex items-center gap-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <h2>{{ $property->location->location }}</h2>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M17.25 4.75H6.75a3.5 3.5 0 0 0-3.5 3.5v9.5a3.5 3.5 0 0 0 3.5 3.5h10.5a3.5 3.5 0 0 0 3.5-3.5v-9.5a3.5 3.5 0 0 0-3.5-3.5m-14 4.5h17.5M7.361 4.75v-2m9.25 2v-2" />
                    </svg>
                    <h2>{{ date('d/m/Y', strtotime($property->published_at)) }}</h2>
                </div>
            </div>

            <div class="flex justify-between gap-10">
                <div class="my-6 relative w-1/2 h-1/2">


                    <!-- Contenedor de imagen para que el botón quede dentro -->
                    <div class="relative">
                        <img src="{{ $property->image_url }}" alt="{{ $property->title }}"
                            class="rounded-t-xl w-full h-full object-cover">

                        <!-- Botón dentro de la imagen -->
                        <a href="{{ $property->image_url }}" target="_blank"
                            class="absolute top-2 right-2 bg-white opacity-25  p-2 rounded hover:opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M10.25 3.75h-2.5a4 4 0 0 0-4 4v8.5a4 4 0 0 0 4 4h8.5a4 4 0 0 0 4-4v-2.5m-6.5-10h5.5c.276 0 .526.112.707.293m.293 6.207v-5.5a1 1 0 0 0-.293-.707M12.75 11.25l6.5-6.5l.707-.707" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="w-1/2 space-y-8">
                    <h2 class="text-left text-4xl font-bold">Detalles</h2>
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl">{{ $property->type->name }} | {{ $property->title }} <br>
                            {{ $property->location->location }}</h2>
                        <p class="text-2xl font-bold">{{ '$' . number_format($property->price, 2, '.', ',') }}</p>
                    </div>
                    <div class="flex justify-start gap-4">
                        <div
                            class="flex justify-between items-center gap-6 text-gray-600 border border-gray-400 px-6 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-circle-dollar-sign-icon lucide-circle-dollar-sign">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                                <path d="M12 18V6" />
                            </svg>
                            <div>
                                <p>Precio</p>
                                <p class="font-bold">{{ '$' . number_format($property->price, 2, '.', ',') }}</p>
                            </div>


                        </div>
                        <div
                            class="flex justify-between items-center gap-6 text-gray-600 border border-gray-400 px-6 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-bed-icon lucide-bed">
                                <path d="M2 4v16" />
                                <path d="M2 8h18a2 2 0 0 1 2 2v10" />
                                <path d="M2 17h20" />
                                <path d="M6 8v9" />
                            </svg>
                            <div>
                                <p>Recamaras</p>
                                <p class="font-bold">{{ $property->bedrooms }}</p>
                            </div>


                        </div>
                        <div
                            class="flex justify-between items-center gap-6 text-gray-600 border border-gray-400 px-6 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-bath-icon lucide-bath">
                                <path d="M10 4 8 6" />
                                <path d="M17 19v2" />
                                <path d="M2 12h20" />
                                <path d="M7 19v2" />
                                <path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                            </svg>
                            <div>
                                <p>Baños</p>
                                <p class="font-bold">{{ $property->bathrooms }}</p>
                            </div>


                        </div>
                        <div
                            class="flex justify-between items-center gap-6 text-gray-600 border border-gray-400 px-6 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-scan-icon lucide-scan">
                                <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                            </svg>
                            <div>
                                <p>Área</p>
                                <p class="font-bold">{{ $property->area }}</p>
                            </div>


                        </div>

                    </div>

                    <div class="flex justify-evenly items-center">
                        <div>
                            <p>Localización</p>
                            <p class="font-bold">{{ $property->location->location }}</p>
                        </div>
                        <div>
                            <p>Publicado</p>
                            <p class="font-bold">{{date('d/m/Y', strtotime($property->published_at)) }}</p>
                        </div>
                        <div>
                            <p>Precio/M² de Terreno</p>
                            @php
                                $number = (int) filter_var($property->area, FILTER_SANITIZE_NUMBER_INT);
                            @endphp
                            <p class="font-bold">{{  '$' . number_format($property->price / $number, 2, '.', ',') }}</p>
                        </div>
                        <div>
                            <p>M² Totales</p>
                            <p class="font-bold">{{ $number }}</p>
                        </div>
                    </div>
                    <hr>

                    <p class="text-xl">{{ $property->description }}</p>
                    <a class="py-4 px-8 text-lg hover:bg-slate-800 rounded-lg bg-black font-bold text-white" href="{{$property->source}}" target="_blank">Visitar Sitio del anunciante</a>

                </div>

            </div>
            <div class="my-10">
                <iframe src="https://www.google.com/maps?q={{ $property->location->location }}&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>






        </div>
    @endsection
</div>
