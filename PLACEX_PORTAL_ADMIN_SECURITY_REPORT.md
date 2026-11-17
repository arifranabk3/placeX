# PlaceX Portal Admin Security Report

## 1. Security Architecture & Isolation
The Portal Admin Panel is isolated from the Super Admin Panel.

| Layer | Implementation | Verification |
|---|---|---|
| **Route Isolation** | Super Admin runs on `/admin`; Portal Admin runs on `/portal-admin` | Tested independent route namespaces |
| **Authentication** | Session-based authentication with separate login endpoints (`/portal-admin/login`) | Verified guest redirection |
| **Authorization** | `EnsurePortalAdminAccess` middleware checks `portal-manager`, `content-manager`, etc. | Verified regular customer is blocked with HTTP 403 |
| **Cross-Panel Boundary** | Portal Managers cannot access `/admin` unless granted explicit Super Admin roles | Tested privilege boundary |
| **Matrimonial Privacy** | Confidential attributes restricted to staff with `portal.matrimonial.manage` permission | Masked for unauthorized staff |
| **Rate Limiting** | 5 failed attempts per minute locks login endpoint | Throttled via `RateLimiter::hit` |
| **CSRF & Injection** | Blade `@csrf` tokens on all forms; Eloquent parameter binding prevents SQLi | Verified on all POST/PUT/PATCH/DELETE routes |
