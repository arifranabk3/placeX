'use client';

import React, { useState, useMemo } from 'react';
import Link from 'next/link';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

interface ServiceItem {
  id: number;
  slug: string;
  title: string;
  description: string;
  price: string;
  location: string;
  city: string;
  type: string;
  provider: string;
  rating: number;
  reviewsCount: number;
  verified: boolean;
  image: string;
}

const ALL_SERVICES: ServiceItem[] = [
  {
    id: 1,
    slug: 'home-appliance-repair-maintenance',
    title: 'Home Appliance Repair & Maintenance',
    description: 'Expert repair services for AC, Refrigerator, Washing Machine, and Microwave Oven.',
    price: 'PKR 1,500 / visit',
    location: 'Islamabad',
    city: 'Islamabad',
    type: 'Home Maintenance',
    provider: 'FastFix Solutions',
    rating: 4.9,
    reviewsCount: 142,
    verified: true,
    image: 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 2,
    slug: 'professional-interior-architecture-design',
    title: 'Professional Interior & Architecture Design',
    description: 'Turnkey interior design, 3D modeling, and architectural planning for homes and offices.',
    price: 'PKR 45,000 / project',
    location: 'Lahore',
    city: 'Lahore',
    type: 'Design & Construction',
    provider: 'Studio Nexus',
    rating: 5.0,
    reviewsCount: 89,
    verified: true,
    image: 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 3,
    slug: 'commercial-residential-cleaning-services',
    title: 'Commercial & Deep Home Cleaning',
    description: 'Complete disinfection, sofa & carpet shampooing, water tank cleaning, and fumigation.',
    price: 'PKR 5,000 / session',
    location: 'Karachi',
    city: 'Karachi',
    type: 'Cleaning & Care',
    provider: 'Sparkle Cleaners',
    rating: 4.8,
    reviewsCount: 215,
    verified: true,
    image: 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 4,
    slug: 'web-mobile-app-development-services',
    title: 'Web & Mobile App Development',
    description: 'Full-stack software development, custom ERPs, mobile applications, and cloud architecture.',
    price: 'PKR 80,000 / project',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    type: 'IT & Digital Services',
    provider: 'CodeCraft Technologies',
    rating: 4.9,
    reviewsCount: 64,
    verified: true,
    image: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 5,
    slug: 'legal-corporate-consultancy-tax-advisory',
    title: 'Corporate Legal & Tax Advisory',
    description: 'Company registration, NTN filing, trademark registration, and commercial legal contracts.',
    price: 'PKR 10,000 / consult',
    location: 'Islamabad',
    city: 'Islamabad',
    type: 'Legal & Finance',
    provider: 'Apex Legal Partners',
    rating: 4.7,
    reviewsCount: 53,
    verified: true,
    image: 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 6,
    slug: 'solar-panel-installation-electrical-services',
    title: 'Solar System Installation & Engineering',
    description: 'Certified on-grid and hybrid solar power solutions with Net Metering support.',
    price: 'PKR 25,000 / installation',
    location: 'Faisalabad',
    city: 'Faisalabad',
    type: 'Home Maintenance',
    provider: 'EcoPower Energy',
    rating: 4.9,
    reviewsCount: 98,
    verified: true,
    image: 'https://images.unsplash.com/photo-1508873696983-2df57046475a?auto=format&fit=crop&w=900&q=85',
  },
];

