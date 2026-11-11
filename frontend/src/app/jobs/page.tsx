'use client';

import React, { useState, useMemo } from 'react';
import Link from 'next/link';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

interface JobItem {
  id: number;
  title: string;
  slug: string;
  desc: string;
  type: string;
  location: string;
  salary: string;
  company: string;
  companyMark: string;
  companyClass: string;
}

const ALL_JOBS: JobItem[] = [
  {
    id: 1,
    title: 'Senior Laravel Developer',
    slug: 'senior-laravel-developer',
    desc: 'Join our tech team to build and scale web applications and robust REST APIs.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 150K – 200K',
    company: 'TechNova',
    companyMark: 'TN',
    companyClass: 'tech-nova',
  },
  {
    id: 2,
    title: 'UI/UX Designer',
    slug: 'ui-ux-designer-remote',
    desc: 'Design modern and user-friendly web and mobile experiences in Figma.',
    type: 'Full Time',
    location: 'Remote',
    salary: 'PKR 120K – 180K',
    company: 'PixelCraft',
    companyMark: 'PC',
    companyClass: 'pixel-craft',
  },
  {
    id: 3,
    title: 'Marketing Executive',
    slug: 'marketing-executive-lahore',
    desc: 'Handle campaigns, social content and digital performance marketing.',
    type: 'Full Time',
    location: 'Lahore',
    salary: 'PKR 80K – 120K',
    company: 'MarketEdge',
    companyMark: 'ME',
    companyClass: 'market-edge',
  },
  {
    id: 4,
    title: 'Teaching Professional',
    slug: 'teaching-professional-rawalpindi',
    desc: 'Required for a reputable school, multiple primary and secondary subjects.',
    type: 'Full Time',
    location: 'Rawalpindi',
    salary: 'PKR 60K – 90K',
    company: 'Bright Future',
    companyMark: 'BF',
    companyClass: 'bright-future',
  },
  {
    id: 5,
    title: 'Sales Executive',
    slug: 'sales-executive-karachi',
    desc: 'Drive corporate B2B sales and build lasting client relationships.',
    type: 'Full Time',
    location: 'Karachi',
    salary: 'PKR 70K – 110K',
    company: 'SalesPro',
    companyMark: 'SP',
    companyClass: 'sales-pro',
  },
  {
    id: 6,
    title: 'Frontend Developer (Next.js)',
    slug: 'frontend-developer-islamabad',
    desc: 'Build fast, responsive interfaces with React, Next.js, and TypeScript.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 130K – 170K',
    company: 'CodeWave',
    companyMark: 'CW',
    companyClass: 'tech-nova',
  },
  {
    id: 7,
    title: 'DevOps Engineer',
    slug: 'devops-engineer-remote',
    desc: 'Automate CI/CD pipelines, Docker containers, and Kubernetes clusters.',
    type: 'Remote',
    location: 'Remote',
    salary: 'PKR 180K – 250K',
    company: 'CloudSphere',
    companyMark: 'CS',
    companyClass: 'pixel-craft',
  },
  {
    id: 8,
    title: 'Accountant & Financial Officer',
    slug: 'accountant-financial-officer-lahore',
    desc: 'Manage day-to-day accounts, balance sheets, and tax compliance.',
    type: 'Full Time',
    location: 'Lahore',
    salary: 'PKR 75K – 105K',
    company: 'AuditPoint',
    companyMark: 'AP',
    companyClass: 'market-edge',
  },
  {
    id: 9,
    title: 'Customer Support Representative',
    slug: 'customer-support-rep-islamabad',
    desc: 'Provide top-tier customer care and live chat support for global users.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 65K – 95K',
    company: 'HelpDesk Pro',
    companyMark: 'HP',
    companyClass: 'bright-future',
  },
  {
    id: 10,
    title: 'Mobile App Developer (Flutter)',
    slug: 'flutter-developer-lahore',
    desc: 'Develop cross-platform iOS and Android apps with clean architecture.',
    type: 'Full Time',
    location: 'Lahore',
    salary: 'PKR 140K – 190K',
    company: 'AppVenture',
    companyMark: 'AV',
    companyClass: 'tech-nova',
  },
  {
    id: 11,
    title: 'Content Creator & Copywriter',
    slug: 'content-writer-remote',
    desc: 'Draft engaging articles, landing page copy, and creative video scripts.',
    type: 'Part Time',
    location: 'Remote',
    salary: 'PKR 50K – 80K',
    company: 'StoryCraft',
    companyMark: 'SC',
    companyClass: 'pixel-craft',
  },
  {
    id: 12,
    title: 'QA Automation Engineer',
    slug: 'qa-engineer-karachi',
    desc: 'Write automated testing suites with Cypress, Playwright, and Pest PHP.',
    type: 'Full Time',
    location: 'Karachi',
    salary: 'PKR 110K – 160K',
    company: 'TestLogic',
    companyMark: 'TL',
    companyClass: 'sales-pro',
  },
  {
    id: 13,
    title: 'HR Manager',
    slug: 'hr-manager-islamabad',
    desc: 'Lead recruitment, talent management, and internal team culture.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 120K – 170K',
    company: 'PeopleFirst',
    companyMark: 'PF',
    companyClass: 'bright-future',
  },
  {
    id: 14,
    title: 'Network & Systems Administrator',
    slug: 'network-admin-rawalpindi',
    desc: 'Maintain local office networks, firewalls, and server infrastructure.',
    type: 'Full Time',
    location: 'Rawalpindi',
    salary: 'PKR 85K – 115K',
    company: 'NetGuard',
    companyMark: 'NG',
    companyClass: 'tech-nova',
  },
];

