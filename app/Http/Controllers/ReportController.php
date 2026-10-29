<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalHealth;
use App\Models\Breeding;
use App\Models\InventoryItem;
use App\Models\MilkProduction;
use App\Models\Sale;
use App\Models\StaffActivity;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    private const REPORTS = [
        'animal-population' => 'Animal Population',
        'milk-production' => 'Milk Production',
        'sales-revenue' => 'Sales & Revenue',
        'breeding' => 'Breeding',
        'animal-health' => 'Animal Health',
        'inventory' => 'Inventory',
        'staff-activities' => 'Staff Activities',
    ];

    private const PERIODS = [
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
        'yearly' => 'Yearly',
        'all' => 'All time',
    ];

    public function index(Request $request): View
    {
        [$report, $period] = $this->validatedOptions($request);
        [$startDate, $endDate] = $this->periodBounds($period);
        $reportData = $this->buildReport($report, $period, $startDate, $endDate);

        return view('reports.index', [
            'reports' => self::REPORTS,
            'periods' => self::PERIODS,
            'selectedReport' => $report,
            'selectedPeriod' => $period,
            'periodLabel' => in_array($report, ['animal-population', 'inventory'], true)
                ? 'Current snapshot'
                : self::PERIODS[$period],
            'reportTitle' => self::REPORTS[$report],
            ...$reportData,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        [$report, $period] = $this->validatedOptions($request);
        [$startDate, $endDate] = $this->periodBounds($period);
        $reportData = $this->buildReport($report, $period, $startDate, $endDate);

        return response()->streamDownload(
            static function () use ($reportData): void {
                $stream = fopen('php://output', 'w');

                if ($stream === false) {
                    throw new \RuntimeException('Unable to open the report export stream.');
                }

                fputcsv($stream, ['Metric', 'Value'], ',', '"', '');

                foreach ($reportData['metrics'] as $metric) {
                    fputcsv($stream, [self::safeCsvLabel($metric['label']), $metric['value']], ',', '"', '');
                }

                fputcsv($stream, [], ',', '"', '');
                fputcsv($stream, ['Breakdown', 'Value'], ',', '"', '');

                foreach ($reportData['chart'] as $row) {
                    fputcsv($stream, [self::safeCsvLabel($row['label']), $row['value']], ',', '"', '');
                }

                fclose($stream);
            },
            'farm-'.str_replace('-', '_', $report).'-report.csv',
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function validatedOptions(Request $request): array
    {
        $validated = $request->validate([
            'report' => ['sometimes', 'required', Rule::in(array_keys(self::REPORTS))],
            'period' => ['sometimes', 'required', Rule::in(array_keys(self::PERIODS))],
        ]);

        return [
            $validated['report'] ?? 'milk-production',
            $validated['period'] ?? 'monthly',
        ];
    }

    /**
     * @return array{0: ?string, 1: ?string}
     */
    private function periodBounds(string $period): array
    {
        $today = today();

        return match ($period) {
            'daily' => [$today->toDateString(), $today->toDateString()],
            'weekly' => [$today->copy()->startOfWeek()->toDateString(), $today->copy()->endOfWeek()->toDateString()],
            'monthly' => [$today->copy()->startOfMonth()->toDateString(), $today->copy()->endOfMonth()->toDateString()],
            'yearly' => [$today->copy()->startOfYear()->toDateString(), $today->copy()->endOfYear()->toDateString()],
            'all' => [null, null],
        };
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function buildReport(string $report, string $period, ?string $startDate, ?string $endDate): array
    {
        return match ($report) {
            'animal-population' => $this->animalPopulationReport(),
            'milk-production' => $this->milkProductionReport($period, $startDate, $endDate),
            'sales-revenue' => $this->salesRevenueReport($startDate, $endDate),
            'breeding' => $this->breedingReport($startDate, $endDate),
            'animal-health' => $this->animalHealthReport($startDate, $endDate),
            'inventory' => $this->inventoryReport(),
            'staff-activities' => $this->staffActivitiesReport($startDate, $endDate),
        };
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function animalPopulationReport(): array
    {
        $animals = Animal::query()->get(['animal_type', 'sex', 'status']);
        $animalsByType = $animals->groupBy('animal_type');

        return [
            'metrics' => [
                $this->metric('Total animals', number_format($animals->count()), 'Current farm population'),
                $this->metric('Dairy cows', number_format($animalsByType->get('Dairy', collect())->count()), 'Registered dairy animals'),
                $this->metric('Active animals', number_format($animals->where('status', 'Active')->count()), 'Currently active'),
            ],
            'chart' => collect(['Dairy', 'Beef', 'Calf'])
                ->map(fn (string $type): array => ['label' => $type, 'value' => $animalsByType->get($type, collect())->count()])
                ->all(),
        ];
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function milkProductionReport(string $period, ?string $startDate, ?string $endDate): array
    {
        $productions = $this->filterByPeriod(
            MilkProduction::query(),
            'production_date',
            $startDate,
            $endDate
        )->get(['production_date', 'session', 'quantity_liters']);

        $chartLabels = match ($period) {
            'daily' => ['Morning', 'Afternoon', 'Evening'],
            'weekly' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'yearly', 'all' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            default => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        };
        $productionByGroup = array_fill_keys($chartLabels, 0.0);

        foreach ($productions as $production) {
            $group = match ($period) {
                'daily' => $production->session,
                'weekly' => $production->production_date->format('D'),
                'yearly', 'all' => $production->production_date->format('M'),
                default => 'Week '.(min((int) floor(($production->production_date->day - 1) / 8), 3) + 1),
            };

            $productionByGroup[$group] += (float) $production->quantity_liters;
        }

        $monthStart = today()->copy()->startOfMonth()->toDateString();
        $monthEnd = today()->copy()->endOfMonth()->toDateString();
        $todayProduction = MilkProduction::query()
            ->whereDate('production_date', today())
            ->sum('quantity_liters');
        $monthlyRevenue = Sale::query()
            ->whereBetween('sale_date', [$monthStart, $monthEnd])
            ->sum('total_amount');
        $activeDairyCows = Animal::query()
            ->where('animal_type', 'Dairy')
            ->where('status', 'Active')
            ->count();

        return [
            'metrics' => [
                $this->metric('Dairy cows', number_format($activeDairyCows), 'Active'),
                $this->metric('Milk recorded today', number_format((float) $todayProduction, 2).' L', 'Farm-wide'),
                $this->metric('Monthly revenue', number_format((float) $monthlyRevenue, 2).' ETB', 'Recorded sales'),
            ],
            'chart' => collect($productionByGroup)
                ->map(fn (float $quantity, string $label): array => [
                    'label' => $label,
                    'value' => round($quantity, 2),
                ])
                ->all(),
        ];
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function salesRevenueReport(?string $startDate, ?string $endDate): array
    {
        $sales = $this->filterByPeriod(Sale::query(), 'sale_date', $startDate, $endDate)
            ->get(['sale_type', 'total_amount']);
        $revenueByType = $sales->groupBy('sale_type')
            ->map(fn ($typeSales): float => (float) $typeSales->sum('total_amount'));

        return [
            'metrics' => [
                $this->metric('Total sales', number_format($sales->count()), 'Recorded transactions'),
                $this->metric('Total revenue', number_format((float) $sales->sum('total_amount'), 2).' ETB', 'Selected date range'),
                $this->metric('Average sale', number_format((float) $sales->avg('total_amount'), 2).' ETB', 'Per transaction'),
            ],
            'chart' => collect(['Animal', 'Milk'])
                ->map(fn (string $type): array => ['label' => $type, 'value' => $revenueByType->get($type, 0)])
                ->all(),
        ];
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function breedingReport(?string $startDate, ?string $endDate): array
    {
        $breedings = $this->filterByPeriod(Breeding::query(), 'mating_date', $startDate, $endDate)
            ->get(['status']);
        $byStatus = $breedings->groupBy('status');

        return [
            'metrics' => [
                $this->metric('Breeding records', number_format($breedings->count()), 'In selected date range'),
                $this->metric('Pregnant', number_format($byStatus->get('Pregnant', collect())->count()), 'Confirmed pregnancies'),
                $this->metric('Calved', number_format($byStatus->get('Calved', collect())->count()), 'Recorded births'),
            ],
            'chart' => $byStatus->map(fn ($records, string $status): array => [
                'label' => $status,
                'value' => $records->count(),
            ])->values()->all(),
        ];
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function animalHealthReport(?string $startDate, ?string $endDate): array
    {
        $records = $this->filterByPeriod(AnimalHealth::query(), 'checkup_date', $startDate, $endDate)
            ->get(['health_status']);
        $byStatus = $records->groupBy('health_status');

        return [
            'metrics' => [
                $this->metric('Health checkups', number_format($records->count()), 'In selected date range'),
                $this->metric('Healthy', number_format($byStatus->get('Healthy', collect())->count()), 'Recorded as healthy'),
                $this->metric('Needs attention', number_format(
                    $records->whereIn('health_status', ['Sick', 'Under Treatment'])->count()
                ), 'Sick or under treatment'),
            ],
            'chart' => $byStatus->map(fn ($statusRecords, string $status): array => [
                'label' => $status,
                'value' => $statusRecords->count(),
            ])->values()->all(),
        ];
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function inventoryReport(): array
    {
        $items = InventoryItem::query()->get(['category', 'quantity', 'reorder_level', 'unit_cost']);
        $quantityByCategory = $items->groupBy('category')
            ->map(fn ($categoryItems): float => (float) $categoryItems->sum('quantity'));
        $lowStockItems = $items->filter(fn (InventoryItem $item): bool => $item->quantity <= $item->reorder_level);

        return [
            'metrics' => [
                $this->metric('Inventory items', number_format($items->count()), 'Current stock list'),
                $this->metric('Low stock items', number_format($lowStockItems->count()), 'At or below reorder level'),
                $this->metric('Stock value', number_format((float) $items->sum(
                    fn (InventoryItem $item): float => (float) $item->quantity * (float) $item->unit_cost
                ), 2).' ETB', 'Estimated at unit cost'),
            ],
            'chart' => $quantityByCategory->map(fn (float $quantity, string $category): array => [
                'label' => $category,
                'value' => $quantity,
            ])->values()->all(),
        ];
    }

    /**
     * @return array{metrics: array<int, array{label: string, value: string, detail: string}>, chart: array<int, array{label: string, value: int|float}>}
     */
    private function staffActivitiesReport(?string $startDate, ?string $endDate): array
    {
        $activities = $this->filterByPeriod(StaffActivity::query(), 'created_at', $startDate, $endDate)
            ->get(['created_at']);

        return [
            'metrics' => [
                $this->metric('Activity records', number_format($activities->count()), 'In selected date range'),
                $this->metric('Recorded today', number_format($activities->where('created_at', '>=', today())->count()), 'Farm-wide'),
                $this->metric('Logged activity days', number_format($activities->map(
                    fn (StaffActivity $activity): string => $activity->created_at->toDateString()
                )->unique()->count()), 'Days with records'),
            ],
            'chart' => [
                ['label' => 'Activity records', 'value' => $activities->count()],
            ],
        ];
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    private function filterByPeriod(
        Builder $query,
        string $column,
        ?string $startDate,
        ?string $endDate
    ): Builder {
        if ($startDate !== null && $endDate !== null) {
            $query->whereBetween($column, [$startDate, $endDate]);
        }

        return $query;
    }

    /**
     * @return array{label: string, value: string, detail: string}
     */
    private function metric(string $label, string $value, string $detail): array
    {
        return compact('label', 'value', 'detail');
    }

    private static function safeCsvLabel(string $label): string
    {
        return preg_match('/^[\t\r\n ]*[=+\-@]/', $label) === 1
            ? "'".$label
            : $label;
    }
}
