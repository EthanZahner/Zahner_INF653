const express = require('express');
const bookingController = require('../controllers/bookingController');
const auth = require('../middleware/auth');
const router = express.Router();

//All booking routes require a logged-in user
router.get('/', auth.verifyToken, bookingController.getUserBookings);           // GET /api/bookings
router.get('/:id', auth.verifyToken, bookingController.getBookingById);         // GET /api/bookings/:id
router.post('/', auth.verifyToken, bookingController.createBooking);           // POST /api/bookings

// (Bonus)
router.get('/validate/:code', auth.verifyToken, auth.isAdmin, bookingController.validateTicket);

module.exports = router;

