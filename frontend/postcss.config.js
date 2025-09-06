
module.exports = {
  plugins: {
    //tailwindcss: {},
    "@tailwindcss/postcss": {}, // 👈 OBLIGATORIO con Tailwind 3.4+
    autoprefixer: {},
    // prueba
    testplugin: () => {
      console.log("✅ PostCSS config leído");
      return {};
    }
  },
};
