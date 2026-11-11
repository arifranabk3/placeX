# PlaceX SECURITY BASELINE

## 1. Authentication & Session Management
- **Sanctum API Tokens**: Plaintext tokens are returned only upon initial registration or login and stored as cryptographically hashed SHA-256 strings in `personal_access_tokens`.
- **Password Security**: Bcrypt with a minimum cost round factor of 12.
- **Throttling**: Sensitive authentication endpoints (`/auth/login`, `/auth/register`) are throttled at 10 requests per minute per IP to combat brute-force and credential stuffing.

## 2. Authorization & IDOR Defenses
- **Laravel Policies**: All modifications and administrative actions are governed by strict policies:
  - `ListingPolicy`: Guarantees only the listing owner or an administrator can update, archive, or delete listings.
  - `ConversationPolicy`: Only registered conversation participants can access conversation logs or post messages.
- **Authoritative Server**: The frontend never determines access rights; every request is authorized against the active database state.

## 3. Data Protection & Privacy Controls
- **Matrimonial Safeguards**: Personal details such as `family_details` and `monthly_income` are segregated and strictly excluded from public JSON resource serialization.
- **Precise Location Masking**: Public endpoints return only normalized geographic names (`Islamabad`, `Rawalpindi`) and general vicinity indicators. Precise addresses and coordinate decimals are withheld.

## 4. Input Sanitization & Mass Assignment
- **Strict Eloquent Fillables**: All models define `$fillable` arrays explicitly to avoid mass assignment attacks.
- **Form Requests**: Strict type validation, regex checks, and uniqueness constraints on all incoming payloads.

