const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const enPath = path.join(root, 'resources', 'lang', 'en.json');
const msPath = path.join(root, 'resources', 'lang', 'ms.json');

function readJson(filePath) {
  try {
    return JSON.parse(fs.readFileSync(filePath, 'utf8'));
  } catch (e) {
    console.error('Failed to read/parse', filePath, e.message);
    process.exit(2);
  }
}

function flatten(obj, prefix = '', out = {}) {
  if (typeof obj !== 'object' || obj === null) {
    out[prefix] = obj;
    return out;
  }
  if (Array.isArray(obj)) {
    out[prefix] = obj;
    return out;
  }
  const keys = Object.keys(obj);
  if (keys.length === 0 && prefix) {
    out[prefix] = {};
    return out;
  }
  for (const k of keys) {
    const v = obj[k];
    const next = prefix ? `${prefix}.${k}` : k;
    flatten(v, next, out);
  }
  return out;
}

function unflatten(flat) {
  const out = {};
  for (const key of Object.keys(flat)) {
    const parts = key.split('.');
    let dst = out;
    for (let i = 0; i < parts.length; i++) {
      const p = parts[i];
      if (i === parts.length - 1) {
        dst[p] = flat[key];
      } else {
        if (typeof dst[p] !== 'object' || dst[p] === null) dst[p] = {};
        dst = dst[p];
      }
    }
  }
  return out;
}

const en = readJson(enPath);
const ms = readJson(msPath);

const flatEn = flatten(en);
const flatMs = flatten(ms);

const added = [];
for (const key of Object.keys(flatEn)) {
  if (!(key in flatMs)) {
    // add with empty string placeholder
    flatMs[key] = "";
    added.push(key);
  }
}

const merged = unflatten(flatMs);

// write backup
fs.writeFileSync(msPath + '.bak', JSON.stringify(ms, null, 2), 'utf8');
fs.writeFileSync(msPath, JSON.stringify(merged, null, 2), 'utf8');

console.log('Added keys:', added.length);
for (const k of added) console.log(k);
if (added.length === 0) console.log('No keys added.');
