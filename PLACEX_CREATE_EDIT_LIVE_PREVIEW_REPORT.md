# PlaceX — Live Preview for Both Create and Edit Listing Report

## 1. Executive Summary

This report documents the implementation of the **Mandatory Real-Time Listing Preview System** across both **Create New Listing** and **Edit Existing Listing** workflows inside the PlaceX Portal Admin Panel (`/portal-admin`).

Prior to this implementation, real-time live preview existed primarily on the Create form. The architecture has now been refactored into a unified, shared component system that guarantees complete parity: both Create and Edit pages share the same Alpine.js reactive state store, the same form field layouts, the same instant image management pipeline, and the exact same Card Preview and Full Detail Preview components matching the public Next.js website.

---

## 2. Shared Component Architecture

To eliminate code duplication and ensure identical behavior across forms, the implementation is decomposed into dedicated, reusable Blade partials:

```
backend/resources/views/portal-admin/listings/
├── create.blade.php                          # Split-screen Create View
├── edit.blade.php                            # Split-screen Edit View (with pre-populated initial data)
└── partials/
    ├── editor-script.blade.php               # Shared Alpine.js reactive component (portalListingEditor)
    ├── listing-form-fields.blade.php         # Reusable form sections (Category, Core Info, Specs, Gallery)
    ├── card-preview.blade.php                # PlaceX Next.js Card Component Replica
    └── detail-preview.blade.php              # PlaceX Next.js /listings/[slug] Detail Page Replica
```

### Shared Component Breakdown:
1. **`portalListingEditor` (`editor-script.blade.php`)**:
   - Central Alpine.js store handling form state, live category switching, responsive layout tabs (Mobile Editor vs Preview), multi-image arrays, cover image assignment, image reordering, and preview mode switching (`Card Mode` vs `Detail Mode`).
   - Accepts customizable `initial` data and `initialImages`. On Create, this initializes with empty defaults; on Edit, it receives the full Eloquent model and pre-existing media relations.
2. **`listing-form-fields.blade.php`**:
   - Common reactive input controls with live `x-model` bindings for Title, Price, Currency, Location, Description, and Featured status.
   - Dynamic vertical specifications matrix that switches visibility seamlessly across all 5 categories.
   - Instant image uploader supporting computer file uploads (`FileReader.readAsDataURL`) and direct image URL insertion.
3. **`card-preview.blade.php`**:
   - Matches the public PlaceX homepage and search result cards (`.listing-card`).
   - Reflects the active cover image, category badge, featured lightning pill, localized formatted price (`formattedPrice()`), dynamic specs chips, and location in real time without page reloads.
4. **`detail-preview.blade.php`**:
   - Matches the public Next.js detail view (`/listings/[slug]`).
   - Features dynamic photo carousel, thumbnail switcher strip, full specifications matrix, rich narrative description, and verified seller contact widget.

---

## 3. Create vs. Edit Behavior Parity

| Feature / Behavior | Create New Listing | Edit Existing Listing | Parity Status |
| :--- | :--- | :--- | :--- |
| **Initial State** | Starts with clean defaults & category 1 selected | Hydrates existing database values, relations, and saved images | **Verified** |
| **Live Title / Price Sync** | Instant update on keystroke | Instant update on keystroke | **Verified** |
| **Category-Specific Specs** | Dynamic fields switch immediately | Dynamic fields switch immediately while preserving saved attributes | **Verified** |
| **Image Management** | Direct DataURL previews | Displays existing server photos + allows adding new photos instantly | **Verified** |
| **Cover Photo Selection** | Set any image as primary cover | Promotes selected photo to cover; updates primary badge | **Verified** |
| **Safe Image Removal** | Discards unsaved temporary images | Marks existing image as removed in preview; **defers deletion on server until explicit Save** | **Verified** |
| **Discard / Cancel Safety** | Redirects back without saving | "Discard Edits" prompt leaves persisted server data completely unchanged | **Verified** |
| **Save Draft vs Publish** | Allows saving as draft or publishing directly | Supports updating draft or promoting directly to public live | **Verified** |
| **Preview Modes** | Supports toggling Card & Detail modes | Supports toggling Card & Detail modes | **Verified** |

