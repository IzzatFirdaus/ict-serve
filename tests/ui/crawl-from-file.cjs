const fs = require('fs');
const path = require('path');
const { JSDOM } = require('jsdom');

const rootHtml = fs.readFileSync(path.resolve(__dirname,'root.html'),'utf8');
const dom = new JSDOM(rootHtml);
const anchors = [...dom.window.document.querySelectorAll('a[href]')];
const base = 'http://127.0.0.1:8000';
function normalize(href){
  if (!href) return null;
  if (href.startsWith('#')) return null;
  if (href.startsWith('mailto:')) return null;
  if (href.startsWith('http') && !href.startsWith(base)) return null;
  if (href.startsWith('http')) return href.split('#')[0];
  if (href.startsWith('/')) return base + href.split('#')[0];
  return base + '/' + href.split('#')[0];
}
const urls = new Set();
anchors.forEach(a => { const n = normalize(a.getAttribute('href')); if (n) urls.add(n); });
fs.writeFileSync(path.resolve(__dirname,'crawl-results.json'), JSON.stringify(Array.from(urls), null, 2));
console.log('Wrote', urls.size, 'urls to crawl-results.json');
