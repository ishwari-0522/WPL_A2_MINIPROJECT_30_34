const express = require('express');
const router = express.Router();
const { makeRepayment, getRepayments } = require('../controllers/repaymentController');
const protect = require('../middleware/authMiddleware');

router.post('/pay', protect, makeRepayment);
router.get('/:loan_id', protect, getRepayments);

module.exports = router;