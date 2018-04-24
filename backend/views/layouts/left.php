<aside class="main-sidebar">

    <section class="sidebar" data-widget="tree">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" id="txt_left_menu_filter" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Dev Tools',
                        'icon' => 'file-code-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                            ['label' => 'RBAC', 'icon' => 'unlock-alt',
                                'url' => ["/admin/role/"],
                                'visible' => Yii::$app->user->can('Manage RBAC'),
//                                'template' => '<a href="{url}" ><i class="lock"></i><span>{label}</span><i class="angle-left pull-right"></i></a>',
                                'items' => [
                                    ['label' => 'Manage Assignments', 'url' => ["/admin"]],
                                    ['label' => 'Manage Roles', 'url' => ["/admin/role"]],
                                    ['label' => 'Manage Permissions', 'url' => ["/admin/permission"]],
                                    ['label' => 'Manage Routes', 'url' => ["/admin/route"]],
                                ],
                            ],
                    ]
                    ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Website',
                        'icon' => 'tv',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Static Page', 'icon' => 'circle-o', 'url' => ['/static-page'],],
                            ['label' => 'Static Block', 'icon' => 'circle-o', 'url' => ['/static-block'],],
                            ['label' => 'Banner List', 'icon' => 'circle-o', 'url' => ['/banner'],],
                           /// ['label' => 'News', 'icon' => 'circle-o', 'url' => ['/news']],
                            ['label' => 'FAQ', 'icon' => 'question-circle-o', 'url' => ['/faq']],
                            ['label' => 'Menu', 'icon' => 'question-circle-o', 'url' => ['/menu']],
                            ['label' => 'Contact Agent', 'icon' => 'question-circle-o', 'url' => ['/contact-agent']],
                        ],
                    ],
                    [
                        'label' => 'Config',
                        'icon' => 'cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Manage Configuration', 'icon' => 'wrench', 'url' => ['/site-config/manage'],],
                            ['label' => 'Static Block Type', 'icon' => 'circle-o', 'url' => ['/static-block-location-master'],],
                            ['label' => 'Service Category', 'icon' => 'circle-o', 'url' => ['/service-category'],],
                            ['label' => 'Metric Type', 'icon' => 'circle-o', 'url' => ['/metric-type'],],
                            ['label' => 'Advertise Location Master', 'icon' => 'circle-o', 'url' => ['/advertisement-location-master'],],
                            ['label' => 'Permission Master', 'icon' => 'circle-o', 'url' => ['/permission-master'],],
                            ['label' => 'Construction Status', 'icon' => 'circle-o', 'url' => ['/construction-status-master'],],
                            ['label' => 'Local Info Type', 'icon' => 'circle-o', 'url' => ['/location-local-info-type-master'],],
                            ['label' => 'Fact master', 'icon' => 'circle-o', 'url' => ['/fact-master'],],
                            ['label' => 'Payment Type master', 'icon' => 'circle-o', 'url' => ['/payment-type-master'],],
                            ['label' => 'Banner Types', 'icon' => 'circle-o', 'url' => ['/banner-type'],],
                            ['label' => 'Rental Plan Types', 'icon' => 'circle-o', 'url' => ['/rental-plan-type'],],
                            ['label' => 'Currency Master', 'icon' => 'circle-o', 'url' => ['/currency-master'],],
                            ['label' => 'Electricity Type', 'icon' => 'circle-o', 'url' => ['/electricity-type'],],
                        ],
                    ],
                    [
                        'label' => 'News & Advice',
                        'icon' => 'newspaper-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'News Category', 'icon' => 'circle-o', 'url' => ['/news-category'],],
                            ['label' => 'news', 'icon' => 'circle-o', 'url' => ['/news'],],
                            ['label' => 'Advice Category', 'icon' => 'circle-o', 'url' => ['/advice-category'],],
                            ['label' => 'Advice', 'icon' => 'circle-o', 'url' => ['/advice'],],
                        ],
                    ],
                    [
                        'label' => 'Team Management',
                        'icon' => 'newspaper-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Teams', 'icon' => 'circle-o', 'url' => ['/team'],],
                            ['label' => 'Add Team', 'icon' => 'plus', 'url' => ['/team/create'],],
                        ],
                    ],
                    [
                        'label' => 'User Management',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Buyers', 'icon' => 'circle-o', 'url' => ['/buyer'],],
                            ['label' => 'Sellers', 'icon' => 'circle-o', 'url' => ['/seller'],],
                            ['label' => 'Agents', 'icon' => 'circle-o', 'url' => ['/agent'],],
                            ['label' => 'Hotel Owners', 'icon' => 'circle-o', 'url' => ['/hotel-owner'],],
//                            ['label' => 'Admins', 'icon' => 'circle-o', 'url' => ['/admins'],],
                            ['label' => 'User Import', 'icon' => 'circle-o', 'url' => ['/user-import/create'],],
                            ['label' => 'Agent Export', 'icon' => 'circle-o', 'url' => ['/agent-export'],],
                            ['label' => 'Buyer Export', 'icon' => 'circle-o', 'url' => ['/buyer-export'],],
                            ['label' => 'Seller Export', 'icon' => 'circle-o', 'url' => ['/seller-export'],],
                            
                        ],
                    ],
