# Implementation Plan — DairyBeefFarm Full CRUD Completion

This plan completes all missing CRUD operations and wires up the two stub modules
(Staff Activities, User Management) so every section of the app uses real database
records. The work is grouped into three features executed sequentially.

---

## Context

- **Framework:** Laravel 11, PHP 8.4
- **CSS:** Tailwind CSS (dark-green theme: sidebar `#10352a`, background `#f4f7f3`, cards `rounded-2xl`)
- **Sidebar:** shared partial at `resources/views/layouts/farm-sidebar.blade.php` — pass `['active' => '<key>']`; breedings/index already uses it; user-management and staff-activities inline their own sidebars (must be migrated to the partial)
- **Build/verify:** `php artisan migrate`, `php artisan route:list`, load pages in browser
- **No test suite present** — verification is route listing + page load

---

## FEAT-001 — Complete CRUD for Breeding, Milk Productions, Sales, Animal Health

### 1. Expand routes in `routes/web.php`

Move the four partial resources inside the `auth`/`verified` group and use `Route::resource()` without `->only()` restriction (or expand to include all methods).

**Files:** `routes/web.php`

Change:
```php
Route::resource('breedings', BreedingController::class)
    ->only(['index', 'create', 'store']);
Route::resource('milk-productions', MilkProductionController::class)
    ->only(['index', 'create', 'store']);
Route::resource('sales', SaleController::class)
    ->only(['index', 'create', 'store']);
// inside auth group:
Route::resource('animal-health', AnimalHealthController::class)
    ->only(['index', 'create', 'store']);
```

To (all four as full resources inside the `['auth','verified']` middleware group):
```php
Route::resource('breedings', BreedingController::class);
Route::resource('milk-productions', MilkProductionController::class);
Route::resource('sales', SaleController::class);
Route::resource('animal-health', AnimalHealthController::class);
```

**Verify:** `php artisan route:list --path=breedings` — shows edit, update, destroy rows.

---

### 2. Add `edit`, `update`, `destroy` to `BreedingController`

`edit($id)` — loads record + female/male lists, returns `breedings.edit` view.  
`update(Request $request, $id)` — same validation as `store`, calls `$breeding->update()`, redirects to index with flash.  
`destroy($id)` — deletes record, redirects to index with flash.

**Files:** `app/Http/Controllers/BreedingController.php`

**Verify:** `php artisan route:list --path=breedings` — all 7 resourceful routes present.

---

### 3. Create `resources/views/breedings/edit.blade.php`

Mirror `breedings/create.blade.php` but:
- Form action: `route('breedings.update', $breeding)`, method POST + `@method('PUT')`
- Pre-fill all fields using `old('field', $breeding->field)` with `->format('Y-m-d')` for dates
- Use `@include('layouts.farm-sidebar', ['active' => 'breedings'])` sidebar
- Apply full theme: `bg-[#f4f7f3]`, `rounded-2xl` cards, `bg-[#123e31]` primary button, `rounded-xl` inputs with green focus ring
- Show `session('success')` / `session('error')` flash at top of page content

**Files:** `resources/views/breedings/edit.blade.php`

---

### 4. Update `resources/views/breedings/index.blade.php` — edit + delete action buttons

Replace the single "view animal" icon link in the Actions column with three icon buttons:
- **View** → `route('breedings.show', $breeding)` (link to a show view)
- **Edit** → `route('breedings.edit', $breeding)`
- **Delete** → `<form method="POST" action="{{ route('breedings.destroy', $breeding) }}">` with `@method('DELETE') @csrf`

**Files:** `resources/views/breedings/index.blade.php`

---

### 5. Create `resources/views/breedings/show.blade.php`

Read-only detail card showing all fields (female animal, male animal, mating date, breeding method, expected calving, actual calving, status, notes). Same sidebar + theme. Back button to index.

**Files:** `resources/views/breedings/show.blade.php`

---

### 6. Add `edit`, `update`, `destroy`, `show` to `MilkProductionController`

