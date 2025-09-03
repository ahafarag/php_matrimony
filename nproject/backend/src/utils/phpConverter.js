module.exports.phpToJson = function(phpData) {
    // Convert PHP array to JSON
    return JSON.stringify(phpData);
};

module.exports.phpToXml = function(phpData) {
    // Convert PHP array to XML
    let xml = '<root>';
    for (const [key, value] of Object.entries(phpData)) {
        xml += `<${key}>${value}</${key}>`;
    }
    xml += '</root>';
    return xml;
};