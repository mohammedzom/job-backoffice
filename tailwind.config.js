import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    /*
    |--------------------------------------------------------------------------
    | Dark Mode Strategy
    |--------------------------------------------------------------------------
    | Uses the 'class' strategy so dark mode is toggled manually via Alpine.js
    | by adding/removing the 'dark' class on <html>. This enables full user
    | control over the theme preference, persisted in localStorage.
    */
    darkMode: 'class',

    /*
    |--------------------------------------------------------------------------
    | Content Sources
    |--------------------------------------------------------------------------
    */
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            /*
            |------------------------------------------------------------------
            | Typography
            |------------------------------------------------------------------
            | Primary sans-serif: Inter (Latin/LTR) — loaded in app.css
            | Secondary sans-serif: Cairo (Arabic/RTL) — loaded in app.css
            | Both flow through --font-sans so a single Tailwind class covers
            | both locales; the browser picks the correct glyph per character.
            */
            fontFamily: {
                sans: ['Inter', 'Cairo', ...defaultTheme.fontFamily.sans],
                arabic: ['Cairo', 'Tajawal', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },

            /*
            |------------------------------------------------------------------
            | Brand Color Palette — "Indigo + Slate" system
            |------------------------------------------------------------------
            | Primary:  indigo (actions, links, active states)
            | Surface:  slate  (backgrounds, borders)
            | Accent:   violet (highlights, gradients)
            | Semantic: emerald / amber / rose (success / warning / danger)
            |
            | Every shade is paired with a dark-mode equivalent so components
            | can use a single token and render correctly in both themes.
            */
            colors: {
                brand: {
                    50:  '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',   // primary action
                    600: '#4f46e5',   // hover
                    700: '#4338ca',   // pressed
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                surface: {
                    /* Light surfaces */
                    'light-base':    '#f8fafc',   // page background
                    'light-raised':  '#ffffff',   // card / panel
                    'light-overlay': '#f1f5f9',   // subtle offset
                    /* Dark surfaces */
                    'dark-base':     '#0f172a',   // page background
                    'dark-raised':   '#1e293b',   // card / panel
                    'dark-overlay':  '#293548',   // subtle offset
                    'dark-border':   '#334155',   // border
                },
            },

            /*
            |------------------------------------------------------------------
            | Spacing & Sizing Extensions
            |------------------------------------------------------------------
            */
            spacing: {
                '4.5':  '1.125rem',
                '13':   '3.25rem',
                '15':   '3.75rem',
                '18':   '4.5rem',
                '88':   '22rem',
                '112':  '28rem',
                '128':  '32rem',
            },

            /*
            |------------------------------------------------------------------
            | Border Radius
            |------------------------------------------------------------------
            */
            borderRadius: {
                '2.5xl': '1.25rem',
                '3.5xl': '1.75rem',
            },

            /*
            |------------------------------------------------------------------
            | Box Shadows — layered for depth, tuned for dark mode
            |------------------------------------------------------------------
            */
            boxShadow: {
                'card':         '0 1px 3px 0 rgb(0 0 0 / 0.06), 0 1px 2px -1px rgb(0 0 0 / 0.06)',
                'card-md':      '0 4px 12px -2px rgb(0 0 0 / 0.08), 0 2px 6px -2px rgb(0 0 0 / 0.06)',
                'card-lg':      '0 12px 32px -4px rgb(0 0 0 / 0.12), 0 4px 12px -2px rgb(0 0 0 / 0.08)',
                'card-dark':    '0 4px 20px 0 rgb(0 0 0 / 0.30)',
                'glow-brand':   '0 0 20px rgb(99 102 241 / 0.35)',
                'glow-success': '0 0 16px rgb(16 185 129 / 0.30)',
                'glow-danger':  '0 0 16px rgb(239 68 68 / 0.30)',
                'inner-sm':     'inset 0 1px 3px 0 rgb(0 0 0 / 0.06)',
                'sidebar':      '4px 0 24px rgb(0 0 0 / 0.04)',
                'sidebar-dark': '4px 0 32px rgb(0 0 0 / 0.30)',
            },

            /*
            |------------------------------------------------------------------
            | Background Image Utilities (gradients)
            |------------------------------------------------------------------
            */
            backgroundImage: {
                'gradient-brand':       'linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)',
                'gradient-brand-soft':  'linear-gradient(135deg, #eef2ff 0%, #ede9fe 100%)',
                'gradient-surface':     'linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%)',
                'gradient-dark':        'linear-gradient(180deg, #1e293b 0%, #0f172a 100%)',
                'gradient-success':     'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                'gradient-danger':      'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                'gradient-warning':     'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
            },

            /*
            |------------------------------------------------------------------
            | Keyframe Animations
            |------------------------------------------------------------------
            */
            keyframes: {
                'fade-in': {
                    '0%':   { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'fade-in-scale': {
                    '0%':   { opacity: '0', transform: 'scale(0.96)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'slide-in-left': {
                    '0%':   { opacity: '0', transform: 'translateX(-12px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                'slide-in-right': {
                    '0%':   { opacity: '0', transform: 'translateX(12px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                'pulse-brand': {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgb(99 102 241 / 0.4)' },
                    '50%':      { boxShadow: '0 0 0 8px rgb(99 102 241 / 0)' },
                },
                'shimmer': {
                    '0%':   { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
            animation: {
                'fade-in':        'fade-in 0.3s ease-out both',
                'fade-in-scale':  'fade-in-scale 0.25s ease-out both',
                'slide-in-left':  'slide-in-left 0.3s ease-out both',
                'slide-in-right': 'slide-in-right 0.3s ease-out both',
                'pulse-brand':    'pulse-brand 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'shimmer':        'shimmer 2s linear infinite',
            },

            /*
            |------------------------------------------------------------------
            | Transitions
            |------------------------------------------------------------------
            */
            transitionDuration: {
                '400': '400ms',
            },

            /*
            |------------------------------------------------------------------
            | Z-Index Scale
            |------------------------------------------------------------------
            */
            zIndex: {
                '60':  '60',
                '70':  '70',
                '80':  '80',
                '90':  '90',
                '100': '100',
            },

            /*
            |------------------------------------------------------------------
            | Max Width
            |------------------------------------------------------------------
            */
            maxWidth: {
                '8xl':  '88rem',
                '9xl':  '96rem',
                'prose-wide': '75ch',
            },
        },
    },

    plugins: [
        forms({
            /*
             * 'class' strategy: form elements are unstyled by default and
             * only receive styles when you add the `.form-*` class. This
             * gives us full control without fighting Tailwind's form reset.
             */
            strategy: 'class',
        }),
    ],
};
