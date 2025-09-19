#!/usr/bin/env node
/*
 Simple MYDS linter for Blade/CSS/JS to catch common violations:
 - Hex colors in Blade/HTML files (prefer MYDS tokens)
 - Inline style="..." usage
 - Bootstrap-like classes (btn, btn-primary)
 - Tailwind primary-* utilities in Blade (prefer token utilities or components)
 - Encourage using <x-myds.*> for buttons/inputs
*/
const { readFileSync, readdirSync, statSync } = require('node:fs');
const { join, extname } = require('node:path');

const ROOT = process.cwd();
const TARGET_DIRS = ['resources/views', 'resources/css', 'resources/js'];

const HEX_COLOR = /#[0-9a-fA-F]{3,8}\b/;
// Detect inline style attributes, but ignore Alpine bindings like :style and x-bind:style
const INLINE_STYLE_RAW = /(^|[\s<])style\s*=\s*"[^"]*"/i;
const INLINE_STYLE_ALPINE = /(^|\s)(?::style|x-bind:style)\s*=\s*"[^"]*"/i;
// Match standalone Bootstrap-like btn classes only, not custom tokens like myds-btn-*
const BOOTSTRAP_BTN = /(^|\s)btn(?:-[a-z]+)?(\s|$)/;
// Allow bg-* color utilities and gradients; only flag text|ring|border using primary-* (with optional variant prefixes like hover: or md:)
// But exclude our MYDS semantic tokens like border-otl-primary-*, text-txt-primary, focus:ring-fr-primary
const TAILWIND_PRIMARY =
  /\b(?:[a-z0-9-]+:)*(?:text-primary-|ring-primary-|border-primary-)(?:50|100|200|300|400|500|600|700|800|900|950)\b/;

const ALLOWED_EXTS = new Set([
  '.blade.php',
  '.php',
  '.html',
  '.css',
  '.js',
  '.ts',
  '.vue',
]);

/** @param {string} dir */
function* walk(dir) {
  for (const entry of readdirSync(dir)) {
    const p = join(dir, entry);
    const s = statSync(p);
    if (s.isDirectory()) {
      yield* walk(p);
    } else if (ALLOWED_EXTS.has(extname(p))) {
      yield p;
    }
  }
}

const issues = [];

for (const base of TARGET_DIRS) {
  const dir = join(ROOT, base);
  try {
    for (const file of walk(dir)) {
      const text = readFileSync(file, 'utf8');
      const fileIssues = [];

      if (file.endsWith('.blade.php') || file.endsWith('.html')) {
        let textWithoutAlpine = text.replace(
          /(?::style|x-bind:style)\s*=\s*"[^"]*"/gi,
          ''
        );
        if (INLINE_STYLE_RAW.test(textWithoutAlpine)) {
          fileIssues.push('Inline style attribute found (use classes/tokens)');
        }
      }
      if (file.endsWith('.blade.php') || file.endsWith('.html')) {
        const textWithoutStyleBlocks = text.replace(
          /<style[\s\S]*?>[\s\S]*?<\/style>/gi,
          ''
        );
        const textWithoutEntities = textWithoutStyleBlocks
          .replace(/&#[0-9]+;/g, '')
          .replace(/&#x[0-9a-fA-F]+;/g, '');
        if (HEX_COLOR.test(textWithoutEntities)) {
          fileIssues.push('Hex color detected in markup (use MYDS tokens)');
        }
      }
      if (
        (file.endsWith('.blade.php') || file.endsWith('.html')) &&
        BOOTSTRAP_BTN.test(text)
      ) {
        fileIssues.push('Bootstrap-like btn class found (use <x-myds.button>)');
      }
      if (file.endsWith('.blade.php') && TAILWIND_PRIMARY.test(text)) {
        fileIssues.push(
          'Tailwind primary-* utility used (prefer MYDS token utilities)'
        );
      }

      if (fileIssues.length) {
        issues.push({ file, problems: fileIssues });
      }
    }
  } catch (_) {
    // directory may not exist; ignore
  }
}

if (!issues.length) {
  console.log('MYDS Lint: No issues found. ✅');
  process.exit(0);
}

console.log('MYDS Lint: Issues found');
for (const { file, problems } of issues) {
  for (const p of problems) {
    console.log(` - ${file}: ${p}`);
  }
}
console.log(`\nTotal files with issues: ${issues.length}`);
process.exitCode = 1;
