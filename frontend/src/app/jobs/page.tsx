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
  salaryMin: number;
  salaryMax: number;
  company: string;
  companyMark: string;
  companyClass: string;
  functionalArea: string;
  industry: string;
  experience: string;
  careerLevel: string;
  gender: string;
  postedAgo: string;
}

const ALL_JOBS: JobItem[] = [
  {
    id: 1,
    title: 'Senior Laravel Developer',
    slug: 'senior-laravel-developer',
    desc: 'Join our tech team to build and scale web applications, microservices, and robust REST APIs.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 150K – 200K',
    salaryMin: 150000,
    salaryMax: 200000,
    company: 'TechNova',
    companyMark: 'TN',
    companyClass: 'tech-nova',
    functionalArea: 'Software & Web Development',
    industry: 'Information Technology',
    experience: '3 - 5 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '1 day ago',
  },
  {
    id: 2,
    title: 'UI/UX Designer',
    slug: 'ui-ux-designer-remote',
    desc: 'Design modern and user-friendly web and mobile experiences in Figma, design systems and prototypes.',
    type: 'Full Time',
    location: 'Remote',
    salary: 'PKR 120K – 180K',
    salaryMin: 120000,
    salaryMax: 180000,
    company: 'PixelCraft',
    companyMark: 'PC',
    companyClass: 'pixel-craft',
    functionalArea: 'Creative, Design & Art',
    industry: 'Information Technology',
    experience: '2 - 4 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '2 days ago',
  },
  {
    id: 3,
    title: 'Marketing Executive',
    slug: 'marketing-executive-lahore',
    desc: 'Handle performance campaigns, social content, influencer partnerships, and digital marketing.',
    type: 'Full Time',
    location: 'Lahore',
    salary: 'PKR 80K – 120K',
    salaryMin: 80000,
    salaryMax: 120000,
    company: 'MarketEdge',
    companyMark: 'ME',
    companyClass: 'market-edge',
    functionalArea: 'Marketing',
    industry: 'FMCG & Retail',
    experience: '1 - 2 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '3 days ago',
  },
  {
    id: 4,
    title: 'Teaching Professional',
    slug: 'teaching-professional-rawalpindi',
    desc: 'Required for a reputable private Cambridge school, primary and secondary STEM subjects.',
    type: 'Full Time',
    location: 'Rawalpindi',
    salary: 'PKR 60K – 90K',
    salaryMin: 60000,
    salaryMax: 90000,
    company: 'Bright Future',
    companyMark: 'BF',
    companyClass: 'bright-future',
    functionalArea: 'Education & Training',
    industry: 'Education',
    experience: '2 - 4 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '4 days ago',
  },
  {
    id: 5,
    title: 'Sales Executive',
    slug: 'sales-executive-karachi',
    desc: 'Drive corporate B2B telecommunication sales, prospect leads, and build lasting client relationships.',
    type: 'Full Time',
    location: 'Karachi',
    salary: 'PKR 70K – 110K',
    salaryMin: 70000,
    salaryMax: 110000,
    company: 'SalesPro',
    companyMark: 'SP',
    companyClass: 'sales-pro',
    functionalArea: 'Sales & Business Development',
    industry: 'Telecommunication',
    experience: '1 - 2 Years',
    careerLevel: 'Entry Level',
    gender: 'No Preference',
    postedAgo: '2 days ago',
  },
  {
    id: 6,
    title: 'Frontend Developer (Next.js)',
    slug: 'frontend-developer-islamabad',
    desc: 'Build fast, responsive interfaces with React, Next.js, TypeScript, and modern Tailwind CSS.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 130K – 170K',
    salaryMin: 130000,
    salaryMax: 170000,
    company: 'CodeWave',
    companyMark: 'CW',
    companyClass: 'tech-nova',
    functionalArea: 'Software & Web Development',
    industry: 'Information Technology',
    experience: '2 - 4 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: 'Just now',
  },
  {
    id: 7,
    title: 'DevOps Engineer',
    slug: 'devops-engineer-remote',
    desc: 'Automate CI/CD pipelines, Docker containers, AWS Cloud infrastructure, and Kubernetes clusters.',
    type: 'Remote',
    location: 'Remote',
    salary: 'PKR 180K – 250K',
    salaryMin: 180000,
    salaryMax: 250000,
    company: 'CloudSphere',
    companyMark: 'CS',
    companyClass: 'pixel-craft',
    functionalArea: 'Software & Web Development',
    industry: 'Information Technology',
    experience: '5+ Years',
    careerLevel: 'Senior Executive',
    gender: 'No Preference',
    postedAgo: '5 days ago',
  },
  {
    id: 8,
    title: 'Accountant & Financial Officer',
    slug: 'accountant-financial-officer-lahore',
    desc: 'Manage day-to-day accounts, balance sheets, quickbooks auditing, and statutory tax compliance.',
    type: 'Full Time',
    location: 'Lahore',
    salary: 'PKR 75K – 105K',
    salaryMin: 75000,
    salaryMax: 105000,
    company: 'AuditPoint',
    companyMark: 'AP',
    companyClass: 'market-edge',
    functionalArea: 'Accounts, Finance & Financial Services',
    industry: 'Banking & Financial Services',
    experience: '2 - 4 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '1 week ago',
  },
  {
    id: 9,
    title: 'Customer Support Representative',
    slug: 'customer-support-rep-islamabad',
    desc: 'Provide top-tier customer care, inbound email handling, and live chat support for global users.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 65K – 95K',
    salaryMin: 65000,
    salaryMax: 95000,
    company: 'HelpDesk Pro',
    companyMark: 'HP',
    companyClass: 'bright-future',
    functionalArea: 'Customer Service & Support',
    industry: 'Telecommunication',
    experience: 'Fresh / Less than 1 Year',
    careerLevel: 'Entry Level',
    gender: 'No Preference',
    postedAgo: '3 days ago',
  },
  {
    id: 10,
    title: 'Mobile App Developer (Flutter)',
    slug: 'flutter-developer-lahore',
    desc: 'Develop cross-platform iOS and Android apps with clean architecture, Bloc state, and REST integration.',
    type: 'Full Time',
    location: 'Lahore',
    salary: 'PKR 140K – 190K',
    salaryMin: 140000,
    salaryMax: 190000,
    company: 'AppVenture',
    companyMark: 'AV',
    companyClass: 'tech-nova',
    functionalArea: 'Software & Web Development',
    industry: 'Information Technology',
    experience: '2 - 4 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '4 days ago',
  },
  {
    id: 11,
    title: 'Content Creator & Copywriter',
    slug: 'content-writer-remote',
    desc: 'Draft engaging articles, landing page copy, social media reels scripts, and creative marketing text.',
    type: 'Part Time',
    location: 'Remote',
    salary: 'PKR 50K – 80K',
    salaryMin: 50000,
    salaryMax: 80000,
    company: 'StoryCraft',
    companyMark: 'SC',
    companyClass: 'pixel-craft',
    functionalArea: 'Marketing',
    industry: 'Information Technology',
    experience: '1 - 2 Years',
    careerLevel: 'Entry Level',
    gender: 'No Preference',
    postedAgo: '6 days ago',
  },
  {
    id: 12,
    title: 'QA Automation Engineer',
    slug: 'qa-engineer-karachi',
    desc: 'Write automated end-to-end testing suites with Cypress, Playwright, API tests, and Pest PHP.',
    type: 'Full Time',
    location: 'Karachi',
    salary: 'PKR 110K – 160K',
    salaryMin: 110000,
    salaryMax: 160000,
    company: 'TestLogic',
    companyMark: 'TL',
    companyClass: 'sales-pro',
    functionalArea: 'Software & Web Development',
    industry: 'Information Technology',
    experience: '2 - 4 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '1 day ago',
  },
  {
    id: 13,
    title: 'HR Manager',
    slug: 'hr-manager-islamabad',
    desc: 'Lead company-wide recruitment, technical talent acquisition, onboarding, and internal team culture.',
    type: 'Full Time',
    location: 'Islamabad',
    salary: 'PKR 120K – 170K',
    salaryMin: 120000,
    salaryMax: 170000,
    company: 'PeopleFirst',
    companyMark: 'PF',
    companyClass: 'bright-future',
    functionalArea: 'Human Resources',
    industry: 'Services',
    experience: '5+ Years',
    careerLevel: 'Department Head',
    gender: 'No Preference',
    postedAgo: '3 days ago',
  },
  {
    id: 14,
    title: 'Network & Systems Administrator',
    slug: 'network-admin-rawalpindi',
    desc: 'Maintain local office networks, VPNs, Cisco firewalls, Linux servers, and infrastructure uptime.',
    type: 'Full Time',
    location: 'Rawalpindi',
    salary: 'PKR 85K – 115K',
    salaryMin: 85000,
    salaryMax: 115000,
    company: 'NetGuard',
    companyMark: 'NG',
    companyClass: 'tech-nova',
    functionalArea: 'Software & Web Development',
    industry: 'Telecommunication',
    experience: '3 - 5 Years',
    careerLevel: 'Mid Career',
    gender: 'No Preference',
    postedAgo: '5 days ago',
  },
];

