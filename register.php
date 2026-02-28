<?php
/**
 * register.php
 * Handles registration form display and server-side validation.
 */

require_once 'includes/validation.php';

// ── Handle POST submission ──────────────────────────────────────────────────
$errors  = [];
$success = false;
$data    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize all inputs
    $data = [
        'full_name'  => getInput('full_name'),
        'email'      => getInput('email'),
        'student_id' => getInput('student_id'),
        'username'   => getInput('username'),
        'password'   => getRawInput('password'),
        'confirm'    => getRawInput('confirm'),
        'program'    => getInput('program'),
        'year_level' => getInput('year_level'),
        'terms'      => !empty($_POST['terms']),
    ];

    $errors = validateRegistration($data);

    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UM Skills Clinic — Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

    <!-- Background Layers -->
    <div class="bg"></div>
    <div class="bg-grain"></div>
    <div class="bg-shimmer"></div>

    <!-- Register Card -->
    <div class="card-wrap card-wrap--wide">
        <div class="card">

            <!-- Logo -->
            <div class="card__logo">
                <img class="card__logo-img" src="umsclogo.png" alt="UM Skills Clinic Logo">
            </div>

            <h1 class="card__title">Create your Account</h1>
            <p class="card__subtitle">Join UM Skills Clinic — fill in the form below.</p>

            <!-- Success State -->
            <?php if ($success): ?>
                <div class="alert alert--success alert--visible">
                    <span class="success__icon">🎓</span>
                    <div class="success__title">Registration Successful!</div>
                    <p class="success__msg">
                        Welcome, <strong><?= htmlspecialchars($data['full_name']) ?></strong>!<br>
                        Your account <strong>@<?= htmlspecialchars($data['username']) ?></strong> is ready.
                    </p>
                    <a href="login.php" class="btn-login-now">Sign In Now →</a>
                </div>

            <?php else: ?>

                <!-- Error Alert -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert--error alert--block alert--visible">
                        Please fix the following:
                        <ul class="alert__error-list">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Registration Form -->
                <form method="POST" action="" autocomplete="off" novalidate>

                    <!-- Section: Personal Information -->
                    <p class="form__section-label">Personal Information</p>
                    <div class="form__grid">

                        <!-- Full Name -->
                        <div class="field col-full">
                            <div class="field__header">
                                <label class="field__label" for="full_name">
                                    Full Name<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="full_name"
                                    name="full_name"
                                    class="input"
                                    placeholder="e.g. Juan Dela Cruz"
                                    value="<?= htmlspecialchars($data['full_name'] ?? '') ?>"
                                    autocomplete="name"
                                >
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="field">
                            <div class="field__header">
                                <label class="field__label" for="email">
                                    Email Address<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </span>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="input"
                                    placeholder="you@um.edu.ph"
                                    value="<?= htmlspecialchars($data['email'] ?? '') ?>"
                                    autocomplete="email"
                                >
                            </div>
                        </div>

                        <!-- Student ID -->
                        <div class="field">
                            <div class="field__header">
                                <label class="field__label" for="student_id">
                                    Student ID<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                                        <path d="M16 3H8l-2 4h12l-2-4z"/>
                                    </svg>
                                </span>
                                <input
                                    type="text"
                                    id="student_id"
                                    name="student_id"
                                    class="input"
                                    placeholder="e.g. 2023-00001"
                                    value="<?= htmlspecialchars($data['student_id'] ?? '') ?>"
                                >
                            </div>
                        </div>

                    </div>

                    <!-- Section: Account Credentials -->
                    <p class="form__section-label">Account Credentials</p>
                    <div class="form__grid">

                        <!-- Username -->
                        <div class="field col-full">
                            <div class="field__header">
                                <label class="field__label" for="username">
                                    Username<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">@</span>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="input"
                                    placeholder="Choose a unique username"
                                    value="<?= htmlspecialchars($data['username'] ?? '') ?>"
                                    autocomplete="username"
                                >
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="field">
                            <div class="field__header">
                                <label class="field__label" for="password">
                                    Password<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="input"
                                    placeholder="Min. 6 characters"
                                    oninput="updatePasswordStrength(this.value, 'pw-fill', 'pw-label')"
                                    autocomplete="new-password"
                                >
                                <span class="input-wrap__icon-right" onclick="togglePasswordVisibility('password', 'pw-eye')" title="Toggle password visibility">
                                    <svg id="pw-eye" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="pw-strength">
                                <div class="pw-strength__bar">
                                    <div class="pw-strength__fill" id="pw-fill"></div>
                                </div>
                                <span class="pw-strength__label" id="pw-label">—</span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="field">
                            <div class="field__header">
                                <label class="field__label" for="confirm">
                                    Confirm Password<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                </span>
                                <input
                                    type="password"
                                    id="confirm"
                                    name="confirm"
                                    class="input"
                                    placeholder="Re-enter password"
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                    </div>

                    <!-- Section: Academic Details -->
                    <p class="form__section-label">Academic Details</p>
                    <div class="form__grid">

                        <!-- Program -->
                        <div class="field">
                            <div class="field__header">
                                <label class="field__label" for="program">
                                    Program<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                    </svg>
                                </span>
                                <select id="program" name="program" class="select">
                                    <option value="" disabled <?= empty($data['program']) ? 'selected' : '' ?>>Select program</option>
                                    <?php foreach (['BSCS', 'BSIT', 'BSIS', 'ACT'] as $prog): ?>
                                        <option value="<?= $prog ?>" <?= ($data['program'] ?? '') === $prog ? 'selected' : '' ?>>
                                            <?= $prog ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="select-arrow">▾</span>
                            </div>
                        </div>

                        <!-- Year Level -->
                        <div class="field">
                            <div class="field__header">
                                <label class="field__label" for="year_level">
                                    Year Level<span class="field__required">*</span>
                                </label>
                            </div>
                            <div class="input-wrap">
                                <span class="input-wrap__icon-left">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                                        <line x1="3"  y1="10" x2="21" y2="10"/>
                                    </svg>
                                </span>
                                <select id="year_level" name="year_level" class="select">
                                    <option value="" disabled <?= empty($data['year_level']) ? 'selected' : '' ?>>Select year</option>
                                    <?php
                                        $yearLabels = ['1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year'];
                                        foreach ($yearLabels as $value => $label):
                                    ?>
                                        <option value="<?= $value ?>" <?= ($data['year_level'] ?? '') === $value ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="select-arrow">▾</span>
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="col-full">
                            <label class="terms-row">
                                <input
                                    type="checkbox"
                                    name="terms"
                                    <?= !empty($data['terms']) ? 'checked' : '' ?>
                                >
                                <span class="terms-row__text">
                                    I agree to the
                                    <a href="#">UM Skills Clinic Terms &amp; Conditions</a>
                                    and confirm my information is accurate.
                                </span>
                            </label>
                        </div>

                    </div>

                    <button type="submit" class="btn-primary">Create Account</button>

                </form>

            <?php endif; ?>

            <!-- Footer Link -->
            <div class="card__footer">
                Already have an account? <a href="login.php">Sign In</a>
            </div>

        </div>
    </div>

    <script src="assets/js/auth.js"></script>

</body>
</html>