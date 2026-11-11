'use client';

import React, { useState, useMemo } from 'react';
import Link from 'next/link';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

interface MatrimonialProfile {
  id: number;
  slug: string;
  code: string;
  type: 'Bride Profile' | 'Groom Profile';
  age: number;
  education: string;
  profession: string;
  location: string;
  city: string;
  description: string;
  image: string;
}

const ALL_PROFILES: MatrimonialProfile[] = [
  {
    id: 1,
    slug: 'profile-px-1024',
    code: 'Profile PX-1024',
    type: 'Bride Profile',
    age: 27,
    education: 'Masters',
    profession: 'Software Professional',
    location: 'Islamabad',
    city: 'Islamabad',
    description: 'Age 27 · Masters · Professional. Family-oriented and based in Islamabad.',
    image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 2,
    slug: 'profile-px-1038',
    code: 'Profile PX-1038',
    type: 'Groom Profile',
    age: 30,
    education: 'Masters',
    profession: 'Engineer',
    location: 'Lahore',
    city: 'Lahore',
    description: 'Age 30 · Engineer · Masters. Lahore-based professional.',
    image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 3,
    slug: 'profile-px-1051',
    code: 'Profile PX-1051',
    type: 'Bride Profile',
    age: 26,
    education: 'Medical Graduate',
    profession: 'Doctor (MBBS)',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    description: 'Age 26 · Medical Graduate. Based in Rawalpindi.',
    image: 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 4,
    slug: 'profile-px-1062',
    code: 'Profile PX-1062',
    type: 'Groom Profile',
    age: 32,
    education: 'Masters',
    profession: 'Businessman',
    location: 'Karachi',
    city: 'Karachi',
    description: 'Age 32 · Business · Masters. Karachi-based professional.',
    image: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 5,
    slug: 'profile-px-1073',
    code: 'Profile PX-1073',
    type: 'Bride Profile',
    age: 28,
    education: 'Masters in English',
    profession: 'Lecturer / Teacher',
    location: 'Lahore',
    city: 'Lahore',
    description: 'Age 28 · Teacher · Masters. Based in Lahore.',
    image: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 6,
    slug: 'profile-px-1081',
    code: 'Profile PX-1081',
    type: 'Groom Profile',
    age: 29,
    education: 'Masters in CS',
    profession: 'Full-Stack Lead',
    location: 'Islamabad',
    city: 'Islamabad',
    description: 'Age 29 · Software Engineer · Masters. Islamabad.',
    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 7,
    slug: 'profile-px-1092',
    code: 'Profile PX-1092',
    type: 'Bride Profile',
    age: 25,
    education: 'Pharm-D',
    profession: 'Clinical Pharmacist',
    location: 'Islamabad',
    city: 'Islamabad',
    description: 'Age 25 · Doctor of Pharmacy · Practicing in reputable hospital.',
    image: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 8,
    slug: 'profile-px-1105',
    code: 'Profile PX-1105',
    type: 'Groom Profile',
    age: 31,
    education: 'Chartered Accountant (CA)',
    profession: 'Audit Manager',
    location: 'Lahore',
    city: 'Lahore',
    description: 'Age 31 · CA Qualified · Working in Big-4 firm, family background.',
    image: 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 9,
    slug: 'profile-px-1118',
    code: 'Profile PX-1118',
    type: 'Bride Profile',
    age: 29,
    education: 'B.Arch Architecture',
    profession: 'Senior Architect',
    location: 'Karachi',
    city: 'Karachi',
    description: 'Age 29 · Creative architect, well settled and cultured family.',
    image: 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 10,
    slug: 'profile-px-1127',
    code: 'Profile PX-1127',
    type: 'Groom Profile',
    age: 33,
    education: 'MBA Marketing',
    profession: 'Brand Director',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    description: 'Age 33 · FMCG Marketing Director, home in Bahria Town.',
    image: 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 11,
    slug: 'profile-px-1134',
    code: 'Profile PX-1134',
    type: 'Bride Profile',
    age: 26,
    education: 'BDS Dental Surgeon',
    profession: 'Dental Surgeon',
    location: 'Lahore',
    city: 'Lahore',
    description: 'Age 26 · Practicing dentist with own clinic setup in DHA.',
    image: 'https://images.unsplash.com/photo-1548142813-c348350df52b?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 12,
    slug: 'profile-px-1149',
    code: 'Profile PX-1149',
    type: 'Groom Profile',
    age: 28,
    education: 'B.Sc Civil Engineering',
    profession: 'Project Engineer',
    location: 'Islamabad',
    city: 'Islamabad',
    description: 'Age 28 · Government contract engineer, religious and modern values.',
    image: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 13,
    slug: 'profile-px-1158',
    code: 'Profile PX-1158',
    type: 'Bride Profile',
    age: 27,
    education: 'M.Sc Clinical Psychology',
    profession: 'Psychologist & Counselor',
    location: 'Rawalpindi',
    city: 'Rawalpindi',
    description: 'Age 27 · Warm, caring and educated personality.',
    image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 14,
    slug: 'profile-px-1166',
    code: 'Profile PX-1166',
    type: 'Groom Profile',
    age: 30,
    education: 'MS Data Science',
    profession: 'AI Specialist',
    location: 'Lahore',
    city: 'Lahore',
    description: 'Age 30 · Tech professional working with US clients.',
    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=900&q=85',
  },
];

