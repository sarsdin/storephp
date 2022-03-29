module.exports = {
    content: [
      "./index.html",
      "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
        extend: {
            width: {
                '68':'17rem',
                '256':'74rem',
                '260':'85rem'
            },
            colors: {
                "airbus-1": "#74d2e7",
                "airbus-2": "#48a9c5",
                "airbus-3": "#0085ad",
                "airbus-4": "#8db9ca",
                "airbus-5": "#4298b5",
                "airbus-6": "#005670",
                "airbus-7": "#00205b",
                "airbus-8": "#009f4d",
                "airbus-9": "#84bd00",
                "airbus-10": "#efdf00",
                "airbus-11": "#fe5000",
                "airbus-12": "#e4002b",
                "airbus-13": "#da1884",
                "airbus-14": "#a51890",
                "airbus-15": "#0077c8",
                "airbus-16": "#008eaa"
            }
        },
    },
    plugins: [],
  }