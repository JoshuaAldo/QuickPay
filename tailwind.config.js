/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
    ],
    theme: {
      extend: {
        colors:{
          PinkTua: '#FB6F92',
          PinkMuda: '#FEE5EB',
          PinkMuda2: '#FFF0F4',
          PinkSelect: '#FB6F92',
        }
      },
      fontFamily: {
          zenOldMincho: ['"Zen Old Mincho"', 'serif'],
          zenMaruGothic: ["Zen Maru Gothic", 'serif']
        },
    },
    plugins: [],
  }