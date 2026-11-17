# PlaceX Admin Panel Architecture & Implementation Plan

## 1. Executive Architecture Summary
PlaceX is a high-volume, multi-category marketplace operating across Pakistan with five distinct vertical ecosystems:
1. **Jobs**: Employer job listings, company profiles, salary specifications, candidate applicants.
2. **Property**: Real estate listings (Sales & Rentals), land units, rooms, amenities.
3. **Classifieds**: Consumer electronics, household items, used goods, vehicles, general marketplace.
4. **Vehicles**: Automotive marketplace featuring make, model, year, transmission, fuel, mileage.
5. **Matrimonial**: Privacy-sensitive marital matchmaking profiles with restricted data access.

### Hybrid Topology
- **Public Website**: Next.js 16 + React 19 + TypeScript + Tailwind CSS.
- **Administrative Core**: Laravel 11.57.1 + Blade Engine + Tailwind CSS + Alpine.js.
- **Database**: Single unified MySQL instance (`place-x`) with 45 relational tables and Eloquent ORM.

---

## 2. Security Architecture & Role-Based Access Control (RBAC)

### 6 Standard Roles
1. `super-admin`: Wildcard full-platform authority, roles & permissions management, irreversible actions.
2. `admin`: Platform-wide operational access, user/listing management, system settings.
3. `moderator`: Review queues, suspicious listing flagging, approval/rejection, user reports handling.
4. `support-agent`: Read-only user directory inspection, dispute notes, customer support tickets.
5. `seller`: Commercial vendor profile, store management, inventory publication.
6. `user`: Standard customer account, ad posting, favorites, direct messaging.

### Granular Security Matrix (24 Permissions)
- `users.view`, `users.edit`, `users.delete`
- `sellers.view`, `sellers.manage`
- `listings.view`, `listings.edit`, `listings.delete`
- `categories.manage`
- `moderation.queue`
- `reports.manage`
- `promotions.manage`
- `payments.view`
- `roles.manage`
- `audit.view`
- `settings.manage`
- `matrimonial.manage` (Restricted privacy gate)

---

## 3. Directory Layout & Key Modules
```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/Admin/
│   │   │   ├── Auth/AdminAuthController.php
│   │   │   ├── AuditLogController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ListingController.php
│   │   │   ├── ModerationController.php
│   │   │   ├── NotificationController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── PromotionController.php
│   │   │   ├── ReportController.php
│   │   │   ├── RoleController.php
│   │   │   ├── SellerController.php
│   │   │   ├── SettingController.php
│   │   │   └── UserController.php
│   │   ├── Middleware/
│   │   │   ├── EnsureAdminAccess.php
│   │   │   └── RequirePermission.php
│   │   └── Requests/Admin/
│   │       └── UpdateUserRequest.php
│   └── Models/
│       ├── AuditLog.php, ModerationCase.php, ListingReport.php, Payment.php
│       ├── PromotionPlan.php, ListingPromotion.php, PromotionEntitlement.php
│       ├── SystemSetting.php, User.php, Listing.php, Category.php
├── resources/views/admin/
│   ├── layouts/app.blade.php, auth.blade.php
│   ├── dashboard/index.blade.php
│   ├── users/index.blade.php, show.blade.php, edit.blade.php
│   ├── sellers/index.blade.php, show.blade.php
│   ├── listings/index.blade.php, show.blade.php, edit.blade.php
│   ├── categories/index.blade.php
│   ├── moderation/index.blade.php
│   ├── reports/index.blade.php, show.blade.php
│   ├── promotions/index.blade.php
│   ├── payments/index.blade.php
│   ├── roles/index.blade.php
│   ├── notifications/index.blade.php
│   ├── audit-logs/index.blade.php
│   └── settings/index.blade.php
└── routes/web.php
```
