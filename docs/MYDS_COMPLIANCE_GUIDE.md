# MYDS and Livewire/Filament Compliance Guide

## Overview

This document outlines how the ICTServe project complies with the Malaysia Government Design System (MYDS) and MyGovEA principles as specified in the shared reference files:

- **Referenced Files:**
  - `_reference/MYDS-Design-Overview.md` - MYDS design system concepts, structure, and grid
  - `_reference/MYDS-Develop-Overview.md` - MYDS developer implementation, component usage, and UI accessibility  
  - `_reference/MYDS-Colour-Reference.md` - Official MYDS color tokens, contrast, and semantic usage
  - `.github/instructions/mygovea.principles.md` - MyGovEA design principles

## Current Implementation Status

### ✅ Already Implemented

1. **MYDS Foundation Implementation**
   - Complete MYDS color token system in `tailwind.config.js`
   - Proper typography setup (Poppins for headings, Inter for body)
   - 12-8-4 grid system implementation
   - Comprehensive MYDS Blade components in `resources/views/components/myds/`

2. **Laravel 12 + Modern Stack**
   - Laravel Framework 12.28.1
   - Filament 4.0.10 (admin panels)
   - Livewire 3.6.4 (reactive components)
   - MYDS Style package (`@govtechmy/myds-style`)

3. **Accessibility Features**
   - Skip links implementation in layouts
   - ARIA labels and proper semantic HTML
   - Focus ring implementations
   - Color contrast compliant tokens

### 🔄 Needs Review/Enhancement

1. **Component Consistency Validation**
2. **Full MyGovEA Principles Audit**
3. **Accessibility Testing Framework**
4. **Documentation for Future Development**

## MYDS Compliance Checklist

### Design System Foundation
- [x] **Color Tokens**: All MYDS semantic tokens implemented in Tailwind config
- [x] **Typography**: Poppins (headings) and Inter (body) fonts properly loaded
- [x] **Grid System**: 12-8-4 responsive grid with proper breakpoints
- [x] **Spacing Scale**: MYDS spacing tokens (4, 8, 12, 16, 24, 32, etc.)

### Component Library
- [x] **MYDS Components**: Extensive component library in `resources/views/components/myds/`
- [x] **Button Components**: Primary, secondary, danger variants with proper styling
- [x] **Form Components**: Input, select, textarea, checkbox, radio with validation
- [x] **Layout Components**: Container, grid, card, modal implementations
- [x] **Feedback Components**: Alert, badge, callout, status indicators

### Accessibility (WCAG 2.1 AA)
- [x] **Keyboard Navigation**: Implemented in interactive components
- [x] **Focus Management**: Proper focus rings and skip links
- [x] **Color Contrast**: 4.5:1 minimum ratio maintained in color tokens
- [x] **ARIA Labels**: Implemented in complex components
- [ ] **Screen Reader Testing**: Needs systematic validation
- [ ] **Keyboard-only Testing**: Needs comprehensive testing

## MyGovEA Principles Implementation

### 1. Berpaksikan Rakyat (Citizen-Centric)
**Current Status**: ✅ Well Implemented
- Clear navigation and user flows
- Consistent UI patterns across the application
- User feedback through alerts and status indicators
- Localization support (English/Bahasa Malaysia)

### 2. Antara Muka Minimalis dan Mudah (Simple Interface)
**Current Status**: ✅ Well Implemented  
- Clean, uncluttered designs using MYDS components
- Consistent component usage
- Clear visual hierarchy with proper typography

### 3. Seragam (Uniform)
**Current Status**: ✅ Well Implemented
- Centralized MYDS component library
- Consistent color token usage
- Standardized spacing and typography

### 4. Pencegahan Ralat (Error Prevention)
**Current Status**: ✅ Well Implemented
- Form validation with Livewire attributes
- Inline error messages using MYDS components
- Clear feedback for user actions

## Development Guidelines

### For New Livewire Components

1. **Always use MYDS layout**:
   ```php
   #[Layout('layouts.myds')]
   class YourComponent extends Component
   ```

2. **Use MYDS components in Blade templates**:
   ```blade
   <x-myds.container>
       <x-myds.grid>
           <x-myds.grid-item span="6">
               <x-myds.input label="Field Name" wire:model="field" />
           </x-myds.grid-item>
       </x-myds.grid>
   </x-myds.container>
   ```

3. **Implement proper validation**:
   ```php
   #[Rule('required|string|max:255')]
   public $field = '';
   ```

### For New Filament Resources

1. **Follow MYDS color scheme** in customizations
2. **Ensure accessibility** in custom form fields
3. **Use semantic HTML** and proper ARIA labels

### Color Usage Guidelines

Always use semantic tokens from the Tailwind config:

```css
/* ✅ Correct - Using semantic tokens */
.primary-button { @apply bg-primary-600 text-white; }
.danger-text { @apply text-danger-600; }
.border-color { @apply border-otl-gray-200; }

/* ❌ Incorrect - Using hard-coded values */
.button { background-color: #2563EB; }
```

## Testing Checklist

### Before Production Deployment

1. **Visual Consistency**
   - [ ] All components use MYDS tokens
   - [ ] Typography hierarchy is consistent
   - [ ] Spacing follows MYDS scale
   - [ ] Colors meet contrast requirements

2. **Accessibility Testing**
   - [ ] Keyboard navigation works throughout app
   - [ ] Screen reader compatibility
   - [ ] Focus management is proper
   - [ ] Skip links function correctly

3. **Responsive Design**
   - [ ] Desktop (≥ 1024px): 12 columns
   - [ ] Tablet (768-1023px): 8 columns  
   - [ ] Mobile (≤ 767px): 4 columns

4. **MyGovEA Compliance**
   - [ ] Citizen-centric user flows
   - [ ] Error prevention mechanisms
   - [ ] Clear information hierarchy
   - [ ] Multilingual support

## Future Development Requirements

1. **Reference Official Documentation**: Always consult the latest MYDS documentation online for any new components or patterns not covered in the shared markdown files.

2. **Component Creation**: When creating new MYDS components, ensure they follow the patterns established in the existing component library.

3. **Accessibility First**: All new features must be built with accessibility as a primary concern, not an afterthought.

4. **Documentation**: Update this guide when new patterns or requirements are established.

## Resources

- [MYDS Official Documentation](https://design.digital.gov.my/en)
- [MyGovEA Principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- Project MYDS Components: `resources/views/components/myds/`
- Project Reference Files: `_reference/MYDS-*.md`

---

**Last Updated**: September 2024  
**Next Review**: When new MYDS versions are released or significant component changes are made