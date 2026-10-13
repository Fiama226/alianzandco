# Allianz & Co – WordPress Theme

A production-ready, professional WordPress theme for **Allianz & Co**, a multi-disciplinary
engineering and construction company operating across the African continent.

The theme is built as a self-contained classic WordPress theme — **no Elementor, no
heavy page-builder plugin** required — and ships with:

- A complete **visual design system** (Space Grotesk + Inter + Playfair Display, warm
  orange accents, bold display typography, generous whitespace), inspired by the
  Avelon reference.
- **Custom post types** for *Team*, *Services*, *Projects* and *FAQs* — with a
  Customizer-driven homepage.
- A **one-click seeding routine** that auto-populates the site with realistic content
  (about, team, services, projects, FAQs, blog posts) on theme activation.
- A **Docker Compose** environment for instant local testing.

---

## 🚀 Quick start (Docker)

Requires only [Docker](https://www.docker.com/) and `docker compose`.

```bash
# from the repository root
./init.sh
# or:
docker compose up -d
```

On first boot, the entrypoint script **auto-installs WordPress, installs
TranslatePress (for the FR/EN bilingual switcher), activates the Allianz & Co
theme, and seeds all content**. Subsequent boots are a no-op.

Then open **http://localhost:8080** in your browser.

Default credentials:

| URL                   | http://localhost:8080           |
|-----------------------|---------------------------------|
| Admin URL             | http://localhost:8080/wp-admin  |
| Username              | `admin`                         |
| Password              | `admin`                         |
| Email                 | `admin@example.com`             |
| phpMyAdmin (optional) | http://localhost:8081           |

> ℹ️ The theme is **mounted as a read-only volume** into the container, so any change
> you make in `wordpress-theme/allianzandco/` is reflected immediately — no rebuild
> needed.

### 🌐 Bilingual FR / EN

The site is fully bilingual out of the box, powered by **TranslatePress**:

- A **language switcher** is in the header (top right) and the mobile menu.
- All theme UI strings (nav, buttons, sections, forms, FAQ accordion) are
  pre-translated to French via the theme's own string dictionary — so the FR
  experience is polished immediately.
- Page/post content is auto-translated by TranslatePress (free Google Translate
  engine by default). The user can refine any translation visually at
  `https://your-site.com/fr/` → click the pencil icon → edit any string.

To add a third language: **Settings → TranslatePress → Add new translation
language**. To change the default language: **Settings → General → Site
Language**.

---

## 📦 Theme structure

```
wordpress-theme/allianzandco/
├── style.css                 ← WordPress theme header
├── functions.php             ← Theme bootstrap, CPTs, customizer, seeding
├── header.php / footer.php  ← Layout chrome
├── index.php                 ← Fallback
├── 404.php
├── archive.php               ← Category / tag / author / date archives
├── single.php                ← Single blog post
├── single-al_team.php        ← Single team member
├── page-home.php             ← Homepage (hero, services, projects, team, blog, CTA)
├── page-about.php            ← About Us
├── page-team.php             ← Our Team (grid)
├── page-services.php         ← Services
├── page-philosophy.php       ← Philosophy
├── page-history.php          ← History (timeline)
├── page-faqs.php             ← FAQs (accordion)
├── page-blog.php             ← Blog list
├── page-contact.php          ← Contact (with built-in form)
├── template-parts/
│   └── page-header.php       ← Reusable page banner
└── assets/
    ├── css/main.css          ← Complete design system
    ├── js/main.js            ← Menu, FAQ, scroll reveal, counters
    └── images/               ← Theme images + project / partner / blog photos
```

---

## 🗺️ Pages (URL → template)

| URL                                | Template             | Notes                              |
|-----------------------------------|----------------------|------------------------------------|
| `/`                                | `page-home.php`      | Hero, services, projects, team, blog, CTA |
| `/about-us/`                       | `page-about.php`     | Story, values, CEO message         |
| `/our-team/`                       | `page-team.php`      | Team grid                          |
| `/team/{name}/`                    | `single-al_team.php` | Individual team member             |
| `/services/`                       | `page-services.php`  | 6 services + delivery model        |
| `/philosophy/`                     | `page-philosophy.php`| Manifesto                          |
| `/history/`                        | `page-history.php`   | Timeline                           |
| `/faqs/`                           | `page-faqs.php`      | Accordion                          |
| `/blog-list/`                      | `page-blog.php`      | Blog index                         |
| `/{post-slug}/` (e.g. `custom-vs-prefab-homes/`) | `single.php` | Single blog article    |
| `/contacts/`                       | `page-contact.php`   | Form + contact info                |
| 404                                | `404.php`            | Custom 404                         |

All slugs are pre-created on theme activation (see **Seeding** below). If you change
a slug in WP admin, links in menus and footers update automatically.

---

## 🌱 Seeding (one-click content)

When the theme is activated, the `al_seed_content()` function runs **once** and
creates:

- **Pages** for every section (with the right templates assigned)
- **Team members** (6) with portraits, roles and bios
- **Services** (6) with descriptions
- **Projects** (6) with client, location, year, category
- **FAQs** (6) covering commercial, technical and process questions
- **Blog posts** (6) with hero images, including the reference
  *Custom vs Prefab Homes* article
- **Customizer defaults** (hero copy, stat counters, contact info, social links)
- The **homepage** is set to a static front page using the `page-home.php` template

To re-seed (e.g. after deleting content), delete the option `al_seeded_v1` from
`wp_options` in phpMyAdmin, or run in WP-CLI:

```bash
docker compose exec wordpress wp eval 'delete_option("al_seeded_v1");'
docker compose exec wordpress wp theme activate allianzandco
```

---

## ⚙️ Customizer

The theme registers a *Homepage Hero*, *Homepage Stats*, *Contact Info* and *Footer*
section. Configure them at **Appearance → Customize** in WP admin.

Key options:

- Hero: eyebrow, title, description, primary button, background image
- Stats (4): number + label, shown above the dark stats section
- Contact: address, phone, email, opening hours
- Footer: about text, social URLs (LinkedIn / X / Facebook / Instagram)

---

## 🛠️ Development

```bash
# Watch / live-reload
docker compose up -d
# edit files in wordpress-theme/allianzandco/ — they are live-mounted

# Inspect logs
docker compose logs -f wordpress

# Reset everything (delete content + uploads)
docker compose down -v
docker compose up -d
```

To enable WP-CLI inside the container:

```bash
docker compose exec wordpress bash
wp --info
```

---

## 🎨 Design system tokens

The palette is sampled from the official Allianz & Co logo:

- **Fonts:** Space Grotesk (display), Inter (body), Playfair Display (accent)
- **Primary green:** `#0b7d38`  *(logo "Alliance & Co" text)*
- **Icon green:** `#297a1d`
- **Gold accent:** `#e3ca3c`  *(Africa icon)*
- **Dark sections:** `#0a1f12`  *(deep green-black)*
- **Soft background:** `#f5f3ee`

All tokens are CSS custom properties — see `assets/css/main.css` (top of file).

---

## 📝 License

GPL-2.0-or-later.