`show($id)` — returns `milk-productions.show`.  
`edit($id)` — loads record + active dairy animals, returns `milk-productions.edit`.  
`update` — same validation as `store`, updates record, redirects with flash.  
`destroy` — deletes, redirects with flash.

**Files:** `app/Http/Controllers/MilkProductionController.php`

**Verify:** `php artisan route:list --path=milk-productions` — all 7 routes present.

---

### 7. Create `resources/views/milk-productions/edit.blade.php` and `show.blade.php`

`edit`: mirror `milk-productions/create.blade.php`, pre-fill via `old()` + model values, PUT method override, sidebar + full theme.  
`show`: read-only card with animal, date, session, quantity, notes.

**Files:**  
- `resources/views/milk-productions/edit.blade.php`  
- `resources/views/milk-productions/show.blade.php`

---

### 8. Update `resources/views/milk-productions/index.blade.php` — edit + delete buttons

Add Edit and Delete icon buttons to each row's Actions column (same pattern as Animals index).

**Files:** `resources/views/milk-productions/index.blade.php` (read first to locate the actions cell)

---

### 9. Add `edit`, `update`, `destroy`, `show` to `SaleController`

`show` — returns `sales.show`.  
`edit` — loads record + all animals, returns `sales.edit`.  
`update` — same validation as `store` (recalculate `total_amount`; do NOT regenerate `sale_number`), update, redirect.  
`destroy` — delete, redirect.

**Files:** `app/Http/Controllers/SaleController.php`

**Verify:** `php artisan route:list --path=sales`.

---

### 10. Create `resources/views/sales/edit.blade.php` and `show.blade.php`

`edit`: mirror `sales/create.blade.php`, pre-fill all fields, PUT override, same JS for total preview and animal filtering, full theme.  
`show`: read-only detail of one sale (sale number, type, animal, buyer, item, qty, price, total, date, notes).

**Files:**  
- `resources/views/sales/edit.blade.php`  
- `resources/views/sales/show.blade.php`

---

### 11. Update `resources/views/sales/index.blade.php` — edit + delete buttons

Add Edit (`route('sales.edit', $sale)`) and Delete form buttons to each row.

**Files:** `resources/views/sales/index.blade.php`

---

### 12. Add `edit`, `update`, `destroy`, `show` to `AnimalHealthController`

Same pattern: `show`, `edit` (load record + animals), `update` (same validation), `destroy`.

**Files:** `app/Http/Controllers/AnimalHealthController.php`

**Verify:** `php artisan route:list --path=animal-health`.

---

### 13. Create `resources/views/animal-health/edit.blade.php` and `show.blade.php`

`edit`: mirror `animal-health/create.blade.php`, pre-fill all fields, PUT override, full theme + sidebar.  
`show`: read-only health record detail (animal, checkup date, status, disease, symptoms, treatment, medicine, next checkup, notes).

**Files:**  
- `resources/views/animal-health/edit.blade.php`  
- `resources/views/animal-health/show.blade.php`

---

### 14. Update `resources/views/animal-health/index.blade.php` — edit + delete buttons

Add Edit and Delete buttons to each row's Actions column.

**Files:** `resources/views/animal-health/index.blade.php`

**Verify (FEAT-001):** Visit `/breedings`, `/milk-productions`, `/sales`, `/animal-health` — each shows Edit and Delete buttons; clicking Edit opens a pre-filled form; submitting saves; Delete removes the record. Flash messages appear on redirect.

---

## FEAT-002 — Staff Activities: schema + full CRUD

### 15. Create migration to add columns to `staff_activities`

Create a new migration (do NOT modify the existing one; the table already exists in production):
```
php artisan make:migration add_fields_to_staff_activities_table
```

Add columns: `staff_name` (string), `role` (string), `assignment` (string), `shift` (string), `activity` (string), `status` (string, default `'Scheduled'`), `activity_date` (date), `notes` (nullable text).

**Files:** `database/migrations/<timestamp>_add_fields_to_staff_activities_table.php`

