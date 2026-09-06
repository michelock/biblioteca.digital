---
name: Civic Horizon
colors:
  surface: '#f8fafb'
  surface-dim: '#d8dadb'
  surface-bright: '#f8fafb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f5'
  surface-container: '#eceeef'
  surface-container-high: '#e6e8e9'
  surface-container-highest: '#e1e3e4'
  on-surface: '#191c1d'
  on-surface-variant: '#40484d'
  inverse-surface: '#2e3132'
  inverse-on-surface: '#eff1f2'
  outline: '#70787d'
  outline-variant: '#c0c8cd'
  surface-tint: '#236580'
  primary: '#00475e'
  on-primary: '#ffffff'
  primary-container: '#1a5f7a'
  on-primary-container: '#9bd7f7'
  inverse-primary: '#92cfee'
  secondary: '#7a590c'
  on-secondary: '#ffffff'
  secondary-container: '#fed17b'
  on-secondary-container: '#78580b'
  tertiary: '#5f3800'
  on-tertiary: '#ffffff'
  tertiary-container: '#7b4f16'
  on-tertiary-container: '#ffc484'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#c0e8ff'
  primary-fixed-dim: '#92cfee'
  on-primary-fixed: '#001e2b'
  on-primary-fixed-variant: '#004d66'
  secondary-fixed: '#ffdea5'
  secondary-fixed-dim: '#ecc06c'
  on-secondary-fixed: '#271900'
  on-secondary-fixed-variant: '#5d4200'
  tertiary-fixed: '#ffddbb'
  tertiary-fixed-dim: '#f7bb78'
  on-tertiary-fixed: '#2b1700'
  on-tertiary-fixed-variant: '#663e04'
  background: '#f8fafb'
  on-background: '#191c1d'
  surface-variant: '#e1e3e4'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.05em
  caption:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 0.25rem
  sm: 0.5rem
  md: 1rem
  lg: 1.5rem
  xl: 2.5rem
  container-max: 1280px
  gutter: 24px
---

## Brand & Style

The design system is engineered for a municipality’s library ecosystem, balancing the authority of a public institution with the warmth of a community hub. The brand personality is **Knowledge-Forward, Welcoming, and Orderly**. It aims to evoke a sense of quiet confidence and effortless accessibility, ensuring that citizens of all ages and digital literacies feel empowered to explore the collection.

The design style is **Corporate Modern with Tactile Accents**. It utilizes a clean, systematic foundation (high whitespace, structured grids) but softens the institutional edge through rounded geometry and high-quality "Elegant Gold" accents. The emotional response should be one of "Reliable Inspiration"—a place where logic meets discovery.

## Colors

The palette is anchored by **Trustful Blue (#1A5F7A)**, used for primary actions, navigation, and structural elements to establish credibility. **Elegant Gold (#C9A050)** acts as a sophisticated accent, reserved for highlighting "New Arrivals," featured collections, or premium membership status—adding a layer of warmth and prestige to the municipal service.

The background uses a pure **White (#FFFFFF)** to maximize legibility, while a very light **Neutral (#F8FAFB)** is used for section containers to create subtle grouping. High-contrast dark slate is used for text to ensure WCAG AA/AAA compliance for accessibility.

## Typography

The design system relies exclusively on **Inter** for its systematic clarity and excellent legibility across all weights. The typographic hierarchy emphasizes a "reading-first" approach. 

- **Display & Headlines:** Use semi-bold to bold weights with slight negative letter-spacing to create a tight, professional look.
- **Body Text:** Uses a 1.5x to 1.6x line-height ratio to ensure long descriptions of books and articles are comfortable to read.
- **Labels:** Small caps or increased letter-spacing are used for metadata (e.g., ISBN, Author Name) to distinguish factual data from narrative text.

## Layout & Spacing

This design system follows a **Fixed Grid** model on desktop to maintain a "book-like" structure and premium feel, transitioning to a fluid model on smaller screens. 

- **Desktop (1280px+):** 12-column grid with 24px gutters. Generous 40px - 80px margins create a sense of calm and prevent the interface from feeling cluttered.
- **Tablet (768px - 1024px):** 8-column grid with 16px gutters.
- **Mobile (below 768px):** 4-column fluid grid.

Vertical rhythm is strictly based on 8px increments. The "Spacious" philosophy is achieved by doubling the standard padding in card containers and between sections to allow the eye to rest.

## Elevation & Depth

Depth is used sparingly to signify interactivity and layering without overwhelming the user. 

- **Level 1 (Base):** Flat surfaces with a 1px border (#E2E8F0) for standard layout cards.
- **Level 2 (Interactive):** "Soft Shadows" with high diffusion (20px blur) and low opacity (4% - 6% alpha) are applied to cards on hover and primary call-to-action buttons.
- **Level 3 (Overlays):** Used for search results and modals. These utilize a Backdrop Blur (8px) on the surface behind them to maintain context while focusing the user's attention.

The use of "Tonal Layers" is preferred over heavy shadows; for instance, the search bar may sit on a slightly darker #F1F5F9 background to distinguish it from the white content area.

## Shapes

The shape language is **friendly and organic**. A standard corner radius of 8px (0.5rem) is used for all primary UI elements like book cards, search inputs, and container blocks. 

For high-priority buttons and categories (chips), the system utilizes **rounded-xl (1.5rem)** to create a more approachable, modern feel. Book covers should retain a tighter 4px radius to mimic the physical nature of a book's edge while still feeling unified with the overall soft-UI aesthetic.

## Components

- **Buttons:** Primary buttons are Solid Trustful Blue with white text. Secondary buttons use a Ghost style (Blue outline). Accent buttons for "New" or "Special" items use the Elegant Gold.
- **Book Cards:** Vertically oriented. Features a subtle border and Level 2 shadow on hover. Metadata (Title, Author) is left-aligned with the "Reserve" button consistently at the bottom.
- **Chips:** Used for genres and tags. These are pill-shaped with light blue backgrounds (#EBF4F8) and dark blue text.
- **Search Bar:** A large, prominent component with a rounded-xl radius and a persistent Gold magnifying glass icon.
- **Availability Indicators:** A small, circular status dot. Green for "Available," Gold for "Reference Only," and Grey for "Checked Out."
- **Navigation:** A clean top-tier navigation with high contrast. The active state is indicated by a 3px Elegant Gold bottom border on the menu item.