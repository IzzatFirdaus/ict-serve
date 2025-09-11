import { defineConfig } from 'tailwindcss/lib/cjs/index.js';

export default defineConfig({
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            // MYDS 12-8-4 Grid System  
            gridTemplateColumns: {
                'myds-12': 'repeat(12, minmax(0, 1fr))',
                'myds-8': 'repeat(8, minmax(0, 1fr))', 
                'myds-4': 'repeat(4, minmax(0, 1fr))',
            },

            // MYDS Font Families
            fontFamily: {
                'sans': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif'],
                'heading': ['Poppins', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif'],
            },

            // MYDS Complete Color Token System - mapped to Filament semantics
            colors: {
                // Primary mapped to MYDS Blue
                primary: {
                    50: '#EFF6FF',    
                    100: '#DBEAFE',   
                    200: '#C2D5FF',   
                    300: '#96B7FF',   
                    400: '#6394FF',   
                    500: '#3A75F6',   
                    600: '#2563EB',   // Main MYDS Blue
                    700: '#1D4ED8',   
                    800: '#1E40AF',   
                    900: '#1E3A8A',   
                    950: '#172554',   
                },

                // Danger mapped to MYDS Red
                danger: {
                    50: '#FEF2F2',   
                    100: '#FEE2E2',  
                    200: '#FECACA',  
                    300: '#FCA5A5',  
                    400: '#F87171',  
                    500: '#EF4444',  
                    600: '#DC2626',  // Main danger color
                    700: '#B91C1C',  
                    800: '#991B1B',  
                    900: '#7F1D1D',  
                    950: '#450A0A',  
                },

                // Success mapped to MYDS Green
                success: {
                    50: '#F0FDF4',   
                    100: '#DCFCE7',  
                    200: '#BBF7D0',  
                    300: '#83DAA3',  
                    400: '#4ADE80',  
                    500: '#22C55E',  
                    600: '#16A34A',  // Main success color
                    700: '#15803D',  
                    800: '#166534',  
                    900: '#14532D',  
                    950: '#052E16',  
                },

                // Warning mapped to MYDS Yellow
                warning: {
                    50: '#FEFCE8',   
                    100: '#FEF9C3',  
                    200: '#FEF08A',  
                    300: '#FDE047',  
                    400: '#FACC15',  
                    500: '#EAB308',  
                    600: '#CA8A04',  // Main warning color
                    700: '#A16207',  
                    800: '#854D0E',  
                    900: '#713F12',  
                    950: '#422006',  
                },

                // Gray mapped to MYDS Gray scale
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
                    850: '#1D1D21',  
                    900: '#18181B',  
                    930: '#161619',  
                    950: '#09090B',  
                },
            },

            // MYDS Spacing System
            spacing: {
                '4': '4px',
                '8': '8px', 
                '12': '12px',
                '16': '16px',
                '20': '20px',
                '24': '24px',
                '32': '32px',
                '40': '40px', 
                '48': '48px',
                '64': '64px',
            },

            // MYDS Border Radius System
            borderRadius: {
                'xs': '4px',   // Extra Small 
                's': '6px',    // Small
                'm': '8px',    // Medium
                'l': '12px',   // Large
                'xl': '14px',  // Extra Large
                'full': '9999px', // Full
            },

            // MYDS Shadow System
            boxShadow: {
                'none': 'none',
                'button': '0px 1px 3px 0px rgba(0, 0, 0, 0.07)',
                'card': '0px 2px 6px 0px rgba(0, 0, 0, 0.05), 0px 6px 24px 0px rgba(0, 0, 0, 0.05)',
                'context-menu': '0px 2px 6px 0px rgba(0, 0, 0, 0.05), 0px 12px 50px 0px rgba(0, 0, 0, 0.10)',
            },

            // MYDS Motion System
            transitionTimingFunction: {
                'linear': 'cubic-bezier(0, 0, 1, 1)',
                'easeout': 'cubic-bezier(0, 0, 0.58, 1)', 
                'easeoutback': 'cubic-bezier(0.4, 1.4, 0.2, 1)',
            },

            transitionDuration: {
                'short': '200ms',
                'medium': '400ms', 
                'long': '600ms',
            },
        },
    },
    plugins: [],
});