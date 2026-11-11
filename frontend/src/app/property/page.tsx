'use client';

import React, { useState, useMemo } from 'react';
import Link from 'next/link';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

interface PropertyItem {
  id: number;
  title: string;
  slug: string;
  desc: string;
  location: string;
  price: string;
  type: 'Sale' | 'Rent';
  beds: string;
  image: string;
}

const ALL_PROPERTIES: PropertyItem[] = [
  {
    id: 1,
    title: 'Modern Family House',
    slug: 'modern-family-house-5-marla-bahria-town',
    desc: '5 Marla house in Bahria Town with modern design and amenities.',
    location: 'Rawalpindi',
    price: 'PKR 2.25 Crore',
    type: 'Sale',
    beds: '3',
    image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 2,
    title: 'Luxury Apartment',
    slug: 'luxury-apartment-islamabad',
    desc: '3 Beds luxury apartment in prime sector with modern interior and parking.',
    location: 'Islamabad',
    price: 'PKR 85K / month',
    type: 'Rent',
    beds: '3',
    image: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 3,
    title: '10 Marla Residential Plot',
    slug: '10-marla-residential-plot-lahore',
    desc: 'Ideal plot for home construction in a developed society.',
    location: 'Lahore',
    price: 'PKR 1.1 Crore',
    type: 'Sale',
    beds: 'Plot',
    image: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 4,
    title: 'Commercial Office Space',
    slug: 'commercial-office-space-islamabad',
    desc: 'Office space in commercial business district with elevator and backup power.',
    location: 'Islamabad',
    price: 'PKR 3.5 Crore',
    type: 'Sale',
    beds: 'Commercial',
    image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 5,
    title: '4 Marla House for Rent',
    slug: '4-marla-house-for-rent-rawalpindi',
    desc: 'Peaceful society, water and gas available, ideal for small family.',
    location: 'Rawalpindi',
    price: 'PKR 45K / month',
    type: 'Rent',
    beds: '2',
    image: 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 6,
    title: '1 Kanal Luxury Villa',
    slug: 'luxury-family-house-dha',
    desc: 'Brand new 1 Kanal designer villa in DHA Phase 6 with 5 master bedrooms.',
    location: 'Lahore',
    price: 'PKR 4.5 Crore',
    type: 'Sale',
    beds: '5',
    image: 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 7,
    title: 'Executive Studio Apartment',
    slug: 'studio-apartment-dha-islamabad',
    desc: 'Fully furnished studio apartment with gym and swimming pool access.',
    location: 'Islamabad',
    price: 'PKR 55K / month',
    type: 'Rent',
    beds: 'Studio',
    image: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 8,
    title: 'Corner Plot 1 Kanal',
    slug: 'corner-plot-1-kanal-bahria',
    desc: 'Park facing corner plot in prime block with direct boulevard access.',
    location: 'Rawalpindi',
    price: 'PKR 2.8 Crore',
    type: 'Sale',
    beds: 'Plot',
    image: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 9,
    title: '2 Bed Portion for Rent',
    slug: 'upper-portion-rent-lahore',
    desc: 'Upper portion with separate gate and electricity meter in Model Town.',
    location: 'Lahore',
    price: 'PKR 38K / month',
    type: 'Rent',
    beds: '2',
    image: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 10,
    title: 'Modern Penthouse with Terrace',
    slug: 'penthouse-islamabad-f11',
    desc: 'Panoramic Margalla hills view, private jacuzzi, and smart home automation.',
    location: 'Islamabad',
    price: 'PKR 5.2 Crore',
    type: 'Sale',
    beds: '4',
    image: 'https://images.unsplash.com/photo-1567496898669-ee935f5f647a?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 11,
    title: 'Furnished Farmhouse for Weekend',
    slug: 'farmhouse-bedian-road-lahore',
    desc: '4 Kanal lush green farmhouse with swimming pool on Bedian Road.',
    location: 'Lahore',
    price: 'PKR 65K / day',
    type: 'Rent',
    beds: '4',
    image: 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 12,
    title: 'Commercial Plaza Floor',
    slug: 'commercial-plaza-karachi',
    desc: 'Full floor available for IT software house or multinational corporate office.',
    location: 'Karachi',
    price: 'PKR 4.2 Crore',
    type: 'Sale',
    beds: 'Commercial',
    image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 13,
    title: 'Brand New 7 Marla Triple Story',
    slug: 'triple-story-house-rawalpindi',
    desc: 'Ideal for two rental portions + owner living, solid marble flooring.',
    location: 'Rawalpindi',
    price: 'PKR 2.65 Crore',
    type: 'Sale',
    beds: '5',
    image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=85',
  },
  {
    id: 14,
    title: 'Sea Facing Apartment Clifton',
    slug: 'sea-facing-apartment-clifton-karachi',
    desc: '3 Bed drawing dining with uninterrupted Arabian Sea view in Clifton.',
    location: 'Karachi',
    price: 'PKR 3.8 Crore',
    type: 'Sale',
    beds: '3',
    image: 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=700&q=85',
  },
];

