const fs = require('fs');
const path = require('path');
const { JSDOM } = require('jsdom');
const fetch = require('node-fetch');

(async function main() {
  const base = 'http://127.0.0.1:8000';
  const out = [];
  const seen = new Set();

  function normalize(href) {
    if (!href) return null;
    if (href.startsWith('#')) return null;
    if (href.startsWith('mailto:')) return null;
    if (href.startsWith('http') && !href.startsWith(base)) return null;
    if (href.startsWith('http')) return href.split('#')[0];
    if (href.startsWith('/')) return base + href.split('#')[0];
    return base + '/' + href.split('#')[0];
  }

  async function extract(url) {
    if (!url || seen.has(url)) return;
    seen.add(url);
    try {
      const res = await fetch(url, { timeout: 10000 });
      const text = await res.text();
      out.push({ url, status: res.status });
      const dom = new JSDOM(text);
      const anchors = [...dom.window.document.querySelectorAll('a[href]')];
      for (const a of anchors) {
        const n = normalize(a.getAttribute('href'));
        if (n) await extract(n);
      }
    } catch (e) {
      out.push({ url, error: String(e) });
    }
  }

  await extract(base + '/');
  fs.writeFileSync(
    path.resolve(__dirname, 'crawl-results.json'),
    JSON.stringify(out, null, 2)
  );
  console.log('Crawl finished. Found', out.length, 'entries.');
})();
