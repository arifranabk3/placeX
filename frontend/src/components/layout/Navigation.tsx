'use client';

import React from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';

interface HeaderProps {
  activeTab?: string;
}

export function Header({ activeTab }: HeaderProps) {
  const router = useRouter();
  const currentTab = activeTab || '';

  const isTabActive = (tab: string) => {
    if (!currentTab) return false;
    if (tab === 'home') return currentTab === 'home';
    if (tab === 'jobs') return currentTab === 'jobs';
    if (tab === 'property') return currentTab === 'property';
    if (tab === 'classifieds') return currentTab === 'classifieds';
    if (tab === 'vehicles') return currentTab === 'vehicles' || currentTab === 'cars';
    if (tab === 'matrimonial') return currentTab === 'matrimonial' || currentTab === 'marriage';
    return false;
  };

  const handlePostAdClick = (e: React.MouseEvent) => {
    e.preventDefault();
    const token = typeof window !== 'undefined' ? localStorage.getItem('placex_token') : null;
    if (!token) {
      router.push('/login?redirect=/post');
    } else {
      router.push('/post');
    }
  };

  return (
    <header className="site-header inner-site-header">
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
        <Link className={isTabActive('home') ? 'active' : ''} href="/">Home</Link>
        <Link className={isTabActive('jobs') ? 'active' : ''} href="/jobs">Jobs</Link>
        <Link className={isTabActive('property') ? 'active' : ''} href="/property">Property</Link>
        <Link className={isTabActive('classifieds') ? 'active' : ''} href="/classifieds">Classifieds</Link>
        <Link className={isTabActive('vehicles') ? 'active' : ''} href="/vehicles">Vehicle</Link>
        <Link className={isTabActive('matrimonial') ? 'active' : ''} href="/matrimonial">Matrimonial</Link>
        <a href="/#categories">Categories</a>
        <Link href="#">Blog</Link>
        <Link href="#">About</Link>
        <Link href="#">Contact</Link>
      </nav>
      <div className="header-actions">
        <Link className="user-btn" href="/login" aria-label="Account">
          <i className="fa-regular fa-user"></i>
        </Link>
        <a 
          href="/post" 
          onClick={handlePostAdClick} 
          className={`post-btn ${currentTab === 'post' ? 'active' : ''}`}
        >
          + Post Free Ad
        </a>
        <button className="menu-square" aria-label="More">
          <i className="fa-solid fa-bars"></i>
        </button>
      </div>
    </header>
  );
}

export function CommunitySection() {
  const router = useRouter();

  const handlePostAdClick = (e: React.MouseEvent) => {
    e.preventDefault();
    const token = typeof window !== 'undefined' ? localStorage.getItem('placex_token') : null;
    if (!token) {
      router.push('/login?redirect=/post');
    } else {
      router.push('/post');
    }
  };

  return (
    <section className="community">
      <div className="community-inner container">
        <div className="community-icon">
          <i className="fa-solid fa-users"></i>
        </div>
        <div className="community-copy">
          <h2>Join a Growing Community</h2>
          <p>
            Create your account and start exploring thousands of jobs,
            <br /> properties and classifieds today.
          </p>
        </div>
        <Link href="/register" className="community-primary">
          Create an Account <span>→</span>
        </Link>
        <a href="/post" onClick={handlePostAdClick} className="community-secondary">
          Post a Free Ad
        </a>
        <div className="trust-item">
          <i className="fa-solid fa-bolt"></i>
          <span>
            <b>Fast &amp; Easy</b>
            <small>Get started in minutes</small>
          </span>
        </div>
        <div className="trust-item">
          <i className="fa-solid fa-shield-halved"></i>
          <span>
            <b>Verified Listings</b>
            <small>Safe and trusted</small>
          </span>
        </div>
      </div>
    </section>
  );
}

export function Footer() {
  return (
    <footer className="site-footer">
      <div className="footer-inner container">
        <div className="footer-brand">
          <Link className="brand" href="/">
            <span>
              Place<span className="brand-x">X</span>
            </span>
            <small>JOBS · PROPERTY · CLASSIFIEDS</small>
          </Link>
          <div className="socials">
            <a href="#" aria-label="Facebook"><i className="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i className="fa-brands fa-x-twitter"></i></a>
            <a href="#" aria-label="YouTube"><i className="fa-brands fa-youtube"></i></a>
            <a href="#" aria-label="Instagram"><i className="fa-brands fa-instagram"></i></a>
          </div>
        </div>
        <div className="footer-col">
          <h4>Marketplace</h4>
          <Link href="/jobs">Jobs</Link>
          <Link href="/property">Property</Link>
          <Link href="/classifieds">Classifieds</Link>
          <Link href="/vehicles">Vehicle</Link>
          <Link href="/matrimonial">Matrimonial</Link>
          <a href="/#categories">All Categories</a>
        </div>
        <div className="footer-col">
          <h4>Company</h4>
          <Link href="#">About Us</Link>
          <Link href="#">Blog</Link>
          <Link href="#">Contact Us</Link>
          <Link href="#">Terms of Use</Link>
          <Link href="#">Privacy Policy</Link>
        </div>
        <div className="footer-col">
          <h4>Help &amp; Support</h4>
          <Link href="#">Help Center</Link>
          <Link href="#">Safety Tips</Link>
          <Link href="#">Community Guidelines</Link>
          <Link href="#">Report a Listing</Link>
          <Link href="#">FAQ</Link>
        </div>
        <div className="newsletter">
          <h4>Newsletter</h4>
          <p>Subscribe for latest updates</p>
          <form onSubmit={(e) => e.preventDefault()}>
            <input type="email" placeholder="Enter your email" aria-label="Email address" required />
            <button type="submit">
              <i className="fa-solid fa-arrow-right"></i>
            </button>
          </form>
        </div>
      </div>
      <div className="footer-bottom container">
        <span>© 2026 PlaceX. All rights reserved.</span>
        <span>
          <Link href="#">Privacy Policy</Link> | <Link href="#">Terms of Use</Link> | <Link href="#">Sitemap</Link>
        </span>
      </div>
    </footer>
  );
}
