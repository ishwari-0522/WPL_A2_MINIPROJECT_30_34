const express = require('express')
const cors = require('cors')
const dotenv = require('dotenv')
dotenv.config();
const db = require('./config/db');
const authRoutes = require('./routes/authRoutes');



const app = express();
app.use(cors());
app.use(express.json());
app.use('/api/auth', authRoutes);

app.get('/',(req,res) => {
res.json({ message: 'Microfinance app running!!' });
});

const PORT =process.env.PORT || 5000 ;
app.listen(PORT, ()=> {
    console.log(`server running on http://localhost:${PORT}`);
});