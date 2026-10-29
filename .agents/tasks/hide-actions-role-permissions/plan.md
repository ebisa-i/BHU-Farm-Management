# Implementation Plan — Hide action buttons from restricted roles (index/list views)

## What this task does
Wrap create / edit / delete / export / manage_users action buttons in the index/list Blade views with the custom `@canDo('...') ... @endCanDo` directives defined in `app/Providers/PermissionServiceProvider.php`, so restricted roles (Student/Researcher, etc.) no longer see them. View/show icons and pure navigation stay visible to everyone.

## Environment & commands (from composer.json + AGENTS.md)
- Stack: Laravel 13 / PHP 8.4 / Blade + Vite. No PHP, migrations, or assets change here, so Pint / npm / composer are NOT needed.
- Clear compiled views: `php artisan view:clear`
- Compile-check every Blade view (aborts on any unbalanced `@canDo`/`@endCanDo`): `php artisan view:cache`
- Tests: `php artisan test --compact <file paths>` (alias of `vendor/bin/phpunit`).
- Run all commands from `c:\wamp64\www\DairyBeefFarm`.

## How `@canDo` works (read before editing)
- `@canDo('create') ... @endCanDo` renders its contents only if the logged-in user's role has that permission. `auth()->user()->role` is read, defaulting to `'Team Leader'` when null.
- Matrix: System Administrator = all; Team Leader = all except `manage_users`; Vocational Worker = view/create/edit (no export/manage_users); Student/Researcher = view only; University Management = view/approve/export (no create/edit/manage_users).
- Test users come from `User::factory()->create()` which sets NO `role`, so `@canDo` treats them as **Team Leader** (create/edit/export true, manage_users false). This is why the existing tests keep passing — see "Test impact" below.

## Rules for every edit (do not skip these)
1. Read each file fully before editing; match exact current content with `str_replace` using enough surrounding context to be unique.
2. Wrap ONLY elements whose `href`/`action` is a `*.create`, `*.edit`, or `*.destroy` route, or `reports.export`. Keep every `*.show` (View) icon, every `*.index` navigation link, all search/filter forms, and the generic Print buttons visible to all roles.
3. Do NOT double-wrap — if an element is already inside `@canDo(...)` from a prior partial edit, skip it.
4. Where a row has both an edit icon and a delete form, wrap both in ONE `@canDo('edit') ... @endCanDo` block (the pattern already used in `animal-health/index.blade.php`), placing the View icon outside that block.

## Decisions made (gaps in the request, resolved here)
- **"Clear search" link (animals/index empty state):** Do NOT wrap. It points to `route('animals.index')` (resets a search filter), not a create route. Hiding it would stop restricted roles from clearing their own search, which is not the user's intent. Rule of thumb: only wrap links whose href is a `*.create` route. (Confirmed no empty-state "Register" create link exists in animals/index.)
- **"Export PDF" button (reports/index):** It calls `window.print()` (browser print), but the task labels it an export. Wrap it with `@canDo('export')`. The separate generic "Print" footer button and the header "Print preview" button stay visible to all.
- **"Adjust stock" link (inventory/index):** It points to `route('inventory.movements.create', $item)` — a create route — so wrap it with `@canDo('create')` (matches task item 6, "movements create link").
- **Test impact:** Factory test users default to Team Leader, so create/edit/export elements stay visible in tests; `ReportControllerTest` asserts `assertSee('Export Excel (CSV)')` and still passes (Team Leader export=true). No test asserts on user-management action buttons (which would be hidden), and there is no StaffActivities or UserManagement feature test. The suite stays green.

## Test impact summary per changed view
| View | Existing feature test | Asserts on a wrapped element? |
|---|---|---|
| breedings | `BreedingManagementTest` | No (only view/record text) |
| milk-productions | `MilkProductionManagementTest` | No |
| sales | `SaleManagementTest` | No |
| inventory | `InventoryManagementTest` | No |
| reports | `ReportControllerTest` | Yes — `assertSee('Export Excel (CSV)')`; still visible for Team Leader |
| staff-activities | none | n/a (verify via `view:cache`) |
| user-management | none | n/a (verify via `view:cache`) |

---

## Files already fully protected — NO edits needed (verify only)

- [ ] 0. Confirm the four files below need no changes (read each; do not edit):
      - `resources/views/animals/index.blade.php` — 'Register Animal' button and the row edit icon are already wrapped with `@canDo`. No `animals.destroy` form exists. 'Clear search' empty-state link is intentionally left visible (see Decisions).
      - `resources/views/animal-health/index.blade.php` — 'Record Health Check' button, empty-state 'Record First Health Check' link, and the edit icon + delete form (one `@canDo('edit')` block) are all already wrapped.
      - `resources/views/inventory-movements/index.blade.php` — contains no create/edit/delete/export actions (only 'Back to Inventory' nav and item view links). Nothing to wrap.
      - `resources/views/dashboard.blade.php` — every link targets an `*.index` route (sidebar nav, 'Manage Animals' hero, metric cards, module cards); there are NO `*.create` links. Nothing to wrap.
      Verify: `php artisan view:cache` succeeds with these files untouched.

