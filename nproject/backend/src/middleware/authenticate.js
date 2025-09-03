const jwt = require('jsonwebtoken');

module.exports = (req, res, next) => {
    // Example: Check for JWT token in Authorization header
    const authHeader = req.headers.authorization;
    if (!authHeader) {
        return res.status(401).json({ message: 'Unauthorized: No token provided' });
    }
    const token = authHeader.split(' ')[1];
    // TODO: Verify token (use JWT or your auth logic)
    try {
        const user = jwt.verify(token, process.env.JWT_SECRET);
        req.user = user; // user object from token payload
        next();
    } catch (err) {
        return res.status(401).json({ message: 'Unauthorized: Invalid token' });
    }
};