<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AdminLteAsset;
use app\assets\FontAwesomeAsset;
use app\assets\AdminLteUserAsset;
use app\widgets\Alert;
use app\widgets\Nav;
use app\widgets\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use cebe\gravatar\Gravatar;
use yii\bootstrap4\Modal;
use app\models\Language;

AdminLteAsset::register($this);
FontAwesomeAsset::register($this);
AdminLteUserAsset::register($this);

//List of language options
$languages = Language::find()
    ->orderBy(['name_ascii' => SORT_ASC])
    ->all();
$langOpt = [];

if (!empty($languages)) {
    foreach ($languages as $lang) {
        //Check if the language is the active
        $active = ($lang->code == Yii::$app->language) ? 'active' : '';
        $langOpt[] = [
            'label' => $lang->name_ascii,
            'url' => Yii::$app->urlManager->createUrl(['site/change-language', 'lang'=>$lang->code]),
            'linkOptions' => [
                'class' => 'dropdown-item ' . $active,
            ]
        ];
    }
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" style="font-size: 14px">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name . ($this->title ? " - $this->title" : '')) ?></title>
    <?php $this->head() ?>
</head>
<body class="sidebar-mini">
    <?php $this->beginBody() ?>
    <?php Modal::begin([
        'id' => 'main-modal',
        'size' => Modal::SIZE_LARGE,
        'clientEvents' => [
            'show.bs.modal' => 'function (e) {
                    $("#main-modal").addClass("show");
            }',
            'hide.bs.modal' => 'function (e) {
                    $("#main-modal").removeClass("show");
            }',
        ],
        'options' => ['class' => 'card-primary', 'tabindex' => false],
        'title' => Html::tag('h4', '', ['id' => 'main-modal-header', 'class' => 'modal-title']),
        'titleOptions' => ['class' => 'card-header'],
        'bodyOptions' => ['id' => 'main-modal-body'],
    ]);
    Modal::end(); ?>

    <?php Modal::begin([
        'id' => 'main-modal-xl',
        'size' => Modal::SIZE_EXTRA_LARGE,
        'options' => ['class' => 'card-primary', 'tabindex' => false],
    ]);
    Modal::end(); ?>
    <div class="wrapper">
        <?php
        NavBar::begin([
            'renderInnerContainer' => false,
            'options' => [
                    'class' => 'main-header navbar navbar-expand bg-white navbar-light border-bottom',
            ],
        ]);

        $menuItemsLeft[] = ['label' => '<i class="fa fa-bars"></i>', 'url' => '#', 'options' => ['class' => 'nav-item', 'data-widget' => 'pushmenu'], 'linkOptions' => ['class' => 'nav-link'], 'encode' => false];

        $menuItemsRight[] = [
            'label' => Gravatar::widget([
                'email' => Yii::$app->user->identity->email,
                'secure' => true,
                'options' => [
                    'alt' => 'Profile Gravatar',
                    'class' => 'img-circle',
                ],
                'size' => 20,
            ]),
            'items' => [
                [
                    'label' => Yii::t('app', 'Account'),
                    'url' => ['site/account'],
                    'linkOptions' => [
                        'tabindex' => -1,
                        'class' => 'dropdown-item ' . ((Yii::$app->requestedRoute == 'site/account') ? 'active' : ''),
                    ]
                ],
                [
                    'label' => Yii::t('app', 'Loyalty program'),
                    'url' => ['/referrals'],
                    'linkOptions' => [
                        'tabindex' => -1,
                        'class' => 'dropdown-item ' . ((Yii::$app->requestedRoute == 'referrals/index') ? 'active' : ''),
                    ]
                ],
                [
                    'label' => Yii::t('app', 'Logout'),
                    'url' => ['site/logout'],
                    'linkOptions' => [
                        'data-method' => 'post',
                        'tabindex' => -1,
                        'class' => 'dropdown-item'
                    ]
                ],
            ],
            'encode' => FALSE,
            'options' => ['class' => 'nav-item'],
            'linkOptions' => ['class' => 'nav-link'],
        ];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItemsLeft,
            'activateParents' => true,
        ]); ?>

        <div class="dropdown dropdown-inner ml-auto">
            <a class="nav-link dropdown-toggle dropbtn dropbtn-inner" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= strtoupper(Yii::$app->language) ?>
            </a>

            <div id="myDropdown" class="dropdown-menu dropdown-menu-inner" aria-labelledby="dropdownMenuLink">
                <div class="search-container">
                <input type="text" id="search-lang" placeholder="Search..">
                <button type="button"><i class="fa fa-search"></i></button>
                </div>

                <div class="dropdown-container">
                <?php

                //List of language options
                $languages = Language::find()
                    ->orderBy(['name_ascii' => SORT_ASC])
                    ->all();

                if (!empty($languages)) {
                    foreach ($languages as $language) {
                        //Check if the language is the active
                        $active = ($language->code == Yii::$app->language) ? 'active' : null;
                        echo Html::a($language->name_ascii, Yii::$app->urlManager->createUrl(['site/change-language', 'lang' => $language->code]), ['class' => ['dropdown-item', $active]]);
                    }
                } ?>
                </div>
            </div>
        </div>

        <?php echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItemsRight,
        ]);
        NavBar::end();
        ?>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= Yii::$app->homeUrl ?>" class="brand-link">
                <span class="brand-abbr font-weight-light">OSW</span>
            </a>

