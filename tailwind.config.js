import colors from 'tailwindcss/colors' 
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    "./vendor/filament/**/*.blade.php", 
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        colors: { 
          danger: colors.rose,
          primary: colors.blue,
          success: colors.green,
          warning: colors.yellow,
      }, 
    },
  },
  plugins: [
    forms, 
    typography, 
  ],
}

