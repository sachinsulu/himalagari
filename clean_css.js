const fs = require('fs');
const files = [
  'template/web/package_listing.css',
  'template/web/package-inner.css',
  'template/web/holiday_types_inner.css',
  'template/web/contact.css',
  'template/web/blog_listing.css',
  'template/web/blog.css',
  'template/web/about.css'
];

files.forEach(file => {
  if (fs.existsSync(file)) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Attempt to remove all .package-card blocks that aren't specific to something else.
    // It's safer to just replace .package-card { ... } completely.
    content = content.replace(/\.package-card\s*\{[\s\S]*?\}/g, '');
    content = content.replace(/\.card-info-wrapper\s*\{[\s\S]*?\}/g, '');
    content = content.replace(/\.info-row\s*\{[\s\S]*?\}/g, '');
    content = content.replace(/\.row-divider\s*\{[\s\S]*?\}/g, '');
    content = content.replace(/\.action-row\s*\{[\s\S]*?\}/g, '');
    
    fs.writeFileSync(file, content);
    console.log(`Cleaned ${file}`);
  }
});
