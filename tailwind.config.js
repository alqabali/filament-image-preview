const preset = require("./vendor/filament/filament/tailwind.config.preset");

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [preset],
    content: ["./resources/views/*.blade.php", "./src/**/*.php"],

    safelist: [
        {
      pattern: /^(bg|text|border)-(green|blue|yellow|primary|gray|red)-(100|200|300|400|500|600|700|800|900)$/,
    }
  ],
    darkMode: "class",
    theme: {
        extend: {},
    },
};
