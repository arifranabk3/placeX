import React from 'react';
import Link from 'next/link';
import Image from 'next/image';

export default function HomePage() {
  return (
    <>
      <div className="hero-wrap">
        <header className="site-header container">
          <Link className="brand" href="/">
            <span>
              Place<span className="brand-x">X</span>
            </span>
            <small>JOBS · PROPERTY · CLASSIFIEDS</small>
          </Link>
          <button className="mobile-menu" aria-label="Toggle navigation">
            <i className="fa-solid fa-bars"></i>
          </button>
          <nav className="main-nav">
            <Link className="active" href="/">Home</Link>
            <Link href="/jobs">Jobs</Link>
            <Link href="/property">Property</Link>
            <Link href="/classifieds">Classifieds</Link>
            <Link href="/vehicles">Vehicle</Link>
            <Link href="/matrimonial">Matrimonial</Link>
            <a href="#categories">Categories</a>
            <Link href="/blog">Blog</Link>
            <Link href="/about">About</Link>
            <Link href="/contact">Contact</Link>
          </nav>
          <div className="header-actions">
            <Link className="user-btn" href="/login" aria-label="Account">
              <i className="fa-regular fa-user"></i>
            </Link>
            <Link className="post-btn" href="/post">
              + Post Free Ad
            </Link>
            <button className="menu-square" aria-label="More">
              <i className="fa-solid fa-bars"></i>
            </button>
          </div>
        </header>

        <main>
          <section className="hero container">
            <div className="hero-copy">
              <span className="eyebrow">ONE PLATFORM. MORE POSSIBILITIES.</span>
              <h1>
                Jobs. Property. Classifieds.
                <br />
                <em>All in One Place.</em>
              </h1>
              <p>
                Discover real opportunities, verified listings and amazing deals
                <br className="desktop-only" /> in your city and across the world.
              </p>
              <div className="vertical-words">
                Live<br />Work<br />Buy<br />Sell<br />Explore <span>↗</span>
              </div>
            </div>

            <div className="search-panel">
              <div className="search-tabs">
                <button className="search-tab selected" data-tab="vehicles">
                  <i className="fa-solid fa-car"></i> Car
                </button>
                <button className="search-tab" data-tab="property">
                  <i className="fa-solid fa-house"></i> Property
                </button>
                <button className="search-tab" data-tab="matrimonial">
                  <i className="fa-solid fa-heart"></i> Marriage
                </button>
                <button className="search-tab" data-tab="classifieds">
                  <i className="fa-solid fa-border-all"></i> Classified
                </button>
                <button className="search-tab" data-tab="jobs">
                  <i className="fa-solid fa-briefcase"></i> Job Search
                </button>
              </div>
              <form className="search-fields">
                <label className="search-input">
                  <i className="fa-solid fa-magnifying-glass"></i>
                  <input
                    type="search"
                    placeholder="Make, model or keyword"
                    aria-label="Search keyword"
                  />
                </label>
                <label className="search-input">
                  <i className="fa-solid fa-location-dot"></i>
                  <select aria-label="Select city">
                    <option value="">Select City</option>
                    <option>Islamabad</option>
                    <option>Rawalpindi</option>
                    <option>Lahore</option>
                    <option>Karachi</option>
                  </select>
                </label>
                <label className="search-input">
                  <i className="fa-solid fa-grip"></i>
                  <select aria-label="Select category">
                    <option>All Vehicle Types</option>
                    <option>Sedan</option>
                    <option>SUV</option>
                    <option>Hatchback</option>
                  </select>
                </label>
                <button className="search-submit" type="submit">
                  <i className="fa-solid fa-magnifying-glass"></i> Search
                </button>
              </form>
              <div className="trending">
                <b>Trending:</b>
                <Link href="/vehicles">Used Cars</Link>
                <Link href="/property">House for Sale</Link>
                <Link href="/property">House for Rent</Link>
                <Link href="/jobs">Jobs Near Me</Link>
                <Link href="/classifieds">Electronics</Link>
                <Link href="/classifieds">Mobiles</Link>
                <Link href="/classifieds">Furniture</Link>
                <a className="view-more" href="#categories">
                  View More →
                </a>
              </div>
            </div>

            <div className="stats">
              <div>
                <span className="stat-icon orange">
                  <i className="fa-solid fa-layer-group"></i>
                </span>
                <strong>300K+</strong>
                <small>Active Listings</small>
              </div>
              <div>
                <span className="stat-icon blue">
                  <i className="fa-solid fa-users"></i>
                </span>
                <strong>300K+</strong>
                <small>Happy Users</small>
              </div>
              <div>
                <span className="stat-icon green">
                  <i className="fa-solid fa-building"></i>
                </span>
                <strong>50K+</strong>
                <small>Companies &amp; Agents</small>
              </div>
              <div>
                <span className="stat-icon grey">
                  <i className="fa-solid fa-earth-americas"></i>
                </span>
                <strong>100+</strong>
                <small>Cities Worldwide</small>
              </div>
            </div>

            <section className="category-box category-showcase" id="categories">
              <div className="category-showcase-grid">
                <Link className="category-feature property-feature" href="/property">
                  <span className="feature-icon"><i className="fa-solid fa-house"></i></span>
                  <span className="feature-copy"><strong>Property</strong><small>Buy, sell or rent<br />properties</small></span>
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img loading="lazy" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=360&q=85" alt="Modern property" />
                  <span className="feature-arrow"><i className="fa-solid fa-arrow-right"></i></span>
                </Link>
                <Link className="category-feature marriage-feature" href="/matrimonial">
                  <span className="feature-icon"><i className="fa-regular fa-heart"></i></span>
                  <span className="feature-copy"><strong>Marriage</strong><small>Find the right<br />match</small></span>
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img loading="lazy" src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=360&q=85" alt="Wedding rings" />
                  <span className="feature-arrow"><i className="fa-solid fa-arrow-right"></i></span>
                </Link>
                <Link className="category-feature vehicles-feature" href="/vehicles">
                  <span className="feature-icon"><i className="fa-solid fa-car"></i></span>
                  <span className="feature-copy"><strong>Vehicles</strong><small>Buy and sell<br />vehicles</small></span>
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img loading="lazy" src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=360&q=85" alt="Car" />
                  <span className="feature-arrow"><i className="fa-solid fa-arrow-right"></i></span>
                </Link>
                <Link className="category-feature classifieds-feature" href="/classifieds">
                  <span className="feature-icon"><i className="fa-solid fa-tag"></i></span>
                  <span className="feature-copy"><strong>Classifieds</strong><small>Buy and sell<br />anything</small></span>
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img loading="lazy" src="https://images.unsplash.com/photo-1607082349566-187342175e2f?auto=format&fit=crop&w=360&q=85" alt="Shopping boxes" />
                  <span className="feature-arrow"><i className="fa-solid fa-arrow-right"></i></span>
                </Link>
                <Link className="category-feature jobs-feature" href="/jobs">
                  <span className="feature-icon"><i className="fa-solid fa-briefcase"></i></span>
                  <span className="feature-copy"><strong>Jobs</strong><small>Find or post<br />jobs</small></span>
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img loading="lazy" src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=360&q=85" alt="Office chair and desk" />
                  <span className="feature-arrow"><i className="fa-solid fa-arrow-right"></i></span>
                </Link>
              </div>
            </section>
          </section>
        </main>
      </div>

      <section className="promo-area">
        <div className="promo-grid container">
          <article className="promo-card promo-jobs">
            <span>CAREER &amp; OPPORTUNITY</span>
            <h3>Find work that<br />moves you forward.</h3>
            <p>Explore roles from companies and teams<br />hiring now.</p>
            <Link href="/jobs">Explore jobs <b>→</b></Link>
            <i className="fa-solid fa-briefcase promo-art"></i>
          </article>
          <article className="promo-card promo-property">
            <span>YOUR NEXT ADDRESS</span>
            <h3>Make room for<br />what matters.</h3>
            <p>Discover homes, rentals and spaces worth<br />seeing.</p>
            <Link href="/property">Explore property <b>→</b></Link>
            <i className="fa-solid fa-house-chimney promo-art"></i>
          </article>
          <article className="promo-card promo-classified">
            <span>BUY · SELL · DISCOVER</span>
            <h3>Good finds.<br />New possibilities.</h3>
            <p>Browse everyday essentials and standout<br />finds.</p>
            <Link href="/classifieds">Browse classifieds <b>→</b></Link>
            <i className="fa-solid fa-tag promo-art"></i>
          </article>
        </div>
      </section>

      <main className="listing-main container">
        {/* Jobs Section */}
        <section className="listing-section" id="jobs">
          <div className="section-heading">
            <h2>Jobs</h2>
            <Link href="/jobs">View All Jobs <span>→</span></Link>
          </div>
          <div className="listing-grid">
            <article className="listing-card">
              <div className="job-logo-panel tech-nova">
                <div className="company-logo-mark">TN</div>
                <div className="company-logo-name">TechNova</div>
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Senior Laravel Developer</h3>
                <p>Join our tech team to build and scale web applications.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Islamabad</span>
                  <strong>PKR 150K – 200K</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="job-logo-panel pixel-craft">
                <div className="company-logo-mark">PC</div>
                <div className="company-logo-name">PixelCraft</div>
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>UI/UX Designer</h3>
                <p>Design modern and user-friendly web &amp; mobile experiences.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Remote</span>
                  <strong>PKR 120K – 180K</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="job-logo-panel market-edge">
                <div className="company-logo-mark">ME</div>
                <div className="company-logo-name">MarketEdge</div>
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Marketing Executive</h3>
                <p>Handle campaigns, content and digital marketing.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Lahore</span>
                  <strong>PKR 80K – 120K</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="job-logo-panel bright-future">
                <div className="company-logo-mark">BF</div>
                <div className="company-logo-name">Bright Future</div>
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Teaching Professional</h3>
                <p>Required for a reputable school, multiple subjects.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Rawalpindi</span>
                  <strong>PKR 60K – 90K</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="job-logo-panel sales-pro">
                <div className="company-logo-mark">SP</div>
                <div className="company-logo-name">SalesPro</div>
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Sales Executive</h3>
                <p>Drive sales and build client relationships.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Karachi</span>
                  <strong>PKR 70K – 110K</strong>
                </div>
              </div>
            </article>
          </div>
        </section>

        {/* Property Section */}
        <section className="listing-section" id="property">
          <div className="section-heading">
            <h2>Property</h2>
            <Link href="/property">View All Property <span>→</span></Link>
          </div>
          <div className="listing-grid">
            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img loading="lazy" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=85" alt="Modern family house" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Modern Family House</h3>
                <p>5 Marla house in Bahria Town with modern design.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Rawalpindi</span>
                  <strong>PKR 2.25 Crore</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=700&q=85" alt="Luxury apartment interior" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Luxury Apartment</h3>
                <p>3 Beds apartment in prime location, with amenities.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Islamabad</span>
                  <strong>PKR 85K / month</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=700&q=85" alt="Green residential land" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>10 Marla Residential Plot</h3>
                <p>Ideal plot for home construction in a developed area.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Lahore</span>
                  <strong>PKR 1.1 Crore</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=700&q=85" alt="Commercial office building" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Commercial Office</h3>
                <p>Office space in business district with parking.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Islamabad</span>
                  <strong>PKR 3.5 Crore</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=700&q=85" alt="House for rent" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>House for Rent</h3>
                <p>4 Marla house for rent in a peaceful society.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Rawalpindi</span>
                  <strong>PKR 45K / month</strong>
                </div>
              </div>
            </article>
          </div>
        </section>

        {/* Classifieds Section */}
        <section className="listing-section" id="classifieds">
          <div className="section-heading">
            <h2>Classifieds</h2>
            <Link href="/classifieds">View All Classifieds <span>→</span></Link>
          </div>
          <div className="listing-grid">
            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=700&q=85" alt="Smartphone" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>iPhone 15 Pro Max</h3>
                <p>Brand new, 256GB with box and accessories.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Islamabad</span>
                  <strong>PKR 425,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=700&q=85" alt="Sofa set" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Sofa Set (5 Seater)</h3>
                <p>Stylish and comfortable sofa set in good condition.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Rawalpindi</span>
                  <strong>PKR 85,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?auto=format&fit=crop&w=700&q=85" alt="Refrigerator" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Nova Refrigerator</h3>
                <p>Double door refrigerator, excellent condition.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Lahore</span>
                  <strong>PKR 55,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=85" alt="Smart watch" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Smart Watch</h3>
                <p>Feature-rich smart watch with health tracking.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Karachi</span>
                  <strong>PKR 18,500</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&w=700&q=85" alt="LED television" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>LED TV 55 Inch</h3>
                <p>4K Ultra HD LED TV with smart features.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Islamabad</span>
                  <strong>PKR 92,000</strong>
                </div>
              </div>
            </article>
          </div>
        </section>

        {/* Vehicles Section */}
        <section className="listing-section" id="vehicles">
          <div className="section-heading">
            <h2>Vehicles</h2>
            <Link href="/vehicles">View All Vehicles <span>→</span></Link>
          </div>
          <div className="listing-grid">
            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=700&q=85" alt="Toyota Corolla" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Toyota Corolla 2023</h3>
                <p>2023 model, low mileage and excellent condition.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Lahore</span>
                  <strong>PKR 74,50,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=700&q=85" alt="Honda Civic" />
              </div>
              <div className="card-body">
                <h3>Honda Civic 2021</h3>
                <p>Clean car, single owner and well maintained.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Islamabad</span>
                  <strong>PKR 68,50,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=700&q=85" alt="SUV" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Kia Sportage 2023</h3>
                <p>2023 model, full options and excellent condition.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Karachi</span>
                  <strong>PKR 89,00,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=700&q=85" alt="Red sports car" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Suzuki Swift 2022</h3>
                <p>Neat and clean, fuel efficient and family used.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Rawalpindi</span>
                  <strong>PKR 42,50,000</strong>
                </div>
              </div>
            </article>

            <article className="listing-card">
              <div className="card-image">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img loading="lazy" src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=700&q=85" alt="Honda City" />
                <button className="favorite" aria-label="Add to favourites"><i className="fa-regular fa-heart"></i></button>
              </div>
              <div className="card-body">
                <h3>Honda City 2020</h3>
                <p>Good condition, original paint and low mileage.</p>
                <div className="card-meta">
                  <span><i className="fa-solid fa-location-dot"></i> Lahore</span>
                  <strong>PKR 34,00,000</strong>
                </div>
              </div>
            </article>
          </div>
        </section>

        {/* Matrimonial Section */}
        <section className="listing-section matrimonial-section" id="matrimonial">
          <div className="section-heading">
            <h2>Matrimonial</h2>
            <Link href="/matrimonial">View All Profiles <span>→</span></Link>
          </div>
          <div className="profile-grid">
            <article className="profile-card">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=180&q=85" alt="Profile portrait" />
              <div>
                <b>PX-1024</b>
                <p>Age 27 · Islamabad<br />Masters · Professional</p>
                <span className="bride">Bride Profile</span>
              </div>
              <i className="fa-regular fa-heart"></i>
            </article>

            <article className="profile-card">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=180&q=85" alt="Profile portrait" />
              <div>
                <b>PX-1038</b>
                <p>Age 30 · Lahore<br />Engineer · Masters</p>
                <span className="groom">Groom Profile</span>
              </div>
              <i className="fa-regular fa-heart"></i>
            </article>

            <article className="profile-card">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=180&q=85" alt="Profile portrait" />
              <div>
                <b>PX-1051</b>
                <p>Age 26 · Rawalpindi<br />Medical · Graduate</p>
                <span className="bride">Bride Profile</span>
              </div>
              <i className="fa-regular fa-heart"></i>
            </article>

            <article className="profile-card">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=180&q=85" alt="Profile portrait" />
              <div>
                <b>PX-1062</b>
                <p>Age 32 · Karachi<br />Business · Masters</p>
                <span className="groom">Groom Profile</span>
              </div>
              <i className="fa-regular fa-heart"></i>
            </article>

            <article className="profile-card">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=180&q=85" alt="Profile portrait" />
              <div>
                <b>PX-1073</b>
                <p>Age 28 · Lahore<br />Teacher · Masters</p>
                <span className="bride">Bride Profile</span>
              </div>
              <i className="fa-regular fa-heart"></i>
            </article>
          </div>
        </section>
      </main>

      <section className="community">
        <div className="community-inner container">
          <div className="community-icon"><i className="fa-solid fa-users"></i></div>
          <div className="community-copy">
            <h2>Join a Growing Community</h2>
            <p>Create your account and start exploring thousands of jobs,<br /> properties and classifieds today.</p>
          </div>
          <Link href="/register" className="community-primary">Create an Account <span>→</span></Link>
          <Link href="/post" className="community-secondary">Post a Free Ad</Link>
          <div className="trust-item"><i className="fa-solid fa-bolt"></i><span><b>Fast &amp; Easy</b><small>Get started in minutes</small></span></div>
          <div className="trust-item"><i className="fa-solid fa-shield-halved"></i><span><b>Verified Listings</b><small>Safe and trusted</small></span></div>
        </div>
      </section>

      <footer className="site-footer">
        <div className="footer-inner container">
          <div className="footer-brand">
            <Link className="brand" href="/">
              <span>Place<span className="brand-x">X</span></span>
              <small>JOBS · PROPERTY · CLASSIFIEDS</small>
            </Link>
            <div className="socials">
              <a href="#"><i className="fa-brands fa-facebook-f"></i></a>
              <a href="#"><i className="fa-brands fa-x-twitter"></i></a>
              <a href="#"><i className="fa-brands fa-youtube"></i></a>
              <a href="#"><i className="fa-brands fa-instagram"></i></a>
              <a href="#"><i className="fa-brands fa-linkedin-in"></i></a>
            </div>
          </div>
          <div className="footer-col">
            <h4>Marketplace</h4>
            <Link href="/jobs">Jobs</Link>
            <Link href="/property">Property</Link>
            <Link href="/classifieds">Classifieds</Link>
            <Link href="/vehicles">Vehicle</Link>
            <Link href="/matrimonial">Matrimonial</Link>
            <a href="#categories">All Categories</a>
          </div>
          <div className="footer-col">
            <h4>Company</h4>
            <Link href="/about">About Us</Link>
            <Link href="/blog">Blog</Link>
            <Link href="/contact">Contact Us</Link>
            <Link href="/terms">Terms of Use</Link>
            <Link href="/privacy">Privacy Policy</Link>
          </div>
          <div className="footer-col">
            <h4>Help &amp; Support</h4>
            <Link href="/help">Help Center</Link>
            <Link href="/safety">Safety Tips</Link>
            <Link href="/guidelines">Community Guidelines</Link>
            <Link href="/report">Report a Listing</Link>
            <Link href="/faq">FAQ</Link>
          </div>
          <div className="newsletter">
            <h4>Newsletter</h4>
            <p>Subscribe for latest updates</p>
            <form>
              <input type="email" placeholder="Enter your email" aria-label="Email address" required />
              <button type="submit" aria-label="Subscribe"><i className="fa-solid fa-arrow-right"></i></button>
            </form>
          </div>
        </div>
        <div className="footer-bottom container">
          <span>© 2026 PlaceX. All rights reserved.</span>
          <span>
            <Link href="/privacy">Privacy Policy</Link>　|　
            <Link href="/terms">Terms of Use</Link>　|　
            <Link href="/sitemap">Sitemap</Link>
          </span>
        </div>
      </footer>
    </>
  );
}
