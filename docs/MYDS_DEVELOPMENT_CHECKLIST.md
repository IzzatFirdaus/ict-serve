# MYDS Development Checklist

Use this checklist when creating or updating Livewire components, Filament resources, or any UI elements to ensure MYDS and MyGovEA compliance.

## Pre-Development Checklist

- [ ] I have reviewed the current MYDS component library in `resources/views/components/myds/`
- [ ] I have consulted `_reference/MYDS-*.md` files for design guidelines
- [ ] I have checked if a similar component already exists to maintain consistency
- [ ] I understand the citizen-centric requirements for this feature

## Component Development Checklist

### Layout and Structure

- [ ] Uses proper MYDS layout (`layouts.myds` or equivalent)
- [ ] Implements 12-8-4 grid system with `x-myds.grid` and `x-myds.grid-item`
- [ ] Uses `x-myds.container` for proper content width constraints
- [ ] Follows semantic HTML structure (headings hierarchy, landmarks)

### Typography

- [ ] Uses `x-myds.heading` components for headings (h1-h6)
- [ ] Uses `x-myds.text` for body content
- [ ] Maintains proper heading hierarchy (no skipping levels)
- [ ] Uses appropriate font families (Poppins for headings, Inter for body)

### Colors and Theming

- [ ] Uses only MYDS semantic color tokens (primary-_, danger-_, success-\*, etc.)
- [ ] Avoids hard-coded hex values
- [ ] Maintains 4.5:1 minimum contrast ratio
- [ ] Supports both light and dark themes (if applicable)

### Interactive Elements

- [ ] Uses `x-myds.button` components with proper variants
- [ ] Implements proper hover and focus states
- [ ] Includes accessible focus rings (`focus:ring-primary-600`)
- [ ] Uses consistent interactive element sizing (minimum 48x48px touch targets)

### Forms and Validation

- [ ] Uses `x-myds.input`, `x-myds.select`, `x-myds.textarea` components
- [ ] Implements Livewire validation rules with `#[Rule()]` attributes
- [ ] Shows inline validation errors with MYDS error styling
- [ ] Includes proper labels and help text
- [ ] Implements error prevention (disabled states, confirmation dialogs)

### Accessibility (WCAG 2.1 AA)

- [ ] Includes proper ARIA labels and descriptions
- [ ] Supports keyboard navigation (Tab, Enter, Escape)
- [ ] Uses semantic HTML elements appropriately
- [ ] Includes skip links where appropriate
- [ ] Has been tested with keyboard-only navigation
- [ ] Screen reader friendly (proper alt text, labels)

### MyGovEA Principles Implementation

#### Berpaksikan Rakyat (Citizen-Centric)

- [ ] User flow is intuitive and efficient
- [ ] Error messages are clear and helpful
- [ ] Language is simple and understandable
- [ ] Supports both English and Bahasa Malaysia

#### Antara Muka Minimalis dan Mudah (Simple Interface)

- [ ] UI is clean and uncluttered
- [ ] Uses consistent component patterns
- [ ] Avoids unnecessary decorative elements
- [ ] Focuses on primary user tasks

#### Seragam (Uniform)

- [ ] Follows established component patterns
- [ ] Uses consistent spacing (MYDS spacing scale)
- [ ] Maintains visual consistency with existing features

#### Pencegahan Ralat (Error Prevention)

- [ ] Validates input before submission
- [ ] Provides clear feedback for user actions
- [ ] Includes confirmation for destructive actions
- [ ] Handles edge cases gracefully

## Testing Checklist

### Visual Testing

- [ ] Component renders correctly on desktop (≥1024px)
- [ ] Component renders correctly on tablet (768-1023px)
- [ ] Component renders correctly on mobile (≤767px)
- [ ] All interactive states work (hover, focus, active, disabled)
- [ ] Color contrast meets WCAG standards

### Functional Testing

- [ ] All form validation works correctly
- [ ] Livewire component updates work as expected
- [ ] Error handling works properly
- [ ] Success states are clearly communicated

### Accessibility Testing

- [ ] Can be navigated using only keyboard
- [ ] Screen reader announces content properly
- [ ] Focus indicators are visible and clear
- [ ] Skip links work correctly
- [ ] ARIA attributes are properly implemented

### Performance Testing

- [ ] Component loads quickly
- [ ] No unnecessary re-renders
- [ ] Images are optimized and have proper alt text
- [ ] Livewire requests are efficient

## Code Review Checklist

### Code Quality

- [ ] Follows Laravel and Livewire best practices
- [ ] Uses proper PHP type declarations
- [ ] Includes appropriate PHPDoc comments
- [ ] Follows PSR coding standards

### MYDS Compliance

- [ ] Uses only approved MYDS components
- [ ] Follows color token naming conventions
- [ ] Implements proper spacing and typography
- [ ] Includes proper accessibility attributes

### Documentation

- [ ] Component purpose and usage is documented
- [ ] Any deviations from MYDS standards are justified and documented
- [ ] Examples of proper usage are provided

## Pre-Production Checklist

- [ ] Component has been tested with real user data
- [ ] Performance impact has been assessed
- [ ] Accessibility has been validated with assistive technologies
- [ ] Component works correctly in all supported browsers
- [ ] Responsive design has been tested on actual devices

## Post-Deployment Checklist

- [ ] Monitor for any user feedback or issues
- [ ] Track usage analytics if applicable
- [ ] Update documentation if needed
- [ ] Plan for future improvements based on user feedback

## Emergency MYDS Reference

If official MYDS documentation is needed beyond the reference files:

1. **Design Guidelines**: https://design.digital.gov.my/en/docs/design
2. **Component Documentation**: https://design.digital.gov.my/en/docs/develop
3. **Color System**: https://design.digital.gov.my/en/docs/design/color
4. **Accessibility Guidelines**: WCAG 2.1 AA standards

## Quick Component Reference

```blade
<!-- Basic Structure -->
<x-myds.container>
    <x-myds.grid>
        <x-myds.grid-item span="6">
            <x-myds.heading level="2">Section Title</x-myds.heading>
            <x-myds.text>Content goes here...</x-myds.text>
        </x-myds.grid-item>
    </x-myds.grid>
</x-myds.container>

<!-- Form Example -->
<x-myds.input
    label="Field Label"
    name="field_name"
    wire:model="fieldName"
    :error="$errors->first('fieldName')"
    required
/>

<!-- Button Example -->
<x-myds.button
    variant="primary"
    wire:click="submitForm"
    :disabled="$processing"
>
    Submit Form
</x-myds.button>
```

---

**Remember**: This checklist ensures compliance with MYDS, MyGovEA principles, and accessibility standards. When in doubt, refer to the official documentation or consult the project's MYDS component library.
