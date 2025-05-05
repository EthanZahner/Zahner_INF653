const Event = require('../models/Event');
const Booking = require('../models/Booking');

// get all events (with optional filters)
exports.getEvents = async (req, res) => {
  try {
    const { category, date } = req.query;
    const filter = {};
    if (category) filter.category = category;
    if (date) {
      // filter by date
      const dayStart = new Date(date);
      const dayEnd = new Date(date);
      dayEnd.setDate(dayStart.getDate() + 1);
      filter.date = { $gte: dayStart, $lt: dayEnd };
    }
    const events = await Event.find(filter);
    res.json(events);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Failed to retrieve events" });
  }
};

// Get single event by ID
exports.getEventById = async (req, res) => {
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: "Event not found" });
    }
    res.json(event);
  } catch (err) {
    console.error(err);
    res.status(400).json({ error: "Invalid event ID" });  //Cast error or bad ID format
  }
};

// Create a new event (admin only)
exports.createEvent = async (req, res) => {
  try {
    const event = new Event(req.body);
    const saved = await event.save();
    res.status(201).json(saved);
  } catch (err) {
    console.error(err);
    res.status(400).json({ error: "Failed to create event", details: err.message });
  }
};

// update an event (admin only)
exports.updateEvent = async (req, res) => {
  try {
    // Prevent changing seatCapacity to below current bookedSeats
    if (req.body.seatCapacity !== undefined) {
      const existing = await Event.findById(req.params.id);
      if (!existing) return res.status(404).json({ error: "Event not found" });
      if (req.body.seatCapacity < existing.bookedSeats) {
        return res.status(400).json({ error: "seatCapacity cannot be less than already booked seats" });
      }
    }
    const updated = await Event.findByIdAndUpdate(req.params.id, req.body, { new: true, runValidators: true });
    if (!updated) {
      return res.status(404).json({ error: "Event not found" });
    }
    res.json(updated);
  } catch (err) {
    console.error(err);
    res.status(400).json({ error: "Failed to update event", details: err.message });
  }
};

//Delete an event (admin only)
exports.deleteEvent = async (req, res) => {
  try {
    // Check for associated bookings
    const bookingExists = await Booking.exists({ event: req.params.id });
    if (bookingExists) {
      return res.status(400).json({ error: "Cannot delete event with existing bookings" });
    }
    const deleted = await Event.findByIdAndDelete(req.params.id);
    if (!deleted) {
      return res.status(404).json({ error: "Event not found" });
    }
    res.json({ message: "Event deleted successfully" });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Failed to delete event" });
  }
};

exports.getEventsWithBookings = async (req, res) => {
    try {
      const events = await Event.find().lean();  // get all events as plain objects
      const result = [];
      for (let event of events) {
        // find all bookings for this event and populate user info
        const bookings = await Booking.find({ event: event._id }).populate('user', 'name email');
        const users = bookings.map(b => ({
          name: b.user.name,
          email: b.user.email,
          quantity: b.quantity
        }));
        result.push({
          event: {
            title: event.title,
            date: event.date,
            venue: event.venue,
            totalBookings: bookings.length
          },
          users: users
        });
      }
      res.json(result);
    } catch (err) {
      console.error(err);
      res.status(500).json({ error: "Failed to generate report" });
    }
  };
  