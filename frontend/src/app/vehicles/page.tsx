'use client';

import React, { useState, useMemo } from 'react';
import Link from 'next/link';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

interface VehicleItem {
  id: number;
  slug: string;
  title: string;
  description: string;
  priceFormatted: string;
  price: number;
  location: string;
  registeredIn: string;
  make: string;
  model: string;
  year: number;
  km: number;
  transmission: string;
  body: string;
  fuel: string;
  cc: number;
  assembly: string;
  seller: string;
  verified: boolean;
  featured: boolean;
  image: string;
}

const ALL_VEHICLES: VehicleItem[] = [
  {
    id: 1,
    slug: 'toyota-corolla-2023',
    title: 'Toyota Corolla Altis Grande 2023',
    description: '2023 model, low mileage and immaculate bumper-to-bumper condition.',
    priceFormatted: 'PKR 74,50,000',
    price: 7450000,
    location: 'Lahore',
    registeredIn: 'Lahore',
    make: 'Toyota',
    model: 'Corolla',
    year: 2023,
    km: 28000,
    transmission: 'Automatic',
    body: 'Sedan',
    fuel: 'Petrol',
    cc: 1800,
    assembly: 'Local',
    seller: 'Dealer',
    verified: true,
    featured: true,
    image: 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 2,
    slug: 'honda-civic-2021',
    title: 'Honda Civic Oriel 1.8 2021',
    description: 'Clean car, single owner, dealership maintained with complete service history.',
    priceFormatted: 'PKR 68,50,000',
    price: 6850000,
    location: 'Islamabad',
    registeredIn: 'Islamabad',
    make: 'Honda',
    model: 'Civic',
    year: 2021,
    km: 42000,
    transmission: 'Automatic',
    body: 'Sedan',
    fuel: 'Petrol',
    cc: 1800,
    assembly: 'Local',
    seller: 'Owner',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 3,
    slug: 'kia-sportage-2023',
    title: 'Kia Sportage AWD 2023',
    description: '2023 model, panoramic sunroof, full luxury options and showroom condition.',
    priceFormatted: 'PKR 89,00,000',
    price: 8900000,
    location: 'Karachi',
    registeredIn: 'Karachi',
    make: 'Kia',
    model: 'Sportage',
    year: 2023,
    km: 18000,
    transmission: 'Automatic',
    body: 'SUV',
    fuel: 'Petrol',
    cc: 2000,
    assembly: 'Local',
    seller: 'Dealer',
    verified: true,
    featured: true,
    image: 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 4,
    slug: 'suzuki-swift-2022',
    title: 'Suzuki Swift GLX CVT 2022',
    description: 'Neat and clean, push start, excellent fuel economy, family driven.',
    priceFormatted: 'PKR 42,50,000',
    price: 4250000,
    location: 'Rawalpindi',
    registeredIn: 'Rawalpindi',
    make: 'Suzuki',
    model: 'Swift',
    year: 2022,
    km: 25000,
    transmission: 'Automatic',
    body: 'Hatchback',
    fuel: 'Petrol',
    cc: 1200,
    assembly: 'Local',
    seller: 'Owner',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 5,
    slug: 'honda-city-2020',
    title: 'Honda City 1.5 Aspire 2020',
    description: 'Good condition, original paint, alloy rims, neat interior and low mileage.',
    priceFormatted: 'PKR 34,00,000',
    price: 3400000,
    location: 'Lahore',
    registeredIn: 'Lahore',
    make: 'Honda',
    model: 'City',
    year: 2020,
    km: 56000,
    transmission: 'Automatic',
    body: 'Sedan',
    fuel: 'Petrol',
    cc: 1500,
    assembly: 'Local',
    seller: 'Dealer',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 6,
    slug: 'hyundai-tucson-2022',
    title: 'Hyundai Tucson AWD 2022',
    description: 'Well maintained crossover SUV with complete original file and smart card.',
    priceFormatted: 'PKR 76,00,000',
    price: 7600000,
    location: 'Islamabad',
    registeredIn: 'Islamabad',
    make: 'Hyundai',
    model: 'Tucson',
    year: 2022,
    km: 30000,
    transmission: 'Automatic',
    body: 'SUV',
    fuel: 'Petrol',
    cc: 2000,
    assembly: 'Imported',
    seller: 'Dealer',
    verified: true,
    featured: true,
    image: 'https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 7,
    slug: 'toyota-yaris-2021',
    title: 'Toyota Yaris ATIV X 1.5 CVT 2021',
    description: 'Superb fuel average, eco mode, airbags, immaculate suspension and tires.',
    priceFormatted: 'PKR 45,50,000',
    price: 4550000,
    location: 'Islamabad',
    registeredIn: 'Islamabad',
    make: 'Toyota',
    model: 'Corolla',
    year: 2021,
    km: 35000,
    transmission: 'Automatic',
    body: 'Sedan',
    fuel: 'Petrol',
    cc: 1500,
    assembly: 'Local',
    seller: 'Owner',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 8,
    slug: 'suzuki-alto-vxl-2023',
    title: 'Suzuki Alto VXL AGS 2023',
    description: 'Air conditioned, ABS brakes, retractable mirrors, very economical city commute.',
    priceFormatted: 'PKR 28,50,000',
    price: 2850000,
    location: 'Lahore',
    registeredIn: 'Lahore',
    make: 'Suzuki',
    model: 'Swift',
    year: 2023,
    km: 14000,
    transmission: 'Automatic',
    body: 'Hatchback',
    fuel: 'Petrol',
    cc: 660,
    assembly: 'Local',
    seller: 'Owner',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 9,
    slug: 'toyota-fortuner-sigma-2022',
    title: 'Toyota Fortuner Sigma 4 Diesel 2022',
    description: '4x4 beast with leather seats, paddle shifters, power tailgate and push start.',
    priceFormatted: 'PKR 1,65,00,000',
    price: 16500000,
    location: 'Karachi',
    registeredIn: 'Karachi',
    make: 'Toyota',
    model: 'Corolla',
    year: 2022,
    km: 32000,
    transmission: 'Automatic',
    body: 'SUV',
    fuel: 'Diesel',
    cc: 2800,
    assembly: 'Local',
    seller: 'Dealer',
    verified: true,
    featured: true,
    image: 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 10,
    slug: 'mg-hs-exclusive-2022',
    title: 'MG HS 1.5 Turbo Exclusive 2022',
    description: 'Red leather interior, trophy edition styling, lane assist, adaptive cruise.',
    priceFormatted: 'PKR 64,00,000',
    price: 6400000,
    location: 'Rawalpindi',
    registeredIn: 'Islamabad',
    make: 'Kia',
    model: 'Sportage',
    year: 2022,
    km: 26000,
    transmission: 'Automatic',
    body: 'SUV',
    fuel: 'Petrol',
    cc: 1500,
    assembly: 'Imported',
    seller: 'Owner',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 11,
    slug: 'changan-alsvin-lumiere-2023',
    title: 'Changan Alsvin 1.5 Lumiere DCT 2023',
    description: 'Sunroof, cruise control, leatherette seats, genuine low mileage.',
    priceFormatted: 'PKR 39,50,000',
    price: 3950000,
    location: 'Lahore',
    registeredIn: 'Lahore',
    make: 'Hyundai',
    model: 'City',
    year: 2023,
    km: 19000,
    transmission: 'Automatic',
    body: 'Sedan',
    fuel: 'Petrol',
    cc: 1500,
    assembly: 'Local',
    seller: 'Dealer',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1550355291-bbee04a92027?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 12,
    slug: 'honda-brv-s-2021',
    title: 'Honda BR-V i-VTEC S 7-Seater 2021',
    description: 'Spacious 7 seater family crossover with roof rails and rear AC vents.',
    priceFormatted: 'PKR 46,00,000',
    price: 4600000,
    location: 'Islamabad',
    registeredIn: 'Islamabad',
    make: 'Honda',
    model: 'Civic',
    year: 2021,
    km: 48000,
    transmission: 'Automatic',
    body: 'SUV',
    fuel: 'Petrol',
    cc: 1500,
    assembly: 'Local',
    seller: 'Owner',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 13,
    slug: 'kia-picanto-at-2022',
    title: 'Kia Picanto 1.0 Automatic 2022',
    description: 'Compact automatic hatchback, ideal for lady drive, original paint.',
    priceFormatted: 'PKR 33,50,000',
    price: 3350000,
    location: 'Karachi',
    registeredIn: 'Karachi',
    make: 'Kia',
    model: 'Swift',
    year: 2022,
    km: 22000,
    transmission: 'Automatic',
    body: 'Hatchback',
    fuel: 'Petrol',
    cc: 1000,
    assembly: 'Local',
    seller: 'Dealer',
    verified: true,
    featured: false,
    image: 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=900&q=85',
  },
  {
    id: 14,
    slug: 'toyota-prius-hybrid-2020',
    title: 'Toyota Prius S 1.8 Hybrid 2020',
    description: 'Japanese imported hybrid delivering 24+ km/L fuel average.',
    priceFormatted: 'PKR 71,00,000',
    price: 7100000,
    location: 'Lahore',
    registeredIn: 'Lahore',
    make: 'Toyota',
    model: 'Corolla',
    year: 2020,
    km: 45000,
    transmission: 'Automatic',
    body: 'Sedan',
    fuel: 'Hybrid',
    cc: 1800,
    assembly: 'Imported',
    seller: 'Dealer',
    verified: true,
    featured: true,
    image: 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=900&q=85',
  },
];

