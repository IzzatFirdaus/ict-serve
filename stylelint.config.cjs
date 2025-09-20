module.exports = {
  extends: [
    'stylelint-config-recommended',
    'stylelint-config-tailwindcss',
    'stylelint-config-standard-scss',
  ],
  ignoreFiles: [
    'vendor/**/*',
    'node_modules/**/*',
    'public/css/**/*',
    'public/build/**/*',
    'storage/**/*',
    'bootstrap/cache/**/*',
    'tests/ui/**/*',
    'playwright-report/**/*',
    'test-results/**/*',
    'qa-results/**/*',
    'tmp/**/*',
    'e2e/**/*'
  ],
  rules: {
    'at-rule-no-unknown': [
      true,
      {
        ignoreAtRules: [
          'tailwind',
          'apply',
          'variants',
          'responsive',
          'screen',
          'source',
          'theme',
          'use',
        ],
      },
    ],
    'scss/at-rule-no-unknown': [
      true,
      {
        ignoreAtRules: [
          'tailwind',
          'apply',
          'variants',
          'responsive',
          'screen',
          'use',
          'source',
          'theme',
        ],
      },
    ],
    'selector-class-pattern': null,
  },
};
