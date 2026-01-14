<?php

namespace App\Http\Controllers;

use App\Models\Kupac;
use App\Models\Narudzbina;
use App\Models\Proizvod;
use App\Models\Servis;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics and charts.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Ako je direktor, pripremi podatke za grafike
        if ($user->isDirektor()) {
            // Prihodi po mesecima (poslednjih 6 meseci) - SQLite kompatibilno
            $narudzbine = Narudzbina::where('datum_narudzbine', '>=', Carbon::now()->subMonths(6)->toDateString())
                ->where('status', '!=', 'otkazana')
                ->get();

            // Grupiši po mesecima u PHP-u
            $prihodiPoMesecima = [];
            foreach ($narudzbine as $narudzbina) {
                $date = Carbon::parse($narudzbina->datum_narudzbine);
                $key = $date->format('Y-m');

                if (! isset($prihodiPoMesecima[$key])) {
                    $prihodiPoMesecima[$key] = [
                        'godina' => $date->year,
                        'mesec' => $date->month,
                        'ukupno' => 0,
                    ];
                }

                $prihodiPoMesecima[$key]['ukupno'] += (float) $narudzbina->ukupna_cena;
            }

            // Formatiraj podatke za Chart.js
            $mesecLabels = [];
            $prihodiData = [];

            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $key = $date->format('Y-m');
                $mesecLabels[] = $date->format('M Y');

                $prihodiData[] = isset($prihodiPoMesecima[$key]) ? (float) $prihodiPoMesecima[$key]['ukupno'] : 0;
            }

            // Narudžbine po statusu
            $narudzbinePoStatusu = Narudzbina::select('status', DB::raw('COUNT(*) as broj'))
                ->groupBy('status')
                ->get();

            $statusLabels = $narudzbinePoStatusu->pluck('status')->map(function ($status) {
                return ucfirst($status);
            })->toArray();
            $statusData = $narudzbinePoStatusu->pluck('broj')->toArray();

            // Mapiranje boja po statusu
            $colorMap = [
                'kreirana' => 'rgba(59, 130, 246, 0.8)',   // plava
                'u obradi' => 'rgba(234, 179, 8, 0.8)',   // žuta
                'isporučena' => 'rgba(34, 197, 94, 0.8)',  // zelena
                'otkazana' => 'rgba(239, 68, 68, 0.8)',     // crvena
            ];

            $statusColors = $narudzbinePoStatusu->pluck('status')->map(function ($status) use ($colorMap) {
                return $colorMap[strtolower($status)] ?? 'rgba(156, 163, 175, 0.8)'; // siva za nepoznate
            })->toArray();

            // Ukupna statistika
            $ukupniPrihodi = Narudzbina::where('status', '!=', 'otkazana')->sum('ukupna_cena');
            $ukupnoNarudzbina = Narudzbina::count();
            $ukupnoKupaca = Kupac::count();
            $ukupnoProizvoda = Proizvod::count();
            $ukupnoServisa = Servis::count();
            // Mesecni prihodi - SQLite kompatibilno
            $mesecniPrihodi = Narudzbina::where('status', '!=', 'otkazana')
                ->where('datum_narudzbine', '>=', Carbon::now()->startOfMonth()->toDateString())
                ->where('datum_narudzbine', '<=', Carbon::now()->endOfMonth()->toDateString())
                ->sum('ukupna_cena');

            return view('dashboard', compact(
                'mesecLabels',
                'prihodiData',
                'statusLabels',
                'statusData',
                'statusColors',
                'ukupniPrihodi',
                'ukupnoNarudzbina',
                'ukupnoKupaca',
                'ukupnoProizvoda',
                'ukupnoServisa',
                'mesecniPrihodi'
            ));
        }

        return view('dashboard');
    }
}
