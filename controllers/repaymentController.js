const db = require('../config/db');

const makeRepayment = (req, res) => {
  const { loan_id, amount_paid, payment_date } = req.body;

  db.query(
    'SELECT * FROM loans WHERE id = ? AND status = "approved"',
    [loan_id],
    (err, results) => {
      if (results.length === 0) {
        return res.status(400).json({ message: 'Loan not found or not approved yet' });
      }

      db.query(
        'INSERT INTO repayments (loan_id, amount_paid, payment_date) VALUES (?, ?, ?)',
        [loan_id, amount_paid, payment_date],
        (err, result) => {
          if (err) return res.status(500).json({ message: 'Repayment failed' });
          res.status(201).json({ message: 'Repayment recorded successfully!' });
        }
      );
    }
  );
};

const getRepayments = (req, res) => {
  const { loan_id } = req.params;

  db.query(
    'SELECT * FROM repayments WHERE loan_id = ?',
    [loan_id],
    (err, results) => {
      if (err) return res.status(500).json({ message: 'Failed to fetch repayments' });
      res.json(results);
    }
  );
};

module.exports = { makeRepayment, getRepayments };