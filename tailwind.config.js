import { defineConfig } from 'tailwindcss/lib/cjs/index.js';

export default defineConfig({
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/**/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  darkMode: 'class', // Enable class-based dark mode
  theme: {
    extend: {
      // MYDS Ring Color Extensions
      ringColor: {
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
        'primary-950': '#172554',
      },

      // MYDS 12-8-4 Grid System
      gridTemplateColumns: {
        // Desktop (≥1024px): 12-column grid
        'myds-12': 'repeat(12, minmax(0, 1fr))',
        // Tablet (768px-1023px): 8-column grid
        'myds-8': 'repeat(8, minmax(0, 1fr))',
        // Mobile (≤767px): 4-column grid
        'myds-4': 'repeat(4, minmax(0, 1fr))',
      },

      // MYDS Font Families
      fontFamily: {
        sans: [
          'Inter',
          'ui-sans-serif',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica Neue',
          'Arial',
          'Noto Sans',
          'sans-serif',
        ],
        heading: [
          'Poppins',
          'ui-sans-serif',
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica Neue',
          'Arial',
          'Noto Sans',
          'sans-serif',
        ],
      },

      // MYDS Complete Color Token System
      colors: {
        // White
        white: '#FFFFFF',

        // Primary Colors (MYDS Blue) - Light Mode
        primary: {
          50: '#EFF6FF', // primary-50
          100: '#DBEAFE', // primary-100
          200: '#C2D5FF', // primary-200
          300: '#96B7FF', // primary-300
          400: '#6394FF', // primary-400
          500: '#3A75F6', // primary-500
          600: '#2563EB', // primary-600 - Main MYDS Blue
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
          850: '#1D1D21', // gray-850 - MYDS specific
          900: '#18181B', // gray-900
          930: '#161619', // gray-930 - MYDS specific
          950: '#09090B', // gray-950
        },

        // MYDS Semantic Color Tokens - Light Mode
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

        // MYDS Semantic Color Tokens - Dark Mode (via CSS variables)
        // These will be handled by CSS custom properties for theme switching
      },

      // MYDS Typography System
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'], // Headings
        inter: ['Inter', 'sans-serif'], // Body text and RTF
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },

      // MYDS Typography Sizes (Complete Scale)
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

      // MYDS Spacing System (Complete Scale)
      spacing: {
        // MYDS Standard Spacing Scale
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

      // MYDS 12-8-4 Grid System Breakpoints
      screens: {
        mobile: { max: '767px' }, // Mobile: ≤ 767px (4-column)
        tablet: { min: '768px', max: '1023px' }, // Tablet: 768px - 1023px (8-column)
        desktop: { min: '1024px' }, // Desktop: ≥ 1024px (12-column)
        wide: '1280px', // Maximum content width
      },

      // MYDS Grid Template Columns
      gridTemplateColumns: {
        // Mobile: 4 columns
        'mobile-4': 'repeat(4, minmax(0, 1fr))',
        // Tablet: 8 columns
        'tablet-8': 'repeat(8, minmax(0, 1fr))',
        // Desktop: 12 columns
        'desktop-12': 'repeat(12, minmax(0, 1fr))',
      },

      // MYDS Shadow System
      boxShadow: {
        none: 'none',
        button: '0px 1px 3px 0px rgba(0, 0, 0, 0.07)',
        card: '0px 2px 6px 0px rgba(0, 0, 0, 0.05), 0px 6px 24px 0px rgba(0, 0, 0, 0.05)',
        'context-menu':
          '0px 2px 6px 0px rgba(0, 0, 0, 0.05), 0px 12px 50px 0px rgba(0, 0, 0, 0.10)',
      },

      // MYDS Border Radius System
      borderRadius: {
        xs: '4px', // radius-xs - Extra Small
        s: '6px', // radius-s - Small
        m: '8px', // radius-m - Medium
        l: '12px', // radius-l - Large
        xl: '14px', // radius-xl - Extra Large
        full: '9999px', // radius-full - Fully rounded
      },

      // MYDS Motion System
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

      // MYDS Component Sizes
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

      // MYDS Maximum Widths
      maxWidth: {
        article: '640px', // Article container max width
        interactive: '740px', // Interactive charts/images max width
        container: '1280px', // Maximum content container width
      },
    },
  },

  plugins: [
    // MYDS Component Plugin - Full Component System
    function ({ addUtilities, addComponents, theme }) {
      // MYDS Layout Utilities
      addUtilities({
        // MYDS Container
        '.myds-container': {
          width: '100%',
          'max-width': theme('maxWidth.container'),
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

        // MYDS 12-8-4 Grid System
        '.myds-grid': {
          display: 'grid',
          gap: theme('spacing.grid-gap-mobile'),
          'grid-template-columns': theme('gridTemplateColumns.mobile-4'),
          '@media (min-width: 768px)': {
            gap: theme('spacing.grid-gap-tablet'),
            'grid-template-columns': theme('gridTemplateColumns.tablet-8'),
          },
          '@media (min-width: 1024px)': {
            gap: theme('spacing.grid-gap-desktop'),
            'grid-template-columns': theme('gridTemplateColumns.desktop-12'),
          },
        },

        // MYDS Article Container (640px max for readability)
        '.myds-article': {
          'max-width': theme('maxWidth.article'),
          'margin-left': 'auto',
          'margin-right': 'auto',
        },

        // MYDS Interactive Content Container (740px max)
        '.myds-interactive': {
          'max-width': theme('maxWidth.interactive'),
          'margin-left': 'auto',
          'margin-right': 'auto',
        },

        // MYDS Skip Link (accessibility)
        '.myds-skip-link': {
          position: 'absolute',
          left: '-9999px',
          'z-index': '999',
          padding: '8px 16px',
          background: theme('colors.white'),
          color: theme('colors.primary.600'),
          'text-decoration': 'none',
          'border-radius': theme('borderRadius.m'),
          'box-shadow': theme('boxShadow.context-menu'),
          '&:focus': {
            left: '24px',
            top: '24px',
          },
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
        '.myds-rtf': {
          'font-family': theme('fontFamily.inter').join(', '),
          'font-weight': '400',
        },
      });

      // MYDS Component Classes
      addComponents({
        // MYDS Button Components
        '.myds-btn': {
          display: 'inline-flex',
          'align-items': 'center',
          'justify-content': 'center',
          gap: '8px',
          'font-family': theme('fontFamily.inter').join(', '),
          'font-weight': '500',
          'text-decoration': 'none',
          border: '1px solid transparent',
          'border-radius': theme('borderRadius.m'),
          transition: 'all 200ms cubic-bezier(0, 0, 0.58, 1)',
          cursor: 'pointer',
          outline: 'none',
          position: 'relative',
          '&:focus-visible': {
            'box-shadow': `0 0 0 2px ${theme('colors.white')}, 0 0 0 4px ${theme('colors.fr-primary.600')}`,
          },
          '&:disabled': {
            opacity: '0.5',
            cursor: 'not-allowed',
            'pointer-events': 'none',
          },
        },

        // Button Sizes
        '.myds-btn-sm': {
          height: theme('height.button-sm'),
          padding: '0 12px',
          'font-size': theme('fontSize.body-sm')[0],
          'line-height': theme('fontSize.body-sm')[1].lineHeight,
        },
        '.myds-btn-md': {
          height: theme('height.button-md'),
          padding: '0 16px',
          'font-size': theme('fontSize.body-base')[0],
          'line-height': theme('fontSize.body-base')[1].lineHeight,
        },
        '.myds-btn-lg': {
          height: theme('height.button-lg'),
          padding: '0 20px',
          'font-size': theme('fontSize.body-lg')[0],
          'line-height': theme('fontSize.body-lg')[1].lineHeight,
        },

        // Button Variants
        '.myds-btn-primary': {
          background: theme('colors.primary.600'),
          color: theme('colors.white'),
          'box-shadow': theme('boxShadow.button'),
          '&:hover': {
            background: theme('colors.primary.700'),
            transform: 'translateY(0.5px)',
          },
          '&:active': {
            background: theme('colors.primary.800'),
            transform: 'translateY(1px)',
          },
        },

        '.myds-btn-secondary': {
          background: theme('colors.white'),
          color: theme('colors.gray.900'),
          'border-color': theme('colors.otl-gray.300'),
          'box-shadow': theme('boxShadow.button'),
          '&:hover': {
            background: theme('colors.gray.50'),
            'border-color': theme('colors.otl-gray.400'),
            transform: 'translateY(0.5px)',
          },
          '&:active': {
            background: theme('colors.gray.100'),
            transform: 'translateY(1px)',
          },
        },

        '.myds-btn-tertiary': {
          background: 'transparent',
          color: theme('colors.primary.600'),
          '&:hover': {
            background: theme('colors.primary.50'),
            'text-decoration': 'underline',
          },
          '&:active': {
            background: theme('colors.primary.100'),
          },
        },

        '.myds-btn-danger': {
          background: theme('colors.danger.600'),
          color: theme('colors.white'),
          'box-shadow': theme('boxShadow.button'),
          '&:hover': {
            background: theme('colors.danger.700'),
            transform: 'translateY(0.5px)',
          },
          '&:active': {
            background: theme('colors.danger.800'),
            transform: 'translateY(1px)',
          },
          '&:focus-visible': {
            'box-shadow': `0 0 0 2px ${theme('colors.white')}, 0 0 0 4px ${theme('colors.fr-danger.600')}`,
          },
        },

        // MYDS Form Components
        '.myds-input': {
          display: 'flex',
          width: '100%',
          border: '1px solid ' + theme('colors.otl-gray.300'),
          'border-radius': theme('borderRadius.m'),
          background: theme('colors.bg-white.0'),
          padding: '8px 12px',
          'font-family': theme('fontFamily.inter').join(', '),
          'font-size': theme('fontSize.body-base')[0],
          'line-height': theme('fontSize.body-base')[1].lineHeight,
          color: theme('colors.txt-black.900'),
          transition: 'all 200ms cubic-bezier(0, 0, 0.58, 1)',
          outline: 'none',
          '&::placeholder': {
            color: theme('colors.txt-black.400'),
          },
          '&:hover': {
            'border-color': theme('colors.otl-gray.400'),
          },
          '&:focus': {
            'border-color': theme('colors.primary.600'),
            'box-shadow': `0 0 0 1px ${theme('colors.primary.600')}`,
          },
          '&:disabled': {
            background: theme('colors.bg-white.100'),
            color: theme('colors.txt-black.400'),
            cursor: 'not-allowed',
          },
        },

        // Input Sizes
        '.myds-input-sm': {
          height: theme('height.input-sm'),
          padding: '6px 10px',
          'font-size': theme('fontSize.body-sm')[0],
        },
        '.myds-input-md': {
          height: theme('height.input-md'),
          padding: '8px 12px',
        },
        '.myds-input-lg': {
          height: theme('height.input-lg'),
          padding: '10px 16px',
          'font-size': theme('fontSize.body-lg')[0],
        },

        // Input States
        '.myds-input-error': {
          'border-color': theme('colors.danger.300'),
          '&:focus': {
            'border-color': theme('colors.danger.600'),
            'box-shadow': `0 0 0 1px ${theme('colors.danger.600')}`,
          },
        },

        // MYDS Card Component
        '.myds-card': {
          background: theme('colors.bg-white.0'),
          border: '1px solid ' + theme('colors.otl-gray.200'),
          'border-radius': theme('borderRadius.l'),
          'box-shadow': theme('boxShadow.card'),
          padding: theme('spacing.6'),
        },

        // MYDS Callout Component
        '.myds-callout': {
          display: 'flex',
          gap: theme('spacing.3'),
          padding: theme('spacing.4'),
          'border-radius': theme('borderRadius.m'),
          'border-left': '4px solid',
        },

        '.myds-callout-info': {
          background: theme('colors.primary.50'),
          'border-left-color': theme('colors.primary.600'),
        },

        '.myds-callout-success': {
          background: theme('colors.success.50'),
          'border-left-color': theme('colors.success.600'),
        },

        '.myds-callout-warning': {
          background: theme('colors.warning.50'),
          'border-left-color': theme('colors.warning.600'),
        },

        '.myds-callout-error': {
          background: theme('colors.danger.50'),
          'border-left-color': theme('colors.danger.600'),
        },

        // MYDS Tag Component
        '.myds-tag': {
          display: 'inline-flex',
          'align-items': 'center',
          gap: theme('spacing.1'),
          padding: '4px 8px',
          'font-family': theme('fontFamily.inter').join(', '),
          'font-size': theme('fontSize.body-sm')[0],
          'font-weight': '500',
          'border-radius': theme('borderRadius.s'),
        },

        '.myds-tag-gray': {
          background: theme('colors.gray.100'),
          color: theme('colors.gray.800'),
        },

        '.myds-tag-success': {
          background: theme('colors.success.100'),
          color: theme('colors.success.800'),
        },

        '.myds-tag-warning': {
          background: theme('colors.warning.100'),
          color: theme('colors.warning.800'),
        },

        '.myds-tag-danger': {
          background: theme('colors.danger.100'),
          color: theme('colors.danger.800'),
        },

        '.myds-tag-primary': {
          background: theme('colors.primary.100'),
          color: theme('colors.primary.800'),
        },

        // MYDS Panel Component
        '.myds-panel': {
          padding: theme('spacing.6'),
          'border-radius': theme('borderRadius.l'),
          'border-left': '4px solid',
        },

        '.myds-panel-info': {
          background: theme('colors.primary.50'),
          'border-left-color': theme('colors.primary.600'),
        },

        '.myds-panel-success': {
          background: theme('colors.success.50'),
          'border-left-color': theme('colors.success.600'),
        },

        '.myds-panel-warning': {
          background: theme('colors.warning.50'),
          'border-left-color': theme('colors.warning.600'),
        },

        '.myds-panel-danger': {
          background: theme('colors.danger.50'),
          'border-left-color': theme('colors.danger.600'),
        },
      });
    },
  ],
});
