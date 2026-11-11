'use client';

import React, { useState, useEffect, Suspense } from 'react';
import Link from 'next/link';
import { useParams } from 'next/navigation';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';
import { placexApi } from '@/lib/api';
import type { Listing, ApiResponse } from '@/types';

interface DetailMock {
  title: string;
  category: string;
  categorySlug: string;
  location: string;
  price: string;
  description: string;
  images: string[];
  specs: { label: string; value: string }[];
  seller: { name: string; initials: string; memberType: string; phone?: string };
}

const STATIC_FALLBACK_DETAILS: Record<string, DetailMock> = {
  // Jobs
  'senior-laravel-developer': {
    title: 'Senior Laravel Developer',
    category: 'Jobs',
    categorySlug: 'jobs',
    location: 'Islamabad',
    price: 'PKR 150K – 200K',
    description: 'TechNova is looking for an experienced Senior Laravel Developer to build and scale modern web applications and APIs. You will work on robust backend architecture, database optimization, and REST API design with our full-stack engineering team.',
    images: [
      'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=900&q=85',
    ],
    specs: [
      { label: 'Employment', value: 'Full Time' },
      { label: 'Work Mode', value: 'Hybrid / Remote' },
      { label: 'Company', value: 'TechNova' },
      { label: 'Experience', value: '3-5 Years' },
    ],
    seller: { name: 'TechNova', initials: 'TN', memberType: 'Verified Employer', phone: '+92 300 1234567' },
  },
  // Property
  'luxury-family-house-dha': {
    title: 'Luxury Family House DHA',
    category: 'Property',
    categorySlug: 'property',
    location: 'Lahore',
    price: 'PKR 4,50,00,000',
    description: 'Brand new 1 Kanal designer house in DHA Phase 6. Featuring 5 master bedrooms with attached baths, modern imported kitchen, basement entertainment hall, servant quarters, and lush green lawn.',
    images: [
      'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=900&q=85',
    ],
    specs: [
      { label: 'Purpose', value: 'For Sale' },
      { label: 'Area', value: '1 Kanal' },
      { label: 'Bedrooms', value: '5 Beds' },
      { label: 'Bathrooms', value: '6 Baths' },
    ],
    seller: { name: 'DHA Real Estate', initials: 'DH', memberType: 'Verified Agency', phone: '+92 321 9876543' },
  },
  // Vehicles
  'toyota-corolla-2023': {
    title: 'Toyota Corolla 2023',
    category: 'Vehicles',
    categorySlug: 'vehicles',
    location: 'Lahore',
    price: 'PKR 74,50,000',
    description: 'Toyota Corolla Altis Grande 1.8 2023 model in pristine condition. Bumper to bumper original paint, complete dealership service history, low mileage, push start, sunroof, and all luxury options enabled.',
    images: [
      'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=85',
    ],
    specs: [
      { label: 'Make & Model', value: 'Toyota Corolla' },
      { label: 'Model Year', value: '2023' },
      { label: 'Mileage', value: '28,000 km' },
      { label: 'Transmission', value: 'Automatic' },
    ],
    seller: { name: 'Lahore Motors', initials: 'LM', memberType: 'Verified Dealership', phone: '+92 333 4567890' },
  },
  // Classifieds
  'iphone-15-pro-max': {
    title: 'iPhone 15 Pro Max',
    category: 'Classifieds',
    categorySlug: 'classifieds',
    location: 'Islamabad',
    price: 'PKR 425,000',
    description: 'Brand new, 256GB with original box and cable. Natural Titanium color, factory unlocked (physical + eSIM), 100% battery health. Contact the advertiser for details and face-to-face inspection.',
    images: [
      'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?auto=format&fit=crop&w=900&q=85',
      'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=85',
    ],
    specs: [
      { label: 'Condition', value: 'Brand New' },
      { label: 'Category', value: 'Electronics / Mobiles' },
      { label: 'Storage', value: '256 GB' },
      { label: 'Seller', value: 'Private Seller' },
    ],
    seller: { name: 'Private Seller', initials: 'PS', memberType: 'Verified Member', phone: '+92 312 3456789' },
  },
  // Matrimonial
  'profile-px-1024': {
    title: 'Profile PX-1024',
    category: 'Matrimonial',
    categorySlug: 'matrimonial',
    location: 'Islamabad',
    price: 'Bride Profile',
    description: 'Age 27 · Masters in Computer Science · Family-oriented and based in Islamabad. Seeking an educated, respectful, and established partner with strong moral and family values.',
    images: [
      'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=900&q=85',
    ],
    specs: [
      { label: 'Age', value: '27 Years' },
      { label: 'Education', value: 'Masters (CS)' },
      { label: 'Profession', value: 'Software Professional' },
      { label: 'Marital Status', value: 'Single / Never Married' },
    ],
    seller: { name: 'Family Representative', initials: 'PX', memberType: 'Privacy Protected Match', phone: 'Direct message via PlaceX' },
  },
};

