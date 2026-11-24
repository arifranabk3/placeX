<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('portalListingEditor', (config) => ({
        categories: config.categories || [],
        locations: config.locations || [],
        form: Object.assign({
            title: '',
            category_id: (config.categories && config.categories[0]) ? config.categories[0].id : 1,
            location_id: (config.locations && config.locations[0]) ? config.locations[0].id : 1,
            price: 50000,
            currency: 'PKR',
            description: '',
            listing_status: 'draft',
            moderation_status: 'approved',
            is_featured: false,
            // Jobs
            company_name: '',
            job_type: 'full-time',
            experience_level: 'mid-level',
            salary_min: 80000,
            salary_max: 150000,
            // Property
            property_purpose: 'sale',
            property_type: 'house',
            area_size: '5 Marla',
            bedrooms: 3,
            bathrooms: 3,
            // Classifieds
            condition: 'used',
            brand: '',
            model: '',
            // Vehicles
            make: 'Toyota',
            vehicle_model: 'Corolla',
            year: 2022,
            mileage: 38000,
            transmission: 'automatic',
            fuel_type: 'petrol',
            // Matrimonial
            gender: 'male',
            age: 28,
            marital_status: 'single',
            religion: 'Islam - Sunni',
            education: 'Masters',
            profession: 'Software Engineer',
        }, config.initial || {}),

        // Array of image objects: { id: number|null, url: string, is_new: boolean, is_removed: boolean, is_primary: boolean }
        imageList: (config.initialImages && config.initialImages.length > 0)
            ? config.initialImages.map((img, idx) => typeof img === 'string' 
                ? { id: null, url: img, is_new: false, is_removed: false, is_primary: idx === 0 }
                : { id: img.id || null, url: img.image_url || img.url, is_new: false, is_removed: false, is_primary: img.is_primary ?? (idx === 0) })
            : [
                { id: null, url: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85', is_new: false, is_removed: false, is_primary: true }
            ],

        activeImageIndex: 0,
        newImageUrl: '',
        previewMode: 'card', // 'card' or 'detail'
        mobileTab: 'form',   // 'form' or 'preview'
        removedImageIds: [],

        get activeImages() {
            return this.imageList.filter(img => !img.is_removed);
        },

        get images() {
            return this.activeImages.map(img => img.url);
        },

        get currentCategory() {
            return this.categories.find(c => c.id == this.form.category_id) || this.categories[0] || {};
        },

        get currentCategorySlug() {
            const slug = (this.currentCategory.slug || '').toLowerCase();
            if (slug.includes('job')) return 'jobs';
            if (slug.includes('prop')) return 'property';
            if (slug.includes('class')) return 'classifieds';
            if (slug.includes('vehic') || slug.includes('car')) return 'vehicles';
            if (slug.includes('matri') || slug.includes('marr')) return 'matrimonial';
            return slug || 'classifieds';
        },

        getCategoryName() {
            return this.currentCategory.name || 'General';
        },

        getLocationName() {
            const loc = this.locations.find(l => l.id == this.form.location_id);
            return loc ? loc.name : 'Pakistan';
        },

        formattedPrice() {
            if (this.currentCategorySlug === 'jobs') {
                if (this.form.salary_min && this.form.salary_max) {
                    return `PKR ${Number(this.form.salary_min).toLocaleString()} - ${Number(this.form.salary_max).toLocaleString()}`;
                }
            }
            if (!this.form.price || Number(this.form.price) === 0) {
                return 'Contact for Price';
            }
            return `${this.form.currency || 'PKR'} ${Number(this.form.price).toLocaleString()}`;
        },

        selectCategory(cat) {
            this.form.category_id = cat.id;
        },

        addImageUrl() {
            if (this.newImageUrl && this.newImageUrl.trim() !== '') {
                this.imageList.push({
                    id: null,
                    url: this.newImageUrl.trim(),
                    is_new: true,
                    is_removed: false,
                    is_primary: this.activeImages.length === 0
                });
                this.newImageUrl = '';
            }
        },

        handleFileSelect(event) {
            const files = event.target.files;
            if (!files || files.length === 0) return;

            Array.from(files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageList.unshift({
                        id: null,
                        url: e.target.result,
                        is_new: true,
                        is_removed: false,
                        is_primary: true
                    });
                    this.recalcPrimary();
                    this.activeImageIndex = 0;
                };
                reader.readAsDataURL(file);
            });
        },

        setCover(activeIdx) {
            const active = this.activeImages[activeIdx];
            if (!active) return;

            // Move to first position among active images
            const realIdx = this.imageList.indexOf(active);
            if (realIdx > -1) {
                const item = this.imageList.splice(realIdx, 1)[0];
                this.imageList.unshift(item);
                this.recalcPrimary();
                this.activeImageIndex = 0;
            }
        },

        removeImage(activeIdx) {
            const target = this.activeImages[activeIdx];
            if (!target) return;

            if (target.id) {
                target.is_removed = true;
                if (!this.removedImageIds.includes(target.id)) {
                    this.removedImageIds.push(target.id);
                }
            } else {
                const realIdx = this.imageList.indexOf(target);
                if (realIdx > -1) {
                    this.imageList.splice(realIdx, 1);
                }
            }

            this.recalcPrimary();
            if (this.activeImageIndex >= this.activeImages.length) {
                this.activeImageIndex = Math.max(0, this.activeImages.length - 1);
            }
        },

        moveImage(activeIdx, direction) {
            const target = this.activeImages[activeIdx];
            const newActiveIdx = activeIdx + direction;
            const dest = this.activeImages[newActiveIdx];
            if (!target || !dest) return;

            const fromReal = this.imageList.indexOf(target);
            const toReal = this.imageList.indexOf(dest);

            const item = this.imageList.splice(fromReal, 1)[0];
            this.imageList.splice(toReal, 0, item);

            this.recalcPrimary();
            this.activeImageIndex = newActiveIdx;
        },

        recalcPrimary() {
            this.imageList.forEach((img, idx) => {
                img.is_primary = (!img.is_removed && idx === 0);
            });
        },

        saveListing(status) {
            this.form.listing_status = status;
            const formElem = document.getElementById('listingForm');
            if (formElem) {
                formElem.submit();
            }
        },

        submitRealForm() {
            this.saveListing(this.form.listing_status || 'draft');
        }
    }));
});
</script>
