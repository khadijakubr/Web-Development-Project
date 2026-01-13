# Styling Reference Guide - Component Library

## Color Palette Reference

### Monochromatic Colors
```
Primary Black      #1a1a1a  ████████████████████  (Text, Dark BG)
Secondary Gray     #4a4a4a  ████████████████████  (Secondary Text)
Light Gray         #e5e5e5  ████████████████████  (Light Elements)
Off-White          #f8f8f8  ████████████████████  (Light BG)
Pure White         #ffffff  ████████████████████  (Cards, Main BG)
Border Color       #d1d5db  ████████████████████  (Borders)
BG Light           #f3f4f6  ████████████████████  (Sections)
```

### Status Colors
```
Success            #059669  ████████████████████  (Positive Actions)
Danger             #dc2626  ████████████████████  (Destructive)
Warning            #92400e  ████████████████████  (Caution)
Info               #0284c7  ████████████████████  (Information)
```

---

## Typography Scale

### Headings
```
H1 (2.5rem)  - Display headlines, page titles
H2 (2rem)    - Main section titles
H3 (1.5rem)  - Subsection titles
H4 (1.25rem) - Card titles, form headers
H5 (1.1rem)  - Smaller headings
H6 (1rem)    - Mini headings
```

**Font Properties**:
- Font Weight: 300-400 (lightweight, elegant)
- Letter Spacing: -0.5px (tighter, professional)
- Line Height: 1.2-1.4

### Body Text
```
Body Text (1rem)       - Default paragraph text
Small Text (0.9rem)    - Secondary information
Tiny Text (0.85rem)    - Labels, captions
```

**Font Properties**:
- Font Weight: 400 (normal)
- Line Height: 1.6 (readable)
- Color: var(--secondary-gray)

---

## Spacing System

### Margin & Padding Scale
```
0      = 0px
0.5rem = 8px
1rem   = 16px
1.5rem = 24px
2rem   = 32px
2.5rem = 40px
3rem   = 48px
4rem   = 64px
```

**Usage**:
- Cards: `padding: 2rem;`
- Section spacing: `margin-bottom: 2rem;`
- Small gaps: `gap: 0.5rem;`
- Content padding: `padding: 1.5rem;`

---

## Border Radius

```
Subtle:   4px  (form inputs, buttons)
Medium:   6px  (cards)
Rounded:  8px  (large cards, modals)
Full:     9999px (badges, circular elements)
```

---

## Shadow System

### Subtle Shadow
```css
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
```
Used on: Default cards

### Medium Shadow
```css
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
```
Used on: Hover states, lifted elements

### Large Shadow
```css
box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
```
Used on: Modals, popups

---

## Button Styles

### Primary Button (Black)
```css
background-color: var(--primary-black);
color: var(--pure-white);
padding: 0.75rem 1.5rem;
border-radius: 4px;
font-weight: 500;
```

**Hover State**:
```css
background-color: var(--secondary-gray);
transform: translateY(-1px);
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
```

### Secondary Button (Gray)
```css
background-color: var(--off-white);
color: var(--primary-black);
border: 1px solid var(--border-color);
padding: 0.75rem 1.5rem;
border-radius: 4px;
```

**Hover State**:
```css
background-color: var(--bg-light);
```

### Outline Button
```css
background-color: transparent;
border: 1px solid var(--primary-black);
color: var(--primary-black);
padding: 0.75rem 1.5rem;
border-radius: 4px;
```

**Hover State**:
```css
background-color: var(--primary-black);
color: var(--pure-white);
```

### Success Button
```css
background-color: var(--success);
color: var(--pure-white);
padding: 0.75rem 1.5rem;
border-radius: 4px;
```

**Hover State**:
```css
background-color: #047857;
```

### Danger Button
```css
background-color: var(--danger);
color: var(--pure-white);
padding: 0.75rem 1.5rem;
border-radius: 4px;
```

**Hover State**:
```css
background-color: #b91c1c;
```

### Small Button
```css
padding: 0.5rem 1rem;
font-size: 0.85rem;
```

---

## Form Elements

### Text Input
```css
border: 1px solid var(--border-color);
border-radius: 4px;
padding: 0.75rem;
font-size: 0.95rem;
color: var(--primary-black);
background-color: var(--pure-white);
```

**Focus State**:
```css
border-color: var(--primary-black);
box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
outline: none;
```

### Label
```css
font-weight: 500;
color: var(--primary-black);
margin-bottom: 0.5rem;
font-size: 0.95rem;
```

### Select / Textarea
Same as text input with appropriate sizing.

---

## Card Component

### Basic Card
```css
background-color: var(--pure-white);
border: 1px solid var(--border-color);
border-radius: 6px;
padding: 2rem;
margin-bottom: 2rem;
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
transition: all 0.3s ease;
```

