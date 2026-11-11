# PlaceX DATA DICTIONARY

## 1. Identity & RBAC
- **users**: Primary authentication table.
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `name`: VARCHAR(255) NOT NULL.
  - `email`: VARCHAR(255) NOT NULL UNIQUE.
  - `phone`: VARCHAR(50) NULL UNIQUE.
  - `password`: VARCHAR(255) NOT NULL.
  - `email_verified_at`: TIMESTAMP NULL.
  - `phone_verified_at`: TIMESTAMP NULL.
  - `status`: ENUM('active', 'suspended', 'banned') DEFAULT 'active'.
  - `created_at`, `updated_at`: TIMESTAMP.
  - `deleted_at`: TIMESTAMP NULL (Soft Deletes).
- **user_profiles**: Public display preferences and bios.
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `user_id`: BIGINT UNSIGNED NOT NULL UNIQUE FK -> users.id CASCADE.
  - `avatar`: VARCHAR(500) NULL.
  - `bio`: TEXT NULL.
  - `city`: VARCHAR(100) NULL.
  - `country`: VARCHAR(100) DEFAULT 'Pakistan'.
- **seller_profiles**: Business/dealer verification and trust metrics.
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `user_id`: BIGINT UNSIGNED NOT NULL UNIQUE FK -> users.id CASCADE.
  - `business_name`: VARCHAR(255) NULL.
  - `is_verified`: BOOLEAN DEFAULT FALSE.
  - `response_time_minutes`: INT UNSIGNED DEFAULT 60.
- **roles & permissions**: RBAC schema.
  - `roles`: `id`, `name` (admin, moderator, seller, buyer), `slug`.
  - `permissions`: `id`, `name`, `slug`.
  - `role_user`: `user_id`, `role_id` composite PK.
  - `permission_role`: `role_id`, `permission_id` composite PK.

## 2. Marketplace Core
- **categories**: Multi-category taxonomy (Jobs, Property, Classifieds, Vehicles, Matrimonial).
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `parent_id`: BIGINT UNSIGNED NULL FK -> categories.id.
  - `name`: VARCHAR(100) NOT NULL.
  - `slug`: VARCHAR(100) NOT NULL UNIQUE.
  - `icon`: VARCHAR(100) NULL.
  - `is_active`: BOOLEAN DEFAULT TRUE.
  - `order`: INT DEFAULT 0.
- **locations**: Geoname hierarchy.
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `country`: VARCHAR(100) NOT NULL.
  - `state`: VARCHAR(100) NULL.
  - `city`: VARCHAR(100) NOT NULL.
  - `latitude`: DECIMAL(10, 8) NULL.
  - `longitude`: DECIMAL(11, 8) NULL.
  - `is_active`: BOOLEAN DEFAULT TRUE.
- **listings**: Core marketplace record.
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `user_id`: BIGINT UNSIGNED NOT NULL FK -> users.id CASCADE.
  - `category_id`: BIGINT UNSIGNED NOT NULL FK -> categories.id RESTRICT.
  - `location_id`: BIGINT UNSIGNED NULL FK -> locations.id SET NULL.
  - `title`: VARCHAR(255) NOT NULL.
  - `slug`: VARCHAR(280) NOT NULL UNIQUE.
  - `description`: LONGTEXT NOT NULL.
  - `price`: DECIMAL(15, 2) NULL (NULL for jobs or matrimonial).
  - `currency`: CHAR(3) DEFAULT 'PKR'.
  - `latitude`: DECIMAL(10, 8) NULL.
  - `longitude`: DECIMAL(11, 8) NULL.
  - `listing_status`: ENUM('draft', 'active', 'paused', 'sold', 'closed', 'expired', 'archived') DEFAULT 'draft'.
  - `moderation_status`: ENUM('not_required', 'pending_review', 'approved', 'rejected', 'flagged') DEFAULT 'pending_review'.
  - `published_at`: TIMESTAMP NULL.
  - `expires_at`: TIMESTAMP NULL.
  - `created_at`, `updated_at`, `deleted_at`: TIMESTAMPS.
- **listing_images**:
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `listing_id`: BIGINT UNSIGNED NOT NULL FK -> listings.id CASCADE.
  - `image_path`: VARCHAR(500) NOT NULL.
  - `is_primary`: BOOLEAN DEFAULT FALSE.
  - `sort_order`: INT DEFAULT 0.

## 3. Category Specific Extensions
- **job_details**:
  - `id`, `listing_id` (UNIQUE FK), `employment_type` (full-time, part-time, contract, internship), `workplace_type` (onsite, remote, hybrid), `min_salary` DECIMAL(15,2), `max_salary` DECIMAL(15,2), `experience_level`, `company_name`.
