class ConverterController {
    async convertPhpToJson(req, res) {
        try {
            const phpData = req.body; // Assuming PHP data is sent in the request body
            const jsonData = await phpToJson(phpData); // Convert PHP to JSON using utility function
            res.json(jsonData);
        } catch (error) {
            res.status(500).json({ error: 'Conversion to JSON failed', details: error.message });
        }
    }

    async convertPhpToXml(req, res) {
        try {
            const phpData = req.body; // Assuming PHP data is sent in the request body
            const xmlData = await phpToXml(phpData); // Convert PHP to XML using utility function
            res.type('application/xml').send(xmlData);
        } catch (error) {
            res.status(500).json({ error: 'Conversion to XML failed', details: error.message });
        }
    }
}

module.exports = ConverterController;