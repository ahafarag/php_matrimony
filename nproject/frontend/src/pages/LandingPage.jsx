import React from 'react';
import { Link } from 'react-router-dom';
import styles from './LandingPage.module.css';

export default function LandingPage() {
  return (
    <div className={styles.container}>
      <h1>Welcome to Matrimony</h1>
      <p>Find your perfect match.</p>
      <nav className={styles.nav}>
        <Link to="/login">Login</Link>
        <Link to="/register">Register</Link>

      </nav>
    </div>
  );
}
