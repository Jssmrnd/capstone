import colors from 'tailwindcss/colors' 
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'
/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'
import colors from 'tailwindcss/colors' 
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography' 

export default {
  content: [
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    "./vendor/filament/**/*.blade.php", 
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
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

