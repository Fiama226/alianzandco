# Allianz & Co — WordPress Theme

A **production-ready, fully-bilingual (FR / EN)** WordPress theme for **Allianz & Co**, a
multi-disciplinary engineering and construction company operating across the African
continent. Ships with a self-contained classic WordPress theme, an auto-seeding
content routine, the official Allianz&Co brand colors, and a one-command Docker
environment for local testing.

The design system is inspired by the Avelon template (Space Grotesk + Inter +
Playfair Display, bold display typography, generous whitespace) but every color
and copy decision is aligned with the official Allianz&Co logo and brand.

---

## ✨ Features

| | |
|---|---|
| 🌐 **Bilingual FR / EN** | TranslatePress auto-installed and pre-configured. Language switcher in header & mobile menu. 90+ UI strings pre-translated in the theme. |
| 🎨 **Brand colors** | Sampled from the official Allianz&Co logo — primary green `#0b7d38`, gold accent `#e3ca3c`, deep green-black `#0a1f12`. |
| 🧱 **No page-builder** | Self-contained classic theme — no Elementor, no Divi, no bloat. |
| 📝 **Custom post types** | `Team`, `Services`, `Projects`, `FAQs` with custom meta fields and admin UI. |
| 🎨 **Customizer** | Homepage hero, stat counters, contact info, social links — all editable from `Appearance → Customize`. |
| ✉️ **Built-in contact form** | Uses `wp_mail` — no Contact Form 7 required. |
| 🌱 **One-click seeding** | 6 team members, 6 services, 6 projects, 6 FAQs, 6 blog posts + all pages — auto-created on theme activation. |
| 📱 **Fully responsive** | Mobile, tablet, desktop with custom mobile menu, burger, and language switcher. |
| 🔍 **SEO ready** | Pretty permalinks, title-tag, semantic HTML, OG meta, JSON-LD. |
| 🚀 **Performance** | Deferred JS, `font-display: swap`, lazy-loaded images, no jQuery dependency. |
| 🐳 **Docker** | One-command stack (WordPress + MariaDB + optional phpMyAdmin). |
| 🌍 **Translation-ready** | All strings wrapped in `__()` / `esc_html__()`, includes `.pot` template, French gettext dictionary. |

---

## 🗂️ Pages included

All pages are auto-created on theme activation with the right slugs, templates and
seeded content. The custom post types have full admin UIs at the left sidebar.

| URL (default) | Template | What it contains |
|---|---|---|
| `/` | `page-home.php` | Hero, services, projects, stats, team, philosophy, partners, blog, CTA |
| `/about-us/` | `page-about.php` | Story, values, CEO message |
| `/our-team/` | `page-team.php` | Team grid (auto-populated from `Team` CPT) |
| `/team/{member}/` | `single-al_team.php` | Individual team member page |
| `/services/` | `page-services.php` | 6 services + 4-step delivery model |
| `/philosophy/` | `page-philosophy.php` | Manifesto-style manifesto |
| `/history/` | `page-history.php` | Interactive timeline 2005 → 2025 |
| `/faqs/` | `page-faqs.php` | Accordion (auto-populated from `FAQ` CPT) |
| `/blog-list/` | `page-blog.php` | Blog index with pagination |
| `/{post-slug}/` | `single.php` | Single blog post (e.g. `/custom-vs-prefab-homes/`) |
| `/contacts/` | `page-contact.php` | Working contact form + contact info |
| 404 | `404.php` | Custom 404 |

URL slugs can be changed in WP admin — links in menus and footers update automatically.

---

## 🚀 Quick start — Docker (recommended)

Requires only [Docker](https://www.docker.com/) + `docker compose` (bundled with
Docker Desktop on macOS/Windows; on Linux install `docker-compose-plugin`).

### One command

```bash
cd /home/user/alianzandco
./init.sh          # or: docker compose up -d
```

On **first boot** the entrypoint script runs these steps automatically:

1. Waits for MariaDB to be healthy
2. Downloads WP-CLI
3. Auto-installs WordPress
4. Downloads + installs the **TranslatePress** plugin (for FR/EN)
5. Activates the **Allianz & Co** theme (this triggers the seeding routine)
6. Configures TranslatePress (EN default + FR second language)
7. Sets pretty permalinks
8. Flushes rewrite rules
9. Hands over to Apache

