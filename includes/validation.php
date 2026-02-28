<?php
/**
 * validation.php
 * Reusable input validation functions for UM Skills Clinic.
 */

/**
 * Sanitizes a string input from POST data.
 *
 * @param string $key     The POST field name.
 * @param string $default Fallback value if field is missing.
 * @return string         Trimmed, sanitized string.
 */
function getInput(string $key, string $default = ''): string {
    return htmlspecialchars(trim($_POST[$key] ?? $default), ENT_QUOTES, 'UTF-8');
}

/**
 * Retrieves a raw (unsanitized) POST value, e.g. for passwords.
 *
 * @param string $key     The POST field name.
 * @param string $default Fallback value if field is missing.
 * @return string
 */
function getRawInput(string $key, string $default = ''): string {
    return $_POST[$key] ?? $default;
}

/**
 * Validates login form fields.
 *
 * @param string $username
 * @param string $password
 * @return array           List of validation error messages.
 */
function validateLogin(string $username, string $password): array {
    $errors = [];

    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    return $errors;
}

/**
 * Validates registration form fields.
 *
 * @param array $data Associative array of form inputs.
 * @return array      List of validation error messages.
 */
function validateRegistration(array $data): array {
    $errors = [];

    // Full Name
    if (empty($data['full_name'])) {
        $errors[] = 'Full Name is required.';
    } elseif (strlen($data['full_name']) < 3) {
        $errors[] = 'Full Name must be at least 3 characters.';
    }

    // Email
    if (empty($data['email'])) {
        $errors[] = 'Email Address is required.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }

    // Student ID
    if (empty($data['student_id'])) {
        $errors[] = 'Student ID is required.';
    }

    // Username
    if (empty($data['username'])) {
        $errors[] = 'Username is required.';
    } elseif (strlen($data['username']) < 4) {
        $errors[] = 'Username must be at least 4 characters.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
        $errors[] = 'Username may only contain letters, numbers, and underscores.';
    }

    // Password
    if (empty($data['password'])) {
        $errors[] = 'Password is required.';
    } elseif (strlen($data['password']) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    // Confirm Password
    if ($data['password'] !== $data['confirm']) {
        $errors[] = 'Passwords do not match.';
    }

    // Program
    $allowedPrograms = ['BSCS', 'BSIT', 'BSIS', 'ACT'];
    if (empty($data['program']) || !in_array($data['program'], $allowedPrograms, true)) {
        $errors[] = 'Please select a valid Program.';
    }

    // Year Level
    $allowedYears = ['1', '2', '3', '4'];
    if (empty($data['year_level']) || !in_array($data['year_level'], $allowedYears, true)) {
        $errors[] = 'Please select a valid Year Level.';
    }

    // Terms
    if (empty($data['terms'])) {
        $errors[] = 'You must agree to the Terms & Conditions.';
    }

    return $errors;
}