# Static preview

This folder is a **standalone static HTML preview** of the homepage design — useful
for sharing a quick visual without spinning up the Docker stack. It uses the same
CSS/JS/images as the live WordPress theme.

To view it: open `home.html` in a browser, or run:

```bash
cd preview && python3 -m http.server 8000
# then open http://localhost:8000/home.html
```

Note: this is **not** the real site — it doesn't have bilingual switching, dynamic
data, comments, or any WordPress features. For the full experience, use the Docker
stack at the project root.