---

## Edits — one item per file (independent; do in any order)

- [ ] 1. `resources/views/breedings/index.blade.php` — wrap 3 elements with `@canDo`.
      a) Empty-state link in the `@empty` cell (colspan=8): the `<a href="{{ route('breedings.create') }}" ...>Record breeding</a>` (lowercase "breeding", inside `@empty`) → wrap with `@canDo('create') ... @endCanDo`. (The header 'Record Breeding' button is already wrapped — leave it.)
      b) Row edit icon: `<a href="{{ route('breedings.edit', $breeding) }}" aria-label="Edit breeding record {{ $breeding->id }}" ...>` → wrap.
      c) Row delete form: `<form method="POST" action="{{ route('breedings.destroy', $breeding) }}" ...>` → put inside the SAME `@canDo('edit') ... @endCanDo` block as (b). Place `@canDo('edit')` after the View icon `<a href="{{ route('breedings.show', $breeding) }}" ...>` and `@endCanDo` after the delete `</form>`.
      Files: `resources/views/breedings/index.blade.php`
      Verify: `php artisan test --compact tests/Feature/BreedingManagementTest.php` — passes; `php artisan view:cache` succeeds.

- [ ] 2. `resources/views/milk-productions/index.blade.php` — wrap 3 elements with `@canDo`.
      a) Header button: `<a href="{{ route('milk-productions.create') }}" ...>Record Milk</a>` (page-heading section) → wrap with `@canDo('create') ... @endCanDo`.
      b) Row edit + delete (both inside `@if ($production->animal)`): wrap the edit `<a href="{{ route('milk-productions.edit', $production->representative_id) }}" ...>` AND the delete `<form ... action="{{ route('milk-productions.destroy', $production->representative_id) }}" ...>` together with `@canDo('edit') ... @endCanDo`. Keep the View icon `<a href="{{ route('milk-productions.show', $production->representative_id) }}" ...>` OUTSIDE the `@canDo('edit')` block (leave it before `@canDo('edit')`, still inside `@if`).
      c) Empty-state link: `<a href="{{ route('milk-productions.create') }}" ...>Record milk production</a>` (in `@empty`) → wrap with `@canDo('create') ... @endCanDo`.
      Files: `resources/views/milk-productions/index.blade.php`
      Verify: `php artisan test --compact tests/Feature/MilkProductionManagementTest.php` — passes; `php artisan view:cache` succeeds.

- [ ] 3. `resources/views/sales/index.blade.php` — wrap 3 elements with `@canDo`.
      a) Header button: `<a href="{{ route('sales.create') }}" ...>Add Sale</a>` → wrap with `@canDo('create') ... @endCanDo`.
      b) Row edit + delete: wrap the edit `<a href="{{ route('sales.edit', $sale) }}" ...>` and the delete `<form ... action="{{ route('sales.destroy', $sale) }}" ...>` together with `@canDo('edit') ... @endCanDo`. Keep the View icon `<a href="{{ route('sales.show', $sale) }}" ...>` outside the `@canDo('edit')` block.
      c) Empty-state link: `<a href="{{ route('sales.create') }}" ...>Add a sale</a>` (in `@empty`) → wrap with `@canDo('create') ... @endCanDo`.
      Files: `resources/views/sales/index.blade.php`
      Verify: `php artisan test --compact tests/Feature/SaleManagementTest.php` — passes; `php artisan view:cache` succeeds.

- [ ] 4. `resources/views/inventory/index.blade.php` — wrap 4 elements with `@canDo`.
      a) Header button: `<a href="{{ route('inventory.create') }}" ...>Add Item</a>` → wrap with `@canDo('create') ... @endCanDo`.
      b) Empty-state link: `<a href="{{ route('inventory.create') }}" ...>Add First Item</a>` (inside `@if ($search === '' && $stock === 'all')`) → wrap with `@canDo('create') ... @endCanDo`.
      c) Row edit icon: `<a href="{{ route('inventory.edit', $item) }}" aria-label="Edit {{ $item->name }}" title="Edit item" ...>` → wrap with `@canDo('edit') ... @endCanDo` (this one link only).
      d) 'Adjust stock' link: `<a href="{{ route('inventory.movements.create', $item) }}" aria-label="Adjust stock for {{ $item->name }}" title="Adjust stock" ...>` → wrap with `@canDo('create') ... @endCanDo`.
      Keep the View icon `<a href="{{ route('inventory.show', $item) }}" ...>` and the 'Movement history' link `<a href="{{ route('inventory-movements.index') }}" ...>` outside any `@canDo` block (always visible).
      Files: `resources/views/inventory/index.blade.php`
      Verify: `php artisan test --compact tests/Feature/InventoryManagementTest.php` — passes; `php artisan view:cache` succeeds.

