Staging: feature/i18n-batch-01

This folder contains the inventory and proposed changes for the first i18n batching run.
Goal: produce the first reviewable batch (20 files) of view-only replacements, ready to be applied on branch `feature/i18n-batch-01` and later merged into `develop`.

How to use:

1. Create a branch locally:
   git checkout -b feature/i18n-batch-01

2. Review `i18n-inventory-batch-01.csv` for suggested keys and mappings.

3. Apply replacements either manually or via the automation script that will be provided. Suggested replacement examples are in `proposed_changes_batch_01.md`.

4. Validate locale files:
   php -r "foreach (glob('resources/lang/\*.json') as $f) { json_decode(file_get_contents($f)); if (json_last_error()) { echo $f . ': ' . json_last_error_msg() . PHP_EOL; exit(1); } } echo 'OK\n'; }"

5. Create PR against `develop` for review.

Notes:

- This staging folder does not create or commit a git branch automatically. It contains artifacts for review and application.
- I can produce the actual modified files in this folder if you want me to apply the changes here for preview.
