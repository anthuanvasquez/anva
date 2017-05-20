/**
 * This is the config file fot the gulp tasks, see gulpfile.js dir
 * to view each tasks.
 *
 * Project Information
 *
 * theme:   The parent theme assets.
 * core:    The framework assets.
 * admin:   The framework admin assets.
 * build:   The build theme without require files for development.
 * dist:    The released theme ready for deployment.
 * bower:   Bower components, required for theme development.
 * modules: The node packages, required for theme development.
 * vendor:  All required vendor plugins for use in the theme.
 */

'use_strict';

// Project `Paths`
var project     = 'anva',
    version     = '1.0.0',
    release     = project + '-' + version,
    proxy       = 'anva.dev',
    src         = '../',
    theme       = src + 'assets/',
    core        = src + 'framework/assets/',
    admin       = src + 'framework/admin/assets/',
    build       = './build/',
    dist        = './dist/' + release + '/',
    ignoreTools = '!' + src + '.tools',
    bower       = './bower_components/',
    modules     = './node_modules/',
    parent      = '../../'
;

// Vendor Scripts `Plugins`
var vendor = [
    core + 'js/vendor/jquery.bootstrap.js',
    core + 'js/vendor/jquery.chart.js',
    core + 'js/vendor/jquery.color.js',
    core + 'js/vendor/jquery.cookie.js',
    core + 'js/vendor/jquery.countdown.js',
    core + 'js/vendor/jquery.countto.js',
    core + 'js/vendor/jquery.dribbble.js',
    core + 'js/vendor/jquery.fitvids.js',
    core + 'js/vendor/jquery.flexslider.js',
    core + 'js/vendor/jquery.flickrfeed.js',
    core + 'js/vendor/jquery.form.js',
    core + 'js/vendor/jquery.important.js',
    core + 'js/vendor/jquery.infinitescroll.js',
    core + 'js/vendor/jquery.instagram.js',
    core + 'js/vendor/jquery.isotope.js',
    core + 'js/vendor/jquery.magnific.js',
    core + 'js/vendor/jquery.owlcarousel.js',
    core + 'js/vendor/jquery.pagetransition.js',
    core + 'js/vendor/jquery.paginate.js',
    core + 'js/vendor/jquery.parallax.js',
    core + 'js/vendor/jquery.piechart.js',
    core + 'js/vendor/jquery.superfish.js',
    core + 'js/vendor/jquery.swiper.js',
    core + 'js/vendor/jquery.tabs.js',
    core + 'js/vendor/jquery.textrotator.js',
    core + 'js/vendor/jquery.toastr.js',
    core + 'js/vendor/jquery.twitterfeed.js',
    core + 'js/vendor/jquery.validation.js',
    core + 'js/vendor/jquery.waypoint.js',
    core + 'js/vendor/jquery.youtube.js',
    core + 'js/vendor/jRespond.js'
];

