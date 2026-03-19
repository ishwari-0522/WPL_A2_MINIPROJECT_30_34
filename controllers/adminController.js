const db = require('../config/db');

const getAllLoans = (req, res) => {
  db.query(
    'SELECT loans.*, users.name, users.email FROM loans JOIN users ON loans.user_id = users.id',
    (err, results) => {
      if (err) return res.status(500).json({ message: 'Failed to fetch loans' });
      res.json(results);
    }
  );
};

const updateLoanStatus = (req, res) => {
  const { status } = req.body;
  const { id } = req.params;

  db.query(
    'UPDATE loans SET status = ? WHERE id = ?',
    [status, id],
    (err, result) => {
      if (err) return res.status(500).json({ message: 'Failed to update loan' });
      res.json({ message: `Loan ${status} successfully!` });
    }
  );
};

module.exports = { getAllLoans, updateLoanStatus };