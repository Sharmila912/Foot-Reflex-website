const express = require('express');
const multer = require('multer');
const { createCanvas, loadImage } = require('canvas');
const fs = require('fs');
const path = require('path');

const app = express();
const port = 3000;

// Configure multer for file uploads
const upload = multer({ dest: 'uploads/' });

app.use(express.static('public'));

// Handle form submission
app.post('/generate-certificate', upload.single('photo'), async (req, res) => {
    const { name, initials } = req.body;
    const photoPath = req.file.path;

    try {
        // Load image and create canvas
        const canvas = createCanvas(800, 600);
        const ctx = canvas.getContext('2d');

        // Fill background
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Draw certificate text
        ctx.fillStyle = '#2a7f62';
        ctx.font = '30px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('Certificate of Completion', canvas.width / 2, 100);
        ctx.font = '20px Arial';
        ctx.fillText(`Awarded to ${name}`, canvas.width / 2, 200);
        ctx.fillText(`Initials: ${initials}`, canvas.width / 2, 250);

        // Load and draw photo
        const photo = await loadImage(photoPath);
        ctx.drawImage(photo, 150, 300, 150, 150);

        // Save certificate
        const outputPath = path.join('certificates', `${name.replace(/\s+/g, '_')}_certificate.png`);
        fs.writeFileSync(outputPath, canvas.toBuffer());

        // Clean up uploaded photo
        fs.unlinkSync(photoPath);

        // Send response
        res.json({ message: 'Certificate generated', url: outputPath });
    } catch (error) {
        console.error('Error generating certificate:', error);
        res.status(500).json({ error: 'Failed to generate certificate' });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
