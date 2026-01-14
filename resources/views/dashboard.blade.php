@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6" style="color: #000000;">
                @auth
                    <h3 class="text-2xl font-bold mb-4" style="color: #000000;">Dobrodošli, {{ Auth::user()->name }}!</h3>
                    <p class="mb-4" style="color: #000000;">Vaša uloga: <span class="font-bold" style="color: #000000;">{{ ucfirst(Auth::user()->role) }}</span></p>
                    
                    @if(Auth::user()->isAdmin() && !Auth::user()->isDirektor())
                        <div class="bg-blue-50 p-4 rounded-lg mb-4">
                            <p class="text-sm" style="color: #000000;">Kao administrator, imate pristup svim funkcionalnostima sistema.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <a href="{{ route('kupacs.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Kupci</h4>
                            </a>
                            <a href="{{ route('narudzbinas.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Narudžbine</h4>
                            </a>
                            <a href="{{ route('proizvods.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Proizvodi</h4>
                            </a>
                            <a href="{{ route('servis.index') }}" class="bg-red-500 hover:bg-red-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Servis</h4>
                            </a>
                        </div>
                    @elseif(Auth::user()->isDirektor())
                        <div class="bg-purple-50 p-4 rounded-lg mb-6">
                            <p class="text-sm" style="color: #000000;">Kao direktor, imate pristup svim funkcionalnostima sistema i pregled statistike.</p>
                        </div>

                        <!-- Statistika kartice -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                            <div class="bg-blue-50 border-2 border-blue-500 p-6 rounded-lg shadow-lg">
                                <div class="text-3xl font-bold mb-1" style="color: #000000;">{{ number_format($ukupniPrihodi ?? 0, 0) }} RSD</div>
                                <div class="text-sm font-semibold" style="color: #000000;">Ukupni Prihodi</div>
                            </div>
                            <div class="bg-green-50 border-2 border-green-500 p-6 rounded-lg shadow-lg">
                                <div class="text-3xl font-bold mb-1" style="color: #000000;">{{ number_format($mesecniPrihodi ?? 0, 0) }} RSD</div>
                                <div class="text-sm font-semibold" style="color: #000000;">Prihodi Ovog Meseca</div>
                            </div>
                            <div class="bg-yellow-50 border-2 border-yellow-500 p-6 rounded-lg shadow-lg">
                                <div class="text-3xl font-bold mb-1" style="color: #000000;">{{ $ukupnoNarudzbina ?? 0 }}</div>
                                <div class="text-sm font-semibold" style="color: #000000;">Ukupno Narudžbina</div>
                            </div>
                            <div class="bg-purple-50 border-2 border-purple-500 p-6 rounded-lg shadow-lg">
                                <div class="text-3xl font-bold mb-1" style="color: #000000;">{{ $ukupnoKupaca ?? 0 }}</div>
                                <div class="text-sm font-semibold" style="color: #000000;">Ukupno Kupaca</div>
                            </div>
                            <div class="bg-red-50 border-2 border-red-500 p-6 rounded-lg shadow-lg">
                                <div class="text-3xl font-bold mb-1" style="color: #000000;">{{ $ukupnoServisa ?? 0 }}</div>
                                <div class="text-sm font-semibold" style="color: #000000;">Ukupno Servisa</div>
                            </div>
                        </div>

                        <!-- Grafiki -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Grafik prihoda po mesecima -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-6">
                                <h3 class="text-xl font-bold mb-4" style="color: #000000;">📈 Prihodi po Mesecima</h3>
                                <div style="height: 250px; position: relative;">
                                    <canvas id="prihodiChart"></canvas>
                                </div>
                            </div>

                            <!-- Grafik narudžbina po statusu -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-6">
                                <h3 class="text-xl font-bold mb-4" style="color: #000000;">📊 Narudžbine po Statusu</h3>
                                <div style="height: 250px; position: relative;">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Brzi linkovi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <a href="{{ route('kupacs.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition transform hover:scale-105">
                                <h4 class="font-semibold">👥 Kupci</h4>
                            </a>
                            <a href="{{ route('narudzbinas.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition transform hover:scale-105">
                                <h4 class="font-semibold">📦 Narudžbine</h4>
                            </a>
                            <a href="{{ route('proizvods.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-lg text-center transition transform hover:scale-105">
                                <h4 class="font-semibold">🔥 Proizvodi</h4>
                            </a>
                            <a href="{{ route('servis.index') }}" class="bg-red-500 hover:bg-red-600 text-white p-4 rounded-lg text-center transition transform hover:scale-105">
                                <h4 class="font-semibold">🔧 Servis</h4>
                            </a>
                        </div>

                        <!-- Chart.js Script -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                        <script>
                            // Grafik prihoda po mesecima
                            const prihodiCtx = document.getElementById('prihodiChart').getContext('2d');
                            new Chart(prihodiCtx, {
                                type: 'line',
                                data: {
                                    labels: @json($mesecLabels ?? []),
                                    datasets: [{
                                        label: 'Prihodi (RSD)',
                                        data: @json($prihodiData ?? []),
                                        borderColor: 'rgb(59, 130, 246)',
                                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                        borderWidth: 3,
                                        fill: true,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointHoverRadius: 7,
                                        pointBackgroundColor: 'rgb(59, 130, 246)',
                                        pointBorderColor: '#fff',
                                        pointBorderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top',
                                            labels: {
                                                color: '#1f2937',
                                                font: {
                                                    size: 12,
                                                    weight: 'bold'
                                                }
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            titleColor: '#fff',
                                            bodyColor: '#fff',
                                            borderColor: '#fff',
                                            borderWidth: 1,
                                            callbacks: {
                                                label: function(context) {
                                                    return 'Prihodi: ' + new Intl.NumberFormat('sr-RS', {
                                                        style: 'currency',
                                                        currency: 'RSD',
                                                        minimumFractionDigits: 0
                                                    }).format(context.parsed.y);
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            ticks: {
                                                color: '#374151',
                                                font: {
                                                    size: 11,
                                                    weight: '600'
                                                }
                                            },
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)'
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                color: '#374151',
                                                font: {
                                                    size: 11,
                                                    weight: '600'
                                                },
                                                callback: function(value) {
                                                    return new Intl.NumberFormat('sr-RS', {
                                                        style: 'currency',
                                                        currency: 'RSD',
                                                        minimumFractionDigits: 0
                                                    }).format(value);
                                                }
                                            },
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.1)'
                                            }
                                        }
                                    }
                                }
                            });

                            // Grafik narudžbina po statusu
                            const statusCtx = document.getElementById('statusChart').getContext('2d');
                            new Chart(statusCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: @json($statusLabels ?? []),
                                    datasets: [{
                                        data: @json($statusData ?? []),
                                        backgroundColor: @json($statusColors ?? []),
                                        borderWidth: 2,
                                        borderColor: '#fff'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'bottom',
                                            labels: {
                                                color: '#1f2937',
                                                font: {
                                                    size: 12,
                                                    weight: 'bold'
                                                },
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            titleColor: '#fff',
                                            bodyColor: '#fff',
                                            borderColor: '#fff',
                                            borderWidth: 1,
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label || '';
                                                    const value = context.parsed || 0;
                                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                    const percentage = ((value / total) * 100).toFixed(1);
                                                    return label + ': ' + value + ' (' + percentage + '%)';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    @elseif(Auth::user()->hasRole('komercijalista'))
                        <div class="bg-green-50 p-4 rounded-lg mb-4">
                            <p class="text-sm" style="color: #000000;">Kao komercijalista, možete upravljati kupcima, narudžbinama i servisima.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('kupacs.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Kupci</h4>
                            </a>
                            <a href="{{ route('narudzbinas.index') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Narudžbine</h4>
                            </a>
                            <a href="{{ route('servis.index') }}" class="bg-red-500 hover:bg-red-600 text-white p-4 rounded-lg text-center">
                                <h4 class="font-semibold">Servis</h4>
                            </a>
                        </div>
                    @else
                        <div class="bg-yellow-50 p-4 rounded-lg mb-4">
                            <p class="text-sm" style="color: #000000;">Kao korisnik, možete pregledati katalog proizvoda, naručiti proizvode i pratiti svoje narudžbine.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('proizvods.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-lg shadow-lg transition transform hover:scale-105 text-center">
                                <h4 class="font-semibold text-xl mb-2">🔥 Katalog Proizvoda</h4>
                                <p class="text-sm opacity-90">Pregledajte i naručite kotao na biomasu</p>
                            </a>
                            <a href="{{ route('moje.narudzbine') }}" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg shadow-lg transition transform hover:scale-105 text-center">
                                <h4 class="font-semibold text-xl mb-2">📦 Moje Narudžbine</h4>
                                <p class="text-sm opacity-90">Pratite status svojih narudžbina</p>
                            </a>
                </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