export default function JobsPage() {
  // Collapsible Accordions State
  const [collapsedSections, setCollapsedSections] = useState<Record<string, boolean>>({
    experience: false,
    careerLevel: true,
    industry: false,
    gender: true,
  });

  // Filter States (Rozee.pk style)
  const [keyword, setKeyword] = useState('');
  const [selectedCities, setSelectedCities] = useState<string[]>([]);
  const [selectedFunctionalAreas, setSelectedFunctionalAreas] = useState<string[]>([]);
  const [selectedIndustries, setSelectedIndustries] = useState<string[]>([]);
  const [selectedExperiences, setSelectedExperiences] = useState<string[]>([]);
  const [selectedTypes, setSelectedTypes] = useState<string[]>([]);
  const [selectedCareerLevels, setSelectedCareerLevels] = useState<string[]>([]);
  const [selectedGender, setSelectedGender] = useState<string>('');
  const [minSalary, setMinSalary] = useState('');
  const [maxSalary, setMaxSalary] = useState('');
  const [activeSalaryChip, setActiveSalaryChip] = useState('');

  // Pagination & Sorting
  const [sortBy, setSortBy] = useState('newest');
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 12;

  const toggleSection = (section: string) => {
    setCollapsedSections(prev => ({ ...prev, [section]: !prev[section] }));
  };

  const toggleItem = (list: string[], setList: React.Dispatch<React.SetStateAction<string[]>>, val: string) => {
    setList(prev => prev.includes(val) ? prev.filter(x => x !== val) : [...prev, val]);
    setCurrentPage(1);
  };

  const handleSalaryChip = (chip: string, min: string, max: string) => {
    if (activeSalaryChip === chip) {
      setActiveSalaryChip('');
      setMinSalary('');
      setMaxSalary('');
    } else {
      setActiveSalaryChip(chip);
      setMinSalary(min);
      setMaxSalary(max);
    }
    setCurrentPage(1);
  };

  const handleResetAll = () => {
    setKeyword('');
    setSelectedCities([]);
    setSelectedFunctionalAreas([]);
    setSelectedIndustries([]);
    setSelectedExperiences([]);
    setSelectedTypes([]);
    setSelectedCareerLevels([]);
    setSelectedGender('');
    setMinSalary('');
    setMaxSalary('');
    setActiveSalaryChip('');
    setCurrentPage(1);
  };

  // Distinct Filter Option Sets with counts based on ALL_JOBS
  const cityCounts = useMemo(() => {
    const counts: Record<string, number> = {};
    ALL_JOBS.forEach(j => {
      counts[j.location] = (counts[j.location] || 0) + 1;
    });
    return counts;
  }, []);

  const functionalAreaCounts = useMemo(() => {
    const counts: Record<string, number> = {};
    ALL_JOBS.forEach(j => {
      counts[j.functionalArea] = (counts[j.functionalArea] || 0) + 1;
    });
    return counts;
  }, []);

  const industryCounts = useMemo(() => {
    const counts: Record<string, number> = {};
    ALL_JOBS.forEach(j => {
      counts[j.industry] = (counts[j.industry] || 0) + 1;
    });
    return counts;
  }, []);

  const experienceCounts = useMemo(() => {
    const counts: Record<string, number> = {};
    ALL_JOBS.forEach(j => {
      counts[j.experience] = (counts[j.experience] || 0) + 1;
    });
    return counts;
  }, []);

  const typeCounts = useMemo(() => {
    const counts: Record<string, number> = {};
    ALL_JOBS.forEach(j => {
      counts[j.type] = (counts[j.type] || 0) + 1;
    });
    return counts;
  }, []);

  const careerLevelCounts = useMemo(() => {
    const counts: Record<string, number> = {};
    ALL_JOBS.forEach(j => {
      counts[j.careerLevel] = (counts[j.careerLevel] || 0) + 1;
    });
    return counts;
  }, []);

  // Filter Engine
  const filteredJobs = useMemo(() => {
    return ALL_JOBS.filter(job => {
      // Keyword filter
      if (keyword.trim()) {
        const q = keyword.toLowerCase();
        const matches = 
          job.title.toLowerCase().includes(q) ||
          job.desc.toLowerCase().includes(q) ||
          job.company.toLowerCase().includes(q) ||
          job.functionalArea.toLowerCase().includes(q) ||
          job.industry.toLowerCase().includes(q);
        if (!matches) return false;
      }

      // Cities filter
      if (selectedCities.length > 0 && !selectedCities.includes(job.location)) {
        return false;
      }

      // Functional Area filter
      if (selectedFunctionalAreas.length > 0 && !selectedFunctionalAreas.includes(job.functionalArea)) {
        return false;
      }

      // Industry filter
      if (selectedIndustries.length > 0 && !selectedIndustries.includes(job.industry)) {
        return false;
      }

      // Experience filter
      if (selectedExperiences.length > 0 && !selectedExperiences.includes(job.experience)) {
        return false;
      }

      // Job Type filter
      if (selectedTypes.length > 0 && !selectedTypes.includes(job.type)) {
        return false;
      }

      // Career Level filter
      if (selectedCareerLevels.length > 0 && !selectedCareerLevels.includes(job.careerLevel)) {
        return false;
      }

      // Gender filter
      if (selectedGender && selectedGender !== 'No Preference' && job.gender !== 'No Preference' && job.gender !== selectedGender) {
        return false;
      }

      // Salary Range filter
      const pMin = Number(minSalary) || 0;
      const pMax = Number(maxSalary) || Infinity;
      if (job.salaryMax < pMin) return false;
      if (pMax !== Infinity && job.salaryMin > pMax) return false;

      return true;
    }).sort((a, b) => {
      if (sortBy === 'salary-high') return b.salaryMax - a.salaryMax;
      if (sortBy === 'salary-low') return a.salaryMin - b.salaryMin;
      return a.id - b.id; // Newest first
    });
  }, [
    keyword, selectedCities, selectedFunctionalAreas, selectedIndustries,
    selectedExperiences, selectedTypes, selectedCareerLevels, selectedGender,
    minSalary, maxSalary, sortBy
  ]);

  const totalPages = Math.ceil(filteredJobs.length / itemsPerPage);
  const paginatedJobs = filteredJobs.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  // Active filters count
  const activeFiltersCount = 
    selectedCities.length + 
    selectedFunctionalAreas.length + 
    selectedIndustries.length + 
    selectedExperiences.length + 
    selectedTypes.length + 
    selectedCareerLevels.length + 
    (selectedGender ? 1 : 0) + 
    (minSalary || maxSalary ? 1 : 0) +
    (keyword ? 1 : 0);

  return (
    <>
      <Header activeTab="jobs" />

      {/* Hero section */}
      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Jobs
          </div>
          <h1>Find Your Next Career Move</h1>
          <p>Explore opportunities from leading verified companies and startups across Pakistan.</p>
          <form className="inner-search" onSubmit={(e) => e.preventDefault()}>
            <input 
              type="search" 
              placeholder="Job title, skills, functional area, or company..." 
              value={keyword}
              onChange={(e) => { setKeyword(e.target.value); setCurrentPage(1); }}
            />
            <select 
              value={selectedCities.length === 1 ? selectedCities[0] : ''}
              onChange={(e) => { 
                setSelectedCities(e.target.value ? [e.target.value] : []); 
                setCurrentPage(1); 
              }}
            >
              <option value="">All Locations</option>
              <option value="Islamabad">Islamabad</option>
              <option value="Rawalpindi">Rawalpindi</option>
              <option value="Lahore">Lahore</option>
              <option value="Karachi">Karachi</option>
              <option value="Remote">Remote</option>
            </select>
            <button type="submit">
              <i className="fa-solid fa-magnifying-glass"></i> Search Jobs
            </button>
          </form>
        </div>
      </section>

      {/* Main layout with Rozee.pk style sidebar */}
      <main className="inner-main container">
        <div className="inner-layout">
          {/* ROZEE.PK STYLE FILTER SIDEBAR */}
          <aside className="rozee-filter-panel">
            <div className="rozee-filter-head">
              <h3>
                <i className="fa-solid fa-sliders"></i> Filters
                {activeFiltersCount > 0 && (
                  <span className="rozee-item-count" style={{ background: '#ffedd5', color: '#c2410c' }}>
                    {activeFiltersCount}
                  </span>
                )}
              </h3>
              {activeFiltersCount > 0 && (
                <button type="button" onClick={handleResetAll} className="rozee-clear-btn">
                  Clear All
                </button>
              )}
            </div>

            {/* Quick Keyword Search inside Sidebar */}
            <div className="rozee-search-box">
              <div className="rozee-search-input-wrap">
                <i className="fa-solid fa-magnifying-glass"></i>
                <input 
                  type="text" 
                  placeholder="Keyword or Title..." 
                  value={keyword}
                  onChange={(e) => { setKeyword(e.target.value); setCurrentPage(1); }}
                />
              </div>
            </div>

            {/* 1. City / Location Filter */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('city')}
                aria-expanded={!collapsedSections['city']}
              >
                <span>City / Location</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['city'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {Object.entries(cityCounts).map(([cityName, count]) => (
                    <label key={cityName} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="checkbox"
                          checked={selectedCities.includes(cityName)}
                          onChange={() => toggleItem(selectedCities, setSelectedCities, cityName)}
                        />
                        {cityName}
                      </span>
                      <span className="rozee-item-count">{count}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* 2. Functional Area Filter */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('functionalArea')}
                aria-expanded={!collapsedSections['functionalArea']}
              >
                <span>Functional Area</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['functionalArea'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {Object.entries(functionalAreaCounts).map(([area, count]) => (
                    <label key={area} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="checkbox"
                          checked={selectedFunctionalAreas.includes(area)}
                          onChange={() => toggleItem(selectedFunctionalAreas, setSelectedFunctionalAreas, area)}
                        />
                        {area}
                      </span>
                      <span className="rozee-item-count">{count}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* 3. Industry Filter */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('industry')}
                aria-expanded={!collapsedSections['industry']}
              >
                <span>Industry</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['industry'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {Object.entries(industryCounts).map(([ind, count]) => (
                    <label key={ind} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="checkbox"
                          checked={selectedIndustries.includes(ind)}
                          onChange={() => toggleItem(selectedIndustries, setSelectedIndustries, ind)}
                        />
                        {ind}
                      </span>
                      <span className="rozee-item-count">{count}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* 4. Experience Filter */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('experience')}
                aria-expanded={!collapsedSections['experience']}
              >
                <span>Experience</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['experience'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {Object.entries(experienceCounts).map(([exp, count]) => (
                    <label key={exp} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="checkbox"
                          checked={selectedExperiences.includes(exp)}
                          onChange={() => toggleItem(selectedExperiences, setSelectedExperiences, exp)}
                        />
                        {exp}
                      </span>
                      <span className="rozee-item-count">{count}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* 5. Expected Salary Range Filter */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('salary')}
                aria-expanded={!collapsedSections['salary']}
              >
                <span>Expected Salary (PKR)</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['salary'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-salary-chips">
                  <button 
                    type="button"
                    className={`rozee-salary-chip ${activeSalaryChip === '50-100' ? 'active' : ''}`}
                    onClick={() => handleSalaryChip('50-100', '50000', '100000')}
                  >
                    50K – 100K
                  </button>
                  <button 
                    type="button"
                    className={`rozee-salary-chip ${activeSalaryChip === '100-150' ? 'active' : ''}`}
                    onClick={() => handleSalaryChip('100-150', '100000', '150000')}
                  >
                    100K – 150K
                  </button>
                  <button 
                    type="button"
                    className={`rozee-salary-chip ${activeSalaryChip === '150-200' ? 'active' : ''}`}
                    onClick={() => handleSalaryChip('150-200', '150000', '200000')}
                  >
                    150K – 200K
                  </button>
                  <button 
                    type="button"
                    className={`rozee-salary-chip ${activeSalaryChip === '200+' ? 'active' : ''}`}
                    onClick={() => handleSalaryChip('200+', '200000', '')}
                  >
                    200K+
                  </button>
                </div>
                <div className="rozee-range-inputs">
                  <input 
                    type="number" 
                    placeholder="Min (PKR)" 
                    value={minSalary}
                    onChange={(e) => { setMinSalary(e.target.value); setActiveSalaryChip(''); setCurrentPage(1); }}
                  />
                  <span>to</span>
                  <input 
                    type="number" 
                    placeholder="Max (PKR)" 
                    value={maxSalary}
                    onChange={(e) => { setMaxSalary(e.target.value); setActiveSalaryChip(''); setCurrentPage(1); }}
                  />
                </div>
              </div>
            </div>

            {/* 6. Job Type / Shift */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('jobType')}
                aria-expanded={!collapsedSections['jobType']}
              >
                <span>Job Type</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['jobType'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {Object.entries(typeCounts).map(([type, count]) => (
                    <label key={type} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="checkbox"
                          checked={selectedTypes.includes(type)}
                          onChange={() => toggleItem(selectedTypes, setSelectedTypes, type)}
                        />
                        {type}
                      </span>
                      <span className="rozee-item-count">{count}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* 7. Career Level */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('careerLevel')}
                aria-expanded={!collapsedSections['careerLevel']}
              >
                <span>Career Level</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['careerLevel'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {Object.entries(careerLevelCounts).map(([lvl, count]) => (
                    <label key={lvl} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="checkbox"
                          checked={selectedCareerLevels.includes(lvl)}
                          onChange={() => toggleItem(selectedCareerLevels, setSelectedCareerLevels, lvl)}
                        />
                        {lvl}
                      </span>
                      <span className="rozee-item-count">{count}</span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* 8. Gender */}
            <div className="rozee-filter-group">
              <button 
                type="button" 
                className="rozee-filter-toggle"
                onClick={() => toggleSection('gender')}
                aria-expanded={!collapsedSections['gender']}
              >
                <span>Gender</span>
                <i className="fa-solid fa-chevron-down"></i>
              </button>
              <div className={`rozee-filter-content ${collapsedSections['gender'] ? 'is-collapsed' : ''}`}>
                <div className="rozee-checkbox-list">
                  {['No Preference', 'Male', 'Female'].map((gen) => (
                    <label key={gen} className="rozee-checkbox-item">
                      <span className="rozee-item-left">
                        <input 
                          type="radio"
                          name="genderRadio"
                          checked={selectedGender === gen || (!selectedGender && gen === 'No Preference')}
                          onChange={() => {
                            setSelectedGender(gen === 'No Preference' ? '' : gen);
                            setCurrentPage(1);
                          }}
                        />
                        {gen}
                      </span>
                    </label>
                  ))}
                </div>
              </div>
            </div>

            {/* Sidebar Bottom Actions */}
            <div className="rozee-filter-actions">
              <button type="button" onClick={handleResetAll} className="rozee-reset-btn">
                Reset All
              </button>
              <button type="button" onClick={() => setCurrentPage(1)} className="rozee-apply-btn">
                Apply Filters ({filteredJobs.length})
              </button>
            </div>
          </aside>

          {/* RESULTS COLUMN */}
          <section>
            {/* Active Filter Badges Strip */}
            {activeFiltersCount > 0 && (
              <div className="rozee-active-pills-wrap">
                <span className="rozee-active-pills-label">Active Filters:</span>
                {keyword && (
                  <span className="rozee-filter-pill">
                    "{keyword}"
                    <button type="button" onClick={() => setKeyword('')}>✕</button>
                  </span>
                )}
                {selectedCities.map(c => (
                  <span key={c} className="rozee-filter-pill">
                    {c}
                    <button type="button" onClick={() => toggleItem(selectedCities, setSelectedCities, c)}>✕</button>
                  </span>
                ))}
                {selectedFunctionalAreas.map(a => (
                  <span key={a} className="rozee-filter-pill">
                    {a}
                    <button type="button" onClick={() => toggleItem(selectedFunctionalAreas, setSelectedFunctionalAreas, a)}>✕</button>
                  </span>
                ))}
                {selectedIndustries.map(ind => (
                  <span key={ind} className="rozee-filter-pill">
                    {ind}
                    <button type="button" onClick={() => toggleItem(selectedIndustries, setSelectedIndustries, ind)}>✕</button>
                  </span>
                ))}
                {selectedExperiences.map(e => (
                  <span key={e} className="rozee-filter-pill">
                    {e}
                    <button type="button" onClick={() => toggleItem(selectedExperiences, setSelectedExperiences, e)}>✕</button>
                  </span>
                ))}
                {selectedTypes.map(t => (
                  <span key={t} className="rozee-filter-pill">
                    {t}
                    <button type="button" onClick={() => toggleItem(selectedTypes, setSelectedTypes, t)}>✕</button>
                  </span>
                ))}
                {selectedCareerLevels.map(lvl => (
                  <span key={lvl} className="rozee-filter-pill">
                    {lvl}
                    <button type="button" onClick={() => toggleItem(selectedCareerLevels, setSelectedCareerLevels, lvl)}>✕</button>
                  </span>
                ))}
                {(minSalary || maxSalary) && (
                  <span className="rozee-filter-pill">
                    PKR {minSalary || '0'} – {maxSalary || 'Any'}
                    <button type="button" onClick={() => { setMinSalary(''); setMaxSalary(''); setActiveSalaryChip(''); }}>✕</button>
                  </span>
                )}
                <button 
                  type="button" 
                  onClick={handleResetAll} 
                  style={{ background: 'none', border: 'none', color: '#dc2626', fontSize: '12px', fontWeight: 700, cursor: 'pointer', marginLeft: 'auto' }}
                >
                  Clear All
                </button>
              </div>
            )}

            <div className="results-top">
              <div>
                <h2>Latest Jobs in Pakistan</h2>
                <p>Showing {paginatedJobs.length} of {filteredJobs.length} verified listings</p>
              </div>
              <select 
                className="sort-select" 
                aria-label="Sort"
                value={sortBy}
                onChange={(e) => setSortBy(e.target.value)}
              >
                <option value="newest">Newest First</option>
                <option value="salary-high">Salary: High to Low</option>
                <option value="salary-low">Salary: Low to High</option>
              </select>
            </div>

            {paginatedJobs.length === 0 ? (
              <div style={{ textAlign: 'center', padding: '60px 20px', background: '#fff', borderRadius: '14px', border: '1px solid #e2e8f0' }}>
                <i className="fa-solid fa-briefcase" style={{ fontSize: '42px', color: '#94a3b8', marginBottom: '16px' }}></i>
                <h3 style={{ fontSize: '18px', fontWeight: 800, color: '#0f172a', marginBottom: '8px' }}>No matching jobs found</h3>
                <p style={{ color: '#64748b', fontSize: '14px', marginBottom: '20px' }}>Try broadening your search or clearing some filters.</p>
                <button 
                  type="button" 
                  onClick={handleResetAll}
                  style={{ background: '#f97316', color: '#fff', border: 'none', padding: '10px 20px', borderRadius: '8px', fontWeight: 700, cursor: 'pointer' }}
                >
                  Clear All Filters
                </button>
              </div>
            ) : (
              <div className="inner-card-grid">
                {paginatedJobs.map((job) => (
                  <article key={job.id} className="inner-listing-card">
                    {/* Modern Company Logo Panel */}
                    <div className={`job-logo-panel ${job.companyClass}`}>
                      <div className="company-logo-mark">{job.companyMark}</div>
                      <div className="company-logo-name">{job.company}</div>
                      <button className="favorite" aria-label="Add to favourites">
                        <i className="fa-regular fa-heart"></i>
                      </button>
                    </div>
                    <div className="inner-card-content">
                      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '8px', marginBottom: '6px' }}>
                        <span style={{ fontSize: '11px', color: '#f97316', fontWeight: 700 }}>
                          {job.functionalArea}
                        </span>
                        <span style={{ fontSize: '10px', color: '#94a3b8' }}>
                          {job.postedAgo}
                        </span>
                      </div>
                      <h3>
                        <Link href={`/listings/${job.slug}`}>{job.title}</Link>
                      </h3>
                      <p>{job.desc}</p>
                      <div className="card-tags">
                        <span>{job.type}</span>
                        <span>{job.experience}</span>
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
            )}

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