**Verify:** `php artisan migrate` — exits 0.

---

### 16. Update `StaffActivity` model

Replace empty class body with:
- `protected $fillable` listing all 8 new columns
- `protected function casts()` — `activity_date => 'date'`

**Files:** `app/Models/StaffActivity.php`

---

### 17. Build full CRUD in `StaffActivityController`

Replace the stub with full resource controller:
- `index` — paginate with `StaffActivity::latest()->paginate(15)`, compute stat cards from real DB (`total today`, `completed count`, `upcoming shift`)
- `create` — return `staff-activities.create` view
- `store` — validate all 8 fields, create, redirect with flash
- `edit($id)` — load record, return `staff-activities.edit`
- `update` — validate, update, redirect with flash
- `destroy` — delete, redirect with flash

**Files:** `app/Http/Controllers/StaffActivityController.php`

---

### 18. Register full resource route for staff-activities

Replace the bare `Route::get('/staff-activities', ...)` with:
```php
Route::resource('staff-activities', StaffActivityController::class);
```
inside the `auth` middleware group.

**Files:** `routes/web.php`

**Verify:** `php artisan route:list --path=staff-activities` — 7 routes present.

---

### 19. Create `resources/views/staff-activities/create.blade.php`

Form with all 8 fields. Use sidebar partial (`['active' => 'staff-activities']`). Roles dropdown: `['Veterinarian', 'Technician', 'Vocational Worker', 'Team Leader']`. Status dropdown: `['Scheduled', 'In Progress', 'Completed', 'Cancelled']`. Input style: `rounded-xl border border-[#d3e1d8]` with green focus ring. Primary button: `bg-[#123e31] rounded-xl`.

**Files:** `resources/views/staff-activities/create.blade.php`

---

### 20. Create `resources/views/staff-activities/edit.blade.php`

Mirror create, pre-fill all fields with `old()` + model values, PUT method override.

**Files:** `resources/views/staff-activities/edit.blade.php`

---

### 21. Update `resources/views/staff-activities/index.blade.php` — real DB data + action buttons

