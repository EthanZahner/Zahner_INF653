const express = require('express');
const eventController = require('../controllers/eventController');
const auth = require('../middleware/auth');          //our auth JWT middleware
const router = express.Router();

// Public routes
router.get('/', eventController.getEvents);         // GET /api/events (list & filter)
router.get('/:id', eventController.getEventById);   // GET /api/events/:id

// protected admin routes
router.post('/', auth.verifyToken, auth.isAdmin, eventController.createEvent);      // POST /api/events
router.put('/:id', auth.verifyToken, auth.isAdmin, eventController.updateEvent);    // PUT /api/events/:id
router.delete('/:id', auth.verifyToken, auth.isAdmin, eventController.deleteEvent); // DELETE /api/events/:id
router.get('/report/bookings-per-event', auth.verifyToken, auth.isAdmin, eventController.getEventsWithBookings);


module.exports = router;
