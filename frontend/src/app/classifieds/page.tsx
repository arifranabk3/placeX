'use client';

import React, { useState, useMemo } from 'react';
import Link from 'next/link';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

interface ClassifiedItem {
  id: number;
  slug: string;
  title: string;
  description: string;
  price: string;
  location: string;
  city: string;
  type: string;
  condition: string;
  verified: boolean;
  image: string;
}

const ALL_CLASSIFIEDS: ClassifiedItem[] = [
  {
    id: 1,
    slug: 'iphone-15-pro-max',
    title: 'iPhone 15 Pro Max',
    description: 'Brand new, 256GB with box and accessories.',
    price: 'PKR 425,000',
    location: 'Islamabad',
    city: 'Islamabad',
    type: 'mobiles',
    condition: 'New',
    verified: true,
    image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 2,
    slug: 'sofa-set-5-seater',
    title: 'Sofa Set (5 Seater)',
    description: 'Stylish and comfortable sofa set in good condition.',
    price: 'PKR 85,000',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    type: 'furniture',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 3,
    slug: 'nova-refrigerator',
    title: 'Nova Refrigerator',
    description: 'Double door refrigerator, excellent condition.',
    price: 'PKR 55,000',
    location: 'Lahore',
    city: 'Lahore',
    type: 'appliances',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 4,
    slug: 'smart-watch',
    title: 'Smart Watch Series 8',
    description: 'Feature-rich smart watch with ECG and health tracking.',
    price: 'PKR 18,500',
    location: 'Karachi',
    city: 'Karachi',
    type: 'electronics',
    condition: 'New',
    verified: true,
    image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 5,
    slug: 'led-tv-55-inch',
    title: 'LED TV 55 Inch 4K UHD',
    description: '4K Ultra HD smart LED TV with Dolby Audio and Android TV.',
    price: 'PKR 92,000',
    location: 'Islamabad',
    city: 'Islamabad',
    type: 'electronics',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 6,
    slug: 'laptop-core-i7',
    title: 'Dell XPS Core i7 16GB',
    description: 'Fast laptop for work, study, video editing and creative tasks.',
    price: 'PKR 145,000',
    location: 'Lahore',
    city: 'Lahore',
    type: 'electronics',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 7,
    slug: 'dslr-camera-canon',
    title: 'Canon EOS 80D with 18-135mm Lens',
    description: 'Professional camera setup with bag, two batteries, and charger.',
    price: 'PKR 125,000',
    location: 'Islamabad',
    city: 'Islamabad',
    type: 'electronics',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 8,
    slug: 'dining-table-6-chairs',
    title: 'Solid Sheesham Dining Table (6 Chairs)',
    description: 'Pure Sheesham wood dining set with tempered glass top.',
    price: 'PKR 68,000',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    type: 'furniture',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 9,
    slug: 'microwave-oven-inverter',
    title: 'Inverter Grill Microwave Oven 30L',
    description: 'Baking and grilling inverter oven, scratchless condition.',
    price: 'PKR 32,000',
    location: 'Lahore',
    city: 'Lahore',
    type: 'appliances',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1585659722983-3a675dabf23d?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 10,
    slug: 'playstation-5-console',
    title: 'Sony PlayStation 5 Disc Edition + 2 Controllers',
    description: 'Japanese model PS5 with God of War Ragnarok and box.',
    price: 'PKR 155,000',
    location: 'Karachi',
    city: 'Karachi',
    type: 'electronics',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 11,
    slug: 'samsung-galaxy-s24-ultra',
    title: 'Samsung Galaxy S24 Ultra 512GB',
    description: 'Titanium Gray, PTA approved, 10/10 condition with bill.',
    price: 'PKR 380,000',
    location: 'Islamabad',
    city: 'Islamabad',
    type: 'mobiles',
    condition: 'New',
    verified: true,
    image: 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 12,
    slug: 'ergonomic-office-chair',
    title: 'High-Back Mesh Ergonomic Office Chair',
    description: 'Breathable mesh lumbar support chair for long work hours.',
    price: 'PKR 24,000',
    location: 'Lahore',
    city: 'Lahore',
    type: 'furniture',
    condition: 'New',
    verified: true,
    image: 'https://images.unsplash.com/photo-1580481077195-c22822b7f36c?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 13,
    slug: 'automatic-washing-machine',
    title: 'Fully Automatic Inverter Washing Machine 9KG',
    description: 'Energy saver model with diamond drum and child lock.',
    price: 'PKR 64,000',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    type: 'appliances',
    condition: 'Used',
    verified: true,
    image: 'https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 14,
    slug: 'ipad-air-m2',
    title: 'Apple iPad Air M2 11-inch 128GB Wi-Fi',
    description: 'Space Gray color with Apple Pencil Pro compatible.',
    price: 'PKR 175,000',
    location: 'Karachi',
    city: 'Karachi',
    type: 'mobiles',
    condition: 'New',
    verified: true,
    image: 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=900&q=85',
  },
];

