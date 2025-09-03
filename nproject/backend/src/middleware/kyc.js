const authenticate = require('../middleware/authenticate');
const authorizeAdmin = require('../middleware/authorizeAdmin');
const kyc = require('../middleware/kyc');

module.exports = (req, res, next) => {
    if (!req.user || !req.user.kycCompleted) {
        return res.status(403).json({ message: 'KYC not completed' });
    }
    next();
};