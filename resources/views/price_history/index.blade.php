@extends('layouts.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header & Selector -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Análisis por Ubicación</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Consulta los precios de propiedades por zona.</p>
        </div>
        <div class="mt-4 md:mt-0 w-full md:w-72" x-data="{ 
            open: false, 
            selected: [], 
            options: {{ json_encode($locations) }},
            toggle(id) {
                if (this.selected.includes(id)) {
                    this.selected = this.selected.filter(i => i !== id);
                } else {
                    this.selected.push(id);
                }
                updateCharts(this.selected);
            },
            selectAll() {
                this.selected = this.options.map(o => o.id);
                updateCharts(this.selected);
            },
            deselectAll() {
                this.selected = [];
                updateCharts(this.selected);
            },
            get label() {
                if (this.selected.length === 0) return 'Seleccionar Ubicaciones';
                if (this.selected.length === 1) return this.options.find(o => o.id === this.selected[0]).location;
                return this.selected.length + ' Ubicaciones Seleccionadas';
            },
            init() {
                // Select first location by default if available
                if (this.options.length > 0) {
                    this.selected = [this.options[0].id];
                    updateCharts(this.selected);
                }
            }
        }">
            <label class="sr-only">Seleccionar Ubicaciones</label>
            <div class="relative">
                <button @click="open = !open" @click.away="open = false" type="button" class="relative w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm pl-3 pr-10 py-2.5 text-left cursor-pointer focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <span class="block truncate text-gray-900 dark:text-white" x-text="label"></span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>

                <div x-show="open" class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" style="display: none;">
                    <div class="px-2 py-2 flex gap-2 border-b border-gray-200 dark:border-gray-600">
                        <button @click="selectAll()" class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Todas</button>
                        <span class="text-gray-300">|</span>
                        <button @click="deselectAll()" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Ninguna</button>
                    </div>
                    <template x-for="option in options" :key="option.id">
                        <div @click="toggle(option.id)" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <input type="checkbox" :checked="selected.includes(option.id)" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="ml-3 block truncate" :class="{ 'font-semibold': selected.includes(option.id), 'font-normal': !selected.includes(option.id) }" x-text="option.location"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Properties -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition duration-300 hover:shadow-md">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Propiedades</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white" id="stat-count">
                                    0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Min Price -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition duration-300 hover:shadow-md">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Precio Mínimo</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white" id="stat-min">
                                    $0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Max Price -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition duration-300 hover:shadow-md">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Precio Máximo</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white" id="stat-max">
                                    $0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Price -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg transition duration-300 hover:shadow-md">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Promedio</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white" id="stat-avg">
                                    $0
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Bar Chart: Properties in Location -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Precios de Propiedades</h3>
                <div class="relative h-[400px] w-full">
                    <canvas id="locationBarChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart: Distribution -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Distribución de Precios</h3>
                <div class="relative h-[400px] w-full">
                    <canvas id="locationPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="module">
    const properties = @json($properties);
    const locations = @json($locations);
    
    let barChartInstance = null;
    let pieChartInstance = null;

    const barCtx = document.getElementById('locationBarChart').getContext('2d');
    const pieCtx = document.getElementById('locationPieChart').getContext('2d');
    
    // Stats Elements
    const statCount = document.getElementById('stat-count');
    const statMin = document.getElementById('stat-min');
    const statMax = document.getElementById('stat-max');
    const statAvg = document.getElementById('stat-avg');

    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });

    function updateStats(filteredProperties) {
        if (filteredProperties.length === 0) {
            statCount.textContent = '0';
            statMin.textContent = '$0';
            statMax.textContent = '$0';
            statAvg.textContent = '$0';
            return;
        }

        const prices = filteredProperties.map(p => parseFloat(p.price));
        const min = Math.min(...prices);
        const max = Math.max(...prices);
        const avg = prices.reduce((a, b) => a + b, 0) / prices.length;

        statCount.textContent = filteredProperties.length;
        statMin.textContent = formatter.format(min);
        statMax.textContent = formatter.format(max);
        statAvg.textContent = formatter.format(avg);
    }

    function truncateLabel(label, maxLength = 15) {
        if (label.length > maxLength) {
            return label.substring(0, maxLength) + '...';
        }
        return label;
    }

    // Make updateCharts globally available so Alpine can call it
    window.updateCharts = function(locationIds) {
        // Filter properties by multiple locations
        const filteredProperties = properties.filter(p => locationIds.includes(p.location_id));
        
        updateStats(filteredProperties);

        const fullLabels = filteredProperties.map(p => p.title);
        const truncatedLabels = fullLabels.map(l => truncateLabel(l));
        const data = filteredProperties.map(p => p.price);

        // Destroy existing charts
        if (barChartInstance) barChartInstance.destroy();
        if (pieChartInstance) pieChartInstance.destroy();

        // Bar Chart
        barChartInstance = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: truncatedLabels,
                datasets: [{
                    label: 'Precio',
                    data: data,
                    backgroundColor: '#4f46e5',
                    borderRadius: 4,
                    barPercentage: 0.9,
                    categoryPercentage: 1.0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                // Show full title in tooltip
                                return fullLabels[context[0].dataIndex];
                            },
                            label: function(context) {
                                return formatter.format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return '$' + (value / 1000000).toFixed(1) + 'M';
                                if (value >= 1000) return '$' + (value / 1000).toFixed(0) + 'k';
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart
        pieChartInstance = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: truncatedLabels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#4f46e5', '#10b981', '#ef4444', '#f59e0b', '#3b82f6', 
                        '#8b5cf6', '#ec4899', '#6366f1', '#14b8a6', '#f97316'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { 
                            color: '#6b7280',
                            boxWidth: 12
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return fullLabels[context[0].dataIndex];
                            },
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += formatter.format(context.parsed);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
