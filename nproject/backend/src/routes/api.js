const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const ConverterController = require('../controllers/converterController');
const converterController = new ConverterController();
const authenticate = require('../middleware/authenticate');
const authorizeAdmin = require('../middleware/authorizeAdmin');
const kyc = require('../middleware/kyc');

// Registration
router.get('/register', authController.showRegister); // GET /api/register
router.post('/register', authController.register);    // POST /api/register

// Login
router.get('/login', authController.showLogin);       // GET /api/login
router.post('/login', authController.login);          // POST /api/login

// Forgot Password
router.get('/forgot-password', authController.showForgotPassword); // GET /api/forgot-password
router.post('/forgot-password', authController.forgotPassword);    // POST /api/forgot-password

// Reset Password
router.get('/reset-password/:token', authController.showResetPassword); // GET /api/reset-password/:token
router.post('/reset-password', authController.resetPassword);           // POST /api/reset-password

// Email Verification
router.get('/verify-email', authController.showVerifyEmail); // GET /api/verify-email
router.get('/verify-email/:id/:hash', authController.verifyEmail); // GET /api/verify-email/:id/:hash
router.post('/email/verification-notification', authController.sendVerificationEmail); // POST /api/email/verification-notification

// Confirm Password
router.get('/confirm-password', authController.showConfirmPassword); // GET /api/confirm-password
router.post('/confirm-password', authController.confirmPassword);    // POST /api/confirm-password

// Logout
router.post('/logout', authController.logout); // POST /api/logout

// Converter Routes
router.post('/api/convert/php-to-json', converterController.convertPhpToJson.bind(converterController));
router.post('/api/convert/php-to-xml', converterController.convertPhpToXml.bind(converterController));

// Example: Protect admin dashboard
router.get('/admin/dashboard', authenticate, authorizeAdmin, (req, res) => {
    res.json({ message: 'Admin dashboard' });
});

// Example: Protect KYC-required route
router.get('/user/profile', authenticate, kyc, (req, res) => {
    res.json({ message: 'User profile with KYC' });
});

// Test DB Connection and List Collections
router.get('/test-db', async (req, res) => {
    try {
        const mongoose = require('mongoose');
        if (!mongoose.connection.readyState || !mongoose.connection.db) {
            return res.status(500).json({ status: 'error', error: res.error });
        }
        const collections = await mongoose.connection.db.listCollections().toArray();
        res.json({ status: 'success', collections });
    } catch (err) {
        res.status(500).json({ status: 'error', error: err.message });
    }
});

module.exports = router;