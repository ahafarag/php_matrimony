const express = require('express');
const fs = require('fs-extra');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const cors = require('cors');
const path = require('path');
const crypto = require('crypto');


const app = express();
app.use(cors());
app.use(express.json());

const USERS_FILE = path.join(__dirname, 'users.json');
const RESETS_FILE = path.join(__dirname, 'resets.json');

const JWT_SECRET = process.env.JWT_SECRET || 'secret-key';

async function loadUsers() {
  try {
    return await fs.readJson(USERS_FILE);
  } catch (err) {
    return [];
  }
}

async function saveUsers(users) {
  await fs.writeJson(USERS_FILE, users);
}

async function loadResets() {
  try {
    return await fs.readJson(RESETS_FILE);
  } catch (err) {
    return [];
  }
}

async function saveResets(tokens) {
  await fs.writeJson(RESETS_FILE, tokens);
}


function generateMemberId(username) {
  const prefix = username.slice(0, 2).toUpperCase();
  const random = crypto.randomBytes(4).toString('hex').toUpperCase();
  return `${prefix}${random}`;
}

app.post('/api/register', async (req, res) => {
  const {
    firstname,
    lastname,
    username,
    email,
    country_code,
    phone_code,
    phone,
    password,
    sponsor
  } = req.body;

  if (!firstname || !lastname || !username || !email || !password) {
    return res.status(400).json({ error: 'Missing required fields' });
  }

  const users = await loadUsers();
  if (users.find(u => u.email === email || u.username === username)) {
    return res.status(409).json({ error: 'User already exists' });
  }

  const referral = users.find(u => u.username === sponsor);
  const hashed = await bcrypt.hash(password, 10);
  const user = {
    id: Date.now(),
    firstname,
    lastname,
    username,
    email,
    country_code,
    phone_code,
    phone,
    password: hashed,
    referral_id: referral ? referral.id : null,
    member_id: generateMemberId(username),
    status: 1,
    last_login: null
  };

  users.push(user);
  await saveUsers(users);

  const token = jwt.sign({ id: user.id, username: user.username }, JWT_SECRET);

  res.json({ token });
});

app.post('/api/login', async (req, res) => {
  const { username, password } = req.body;
  const users = await loadUsers();
  const user = users.find(
    u => u.username === username || u.email === username
  );
  if (!user) {
    return res.status(401).json({ error: 'Invalid credentials' });
  }
  if (user.status !== 1) {
    return res
      .status(403)
      .json({ error: 'You are banned from this application. Please contact administrator.' });
  }

  const match = await bcrypt.compare(password, user.password);
  if (!match) {
    return res.status(401).json({ error: 'Invalid credentials' });
  }
  user.last_login = new Date().toISOString();
  await saveUsers(users);
  const token = jwt.sign({ id: user.id, username: user.username }, JWT_SECRET);
  res.json({ token });
});

app.post('/api/forgot', async (req, res) => {
  const { email } = req.body;
  const users = await loadUsers();
  const user = users.find(u => u.email === email);
  if (!user) {
    return res.status(404).json({ error: 'Email not found' });
  }
  const tokens = await loadResets();
  const token = crypto.randomBytes(20).toString('hex');
  tokens.push({ token, userId: user.id, expires: Date.now() + 3600000 });
  await saveResets(tokens);
  res.json({ token });
});

app.post('/api/reset', async (req, res) => {
  const { token, password } = req.body;
  const tokens = await loadResets();
  const entry = tokens.find(t => t.token === token && t.expires > Date.now());
  if (!entry) {
    return res.status(400).json({ error: 'Invalid or expired token' });
  }
  const users = await loadUsers();
  const user = users.find(u => u.id === entry.userId);
  if (!user) {
    return res.status(400).json({ error: 'User not found' });
  }
  user.password = await bcrypt.hash(password, 10);
  await saveUsers(users);
  const remaining = tokens.filter(t => t !== entry);
  await saveResets(remaining);
  res.json({ message: 'Password reset successful' });
});

app.get('/api/me', async (req, res) => {
  const auth = req.headers.authorization || '';
  const token = auth.split(' ')[1];
  if (!token) {
    return res.status(401).json({ error: 'No token' });
  }
  try {
    const payload = jwt.verify(token, JWT_SECRET);
    const users = await loadUsers();
    const user = users.find(u => u.id === payload.id);
    if (!user) {
      return res.status(404).json({ error: 'User not found' });
    }
    res.json({
      id: user.id,
      firstname: user.firstname,
      lastname: user.lastname,
      username: user.username,
      email: user.email,
      country_code: user.country_code,
      phone_code: user.phone_code,
      phone: user.phone,
      member_id: user.member_id,
      referral_id: user.referral_id,
      last_login: user.last_login
    });
  } catch (err) {
    res.status(401).json({ error: 'Invalid token' });
  }
});

const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
