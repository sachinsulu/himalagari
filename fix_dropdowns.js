const fs = require('fs');
const files = [
  'template/web/package_listing.css',
  'template/web/package-inner.css',
  'template/web/holiday_types_inner.css',
  'template/web/contact.css',
  'template/web/blog_listing.css',
  'template/web/blog.css',
  'template/web/about.css',
  'template/web/style.css'
];

files.forEach(file => {
  if (fs.existsSync(file)) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Fix the dropdown bug
    content = content.replace(/\.navbar \.dropdown-menu \.show/g, '.navbar .dropdown-menu.show');
    
    // Also remove the restrictive position:absolute!important which hid the dropdown
    content = content.replace(/position:\s*absolute\s*!important;\s*\n\s*top:\s*100%;/g, 'top: 100%;');
    
    fs.writeFileSync(file, content);
    console.log(`Fixed dropdown in ${file}`);
  }
});
