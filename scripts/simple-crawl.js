const fs = require('fs');
const url = require('url');
const fetch = require('node-fetch');
const { JSDOM } = require('jsdom');

const start = process.argv[2] || 'http://127.0.0.1:8000';
const maxDepth = parseInt(process.argv[3] || '2', 10);
const out = process.argv[4] || 'tmp/crawl/sitemap.json';

const visited = new Set();
const queue = [{ href: start, depth: 0 }];
const origin = new URL(start).origin;

async function crawl() {
  while (queue.length) {
    const { href, depth } = queue.shift();
    if (visited.has(href)) continue;
    console.log('Crawling', href);
    try {
      const res = await fetch(href, { redirect: 'follow', timeout: 10000 });
      if (!res.ok) continue;
      const text = await res.text();
      const dom = new JSDOM(text);
      const anchors = Array.from(dom.window.document.querySelectorAll('a[href]'))
        .map(a => a.getAttribute('href'))
        .filter(h => !!h);
      const normalized = anchors.map(h => {
        try { return new URL(h, href).toString(); } catch (e) { return null; }
      }).filter(u => u && u.startsWith(origin));
      visited.add(href);
      fs.writeFileSync(out, JSON.stringify({ start, origin, pages: Array.from(visited) }, null, 2));
      if (depth < maxDepth) {
        for (const p of normalized) if (!visited.has(p)) queue.push({ href: p, depth: depth + 1 });
      }
    } catch (e) {
      console.error('Error crawling', href, e.message);
    }
  }
  console.log('Crawl complete. Pages:', visited.size);
}

crawl().then(() => process.exit(0)).catch(e => { console.error(e); process.exit(1); });
