const express = require('express');
const router = express.Router();
const { applyLoan, getMyLoans } = require('../controllers/loanController');
const protect = require('../middleware/authMiddleware');

router.post('/apply', protect, applyLoan);
router.get('/my-loans', protect, getMyLoans);

module.exports = router;