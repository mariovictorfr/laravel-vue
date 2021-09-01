module.exports = {
  root: true,
  extends: [
    'plugin:vue/recommended',
    '@vue/airbnb',
    'plugin:prettier/recommended',
    'prettier/vue',
  ],
  parserOptions: {
    parser: 'babel-eslint',
  },
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
  },
}