export default function JobsPage() {
  const [selectedTypes, setSelectedTypes] = useState<string[]>([]);
  const [selectedCity, setSelectedCity] = useState('');
  const [keyword, setKeyword] = useState('');
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 12;

  const toggleType = (t: string) => {
    setSelectedTypes(prev =>
      prev.includes(t) ? prev.filter(x => x !== t) : [...prev, t]
    );
    setCurrentPage(1);
  };

  const filteredJobs = useMemo(() => {
    return ALL_JOBS.filter(job => {
      if (selectedTypes.length > 0 && !selectedTypes.some(t => job.type.toLowerCase().includes(t.toLowerCase()))) {
        return false;
      }
      if (selectedCity && selectedCity !== 'All Cities' && job.location !== selectedCity) {
        return false;
      }
      if (keyword.trim()) {
        const q = keyword.toLowerCase();
        return (
          job.title.toLowerCase().includes(q) ||
          job.desc.toLowerCase().includes(q) ||
          job.company.toLowerCase().includes(q)
        );
      }
      return true;
    });
  }, [selectedTypes, selectedCity, keyword]);

  const totalPages = Math.ceil(filteredJobs.length / itemsPerPage);
  const paginatedJobs = filteredJobs.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  return (
    <>
      <Header activeTab="jobs" />

      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Jobs
          </div>
          <h1>Find Your Next Career Move</h1>
          <p>Explore opportunities from leading companies and startups across Pakistan.</p>
          <form className="inner-search" onSubmit={(e) => e.preventDefault()}>
            <input 
              type="search" 
              placeholder="Job title, keywords, or company..." 
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
              <h4>Job Type</h4>
              <label>
                <input 
                  type="checkbox" 
                  value="full time" 
                  checked={selectedTypes.includes('full time')}
                  onChange={() => toggleType('full time')}
                /> Full Time
              </label>
              <label>
                <input 
                  type="checkbox" 
                  value="part time" 
                  checked={selectedTypes.includes('part time')}
                  onChange={() => toggleType('part time')}
                /> Part Time
              </label>
              <label>
                <input 
                  type="checkbox" 
                  value="remote" 
                  checked={selectedTypes.includes('remote')}
                  onChange={() => toggleType('remote')}
                /> Remote
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

          <section>
            <div className="results-top">
              <div>
                <h2>Latest Jobs</h2>
                <p>Showing {paginatedJobs.length} of {filteredJobs.length} listings</p>
              </div>
              <select className="sort-select" aria-label="Sort">
                <option>Newest First</option>
                <option>Salary: Low to High</option>
                <option>Salary: High to Low</option>
              </select>
            </div>

            <div className="inner-card-grid">
              {paginatedJobs.map((job) => (
                <article key={job.id} className="inner-listing-card">
                  <div className={`job-logo-panel ${job.companyClass}`}>
                    <div className="company-logo-mark">{job.companyMark}</div>
                    <div className="company-logo-name">{job.company}</div>
                    <button className="favorite" aria-label="Add to favourites">
                      <i className="fa-regular fa-heart"></i>
                    </button>
                  </div>
                  <div className="inner-card-content">
                    <h3>
                      <Link href={`/listings/${job.slug}`}>{job.title}</Link>
                    </h3>
                    <p>{job.desc}</p>
                    <div className="card-tags">
                      <span>{job.type}</span>
                      <span>Verified Employer</span>
                    </div>
                    <div className="inner-card-meta">
                      <span>
                        <i className="fa-solid fa-location-dot"></i> {job.location}
                      </span>
                      <strong>{job.salary}</strong>
                    </div>
                  </div>
                </article>
              ))}
            </div>

            {/* Pagination only shown when total items exceed 12 */}
            {filteredJobs.length > itemsPerPage && (
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