export default function MatrimonialPage() {
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

  const toggleType = (t: string) => {
    setSelectedTypes(prev => 
      prev.includes(t) ? prev.filter(item => item !== t) : [...prev, t]
    );
    setCurrentPage(1);
  };

  const filteredProfiles = useMemo(() => {
    return ALL_PROFILES.filter(p => {
      if (selectedTypes.includes('bride') && p.type !== 'Bride Profile') return false;
      if (selectedTypes.includes('groom') && p.type !== 'Groom Profile') return false;
      if (selectedTypes.includes('age-20-30') && (p.age < 20 || p.age > 30)) return false;
      if (selectedTypes.includes('age-30-40') && (p.age < 30 || p.age > 40)) return false;

      if (selectedCity && selectedCity !== 'All Cities' && p.city !== selectedCity) {
        return false;
      }
      if (keyword.trim()) {
        const q = keyword.toLowerCase();
        return (
          p.code.toLowerCase().includes(q) ||
          p.description.toLowerCase().includes(q) ||
          p.profession.toLowerCase().includes(q)
        );
      }
      return true;
    });
  }, [selectedTypes, selectedCity, keyword]);

  const totalPages = Math.ceil(filteredProfiles.length / itemsPerPage);
  const paginatedProfiles = filteredProfiles.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <>
      <Header activeTab="matrimonial" />

      {/* Hero Section */}
      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Matrimonial
          </div>
          <h1>Meet Someone Who Shares Your Values</h1>
          <p>Explore respectful, privacy-conscious matrimonial profiles and find a compatible life partner.</p>
          <form 
            className="inner-search" 
            onSubmit={(e) => { e.preventDefault(); }}
          >
            <input 
              type="search" 
              placeholder="Search matrimonial..." 
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
          {/* Aside Filter */}
          <aside className="filter-panel">
            <h3><i className="fa-solid fa-sliders"></i> Filters</h3>
            <div className="filter-group">
              <h4>Profile Type</h4>
              <label>
                <input 
                  type="checkbox" 
                  checked={selectedTypes.includes('bride')}
                  onChange={() => toggleType('bride')}
                /> Bride Profiles
              </label>
              <label>
                <input 
                  type="checkbox" 
                  checked={selectedTypes.includes('groom')}
                  onChange={() => toggleType('groom')}
                /> Groom Profiles
              </label>
              <label>
                <input 
                  type="checkbox" 
                  checked={selectedTypes.includes('age-20-30')}
                  onChange={() => toggleType('age-20-30')}
                /> Age 20–30
              </label>
              <label>
                <input 
                  type="checkbox" 
                  checked={selectedTypes.includes('age-30-40')}
                  onChange={() => toggleType('age-30-40')}
                /> Age 30–40
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

          {/* Results Grid */}
          <section>
            <div className="results-top">
              <div>
                <h2>Latest Matrimonial</h2>
                <p>Showing {paginatedProfiles.length} of {filteredProfiles.length} listings</p>
              </div>
              <select className="sort-select" aria-label="Sort">
                <option>Newest First</option>
                <option>Verified First</option>
              </select>
            </div>

            <div className="inner-card-grid">
              {paginatedProfiles.map((profile) => (
                <article key={profile.id} className="inner-listing-card">
                  <div className="inner-card-image">
                    <Link href={`/listings/${profile.slug}`}>
                      <img loading="lazy" src={profile.image} alt={profile.code} />
                    </Link>
                    <button 
                      className="favorite" 
                      aria-label="Add to favourites"
                      onClick={() => toggleFavorite(profile.id)}
                    >
                      <i className={favorites.includes(profile.id) ? "fa-solid fa-heart" : "fa-regular fa-heart"} style={favorites.includes(profile.id) ? { color: '#f97316' } : {}}></i>
                    </button>
                  </div>
                  <div className="inner-card-content">
                    <h3>
                      <Link href={`/listings/${profile.slug}`}>{profile.code}</Link>
                    </h3>
                    <p>{profile.description}</p>
                    <div className="card-tags">
                      <span>Privacy Protected</span>
                      <span>{profile.location}</span>
                    </div>
                    <div className="inner-card-meta">
                      <span><i className="fa-solid fa-location-dot"></i> {profile.location}</span>
                      <strong>{profile.type}</strong>
                    </div>
                  </div>
                </article>
              ))}
            </div>

            {/* Pagination only shown when total items exceed 12 */}
            {filteredProfiles.length > itemsPerPage && (
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