- **property_details**:
  - `id`, `listing_id` (UNIQUE FK), `purpose` (sale, rent), `property_type` (house, flat, plot, commercial), `area_size` DECIMAL(10,2), `area_unit` (marla, kanal, sq_ft), `bedrooms` INT, `bathrooms` INT, `amenities` JSON.
- **classified_details**:
  - `id`, `listing_id` (UNIQUE FK), `sub_category`, `condition` (new, used), `brand`, `model`.
- **vehicle_details**:
  - `id`, `listing_id` (UNIQUE FK), `make`, `model`, `variant`, `year` INT, `mileage` INT, `transmission` (manual, automatic), `fuel_type` (petrol, diesel, hybrid, electric), `engine_capacity` INT, `body_type`, `assembly` (local, imported).
- **matrimonial_profiles**:
  - `id`, `listing_id` (UNIQUE FK), `profile_for` (self, son, daughter, sibling), `gender` (male, female), `age` INT, `marital_status`, `height_cm` INT, `religion`, `sect`, `education`, `profession`, `monthly_income` VARCHAR(100), `family_details` TEXT, `privacy_level` (public, verified_only, on_request).
- **matrimonial_preferences**:
  - `id`, `matrimonial_profile_id` (UNIQUE FK), `min_age` INT, `max_age` INT, `preferred_city` VARCHAR(100), `preferred_education` VARCHAR(255).

## 4. Communication & Messaging
- **conversations**:
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `listing_id`: BIGINT UNSIGNED NULL FK -> listings.id SET NULL.
  - `created_by`: BIGINT UNSIGNED NOT NULL FK -> users.id CASCADE.
  - `last_message_at`: TIMESTAMP NULL.
  - `created_at`, `updated_at`: TIMESTAMPS.
- **conversation_participants**:
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `conversation_id`: BIGINT UNSIGNED NOT NULL FK -> conversations.id CASCADE.
  - `user_id`: BIGINT UNSIGNED NOT NULL FK -> users.id CASCADE.
  - `last_read_at`: TIMESTAMP NULL.
  - UNIQUE(`conversation_id`, `user_id`).
- **messages**:
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `conversation_id`: BIGINT UNSIGNED NOT NULL FK -> conversations.id CASCADE.
  - `sender_id`: BIGINT UNSIGNED NOT NULL FK -> users.id CASCADE.
  - `body`: TEXT NOT NULL.
  - `created_at`, `updated_at`: TIMESTAMPS.
- **message_attachments**:
  - `id`: BIGINT UNSIGNED AUTO_INCREMENT PK.
  - `message_id`: BIGINT UNSIGNED NOT NULL FK -> messages.id CASCADE.
  - `file_path`: VARCHAR(500) NOT NULL.
  - `file_type`: VARCHAR(100) NOT NULL.
  - `file_size`: INT UNSIGNED NOT NULL.

## 5. Trust, Moderation & Audit
- **listing_reports**:
  - `id`, `listing_id`, `reporter_id`, `reason`, `details`, `status` (pending, reviewed, dismissed).
- **user_blocks**:
  - `id`, `blocker_id`, `blocked_id`, UNIQUE(`blocker_id`, `blocked_id`).
- **moderation_cases**:
  - `id`, `listing_id`, `assigned_to`, `verdict`, `notes`, `created_at`.
- **audit_logs**:
  - `id`, `user_id`, `action`, `entity_type`, `entity_id`, `ip_address`, `user_agent`, `payload` (JSON), `created_at`.

## 6. Promotion & Discovery
- **promotion_plans**:
  - `id`, `name` (Featured, Urgent, Top of Page), `duration_days`, `badge_color`, `price` DECIMAL(10,2).
- **listing_promotions**:
  - `id`, `listing_id`, `promotion_plan_id`, `starts_at`, `expires_at`, `status`.
- **promotion_entitlements**:
  - `id`, `user_id`, `plan_type`, `credits_remaining`, `granted_by`, `expires_at`.
- **listing_favourites**:
  - `id`, `user_id`, `listing_id`, UNIQUE(`user_id`, `listing_id`).
- **saved_searches**:
  - `id`, `user_id`, `criteria` JSON, `notify_email` BOOLEAN.
- **listing_views**:
  - `id`, `listing_id`, `viewer_ip`, `user_id` NULL, `viewed_at`.
- **notifications**:
  - Standard polymorphic notification system (`id`, `notifiable_type`, `notifiable_id`, `data`, `read_at`).

