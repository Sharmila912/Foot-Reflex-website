const express = require('express');
const app = express();
const port = 3000;

app.use(express.json());
app.use(express.static('public'));

let messages = []; // Store messages

// Endpoint to send a message
app.post('/send-message', (req, res) => {
    const userMessage = req.body.message;
    messages.push({ from: 'user', text: userMessage });
    
    // Simple admin response
    const adminResponse = 'Thank you for your message. We will get back to you shortly.';
    messages.push({ from: 'admin', text: adminResponse });

    res.json({ reply: adminResponse });
});

// Endpoint to get all messages (for admin)
app.get('/admin/messages', (req, res) => {
    res.json(messages);
});

app.listen(port, () => {
    console.log(`Chat server running on http://localhost:${port}`);
});