---

## 4. Safe Media Handling Pipeline

A critical requirement is that removing an existing image in the edit form must **not** delete the file from the database or disk prematurely while the form is unsaved.

- In `edit.blade.php`, existing images are loaded with their database `id`.
- When an administrator clicks the trash button on an existing image, it is marked as `is_removed = true`, excluded from the active preview gallery, and its ID is pushed to `removedImageIds[]`.
- If the administrator cancels or leaves the page, the database is untouched.
- Only when the form is submitted (`PUT /portal-admin/listings/{listing}`) does the `PortalListingService` execute:
  ```php
  if (! empty($data['removed_image_ids'])) {
      ListingImage::where('listing_id', $listing->id)
          ->whereIn('id', $data['removed_image_ids'])
          ->delete();
  }
  ```
- Any newly added photos or direct URLs are safely created and linked without overwriting existing retained media.

---

## 5. Support for All Five Categories

Both Create and Edit live preview systems support all 5 PlaceX marketplace categories:

1. **Jobs**:
   - Form Fields: Company Name, Employment Type, Workplace Type, Experience Level, Min/Max Salary.
   - Live Preview: Dynamic salary range calculation, company badge, employment chips.
2. **Property**:
   - Form Fields: Purpose (Sale/Rent), Property Type, Area Size & Unit, Bedrooms, Bathrooms.
   - Live Preview: Purpose chips (`For Sale` / `For Rent`), area dimensions, room configuration tags.
3. **Vehicles**:
   - Form Fields: Make, Model, Year, Mileage, Transmission, Fuel Type.
   - Live Preview: Make/Model headline, registration year, formatted mileage (`45,000 km`), transmission chip.
4. **Classifieds**:
   - Form Fields: Condition (`New`, `Used`, `Refurbished`), Brand, Model.
   - Live Preview: Condition pill, brand/model attributes.
5. **Matrimonial**:
   - Form Fields: Gender (`Bride`/`Groom`), Age, Marital Status, Education, Profession, Religion.
   - Live Preview: Bride/Groom indicator, age badge, qualification tags, profession summary.

---

## 6. Automated Test Verification

A dedicated feature test suite has been authored at `backend/tests/Feature/PortalListingLivePreviewTest.php`.

### Test Execution Command:
```powershell
php artisan test tests/Feature/PortalListingLivePreviewTest.php
```

### Test Results:
```
PASS  Tests\Feature\PortalListingLivePreviewTest
✓ create page contains live preview and split screen architecture (0.38s)
✓ edit page loads existing listing data and images into preview (0.23s)
✓ edit updates fields without altering unrelated attributes (0.16s)
✓ safe image removal does not delete server media until saved (0.24s)
✓ all five categories persist vertical specs on create and edit (0.45s)

Tests:    5 passed (28 assertions)
Duration: 1.69s
```

### Full Core Test Suite Summary:
- **`PortalListingLivePreviewTest`**: 5 Passed (28 assertions)
- **`PortalAdminTest`**: 5 Passed (11 assertions)
- **`AdminAuthenticationTest`**: 3 Passed (5 assertions)
- **`ExampleTest`**: 1 Passed (1 assertion)
- **Total**: 14 Feature Tests Passing, 0 Failures.

---

## 7. Remaining Limitations & Recommendations

1. **Large Video Uploads**:
   - Currently, preview supports images (JPG, PNG, WebP) and external URLs. Video previews can be added in subsequent milestones by integrating an HTML5 video tag inside `detail-preview.blade.php`.
2. **Real-time Slug Collisions**:
   - Slug generation is safely deduplicated on the backend upon submission. If real-time slug preview is needed, an asynchronous debounced check endpoint can be connected.
