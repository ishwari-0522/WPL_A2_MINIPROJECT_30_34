const db = require('../config/db');

const applyLoan = (req, res) => {
  const { amount, purpose, duration_months } = req.body;
  const user_id = req.user.id;

  db.query(
    'INSERT INTO loans (user_id, amount, purpose, duration_months) VALUES (?, ?, ?, ?)',
    [user_id, amount, purpose, duration_months],
    (err, result) => {
      if (err) return res.status(500).json({ message: 'Failed to apply for loan' });
      res.status(201).json({ message: 'Loan application submitted successfully!' });
    }
  );
};

const getMyLoans = (req, res) => {
  const user_id = req.user.id;

  db.query(
    'SELECT * FROM loans WHERE user_id = ?',
    [user_id],
    (err, results) => {
      if (err) return res.status(500).json({ message: 'Failed to fetch loans' });
      res.json(results);
    }
  );
};

module.exports = { applyLoan, getMyLoans };