export default function ServicesPage() {
  const [selectedCity, setSelectedCity] = useState('');
  const [selectedType, setSelectedType] = useState('');
  const [searchKeyword, setSearchKeyword] = useState('');

  const filteredServices = useMemo(() => {
    return ALL_SERVICES.filter((item) => {
      if (selectedCity && item.city !== selectedCity) return false;
      if (selectedType && item.type !== selectedType) return false;
      if (searchKeyword.trim()) {
        const query = searchKeyword.toLowerCase();
        const matches =
          item.title.toLowerCase().includes(query) ||
          item.description.toLowerCase().includes(query) ||
          item.provider.toLowerCase().includes(query);
        if (!matches) return false;
      }
      return true;
    });
  }, [selectedCity, selectedType, searchKeyword]);

  return (
    <>
      <Header activeTab="services" />

      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Services
          </div>
          <h1>Explore Professional Services</h1>
          <p>
            Connect with verified service providers, technicians, creative experts, and corporate professionals.
          </p>
          <form className="inner-search" onSubmit={(e) => e.preventDefault()}>
            <input
              type="search"
              placeholder="Search service, company or keyword (e.g. AC Repair, Cleaning)..."
              value={searchKeyword}
              onChange={(e) => setSearchKeyword(e.target.value)}
            />
            <select
              value={selectedCity}
              onChange={(e) => setSelectedCity(e.target.value)}
            >
              <option value="">All Cities</option>
              <option value="Islamabad">Islamabad</option>
              <option value="Rawalpindi">Rawalpindi</option>
              <option value="Lahore">Lahore</option>
              <option value="Karachi">Karachi</option>
              <option value="Faisalabad">Faisalabad</option>
            </select>
            <button type="submit">
              <i className="fa-solid fa-magnifying-glass"></i> Search
            </button>
          </form>
        </div>
      </section>

      <main className="listing-main">
        <div className="container">
          <div className="section-heading">
            <div style={{ display: 'flex', alignItems: 'center', gap: '10px', flexWrap: 'wrap' }}>
              <h2>Featured Services ({filteredServices.length})</h2>
              <div className="category-pills" style={{ display: 'inline-flex', gap: '6px', marginLeft: '12px' }}>
                {['All', 'Home Maintenance', 'Design & Construction', 'Cleaning & Care', 'IT & Digital Services', 'Legal & Finance'].map((type) => (
                  <button
                    key={type}
                    type="button"
                    onClick={() => setSelectedType(type === 'All' ? '' : type)}
                    style={{
                      border: '0',
                      borderRadius: '20px',
                      padding: '5px 12px',
                      fontSize: '11px',
                      fontWeight: 700,
                      cursor: 'pointer',
                      background: (type === 'All' && !selectedType) || selectedType === type ? 'var(--orange)' : '#f1f5f9',
                      color: (type === 'All' && !selectedType) || selectedType === type ? '#fff' : '#475569',
                      transition: 'all 0.2s ease',
                    }}
                  >
                    {type}
                  </button>
                ))}
              </div>
            </div>
            <Link href="/post?category=services">+ Offer a Service</Link>
          </div>

          <div className="listing-grid">
            {filteredServices.map((service) => (
              <article key={service.id} className="listing-card">
                <div className="card-image">
                  <img src={service.image} alt={service.title} loading="lazy" />
                  <span className="card-badge">{service.type}</span>
                </div>
                <div className="card-body">
                  <div className="card-meta">
                    <strong>{service.price}</strong>
                    <span>
                      <i className="fa-solid fa-star" style={{ color: '#ffb400' }}></i> {service.rating} ({service.reviewsCount})
                    </span>
                  </div>
                  <h3>{service.title}</h3>
                  <p>{service.description}</p>
                  <div className="card-footer" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginTop: 'auto', paddingTop: '8px', borderTop: '1px solid #f1f5f9' }}>
                    <span style={{ fontSize: '11px', color: '#64748b', display: 'flex', alignItems: 'center', gap: '4px' }}>
                      <i className="fa-solid fa-location-dot"></i> {service.location}
                    </span>
                    <span style={{ color: 'var(--orange)', fontWeight: 700, fontSize: '11px' }}>
                      {service.provider}
                    </span>
                  </div>
                </div>
              </article>
            ))}
          </div>

          {filteredServices.length === 0 && (
            <div style={{ textAlign: 'center', padding: '60px 20px', color: '#637386' }}>
              <i className="fa-solid fa-briefcase" style={{ fontSize: '40px', marginBottom: '14px', color: '#8898aa' }}></i>
              <h3 style={{ fontSize: '18px', margin: '0 0 8px', color: '#101b28' }}>No services found</h3>
              <p style={{ fontSize: '13px', margin: 0 }}>Try adjusting your search keyword or city filter.</p>
            </div>
          )}
        </div>
      </main>

      <CommunitySection />
      <Footer />
    </>
  );
}