export default function PropertyPage() {
  const [purpose, setPurpose] = useState<'All' | 'Sale' | 'Rent'>('All');
  const [selectedCity, setSelectedCity] = useState('');
  const [keyword, setKeyword] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 12;

  const filteredProperties = useMemo(() => {
    return ALL_PROPERTIES.filter(p => {
      if (purpose !== 'All' && p.type !== purpose) return false;
      if (selectedCity && selectedCity !== 'All Cities' && p.location !== selectedCity) return false;
      if (keyword.trim()) {
        const q = keyword.toLowerCase();
        return p.title.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q);
      }
      return true;
    });
  }, [purpose, selectedCity, keyword]);

  const totalPages = Math.ceil(filteredProperties.length / itemsPerPage);
  const paginatedProperties = filteredProperties.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <>
      <Header activeTab="property" />

      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Property
          </div>
          <h1>Find Your Perfect Space</h1>
          <p>Discover houses, plots, apartments and commercial properties across Pakistan.</p>
          <form className="inner-search" onSubmit={(e) => e.preventDefault()}>
            <input 
              type="search" 
              placeholder="Search by location, project, or property type..." 
              value={keyword}
              onChange={(e) => { setKeyword(e.target.value); setCurrentPage(1); }}
            />
            <select 
              value={selectedCity}
              onChange={(e) => { setSelectedCity(e.target.value); setCurrentPage(1); }}
            >
              <option value="">All Cities</option>
              <option value="Islamabad">Islamabad</option>
              <option value="Rawalpindi">Rawalpindi</option>
              <option value="Lahore">Lahore</option>
              <option value="Karachi">Karachi</option>
            </select>
            <button type="submit">
              <i className="fa-solid fa-magnifying-glass"></i> Search
            </button>
          </form>
        </div>
      </section>

      <main className="inner-main container">
        <div className="inner-layout">
          <aside className="filter-panel">
            <h3>
              <i className="fa-solid fa-sliders"></i> Filters
            </h3>
            <div className="filter-group">
              <h4>Purpose</h4>
              <label>
                <input 
                  type="radio" 
                  name="purpose" 
                  checked={purpose === 'All'} 
                  onChange={() => { setPurpose('All'); setCurrentPage(1); }} 
                /> All Properties
              </label>
              <label>
                <input 
                  type="radio" 
                  name="purpose" 
                  checked={purpose === 'Sale'} 
                  onChange={() => { setPurpose('Sale'); setCurrentPage(1); }} 
                /> For Sale
              </label>
              <label>
                <input 
                  type="radio" 
                  name="purpose" 
                  checked={purpose === 'Rent'} 
                  onChange={() => { setPurpose('Rent'); setCurrentPage(1); }} 
                /> For Rent
              </label>
            </div>
            <div className="filter-group">
              <h4>City</h4>
              <select 
                value={selectedCity}
                onChange={(e) => { setSelectedCity(e.target.value); setCurrentPage(1); }}
              >
                <option value="">All Cities</option>
                <option value="Islamabad">Islamabad</option>
                <option value="Rawalpindi">Rawalpindi</option>
                <option value="Lahore">Lahore</option>
                <option value="Karachi">Karachi</option>
              </select>
            </div>
            <div className="filter-group">
              <h4>Keyword</h4>
              <input 
                type="text" 
                placeholder="Enter keyword" 
                value={keyword}
                onChange={(e) => { setKeyword(e.target.value); setCurrentPage(1); }}
              />
            </div>
          </aside>

          <section>
            <div className="results-top">
              <div>
                <h2>Latest Properties</h2>
                <p>Showing {paginatedProperties.length} of {filteredProperties.length} listings</p>
              </div>
              <select className="sort-select" aria-label="Sort">
                <option>Newest First</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
              </select>
            </div>

            <div className="inner-card-grid">
              {paginatedProperties.map((prop) => (
                <article key={prop.id} className="inner-listing-card">
                  <div className="inner-card-image">
                    <Link href={`/listings/${prop.slug}`}>
                      <img loading="lazy" src={prop.image} alt={prop.title} />
                    </Link>
                    <button className="favorite" aria-label="Add to favourites">
                      <i className="fa-regular fa-heart"></i>
                    </button>
                  </div>
                  <div className="inner-card-content">
                    <h3>
                      <Link href={`/listings/${prop.slug}`}>{prop.title}</Link>
                    </h3>
                    <p>{prop.desc}</p>
                    <div className="card-tags">
                      <span>{prop.type === 'Sale' ? 'For Sale' : 'For Rent'}</span>
                      <span>Verified Property</span>
                    </div>
                    <div className="inner-card-meta">
                      <span>
                        <i className="fa-solid fa-location-dot"></i> {prop.location}
                      </span>
                      <strong>{prop.price}</strong>
                    </div>
                  </div>
                </article>
              ))}
            </div>

            {/* Pagination only shown when total items exceed 12 */}
            {filteredProperties.length > itemsPerPage && (
              <div className="pagination">
                <button 
                  disabled={currentPage === 1}
                  className={currentPage === 1 ? 'disabled' : ''}
                  onClick={() => setCurrentPage(prev => Math.max(prev - 1, 1))}
                >
                  ←
                </button>
                {Array.from({ length: totalPages }, (_, i) => i + 1).map((page) => (
                  <button
                    key={page}
                    className={currentPage === page ? 'active' : ''}
                    onClick={() => setCurrentPage(page)}
                  >
                    {page}
                  </button>
                ))}
                <button 
                  disabled={currentPage === totalPages}
                  className={currentPage === totalPages ? 'disabled' : ''}
                  onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                >
                  →
                </button>
              </div>
            )}
          </section>
        </div>
      </main>

      <CommunitySection />
      <Footer />
    </>
  );
}