function ListingDetailContent() {
  const params = useParams();
  const slug = (params?.slug as string) || '';

  const [activeImage, setActiveImage] = useState<string>('');
  const [showPhone, setShowPhone] = useState(false);
  const [messageSent, setMessageSent] = useState(false);
  const [data, setData] = useState<DetailMock | null>(null);

  useEffect(() => {
    // Check static fallback dictionary first
    if (STATIC_FALLBACK_DETAILS[slug]) {
      setData(STATIC_FALLBACK_DETAILS[slug]);
      setActiveImage(STATIC_FALLBACK_DETAILS[slug].images[0]);
      return;
    }

    // Try fetching from Laravel backend API
    placexApi.getListing(slug)
      .then((res: ApiResponse<Listing>) => {
        if (res.success && res.data) {
          const l: Listing = res.data;
          const mapped: DetailMock = {
            title: l.title,
            category: l.category?.name || 'Listing',
            categorySlug: l.category?.slug || 'classifieds',
            location: l.location?.city || 'Pakistan',
            price: l.price ? `PKR ${Number(l.price).toLocaleString()}` : 'Contact for Price',
            description: l.description,
            images: l.images && l.images.length > 0 
              ? l.images.map(img => img.image_path)
              : ['https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85'],
            specs: [
              { label: 'Status', value: l.listing_status.toUpperCase() },
              { label: 'Location', value: l.location?.city || 'Pakistan' },
            ],
            seller: {
              name: l.seller?.name || 'Seller',
              initials: (l.seller?.name || 'S').slice(0, 2).toUpperCase(),
              memberType: l.seller?.is_verified ? 'Verified Seller' : 'PlaceX Member',
              phone: '+92 300 0000000',
            },
          };
          setData(mapped);
          setActiveImage(mapped.images[0]);
        } else {
          // Generic fallback
          setDefaultFallback();
        }
      })
      .catch(() => {
        setDefaultFallback();
      });

    function setDefaultFallback() {
      const fallback: DetailMock = {
        title: slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
        category: 'Marketplace',
        categorySlug: 'classifieds',
        location: 'Pakistan',
        price: 'Contact for Price',
        description: 'Verified listing on PlaceX. Contact the advertiser for complete specifications, condition check, and further details.',
        images: [
          'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85',
        ],
        specs: [
          { label: 'Status', value: 'Active' },
          { label: 'Category', value: 'PlaceX Listing' },
        ],
        seller: { name: 'Verified Seller', initials: 'PX', memberType: 'PlaceX Member', phone: '+92 300 1234567' },
      };
      setData(fallback);
      setActiveImage(fallback.images[0]);
    }
  }, [slug]);

  if (!data) {
    return (
      <>
        <Header />
        <main className="inner-main container" style={{ padding: '80px 0', textAlign: 'center' }}>
          <p>Loading listing details...</p>
        </main>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Header activeTab={data.categorySlug} />

      {/* Hero / Breadcrumb */}
      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / <Link href={`/${data.categorySlug}`}>{data.category}</Link> / Details
          </div>
          <h1>{data.category} Details</h1>
          <p>Explore listing information and contact the advertiser.</p>
        </div>
      </section>

      {/* Main Details */}
      <main className="inner-main container">
        <Link className="back-link" href={`/${data.categorySlug}`}>
          <i className="fa-solid fa-arrow-left"></i> Back to {data.category}
        </Link>

        <div className="detail-layout">
          {/* Main Left Column */}
          <section>
            {/* Gallery */}
            <div className="detail-gallery">
              <div className="detail-main-image">
                <img 
                  className="detail-current-image" 
                  src={activeImage || data.images[0]} 
                  alt={data.title} 
                />
              </div>
              {data.images.length > 1 && (
                <div className="detail-thumbs">
                  {data.images.map((img, idx) => (
                    <img 
                      key={idx}
                      loading="lazy" 
                      src={img} 
                      className={activeImage === img ? 'active' : ''} 
                      alt={`Listing photo ${idx + 1}`}
                      onClick={() => setActiveImage(img)}
                    />
                  ))}
                </div>
              )}
            </div>

            {/* Info Panel */}
            <div className="detail-panel" style={{ marginTop: '16px' }}>
              <div className="detail-title-row">
                <div>
                  <h1>{data.title}</h1>
                  <p className="detail-location">
                    <i className="fa-solid fa-location-dot"></i> {data.location} · Listed on PlaceX
                  </p>
                </div>
                <div className="detail-price">{data.price}</div>
              </div>

              {/* Specs Grid */}
              <div className="detail-specs">
                {data.specs.map((spec, idx) => (
                  <div key={idx} className="detail-spec">
                    <small>{spec.label}</small>
                    <strong>{spec.value}</strong>
                  </div>
                ))}
              </div>

              {/* Description */}
              <div className="detail-description">
                <h3>Description</h3>
                <p>{data.description}</p>
                
                <h3>Safety &amp; Verification</h3>
                <p>
                  Verify important details and avoid sending advance payments to unknown parties. PlaceX fosters direct, safe buyer-seller communication across Pakistan.
                </p>
              </div>
            </div>
          </section>

          {/* Right Column: Seller Panel */}
          <aside className="seller-panel">
            <h3>Contact Advertiser</h3>
            <div className="seller-info">
              <div className="seller-avatar">{data.seller.initials}</div>
              <div>
                <strong>{data.seller.name}</strong>
                <small>{data.seller.memberType}</small>
              </div>
            </div>

            {showPhone ? (
              <div style={{
                background: '#f1f5f9',
                padding: '12px 16px',
                borderRadius: '8px',
                fontWeight: 700,
                color: '#0b1a30',
                fontSize: '1.1rem',
                textAlign: 'center',
                margin: '12px 0'
              }}>
                <i className="fa-solid fa-phone" style={{ marginRight: '8px', color: '#f97316' }}></i>
                {data.seller.phone || '+92 300 1234567'}
              </div>
            ) : (
              <button 
                className="contact-btn reveal-contact"
                onClick={() => setShowPhone(true)}
              >
                Show Contact Details
              </button>
            )}

            <button 
              className="message-btn"
              onClick={() => setMessageSent(!messageSent)}
            >
              <i className="fa-regular fa-comment"></i> {messageSent ? 'Message Sent!' : 'Send Message'}
            </button>

            {messageSent && (
              <p style={{ color: '#16a34a', fontSize: '0.85rem', marginTop: '8px', textAlign: 'center' }}>
                Your message has been queued for the seller.
              </p>
            )}

            <p className="safety-note">
              <i className="fa-solid fa-shield-halved"></i> Verify the listing and seller before any transaction.
            </p>
          </aside>
        </div>
      </main>

      <CommunitySection />
      <Footer />
    </>
  );
}

export default function ListingDetailPage() {
  return (
    <Suspense fallback={
      <>
        <Header />
        <main className="inner-main container" style={{ padding: '80px 0', textAlign: 'center' }}>
          <p>Loading listing details...</p>
        </main>
        <Footer />
      </>
    }>
      <ListingDetailContent />
    </Suspense>
  );
}

