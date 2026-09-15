<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us & Support - ReadyRide</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(22, 30, 49, 0.7);
            --card-border: rgba(59, 130, 246, 0.15);
            --primary: #3b82f6;
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --accent: #10b981;
            --danger: #ef4444;
            --input-bg: rgba(17, 24, 39, 0.6);
            --input-border: rgba(255, 255, 255, 0.08);
            --input-focus: rgba(59, 130, 246, 0.5);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.6;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInDown 0.8s ease-out;
        }

        header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        header p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        header .brand {
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 8px;
            -webkit-text-fill-color: var(--primary);
            background: none;
        }

        /* Two-column layout */
        .content-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
            animation: fadeInUp 0.8s ease-out;
        }

        /* Glassmorphism cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 35px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.6rem;
            color: #ffffff;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
        }

        h2 svg {
            margin-right: 12px;
            color: var(--primary);
        }

        p.card-desc {
            color: var(--text-muted);
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 12px;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background: var(--primary-gradient);
            color: #ffffff;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25);
            font-size: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(59, 130, 246, 0.4);
            opacity: 0.95;
        }

        /* Sidebar Info Cards */
        .info-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: rgba(22, 30, 49, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            border-color: rgba(59, 130, 246, 0.25);
            background: rgba(22, 30, 49, 0.6);
            transform: translateY(-2px);
        }

        .info-icon {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-details h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .info-details p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .info-details a {
            color: var(--primary);
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .info-details a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        /* Account Deletion Notice section */
        .deletion-notice {
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 16px;
            padding: 20px;
            margin-top: 10px;
        }

        .deletion-notice h4 {
            color: #f87171;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .deletion-notice p {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* Success & Loading Interactivity */
        .form-container {
            position: relative;
        }

        .success-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--card-bg);
            border-radius: 24px;
            z-index: 10;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            animation: fadeIn 0.4s ease-out forwards;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            font-size: 2.5rem;
            border: 2px solid rgba(16, 185, 129, 0.3);
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .success-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .success-text {
            color: var(--text-muted);
            font-size: 1rem;
            max-width: 400px;
            margin-bottom: 30px;
        }

        /* Loading spinner */
        .spinner {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; backdrop-filter: blur(0px); }
            to { opacity: 1; backdrop-filter: blur(12px); }
        }

        @keyframes scaleIn {
            from { transform: scale(0.6); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Privacy Policy Link footer */
        .policy-link-footer {
            margin-top: 30px;
            text-align: center;
        }

        .policy-link-footer a {
            color: var(--text-muted);
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .policy-link-footer a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Responsiveness */
        @media (max-width: 900px) {
            body {
                padding: 20px 10px;
            }

            header h1 {
                font-size: 2.2rem;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <p class="brand">ReadyRide</p>
            <h1>Contact Us</h1>
            <p>Get in touch or submit an Account Deletion Request</p>
        </header>

        <div class="content-grid">
            <!-- Left Side: Interactive Contact Form -->
            <div class="card form-container" id="contactCard">
                <div class="success-overlay" id="successOverlay">
                    <div class="success-icon">✓</div>
                    <h3 class="success-title" id="successTitle">Message Sent!</h3>
                    <p class="success-text" id="successText">Thank you for reaching out. Our support team has received your request and will respond within 24 hours.</p>
                    <button class="btn" style="max-width: 200px;" onclick="resetForm()">Send Another</button>
                </div>

                <h2>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Send a Message
                </h2>
                <p class="card-desc">Fill out the form below, and we will get back to you as soon as possible.</p>

                <form id="contactForm" onsubmit="handleFormSubmit(event)">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" class="form-control" placeholder="John Doe" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" placeholder="john@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="purpose">Purpose of Inquiry</label>
                        <select id="purpose" class="form-control" onchange="togglePurposeDetails(this)" required>
                            <option value="support">General Support</option>
                            <option value="deletion">Account & Data Deletion Request</option>
                            <option value="bug">Report a Bug</option>
                            <option value="business">Business Partnership</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" class="form-control" placeholder="How can we help you?" required></textarea>
                    </div>

                    <button type="submit" class="btn" id="submitBtn">
                        <span class="spinner" id="btnSpinner"></span>
                        <span id="btnText">Submit Request</span>
                    </button>
                </form>
            </div>

            <!-- Right Side: Contact Details & Account Deletion Notice -->
            <div class="info-panel">
                <div class="card">
                    <h2>Support Details</h2>
                    <p class="card-desc">Feel free to reach out to us directly through any of the channels below.</p>

                    <div class="info-panel">
                        <div class="info-card">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="info-details">
                                <h3>Email Support</h3>
                                <p><a href="mailto:support@fleetmanagement.com">support@fleetmanagement.com</a></p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="info-details">
                                <h3>Phone Support</h3>
                                <p><a href="tel:+18005550199">+1 (800) 555-0199</a></p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="info-details">
                                <h3>HQ Address</h3>
                                <p>100 Fleet Parkway, Suite 500<br>San Francisco, CA 94107</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Deletion Info Box -->
                <div class="deletion-notice" id="deletionNotice">
                    <h4>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        Account Deletion Requests
                    </h4>
                    <p>When selecting "Account & Data Deletion Request", please ensure the email matches your registered account email. All user profiles, vehicle logs, and location metrics will be permanently purged from our servers within 30 days of compliance verification.</p>
                </div>
            </div>
        </div>

        <div class="policy-link-footer">
            <a href="{{ route('privacy-policy') }}">View our full Privacy Policy</a>
        </div>
    </div>

    <script>
        function togglePurposeDetails(selectElement) {
            const notice = document.getElementById('deletionNotice');
            if (selectElement.value === 'deletion') {
                notice.style.background = 'rgba(239, 68, 68, 0.08)';
                notice.style.borderColor = 'rgba(239, 68, 68, 0.4)';
                notice.style.transform = 'scale(1.02)';
                notice.style.transition = 'all 0.3s ease';
            } else {
                notice.style.background = 'rgba(239, 68, 68, 0.05)';
                notice.style.borderColor = 'rgba(239, 68, 68, 0.2)';
                notice.style.transform = 'scale(1)';
            }
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const purpose = document.getElementById('purpose').value;
            const message = document.getElementById('message').value;

            // UI feedback: loading state
            const spinner = document.getElementById('btnSpinner');
            const btnText = document.getElementById('btnText');
            const submitBtn = document.getElementById('submitBtn');

            spinner.style.display = 'inline-block';
            btnText.textContent = 'Processing...';
            submitBtn.disabled = true;

            // Simulate server request delay
            setTimeout(() => {
                const overlay = document.getElementById('successOverlay');
                const title = document.getElementById('successTitle');
                const text = document.getElementById('successText');

                if (purpose === 'deletion') {
                    title.textContent = 'Deletion Request Received';
                    text.innerHTML = `Dear <strong>${name}</strong>, your request for account deletion associated with <strong>${email}</strong> has been logged. Our compliance team will permanently delete your records within 30 days. A verification email has been sent to confirm your identity.`;
                } else {
                    title.textContent = 'Message Sent!';
                    text.innerHTML = `Thank you <strong>${name}</strong>. Your general inquiry has been received. Our support team will reach out to <strong>${email}</strong> within 24 hours.`;
                }

                overlay.style.display = 'flex';
                
                // Reset button states
                spinner.style.display = 'none';
                btnText.textContent = 'Submit Request';
                submitBtn.disabled = false;
            }, 1200);
        }

        function resetForm() {
            document.getElementById('contactForm').reset();
            document.getElementById('successOverlay').style.display = 'none';
        }
    </script>
</body>
</html>
