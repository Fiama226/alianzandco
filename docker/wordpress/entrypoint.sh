#!/bin/sh
# WordPress entrypoint that:
#  - waits for DB
#  - auto-installs WordPress if not installed
#  - installs + activates TranslatePress (for FR/EN bilingual)
#  - activates the Allianz & Co theme (which triggers seeding)
#  - sets pretty permalinks
#  - configures TranslatePress (FR + EN languages)
#  - then runs the original entrypoint

set -e

echo "[al-entrypoint] Waiting for database..."
for i in $(seq 1 60); do
  if mysql -h db -u wp -pwp wordpress -e "SELECT 1" >/dev/null 2>&1; then
    echo "[al-entrypoint] Database is ready."
    break
  fi
  sleep 2
done

# Install WP-CLI if not present
if [ ! -f /usr/local/bin/wp ]; then
  echo "[al-entrypoint] Installing WP-CLI..."
  curl -sSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
  chmod +x /usr/local/bin/wp
fi

# Install WordPress if not installed
if ! wp core is-installed --allow-root --path=/var/www/html 2>/dev/null; then
  echo "[al-entrypoint] Installing WordPress..."
  wp core install \
    --allow-root --path=/var/www/html \
    --url="http://localhost:8080" \
    --title="Alliance & Co" \
    --admin_user="admin" \
    --admin_password="admin" \
    --admin_email="admin@example.com" \
    --skip-email
  echo "[al-entrypoint] WordPress installed."
fi

# Install TranslatePress plugin (official zip)
if ! wp plugin is-installed translatepress-multilingual --allow-root --path=/var/www/html 2>/dev/null; then
  echo "[al-entrypoint] Installing TranslatePress plugin..."
  cd /tmp
  curl -sSL -o tp.zip "https://codeload.github.com/kingtirano/translatepress3/zip/refs/heads/main"
  unzip -q tp.zip -d /tmp/tp-extract
  inner_zip=$(find /tmp/tp-extract -maxdepth 2 -name "translatepress-multilingual.*.zip" | head -1)
  if [ -n "$inner_zip" ]; then
    unzip -q "$inner_zip" -d /tmp/tp-final
    rm -rf /var/www/html/wp-content/plugins/translatepress-multilingual
    cp -r /tmp/tp-final/translatepress-multilingual /var/www/html/wp-content/plugins/
  fi
  rm -rf /tmp/tp.zip /tmp/tp-extract /tmp/tp-final
fi

# Activate TranslatePress
if ! wp plugin is-active translatepress-multilingual --allow-root --path=/var/www/html 2>/dev/null; then
  echo "[al-entrypoint] Activating TranslatePress..."
  wp plugin activate translatepress-multilingual --allow-root --path=/var/www/html
fi

# Configure TranslatePress: default language = English, add French
wp option update trp_language "en_US" --allow-root --path=/var/www/html 2>/dev/null || true
wp option update translatepress_settings 'a:7:{s:11:"default-language";s:5:"en_US";s:23:"translation-languages";a:1:{i:0;s:5:"fr_FR";}s:21:"publish-languages";s:5:"fr_FR";s:23:"native-or-english-language";s:5:"en_US";s:13:"show-slug";s:1:"1";s:12:"translation-memory";a:0:{}s:11:"url-slugs";a:2:{s:5:"en_US";s:0:"";s:5:"fr_FR";s:2:"fr";}}' --format=json --allow-root --path=/var/www/html 2>/dev/null || true

# Activate the theme (this triggers al_seed_content via after_switch_theme)
if ! wp theme is-active allianzandco --allow-root --path=/var/www/html 2>/dev/null; then
  echo "[al-entrypoint] Activating Allianz & Co theme..."
  wp theme activate allianzandco --allow-root --path=/var/www/html
fi

# Pretty permalinks
wp rewrite structure '/%postname%/' --hard --allow-root --path=/var/www/html 2>/dev/null || true
wp rewrite flush --hard --allow-root --path=/var/www/html 2>/dev/null || true

echo "[al-entrypoint] Setup complete. Handing over to Apache."

# Hand over to the original entrypoint
exec docker-entrypoint.sh apache2-foreground "$@"
