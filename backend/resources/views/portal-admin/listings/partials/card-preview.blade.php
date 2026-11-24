<!-- Reusable Listing Card Preview (Matches PlaceX Next.js .listing-card) -->
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition w-full max-w-md mx-auto">
    <!-- Card Media Container -->
    <div class="relative aspect-4/3 bg-slate-100 overflow-hidden">
        <img :src="images[0] || 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85'" 
             :alt="form.title || 'Listing Preview'" 
             class="w-full h-full object-cover">
        
        <!-- Category Badge -->
        <span class="absolute top-2.5 left-2.5 bg-slate-900/85 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
            <span x-text="getCategoryName()"></span>
        </span>

        <!-- Featured Badge -->
        <span x-show="form.is_featured" class="absolute top-2.5 right-2.5 bg-orange text-white text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider flex items-center gap-1 shadow">
            <i class="fa-solid fa-bolt text-[9px]"></i>
            <span>Featured</span>
        </span>

        <!-- Price Pill -->
        <div class="absolute bottom-2.5 left-2.5 bg-slate-950/90 text-white font-black text-xs px-2.5 py-1 rounded-lg backdrop-blur-xs shadow-sm">
            <span x-text="formattedPrice()"></span>
        </div>
    </div>

    <!-- Card Content -->
    <div class="p-4 space-y-2.5">
        <h3 class="font-bold text-sm text-slate-900 line-clamp-2 leading-snug" 
            x-text="form.title || 'Your Listing Title Will Appear Here'"></h3>

        <!-- Dynamic Category-specific Chips -->
        <div class="flex flex-wrap gap-1.5 text-[11px] text-slate-600">
            <!-- Jobs -->
            <template x-if="currentCategorySlug === 'jobs'">
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.company_name || 'Hiring Company'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700 uppercase text-[10px]" x-text="form.job_type || 'Full Time'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.experience_level || 'Mid Level'"></span>
                </div>
            </template>

            <!-- Property -->
            <template x-if="currentCategorySlug === 'property'">
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700 capitalize" x-text="form.property_purpose ? 'For ' + form.property_purpose : 'For Sale'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700 capitalize" x-text="form.property_type || 'House'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.area_size || '5 Marla'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="(form.bedrooms || 3) + ' Beds'"></span>
                </div>
            </template>

            <!-- Vehicles -->
            <template x-if="currentCategorySlug === 'vehicles'">
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="(form.make || 'Toyota') + ' ' + (form.vehicle_model || 'Corolla')"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.year || '2022'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.mileage ? Number(form.mileage).toLocaleString() + ' km' : '45,000 km'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700 capitalize" x-text="form.fuel_type || 'Petrol'"></span>
                </div>
            </template>

            <!-- Classifieds -->
            <template x-if="currentCategorySlug === 'classifieds'">
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700 capitalize" x-text="form.condition || 'Used'"></span>
                    <span x-show="form.brand" class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.brand"></span>
                    <span x-show="form.model" class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.model"></span>
                </div>
            </template>

            <!-- Matrimonial -->
            <template x-if="currentCategorySlug === 'matrimonial'">
                <div class="flex flex-wrap gap-1.5">
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="(form.gender === 'female' ? 'Bride' : 'Groom') + ' · ' + (form.age || '28') + ' Yrs'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700 capitalize" x-text="form.marital_status || 'Single'"></span>
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium text-slate-700" x-text="form.profession || 'Professional'"></span>
                </div>
            </template>
        </div>

        <!-- Meta Footer -->
        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-location-dot text-slate-400"></i>
                <span x-text="getLocationName()"></span>
            </span>
            <span class="text-orange font-bold text-[10px]">Just now</span>
        </div>
    </div>
</div>
