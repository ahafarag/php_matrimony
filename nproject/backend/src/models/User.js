const mongoose = require('mongoose');

const userSchema = new mongoose.Schema({
    email: { type: String, required: true, unique: true },
    password: { type: String, required: true },
    role: { type: String, default: 'user' },
    kycCompleted: { type: Boolean, default: false }
    // Add other fields as needed
});

module.exports = mongoose.model('User', userSchema);