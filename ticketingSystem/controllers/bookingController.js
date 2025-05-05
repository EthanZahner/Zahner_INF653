const Booking = require('../models/Booking');
const Event = require('../models/Event');
const QRCode = require('qrcode');   // for bonus feature
const nodemailer = require('nodemailer'); //for bonus email

// Get all bookings for the logged-in user
exports.getUserBookings = async (req, res) => {
  try {
    const userId = req.user.userId;  // `req.user` will be set by auth middleware after verifying JWT
    const bookings = await Booking.find({ user: userId }).populate('event');
    res.json(bookings);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Failed to fetch bookings" });
  }
};

//get booking by ID (ensure it belongs to the logged-in user)
exports.getBookingById = async (req, res) => {
  try {
    const booking = await Booking.findById(req.params.id).populate('event');
    if (!booking) {
      return res.status(404).json({ error: "Booking not found" });
    }
    // check ownership
    if (booking.user.toString() !== req.user.userId && req.user.role !== 'admin') {
      return res.status(403).json({ error: "Access denied to this booking" });
    }
    res.json(booking);
  } catch (err) {
    console.error(err);
    res.status(400).json({ error: "Invalid booking ID" });
  }
};

// Create a new booking (ticket purchase)
exports.createBooking = async (req, res) => {
  try {
    const userId = req.user.userId;
    const { eventId, quantity } = req.body;
    if (!eventId || !quantity) {
      return res.status(400).json({ error: "eventId and quantity are required" });
    }
    const event = await Event.findById(eventId);
    if (!event) {
      return res.status(404).json({ error: "Event not found" });
    }
    // Check seat availability
    if (quantity <= 0) {
      return res.status(400).json({ error: "Quantity must be at least 1" });
    }
    if (event.bookedSeats + quantity > event.seatCapacity) {
      return res.status(400).json({ error: "Not enough seats available" });
    }
    // create booking
    const booking = new Booking({
      user: userId,
      event: eventId,
      quantity: quantity
    });
    //(Bonus: generate QR code and attach to booking.qrCode)
    const qrDataUrl = await QRCode.toDataURL(String(booking._id));
    booking.qrCode = qrDataUrl;

    await booking.save();
    //Update event's bookedSeats count
    event.bookedSeats += quantity;
    await event.save();
    res.status(201).json(booking);
    // (Bonus: send confirmation email after creation)
    // Configure mail transporter (using Gmail)
    let transporter = nodemailer.createTransport({
        service: 'gmail',
        auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASS
        }
    });
    
    // Compose the email
    let mailOptions = {
        from: process.env.EMAIL_USER,
        to: req.user.email,  // we need the user's email
        subject: `Booking Confirmation - ${event.title}`,
        text: `Hello ${req.user.name},\n\nYour booking for "${event.title}" is confirmed. Quantity: ${quantity}.\nThank you!`,
        //include the QR code image:
        html: `<h1>Booking Confirmed</h1>
            <p>Event: ${event.title}</p>
            <p>Tickets: ${quantity}</p>
            ${ booking.qrCode ? `<img src="${booking.qrCode}" alt="QR Code" />` : '' }`
    };
    
    // Send the email
    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
        return console.error('Email send error:', error);
        }
        console.log('Confirmation email sent: ' + info.response);
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Failed to create booking" });
  }
};
// validate ticket
exports.validateTicket = async (req, res) => {
    try {
      const code = req.params.code;  
      const booking = await Booking
        .findById(code)
        .populate('event')
        .populate('user');
  
      if (!booking) {
        return res
          .status(404)
          .json({ valid: false, message: "Ticket not found or invalid." });
      }
  
      return res.json({
        valid: true,
        booking: {
          id: booking._id,
          user: { name: booking.user.name, email: booking.user.email },
          event: { title: booking.event.title, date: booking.event.date },
          quantity: booking.quantity
        }
      });
  
    } catch (err) {
      console.error(err);
      return res
        .status(400)
        .json({ valid: false, message: "Invalid code format." });
    }
  };
  