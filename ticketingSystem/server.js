// server.js
require('dotenv').config();              // Load .env file
const express = require('express');
const mongoose = require('mongoose');

const app = express();
app.use(express.json());                // Parse JSON request bodies:contentReference[oaicite:1]{index=1}
app.use('/api/auth', require('./routes/authRoutes'));
app.use('/api/events', require('./routes/eventRoutes'));
app.use('/api/bookings', require('./routes/bookingRoutes'));
// Connect to MongoDB (URI from .env) then start server
mongoose.connect(process.env.MONGO_URI, { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => {
    console.log('Connected to MongoDB');
    //Start Express server after successful DB connection
    const PORT = process.env.PORT || 5000;
    app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
  })
  .catch(err => {
    console.error('Failed to connect to MongoDB', err);
    process.exit(1);
  });

app.get('/', (req, res) => {
    res.send('<h1>Welcome to the Event API</h1><p>Please use the /api endpoints.</p>');
  });

  // Catch-all 404 handler (for any request that didn't match an earlier route)
app.use((req, res) => {
    res.status(404);
    // respond with HTML if client accepts HTML
    if (req.accepts('html')) {
      res.send('<h1>404 Not Found</h1><p>The page you are looking for does not exist.</p>');
      return;
    }
    // respond with JSON if client expects JSON
    if (req.accepts('json')) {
      res.json({ error: '404 Not Found' });
      return;
    }
    // Default to plain text
    res.type('txt').send('404 Not Found');
  });
   
  //Global error handler
  app.use((err, req, res, next) => {
    console.error(err.stack);
    const status = err.status || 500;
    res.status(status);
    res.json({ error: err.message || 'Internal Server Error' });
  });
