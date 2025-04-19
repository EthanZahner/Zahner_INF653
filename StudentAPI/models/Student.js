const mongoose = require('mongoose');

// Define the Student schema
const studentSchema = new mongoose.Schema({
  firstName: {
    type: String,
    required: [true, 'First name is required'],
    trim: true
  },
  lastName: {
    type: String,
    required: [true, 'Last name is required'],
    trim: true
  },
  email: {
    type: String,
    required: [true, 'Email is required'],
    unique: true,
    trim: true,
    lowercase: true,
    match: [/.+@.+\..+/, 'Please fill a valid email address']
  },
  course: {
    type: String,
    required: [true, 'Course is required'],
    trim: true
  },
  enrolledDate: {
    type: Date,
    default: Date.now
  }
});

// create and export the model
const Student = mongoose.model('Student', studentSchema);
module.exports = Student;
