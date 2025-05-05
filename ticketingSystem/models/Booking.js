const mongoose = require('mongoose');

const bookingSchema = new mongoose.Schema({
  user:        { type: mongoose.Schema.Types.ObjectId, ref: 'User', required: true },
  event:       { type: mongoose.Schema.Types.ObjectId, ref: 'Event', required: true },
  quantity:    { type: Number, required: true },
  bookingDate: { type: Date, default: Date.now }, 
  qrCode:      { type: String }  // will store a QR code (base64) string for bonus feature
}, { timestamps: true });

module.exports = mongoose.model('Booking', bookingSchema);
