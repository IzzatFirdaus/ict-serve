/** @type {import('stylelint').Config} */
export default {
  extends: ['stylelint-config-standard'],
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
          'theme',
          'source',
          'config',
          'plugin',
          'reference',
          'custom-variant',
          'variant',
        ],
      },
    ],
    'declaration-block-single-line-max-declarations': null,
    'custom-property-pattern': null,
  },
};