<?php
$leftMenuItems = [
    [
        'title' => 'SERVICES',
        'icon' => 'fas fa-cloud',
    ],
    [
        'title' => 'Contacts',
        'icon' => 'far fa-circle',
        'url' => 'contact',
        'route' => '/contact',
    ],
    [
        'title' => 'Debts',
        'icon' => 'far fa-circle',
        'url' => 'debt',
        'route' => '/debt',
    ],
    [
        'title' => 'Support groups',
        'icon' => 'far fa-circle',
        'url' => 'support-groups',
        'route' => '/support-groups',
    ],
    [
        'title' => 'Wikipedia watchlists',
        'icon' => 'far fa-circle',
        'url' => 'wikipedia-pages',
        'route' => '/wikipedia-pages/index',
    ],
    //[
    //    'title' => 'Wikinews pages',
    //    'icon' => 'far fa-circle',
    //    'url' => 'wikinews-pages',
    //    'route' => '/wikinews-pages/index',
    //],
    [
        'title' => 'Currency Exchange',
        'icon' => 'far fa-circle',
        'url' => 'currency-exchange-order',
        'route' => '/currency-exchange-order',
    ],
    [
        'title' => 'Ads',
        'icon' => 'far fa-circle',
        'url' => 'ads',
        'route' => '/ads',
    ],
    [
        'title' => 'Jobs',
        'icon' => 'far fa-circle',
        'url' => 'jobs',
        'route' => '/jobs',
    ],
    [
        'title' => 'Dating',
        'icon' => 'far fa-circle',
        'url' => 'dating',
        'route' => '/dating',
    ],
    [
        'title' => 'Ua Lawmaking',
        'icon' => 'far fa-circle',
        'url' => 'ua-lawmaking',
        'route' => '/ua-lawmaking',
    ],
    [
        'title' => 'COMMUNITY',
        'icon' => 'fas fa-users',
    ],
    [
        'title' => 'Website settings',
        'icon' => 'far fa-circle',
        'url' => 'website-settings',
        'route' => '/setting/index',
    ],
    [
        'title' => 'Issues',
        'icon' => 'far fa-circle',
        'url' => 'issue',
        'route' => '/issue',
    ],
    [
        'title' => 'METRICS',
        'icon' => 'far fa-chart-bar',
    ],
    [
        'title' => 'Users',
        'icon' => 'far fa-circle',
        'url' => 'user/display',
        'route' => '/user/display',
    ],
    [
        'title' => 'SYSTEM REPORTS',
        'icon' => 'far fa-list-alt',
    ],
    [
        'title' => 'Cron Log',
        'icon' => 'far fa-circle',
        'url' => 'cron-job',
        'route' => '/cron-job/index',
    ],
    [
        'title' => 'PHP Info',
        'icon' => 'far fa-circle',
        'url' => 'examples/php-info',
        'route' => '/examples/php-info',
    ],
    [
        'title' => 'MySQL Info',
        'icon' => 'far fa-circle',
        'url' => 'examples/mysql-info',
        'route' => '/examples/mysql-info',
    ],
    [
        'title' => 'CONTRIBUTION',
        'icon' => 'fas fa-tools',
    ],
    [
        'title' => 'Getting started',
        'icon' => 'far fa-circle',
        'href' => 'https://github.com/opensourcewebsite-org/opensourcewebsite-org/blob/master/CONTRIBUTING.md',
    ],
    [
        'title' => Yii::t('app', 'Source code'),
        'icon' => 'far fa-circle',
        'href' => 'https://github.com/opensourcewebsite-org/opensourcewebsite-org',
    ],
    [
        'title' => 'Moqups',
        'icon' => 'far fa-circle',
        'url' => 'moqup/design-list',
        'route' => '/moqup/design-list',
    ],
    [
        'title' => 'Models',
        'icon' => 'far fa-circle',
        'urls' => [
            'data/country',
            'data/currency',
            'data/language',
            'data/payment-method',
            'data/gender',
            'data/sexuality',
        ],
        'items' => [
            [
                'title' => 'Countries',
                'icon' => 'far fa-circle',
                'url' => 'data/country',
                'route' => '/data/country',
            ],
            [
                'title' => 'Currencies',
                'icon' => 'far fa-circle',
                'url' => 'data/currency',
                'route' => '/data/currency',
            ],
            [
                'title' => 'Genders',
                'icon' => 'far fa-circle',
                'url' => 'data/gender',
                'route' => 'data/gender',
            ],
            [
                'title' => 'Languages',
                'icon' => 'far fa-circle',
                'url' => 'data/language',
                'route' => '/data/language',
            ],
            [
                'title' => 'Payment methods',
                'icon' => 'far fa-circle',
                'url' => 'data/payment-method',
                'route' => '/data/payment-method',
            ],
            [
                'title' => 'Genders',
                'icon' => 'far fa-circle',
                'url' => 'data/gender',
                'route' => '/data/gender',
            ],
            [
                'title' => 'Sexualities',
                'icon' => 'far fa-circle',
                'url' => 'data/sexuality',
                'route' => '/data/sexuality',
            ],
        ],
    ],
    [
        'title' => 'Design System',
        'icon' => 'far fa-circle',
        'urls' => [
            'examples/dashboard',
            'examples/widgets',
            'examples/charts',
            'examples/ui-elements',
            'examples/forms',
            'examples/tables',
            'examples/calendar',
            'examples/gallery',
        ],
        'items' => [
            [
                'title' => 'Dashboard',
                'icon' => 'far fa-circle',
                'urls' => [
                    'examples/dashboard',
                ],
                'items' => [
                    [
                        'title' => 'Dashboard 1',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/dashboard/1',
                        'route' => '/examples/dashboard/1',
                    ],
                    [
                        'title' => 'Dashboard 2',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/dashboard/2',
                        'route' => '/examples/dashboard/2',
                    ],
                    [
                        'title' => 'Dashboard 3',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/dashboard/3',
                        'route' => '/examples/dashboard/3',
                    ],
                ],
            ],
            [
                'title' => 'Widgets',
                'icon' => 'far fa-circle',
                'url' => 'examples/widgets',
                'route' => '/examples/widgets',
            ],
            [
                'title' => 'Charts',
                'icon' => 'far fa-circle',
                'urls' => [
                    'examples/charts',
                ],
                'items' => [
                    [
                        'title' => 'ChartJS',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/charts/chartjs',
                        'route' => '/examples/charts/chartjs',
                    ],
                    [
                        'title' => 'Flot',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/charts/flot',
                        'route' => '/examples/charts/flot',
                    ],
                    [
                        'title' => 'Inline',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/charts/inline',
                        'route' => '/examples/charts/inline',
                    ],
                ],
            ],
            [
                'title' => 'UI Elements',
                'icon' => 'far fa-circle',
                'urls' => [
                    'examples/ui-elements',
                ],
                'items' => [
                    [
                        'title' => 'General',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/general',
                        'route' => '/examples/ui-elements/general',
                    ],
                    [
                        'title' => 'Icons',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/icons',
                        'route' => '/examples/ui-elements/icons',
                    ],
                    [
                        'title' => 'Buttons',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/buttons',
                        'route' => '/examples/ui-elements/buttons',
                    ],
                    [
                        'title' => 'Sliders',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/sliders',
                        'route' => '/examples/ui-elements/sliders',
                    ],
                    [
                        'title' => 'Modals & Alerts',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/modals-alerts',
                        'route' => '/examples/ui-elements/modals-alerts',
                    ],
                    [
                        'title' => 'Tabs',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/tabs',
                        'route' => '/examples/ui-elements/tabs',
                    ],
                    [
                        'title' => 'Timeline',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/timeline',
                        'route' => '/examples/ui-elements/timeline',
                    ],
                    [
                        'title' => 'Ribbons',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/ui-elements/ribbons',
                        'route' => '/examples/ui-elements/ribbons',
                    ],
                ]
            ],
            [
                'title' => 'Forms',
                'icon' => 'far fa-circle',
                'urls' => ['examples/forms'],
                'items' => [
                    [
                        'title' => 'General Elements',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/forms/general-elements',
                        'route' => '/examples/forms/general-elements',
                    ],
                    [
                        'title' => 'Advenced Elements',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/forms/advanced-elements',
                        'route' => '/examples/forms/advanced-elements',
                    ],
                    [
                        'title' => 'Editors',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/forms/editors',
                        'route' => '/examples/forms/editors',
                    ],
                ]
            ],
            [
                'title' => 'Tables',
                'icon' => 'far fa-circle',
                'urls' => ['examples/tables'],
                'items' => [
                    [
                        'title' => 'Simple Tables',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/tables/simple-tables',
                        'route' => '/examples/tables/simple-tables',
                    ],
                    [
                        'title' => 'DataTables',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/tables/data-tables',
                        'route' => '/examples/tables/data-tables',
                    ],
                    [
                        'title' => 'jsGrid',
                        'icon' => 'far fa-dot-circle',
                        'url' => 'examples/tables/js-grid',
                        'route' => '/examples/tables/js-grid',
                    ],
                ],
            ],
            [
                'title' => 'Calendar',
                'icon' => 'far fa-circle',
                'url' => 'examples/calendar',
                'route' => '/examples/calendar',
            ],
            [
                'title' => 'Gallery',
                'icon' => 'far fa-circle',
                'url' => 'examples/gallery',
                'route' => '/examples/gallery',
            ],
        ],
    ],
    [
        'title' => 'DONATION',
        'icon' => 'fas fa-donate',
    ],
    [
        'title' => 'Getting started',
        'icon' => 'far fa-circle',
        'href' => 'https://github.com/opensourcewebsite-org/opensourcewebsite-org/blob/master/DONATE.md',
    ],
];
?>
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php foreach ($leftMenuItems as $item) : ?>
                            <?php if (isset($item['items'])) : ?>
                                <li class="nav-item has-treeview  <?= in_array(Yii::$app->requestedRoute, $item['urls']) ? 'menu-open' : '' ?>">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon <?= $item['icon'] ?>"></i>
                                        <p><?= $item['title'] ?><i class="fa fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php foreach ($item['items'] as $subItem) : ?>
                                            <?php if (isset($subItem['items'])) : ?>
                                                <li class="nav-item has-treeview  <?= in_array(Yii::$app->requestedRoute, $subItem['urls']) ? 'menu-open' : '' ?>">
                                                    <a href="#" class="nav-link">
                                                        <i class="nav-icon <?= $subItem['icon'] ?>"></i>
                                                        <p><?= $subItem['title'] ?><i class="fa fa-angle-left right"></i></p>
                                                    </a>
                                                    <ul class="nav nav-treeview <?= in_array(Yii::$app->requestedRoute, $subItem['urls']) ? 'menu-open' : '' ?>">
                                                <?php foreach ($subItem['items'] as $subItemItems) : ?>
                                                    <li class="nav-item">
                                                        <a href="<?= Yii::$app->urlManager->createUrl([$subItemItems['url']]) ?>" class="nav-link <?= (Yii::$app->request->getUrl() == $subItemItems['route']) ? 'active' : '' ?>">
                                                            <i class="nav-icon <?= $subItemItems['icon'] ?>"></i>
                                                            <p><?= $subItemItems['title'] ?></p>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php else : ?>
                                            <li class="nav-item">
                                                <a href="<?= $subItem['href'] ?? Yii::$app->urlManager->createUrl([$subItem['url']]) ?>" class="nav-link <?= (isset($subItem['route']) && (Yii::$app->request->getUrl() == $subItem['route'])) ? 'active' : '' ?>">
                                                    <i class="nav-icon <?= $subItem['icon'] ?>"></i>
                                                    <p><?= $subItem['title'] ?></p>
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php elseif (isset($item['url']) || isset($item['href'])) : ?>
                                <li class="nav-item has-treeview  <?= (isset($item['route']) && Yii::$app->request->getUrl() == $item['route']) ? 'menu-open' : '' ?>">
                                    <a href="<?= $item['href'] ?? Yii::$app->urlManager->createUrl([$item['url']]) ?>" class="nav-link <?= (isset($item['route']) && (Yii::$app->request->getUrl() == $item['route'])) ? 'active' : '' ?>">
                                        <i class="nav-icon <?= $item['icon'] ?>"></i>
                                        <p><?= $item['title'] ?></p>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="nav-header"><i class="<?= $item['icon'] ?>"></i> <?= $item['title'] ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </nav><!-- /.sidebar-menu -->
            </div><!-- /.sidebar -->
        </aside><!-- /.main-sidebar -->


        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <?= Alert::widget() ?>
                    </div>
                    <?php if (isset($this->blocks['content-header-data'])): ?>
                        <?php echo $this->blocks['content-header-data']; ?>
                    <?php else: ?>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><?= Html::encode($this->title) ?></h1>
                            </div>
                            <div class="col-sm-6">
                                <?=
                                Breadcrumbs::widget([
                                    'options' => ['class' => 'breadcrumb float-sm-right'],
                                    'itemTemplate' => '<li class="breadcrumb-item"><a href="#">{link}</a></li>',
                                    'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div><!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?= $content ?>

                </div>
            </section><!-- /.content -->
        </div>

        <footer class="main-footer">
            <?= Html::a(Yii::t('app', 'Telegram Bot'), 'https://t.me/opensourcewebsite_bot') ?> |
            <?= Html::a(Yii::t('app', 'Slack'), 'https://join.slack.com/t/opensourcewebsite/shared_invite/enQtNDE0MDc2OTcxMDExLWJmMjFjOGUxNjFiZTg2OTc0ZDdkNTdhNDIzZDE2ODJiMGMzY2M5Yjg3NzEyNGMxNjIwZWE0YTFhNTE3MjhiYjY') ?> |
            <?= Html::a(Yii::t('app', 'Discord'), 'https://discord.gg/94WpSPJ') ?> |
            <?= Html::a(Yii::t('app', 'Gitter'), 'https://gitter.im/opensourcewebsite-org') ?>
        </footer>
    </div>
<?php $this->endBody() ?>
<script>
    $(document).ready(function () {
        $('#lang-menu').prepend('<div><input type="text" id="search-lang" placeholder="Search.."></div>');
        $('#search-lang')
            .keyup(function() {
                var input = $(this).val();
                var filter = input.toLowerCase();
                var nodes = $('.dropdown-item');
                for (var i = 0; i < nodes.length; i++) {
                    if (nodes[i].innerText.toLowerCase().includes(filter)) {
                        nodes[i].style.display = "block";
                    } else {
                        nodes[i].style.display = "none";
                    }
                }
            })
            .keyup();
    });

    $(document).on('click', '.modal-btn-ajax', function(e){
        e.preventDefault();
        $('#main-modal')
            .find('.modal-content')
            .empty()
            .load($(this).attr('href'), function(){
                $('#main-modal').modal('show')
            });

        return false;
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