Replace hardcoded `$scheduleRows` PHP array with real `$activities` pagination. Update:
- Stat cards: use DB counts (`today's schedule` = `whereDate('activity_date', today())->count()`, `tasks completed` = `where('status','Completed')->count()`, `upcoming shift` = next scheduled record's shift/activity)
- Table rows: iterate `$activities` for the schedule table (use the same column names: `staff_name`, `role`, `assignment`, `shift`, `activity`, `status`)
- Add "Add Activity" button linking to `route('staff-activities.create')`
- Wire Edit icon to `route('staff-activities.edit', $activity)`
- Wire Delete as `<form method="POST">` with `@method('DELETE')` to `route('staff-activities.destroy', $activity)`
- Switch sidebar to `@include('layouts.farm-sidebar', ['active' => 'staff-activities'])` (remove the inline `<aside>`)

**Files:** `resources/views/staff-activities/index.blade.php`

**Verify (FEAT-002):** `php artisan migrate`, visit `/staff-activities/create`, fill the form, submit — record appears in index. Edit and delete work.

---

## FEAT-003 — User Management: schema + full CRUD

### 22. Create migration to add `role` and `status` to `users`

```
php artisan make:migration add_role_and_status_to_users_table
```
Add: `role` string default `'Team Leader'`, `status` string default `'Active'`.

**Files:** `database/migrations/<timestamp>_add_role_and_status_to_users_table.php`

**Verify:** `php artisan migrate` — exits 0.

---

### 23. Update `User` model — add role + status to fillable

The model uses the `#[Fillable]` PHP attribute. Replace the attribute with a traditional `$fillable` array (since PHP attributes don't support merging easily) or add `role` and `status` to the existing attribute:

```php
#[Fillable(['name', 'email', 'password', 'role', 'status'])]
```

**Files:** `app/Models/User.php`

---

### 24. Build full CRUD in `UserManagementController`

Replace stub with:
- `index` — `User::latest()->paginate(15)`, pass `$totalUsers`, `$activeUsers`, `$roles`
- `create` — return `user-management.create` with `$roles` array
- `store` — validate name (required, string, max:255), email (required, email, unique:users), password (required, min:8, confirmed), role (required, in: roles list), status (required, in: ['Active','Inactive']); hash password; create user; redirect with flash
- `edit($id)` — load user, return `user-management.edit`
- `update` — validate name, email (unique except current), role, status; optionally update password if provided; update; redirect with flash
- `destroy` — prevent self-delete (`$id !== auth()->id()`), delete, redirect with flash

Roles list: `['System Administrator', 'Team Leader', 'Vocational Worker', 'Student/Researcher', 'University Management']`

**Files:** `app/Http/Controllers/UserManagementController.php`

---

### 25. Register full resource route for user-management

Replace:
```php
Route::get('/user-management', [UserManagementController::class, 'index'])
    ->middleware('auth')
    ->name('user-management.index');
```
With:
```php
Route::resource('user-management', UserManagementController::class);
```
inside the `auth` middleware group.

**Files:** `routes/web.php`

**Verify:** `php artisan route:list --path=user-management` — 7 routes present.

---

### 26. Create `resources/views/user-management/create.blade.php`

Form: name, email, password, password_confirmation, role (select from roles list), status (select: Active/Inactive). Use sidebar partial (`['active' => 'user-management']`). Full theme. Primary button `bg-[#123e31] rounded-xl`. Show validation errors block.

**Files:** `resources/views/user-management/create.blade.php`

---

### 27. Create `resources/views/user-management/edit.blade.php`

Mirror create; pre-fill name, email, role, status. Password field optional (leave blank to keep existing). PUT method override. Note above password: "Leave blank to keep existing password."

**Files:** `resources/views/user-management/edit.blade.php`

---

### 28. Update `resources/views/user-management/index.blade.php` — real DB columns + action buttons

Replace derived/demo values with real DB columns:
- `role` column: `$user->role` (real DB column now exists)
- `status` badge: `$user->status` — green pill for `Active`, amber for `Inactive`
- "Add User" button: link to `route('user-management.create')` (not `profile.edit`)
- Wire Edit icon to `route('user-management.edit', $user)` as a link
- Wire Delete as `<form method="POST">` with `@method('DELETE')` to `route('user-management.destroy', $user)`
- Switch to sidebar partial: `@include('layouts.farm-sidebar', ['active' => 'user-management'])` (remove inline `<aside>`)

**Files:** `resources/views/user-management/index.blade.php`

**Verify (FEAT-003):** `php artisan migrate`, visit `/user-management/create`, fill form, submit — user appears in index with real role/status. Edit and delete work.

---

## Style rules (apply consistently across all new/edited views)

| Element | Class |
|---|---|
| Page wrapper | `<div class="min-h-screen bg-[#f4f7f3] text-[#20392f] lg:flex">` |
| Sidebar | `@include('layouts.farm-sidebar', ['active' => '<key>'])` |
| Card | `rounded-2xl border border-[#dfe8e1] bg-white shadow-sm` |
| Primary button | `bg-[#123e31] hover:bg-[#205644] text-white font-semibold rounded-xl px-5 py-3` |
| Secondary button | `border border-[#d3e1d8] bg-white text-[#173d31] rounded-xl px-5 py-3` |
| Input/select/textarea | `rounded-xl border border-[#d3e1d8] focus:border-green-600 focus:ring-green-600 w-full` |
| Status badge — Active/Completed | `bg-[#e3f5e8] text-[#2d7a46] rounded-full px-3 py-1 text-xs font-semibold` |
| Status badge — In Progress/Inactive | `bg-[#fef3e2] text-[#a16207] rounded-full px-3 py-1 text-xs font-semibold` |
| Flash success | `rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800` |
| Flash error | `rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800` |
| Delete form | `<form method="POST" action="…">@csrf @method('DELETE')<button type="submit">…</button></form>` |
