<?php
/**
 * Central site data: used by header/footer/SEO includes.
 * Edit values here to update contact info, nav, or social links site-wide.
 */

return [
    'site_name'   => 'العربة الماهرة',
    'domain'      => 'https://skilledcart.com',
    'lang'        => 'ar',
    'dir'         => 'rtl',
    'locale'      => 'ar_AR',

    'contact' => [
        'address'   => 'العربة الماهرة السلي، الرياض 14276',
        'phone'     => '+966546196801',
        'email'     => 'info@skilledcart.com',
        'map_query' => 'MV38+84C، السلي، الرياض 14276',
    ],

    'social' => [
        'whatsapp'  => 'https://wa.me/966546196801',
        'tiktok'    => 'https://www.tiktok.com/@skilledcartofficial',
        'instagram' => 'https://www.instagram.com/skilledcart.co/',
        'linkedin'  => 'https://www.linkedin.com/in/maher-aljasem-b56386409/',
    ],

    // Primary navigation.
    'nav' => [
        ['label' => 'الرئيسية',    'url' => '/',           'slug' => 'home'],
        ['label' => 'من نحن',     'url' => '/about/',      'slug' => 'about'],
        ['label' => 'خدماتنا',    'url' => '/services/',   'slug' => 'services'],
        ['label' => 'تواصل معنا', 'url' => '/contact-us/', 'slug' => 'contact'],
    ],

    // Footer "About" blurb (footer widget column 1)
    'footer_about' => 'متخصصون في بيع، تأجير، وتشغيل عربات الجولف (Golf Carts) بجودة عالية تناسب مختلف الاحتياجات. نقدم عربات جولف كهربائية وبنزين للأندية الرياضية، والمنتجعات، والميادين التجارية. خدماتنا تشمل توفير عربات جولف جديدة ومستعملة، تأجير يومي وشهري بأسعار تنافسية، بالإضافة إلى خدمات الصيانة الدورية لضمان الأداء الأمثل. تواصل معنا الآن لاختيار الخدمة التي تناسبك',

    // Per-page SEO + schema metadata (title/description reproduce what the SureRank plugin generated originally)
    'pages' => [
        'home' => [
            'path'        => '/',
            'title'       => 'Home - العربة الماهرة',
            'name'        => 'Home',
            'description' => 'العربة الماهرة حلول متكاملة لعربات الجولف نقدم خدمات متكاملة في بيع وتأجير وتشغيل وصيانة عربات الجولف، مع خيارات متنوعة من العربات الكهربائية والبنزين لتلبية',
            'date_published' => '2026-08-11T04:46:05+03:00',
            'date_modified'  => '2026-08-12T13:02:09+03:00',
            'breadcrumb' => false,
            'body_class' => 'home wp-singular page-template-default page page-id-308 wp-custom-logo wp-embed-responsive wp-theme-astra ehf-template-astra ehf-stylesheet-astra ast-desktop ast-page-builder-template ast-no-sidebar ast-single-post ast-replace-site-logo-transparent ast-inherit-site-logo-transparent ast-theme-transparent-header ast-hfb-header elementor-default elementor-kit-307 elementor-page elementor-page-308',
        ],
        'about' => [
            'path'        => '/about/',
            'title'       => 'About - العربة الماهرة',
            'name'        => 'About',
            'description' => 'تعرف على العربة الماهرة، شريكك المتخصص في بيع وتأجير وتشغيل وصيانة عربات الجولف الكهربائية والبنزين في الرياض، بخبرة وجودة تلبي احتياجاتك',
            'date_published' => '2026-08-11T04:46:06+03:00',
            'date_modified'  => '2026-08-12T13:04:32+03:00',
            'breadcrumb' => true,
            'body_class' => 'wp-singular page-template-default page page-id-311 wp-custom-logo wp-embed-responsive wp-theme-astra ehf-template-astra ehf-stylesheet-astra ast-desktop ast-page-builder-template ast-no-sidebar ast-single-post ast-replace-site-logo-transparent ast-inherit-site-logo-transparent ast-theme-transparent-header ast-hfb-header elementor-default elementor-kit-307 elementor-page elementor-page-311',
        ],
        'services' => [
            'path'        => '/services/',
            'title'       => 'Services - العربة الماهرة',
            'name'        => 'Services',
            'description' => 'خدمات العربة الماهرة: بيع وتأجير وتشغيل وصيانة عربات الجولف الكهربائية والبنزين، حلول متكاملة تناسب مختلف المواقع التجارية والترفيهية',
            'date_published' => '2026-08-11T04:46:05+03:00',
            'date_modified'  => '2026-08-12T12:26:58+03:00',
            'breadcrumb' => true,
            'body_class' => 'wp-singular page-template-default page page-id-310 wp-custom-logo wp-embed-responsive wp-theme-astra ehf-template-astra ehf-stylesheet-astra ast-desktop ast-page-builder-template ast-no-sidebar ast-single-post ast-replace-site-logo-transparent ast-inherit-site-logo-transparent ast-theme-transparent-header ast-hfb-header elementor-default elementor-kit-307 elementor-page elementor-page-310',
        ],
        'projects' => [
            'path'        => '/projects/',
            'title'       => 'Projects - العربة الماهرة',
            'name'        => 'Projects',
            'description' => 'استعرض مشاريعنا في تجهيز وتشغيل عربات الجولف لمختلف المواقع التجارية والترفيهية والأندية الرياضية والمنتجعات',
            'date_published' => '2026-08-11T04:46:05+03:00',
            'date_modified'  => '2026-08-11T04:46:05+03:00',
            'breadcrumb' => true,
            'body_class' => 'wp-singular page-template-default page page-id-309 wp-custom-logo wp-embed-responsive wp-theme-astra ehf-template-astra ehf-stylesheet-astra ast-desktop ast-page-builder-template ast-no-sidebar ast-single-post ast-replace-site-logo-transparent ast-inherit-site-logo-transparent ast-theme-transparent-header ast-hfb-header elementor-default elementor-kit-307 elementor-page elementor-page-309',
        ],
        'contact' => [
            'path'        => '/contact-us/',
            'title'       => 'Contact Us - العربة الماهرة',
            'name'        => 'Contact Us',
            'description' => 'تواصل مع العربة الماهرة للحجز والاستفسار عن خدمات بيع وتأجير وصيانة عربات الجولف. العنوان، رقم الهاتف، والبريد الإلكتروني',
            'date_published' => '2026-08-11T04:46:06+03:00',
            'date_modified'  => '2026-08-12T12:19:39+03:00',
            'breadcrumb' => true,
            'body_class' => 'wp-singular page-template-default page page-id-15 wp-custom-logo wp-embed-responsive wp-theme-astra ehf-template-astra ehf-stylesheet-astra ast-desktop ast-page-builder-template ast-no-sidebar ast-single-post ast-replace-site-logo-transparent ast-inherit-site-logo-transparent ast-theme-transparent-header ast-hfb-header elementor-default elementor-kit-307 elementor-page elementor-page-15',
        ],
    ],
];
