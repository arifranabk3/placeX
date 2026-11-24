<!-- 1. Category Selector (Drives Dynamic Fields) -->
<div class="space-y-4">
    <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2 flex items-center justify-between">
        <span>1. Marketplace Vertical</span>
        <span class="text-[11px] font-bold text-orange" x-text="getCategoryName()"></span>
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
        <template x-for="c in categories" :key="c.id">
            <button type="button"
                    @click="selectCategory(c)"
                    class="p-2.5 rounded-xl border text-center transition flex flex-col items-center justify-center gap-1.5"
                    :class="form.category_id == c.id ? 'border-orange bg-orange/5 text-orange font-black shadow-sm ring-2 ring-orange/20' : 'border-slate-200 hover:border-slate-300 text-slate-700 bg-white'">
                <i class="fa-solid" :class="{
                    'fa-briefcase': (c.slug || '').includes('job'),
                    'fa-house': (c.slug || '').includes('prop'),
                    'fa-tag': (c.slug || '').includes('class'),
                    'fa-car': (c.slug || '').includes('vehic') || (c.slug || '').includes('car'),
                    'fa-heart': (c.slug || '').includes('matri') || (c.slug || '').includes('marr')
                }"></i>
                <span class="text-[11px] leading-tight" x-text="c.name"></span>
            </button>
        </template>
    </div>
    <input type="hidden" name="category_id" :value="form.category_id">
</div>

<!-- 2. Core Listing Information -->
<div class="space-y-4 pt-2">
    <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2">
        2. Listing Information
    </h2>

    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Listing Title <span class="text-orange">*</span></label>
        <input type="text" name="title" x-model="form.title" required
               placeholder="e.g., Senior Full Stack Developer (Next.js / Laravel)"
               class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Location City</label>
            <select name="location_id" x-model="form.location_id" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                <template x-for="loc in locations" :key="loc.id">
                    <option :value="loc.id" x-text="loc.name" :selected="form.location_id == loc.id"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Currency</label>
            <select name="currency" x-model="form.currency" class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
                <option value="PKR">PKR (₨)</option>
                <option value="USD">USD ($)</option>
                <option value="EUR">EUR (€)</option>
                <option value="AED">AED (د.إ)</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Base Price / Value</label>
            <input type="number" name="price" x-model.number="form.price" min="0" step="100"
                   placeholder="e.g., 85000"
                   class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium">
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Description <span class="text-orange">*</span></label>
        <textarea name="description" x-model="form.description" rows="4" required
                  placeholder="Provide comprehensive details for public buyers and candidates..."
                  class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange text-slate-900 font-medium"></textarea>
    </div>

    <!-- Featured Checkbox -->
    <div class="flex items-center gap-2 pt-1">
        <input type="checkbox" id="is_featured" name="is_featured" value="1" x-model="form.is_featured" class="w-4 h-4 text-orange rounded border-slate-300 focus:ring-orange">
        <label for="is_featured" class="text-xs font-bold text-slate-700 cursor-pointer select-none">
            Feature this listing on PlaceX homepage &amp; category banners
        </label>
    </div>
</div>

<!-- 3. Category-Specific Fields (Conditionally Swapped) -->
<div class="space-y-4 pt-2">
    <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2 flex items-center justify-between">
        <span>3. Vertical Specifications</span>
        <span class="text-[10px] uppercase font-bold text-slate-400" x-text="currentCategorySlug"></span>
    </h2>

    <!-- A. JOBS VERTICAL -->
    <div x-show="currentCategorySlug === 'jobs'" class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Company / Organization</label>
                <input type="text" name="company_name" x-model="form.company_name" placeholder="e.g., PlaceX Global Technologies"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Job Type</label>
                <select name="job_type" x-model="form.job_type" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="full-time">Full Time</option>
                    <option value="part-time">Part Time</option>
                    <option value="remote">Remote</option>
                    <option value="contract">Contract</option>
                    <option value="internship">Internship</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Experience Level</label>
                <select name="experience_level" x-model="form.experience_level" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="entry-level">Entry Level (0-2 Yrs)</option>
                    <option value="mid-level">Mid Level (2-5 Yrs)</option>
                    <option value="senior">Senior (5+ Yrs)</option>
                    <option value="lead">Lead / Principal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Min Salary (PKR)</label>
                <input type="number" name="salary_min" x-model.number="form.salary_min" placeholder="80000"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Max Salary (PKR)</label>
                <input type="number" name="salary_max" x-model.number="form.salary_max" placeholder="150000"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
        </div>
    </div>

    <!-- B. PROPERTY VERTICAL -->
    <div x-show="currentCategorySlug === 'property'" class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Purpose</label>
                <select name="property_purpose" x-model="form.property_purpose" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="sale">For Sale</option>
                    <option value="rent">For Rent</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Property Type</label>
                <select name="property_type" x-model="form.property_type" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="house">House</option>
                    <option value="apartment">Flat / Apartment</option>
                    <option value="commercial">Commercial / Office</option>
                    <option value="plot">Plot / Land</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Area Size</label>
                <input type="text" name="area_size" x-model="form.area_size" placeholder="e.g. 5 Marla, 1 Kanal"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bedrooms</label>
                <input type="number" name="bedrooms" x-model.number="form.bedrooms" min="0" max="20"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bathrooms</label>
                <input type="number" name="bathrooms" x-model.number="form.bathrooms" min="0" max="20"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
        </div>
    </div>

    <!-- C. CLASSIFIEDS VERTICAL -->
    <div x-show="currentCategorySlug === 'classifieds'" class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Condition</label>
                <select name="condition" x-model="form.condition" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="new">Brand New</option>
                    <option value="used">Used / Pre-owned</option>
                    <option value="refurbished">Refurbished</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Brand</label>
                <input type="text" name="brand" x-model="form.brand" placeholder="e.g., Apple, Samsung, Sony"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Model / Specs</label>
                <input type="text" name="model" x-model="form.model" placeholder="e.g., iPhone 15 Pro Max"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
        </div>
    </div>

    <!-- D. VEHICLES VERTICAL -->
    <div x-show="currentCategorySlug === 'vehicles'" class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Make</label>
                <input type="text" name="make" x-model="form.make" placeholder="e.g., Honda, Toyota"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Model</label>
                <input type="text" name="vehicle_model" x-model="form.vehicle_model" placeholder="e.g., Civic, Corolla"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Year</label>
                <input type="number" name="year" x-model.number="form.year" min="1990" max="2027"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mileage (km)</label>
                <input type="number" name="mileage" x-model.number="form.mileage" placeholder="45000"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Transmission</label>
                <select name="transmission" x-model="form.transmission" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="automatic">Automatic</option>
                    <option value="manual">Manual</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fuel Type</label>
                <select name="fuel_type" x-model="form.fuel_type" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="petrol">Petrol</option>
                    <option value="diesel">Diesel</option>
                    <option value="hybrid">Hybrid</option>
                    <option value="electric">Electric</option>
                </select>
            </div>
        </div>
    </div>

    <!-- E. MATRIMONIAL VERTICAL -->
    <div x-show="currentCategorySlug === 'matrimonial'" class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Gender</label>
                <select name="gender" x-model="form.gender" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="female">Bride (Female)</option>
                    <option value="male">Groom (Male)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Age</label>
                <input type="number" name="age" x-model.number="form.age" min="18" max="75"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Marital Status</label>
                <select name="marital_status" x-model="form.marital_status" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
                    <option value="single">Single / Never Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Education</label>
                <input type="text" name="education" x-model="form.education" placeholder="e.g. Masters in Computer Science"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Profession</label>
                <input type="text" name="profession" x-model="form.profession" placeholder="e.g. Lead Software Architect"
                       class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg bg-white">
            </div>
        </div>
    </div>
