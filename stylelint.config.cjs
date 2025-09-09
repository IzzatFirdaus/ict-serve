module.exports = {
  extends: [
    'stylelint-config-recommended',
    'stylelint-config-tailwindcss',
    'stylelint-config-standard-scss',
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
