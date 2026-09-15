<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - ReadyRide</title>
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
            --accent-glow: rgba(16, 185, 129, 0.15);
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
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header styling */
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
            font-weight: 400;
        }

        /* Glassmorphism main card */
        .policy-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 40px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.8s ease-out;
        }

        .last-updated {
            display: inline-flex;
            align-items: center;
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 30px;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Sections styling */
        section {
            margin-bottom: 35px;
        }

        section:last-of-type {
            margin-bottom: 0;
        }

        h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.6rem;
            color: #ffffff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        h2::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 24px;
            background: var(--primary-gradient);
            border-radius: 3px;
            margin-right: 12px;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 16px;
            font-size: 1rem;
        }

        ul {
            list-style: none;
            margin-bottom: 20px;
            padding-left: 6px;
        }

        ul li {
            position: relative;
            padding-left: 24px;
            margin-bottom: 10px;
            color: var(--text-muted);
        }

        ul li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
        }

        /* Highlight card for Deletion info */
        .deletion-highlight {
            background: rgba(16, 185, 129, 0.04);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 16px;
            padding: 24px;
            margin-top: 20px;
            box-shadow: 0 10px 20px var(--accent-glow);
        }

        .deletion-highlight h3 {
            font-family: 'Outfit', sans-serif;
            color: var(--accent);
            font-size: 1.25rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .deletion-highlight h3 svg {
            margin-right: 8px;
            fill: var(--accent);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            color: #ffffff;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 15px;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(59, 130, 246, 0.4);
            opacity: 0.95;
        }

        .btn svg {
            margin-left: 8px;
        }

        /* Footer inside main card */
        footer {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            text-align: center;
            font-size: 0.9rem;
            color: rgba(156, 163, 175, 0.6);
        }

        /* Keyframe animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }

            header h1 {
                font-size: 2.2rem;
            }

            .policy-card {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Privacy Policy</h1>
            <p>ReadyRide Application</p>
        </header>

        <div class="policy-card">
            <div class="last-updated">Last Updated: July 19, 2026</div>

            <section>
                <h2>Introduction</h2>
                <p>Welcome to ReadyRide. We are committed to protecting your privacy and security. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our mobile application and backend services.</p>
                <p>By downloading or using the ReadyRide application, you agree to the collection and use of information in accordance with this policy.</p>
            </section>

            <section>
                <h2>Information We Collect</h2>
                <p>To provide a robust fleet tracking and management service, we may collect the following types of information:</p>
                <ul>
                    <li><strong>Personal Data:</strong> Name, email address, phone number, and login credentials when you register an account.</li>
                    <li><strong>Location Data:</strong> To track vehicles and coordinate routes, we collect precise real-time location data (GPS coordinates) of drivers. This information is collected when the app is active in the foreground and/or background to ensure accurate route tracking and status updates.</li>
                    <li><strong>Vehicle Information:</strong> Registration details, maintenance records, and assignments associated with your fleet account.</li>
                    <li><strong>Device Metadata:</strong> Device type, operating system version, unique device identifiers, and crash logs to optimize performance.</li>
                </ul>
            </section>

            <section>
                <h2>How We Use Your Information</h2>
                <p>We use the collected information for various operation and security purposes, including to:</p>
                <ul>
                    <li>Enable real-time tracking, scheduling, and routing for fleet drivers.</li>
                    <li>Authenticate users and protect accounts from unauthorized access.</li>
                    <li>Send push notifications and updates regarding fleet status, bookings, and alerts.</li>
                    <li>Process payments and manage transaction histories.</li>
                    <li>Monitor app usage, identify errors, and improve application functionality.</li>
                </ul>
            </section>

            <section>
                <h2>Data Security & Third-Party Services</h2>
                <p>We implement advanced technical and organizational security measures, including HTTPS/SSL encryption, to protect your personal and location data from loss or unauthorized access.</p>
                <p>We may share metadata with third-party service providers (such as Google Play Services and Firebase) solely to support app authentication, notifications, and analytics.</p>
            </section>

            <section>
                <h2>Account Deletion & Data Retention</h2>
                <p>We retain your personal data and location histories only for as long as necessary to fulfill the business operations outlined in this policy or as required by law.</p>
                
                <div class="deletion-highlight">
                    <h3>
                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                        </svg>
                        Request Account & Data Deletion
                    </h3>
                    <p>You have the absolute right to request the permanent deletion of your account and all associated personal data at any time. When you request account deletion, we immediately restrict access and permanently erase your user profile, location history, and vehicle links within 30 days of confirmation.</p>
                    <p>To request deletion, you can initiate the process directly within the mobile application settings, or submit a request on our contact page:</p>
                    <a href="{{ route('contact') }}" class="btn">
                        Go to Account Deletion Request
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </section>

            <section>
                <h2>Changes to This Policy</h2>
                <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date at the top.</p>
            </section>

            <footer>
                &copy; 2026 ReadyRide. All rights reserved.
            </footer>
        </div>
    </div>
</body>
</html>