It takes ~60 seconds the first time. Subsequent boots are instant (database is
preserved in a Docker volume).

### Once it's up

| | |
|---|---|
| **Site**         | http://localhost:8080 |
| **Admin**        | http://localhost:8080/wp-admin |
| **Username**     | `admin` |
| **Password**     | `admin` |
| **Email**        | `admin@example.com` |
| **phpMyAdmin**   | http://localhost:8081 |

> ℹ️ If you ran the stack before and want a clean slate:
> `docker compose down -v && ./init.sh`

### Useful commands

```bash
# View live logs
docker compose logs -f wordpress

# Open a shell in the WordPress container
docker compose exec wordpress bash

# Run WP-CLI from inside the container
docker compose exec wordpress wp post list --allow-root

# Re-trigger the seeding (after deleting content)
docker compose exec wordpress wp eval 'delete_option("al_seeded_v1");'
docker compose exec wordpress wp theme activate allianzandco --allow-root

# Stop the stack (keeps data)
docker compose down

# Stop the stack and wipe ALL data
docker compose down -v
```

### Live-mounted theme

The theme is **mounted as a read-only volume** into the container:

```
./wordpress-theme/allianzandco  →  /var/www/html/wp-content/themes/allianzandco
```

Any edit you make in `wordpress-theme/allianzandco/` is **reflected live** in the
running site — no rebuild needed. Just refresh the page in your browser.

---

## 🛠️ Local development without Docker

If you already have a WordPress install (e.g. LocalWP, MAMP, LAMP):

1. Copy `wordpress-theme/allianzandco/` into `wp-content/themes/` of your install.
2. In **WP Admin → Appearance → Themes**, activate "Allianz & Co".
3. The seeding routine runs automatically on activation (one-time).
4. Install and activate **TranslatePress Multilingual** to enable FR/EN.
5. In **Settings → TranslatePress**, add **French (France)** as a translation language.

---

## 🌐 Bilingual FR / EN

The site is fully bilingual out of the box, powered by **TranslatePress**.

### What gets translated automatically

- **All theme UI strings** — nav, buttons, section titles, FAQ, contact form, footer.
  The theme ships with a French `gettext` dictionary of 90+ strings, so the FR
  experience is polished the moment you switch. No additional work needed.
- **Page, post and CPT body content** — auto-translated by TranslatePress using
  the free Google Translate engine. Works on first switch with zero setup.
- **URLs** — French pages live under `/fr/...` (e.g. `/fr/services/`,
  `/fr/about-us/`).

### How the user switches

A language switcher is in the **header (top-right)** on desktop and in the
**mobile menu** on mobile. It shows both languages with their flags. Clicking
`FR` switches the whole site to French.

### How to refine translations (manual override)

TranslatePress has a visual translation editor. To enter it, append `?trp-edit-translation=true`
to any URL while logged in as admin. You can then click any text on the page to
edit its translation. Saved edits take priority over the auto-translation.

To add a third language (e.g. Arabic, Swahili):
**Settings → TranslatePress → Add new translation language**.

To change the default language:
**Settings → General → Site Language** (then re-run the language switcher).

---

## 🎨 Design system

The color palette is sampled directly from the official Allianz&Co logo. All
tokens are CSS custom properties — see `assets/css/main.css` (top of file).

| Token | Value | Used for |
|---|---|---|
| `--al-color-accent` | `#0b7d38` | Primary green — buttons, links, eyebrows |
| `--al-color-accent-2` | `#0a6a2e` | Button hover |
| `--al-color-accent-3` | `#297a1d` | Icon green |
| `--al-color-gold` | `#e3ca3c` | Africa accent — dots, project categories, CTA gradient |
| `--al-color-gold-2` | `#d4a017` | Gold hover |
| `--al-color-bg-dark` | `#0a1f12` | Dark sections (stats band) |
| `--al-color-text` | `#0a0a0a` | Body text |
| `--al-color-text-muted` | `#5a5a5a` | Secondary text |
| `--al-color-bg-alt` | `#f5f3ee` | Section background variant |

