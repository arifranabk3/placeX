# PlaceX Portal Admin Public Next.js Frontend Integration Guide

## 1. Shared Database Architecture
The Next.js client (`frontend/`) and Laravel Portal Admin (`backend/`) share the same MySQL database instance (`place-x`).

### Data Synchronization Flow:
1. **Creation/Edit**:
   - Portal Admin staff submits or publishes content via `/portal-admin/listings` or vertical shortcuts.
   - Eloquent records the listing with `listing_status = 'active'` and `moderation_status = 'approved'`.
2. **Public API Retrieval**:
   - Next.js fetches listings via `GET /api/v1/listings`.
   - The query filters only active & approved items: `where('listing_status', 'active')->where('moderation_status', 'approved')`.
3. **Instant Visibility**:
   - The listing appears immediately on `http://localhost:3000` (Home, Jobs, Property, Classifieds, Vehicles, Matrimonial).
4. **Unpublish / Pause**:
   - Changing status to `inactive` or `paused` via Portal Admin instantly removes the item from public search results.
