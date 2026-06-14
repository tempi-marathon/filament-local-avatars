# Release checklist

## Branch protection (GitHub)

In **Settings → Branches → Add rule** for `main`:

- Require a pull request before merging
- Require status checks to pass before merging → select **CI**
- Require branches to be up to date before merging

CI runs on every pull request and on pushes to `main`.

## Packagist

1. Sign in at [packagist.org](https://packagist.org)
2. Submit package URL: `https://github.com/tempi-marathon/filament-local-avatars`
3. On the package page, click **Set up GitHub Hook** to enable auto-update on tag push
4. After the package is indexed, consumer projects can install with:

   ```bash
   composer require tempi-marathon/filament-local-avatars:^1.0
   ```

5. Remove the Composer path repository from consumer `composer.json` once Packagist is live
