//register
const bcrypt = require('bcrypt');
const User = require('../models/User');
const jwt = require('jsonwebtoken');

exports.register = async (req, res) => {
  try {
    const { name, email, password } = req.body;
    // Basic validation
    if (!name || !email || !password) {
      return res.status(400).json({ error: "Name, email, and password are required." });
    }
    // Hash the password
    const hashedPassword = await bcrypt.hash(password, 10);  // saltRounds = 10:contentReference[oaicite:8]{index=8}
    //Create and save the new user
    const user = new User({ name, email, password: hashedPassword });
    user.role = 'user';  // ensure role is 'user' by default
    await user.save();
    res.status(201).json({ message: "User registered successfully!" });
  } catch (err) {
    if (err.code === 11000) {
      //duplicate key error (email already exists)
      return res.status(400).json({ error: "Email already in use." });
    }
    console.error(err);
    res.status(500).json({ error: "Server error during registration." });
  }
};

exports.login = async (req, res) => {
  try {
    const { email, password } = req.body;
    if (!email || !password) {
      return res.status(400).json({ error: "Email and password are required." });
    }
    const user = await User.findOne({ email });
    if (!user) {
      return res.status(400).json({ error: "Invalid credentials" });
    }
    // Check password
    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch) {
      return res.status(400).json({ error: "Invalid credentials" });
    }
    // Generate JWT token
    const payload = { userId: user._id, role: user.role };
    const token = jwt.sign(payload, process.env.JWT_SECRET, { expiresIn: '1h' });  // token valid for 1 hour:contentReference[oaicite:10]{index=10}
    res.json({ token });  // send the token to client
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error during login." });
  }
};
