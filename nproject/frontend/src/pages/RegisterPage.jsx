import React, { useState } from 'react';
import { register } from '../api';
import styles from './AuthPage.module.css';

export default function RegisterPage() {
  const [form, setForm] = useState({
    firstname: '',
    lastname: '',
    username: '',
    email: '',
    password: ''
  });
  const [message, setMessage] = useState('');

  function handleChange(e) {
    setForm({ ...form, [e.target.name]: e.target.value });
  }

  async function handleSubmit(e) {
    e.preventDefault();
    const res = await register(form);
    setMessage(res.token ? 'Registered' : res.error);
  }

  return (
    <div className={styles.container}>
      <h2>Register</h2>
      <form className={styles.form} onSubmit={handleSubmit}>
        <input name="firstname" placeholder="First Name" value={form.firstname} onChange={handleChange} />
        <input name="lastname" placeholder="Last Name" value={form.lastname} onChange={handleChange} />
        <input name="username" placeholder="Username" value={form.username} onChange={handleChange} />
        <input name="email" placeholder="Email" value={form.email} onChange={handleChange} />
        <input name="password" type="password" placeholder="Password" value={form.password} onChange={handleChange} />
        <button type="submit">Register</button>
      </form>
      {message && <p>{message}</p>}
    </div>
  );
}
