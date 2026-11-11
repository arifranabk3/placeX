export interface Category {
  id: number;
  name: string;
  slug: string;
  icon?: string;
  description?: string;
  sort_order: number;
  parent_id?: number | null;
  children_count?: number;
  listings_count?: number;
}

export interface Location {
  id?: number;
  city: string;
  state?: string;
  country: string;
}

export interface Seller {
  id: number;
  name: string;
  is_verified: boolean;
}

export interface ListingImage {
  id: number;
  image_path: string;
  is_primary: boolean;
}

export interface JobDetail {
  employment_type: string;
  workplace_type: string;
  min_salary?: number;
  max_salary?: number;
  salary_period: string;
  experience_level?: string;
  company_name?: string;
}

export interface PropertyDetail {
  purpose: 'sale' | 'rent';
  property_type: string;
  area_size: number;
  area_unit: string;
  bedrooms?: number;
  bathrooms?: number;
  amenities?: string[];
}

export interface ClassifiedDetail {
  sub_category?: string;
  condition: string;
  brand?: string;
  model?: string;
}

export interface VehicleDetail {
  make: string;
  model: string;
  variant?: string;
  year: number;
  mileage: number;
  transmission: string;
  fuel_type: string;
  engine_capacity?: number;
  body_type?: string;
  assembly: string;
}

export interface MatrimonialProfile {
  profile_for: string;
  gender: 'male' | 'female';
  age: number;
  marital_status: string;
  height_cm?: number;
  religion: string;
  sect?: string;
  education?: string;
  profession?: string;
  preferences?: {
    min_age?: number;
    max_age?: number;
    preferred_city?: string;
  };
}

export interface Listing {
  id: number;
  title: string;
  slug: string;
  description: string;
  price: number | null;
  currency: string;
  listing_status: string;
  published_at?: string;
  category: Category;
  location?: Location;
  seller: Seller;
  images: ListingImage[];
  job_details?: JobDetail;
  property_details?: PropertyDetail;
  classified_details?: ClassifiedDetail;
  vehicle_details?: VehicleDetail;
  matrimonial_profile?: MatrimonialProfile;
}

export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  errors?: Record<string, string[]>;
  pagination?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface User {
  id: number;
  name: string;
  email: string;
  phone?: string;
  status: string;
  email_verified: boolean;
  roles: string[];
  profile?: {
    avatar?: string;
    bio?: string;
    city?: string;
    country?: string;
  };
}

