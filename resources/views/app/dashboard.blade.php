<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-cog"></i> {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <section class="container mx-auto px-8 py-4 sm:px-12">
            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Conteo de denuncias activas -->
                <div class="flex flex-col items-center justify-start bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold">Denuncias Activas</h3>
                    <p class="mt-2 text-3xl font-bold">{{ $totalDenuncias }}</p>
                </div>

                <!-- Denuncias cerradas -->
                <div class="flex flex-col items-center justify-start bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold">Denuncias Cerradas</h3>
                    <p class="mt-2 text-3xl font-bold">{{ $denunciasCerradas }}</p>
                </div>

                <!-- Tiempo promedio de cierre -->
                <div class="flex flex-col items-center justify-start bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold">Promedio de Cierre (días)</h3>
                    <p class="mt-2 text-3xl font-bold">{{ $promedioCierre }} días</p>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Gráfico de barras: Histórico mensual de denuncias -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-center mb-4">Histórico Mensual de Denuncias</h3>
                    <canvas id="historicoDenuncias"></canvas>
                </div>

                <!-- Gráfico de pie: Categorización de denuncias -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-center mb-4">Categorización de Denuncias</h3>
                    <canvas id="categoriasDenuncias"></canvas>
                </div>

                <!-- Gráfico de pie: Género del denunciante -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-center mb-4">Género del Denunciante</h3>
                    <canvas id="generoDenunciante"></canvas>
                </div>
            </div>
        </section>
    </div>

    <!-- Scripts para los gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de barras - Histórico Mensual de Denuncias
        var ctxHistorico = document.getElementById('historicoDenuncias').getContext('2d');
        var historicoChart = new Chart(ctxHistorico, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($historicoMensual)) !!}, // Meses
                datasets: [{
                    label: 'Denuncias',
                    data: {!! json_encode(array_values($historicoMensual)) !!}, // Totales
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de pie - Categorización de Denuncias
        var ctxCategorias = document.getElementById('categoriasDenuncias').getContext('2d');
        var categoriasChart = new Chart(ctxCategorias, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($categorizacionDenuncias)) !!}, // Categorías
                datasets: [{
                    data: {!! json_encode(array_values($categorizacionDenuncias)) !!}, // Totales por categoría
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Gráfico de pie - Género del Denunciante
        var ctxGenero = document.getElementById('generoDenunciante').getContext('2d');
        var generoChart = new Chart(ctxGenero, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($denunciasPorGenero)) !!}, // Géneros
                datasets: [{
                    data: {!! json_encode(array_values($denunciasPorGenero)) !!}, // Totales por género
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
</x-tenant-app-layout>
