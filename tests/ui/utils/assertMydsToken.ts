import { Page } from '@playwright/test';

const TOKEN_MAP: Record<string, string> = {
  'primary-50': '#EFF6FF',
  'primary-100': '#DBEAFE',
  'primary-200': '#C2D5FF',
  'primary-300': '#96B7FF',
  'primary-400': '#6394FF',
  'primary-500': '#3A75F6',
  'primary-600': '#2563EB',
  'primary-700': '#1D4ED8',
  'primary-800': '#1E40AF',
  'primary-900': '#1E3A8A',
  'txt-white': '#FFFFFF',
  'txt-black-900': '#18181B',
  'gray-50': '#FAFAFA',
  'gray-100': '#F4F4F5',
  'otl-primary-300': '#96B7FF',
  'fr-primary': '#96B7FF'
};

export async function assertMydsToken(page: Page, selector: string, property: 'background-color' | 'color' | 'border-color', tokenName: string) {
  const expectedHex = TOKEN_MAP[tokenName];
  if (!expectedHex) throw new Error(`Unknown token ${tokenName}`);
  const el = await page.locator(selector).first();
  const value = await el.evaluate((e, prop) => getComputedStyle(e as Element).getPropertyValue(prop), property);
  // normalize rgb/hex
  const normalized = rgbToHex(value.trim());
  if (normalized.toLowerCase() !== expectedHex.toLowerCase()) {
    throw new Error(`Token mismatch for ${selector} ${property}: expected ${expectedHex} got ${normalized}`);
  }
}

function rgbToHex(input: string) {
  // input like 'rgb(37,99,235)', 'rgba(37,99,235,1)', or '#2563EB'
  if (!input) return input;
  const s = input.trim();
  if (s.startsWith('#')) return s.toUpperCase();
  const m = s.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
  if (!m) return s;
  const r = parseInt(m[1], 10);
  const g = parseInt(m[2], 10);
  const b = parseInt(m[3], 10);
  return ('#' + [r, g, b].map(x => x.toString(16).padStart(2, '0')).join('')).toUpperCase();
}
