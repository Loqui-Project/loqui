const plugin = require("tailwindcss/plugin");
const { fontFamily } = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
  ],
  mode: "jit",
  darkMode: "class",
  theme: {
    screens: {
      mobile: "640px",
      // => @media (min-width: 640px) { ... }
      tablet: "768px",
      // => @media (min-width: 768px) { ... }
      "large-tablet": "992px",
      // => @media (min-width: 992px) { ... }
      laptop: "1024px",
      // => @media (min-width: 1024px) { ... }
      desktop: "1280px",
      // => @media (min-width: 1280px) { ... }
      "2desktop": "1536px",
      // => @media (min-width: 1536px) { ... }

      "max-2desktop": { max: "1535px" },
      // => @media (max-width: 1535px) { ... }

      "max-desktop": { max: "1279px" },
      // => @media (max-width: 1279px) { ... }

      "max-laptop": { max: "1023px" },
      // => @media (max-width: 1023px) { ... }

      "max-large-tablet": { max: "991px" },
      // => @media (max-width: 991px) { ... }

      "max-tablet": { max: "767px" },
      // => @media (max-width: 767px) { ... }

      "max-mobile": { max: "639px" },
      // => @media (max-width: 639px) { ... }

      "between-desktop-mobile": { min: "576px", max: "1023px" },
      // => @media (min-width: 576px) and (max-width: 1023px) { ... }
      "between-mobile-tablet": { min: "576px", max: "767px" },
      // => @media (min-width: 576px) and (max-width: 767px) { ... }
      "between-tablet-desktop": { min: "767px", max: "1200px" },
      // => @media (min-width: 767px) and (max-width: 1200px) { ... }
    },
    container: {
      center: true,
      padding: {
        DEFAULT: "15px",
      },
    },
    extend: {
      colors: {
        black: "#26292B",
        danger: "#ED4F32",
        brand: {
          dark: "#424874",
          main: "#A6B1E1",
          light: "#DCD6F7",
          100: "#F4EEFF",
        },
        gray: {
          50: "#F9FAFB",
          100: "#F3F4F6",
          200: "#E5E7EB",
          300: "#D1D5DB",
          400: "#9CA3AF",
          500: "#6B7280",
          600: "#4B5563",
          700: "#374151",
          800: "#1F2937",
          900: "#111827",
        },
        darkgray: {
          50: "#101010",
          100: "#1c1c1c",
          200: "#2b2b2b",
          300: "#444444",
          400: "#575757",
          500: "#767676",
          600: "#a5a5a5",
          700: "#d6d6d6",
          800: "#e8e8e8",
          900: "#f3f4f6",
        },
      },

      keyframes: {
        "fade-in-up": {
          from: { opacity: 0, transform: "translateY(10px)" },
          to: { opacity: 1, transform: "none" },
        },
        spinning: {
          "100%": { transform: "rotate(360deg)" },
        },
      },
      animation: {
        "fade-in-up":
          "fade-in-up 600ms var(--animation-delay, 0ms) cubic-bezier(.21,1.02,.73,1) forwards",
        "fade-in-bottom":
          "fade-in-bottom cubic-bezier(.21,1.02,.73,1) forwards",
        spinning: "spinning 0.75s linear infinite",
      },
      boxShadow: {
        dropdown: "0px 2px 6px -1px rgba(0, 0, 0, 0.08)",
      },
      fontFamily: {
        "cormorant-garamond": [
          "var(--font-cormorant-garamond)",
          ...fontFamily.serif,
        ],
        rubik: ["var(--font-rubik)", ...fontFamily.sans],
        mono: ["Roboto Mono", "monospace"],
      },
    },
  },
  plugins: [
    require("@todesktop/tailwind-variants"),
    require("@tailwindcss/forms"),
    require("@tailwindcss/typography"),
    require("tailwind-scrollbar")({ nocompatible: true }),
    require("@savvywombat/tailwindcss-grid-areas"),
    plugin(({ addVariant }) => {
      addVariant("mac", ".mac &");
      addVariant("windows", ".windows &");
      addVariant("ios", ".ios &");
    }),
    plugin(({ addBase, theme }) => {
      addBase({
        hr: {
          borderColor: theme("subtle"),
        },
      });
    }),
  ],
  variants: {
    scrollbar: ["dark"],
  },
}

