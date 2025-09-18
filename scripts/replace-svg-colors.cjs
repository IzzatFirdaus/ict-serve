const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'resources', 'views', 'welcome.blade.php');

// Read the file
let content = fs.readFileSync(filePath, 'utf8');

// Replace stroke="#1B1B18" with class="svg-stroke-dark"
content = content.replace(/stroke="#1B1B18"/g, 'class="svg-stroke-dark"');

// Replace stroke="#FF750F" with class="svg-stroke-orange" 
content = content.replace(/stroke="#FF750F"/g, 'class="svg-stroke-orange"');

// Write the file back
fs.writeFileSync(filePath, content, 'utf8');

console.log('SVG color replacements completed');