export default function VehiclesPage() {
  const [collapsedSections, setCollapsedSections] = useState<Record<string, boolean>>({});

  const [keyword, setKeyword] = useState('');
  const [city, setCity] = useState('');
  const [registration, setRegistration] = useState('');
  const [make, setMake] = useState('');
  const [model, setModel] = useState('');
  const [minPrice, setMinPrice] = useState('');
  const [maxPrice, setMaxPrice] = useState('');
  const [minYear, setMinYear] = useState('');
  const [maxYear, setMaxYear] = useState('');
  const [minKm, setMinKm] = useState('');
  const [maxKm, setMaxKm] = useState('');
  const [minCc, setMinCc] = useState('');
  const [maxCc, setMaxCc] = useState('');
  const [transmissions, setTransmissions] = useState<string[]>([]);
  const [bodies, setBodies] = useState<string[]>([]);
  const [fuels, setFuels] = useState<string[]>([]);
  const [assemblies, setAssemblies] = useState<string[]>([]);
  const [sellers, setSellers] = useState<string[]>([]);
  const [adProps, setAdProps] = useState<string[]>([]);
  
  const [sortBy, setSortBy] = useState('newest');
  const [favorites, setFavorites] = useState<number[]>([]);
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 12;

  const toggleSection = (section: string) => {
    setCollapsedSections(prev => ({ ...prev, [section]: !prev[section] }));
  };

  const toggleCheckbox = (list: string[], setList: React.Dispatch<React.SetStateAction<string[]>>, val: string) => {
    setList(list.includes(val) ? list.filter(item => item !== val) : [...list, val]);
    setCurrentPage(1);
  };

  const toggleFavorite = (id: number) => {
    setFavorites(prev => 
      prev.includes(id) ? prev.filter(fId => fId !== id) : [...prev, id]
    );
  };

  const handleReset = () => {
    setKeyword('');
    setCity('');
    setRegistration('');
    setMake('');
    setModel('');
    setMinPrice('');
    setMaxPrice('');
    setMinYear('');
    setMaxYear('');
    setMinKm('');
    setMaxKm('');
    setMinCc('');
    setMaxCc('');
    setTransmissions([]);
    setBodies([]);
    setFuels([]);
    setAssemblies([]);
    setSellers([]);
    setAdProps([]);
    setCurrentPage(1);
  };

  const filteredVehicles = useMemo(() => {
    return ALL_VEHICLES.filter(v => {
      const q = keyword.trim().toLowerCase();
      if (q && !(
        v.title.toLowerCase().includes(q) ||
        v.description.toLowerCase().includes(q) ||
        v.make.toLowerCase().includes(q) ||
        v.model.toLowerCase().includes(q)
      )) {
        return false;
      }
      if (city && v.location.toLowerCase() !== city.toLowerCase()) return false;
      if (registration && v.registeredIn.toLowerCase() !== registration.toLowerCase()) return false;
      if (make && v.make.toLowerCase() !== make.toLowerCase()) return false;
      if (model && v.model.toLowerCase() !== model.toLowerCase()) return false;

      const pMin = Number(minPrice) || 0;
      const pMax = Number(maxPrice) || Infinity;
      if (v.price < pMin || v.price > pMax) return false;

      const yMin = Number(minYear) || 0;
      const yMax = Number(maxYear) || 9999;
      if (v.year < yMin || v.year > yMax) return false;

      const kMin = Number(minKm) || 0;
      const kMax = Number(maxKm) || Infinity;
      if (v.km < kMin || v.km > kMax) return false;

      const cMin = Number(minCc) || 0;
      const cMax = Number(maxCc) || Infinity;
      if (v.cc < cMin || v.cc > cMax) return false;

      if (transmissions.length && !transmissions.includes(v.transmission)) return false;
      if (bodies.length && !bodies.includes(v.body)) return false;
      if (fuels.length && !fuels.includes(v.fuel)) return false;
      if (assemblies.length && !assemblies.includes(v.assembly)) return false;
      if (sellers.length && !sellers.includes(v.seller)) return false;

      if (adProps.includes('verified') && !v.verified) return false;
      if (adProps.includes('featured') && !v.featured) return false;
      if (adProps.includes('photos') && !v.image) return false;

      return true;
    }).sort((a, b) => {
      if (sortBy === 'price-low') return a.price - b.price;
      if (sortBy === 'price-high') return b.price - a.price;
      if (sortBy === 'year') return b.year - a.year;
      return b.id - a.id;
    });
  }, [
    keyword, city, registration, make, model, minPrice, maxPrice,
    minYear, maxYear, minKm, maxKm, minCc, maxCc, transmissions,
    bodies, fuels, assemblies, sellers, adProps, sortBy
  ]);

  const totalPages = Math.ceil(filteredVehicles.length / itemsPerPage);
  const paginatedVehicles = filteredVehicles.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <>
      <Header activeTab="vehicles" />

      {/* Hero Section */}
      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Vehicles
          </div>
          <h1>Find Your Next Vehicle</h1>
          <p>Explore cars and other vehicles from private sellers and verified dealerships.</p>
          <form 
            className="inner-search" 
            onSubmit={(e) => { e.preventDefault(); }}
          >
            <input 
              type="search" 
              placeholder="Search vehicles..." 
              value={keyword}
              onChange={(e) => { setKeyword(e.target.value); setCurrentPage(1); }}
            />
            <select 
              value={city}
              onChange={(e) => { setCity(e.target.value); setCurrentPage(1); }}
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
          {/* PakWheels-Style Multi-Section Filter Panel */}
          <aside className="filter-panel vehicle-filter-panel">
            <div className="vehicle-filter-head">
              <div>
                <h3><i className="fa-solid fa-sliders"></i> Refine Your Search</h3>
                <p>Find the right car with detailed filters</p>
              </div>
              <button type="button" className="vehicle-reset" onClick={handleReset}>
                Reset
              </button>
            </div>

            <div className="vehicle-filter-search">
              <label htmlFor="vehicle-keyword">Search by keyword</label>
              <div className="vehicle-keyword-wrap">
                <i className="fa-solid fa-magnifying-glass"></i>
                <input 
                  id="vehicle-keyword" 
                  type="search" 
                  placeholder="Make, model or variant"
                  value={keyword}
                  onChange={(e) => { setKeyword(e.target.value); setCurrentPage(1); }}
                />
              </div>
            </div>

            {/* 1. Location */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['location']}
                onClick={() => toggleSection('location')}
              >
                Location <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content ${collapsedSections['location'] ? 'is-collapsed' : ''}`}>
                <label className="vehicle-field-label" htmlFor="vehicle-city">City</label>
                <select 
                  id="vehicle-city" 
                  className="vehicle-filter-select"
                  value={city}
                  onChange={(e) => { setCity(e.target.value); setCurrentPage(1); }}
                >
                  <option value="">All Pakistan</option>
                  <option value="Islamabad">Islamabad</option>
                  <option value="Rawalpindi">Rawalpindi</option>
                  <option value="Lahore">Lahore</option>
                  <option value="Karachi">Karachi</option>
                </select>
                <label className="vehicle-field-label" htmlFor="vehicle-registration">Registered in</label>
                <select 
                  id="vehicle-registration" 
                  className="vehicle-filter-select"
                  value={registration}
                  onChange={(e) => { setRegistration(e.target.value); setCurrentPage(1); }}
                >
                  <option value="">Any city</option>
                  <option value="Islamabad">Islamabad</option>
                  <option value="Rawalpindi">Rawalpindi</option>
                  <option value="Lahore">Lahore</option>
                  <option value="Karachi">Karachi</option>
                </select>
              </div>
            </section>

            {/* 2. Make & Model */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['makemodel']}
                onClick={() => toggleSection('makemodel')}
              >
                Make &amp; Model <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content ${collapsedSections['makemodel'] ? 'is-collapsed' : ''}`}>
                <label className="vehicle-field-label" htmlFor="vehicle-make">Make</label>
                <select 
                  id="vehicle-make" 
                  className="vehicle-filter-select"
                  value={make}
                  onChange={(e) => { setMake(e.target.value); setCurrentPage(1); }}
                >
                  <option value="">Any Make</option>
                  <option value="Toyota">Toyota</option>
                  <option value="Honda">Honda</option>
                  <option value="Kia">Kia</option>
                  <option value="Suzuki">Suzuki</option>
                  <option value="Hyundai">Hyundai</option>
                </select>
                <label className="vehicle-field-label" htmlFor="vehicle-model">Model</label>
                <select 
                  id="vehicle-model" 
                  className="vehicle-filter-select"
                  value={model}
                  onChange={(e) => { setModel(e.target.value); setCurrentPage(1); }}
                >
                  <option value="">Any Model</option>
                  <option value="Corolla">Corolla</option>
                  <option value="Civic">Civic</option>
                  <option value="Sportage">Sportage</option>
                  <option value="Swift">Swift</option>
                  <option value="City">City</option>
                  <option value="Tucson">Tucson</option>
                </select>
              </div>
            </section>

            {/* 3. Price Range (PKR) */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['price']}
                onClick={() => toggleSection('price')}
              >
                Price Range (PKR) <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content ${collapsedSections['price'] ? 'is-collapsed' : ''}`}>
                <div className="vehicle-range-row">
                  <input 
                    id="vehicle-price-min" 
                    type="number" 
                    min="0" 
                    placeholder="Min price"
                    value={minPrice}
                    onChange={(e) => { setMinPrice(e.target.value); setCurrentPage(1); }}
                  />
                  <span>to</span>
                  <input 
                    id="vehicle-price-max" 
                    type="number" 
                    min="0" 
                    placeholder="Max price"
                    value={maxPrice}
                    onChange={(e) => { setMaxPrice(e.target.value); setCurrentPage(1); }}
                  />
                </div>
                <div className="vehicle-quick-options">
                  <button 
                    type="button" 
                    onClick={() => { setMinPrice(''); setMaxPrice('3000000'); setCurrentPage(1); }}
                  >
                    Under 30 lacs
                  </button>
                  <button 
                    type="button" 
                    onClick={() => { setMinPrice('3000000'); setMaxPrice('6000000'); setCurrentPage(1); }}
                  >
                    30–60 lacs
                  </button>
                  <button 
                    type="button" 
                    onClick={() => { setMinPrice('6000000'); setMaxPrice(''); setCurrentPage(1); }}
                  >
                    60+ lacs
                  </button>
                </div>
              </div>
            </section>

            {/* 4. Model Year */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['year']}
                onClick={() => toggleSection('year')}
              >
                Model Year <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content ${collapsedSections['year'] ? 'is-collapsed' : ''}`}>
                <div className="vehicle-range-row">
                  <select 
                    id="vehicle-year-min"
                    value={minYear}
                    onChange={(e) => { setMinYear(e.target.value); setCurrentPage(1); }}
                  >
                    <option value="">From year</option>
                    <option value="2015">2015</option>
                    <option value="2018">2018</option>
                    <option value="2020">2020</option>
                    <option value="2022">2022</option>
                    <option value="2024">2024</option>
                  </select>
                  <span>to</span>
                  <select 
                    id="vehicle-year-max"
                    value={maxYear}
                    onChange={(e) => { setMaxYear(e.target.value); setCurrentPage(1); }}
                  >
                    <option value="">To year</option>
                    <option value="2018">2018</option>
                    <option value="2020">2020</option>
                    <option value="2022">2022</option>
                    <option value="2024">2024</option>
                    <option value="2026">2026</option>
                  </select>
                </div>
              </div>
            </section>

            {/* 5. Mileage (KM) */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['km']}
                onClick={() => toggleSection('km')}
              >
                Mileage (KM) <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content ${collapsedSections['km'] ? 'is-collapsed' : ''}`}>
                <div className="vehicle-range-row">
                  <input 
                    id="vehicle-km-min" 
                    type="number" 
                    min="0" 
                    placeholder="Min KM"
                    value={minKm}
                    onChange={(e) => { setMinKm(e.target.value); setCurrentPage(1); }}
                  />
                  <span>to</span>
                  <input 
                    id="vehicle-km-max" 
                    type="number" 
                    min="0" 
                    placeholder="Max KM"
                    value={maxKm}
                    onChange={(e) => { setMaxKm(e.target.value); setCurrentPage(1); }}
                  />
                </div>
              </div>
            </section>

            {/* 6. Transmission */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['transmission']}
                onClick={() => toggleSection('transmission')}
              >
                Transmission <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content vehicle-check-options ${collapsedSections['transmission'] ? 'is-collapsed' : ''}`}>
                <label>
                  <input 
                    type="checkbox" 
                    checked={transmissions.includes('Automatic')}
                    onChange={() => toggleCheckbox(transmissions, setTransmissions, 'Automatic')}
                  /> Automatic
                </label>
                <label>
                  <input 
                    type="checkbox" 
                    checked={transmissions.includes('Manual')}
                    onChange={() => toggleCheckbox(transmissions, setTransmissions, 'Manual')}
                  /> Manual
                </label>
              </div>
            </section>

            {/* 7. Fuel Type */}
            <section className="vehicle-filter-group">
              <button 
                className="vehicle-filter-toggle" 
                type="button" 
                aria-expanded={!collapsedSections['fuel']}
                onClick={() => toggleSection('fuel')}
              >
                Fuel Type <i className="fa-solid fa-chevron-up"></i>
              </button>
              <div className={`vehicle-filter-content vehicle-check-options ${collapsedSections['fuel'] ? 'is-collapsed' : ''}`}>
                <label>
                  <input 
                    type="checkbox" 
                    checked={fuels.includes('Petrol')}
                    onChange={() => toggleCheckbox(fuels, setFuels, 'Petrol')}
                  /> Petrol
                </label>
                <label>
                  <input 
                    type="checkbox" 
                    checked={fuels.includes('Hybrid')}
                    onChange={() => toggleCheckbox(fuels, setFuels, 'Hybrid')}
                  /> Hybrid
                </label>
                <label>
                  <input 
                    type="checkbox" 
                    checked={fuels.includes('Diesel')}
                    onChange={() => toggleCheckbox(fuels, setFuels, 'Diesel')}
                  /> Diesel
                </label>
              </div>
            </section>

            <div className="vehicle-filter-actions">
              <button type="button" className="vehicle-reset-secondary" onClick={handleReset}>
                Reset All
              </button>
              <button type="button" className="vehicle-apply" onClick={() => {}}>
                Apply Filters
              </button>
            </div>
          </aside>

          {/* Results Grid */}
          <section>
            <div className="results-top">
              <div>
                <h2>Used Cars for Sale</h2>
                <p className="vehicle-result-count">
                  Showing {paginatedVehicles.length} of {filteredVehicles.length} listings
                </p>
              </div>
              <select 
                className="sort-select vehicle-sort"
                value={sortBy}
                onChange={(e) => setSortBy(e.target.value)}
              >
                <option value="newest">Sort: Newest First</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="year">Model Year</option>
              </select>
            </div>

            <div className="inner-card-grid">
              {paginatedVehicles.map((vehicle) => (
                <article key={vehicle.id} className="inner-listing-card vehicle-result">
                  <div className="inner-card-image">
                    <Link href={`/listings/${vehicle.slug}`}>
                      <img loading="lazy" src={vehicle.image} alt={vehicle.title} />
                    </Link>
                    <button 
                      className="favorite" 
                      aria-label="Add to favourites"
                      onClick={() => toggleFavorite(vehicle.id)}
                    >
                      <i 
                        className={favorites.includes(vehicle.id) ? "fa-solid fa-heart" : "fa-regular fa-heart"} 
                        style={favorites.includes(vehicle.id) ? { color: '#f97316' } : {}}
                      ></i>
                    </button>
                  </div>
                  <div className="inner-card-content">
                    <h3>
                      <Link href={`/listings/${vehicle.slug}`}>{vehicle.title}</Link>
                    </h3>
                    <p>{vehicle.description}</p>
                    <div className="card-tags">
                      <span>{vehicle.year}</span>
                      <span>{vehicle.km.toLocaleString()} km</span>
                      <span>{vehicle.transmission}</span>
                    </div>
                    <div className="inner-card-meta">
                      <span><i className="fa-solid fa-location-dot"></i> {vehicle.location}</span>
                      <strong>{vehicle.priceFormatted}</strong>
                    </div>
                  </div>
                </article>
              ))}
            </div>

            {/* Pagination only shown when total items exceed 12 */}
            {filteredVehicles.length > itemsPerPage && (
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
