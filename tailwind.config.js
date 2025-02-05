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
          blueRevamp: '#578FCA',
          blueRevamp2: '#A1E3F9',
          blueRevamp3: '#3674B5'

        },
        screens: {
          'dekstopScreen' : '1920px',
          'ipad-pro-11': '1194px', // Breakpoint portrait iPad Pro 11 inci
        },
        height: {
          'dekstop': '45rem', 
          'ipad' : '38rem',
          'dekstopOrder': '40rem', 
          'ipadOrder' : '36rem',
        },
        fontSize: {
          'ipad-font': '11px', // Ganti 'custom' dan '24px' sesuai kebutuhan Anda
          'ipad-font-input': '9px',
        },
        maxHeight: {
          'dekstop-order-max': '900px', // Ganti 'custom' dan '400px' sesuai kebutuhan Anda
          'ipad-order-max': '800px',
        },
      },
      fontFamily: {
          zenOldMincho: ['"Zen Old Mincho"', 'serif'],
          zenMaruGothic: ["Zen Maru Gothic", 'serif'],
          monospace: ["Space Mono", "monospace"]
        },
    },
    plugins: [],
  }