//                    ['label' => 'Calender Event', 'icon' => 'circle-o', 'url' => ['/property-showing-request/calender-event'],],
                    [
                        'label' => 'Property Management',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Condominium List', 'icon' => 'circle-o', 'url' => ['/condominium'],],
                            ['label' => 'Property List', 'icon' => 'circle-o', 'url' => ['/property'],],
                            ['label' => 'Brokerage List', 'icon' => 'circle-o', 'url' => ['/property/brokerage-list'],],
                            ['label' => 'General Feature', 'icon' => 'circle-o', 'url' => ['/general-feature-master'],],
                            ['label' => 'Property Features', 'icon' => 'circle-o', 'url' => ['/property-feature-master'],],
                            ['label' => 'Property Categories', 'icon' => 'circle-o', 'url' => ['/property-category'],],
                            ['label' => 'Property Type', 'icon' => 'circle-o', 'url' => ['/property-type'],],
                            //['label' => 'Rent Features', 'icon' => 'circle-o', 'url' => ['/rental-feature-master'],],
//                            ['label' => 'Properties for Rent', 'icon' => 'circle-o', 'url' => ['/rental'],],
                            ['label' => 'Property Import', 'icon' => 'circle-o', 'url' => ['/property-import/create'],],
                            ['label' => 'Property Enquiry', 'icon' => 'circle-o', 'url' => ['/property-enquiery'],],
                            ['label' => 'Property Showing Request', 'icon' => 'circle-o', 'url' => ['/property-showing-request'],],
                            ['label' => 'Property Request', 'icon' => 'circle-o', 'url' => ['/property-request'],],
                            ['label' => 'Export', 'icon' => 'circle-o', 'url' => ['/property-export'],],
                        ],
                    ],
                    
                    [
                        'label' => 'Advertise Management',
                        'icon' => 'puzzle-piece',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Advertise List', 'icon' => 'circle-o', 'url' => ['/advertisement'],],
//                            ['label' => 'Advertise Banner', 'icon' => 'circle-o', 'url' => ['/advertisement-banner'],],
                            ['label' => 'Advertise Location', 'icon' => 'circle-o', 'url' => ['/advertisement-location'],],                            
                        ],
                    ],
                    [
                        'label' => 'Agency Management',
                        'icon' => 'bars',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Agency List', 'icon' => 'circle-o', 'url' => ['/agency'],],
//                            ['label' => 'Agent List', 'icon' => 'circle-o', 'url' => ['/agent-list'],],
                            ['label' => 'Agency Import', 'icon' => 'circle-o', 'url' => ['/agency-import/create'],],
                        ],
                    ],
                    [
                        'label' => 'Hotel Management',
                        'icon' => 'outdent',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Room Type List', 'icon' => 'circle-o', 'url' => ['/room-type'],],
                            ['label' => 'Hotel List', 'icon' => 'circle-o', 'url' => ['/hotel'],],
                            ['label' => 'Hotel Booking', 'icon' => 'circle-o', 'url' => ['/hotel-booking'],],
//                            ['label' => 'Hotel Booking Guest', 'icon' => 'circle-o', 'url' => ['/hotel-booking-guest'],],
                            ['label' => 'Hotel Enquiry', 'icon' => 'circle-o', 'url' => ['/hotel-enquiry'],],
                            ['label' => 'Hotel Import', 'icon' => 'circle-o', 'url' => ['/hotel-import/create'],],
                        ],
                    ],
                    [
                        'label' => 'Holiday Management',
                        'icon' => 'bars ',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Package Category', 'icon' => 'circle-o', 'url' => ['/holiday-package-category'],],
                            ['label' => 'Package Type', 'icon' => 'circle-o', 'url' => ['/holiday-package-type'],],
                            ['label' => 'Package List', 'icon' => 'circle-o', 'url' => ['/holiday-package'],],
                            ['label' => 'Package Booking', 'icon' => 'circle-o', 'url' => ['/holiday-package-booking'],],
                            ['label' => 'Package Enquiry', 'icon' => 'circle-o', 'url' => ['/holiday-package-enquiry'],],
                            ['label' => 'Package Import', 'icon' => 'circle-o', 'url' => ['/holiday-package-import/create'],],
                        ],
                    ],
                    [
                        'label' => 'Newsletter',
                        'icon' => 'bars ',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Newsletter Templates', 'icon' => 'circle-o', 'url' => ['/newsletter-template'],],
                            ['label' => 'All Subscribers', 'icon' => 'bars', 'url' => ['/newsletter-email-subscriber'],],
                            ['label' => 'Subscriber Groups', 'icon' => 'bars', 'url' => ['/newsletter-email-list'],],
                            ['label' => 'Send / Schedule Emails', 'icon' => 'bars', 'url' => '#',
                            'items' => [
                                ['label' => 'Email Users', 'icon' => 'circle-o', 'url' => ['/newsletter/user-templates'],],
                                ['label' => 'Email Subscribers', 'icon' => 'circle-o', 'url' => ['/newsletter/subscriber-templates'],],
                                ['label' => 'Email Groups', 'icon' => 'circle-o', 'url' => ['/newsletter/group-templates'],],
                            ]
                            ],
//                            ['label' => 'Email Users', 'icon' => 'circle-o', 'url' => ['/newsletter/user-templates'],],
//                            ['label' => 'Email Subscribers', 'icon' => 'circle-o', 'url' => ['/newsletter/subscriber-templates'],],
                            
                            ['label' => 'Scheduled Emails', 'icon' => 'bars', 'url' => '#',
                            'items' => [
                                ['label' => 'Users', 'icon' => 'circle-o', 'url' => ['/newsletter/user-scheduled-mails'],],
                                ['label' => 'Subscribers', 'icon' => 'circle-o', 'url' => ['/newsletter/subscriber-scheduled-mails'],],
                                ['label' => 'Groups', 'icon' => 'circle-o', 'url' => ['/newsletter/list-scheduled-mails'],],
                            ]
                            ],
                            ['label' => 'All Sent Mails', 'icon' => 'bars', 'url' => ['/newsletter/sent-mails'],],
                        ],
                    ],
                    [
                        'label' => 'Subscription Management',
                        'icon' => 'bars ',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Agent Plan Master', 'icon' => 'circle-o', 'url' => ['/plan-master'],],
                            ['label' => 'Office Plan Master', 'icon' => 'circle-o', 'url' => ['/plan-master/agency'],],
                        ],
                    ],
                    [
                        'label' => 'Media',
                        'icon' => 'bars ',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Image List', 'icon' => 'circle-o', 'url' => ['/photo-gallery'],],
                            ['label' => 'Attachment', 'icon' => 'circle-o', 'url' => ['/attachment'],],
                            ['label' => 'Video List', 'icon' => 'circle-o', 'url' => ['/video-gallery'],],
                        ],
                    ],
                    [
                        'label' => 'Career',
                        'icon' => 'bars ',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Job Application', 'icon' => 'circle-o', 'url' => ['/job-application'],],
                        ]
                    ],
                    [
                        'label' => 'Email Templates',
                        'icon' => 'bars ',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Manage Templates', 'url' => ["/email-template/index"]],
                            ['label' => 'Create Template', 'url' => ["/email-template/create"]],
                        ]
                    ],
                    
                    ['label' => 'Testimonial', 'icon' => 'circle-o', 'url' => ['/testimonial'],],
                    ['label' => 'User\'s Contacts', 'icon' => 'users', 'url' => ['/contacts']],
                    ['label' => 'Contact Us', 'icon' => 'envelope', 'url' => ['/contact-form-db']],
                    [
                        'label' => 'Blog Management',
                        'icon' => 'rss',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Category', 'icon' => 'circle-o', 'url' => ['/blog-post-category'],],
                            ['label' => 'Posts', 'icon' => 'rss', 'url' => ['/blog-post'],],
                            ['label' => 'Comments', 'icon' => 'comments', 'url' => ['/blog-comment'],],
                            
                        ],
                    ],
                    [
                        'label' => 'Discussion Management',
                        'icon' => 'rss',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Tag', 'icon' => 'circle-o', 'url' => ['/discussion-tag'],],
                            ['label' => 'Category', 'icon' => 'circle-o', 'url' => ['/discussion-category'],],
                            ['label' => 'Posts', 'icon' => 'rss', 'url' => ['/discussion-post'],],
                            ['label' => 'Comments', 'icon' => 'comments', 'url' => ['/discussion-comment'],],
                            
                        ],
                    ],
                    [
                        'label' => 'Buyer Criteria Worksheet',
                        'icon' => 'bars',
                        'url' => ['/buyer-export/criteria-worksheet'],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
