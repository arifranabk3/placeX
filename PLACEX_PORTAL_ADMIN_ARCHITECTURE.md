# PlaceX Portal Admin Architecture & Design Blueprint

## 1. Executive Summary & Dual-Administration Model
PlaceX features two strictly isolated administration experiences:

1. **Super Admin Panel (`/admin`)**:
   - System-level operations, database migrations, platform roles matrix, financial payments, root audit logs.
   - Preserved completely intact in Laravel.

2. **New Portal Admin Panel (`/portal-admin`)**:
   - Frontend-matched content management suite (CMS).
   - Visually mirrors the public PlaceX Next.js website (`http://localhost:3000`).
   - Directly manages live marketplace inventory appearing across Pakistan: **Jobs**, **Property**, **Classifieds**, **Vehicles**, and **Matrimonial**.
   - Handles homepage banners, media assets, category tags, SEO metadata, and user inquiries.

---

## 2. Visual & Architectural Alignment with Next.js Frontend
- **Design Tokens**:
  - Primary Navy: `#061b2d` / `#031727`
  - Accent Orange: `#ff5a0a`
  - Background Neutral: `#f4f7fb`
  - Typography: `Roboto, Arial, sans-serif`
  - Layout: Top navigation with logo, quick vertical shortcuts, rounded cards, clean tables, and responsive forms.

---

## 3. Directory & Route Organization
```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/PortalAdmin/
│   │   │   ├── Auth/PortalAuthController.php
│   │   │   ├── PortalDashboardController.php
│   │   │   ├── PortalListingController.php
│   │   │   ├── PortalVerticalController.php
│   │   │   ├── PortalHomepageController.php
│   │   │   ├── PortalMediaController.php
│   │   │   ├── PortalCategoryController.php
│   │   │   ├── PortalSeoController.php
│   │   │   └── PortalEnquiryController.php
│   │   └── Middleware/
│   │       └── EnsurePortalAdminAccess.php
│   └── Services/PortalAdmin/
│       └── PortalListingService.php
├── resources/views/portal-admin/
│   ├── layouts/app.blade.php
│   ├── auth/login.blade.php
│   ├── dashboard/index.blade.php
│   ├── listings/index.blade.php, create.blade.php, edit.blade.php
│   ├── jobs/index.blade.php, create.blade.php
│   ├── property/index.blade.php, create.blade.php
│   ├── classifieds/index.blade.php, create.blade.php
│   ├── vehicles/index.blade.php, create.blade.php
│   ├── matrimonial/index.blade.php, create.blade.php
│   ├── homepage/index.blade.php
│   ├── media/index.blade.php
│   ├── categories/index.blade.php
│   ├── seo/index.blade.php
│   └── enquiries/index.blade.php, show.blade.php
└── routes/portal-admin.php
```