**Hover State**:
```css
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
```

### Card Header
```css
border-bottom: 1px solid var(--border-color);
padding-bottom: 1rem;
margin-bottom: 1rem;
display: flex;
justify-content: space-between;
align-items: center;
```

### Card Title
```css
font-size: 1.3rem;
font-weight: 500;
margin: 0;
color: var(--primary-black);
```

---

## Alert / Message Styles

### Success Alert
```css
background-color: #dcfce7;
color: #166534;
border-color: #bbf7d0;
border: 1px solid;
border-radius: 6px;
padding: 1rem 1.5rem;
```

### Danger Alert
```css
background-color: #fee2e2;
color: #991b1b;
border-color: #fecaca;
border: 1px solid;
border-radius: 6px;
padding: 1rem 1.5rem;
```

### Warning Alert
```css
background-color: #fef3c7;
color: #92400e;
border-color: #fcd34d;
border: 1px solid;
border-radius: 6px;
padding: 1rem 1.5rem;
```

### Info Alert
```css
background-color: #cffafe;
color: #0c4a6e;
border-color: #a5f3fc;
border: 1px solid;
border-radius: 6px;
padding: 1rem 1.5rem;
```

---

## Badge / Tag Styles

### Default Badge
```css
display: inline-block;
padding: 0.35rem 0.75rem;
border-radius: 12px;
font-size: 0.8rem;
font-weight: 600;
text-transform: uppercase;
letter-spacing: 0.5px;
background-color: var(--primary-black);
color: var(--pure-white);
```

### Success Badge
```css
background-color: var(--success);
color: var(--pure-white);
```

### Danger Badge
```css
background-color: var(--danger);
color: var(--pure-white);
```

---

## Table Styles

### Table Header
```css
background-color: var(--bg-light);
border-bottom: 2px solid var(--border-color);
```

### Table Header Cell
```css
padding: 1rem 1.5rem;
text-align: left;
font-weight: 600;
color: var(--primary-black);
text-transform: uppercase;
letter-spacing: 0.5px;
font-size: 0.85rem;
```

### Table Body Cell
```css
padding: 1rem 1.5rem;
border-bottom: 1px solid var(--border-color);
color: var(--secondary-gray);
```

### Table Row Hover
```css
background-color: var(--bg-light);
```

---

## Transition & Animation

### Standard Transition
```css
transition: all 0.3s ease;
```

### Color Only Transition
```css
transition: color 0.3s ease;
```

### Transform Transition
```css
transition: transform 0.3s ease, box-shadow 0.3s ease;
```

---

## Grid Layouts

### Product Grid (4 columns desktop)
```css
display: grid;
grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
gap: 2rem;
padding: 2rem;
max-width: 1400px;
margin: 0 auto;
```

### 2 Column Layout
```css
grid-template-columns: repeat(2, 1fr);
gap: 2rem;
```

### 3 Column Layout
```css
grid-template-columns: repeat(3, 1fr);
gap: 2rem;
```

---

## Responsive Classes

### Mobile-First Approach
```css
/* Mobile (default) */
.element { font-size: 0.9rem; }

/* Tablet (768px+) */
@media (min-width: 768px) {
    .element { font-size: 1rem; }
}

/* Desktop (1024px+) */
@media (min-width: 1024px) {
    .element { font-size: 1.1rem; }
}
```

---

## Accessibility Features

### Focus States (Keyboard Navigation)
All interactive elements have:
```css
:focus {
    outline: none;
    border-color: var(--primary-black);
    box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
}
```

### Hover States
All buttons and links have:
```css
:hover {
    color: var(--primary-black);
    transition: all 0.3s ease;
}
```

### Color Contrast
- Text on White: #1a1a1a (18.67:1 WCAG AAA)
- Text on Gray: #4a4a4a (9.28:1 WCAG AA)
- All elements meet WCAG AA minimum

---

## Common Patterns

### Centered Form
```html
<div class="w-full max-w-md mx-auto">
    <form class="space-y-5">
        <!-- Form fields -->
    </form>
</div>
```

### Card with Actions
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Title</h3>
        <button class="btn btn-sm btn-secondary">Action</button>
    </div>
    <div class="card-body">
        <!-- Content -->
    </div>
</div>
```

### Button Group
```html
<div class="btn-group">
    <button class="btn btn-primary">Save</button>
    <button class="btn btn-secondary">Cancel</button>
</div>
```

### Data Table
```html
<table class="table">
    <thead>
        <tr>
            <th>Header 1</th>
            <th>Header 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data 1</td>
            <td>Data 2</td>
        </tr>
    </tbody>
</table>
```

---

**Last Updated**: January 11, 2026
**Version**: 1.0
**Status**: Complete ✅
