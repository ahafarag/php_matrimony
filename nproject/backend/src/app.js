// backend/src/app.js
const path = require('path');

// 1) Load env ASAP from backend/.env (parent of /src)
require('dotenv').config({ path: path.resolve(__dirname, '../.env') });

// 2) Fail fast if missing
if (!process.env.MONGODB_URI) {
  console.error('❌ MONGODB_URI is missing. Expected .env at:', path.resolve(__dirname, '../.env'));
  process.exit(1);
}

const express = require('express');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');

// 3) Only now import routes (they might read env)
const apiRoutes = require('./routes/api');

const app = express();
const PORT = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use('/api', apiRoutes);

// 4) Connect with a small timeout and optional dbName
mongoose.connect(process.env.MONGODB_URI, {
  dbName: process.env.MONGODB_DB,            // optional
  serverSelectionTimeoutMS: 10000,
}).then(() => {
  console.log('✅ MongoDB connected');
}).catch(err => {
  console.error('❌ MongoDB connection error:', err.message);
  process.exit(1);
});

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
