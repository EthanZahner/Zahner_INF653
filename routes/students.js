// routes/students.js
// ------------------
const express = require('express');
const router  = express.Router();

const {
  getAllStudents,
  getStudentById,
  createStudent,
  updateStudent,
  deleteStudent
} = require('../controllers/studentController');

// @route   GET /students
router.get('/', getAllStudents);

// @route   GET /students/:id
router.get('/:id', getStudentById);

// @route   POST /students
router.post('/', createStudent);

// @route   PUT /students/:id
router.put('/:id', updateStudent);

// @route   DELETE /students/:id
router.delete('/:id', deleteStudent);

module.exports = router;
