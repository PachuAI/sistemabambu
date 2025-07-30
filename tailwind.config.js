/** @type {import('tailwindcss').Config} */
export default {
  prefix: 'tw-', // Prefijo para evitar conflictos con Bootstrap
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        // Mantener consistencia con tema BAMBU actual
        bambu: {
          primary: '#8B5CF6',        // Violeta fuerte
          'primary-dark': '#7C3AED', // Violeta más oscuro
          'primary-light': '#A78BFA', // Violeta claro
          secondary: '#C4B5FD',      // Lavanda
          'secondary-dark': '#A78BFA', // Lavanda oscuro
          'secondary-light': '#DDD6FE', // Lavanda muy claro
        },
        // Grises personalizados para dark mode
        gray: {
          950: '#0f0f23',
          900: '#1a1a2e',
          800: '#16213e',
          750: '#1f2937',
          700: '#2a2d47',
        }
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Arial', 'sans-serif'],
      },
    },
  },
  plugins: [],
}