export default function ClassifiedsPage() {
  const [selectedTypes, setSelectedTypes] = useState<string[]>([]);
  const [selectedCity, setSelectedCity] = useState('');
  const [keyword, setKeyword] = useState('');
  const [favorites, setFavorites] = useState<number[]>([]);
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 12;

  const toggleFavorite = (id: number) => {
    setFavorites(prev => 
      prev.includes(id) ? prev.filter(fId => fId !== id) : [...prev, id]
    );
  };

  const toggleType = (type: string) => {
    setSelectedTypes(prev => 
      prev.includes(type) ? prev.filter(t => t !== type) : [...prev, type]
    );
    setCurrentPage(1);
  };

  const filteredClassifieds = useMemo(() => {
    return ALL_CLASSIFIEDS.filter(item => {
      if (selectedTypes.length > 0 && !selectedTypes.includes(item.type)) {
        return false;
      }
      if (selectedCity && selectedCity !== 'All Cities' && item.city !== selectedCity) {
        return false;
      }
      if (keyword.trim()) {
        const q = keyword.toLowerCase();
        return (
          item.title.toLowerCase().includes(q) ||
          item.description.toLowerCase().includes(q)
        );
      }
      return true;
    });
  }, [selectedTypes, selectedCity, keyword]);

  const totalPages = Math.ceil(filteredClassifieds.length / itemsPerPage);
  const paginatedClassifieds = filteredClassifieds.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <>
      <Header activeTab="classifieds" />

      {/* Hero Section */}
      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Classifieds
          </div>
          <h1>Buy and Sell Almost Anything</h1>
          <p>Discover great deals on electronics, furniture, home appliances and everyday essentials.</p>
          <form 
            className="inner-search" 
            onSubmit={(e) => { e.preventDefault(); }}
          >
            <input 
              type="search" 
              placeholder="Search classifieds..." 
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

      {/* Main Content */}
      <main className="inner-main container">
        <div className="inner-layout">
          {/* Aside Filters */}
          <aside className="filter-panel">
            <h3><i className="fa-solid fa-sliders"></i> Filters</h3>
            <div className="filter-group">
              <h4>Category / Type</h4>
              <label>
                <input 
                  type="checkbox" 
                  value="mobiles" 
                  checked={selectedTypes.includes('mobiles')}
                  onChange={() => toggleType('mobiles')}
                /> Mobiles
              </label>
              <label>
                <input 
                  type="checkbox" 
                  value="electronics" 
                  checked={selectedTypes.includes('electronics')}
                  onChange={() => toggleType('electronics')}
                /> Electronics
              </label>
              <label>
                <input 
                  type="checkbox" 
                  value="furniture" 
                  checked={selectedTypes.includes('furniture')}
                  onChange={() => toggleType('furniture')}
                /> Furniture
              </label>
              <label>
                <input 
                  type="checkbox" 
                  value="appliances" 
                  checked={selectedTypes.includes('appliances')}
                  onChange={() => toggleType('appliances')}
                /> Appliances
              </label>
            </div>
            <div className="filter-group">
              <h4>Location</h4>
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

          {/* Listings Results */}
          <section>
            <div className="results-top">
              <div>
                <h2>Latest Classifieds</h2>
                <p>Showing {paginatedClassifieds.length} of {filteredClassifieds.length} listings</p>
              </div>
              <select className="sort-select" aria-label="Sort">
                <option>Newest First</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
              </select>
            </div>

            <div className="inner-card-grid">
              {paginatedClassifieds.map((item) => (
                <article key={item.id} className="inner-listing-card">
                  <div className="inner-card-image">
                    <Link href={`/listings/${item.slug}`}>
                      <img loading="lazy" src={item.image} alt={item.title} />
                    </Link>
                    <button 
                      className="favorite" 
                      aria-label="Add to favourites"
                      onClick={() => toggleFavorite(item.id)}
                    >
                      <i className={favorites.includes(item.id) ? "fa-solid fa-heart" : "fa-regular fa-heart"} style={favorites.includes(item.id) ? { color: '#f97316' } : {}}></i>
                    </button>
                  </div>
                  <div className="inner-card-content">
                    <h3>
                      <Link href={`/listings/${item.slug}`}>{item.title}</Link>
                    </h3>
                    <p>{item.description}</p>
                    <div className="card-tags">
                      <span>Verified Listing</span>
                      <span>{item.location}</span>
                    </div>
                    <div className="inner-card-meta">
                      <span><i className="fa-solid fa-location-dot"></i> {item.location}</span>
                      <strong>{item.price}</strong>
                    </div>
                  </div>
                </article>
              ))}
            </div>

            {/* Pagination only shown when total items exceed 12 */}
            {filteredClassifieds.length > itemsPerPage && (
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
