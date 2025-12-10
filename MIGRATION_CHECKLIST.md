# Complete Code Changes: kode_buku → id_buku

## ✅ COMPLETED:

### Models (3 files):
- [x] Buku.php - PK changed to `id_buku` (INT)
- [x] AsetBuku.php - FK `kode_buku` → `id_buku`
- [x] UlasanBuku.php - FK `kode_buku` → `id_buku`

---

## ⏳ REMAINING: Route Parameters & Controller Methods

### Routes to Update (6 routes in web.php):

```php
// BEFORE:
Route::get('/catalog/{kode_buku}', ...)
Route::post('/catalog/{kode_buku}/borrow', ...)
Route::get('/reviews/{kode_buku}/create', ...)
Route::get('/manajemen_buku/{kode_buku}', ...)
Route::put('/manajemen_buku/{kode_buku}', ...)
Route::delete('/manajemen_buku/{kode_buku}', ...)

// AFTER:
Route::get('/catalog/{id_buku}', ...)
Route::post('/catalog/{id_buku}/borrow', ...)
Route::get('/reviews/{id_buku}/create', ...)
Route::get('/manajemen_buku/{id_buku}', ...)
Route::put('/manajemen_buku/{id_buku}', ...)
Route::delete('/manajemen_buku/{id_buku}', ...)
```

### Controllers to Update (4 files, 26 occurrences):

**1. ReviewController.php** (5 changes):
- Line 11: `public function create($id_buku)`
- Line 13: `$book = Buku::findOrFail($id_buku);`
- Line 25: `'id_buku' => 'required|exists:buku,id_buku',`
- Line 36: `'id_buku' => $validated['id_buku'],`
- Line 42: `route('pengunjung.catalog.show', $validated['id_buku'])`

**2. CatalogController.php** (6 changes):
- Line 31: `public function show($id_buku)`
- Line 33: `$book = Buku::findOrFail($id_buku);`
- Line 37: `->where('id_buku', $id_buku)`
- Line 48: `public function borrow(Request $request, $id_buku)`
- Line 50: `$book = Buku::findOrFail($id_buku);`
- Line 60: `'id_buku' => $id_buku,`

**3. Admin/BookController.php** (8 changes):
- Line 29: `'id_buku' => 'required|unique:buku,id_buku',` (for validation)
- Line 52: `public function update(Request $request, $id_buku)`
- Line 54: `$buku = Buku::findOrFail($id_buku);`
- Line 80: `public function destroy($id_buku)`
- Line 82: `$buku = Buku::findOrFail($id_buku);`
- Line 89: `public function storeItem(Request $request, $id_buku)`
- Line 98: `$validated['id_buku'] = $id_buku;`
- Line 101: `$buku = Buku::find($id_buku);`

**4. Admin/BukuController.php** (7 changes):
- Line 33: `'id_buku' => 'required|unique:buku,id_buku',`
- Line 63: `public function show($id_buku)`
- Line 65: `$buku = Buku::findOrFail($id_buku);`
- Line 69: `public function update(Request $request, $id_buku)`
- Line 71: `$buku = Buku::findOrFail($id_buku);`
- Line 104: `public function destroy($id_buku)`
- Line 106: `$buku = Buku::findOrFail($id_buku);`

---

## 🔍 Search & Replace Pattern:

**Find:** `kode_buku`  
**Replace with:** `id_buku`

**Files:**
- routes/web.php
- app/Http/Controllers/Pengunjung/ReviewController.php
- app/Http/Controllers/Pengunjung/CatalogController.php
- app/Http/Controllers/Admin/BookController.php
- app/Http/Controllers/Admin/BukuController.php

**NOTE:** Use IDE's Find & Replace in Files feature!

---

## ⚠️ IMPORTANT:

### Validation Rules to Check:
```php
// Change this:
'kode_buku' => 'required|exists:buku,kode_buku'
'kode_buku' => 'required|unique:buku,kode_buku'

// To this:
'id_buku' => 'required|exists:buku,id_buku'
'id_buku' => 'required|unique:buku,id_buku'
```

### BUT Keep `kode_buku` in fillable if keeping the column:
```php
protected $fillable = ['id_buku', 'kode_buku', 'judul', ...];
// Both kept for backward compatibility
```
