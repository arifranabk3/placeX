# PlaceX API CONTRACTS (v1)

## Base URL
`/api/v1`

## Standard Envelope
All endpoints return standard envelope structures:

### Success Envelope
```json
{
  "success": true,
  "message": "Human readable summary",
  "data": {},
  "pagination": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 20,
    "total": 5
  }
}
```

### Error Envelope
```json
{
  "success": false,
  "message": "Human readable error reason",
  "errors": {
    "field_name": [
      "Validation failure description."
    ]
  }
}
```

---

## Endpoint Catalog

### 1. Health
`GET /api/v1/health`
- **Response**:
```json
{
  "success": true,
  "message": "PlaceX API v1 is operational",
  "data": {
    "status": "healthy",
    "app": "PlaceX",
    "environment": "local",
    "database": "connected",
    "realtime": {
      "broadcaster": "reverb",
      "reverb_host": "127.0.0.1",
      "reverb_port": 8080
    },
    "timestamp": "2026-11-10T07:18:00.000000Z"
  }
}
```

### 2. Categories
`GET /api/v1/categories`
- **Response**: Array of active top-level categories (`Jobs`, `Property`, `Classifieds`, `Vehicles`, `Matrimonial`) with icons and counts.

### 3. Listings Discovery
`GET /api/v1/listings`
- **Query Parameters**:
  - `category`: Category slug (e.g., `vehicles`, `jobs`, `property`)
  - `city`: City name (e.g., `Islamabad`, `Lahore`)
  - `q`: Search keyword across title and description
  - `min_price`, `max_price`: Numerical bounds
  - `lat`, `lng`, `radius_km`: Geographic coordinate radius filter (Haversine server-side)
  - `page`, `per_page`: Pagination controls

`GET /api/v1/listings/{slug}`
- **Response**: Full listing object including category-specific attributes, location, seller profile, and images.

### 4. Authentication
`POST /api/v1/auth/register`
- **Body**: `{ "name": "...", "email": "...", "phone": "...", "password": "...", "password_confirmation": "..." }`
- **Rate Limit**: 10 requests per minute.

`POST /api/v1/auth/login`
- **Body**: `{ "email": "...", "password": "...", "device_name": "..." }`
- **Rate Limit**: 10 requests per minute.

`POST /api/v1/auth/logout`
- **Headers**: `Authorization: Bearer <token>`

`GET /api/v1/auth/me`
- **Headers**: `Authorization: Bearer <token>`
- **Response**: Authenticated user record with roles and profile details.

### 5. Account Management
`GET /api/v1/account/profile`
- **Headers**: `Authorization: Bearer <token>`

`PATCH /api/v1/account/profile`
- **Headers**: `Authorization: Bearer <token>`
- **Body**: `{ "name": "...", "phone": "...", "bio": "...", "city": "...", "country": "..." }`

