# PlaceX TARGET ARCHITECTURE

## 1. Multi-Tier Architecture Diagram
```mermaid
graph TD
    User([End User / Mobile / Desktop]) -->|HTTPS: 3000| NextJS[Next.js 16 App Router Client]
    NextJS -->|JSON / Bearer Token| LaravelAPI[Laravel 11 REST API /api/v1/]
    NextJS -->|WSS: 8080| Reverb[Laravel Reverb WebSocket Server]
    
    subgraph Backend Core
        LaravelAPI --> Sanctum[Sanctum Auth Guard]
        LaravelAPI --> Policies[Role & Ownership Policies]
        LaravelAPI --> FormRequests[Strict Form Requests]
        LaravelAPI --> MySQL[(MySQL 9.1 InnoDB Engine)]
        LaravelAPI --> Storage[Local / Cloud File Storage]
        LaravelAPI --> Queue[Database Queue Worker]
    end

    subgraph Real-Time & Event Engine
        LaravelAPI -.->|Broadcast Event| Reverb
        Reverb -.->|Private Channel Authorization| MySQL
    end
```

## 2. Decoupled Category Extension Model
The platform separates core listing fields (searchable, indexable, price, location) from 1-to-1 polymorphic extension records:
- `job_details`: Compensation periods, workplace type, experience level.
- `property_details`: Square footage/marla, bedrooms, amenities JSON.
- `classified_details`: Subcategory, condition, brand, model.
- `vehicle_details`: Make, model, year, transmission, fuel type, mileage.
- `matrimonial_profiles`: Age, education, caste, privacy control, preferences.

