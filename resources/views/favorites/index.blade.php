@extends('layouts.layout')

@section('content')
<div class="max-w-400 mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Mis Favoritos</h2>
    
    <div id="favorites-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <!-- Favorites will be loaded here via JS -->
    </div>

    <div id="no-favorites" class="hidden text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No tienes favoritos</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza a agregar propiedades a tu lista.</p>
        <div class="mt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Explorar Propiedades
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('favorites-container');
        const noFavorites = document.getElementById('no-favorites');
        
        function loadFavorites() {
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            
            if (favorites.length === 0) {
                container.innerHTML = '';
                noFavorites.classList.remove('hidden');
                return;
            }

            noFavorites.classList.add('hidden');
            container.innerHTML = favorites.map(property => `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition overflow-hidden relative">
                    <button onclick="removeFavorite('${property.id}')" class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition z-10 text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <img src="${property.image_url}" class="w-full h-48 object-cover">
                    <div class="p-4 space-y-2">
                        <span class="bg-gray-100 dark:bg-gray-700 dark:text-gray-300 p-1 rounded-lg font-semibold text-xs">${property.type}</span>
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white">${property.title}</h3>
                        <div class="flex gap-2 items-center text-gray-600 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-sm">${property.location}</p>
                        </div>
                        <p class="text-gray-700 font-bold">${property.price}</p>
                        <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-between mt-2">
                            <div class="flex gap-4">
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bath-icon lucide-bath"><path d="M10 4 8 6"/><path d="M17 19v2"/><path d="M2 12h20"/><path d="M7 19v2"/><path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/></svg>
                                    <span class="font-bold">${property.bathrooms}</span>
                                    
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bed-icon lucide-bed"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
                                    <span class="font-bold">${property.bedrooms}</span>
                                </div>
                                <div class="flex items-center gap-1">   
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan-icon lucide-scan"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/></svg>
                                    <span class="font-bold">${property.area}</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="/property/${property.id}" class="p-2 border rounded-lg hover:bg-gray-100 text-black cursor-pointer">Ver Detalles</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            `).join('');
        }

        window.removeFavorite = function(id) {
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            favorites = favorites.filter(p => p.id != id);
            localStorage.setItem('favorites', JSON.stringify(favorites));
            loadFavorites();
            
            // Dispatch event for other components if needed
            window.dispatchEvent(new CustomEvent('favorites-updated'));
        };

        loadFavorites();
    });
</script>
@endsection
