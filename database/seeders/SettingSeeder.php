<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name',           'value' => 'Cyber Dreams'],
            ['key' => 'site_title',          'value' => 'Cyber Dreams | Build Your Dream Website'],
            ['key' => 'site_logo',           'value' => 'logo.png'],
            ['key' => 'site_favicon',        'value' => 'favicon.ico'],
            ['key' => 'header_contact_text', 'value' => 'Try Amazing Cyber Dreams <a href="#contact" class="text-pink-500 hover:underline font-medium">Services</a>'],
            ['key' => 'footer_text',         'value' => '© ' . date('Y') . ' Cyber Dreams Network. All rights reserved.'],
            ['key' => 'terms_content',       'value' => "Terms & Conditions\n\nEffective Date: January 1, 2024\n\n1. Acceptance of Terms\nBy accessing or using Cyber Dreams Network's services, you agree to be bound by these Terms & Conditions.\n\n2. Services\nCyber Dreams Network provides web hosting, website design and development, software development, mobile application development, SHOUTcast hosting, and e-commerce solutions.\n\n3. Intellectual Property\nAll content, designs, and software developed by Cyber Dreams Network remain the intellectual property of Cyber Dreams unless otherwise agreed in writing.\n\n4. Payment Terms\nPayment terms are specified in individual service agreements. Late payments may incur additional charges.\n\n5. Limitation of Liability\nCyber Dreams shall not be liable for any indirect, incidental, or consequential damages arising from the use of our services.\n\n6. Governing Law\nThese terms are governed by applicable law.\n\n7. Contact\nFor any questions regarding these Terms, contact us at info@cyberdreams.net"],
            ['key' => 'privacy_content',     'value' => "Privacy Policy\n\nEffective Date: January 1, 2024\n\n1. Information We Collect\nWe collect information you provide directly to us, such as name, email address, and project details when you contact us or use our services.\n\n2. How We Use Your Information\nWe use the information we collect to provide, maintain, and improve our services, communicate with you, and comply with legal obligations.\n\n3. Information Sharing\nWe do not sell, trade, or rent your personal information to third parties. We may share information with trusted partners who assist us in operating our services.\n\n4. Data Security\nWe implement appropriate security measures to protect your personal information against unauthorized access, alteration, or disclosure.\n\n5. Cookies\nOur website may use cookies to enhance user experience. You can choose to disable cookies through your browser settings.\n\n6. Third-Party Links\nOur website may contain links to third-party sites. We are not responsible for the privacy practices of those sites.\n\n7. Your Rights\nYou have the right to access, correct, or delete your personal information. Contact us at info@cyberdreams.net to exercise these rights.\n\n8. Contact\nFor privacy-related questions, contact us at info@cyberdreams.net"],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
