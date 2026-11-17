<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortalAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dedicated Portal Admin Roles
        $portalRoles = [
            [
                'name' => 'Portal Manager',
                'slug' => 'portal-manager',
                'description' => 'Oversees frontend marketplace content, homepage CMS, SEO, categories and listings.',
            ],
            [
                'name' => 'Content Manager',
                'slug' => 'content-manager',
                'description' => 'Publishes and curates listings across Jobs, Property, Classifieds, and Vehicles.',
            ],
            [
                'name' => 'Listing Manager',
                'slug' => 'listing-manager',
                'description' => 'Drafts, edits, pauses, and updates marketplace listings.',
            ],
        ];

        $roles = [];
        foreach ($portalRoles as $roleData) {
            $roles[$roleData['slug']] = Role::updateOrCreate(['slug' => $roleData['slug']], $roleData);
        }

        // 2. Portal Permissions
        $portalPerms = [
            ['group' => 'portal', 'slug' => 'portal.access', 'name' => 'Access Portal Admin Panel'],
            ['group' => 'portal', 'slug' => 'portal.dashboard', 'name' => 'View Portal Dashboard'],
            ['group' => 'portal', 'slug' => 'portal.listings.manage', 'name' => 'Manage Marketplace Listings'],
            ['group' => 'portal', 'slug' => 'portal.listings.publish', 'name' => 'Publish & Unpublish Listings'],
            ['group' => 'portal', 'slug' => 'portal.homepage.manage', 'name' => 'Manage Homepage CMS & Banners'],
            ['group' => 'portal', 'slug' => 'portal.media.manage', 'name' => 'Upload & Manage Media Library'],
            ['group' => 'portal', 'slug' => 'portal.seo.manage', 'name' => 'Manage SEO & Metadata'],
            ['group' => 'portal', 'slug' => 'portal.categories.manage', 'name' => 'Manage Categories & Attributes'],
            ['group' => 'portal', 'slug' => 'portal.enquiries.manage', 'name' => 'Review Enquiries & Reports'],
            ['group' => 'portal', 'slug' => 'portal.matrimonial.manage', 'name' => 'Manage Matrimonial Profiles (Strict Privacy)'],
        ];

        $permissionIds = [];
        foreach ($portalPerms as $pData) {
            $perm = Permission::updateOrCreate(['slug' => $pData['slug']], $pData);
            $permissionIds[$pData['slug']] = $perm->id;
        }

        // Grant Portal Permissions to Portal Roles
        $roles['portal-manager']->permissions()->sync(array_values($permissionIds));

        $contentManagerPerms = [
            'portal.access', 'portal.dashboard', 'portal.listings.manage',
            'portal.listings.publish', 'portal.homepage.manage', 'portal.media.manage',
            'portal.seo.manage', 'portal.categories.manage', 'portal.enquiries.manage',
        ];
        $roles['content-manager']->permissions()->sync(
            array_intersect_key($permissionIds, array_flip($contentManagerPerms))
        );

        $listingManagerPerms = [
            'portal.access', 'portal.dashboard', 'portal.listings.manage', 'portal.media.manage',
        ];
        $roles['listing-manager']->permissions()->sync(
            array_intersect_key($permissionIds, array_flip($listingManagerPerms))
        );

        // Also give Super Admin all portal permissions
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdminRole->permissions()->syncWithoutDetaching(array_values($permissionIds));
        }

        // 3. Create Portal Manager User
        $portalManager = User::updateOrCreate(
            ['email' => 'portal@placex.test'],
            [
                'name' => 'PlaceX Portal Manager',
                'password' => Hash::make('PortalPlaceX2026!'),
                'phone' => '+923001234567',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $portalManager->roles()->syncWithoutDetaching([$roles['portal-manager']->id]);

        // 4. Create Content Manager User
        $contentManager = User::updateOrCreate(
            ['email' => 'content@placex.test'],
            [
                'name' => 'Zainab Content Lead',
                'password' => Hash::make('ContentPlaceX2026!'),
                'phone' => '+923007654321',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $contentManager->roles()->syncWithoutDetaching([$roles['content-manager']->id]);
    }
}
