import React, { useState } from 'react';
import { login } from '../api';
import styles from './AuthPage.module.css';

export default function LoginPage() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');

  async function handleSubmit(e) {
    e.preventDefault();
    const res = await login(username, password);
    setMessage(res.token ? 'Logged in' : res.error);
  }

  return (
    <div className={styles.container}>
      <h2>Login</h2>
      <form className={styles.form} onSubmit={handleSubmit}>
        <input
          placeholder="Username or Email"
          value={username}
          onChange={e => setUsername(e.target.value)}
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={e => setPassword(e.target.value)}
        />
        <button type="submit">Login</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
}
