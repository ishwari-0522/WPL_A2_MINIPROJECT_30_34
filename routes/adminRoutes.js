const express = require('express');
const router = express.Router();
const { getAllLoans, updateLoanStatus } = require('../controllers/adminController');
const protect = require('../middleware/authMiddleware');

router.get('/loans', protect, getAllLoans);
router.put('/loans/:id', protect, updateLoanStatus);

module.exports = router;