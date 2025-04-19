// server.js
require('dotenv').config();
const express   = require('express');
const connectDB = require('./dbConfig');

const app = express();

// connect to Mongo
connectDB();

// parse JSON bodies
app.use(express.json());

// health‑check root
app.get('/', (req, res) => {
  res.send('Student Management API is running');
});

// mount your routes
app.use('/students', require('./routes/students'));

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
