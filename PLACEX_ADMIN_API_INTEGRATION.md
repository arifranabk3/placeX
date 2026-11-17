# PlaceX Admin API & Data Synchronization Guide

## 1. Overview
The PlaceX platform leverages a shared MySQL database between the Next.js public client application and the Laravel administration backend.

## 2. Shared Data Model
- **Listings Table (`listings`)**:
  - `listing_status`: `active`, `inactive`, `expired`, `draft`
  - `moderation_status`: `pending`, `approved`, `rejected`
  - Rule: Public Next.js queries only surface listings where `listing_status = 'active'` AND `moderation_status = 'approved'`.
- **User Authentication**:
  - Customer registration via Next.js or Laravel API records users into `users`.
  - Admin panel enforces session-based authentication on `web` guard with password hashing via Bcrypt.

## 3. Endpoints & Webhooks
- Staff mutations in Laravel trigger `AuditLog::record(...)`, saving IP, actor ID, affected entity ID, and JSON delta payload.
- No third-party paid gateway API dependencies are introduced; internal ledger records are utilized for payment audits.
