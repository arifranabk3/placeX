<!-- Reusable Full Listing Detail Preview (Matches PlaceX Next.js /listings/[slug] Page) -->
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm space-y-4 p-4 sm:p-5">
    
    <!-- Top Meta Header -->
    <div class="space-y-2 border-b border-slate-100 pb-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="bg-[#031727] text-white text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider" 
                      x-text="getCategoryName()"></span>
                <span x-show="form.is_featured" class="bg-orange text-white text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider flex items-center gap-1 shadow">
                    <i class="fa-solid fa-bolt text-[9px]"></i>
                    <span>Featured</span>
                </span>
            </div>
            <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                <i class="fa-solid fa-location-dot"></i>
                <span x-text="getLocationName()"></span>
            </span>
        </div>

        <h1 class="text-base sm:text-lg font-black text-slate-900 leading-snug" 
            x-text="form.title || 'Untitled Marketplace Listing'"></h1>

        <div class="text-lg font-black text-[#ff5a0a]" x-text="formattedPrice()"></div>
    </div>

    <!-- Image Gallery Section -->
    <div class="space-y-2">
        <div class="relative aspect-16/10 bg-slate-900 rounded-xl overflow-hidden shadow-inner">
            <img :src="images[activeImageIndex] || images[0] || 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85'" 
                 class="w-full h-full object-cover">
            
            <span class="absolute bottom-2 right-2 bg-slate-950/80 text-white text-[10px] font-bold px-2 py-0.5 rounded backdrop-blur-xs">
                <span x-text="activeImageIndex + 1"></span> / <span x-text="images.length || 1"></span> Photos
            </span>
        </div>

        <!-- Thumbnails Strip -->
        <template x-if="images.length > 1">
            <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-thin">
                <template x-for="(imgUrl, idx) in images" :key="idx">
                    <button type="button" 
                            @click="activeImageIndex = idx"
                            class="relative shrink-0 w-16 h-12 rounded-lg overflow-hidden border-2 transition"
                            :class="activeImageIndex === idx ? 'border-orange ring-2 ring-orange/30' : 'border-slate-200 opacity-60 hover:opacity-100'">
                        <img :src="imgUrl" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>
        </template>
    </div>

    <!-- Category Specific Specifications Matrix -->
    <div class="space-y-2 pt-2">
        <h4 class="text-xs font-black uppercase text-slate-900 tracking-wider">Specifications &amp; Highlights</h4>
        
        <!-- Jobs Specs -->
        <template x-if="currentCategorySlug === 'jobs'">
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Company</span>
                    <span class="font-bold text-slate-800" x-text="form.company_name || 'PlaceX Partner'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Job Type</span>
                    <span class="font-bold text-slate-800 uppercase" x-text="form.job_type || 'Full Time'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Experience</span>
                    <span class="font-bold text-slate-800" x-text="form.experience_level || 'Mid Level'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Salary Range</span>
                    <span class="font-bold text-slate-800" x-text="formattedPrice()"></span>
                </div>
            </div>
        </template>

        <!-- Property Specs -->
        <template x-if="currentCategorySlug === 'property'">
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Type</span>
                    <span class="font-bold text-slate-800 capitalize" x-text="(form.property_purpose || 'Sale') + ' · ' + (form.property_type || 'House')"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Area Size</span>
                    <span class="font-bold text-slate-800" x-text="form.area_size || '5 Marla'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Bedrooms</span>
                    <span class="font-bold text-slate-800" x-text="(form.bedrooms || 3) + ' Rooms'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Bathrooms</span>
                    <span class="font-bold text-slate-800" x-text="(form.bathrooms || 3) + ' Baths'"></span>
                </div>
            </div>
        </template>

        <!-- Vehicles Specs -->
        <template x-if="currentCategorySlug === 'vehicles'">
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Make &amp; Model</span>
                    <span class="font-bold text-slate-800" x-text="(form.make || 'Toyota') + ' ' + (form.vehicle_model || 'Corolla')"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Year</span>
                    <span class="font-bold text-slate-800" x-text="form.year || '2022'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Mileage</span>
                    <span class="font-bold text-slate-800" x-text="form.mileage ? Number(form.mileage).toLocaleString() + ' km' : '45,000 km'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Transmission / Fuel</span>
                    <span class="font-bold text-slate-800 capitalize" x-text="(form.transmission || 'Automatic') + ' / ' + (form.fuel_type || 'Petrol')"></span>
                </div>
            </div>
        </template>

        <!-- Classifieds Specs -->
        <template x-if="currentCategorySlug === 'classifieds'">
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Condition</span>
                    <span class="font-bold text-slate-800 capitalize" x-text="form.condition || 'Used'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Brand</span>
                    <span class="font-bold text-slate-800" x-text="form.brand || 'Original'"></span>
                </div>
            </div>
        </template>

        <!-- Matrimonial Specs -->
        <template x-if="currentCategorySlug === 'matrimonial'">
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Profile Type</span>
                    <span class="font-bold text-slate-800" x-text="(form.gender === 'female' ? 'Bride' : 'Groom') + ' (' + (form.age || 28) + ' Yrs)'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Status</span>
                    <span class="font-bold text-slate-800 capitalize" x-text="form.marital_status || 'Single'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Education</span>
                    <span class="font-bold text-slate-800" x-text="form.education || 'Graduate'"></span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                    <span class="text-[10px] text-slate-400 block font-bold uppercase">Profession</span>
                    <span class="font-bold text-slate-800" x-text="form.profession || 'Working Professional'"></span>
                </div>
            </div>
        </template>
    </div>

    <!-- Description Narrative -->
    <div class="space-y-1.5 pt-2 border-t border-slate-100">
        <h4 class="text-xs font-black uppercase text-slate-900 tracking-wider">Description</h4>
        <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed" 
           x-text="form.description || 'Detailed narrative description provided by the seller/poster will display here in real time as typed in the editor.'"></p>
    </div>

    <!-- Seller Contact Box -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex items-center justify-between text-xs">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-black flex items-center justify-center text-xs">
                PX
            </div>
            <div>
                <span class="font-bold text-slate-900 block leading-tight">PlaceX Verified Seller</span>
                <span class="text-[10px] text-emerald-600 font-semibold"><i class="fa-solid fa-circle-check mr-0.5"></i> Identity Verified</span>
            </div>
        </div>
        <button type="button" class="btn-portal-primary px-3 py-1.5 rounded-lg text-xs font-bold pointer-events-none">
            <i class="fa-solid fa-phone mr-1"></i> Contact
        </button>
    </div>

</div>