- [ ] 5. `resources/views/staff-activities/index.blade.php` — wrap 3 elements with `@canDo`.
      a) Header button: `<a href="{{ route('staff-activities.create') }}" ...>Add Activity</a>` → wrap with `@canDo('create') ... @endCanDo`.
      b) Row edit + delete: wrap the edit `<a href="{{ route('staff-activities.edit', $activity) }}" title="Edit" ...>` and the delete `<form method="POST" action="{{ route('staff-activities.destroy', $activity) }}" ...>` together with `@canDo('edit') ... @endCanDo`. (There is no View icon in this row — only edit + delete.)
      c) Empty-state link: `<a href="{{ route('staff-activities.create') }}" ...>Add the first one.</a>` (inside `@empty` colspan=8) → wrap with `@canDo('create') ... @endCanDo`.
      Files: `resources/views/staff-activities/index.blade.php`
      Verify: `php artisan view:cache` succeeds (no StaffActivities feature test exists). Optional: log in as Student/Researcher vs System Administrator to confirm the button row hides/shows.

- [ ] 6. `resources/views/user-management/index.blade.php` — wrap 2 elements with `@canDo('manage_users')`.
      a) Header button: `<a href="{{ route('user-management.create') }}" ...>Add User</a>` → wrap with `@canDo('manage_users') ... @endCanDo`.
      b) Row actions cell: wrap the entire content of `<div class="flex items-center gap-3"> ... </div>` — the edit `<a href="{{ route('user-management.edit', $user) }}" title="Edit" ...>` together with the delete conditional `@if ($user->id !== auth()->id()) <form ... action="{{ route('user-management.destroy', $user) }}" ...> ... @else <span title="Cannot delete own account" ...> ... </span> @endif` — in ONE `@canDo('manage_users') ... @endCanDo` block. Place `@canDo('manage_users')` right after `<div class="flex items-center gap-3">` and `@endCanDo` right before its closing `</div>`. This hides both edit and delete for non-managers; managers still see edit + (delete, or the disabled-self span).
      Note: per the matrix only System Administrator has `manage_users=true`, so Team Leader and below will no longer see Add User / edit / delete here — that is the intended behavior.
      Files: `resources/views/user-management/index.blade.php`
      Verify: `php artisan view:cache` succeeds (no UserManagement feature test exists). Optional: log in as System Administrator vs Student/Researcher to confirm.

- [ ] 7. `resources/views/reports/index.blade.php` — wrap 2 export elements with `@canDo('export')`.
      a) 'Export PDF' button: the footer `<button type="button" onclick="window.print()" ...>Export PDF</button>` → wrap with `@canDo('export') ... @endCanDo`.
      b) 'Export Excel (CSV)' link: the footer `<a href="{{ $exportUrl }}" ...>Export Excel (CSV)</a>` where `$exportUrl = route('reports.export', ['report' => $selectedReport, 'period' => $selectedPeriod])` → wrap with `@canDo('export') ... @endCanDo`.
      Keep the generic footer 'Print' button and the header 'Print preview' button OUTSIDE any `@canDo` block (always visible). They sit between/around the export elements, so wrap each export element individually.
      Files: `resources/views/reports/index.blade.php`
      Verify: `php artisan test --compact tests/Feature/ReportControllerTest.php` — passes (test user = Team Leader, export=true, so `assertSee('Export Excel (CSV)')` still holds); `php artisan view:cache` succeeds.

---

## Final verification (after ALL edits)

- [ ] 8. Clear and compile-check every Blade view.
      Run: `php artisan view:clear` (required by the task), then `php artisan view:cache`, then `php artisan view:clear` (to leave views uncached for dev).
      Expected: `view:cache` completes with no "Undefined directive" / Blade syntax error — proves every `@canDo`/`@endCanDo` pair is balanced.

- [ ] 9. Run the affected feature tests together.
      Run: `php artisan test --compact tests/Feature/AnimalManagementTest.php tests/Feature/AnimalHealthManagementTest.php tests/Feature/BreedingManagementTest.php tests/Feature/MilkProductionManagementTest.php tests/Feature/SaleManagementTest.php tests/Feature/InventoryManagementTest.php tests/Feature/ReportControllerTest.php tests/Feature/DashboardTest.php`
      Expected: all tests pass (no regressions). Staff-activities and user-management have no feature tests; their correctness relies on the `view:cache` compile check in step 8 plus optional manual role-login.

- [ ] 10. Optional quick sanity check (supplementary, not primary verification).
      Confirm each create/edit/destroy/export/manage_users element listed above now sits inside `@canDo(...) ... @endCanDo`, and that no `*.show` View icon or `*.index` nav link got wrapped. This is a quick grep review only — steps 8 and 9 are the real verification.
