<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminRbacSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles Definition
        $rolesData = [
            [
                'name' => 'Super Administrator',
                'slug' => 'super-admin',
                'description' => 'Unrestricted root administrative access across all PlaceX subsystems.',
            ],
            [
                'name' => 'Operations Administrator',
                'slug' => 'admin',
                'description' => 'Platform operational administration, user management, and listing approvals.',
            ],
            [
                'name' => 'Content Moderator',
                'slug' => 'moderator',
                'description' => 'Trust and safety review queues, content policy enforcement, and report resolution.',
            ],
            [
                'name' => 'Support Agent',
                'slug' => 'support-agent',
                'description' => 'Customer assistance, user verification lookup, and dispute management.',
            ],
            [
                'name' => 'Verified Seller',
                'slug' => 'seller',
                'description' => 'Commercial merchant with storefront privileges and bulk listing tools.',
            ],
            [
                'name' => 'Regular User',
                'slug' => 'user',
                'description' => 'Standard community member buying, selling, and searching across categories.',
            ],
        ];

        $roles = [];
        foreach ($rolesData as $data) {
            $roles[$data['slug']] = Role::updateOrCreate(['slug' => $data['slug']], $data);
        }

        // 2. Granular Permissions Definition
        $permissionsData = [
            // Dashboard
            ['group' => 'dashboard', 'slug' => 'dashboard.view', 'name' => 'View Admin Dashboard'],

            // Users
            ['group' => 'users', 'slug' => 'users.view', 'name' => 'View User Directory and Profiles'],
            ['group' => 'users', 'slug' => 'users.create', 'name' => 'Create New Users'],
            ['group' => 'users', 'slug' => 'users.edit', 'name' => 'Edit User Details'],
            ['group' => 'users', 'slug' => 'users.status', 'name' => 'Activate / Deactivate / Block Users'],
            ['group' => 'users', 'slug' => 'users.delete', 'name' => 'Delete Users'],

            // Sellers
            ['group' => 'sellers', 'slug' => 'sellers.view', 'name' => 'View Seller Profiles'],
            ['group' => 'sellers', 'slug' => 'sellers.verify', 'name' => 'Verify or Unverify Sellers'],
            ['group' => 'sellers', 'slug' => 'sellers.suspend', 'name' => 'Suspend Seller Accounts'],

            // Listings
            ['group' => 'listings', 'slug' => 'listings.view', 'name' => 'View Listings Directory'],
            ['group' => 'listings', 'slug' => 'listings.edit', 'name' => 'Edit Listing Details'],
            ['group' => 'listings', 'slug' => 'listings.approve', 'name' => 'Approve Pending Listings'],
            ['group' => 'listings', 'slug' => 'listings.reject', 'name' => 'Reject or Flag Listings'],
            ['group' => 'listings', 'slug' => 'listings.delete', 'name' => 'Archive or Delete Listings'],

            // Categories
            ['group' => 'categories', 'slug' => 'categories.manage', 'name' => 'Manage Marketplace Categories'],

            // Moderation & Reports
            ['group' => 'moderation', 'slug' => 'moderation.view', 'name' => 'View Moderation Queue'],
            ['group' => 'moderation', 'slug' => 'moderation.action', 'name' => 'Perform Moderation Decisions'],
            ['group' => 'reports', 'slug' => 'reports.view', 'name' => 'View Reports and Complaints'],
            ['group' => 'reports', 'slug' => 'reports.resolve', 'name' => 'Resolve or Dismiss Reports'],

            // Promotions & Payments
            ['group' => 'promotions', 'slug' => 'promotions.view', 'name' => 'View Promotion Plans & Listings'],
            ['group' => 'promotions', 'slug' => 'promotions.manage', 'name' => 'Manage Promotion Plans'],
            ['group' => 'promotions', 'slug' => 'promotions.grant', 'name' => 'Grant Manual Promotion Entitlements'],
            ['group' => 'payments', 'slug' => 'payments.view', 'name' => 'View Payment & Transaction History'],
            ['group' => 'payments', 'slug' => 'payments.manage', 'name' => 'Process Manual Payment Approvals'],

            // Roles & System
            ['group' => 'roles', 'slug' => 'roles.manage', 'name' => 'Manage Roles and Permissions Matrix'],
            ['group' => 'notifications', 'slug' => 'notifications.view', 'name' => 'View and Dispatch Admin Alerts'],
            ['group' => 'audit_logs', 'slug' => 'audit_logs.view', 'name' => 'View Read-Only Audit Logs'],
            ['group' => 'settings', 'slug' => 'settings.view', 'name' => 'View Platform Settings'],
            ['group' => 'settings', 'slug' => 'settings.edit', 'name' => 'Edit Platform Settings'],
        ];

        $permissionIds = [];
        foreach ($permissionsData as $pData) {
            $perm = Permission::updateOrCreate(['slug' => $pData['slug']], $pData);
            $permissionIds[$pData['slug']] = $perm->id;
        }

        // 3. Permission Assignments
        // Super Admin gets all permissions
        $roles['super-admin']->permissions()->sync(array_values($permissionIds));

        // Admin gets operational permissions
        $adminPerms = [
            'dashboard.view',
            'users.view', 'users.create', 'users.edit', 'users.status',
            'sellers.view', 'sellers.verify', 'sellers.suspend',
            'listings.view', 'listings.edit', 'listings.approve', 'listings.reject', 'listings.delete',
            'categories.manage',
            'moderation.view', 'moderation.action',
            'reports.view', 'reports.resolve',
            'promotions.view', 'promotions.manage', 'promotions.grant',
            'payments.view', 'payments.manage',
            'notifications.view',
            'audit_logs.view',
            'settings.view',
        ];
        $roles['admin']->permissions()->sync(
            array_intersect_key($permissionIds, array_flip($adminPerms))
        );

        // Moderator gets moderation & content permissions
        $moderatorPerms = [
            'dashboard.view',
            'listings.view', 'listings.approve', 'listings.reject',
            'moderation.view', 'moderation.action',
            'reports.view', 'reports.resolve',
            'notifications.view',
        ];
        $roles['moderator']->permissions()->sync(
            array_intersect_key($permissionIds, array_flip($moderatorPerms))
        );

        // Support Agent gets view & assistance permissions
        $supportPerms = [
            'dashboard.view',
            'users.view',
            'sellers.view',
            'listings.view',
            'reports.view', 'reports.resolve',
            'notifications.view',
        ];
        $roles['support-agent']->permissions()->sync(
            array_intersect_key($permissionIds, array_flip($supportPerms))
        );

        // 4. Default Admin Accounts Setup
        // Super Admin Account
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@placex.test'],
            [
                'name' => 'PlaceX Super Admin',
                'phone' => '+923000000000',
                'password' => Hash::make('AdminPlaceX2026!'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $adminUser->roles()->syncWithoutDetaching([
            $roles['super-admin']->id,
            $roles['admin']->id,
        ]);

        // Moderator Account
        $modUser = User::updateOrCreate(
            ['email' => 'moderator@placex.test'],
            [
                'name' => 'Ayesha Moderator',
                'phone' => '+923002223344',
                'password' => Hash::make('ModPlaceX2026!'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $modUser->roles()->syncWithoutDetaching([$roles['moderator']->id]);

        // Support Agent Account
        $supportUser = User::updateOrCreate(
            ['email' => 'support@placex.test'],
            [
                'name' => 'Bilal Support',
                'phone' => '+923003334455',
                'password' => Hash::make('SupportPlaceX2026!'),
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $supportUser->roles()->syncWithoutDetaching([$roles['support-agent']->id]);

        // Demo Seller
        $sellerUser = User::where('email', 'seller@placex.test')->first();
        if ($sellerUser) {
            $sellerUser->roles()->syncWithoutDetaching([$roles['seller']->id, $roles['user']->id]);
        }

        // 5. Default System Settings
        $defaultSettings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'PlaceX Marketplace', 'type' => 'string', 'description' => 'Marketplace branding title'],
            ['group' => 'general', 'key' => 'contact_email', 'value' => 'support@placex.pk', 'type' => 'string', 'description' => 'Customer support email'],
            ['group' => 'general', 'key' => 'contact_phone', 'value' => '+92 51 111 752 239', 'type' => 'string', 'description' => 'Customer helpline phone number'],
            ['group' => 'marketplace', 'key' => 'default_currency', 'value' => 'PKR', 'type' => 'string', 'description' => 'Standard listing currency'],
            ['group' => 'marketplace', 'key' => 'items_per_page', 'value' => '12', 'type' => 'integer', 'description' => 'Default pagination size across listings'],
            ['group' => 'listings', 'key' => 'free_ad_duration_days', 'value' => '30', 'type' => 'integer', 'description' => 'Standard active lifetime of free listings'],
            ['group' => 'listings', 'key' => 'max_images_per_listing', 'value' => '10', 'type' => 'integer', 'description' => 'Maximum allowed photos per ad'],
            ['group' => 'moderation', 'key' => 'auto_approve_listings', 'value' => '1', 'type' => 'boolean', 'description' => 'Publish standard ads automatically without manual hold'],
            ['group' => 'moderation', 'key' => 'flag_suspicious_keywords', 'value' => '1', 'type' => 'boolean', 'description' => 'Hold ads with suspicious keywords for manual review'],
            ['group' => 'security', 'key' => 'max_login_attempts', 'value' => '5', 'type' => 'integer', 'description' => 'Rate limit before temporary throttle lock'],
            ['group' => 'notifications', 'key' => 'email_alerts_enabled', 'value' => '1', 'type' => 'boolean', 'description' => 'Notify admins on urgent moderation reports'],
        ];

        foreach ($defaultSettings as $setting) {
            SystemSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