</div>

<!-- 4. Multi-Image Management & Preview Synchronizer -->
<div class="space-y-4 pt-2">
    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
        <h2 class="text-xs font-black uppercase tracking-wider text-slate-800">
            4. Gallery &amp; Photos (<span x-text="activeImages.length"></span>)
        </h2>
        <span class="text-[11px] text-slate-400">First image acts as Cover Photo</span>
    </div>

    <!-- Hidden removed image IDs for safe server sync on save -->
    <template x-for="id in removedImageIds" :key="id">
        <input type="hidden" name="removed_image_ids[]" :value="id">
    </template>

    <!-- Upload Box & Direct URL Box -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <label class="border-2 border-dashed border-slate-300 hover:border-orange rounded-xl p-4 text-center cursor-pointer transition bg-slate-50/50 hover:bg-orange/5 block">
            <i class="fa-solid fa-cloud-arrow-up text-xl text-slate-400 mb-1"></i>
            <span class="block text-xs font-bold text-slate-700">Choose Images from Computer</span>
            <span class="block text-[10px] text-slate-400">JPG, PNG, WebP (Instant Preview)</span>
            <input type="file" @change="handleFileSelect" accept="image/*" multiple class="hidden">
        </label>

        <div class="border border-slate-200 rounded-xl p-3 bg-slate-50 flex flex-col justify-between">
            <span class="text-xs font-bold text-slate-700">Or Paste Image URL</span>
            <div class="flex gap-2 mt-1">
                <input type="url" x-model="newImageUrl" placeholder="https://example.com/image.jpg"
                       class="w-full px-2.5 py-1.5 text-xs border border-slate-200 rounded-lg bg-white">
                <button type="button" @click="addImageUrl" class="px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-bold hover:bg-slate-900 transition">
                    Add
                </button>
            </div>
        </div>
    </div>

    <!-- Image Thumbnails Grid -->
    <template x-if="activeImages.length > 0">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
            <template x-for="(img, idx) in activeImages" :key="img.url + idx">
                <div class="relative group rounded-xl overflow-hidden border border-slate-200 bg-slate-100 aspect-video shadow-xs">
                    <img :src="img.url" class="w-full h-full object-cover">

                    <!-- Badges -->
                    <div class="absolute top-1 left-1 flex flex-col gap-1">
                        <span x-show="idx === 0" class="bg-orange text-white text-[9px] font-black px-1.5 py-0.5 rounded shadow">
                            COVER
                        </span>
                        <span x-show="img.is_new" class="bg-blue-600 text-white text-[8px] font-bold px-1 py-0.5 rounded shadow">
                            NEW
                        </span>
                    </div>

                    <!-- Actions Overlay -->
                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-1.5">
                        <button type="button" x-show="idx > 0" @click="moveImage(idx, -1)" title="Move Left"
                                class="p-1.5 bg-white text-slate-800 rounded-md text-[10px] hover:bg-slate-200">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <button type="button" x-show="idx !== 0" @click="setCover(idx)" title="Make Cover Image"
                                class="p-1.5 bg-orange text-white rounded-md text-[10px] hover:bg-orange-600">
                            <i class="fa-solid fa-star"></i>
                        </button>
                        <button type="button" x-show="idx < activeImages.length - 1" @click="moveImage(idx, 1)" title="Move Right"
                                class="p-1.5 bg-white text-slate-800 rounded-md text-[10px] hover:bg-slate-200">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        <button type="button" @click="removeImage(idx)" title="Remove Image"
                                class="p-1.5 bg-rose-600 text-white rounded-md text-[10px] hover:bg-rose-700">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </template>
    <input type="hidden" name="image_url" :value="images[0] || ''">
</div>
