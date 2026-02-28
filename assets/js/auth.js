/**
 * auth.js
 * Shared JavaScript utilities for UM Skills Clinic authentication pages.
 */

/**
 * Toggles the visibility of a password input field.
 *
 * @param {string} inputId   - The ID of the <input type="password"> element.
 * @param {string} iconId    - The ID of the <svg> icon to update.
 */
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);

    if (!input || !icon) return;

    const isHidden = input.type === 'password';

    input.type = isHidden ? 'text' : 'password';

    icon.innerHTML = isHidden
        ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8
           a18.45 18.45 0 0 1 5.06-5.94"/>
           <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8
           a18.5 18.5 0 0 1-2.16 3.19"/>
           <line x1="1" y1="1" x2="23" y2="23"/>`
        : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
           <circle cx="12" cy="12" r="3"/>`;
}

/**
 * Evaluates password strength and updates the strength bar UI.
 *
 * @param {string} value    - The current password input value.
 * @param {string} fillId   - The ID of the strength fill element.
 * @param {string} labelId  - The ID of the strength label element.
 */
function updatePasswordStrength(value, fillId, labelId) {
    const fill  = document.getElementById(fillId);
    const label = document.getElementById(labelId);

    if (!fill || !label) return;

    let score = 0;
    if (value.length >= 6)             score += 25;
    if (value.length >= 10)            score += 25;
    if (/[A-Z]/.test(value))           score += 25;
    if (/[^a-zA-Z0-9]/.test(value))   score += 25;

    const levels = {
        25:  { color: '#EF4444', text: 'Weak'   },
        50:  { color: '#F59E0B', text: 'Fair'   },
        75:  { color: '#22C55E', text: 'Good'   },
        100: { color: '#F5C518', text: 'Strong' },
    };

    const level = levels[score] ?? { color: '#EF4444', text: 'Weak' };

    fill.style.width      = score + '%';
    fill.style.background = level.color;
    label.textContent     = value.length === 0 ? '—' : level.text;
    label.style.color     = value.length === 0 ? '#666688' : level.color;
}