| Font | Used for |
|---|---|
| Space Grotesk | Display, headings, UI labels |
| Inter | Body, paragraphs, form inputs |
| Playfair Display (italic) | Pull-quotes, blockquotes, accent italic |

---

## 📁 Project structure

```
alianzandco/
├── README.md                          ← You are here
├── docker-compose.yml                 ← Docker stack (WordPress + MariaDB + phpMyAdmin)
├── init.sh                            ← One-command launcher
├── .gitignore
│
├── docker/
│   └── wordpress/
│       ├── entrypoint.sh              ← Auto-installs WP, TranslatePress, theme
│       └── uploads.ini                ← PHP upload limits
│
├── wordpress-theme/
│   └── allianzandco/                  ← The WordPress theme
│       ├── style.css                  ← Theme header (WordPress reads this)
│       ├── readme.txt                 ← Theme readme (shown in WP admin)
│       ├── screenshot.jpg             ← Theme preview in WP admin
│       ├── functions.php              ← Theme bootstrap, CPTs, customizer, seeding
│       ├── header.php / footer.php    ← Layout chrome
│       ├── comments.php               ← Custom comments template
│       ├── 404.php
│       ├── archive.php                ← Category / tag / author / date archives
│       ├── single.php                 ← Single blog post
│       ├── single-al_team.php         ← Single team member
│       ├── index.php                  ← WP fallback
│       ├── page-home.php              ← Homepage
│       ├── page-about.php             ← About Us
│       ├── page-team.php              ← Our Team (grid)
│       ├── page-services.php          ← Services
│       ├── page-philosophy.php        ← Philosophy
│       ├── page-history.php           ← History (timeline)
│       ├── page-faqs.php              ← FAQs (accordion)
│       ├── page-blog.php              ← Blog list
│       ├── page-contact.php           ← Contact (with form)
│       ├── template-parts/
│       │   └── page-header.php        ← Reusable page banner
│       ├── assets/
│       │   ├── css/main.css           ← Complete design system
│       │   ├── js/main.js             ← Menu, FAQ, scroll reveal, counters
│       │   └── images/                ← Theme images, partner logos, etc.
│       └── languages/                 ← (empty — French translations are in functions.php)
│
└── preview/                           ← Standalone static HTML preview
    ├── home.html
    ├── README.md
    └── assets/                        ← (same CSS/JS/images as the theme)
```

---

## 🔧 Customizer options

Navigate to **Appearance → Customize** to edit:

| Section | Options |
|---|---|
| **Homepage Hero** | Eyebrow text · Title · Description · Primary button label & URL · Background image |
| **Homepage Stats** | Four stat counters (number + label each) |
| **Contact Info** | Address · Phone · Email · Opening hours |
| **Footer** | About text · Social URLs (LinkedIn / X / Facebook / Instagram) |
| **Site Identity** | Logo, site title, tagline, favicon |

All changes are previewed live in the Customizer.

---

## 📝 Custom post types

After activating the theme, the following custom post types are available in
the WP admin sidebar:

| CPT | Slug | Use case |
|---|---|---|
| `al_team` | `team` | Team members — add a new member → page `/our-team/` updates automatically |
| `al_service` | `services` | Service cards — appear in `/services/` and homepage |
| `al_project` | `projects` | Portfolio projects with client, location, year, category |
| `al_faq` | `faqs` | FAQ items — render in `/faqs/` accordion |

Each has a custom meta box for the role, client, year, etc.

To add a new project: **Projects → Add New**. Fill in the title, featured image,
and the project details (client, location, year). Publish. It appears
immediately on the homepage's "Selected projects" section.

---

## 🌱 Seeding (one-click content)

The theme seeds a full demo on first activation:

- **8 pages** (home, about, team, services, philosophy, history, FAQs, blog list, contact) with the right slugs and templates
- **6 team members** with portraits, roles and bios
- **6 services** with descriptions
- **6 projects** (3 categories, with client, location, year)
- **6 FAQs**
- **6 blog posts** (including the reference *Custom vs Prefab Homes*)
- **Customizer defaults** (hero copy, stat counters, contact info, social links)
- **Front page** set to the home page template
- **Pretty permalinks** (`/%postname%/`)

