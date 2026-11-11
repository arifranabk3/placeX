# PlaceX INDEX & PERFORMANCE STRATEGY

## Indexing Principles
1. **Primary Compound Search Keys**:
   - Marketplace listing discovery heavily queries:
     - `category_id` + `listing_status` + `moderation_status` + `published_at`
     - Index: `listings_search_idx (category_id, listing_status, moderation_status, published_at)`
   - Location filtering queries:
     - `location_id` + `listing_status` + `moderation_status`
     - Index: `listings_location_idx (location_id, listing_status, moderation_status)`
2. **Spatial Coordinate Discovery**:
   - Bounding-box and Haversine distance computations:
     - Index: `listings_geo_idx (latitude, longitude)`
3. **Slugs & Uniqueness**:
   - `listings (slug)` UNIQUE
   - `categories (slug)` UNIQUE
   - `users (email)` UNIQUE
   - `users (phone)` UNIQUE
4. **Relational Integrity & Join Acceleration**:
   - Foreign keys explicitly indexed:
     - `user_profiles (user_id)` UNIQUE
     - `seller_profiles (user_id)` UNIQUE
     - `listing_images (listing_id, sort_order)`
     - `job_details (listing_id)` UNIQUE
     - `property_details (listing_id)` UNIQUE
     - `vehicle_details (listing_id)` UNIQUE
     - `classified_details (listing_id)` UNIQUE
     - `matrimonial_profiles (listing_id)` UNIQUE
     - `matrimonial_preferences (matrimonial_profile_id)` UNIQUE
5. **Anti-Duplication Indexes**:
   - `listing_favourites (user_id, listing_id)` UNIQUE
   - `conversation_participants (conversation_id, user_id)` UNIQUE
   - `user_blocks (blocker_id, blocked_id)` UNIQUE
6. **Messaging Performance**:
   - `messages (conversation_id, created_at)` for paginated chat log retrieval
   - `conversations (last_message_at)` for inbox order sorting

