# PlaceX CURRENT ARCHITECTURE (Phase 01)

## 1. System Structure
```
PlaceX-InnerProject/
├── backend/                  # Laravel 11.57 REST API
│   ├── app/
│   │   ├── Http/Controllers/Api/V1/ # Health, Auth, Category, Listing, Account
│   │   ├── Http/Requests/Api/V1/    # Form validation & authorization
│   │   ├── Http/Resources/Api/V1/   # API JSON serialization & privacy filters
│   │   ├── Models/                  # Eloquent models with InnoDB relational constraints
│   │   └── Policies/                # Authorization policies (Listing, Conversation)
│   ├── database/
│   │   ├── migrations/              # 7 modular migration batches (InnoDB, strict keys)
│   │   └── seeders/                 # DatabaseSeeder with 5 categories & sample listings
│   └── routes/
│       ├── api.php                  # /api/v1/ REST routes
│       └── channels.php             # Reverb private broadcast channels
│
├── frontend/                 # Next.js 16 App Router (TypeScript)
│   ├── src/
│   │   ├── app/                     # App router pages (Home preserved)
│   │   ├── lib/                     # API client abstraction
│   │   └── types/                   # Shared TypeScript definitions
│   └── public/
│       └── placex.css               # Approved brand styling & 1200px container
│
├── docs/                     # Engineering documentation
│   ├── api/
│   ├── architecture/
│   ├── database/
│   ├── security/
│   └── testing/
│
├── css/ & js/                # Legacy static prototypes preserved
└── *.html                    # Category reference pages preserved
```

## 2. Decoupled Communication
- **API Protocol**: REST over JSON at `/api/v1/`.
- **Authentication**: Laravel Sanctum Bearer tokens.
- **Real-Time Protocol**: Laravel Reverb self-hosted WebSockets on port 8080.

