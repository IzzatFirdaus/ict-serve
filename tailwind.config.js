import { defineConfig } from 'tailwindcss/lib/cjs/index.js';

export default defineConfig({
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/**/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      // MYDS Color Tokens
      colors: {
        // Primary Colors (MYDS Blue)
        primary: {
          50: '#EFF6FF',
          100: '#DBEAFE',
          200: '#C2D5FF',
          300: '#96B7FF',
          400: '#6394FF',
          500: '#3A75F6',
          600: '#2563EB', // Main MYDS Blue
          700: '#1D4ED8',
          800: '#1E40AF',
          900: '#1E3A8A',
          950: '#172554',
        },
        // Danger Colors
        danger: {
          50: '#FEF2F2',
          100: '#FEE2E2',
          200: '#FECACA',
          300: '#FCA5A5',
          400: '#F87171',
          500: '#EF4444',
          600: '#DC2626',
          700: '#B91C1C',
          800: '#991B1B',
          900: '#7F1D1D',
          950: '#450A0A',
        },
        // Success Colors
        success: {
          50: '#F0FDF4',
          100: '#DCFCE7',
          200: '#BBF7D0',
          300: '#86EFAC',
          400: '#4ADE80',
          500: '#22C55E',
          600: '#16A34A',
          700: '#15803D',
          800: '#166534',
          900: '#14532D',
          950: '#052E16',
        },
        // Warning Colors
        warning: {
          50: '#FFFBEB',
          100: '#FEF3C7',
          200: '#FDE68A',
          300: '#FCD34D',
          400: '#FBBF24',
          500: '#F59E0B',
          600: '#D97706',
          700: '#B45309',
          800: '#92400E',
          900: '#78350F',
          950: '#451A03',
        },
        // Enhanced Gray Scale with MYDS specific grays
        gray: {
          50: '#FAFAFA',
          100: '#F4F4F5',
          200: '#E4E4E7',
          300: '#D4D4D8',
          400: '#A1A1AA',
          500: '#71717A',
          600: '#52525B',
          700: '#3F3F46',
          800: '#27272A',
          850: '#1D1D21', // MYDS specific
          900: '#18181B',
          930: '#161619', // MYDS specific
          950: '#09090B',
        },
      },
      
      // MYDS Typography
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'], // Headings
        'inter': ['Inter', 'sans-serif'],     // Body text
        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      
      // MYDS Typography Sizes
      fontSize: {
        // Body Text Sizes
        'body-2xs': ['0.625rem', { lineHeight: '0.75rem' }],   // 10px
        'body-xs': ['0.75rem', { lineHeight: '1.125rem' }],    // 12px
        'body-sm': ['0.875rem', { lineHeight: '1.25rem' }],    // 14px
        'body-base': ['1rem', { lineHeight: '1.5rem' }],       // 16px
        'body-lg': ['1.125rem', { lineHeight: '1.625rem' }],   // 18px
        'body-xl': ['1.25rem', { lineHeight: '1.75rem' }],     // 20px
        'body-2xl': ['1.5rem', { lineHeight: '2rem' }],        // 24px
        'body-3xl': ['1.875rem', { lineHeight: '2.375rem' }],  // 30px
        'body-4xl': ['2.25rem', { lineHeight: '2.75rem' }],    // 36px
        'body-5xl': ['3rem', { lineHeight: '3.75rem' }],       // 48px
        'body-6xl': ['3.75rem', { lineHeight: '4.5rem' }],     // 60px
        
        // Heading Sizes
        'heading-4xs': ['0.875rem', { lineHeight: '1.25rem' }], // 14px
        'heading-3xs': ['1rem', { lineHeight: '1.5rem' }],      // 16px
        'heading-2xs': ['1.25rem', { lineHeight: '1.75rem' }],  // 20px
        'heading-xs': ['1.5rem', { lineHeight: '2rem' }],       // 24px
        'heading-sm': ['1.875rem', { lineHeight: '2.375rem' }], // 30px
        'heading-md': ['2.25rem', { lineHeight: '2.75rem' }],   // 36px
        'heading-lg': ['3rem', { lineHeight: '3.75rem' }],      // 48px
        'heading-xl': ['3.75rem', { lineHeight: '4.5rem' }],    // 60px
      },
      
      // MYDS Spacing (12-8-4 Grid System)
      spacing: {
        // Grid gaps
        'grid-gap-mobile': '18px',
        'grid-gap-tablet': '24px',
        'grid-gap-desktop': '24px',
        // Container padding
        'container-mobile': '18px',
        'container-tablet': '24px',
        'container-desktop': '24px',
      },
      
      // MYDS Breakpoints for 12-8-4 Grid
      screens: {
        'mobile': '320px',
        'tablet': '768px',
        'desktop': '1024px',
        'wide': '1280px',
      },
      
      // MYDS Grid System
      gridTemplateColumns: {
        // Mobile: 4 columns
        'mobile-4': 'repeat(4, minmax(0, 1fr))',
        // Tablet: 8 columns
        'tablet-8': 'repeat(8, minmax(0, 1fr))',
        // Desktop: 12 columns
        'desktop-12': 'repeat(12, minmax(0, 1fr))',
      },
      
      // MYDS Shadows
      boxShadow: {
        'myds-sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
        'myds-md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
        'myds-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        'myds-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
      },
      
      // MYDS Border Radius
      borderRadius: {
        'myds-sm': '0.25rem',   // 4px
        'myds-md': '0.375rem',  // 6px
        'myds-lg': '0.5rem',    // 8px
        'myds-xl': '0.75rem',   // 12px
      },
      
      // Animation and Transitions
      transitionDuration: {
        '150': '150ms',
        '200': '200ms',
        '300': '300ms',
      },
    },
  },
  
  plugins: [
    // MYDS Grid System Plugin
    function({ addUtilities, theme }) {
      addUtilities({
        // MYDS Container
        '.myds-container': {
          'width': '100%',
          'max-width': '1280px',
          'margin-left': 'auto',
          'margin-right': 'auto',
          'padding-left': theme('spacing.container-mobile'),
          'padding-right': theme('spacing.container-mobile'),
          '@media (min-width: 768px)': {
            'padding-left': theme('spacing.container-tablet'),
            'padding-right': theme('spacing.container-tablet'),
          },
          '@media (min-width: 1024px)': {
            'padding-left': theme('spacing.container-desktop'),
            'padding-right': theme('spacing.container-desktop'),
          },
        },
        
        // MYDS Grid
        '.myds-grid': {
          'display': 'grid',
          'gap': theme('spacing.grid-gap-mobile'),
          'grid-template-columns': theme('gridTemplateColumns.mobile-4'),
          '@media (min-width: 768px)': {
            'gap': theme('spacing.grid-gap-tablet'),
            'grid-template-columns': theme('gridTemplateColumns.tablet-8'),
          },
          '@media (min-width: 1024px)': {
            'gap': theme('spacing.grid-gap-desktop'),
            'grid-template-columns': theme('gridTemplateColumns.desktop-12'),
          },
        },
        
        // MYDS Article Container (max 640px for readability)
        '.myds-article': {
          'max-width': '640px',
          'margin-left': 'auto',
          'margin-right': 'auto',
        },
        
        // MYDS Typography Classes
        '.myds-heading': {
          'font-family': theme('fontFamily.poppins').join(', '),
          'font-weight': '500',
        },
        '.myds-body': {
          'font-family': theme('fontFamily.inter').join(', '),
          'font-weight': '400',
        },
      });
    },
  ],
});