// Project `Settings`
module.exports = {

    // -------------------------------------------
    // BrowserSync
    // -------------------------------------------

    browsersync: {
        proxy: proxy
    },

    // -------------------------------------------
    // Images
    // -------------------------------------------

    images: {
        build: {
            src: [
                src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)',
                ignoreTools
            ],
            dest: build
        },
        dist: {
            src: [
                dist + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)',
                '!' + dist + 'screenshot.png'
            ],
            imagemin: {
                optimizationLevel: 7,
                progressive: true,
                interlaced: true
            },
            dest: dist
        }
    },

    // -------------------------------------------
    // Scripts
    // -------------------------------------------

    scripts: {
        dest: build,
        src: [src + '**/*.js', ignoreTools],
        lint: {
            theme: theme + 'js/**/*.js',
            core: core + 'js/**/*.js',
            admin: admin + 'js/**/*.js',
            ignore: [
                '*.min.js',
                'plugins.js',
                'vendor/**',
                'components/**',
                'vmap/**'
            ],
            options: src + '.jshintrc'
        },
        jscs: {
            options: {
                configPath: src + '.jscsrc'
            }
        },
        minify: {
            theme: {
                src: theme + 'js/**/*.js',
                dest: theme + 'js/'
            },
            core: {
                src: core + 'js/**/*.js',
                dest: core + 'js/',
                vendor: {
                    files: vendor,
                    name: 'plugins.vendor.js'
                },
                ignore: [
                    '*.min.js',
                    'plugins.js',
                    'vendor/**',
                    'components/**',
                    'vmap/**'
                ]
            },
            admin: {
                src: admin + 'js/**/*.js',
                dest: admin + 'js/'
            },
            uglify: {},
            rename: {
                suffix: '.min'
            }
        },
        sourcemaps: false
    },

    // -------------------------------------------
    // Styles
    // -------------------------------------------

    styles: {
        src: [src + '**/*.css', ignoreTools],
        dest: build,
        lint: {
            theme: theme + 'css/**/*.css',
            core: core + 'css/**/*.css',
            admin: admin + 'css/**/*.css',
            ignore: [
                '*.min.css',
                'custom.css',
                'ie.css',
                'calendar.css',
                'camera.css',
                'elastic.css',
                'nivo-slider.css',
                'swiper.css',
                'vmap.css',
                'animate.css',
                'bootstrap.css',
                'components/**',
                'fonts/**'
            ],
            options: {
                reporters: [
                    {
                        formatter: 'verbose',
                        console: true
                    }
                ]
            }
        },
        theme: {
            src: theme + 'scss/**/*.scss',
            dest: theme + 'css/'
        },
        core: {
            src: core + 'scss/**/*.scss',
            dest: core + 'css/'
        },
        admin: {
            src: admin + 'scss/**/*.scss',
            dest: admin + 'css/'
        },
        sass: {
            includePaths: [
                theme + 'scss',
                core + 'scss',
                admin + 'scss',
                bower,
                modules
            ],
            // Options: nested, expanded, compact, compressed
            outputStyle: 'expanded'
        },
        sassLint: {
            theme: theme + 'scss/**/*.scss',
            core: core + 'scss/**/*.scss',
            admin: admin + 'scss/**/*.scss'
        },
        autoprefixer: {
            browsers: [
                '> 1%',
                'last 2 versions',
                'not ie < 11',
                'not OperaMini >= 5.0',
                'ios 7',
                'android 4'
            ]
        },
        minify: {
            theme: {
                src: theme + 'css/**/*.css',
                dest: build + 'assets/css/'
            },
            core: {
                src: core + 'css/**/*.css',
                dest: build + 'framework/assets/css/'
            },
            admin: {
                src: admin + 'css/**/*.css',
                dest: build + 'framework/admin/assets/css/'
            },
            dest: build,
            ignore: [
                '*.min.css',
                'custom.css',
                'ie.css',
                'calendar.css',
                'camera.css',
                'elastic.css',
                'nivo-slider.css',
                'swiper.css',
                'vmap.css',
                'animate.css',
                'bootstrap.css',
                'components/**',
                'fonts/**'
            ],
            options: {
                safe: true
            }
        },
        sourcemaps: true
    },

    // -------------------------------------------
    // Theme
    // -------------------------------------------

    theme: {
        lang: {
            src: src + 'languages/**/*',
            dest: build + 'languages/',
            pot: {
                domain: project,
                destFile: project + '.pot',
                package: project,
                bugReport: 'https://anthuanvasquez.net',
                lastTranslator: 'Anthuan Vásquez <me@anthuanvasquez.net>',
                team: 'Anthuan Vásquez <me@anthuanvasquez.net>',
                dest: src + 'languages/'
            }
        },
        php: {
            src: [src + '**/*.php', ignoreTools],
            dest: build
        },
        readme: {
            src: src + 'readme.md',
            dest: build
        },
        textdomain: {
            text_domain: project,
            keywords: [
                '__:1,2d',
                '_e:1,2d',
                '_x:1,2c,3d',
                'esc_html__:1,2d',
                'esc_html_e:1,2d',
                'esc_html_x:1,2c,3d',
                'esc_attr__:1,2d',
                'esc_attr_e:1,2d',
                'esc_attr_x:1,2c,3d',
                '_ex:1,2c,3d',
                '_n:1,2,4d',
                '_nx:1,2,4c,5d',
                '_n_noop:1,2,3d',
                '_nx_noop:1,2,3c,4d'
            ]
        }
    },

    // -------------------------------------------
    // Utils
    // -------------------------------------------

    utils: {
        clean: [src + '**/.DS_Store', src + '**/.log'],
        wipe: {
            dist: [dist],
            build: [build]
        },
        dist: {
            src: [build + '**/*', '!' + build + '**/*.map'],
            dest: './dist',
            name: release + '.zip'
        }
    },

    // -------------------------------------------
    // Watch
    // -------------------------------------------

    watch: {
        src: {
            theme: theme + 'scss/**/*.scss',
            core: core + 'scss/**/*.scss',
            admin: admin + 'scss/**/*.scss',
            scripts: [
                theme + 'js/**/*.js',
                core + 'js/**/*.js',
                admin + 'js/**/*.js'
            ],
            images: src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)',
            php: src + '**/*.php'
        }
    }

};