To re-seed after deleting content:

```bash
# via WP-CLI inside the container
docker compose exec wordpress wp eval 'delete_option("al_seeded_v1");'
docker compose exec wordpress wp theme activate allianzandco --allow-root
```

Or via phpMyAdmin (http://localhost:8081) — delete the `al_seeded_v1` row
from `wp_options`, then re-activate the theme.

---

## 📤 Pushing to GitHub

The current branch is `arena/a2dffde0-alianzandco`, branched from `master` of
`https://github.com/Fiama226/alianzandco.git`. GitHub auth is already configured.

### First push of this branch

```bash
cd /home/user/alianzandco
git push -u origin arena/a2dffde0-alianzandco
```

### Regular workflow

```bash
# Stage & commit changes
git add -A
git commit -m "feat(homepage): tweak hero copy"

# Push to remote
git push

# Create a PR (if you want to merge into master)
gh pr create --base master --title "Allianz & Co theme" --body "Initial theme build"
gh pr merge --merge     # or --squash / --rebase
```

### Useful aliases

```bash
# Add a one-line shortcut
git config --global alias.ac '!git add -A && git commit -m'
git ac "fix: contact form validation"

# View commit history
git log --oneline --graph --decorate -20
```

### When pushing fails (auth error)

If you see an authentication error, the GitHub connection in Arena needs
attention. Click the "Connect GitHub" prompt in the Arena UI and re-authorize.
Then run `git push` again.

---

## 🧪 Validation

All PHP files in the theme are validated with the Node `php-parser` package:

```bash
cd /tmp && npm install php-parser
node -e "
const parser = require('php-parser');
const fs = require('fs');
const path = require('path');
const engine = new parser.Engine({ parser: { php7: true } });
function walk(d){let r=[];for(const e of fs.readdirSync(d,{withFileTypes:true})){const f=path.join(d,e.name);if(e.isDirectory()){if(['node_modules','.git'].includes(e.name))continue;r.push(...walk(f));}else if(e.name.endsWith('.php'))r.push(f);}return r;}
for (const f of walk('/home/user/alianzandco/wordpress-theme/allianzandco')) {
  try { engine.parseCode(fs.readFileSync(f, 'utf8')); console.log('OK', f); }
  catch (e) { console.log('FAIL', f, e.message); }
}
"
```

Expected: all 19 files print `OK`.

---

## 📜 License

GPL-2.0-or-later. Same as WordPress core.

---

## 🙋 FAQ

**Q: Why TranslatePress and not WP Multisite?**
A: Multisite is more complex to set up and operate. TranslatePress gives a
seamless single-site experience with a language switcher, is widely used
(200,000+ active installs), and integrates visually with the editor.

**Q: Can I add more languages (e.g. Arabic, Swahili)?**
A: Yes. **Settings → TranslatePress → Add new translation language**. The
theme's gettext dictionary would need to be extended (drop a PR).

**Q: Where do the partner logos come from?**
A: The 17 partner logos in `assets/images/partner-*.jpeg` are the real client
logos from the original `allianndcooldwebsite` site. Replace them with your
own by uploading via WP admin or overwriting the files.

**Q: How do I add a new team member?**
A: **Team → Add New** in WP admin. Fill the title (name), set a featured image,
fill the role in the "Team Member Details" meta box. Publish. They appear
immediately on `/our-team/` and the homepage preview.

**Q: How do I deploy to production?**
A: Two options:
1. Use the standard WordPress migration flow: install a migration plugin
   (e.g. All-in-One WP Migration, Duplicator) on the local site, export,
   import on production.
2. Or just deploy the theme folder to production: copy
   `wordpress-theme/allianzandco/` to `wp-content/themes/` on the production
   server, then activate the theme in WP admin. The seeding routine is
   guarded by the `al_seeded_v1` option — it will not re-run if content
   already exists.

**Q: Can I disable Google Translate auto-translation?**
A: Yes. In the TranslatePress settings, switch the translation engine to
"Translation Memory" (no auto-translation). You'll then translate content
manually via the visual editor.
