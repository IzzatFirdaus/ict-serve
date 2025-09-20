This folder stores intermediate artifacts for the i18n extraction work.

Batch-01 summary:

- Found ~200 Blade fragments containing hardcoded text across resources/views.
- Recorded a representative subset in batch-01-extraction.json with suggested translation keys.

Next steps:

1. Expand scan to PHP and JS/TS files and extract remaining literals.
2. Create or update resources/lang/en.json and resources/lang/ms.json with suggested keys.
3. Replace Blade literals with \_\_('key') or @lang('key') in small batches and run tests after each batch.

Notes:

- Use MYDS tokens for UI strings where applicable.
- Keep English entries as canonical and copy to Malay file for translation later.
