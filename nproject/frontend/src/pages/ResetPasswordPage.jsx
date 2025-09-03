import React, { useState } from 'react';
import { forgotPassword, resetPassword } from '../api';
import styles from './AuthPage.module.css';


export default function ResetPasswordPage() {
  const [email, setEmail] = useState('');
  const [token, setToken] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');

  async function handleEmail(e) {
    e.preventDefault();
    const res = await forgotPassword(email);
    if (res.token) {
      setToken(res.token);
      setMessage('Token generated. Check your email.');
    } else {
      setMessage(res.error);
    }
  }

  async function handleReset(e) {
    e.preventDefault();
    const res = await resetPassword(token, password);
    setMessage(res.message || res.error);
  }

  return (
    <div className={styles.container}>
      <h2>Reset Password</h2>
      <form className={styles.form} onSubmit={handleEmail}>

        <input placeholder="Email" value={email} onChange={e => setEmail(e.target.value)} />
        <button type="submit">Send Reset Link</button>
      </form>
      {token && (
        <form className={styles.form} onSubmit={handleReset}>

          <input placeholder="Token" value={token} onChange={e => setToken(e.target.value)} />
          <input type="password" placeholder="New Password" value={password} onChange={e => setPassword(e.target.value)} />
          <button type="submit">Reset Password</button>
        </form>
      )}
      {message && <p>{message}</p>}
    </div>
  );
}
