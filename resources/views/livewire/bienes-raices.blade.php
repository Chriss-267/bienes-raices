<div class="mb-20">
    <div class="h-[45vh] bg-blue-500">
        <div class="text-center py-12 space-y-2">
            <h1 class="text-4xl text-white font-semibold">Encuentra tu Hogar Ideal</h1>
            <p class="text-white text-muted ">Descubre miles de propiedades en venta. Tu próxima casa te está esperando.
            </p>
        </div>

        <div
            class="w-full max-w-2xl bg-gray-200 mx-auto rounded-full shadow-2xl p-2 flex items-center border border-gray-100">

            <div
                class="flex-grow min-w-0 px-4 py-2 hover:bg-white rounded-full transition duration-150 ease-in-out cursor-pointer focus-within:bg-gray-100 relative">
                <label for="categorias" class="block text-xs font-semibold text-gray-900">Categorías</label>

                <select wire:model.live='type'
                    class="w-full text-sm text-gray-700 bg-transparent border-none p-0 focus:ring-0 focus:outline-none appearance-none cursor-pointer">
                    <option value="">Todos los tipos</option>
                    @foreach ($types as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center pr-2">
                    <svg class="w-4 h-4 text-gray-500 mt-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <div
                class="flex-grow min-w-0 px-4 py-2 hover:bg-white rounded-full transition duration-150 ease-in-out cursor-pointer focus-within:bg-gray-100">
                <label for="ubicacion" class="block text-xs font-semibold text-gray-900">Ubicación</label>

                <input type="text" id="ubicacion" placeholder="¿Dónde quieres ir?" wire:model.live='search'
                    class="w-full text-sm text-gray-700 bg-transparent border-none p-0 focus:ring-0 focus:outline-none placeholder-gray-400">
            </div>

            <button
                class="flex-shrink-0 bg-black hover:bg-gray-800 text-white p-3.5 rounded-full ml-2 transition duration-150 ease-in-out flex items-center shadow-lg cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

    </div>

    <div class="p-10">
        <h2 class="text-3xl font-bold">Propiedades disponibles</h2>
        <p class="text-gray-600 text-lg">{{ $properties->total() .  ($properties->total() >= 0 ? ' Propiedades encontradas.' : ' Propiedad encontrada.')}}</p>
        <div class="flex justify-between items-center mt-2">
            <button wire:click="$toggle('showFilters')"
                class="px-4 py-2 rounded-full hover:bg-gray-200 transition flex items-center gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal-icon lucide-sliders-horizontal"><path d="M10 5H3"/><path d="M12 19H3"/><path d="M14 3v4"/><path d="M16 17v4"/><path d="M21 12h-9"/><path d="M21 19h-5"/><path d="M21 5h-7"/><path d="M8 10v4"/><path d="M8 12H3"/></svg>
                Filtros
            </button>
        </div>
        <div class="rounded-lg p-4" style="max-width:300px;" x-data="{ open: @entangle('showFilters') }" x-show="open">
        <div class="price-range p-4">
        <span class="text-sm">${{ number_format($price, 2, '.', ',') }}</span>
            <input
                class="w-full accent--600"
                type="range"
                wire:model.live="price"
                min="{{ $minPrice }}"
                max="{{ $maxPrice }}"
                oninput="this.previousElementSibling.innerText=this.value"
            />

            <div class="mt-2 flex w-full justify-between">
            <span class="text-sm text-gray-600">${{number_format($minPrice, 2, '.', ',')}}</span>
            <span class="text-sm text-gray-600">${{number_format($maxPrice), 2, '.', ','}}</span>
            </div>
        </div>
        </div>


        <div class="my-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($properties as $property)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition relative">
                <button onclick="toggleFavorite(this, {{ json_encode([
                    'id' => $property->id,
                    'title' => $property->title,
                    'price' => '$' . number_format($property->price, 2),
                    'image_url' => $property->image_url,
                    'location' => $property->location->location,
                    'type' => $property->type->name,
                    'bedrooms' => $property->bedrooms,
                    'bathrooms' => $property->bathrooms,
                    'area' => $property->area
                ]) }})" 
                class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition z-10 favorite-btn"
                data-id="{{ $property->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                <img src="{{ $property->image_url }}" class="rounded-t-xl w-full h-48 object-cover">
                <div class="p-4 space-y-2">
                    <span class="bg-gray-100 p-1 rounded-lg font-semibold">{{ $property->type->name }}</span>
                    <h3 class="font-semibold text-lg">{{ $property->title }}</h3>
                    <div class="flex gap-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <p class="text-sm text-gray-600">{{ $property->location->location }}</p>
                    </div>
                    <p class="text-gray-700 font-bold">${{ number_format($property->price, 2) }}</p>
                    <div class="text-sm text-gray-500 flex items-center justify-between">
                        <div class="flex gap-6 items-center">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bath-icon lucide-bath"><path d="M10 4 8 6"/><path d="M17 19v2"/><path d="M2 12h20"/><path d="M7 19v2"/><path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/></svg>
                                <p>{{ $property->bathrooms }}</p>
                            </div>
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bed-icon lucide-bed"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
                                <p>{{ $property->bedrooms }}</p>
                            </div>
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan-icon lucide-scan"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/></svg>
                                <p>{{ $property->area }}</p>
                            </div>
                            
                        </div>
                        <div>
                            <a href="{{ route('property.show', $property->id)}}" class="p-2 border rounded-lg hover:bg-gray-100 text-black cursor-pointer">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
    
    <div class="mt-6">
        {{ $properties->links() }}
    </div>

    <script>
        function toggleFavorite(btn, property) {
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const index = favorites.findIndex(p => p.id === property.id);
            const svg = btn.querySelector('svg');
            
            if (index === -1) {
                // Add to favorites
                favorites.push(property);
                svg.setAttribute('fill', 'currentColor');
                svg.classList.remove('text-gray-400');
                svg.classList.add('text-red-500');
            } else {
                // Remove from favorites
                favorites.splice(index, 1);
                svg.setAttribute('fill', 'none');
                svg.classList.remove('text-red-500');
                svg.classList.add('text-gray-400');
            }
            
            localStorage.setItem('favorites', JSON.stringify(favorites));
        }

        function updateFavoriteIcons() {
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const buttons = document.querySelectorAll('.favorite-btn');
            
            buttons.forEach(btn => {
                const id = parseInt(btn.dataset.id);
                const isFavorite = favorites.some(p => p.id === id);
                const svg = btn.querySelector('svg');
                
                if (isFavorite) {
                    svg.setAttribute('fill', 'currentColor');
                    svg.classList.remove('text-gray-400');
                    svg.classList.add('text-red-500');
                } else {
                    svg.setAttribute('fill', 'none');
                    svg.classList.remove('text-red-500');
                    svg.classList.add('text-gray-400');
                }
            });
        }

        // Run on load and after Livewire updates
        document.addEventListener('DOMContentLoaded', updateFavoriteIcons);
        document.addEventListener('livewire:navigated', updateFavoriteIcons);
        document.addEventListener('livewire:updated', updateFavoriteIcons);
    </script>
</div>
