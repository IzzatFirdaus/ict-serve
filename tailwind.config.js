import { defineConfig } from 'tailwindcss';

export default defineConfig({
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.css',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/**/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  // Ensure commonly-applied spacing utilities are always available to @apply
  // This avoids "unknown utility" errors when @apply is used in component CSS
  // (especially for vendor or CSS-module-like processing where the classes
  // may not be picked up by content scanning before CSS is processed).
  safelist: [
    { pattern: /^p[trblxy]?-(?:1|2|3|4|5|6|8|10|12|16)$/ },
    { pattern: /^px-(?:1|2|3|4|5|6|8|10|12|16)$/ },
    { pattern: /^py-(?:1|2|3|4|5|6|8|10|12|16)$/ },
  ],
  darkMode: 'class', // Enable class-based dark mode
  theme: {
    extend: {
  // Complete Color Token System
      colors: {
        // White
        white: '#FFFFFF',

  // Primary Colors - Light Mode
        primary: {
          50: '#EFF6FF', // primary-50
          100: '#DBEAFE', // primary-100
          200: '#C2D5FF', // primary-200
          300: '#96B7FF', // primary-300
          400: '#6394FF', // primary-400
          500: '#3A75F6', // primary-500
          600: '#2563EB', // primary-600 - Main Blue
          700: '#1D4ED8', // primary-700
          800: '#1E40AF', // primary-800
          900: '#1E3A8A', // primary-900
          950: '#172554', // primary-950
        },

        // Danger Colors - Light Mode
        danger: {
          50: '#FEF2F2', // danger-50
          100: '#FEE2E2', // danger-100
          200: '#FECACA', // danger-200
          300: '#FCA5A5', // danger-300
          400: '#F87171', // danger-400
          500: '#EF4444', // danger-500
          600: '#DC2626', // danger-600
          700: '#B91C1C', // danger-700
          800: '#991B1B', // danger-800
          900: '#7F1D1D', // danger-900
          950: '#450A0A', // danger-950
        },

        // Success Colors - Light Mode
        success: {
          50: '#F0FDF4', // success-50
          100: '#DCFCE7', // success-100
          200: '#BBF7D0', // success-200
          300: '#86EFAC', // success-300
          400: '#4ADE80', // success-400
          500: '#22C55E', // success-500
          600: '#16A34A', // success-600
          700: '#15803D', // success-700
          800: '#166534', // success-800
          900: '#14532D', // success-900
          950: '#052E16', // success-950
        },

        // Warning Colors - Light Mode
        warning: {
          50: '#FFFBEB', // warning-50
          100: '#FEF3C7', // warning-100
          200: '#FDE68A', // warning-200
          300: '#FCD34D', // warning-300
          400: '#FBBF24', // warning-400
          500: '#F59E0B', // warning-500
          600: '#D97706', // warning-600
          700: '#B45309', // warning-700
          800: '#92400E', // warning-800
          900: '#78350F', // warning-900
          950: '#451A03', // warning-950
        },

        // Gray Colors - Full Scale for Light & Dark Mode
        gray: {
          50: '#FAFAFA', // gray-50
          100: '#F4F4F5', // gray-100
          200: '#E4E4E7', // gray-200
          300: '#D4D4D8', // gray-300
          400: '#A1A1AA', // gray-400
          500: '#71717A', // gray-500
          600: '#52525B', // gray-600
          700: '#3F3F46', // gray-700
          800: '#27272A', // gray-800
          850: '#1D1D21', // gray-850
          900: '#18181B', // gray-900
          930: '#161619', // gray-930
          950: '#09090B', // gray-950
        },

  // Semantic Color Tokens - Light Mode
        'txt-black': {
          900: '#18181B', // Primary text
          700: '#3F3F46', // Secondary text
          500: '#71717A', // Tertiary text
          400: '#A1A1AA', // Placeholder text
        },

        'bg-white': {
          0: '#FFFFFF', // Main background
          50: '#FAFAFA', // Secondary background
          100: '#F4F4F5', // Tertiary background
        },

        'otl-gray': {
          200: '#E4E4E7', // Light borders
          300: '#D4D4D8', // Medium borders
          400: '#A1A1AA', // Strong borders
        },

        'fr-primary': {
          600: '#2563EB', // Focus ring primary
        },

        'fr-danger': {
          600: '#DC2626', // Focus ring danger
        },

  // Semantic Color Tokens - Dark Mode (via CSS variables)
  // These will be handled by CSS custom properties for theme switching
      },

  // Typography System
      fontFamily: {
  poppins: ['Poppins', 'sans-serif'], // Headings
  inter: ['Inter', 'sans-serif'], // Body text and RTF
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },

  // Typography Sizes (Complete Scale)
      fontSize: {
        // Body Text Sizes (Inter font)
        'body-2xs': [
          '0.625rem',
          {
            lineHeight: '0.75rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 10px
        'body-xs': [
          '0.75rem',
          {
            lineHeight: '1.125rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 12px
        'body-sm': [
          '0.875rem',
          {
            lineHeight: '1.25rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 14px
        'body-base': [
          '1rem',
          {
            lineHeight: '1.5rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 16px
        'body-lg': [
          '1.125rem',
          {
            lineHeight: '1.625rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 18px
        'body-xl': [
          '1.25rem',
          {
            lineHeight: '1.75rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 20px
        'body-2xl': [
          '1.5rem',
          {
            lineHeight: '2rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 24px
        'body-3xl': [
          '1.875rem',
          {
            lineHeight: '2.375rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 30px
        'body-4xl': [
          '2.25rem',
          {
            lineHeight: '2.75rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 36px
        'body-5xl': [
          '3rem',
          {
            lineHeight: '3.75rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 48px
        'body-6xl': [
          '3.75rem',
          {
            lineHeight: '4.5rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 60px

        // Heading Sizes (Poppins font)
        'heading-4xs': ['0.875rem', { lineHeight: '1.25rem' }], // 14px - h6
        'heading-3xs': ['1rem', { lineHeight: '1.5rem' }], // 16px - h5
        'heading-2xs': ['1.25rem', { lineHeight: '1.75rem' }], // 20px - h4
        'heading-xs': ['1.5rem', { lineHeight: '2rem' }], // 24px - h3
        'heading-sm': ['1.875rem', { lineHeight: '2.375rem' }], // 30px - h2
        'heading-md': ['2.25rem', { lineHeight: '2.75rem' }], // 36px - h1
        'heading-lg': ['3rem', { lineHeight: '3.75rem' }], // 48px - Heading Large
        'heading-xl': ['3.75rem', { lineHeight: '4.5rem' }], // 60px - Heading Extra Large

        // Rich Text Format (RTF) - Article content (Inter font)
        'rtf-h1': [
          '1.875rem',
          {
            lineHeight: '2.375rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 30px
        'rtf-h2': [
          '1.5rem',
          {
            lineHeight: '2rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 24px
        'rtf-h3': [
          '1.25rem',
          {
            lineHeight: '1.75rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 20px
        'rtf-h4': [
          '1.125rem',
          {
            lineHeight: '1.625rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 18px
        'rtf-h5': [
          '1rem',
          {
            lineHeight: '1.5rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 16px
        'rtf-h6': [
          '0.875rem',
          {
            lineHeight: '1.25rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '0.75rem',
          },
        ], // 14px
        'rtf-p': [
          '1rem',
          {
            lineHeight: '1.75rem',
            listSpacing: '0.375rem',
            paragraphSpacing: '1.75rem',
          },
        ], // 16px with larger paragraph spacing
      },

  // Spacing System (Complete Scale)
      spacing: {
  // Standard Spacing Scale
        1: '4px', // Micro spacing
        2: '8px', // Gap in button groups, fields, labels
        3: '12px', // General component spacing
        4: '16px', // General component spacing
        5: '20px', // General component spacing
        6: '24px', // Gap between sub-sections, cards
        8: '32px', // Gap between main sections
        10: '40px', // Large blocks, outer margins
        12: '48px', // Extra large blocks, outer margins
        16: '64px', // Page-level or major section separation

        // Grid System Spacing
        'grid-gap-mobile': '18px',
        'grid-gap-tablet': '24px',
        'grid-gap-desktop': '24px',

        // Container Padding
        'container-mobile': '18px',
        'container-tablet': '24px',
        'container-desktop': '24px',

        // Article Container (max 640px for readability)
        'article-max': '640px',
        'interactive-chart-max': '740px',
      },

  // 12-8-4 Grid System Breakpoints
      screens: {
        mobile: { max: '767px' }, // Mobile: ≤ 767px (4-column)
        tablet: { min: '768px', max: '1023px' }, // Tablet: 768px - 1023px (8-column)
        desktop: { min: '1024px' }, // Desktop: ≥ 1024px (12-column)
        wide: '1280px', // Maximum content width
      },

  // Grid Template Columns
      gridTemplateColumns: {
        // Mobile: 4 columns
        'mobile-4': 'repeat(4, minmax(0, 1fr))',
        // Tablet: 8 columns
        'tablet-8': 'repeat(8, minmax(0, 1fr))',
        // Desktop: 12 columns
        'desktop-12': 'repeat(12, minmax(0, 1fr))',
      },

  // Shadow System
      boxShadow: {
        none: 'none',
        button: '0px 1px 3px 0px rgba(0, 0, 0, 0.07)',
        card: '0px 2px 6px 0px rgba(0, 0, 0, 0.05), 0px 6px 24px 0px rgba(0, 0, 0, 0.05)',
        'context-menu':
          '0px 2px 6px 0px rgba(0, 0, 0, 0.05), 0px 12px 50px 0px rgba(0, 0, 0, 0.10)',
      },

  // Border Radius System
      borderRadius: {
        xs: '4px', // radius-xs - Extra Small
        s: '6px', // radius-s - Small
        m: '8px', // radius-m - Medium
        l: '12px', // radius-l - Large
        xl: '14px', // radius-xl - Extra Large
        full: '9999px', // radius-full - Fully rounded
      },

  // Motion System
      transitionDuration: {
        instant: '0ms', // No transition
        short: '200ms', // Small UI elements
        medium: '400ms', // Medium UI elements
        long: '600ms', // Large UI elements
        1000: '1000ms', // Custom duration
      },

      transitionTimingFunction: {
        linear: 'cubic-bezier(0, 0, 1, 1)',
        easeout: 'cubic-bezier(0, 0, 0.58, 1)',
        easeoutback: 'cubic-bezier(0.4, 1.4, 0.2, 1)',
      },

  // Component Sizes
      height: {
        'button-sm': '32px',
        'button-md': '40px',
        'button-lg': '48px',
        'input-sm': '32px',
        'input-md': '40px',
        'input-lg': '48px',
      },

      minHeight: {
        'button-sm': '32px',
        'button-md': '40px',
        'button-lg': '48px',
      },

  // Maximum Widths
      maxWidth: {
        article: '640px', // Article container max width
        interactive: '740px', // Interactive charts/images max width
        container: '1280px', // Maximum content container width
      },
    },
  },

  plugins: [
  // Component Plugin - Full Component System
    function ({ addUtilities, addComponents, theme }) {
  // Layout Utilities
      addUtilities({
        // ...existing code...
      });

      // ...existing code...
    },
  ],
});
