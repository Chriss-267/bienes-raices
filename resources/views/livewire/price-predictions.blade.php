<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl font-extrabold">
                    Clasificación de Precios
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Proyección de valor de mercado por zona.
                </p>
            </div>
            
            <div class="w-full md:w-1/3 mt-4 md:mt-0">
                <div class="relative">
                    <select wire:model.live="selectedLocation" class="block w-full rounded-xl border-gray-200 bg-white text-gray-700 shadow-lg focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white sm:text-sm py-3 px-4 appearance-none">
                        <option value="">Todas las ubicaciones</option>
                        @foreach($locationsList as $location)
                            <option value="{{ $location->id }}">{{ $location->location }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @if($predictions->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-full mb-4">
                    <svg class="h-12 w-12 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Sin datos disponibles</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400 max-w-sm">No hemos encontrado clasificación de precios para la ubicación seleccionada. Intenta con otra zona.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($predictions as $prediction)
                    <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col h-full">
                        
                        <!-- Image Section -->
                        <div class="relative h-56 overflow-hidden">
                            @if($prediction->property && $prediction->property->image_url)
                                <img src="{{ $prediction->property->image_url }}" alt="{{ $prediction->location->location }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    <svg class="h-16 w-16 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide 
                                    {{ $prediction->model_used == 'BARATA' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }} 
                                    backdrop-blur-sm shadow-sm">
                                    {{ $prediction->model_used }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="mb-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">{{ $prediction->location->location }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($prediction->prediction_date)->format('d M, Y') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-1">Precio</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                                            ${{ number_format($prediction->property->price, 0) }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">USD</span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-1">Mediana</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg text-gray-900 dark:text-white tracking-tight">
                                            ${{ number_format($prediction->predicted_price, 0) }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">USD</span>
                                    </div>
                                </div>
                            </div>

                            @if($prediction->property)
                                <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-1" title="Habitaciones">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            <span>{{ $prediction->property->bedrooms ?? '-' }} Hab</span>
                                        </div>
                                        <div class="flex items-center gap-1" title="Baños">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            <span>{{ $prediction->property->bathrooms ?? 'N/A' }} Baños</span>
                                        </div>
                                        <div class="flex items-center gap-1" title="Área">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                            <span>{{ $prediction->property->area ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
