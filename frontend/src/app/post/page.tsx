'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { Header, CommunitySection, Footer } from '@/components/layout/Navigation';

export default function PostAdPage() {
  const router = useRouter();
  const [checkingAuth, setCheckingAuth] = useState(true);

  React.useEffect(() => {
    const token = typeof window !== 'undefined' ? localStorage.getItem('placex_token') : null;
    if (!token) {
      router.push('/login?redirect=/post');
    } else {
      setCheckingAuth(false);
    }
  }, [router]);

  const [category, setCategory] = useState<'jobs' | 'property' | 'classifieds' | 'vehicles' | 'matrimonial'>('classifieds');
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [price, setPrice] = useState('');
  const [city, setCity] = useState('Islamabad');
  const [phone, setPhone] = useState('');
  const [submitting, setSubmitting] = useState(false);
  const [success, setSuccess] = useState(false);

  // Category specific fields
  const [jobType, setJobType] = useState('Full Time');
  const [company, setCompany] = useState('');
  
  const [propPurpose, setPropPurpose] = useState('sale');
  const [propBedrooms, setPropBedrooms] = useState('3');
  
  const [vehicleMake, setVehicleMake] = useState('Toyota');
  const [vehicleYear, setVehicleYear] = useState('2022');
  const [vehicleMileage, setVehicleMileage] = useState('');

  const [matrimonialType, setMatrimonialType] = useState('Bride Profile');
  const [matrimonialAge, setMatrimonialAge] = useState('26');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitting(true);

    setTimeout(() => {
      setSubmitting(false);
      setSuccess(true);
      setTimeout(() => {
        router.push(`/${category}`);
      }, 1500);
    }, 800);
  };

  if (checkingAuth) {
    return (
      <>
        <Header activeTab="post" />
        <main className="inner-main container" style={{ padding: '100px 0', textAlign: 'center' }}>
          <p style={{ color: '#64748b', fontSize: '15px' }}>Checking sign-in status...</p>
        </main>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Header activeTab="post" />

      <section className="inner-hero">
        <div className="container">
          <div className="breadcrumb">
            <Link href="/">Home</Link> / Post Free Ad
          </div>
          <h1>Publish Your Listing on PlaceX</h1>
          <p>Reach thousands of buyers, employers, or clients across Pakistan in minutes.</p>
        </div>
      </section>

      <main className="inner-main container">
        <div className="post-form-card">
          {success ? (
            <div style={{ textAlign: 'center', padding: '40px 20px' }}>
              <i className="fa-solid fa-circle-check" style={{ fontSize: '48px', color: '#16a34a', marginBottom: '16px' }}></i>
              <h2 style={{ fontSize: '22px', fontWeight: 800, color: '#0f172a', marginBottom: '8px' }}>
                Listing Submitted Successfully!
              </h2>
              <p style={{ color: '#64748b', fontSize: '14px' }}>
                Redirecting you to the {category} section...
              </p>
            </div>
          ) : (
            <form onSubmit={handleSubmit}>
              <div style={{ marginBottom: '24px' }}>
                <label style={{ display: 'block', fontSize: '14px', fontWeight: 800, color: '#0f172a', marginBottom: '10px' }}>
                  Choose Category
                </label>
                <div className="post-category-grid">
                  <div
                    className={`post-cat-btn ${category === 'jobs' ? 'selected' : ''}`}
                    onClick={() => setCategory('jobs')}
                  >
                    <i className="fa-solid fa-briefcase"></i>
                    <strong>Jobs</strong>
                  </div>
                  <div
                    className={`post-cat-btn ${category === 'property' ? 'selected' : ''}`}
                    onClick={() => setCategory('property')}
                  >
                    <i className="fa-solid fa-house"></i>
                    <strong>Property</strong>
                  </div>
                  <div
                    className={`post-cat-btn ${category === 'classifieds' ? 'selected' : ''}`}
                    onClick={() => setCategory('classifieds')}
                  >
                    <i className="fa-solid fa-tags"></i>
                    <strong>Classifieds</strong>
                  </div>
                  <div
                    className={`post-cat-btn ${category === 'vehicles' ? 'selected' : ''}`}
                    onClick={() => setCategory('vehicles')}
                  >
                    <i className="fa-solid fa-car"></i>
                    <strong>Vehicle</strong>
                  </div>
                  <div
                    className={`post-cat-btn ${category === 'matrimonial' ? 'selected' : ''}`}
                    onClick={() => setCategory('matrimonial')}
                  >
                    <i className="fa-solid fa-heart"></i>
                    <strong>Matrimonial</strong>
                  </div>
                </div>
              </div>

              {/* Title & Description */}
              <div className="post-form-group">
                <label>Listing Title</label>
                <input
                  type="text"
                  required
                  className="post-form-input"
                  placeholder="e.g. Toyota Corolla 2022 Altis Grande / iPhone 15 Pro Max"
                  value={title}
                  onChange={(e) => setTitle(e.target.value)}
                />
              </div>

              <div className="post-form-group">
                <label>Detailed Description</label>
                <textarea
                  rows={4}
                  required
                  className="post-form-textarea"
                  placeholder="Describe your item, job role, or property details..."
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                ></textarea>
              </div>

              {/* Category-Specific Dynamics */}
              {category === 'jobs' && (
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Employment Type</label>
                    <select className="post-form-select" value={jobType} onChange={(e) => setJobType(e.target.value)}>
                      <option>Full Time</option>
                      <option>Part Time</option>
                      <option>Remote</option>
                      <option>Contract</option>
                    </select>
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Company Name</label>
                    <input type="text" className="post-form-input" placeholder="e.g. TechNova" value={company} onChange={(e) => setCompany(e.target.value)} />
                  </div>
                </div>
              )}

              {category === 'property' && (
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Purpose</label>
                    <select className="post-form-select" value={propPurpose} onChange={(e) => setPropPurpose(e.target.value)}>
                      <option value="sale">For Sale</option>
                      <option value="rent">For Rent</option>
                    </select>
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Bedrooms</label>
                    <select className="post-form-select" value={propBedrooms} onChange={(e) => setPropBedrooms(e.target.value)}>
                      <option>Studio</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4+</option>
                    </select>
                  </div>
                </div>
              )}

              {category === 'vehicles' && (
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '12px', marginBottom: '20px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Make</label>
                    <select className="post-form-select" value={vehicleMake} onChange={(e) => setVehicleMake(e.target.value)}>
                      <option>Toyota</option>
                      <option>Honda</option>
                      <option>Suzuki</option>
                      <option>Kia</option>
                      <option>Hyundai</option>
                    </select>
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Year</label>
                    <input type="number" className="post-form-input" placeholder="2022" value={vehicleYear} onChange={(e) => setVehicleYear(e.target.value)} />
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Mileage (KM)</label>
                    <input type="number" className="post-form-input" placeholder="30000" value={vehicleMileage} onChange={(e) => setVehicleMileage(e.target.value)} />
                  </div>
                </div>
              )}

              {category === 'matrimonial' && (
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Profile Type</label>
                    <select className="post-form-select" value={matrimonialType} onChange={(e) => setMatrimonialType(e.target.value)}>
                      <option>Bride Profile</option>
                      <option>Groom Profile</option>
                    </select>
                  </div>
                  <div>
                    <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, marginBottom: '6px' }}>Age</label>
                    <input type="number" className="post-form-input" placeholder="26" value={matrimonialAge} onChange={(e) => setMatrimonialAge(e.target.value)} />
                  </div>
                </div>
              )}

              {/* Price & Location */}
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '16px', marginBottom: '20px' }}>
                <div>
                  <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, color: '#1e293b', marginBottom: '6px' }}>
                    {category === 'jobs' ? 'Salary / Compensation (PKR)' : 'Price (PKR)'}
                  </label>
                  <input
                    type="text"
                    required
                    className="post-form-input"
                    placeholder="e.g. 85,000"
                    value={price}
                    onChange={(e) => setPrice(e.target.value)}
                  />
                </div>

                <div>
                  <label style={{ display: 'block', fontSize: '13px', fontWeight: 700, color: '#1e293b', marginBottom: '6px' }}>
                    City
                  </label>
                  <select className="post-form-select" value={city} onChange={(e) => setCity(e.target.value)}>
                    <option>Islamabad</option>
                    <option>Rawalpindi</option>
                    <option>Lahore</option>
                    <option>Karachi</option>
                    <option>Peshawar</option>
                  </select>
                </div>
              </div>

              {/* Phone number */}
              <div className="post-form-group">
                <label>Contact Phone Number</label>
                <input
                  type="tel"
                  required
                  className="post-form-input"
                  placeholder="0300 1234567"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                />
              </div>

              <button
                type="submit"
                disabled={submitting}
                style={{
                  width: '100%',
                  height: '48px',
                  background: '#f97316',
                  color: '#fff',
                  border: 'none',
                  borderRadius: '8px',
                  fontWeight: 800,
                  fontSize: '16px',
                  cursor: submitting ? 'not-allowed' : 'pointer',
                  opacity: submitting ? 0.7 : 1,
                  marginTop: '10px'
                }}
              >
                {submitting ? 'Submitting Ad...' : 'Publish Listing'}
              </button>
            </form>
          )}
        </div>
      </main>

      <CommunitySection />
      <Footer />
    </>
  );
}

