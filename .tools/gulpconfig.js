/**
 * This is the config file fot the gulp task, see gulpfile.js dir
 * to view each tasks.
 *
 *
 * Project Information
 *
 * theme:   The parent theme assets.
 * core:    The framework assets.
 * admin:   The admin assets on frameork.
 * build:   The build theme without require files for development.
 * dist:    The released theme ready for deployment.
 * bower:   Bower components, required for theme development.
 * modules: The node packages, required for theme development.
 * vendor:  All required vendor plugins for use in the theme.
 */

'use_strict';

// Project paths
var project = 'anva',
    version = '1.0.0',
    proxy   = 'anva.dev',
    src     = '../',
    theme   = src + 'assets/',
    core    = src + 'framework/assets/',
    admin   = src + 'framework/admin/assets/',
    build   = './build/',
    dist    = './dist/' + project + '-' + version + '/',
    bower   = './bower_components/',
    modules = './node_modules/'
;

// Vendor Scripts `Plugins`
var vendor = [
    core  + 'js/vendor/twitterfeedfetcher.js',
    core  + 'js/vendor/smoothscroll-modified.min.js',
    core  + 'js/vendor/swiper.min.js',
    core  + 'js/vendor/jquery.flickrfeed.min.js',
    core  + 'js/vendor/jquery.plugin.min.js',
    core  + 'js/vendor/jquery.countdown.min.js',
    core  + 'js/vendor/jquery.flexslider-modified.min.js',
    core  + 'js/vendor/jquery.paginate.min.js',
    core  + 'js/vendor/jquery.paginate.min.js',
    core  + 'js/vendor/jquery.ui.1.11.4.min.js',
    bower + 'jquery.easing/js//jquery.easing.min.js',
    bower + 'jquery.fitvids/jquery.fitvids.js',
    bower + 'jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js',
    bower + 'jquery.cookie/jquery.cookie.js',
    bower + 'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
    bower + 'jquery.appear/jquery.appear.js',
    bower + 'jquery.stellar/jquery.stellar.min.js',
    bower + 'jquery-countTo/jquery.countTo.js',
    bower + 'jquery-bbq/jquery.ba-bbq.min.js',
    bower + 'jquery-color/jquery.color.js',
    bower + 'jquery-form/jquery.form.js',
    bower + 'jquery-infinite-scroll/jquery.infinitescroll.min.js',
    bower + 'jquery-validation/dist/jquery.validate.min.js',
    bower + 'superfish/dist/js/superfish.min.js',
    bower + 'superfish/dist/js/hoverIntent.js',
    bower + 'instafeed.js/js/instafeed.min.js',
    bower + 'jribbble/dist/jribbble.min.js',
    bower + 'animsition/dist/js/animsition.min.js',
    bower + 'owl.carousel/dist/owl.carousel.min.js',
    bower + 'Morphext/dist/morphext.min.js',
    bower + 'isotope/dist/isotope.pkgd.min.js',
    bower + 'imagesloaded/imagesloaded.pkgd.min.js',
    bower + 'meteor-toastr/lib/toastr.js',
    bower + 'jrespond/js/jRespond.min.js',
    bower + 'Chart.js/dist/Chart.min.js',
    bower + 'magnific-popup/dist/jquery.magnific-popup.min.js',
    bower + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
];

// Project Settings
module.exports = {

  // -------------------------------------------
  // BrowserSync
  // -------------------------------------------

  browsersync: {
    //files: [src + '/**', '!' + src + '.tools'],
    notify: true,
    open: true,
    proxy: {
      target: proxy
    },
    watchOptions: {
      debounceDelay: 2000
    }
  },

  // -------------------------------------------
  // Livereload
  // -------------------------------------------

  livereload: {
    port: 35729
  },

  // -------------------------------------------
  // Images
  // -------------------------------------------

  images: {
    build: {
      src: [src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)', '!' + src + '/.tools'],
      dest: build
    },
    dist: {
      src: [dist + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)', '!' + dist + 'screenshot.png'],
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
    dest: build + 'js/',
    lint: {
      theme: theme + 'js/**/*.js',
      core: core + 'js/**/*.js',
      admin: admin + 'js/**/*.js',
      ignore: ['*.min.js', 'plugins.js', 'vendor/**', 'components/**', 'vmap/**']
    },
    minify: {
      theme: {
        src: theme + 'js/**/*.js',
        dest: theme + 'js/',
      },
      core: {
        src: core + 'js/**/*.js',
        dest: core + 'js/',
        vendor: {
          files: vendor,
          name: 'vendor.js'
        },
        ignore: ['*.min.js', 'plugins.js', 'vendor/**', 'components/**', 'vmap/**']
      },
      admin: {
        src: admin + 'js/**/*.js',
        dest: admin + 'js/',
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
    lint: {
      min: '**.min.css',
      theme: theme + 'css/**/*.css',
      core: core + 'css/**/*.css',
      admin: admin + 'css/**/*.css',
      ignore: ['*.min.css', 'components/**', 'fonts/**']
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
      includePaths: ['./src/scss', bower, modules],
      precision: 6,
      outputStyle: 'expanded',
      onError: function(err) {
        return console.log(err);
      }
    },
    autoprefixer: {
      browsers: ['> 3%', 'last 2 versions', 'ie 9', 'ios 6', 'android 4']
    },
    minify: {
      safe: true
    },
    sourcemaps: false
  },

  // -------------------------------------------
  // Theme
  // -------------------------------------------

  theme: {
    lang: {
      src: src + 'languages/**/*',
      dest: build + 'languages/'
    },
    php: {
      src: [src + '**/*.php', '!' + src + '.tools/**'],
      dest: build
    }
  },

  // -------------------------------------------
  // Utils
  // -------------------------------------------

  utils: {
    clean: [src + '**/.DS_Store'],
    wipe: {
      dist: [dist],
      build: [build]
    },
    dist: {
      src: [build + '**/*', '!' + build + '**/*.map'],
      dest: dist,
    },
    zip: {
      src: dist + '*',
      name: project + '-' + version + '.zip',
      dest: './dist'
    }
  },

  // -------------------------------------------
  // Watch
  // -------------------------------------------

  watch: {
    src: {
      styles:       [theme  + 'scss/**/*.scss', core + 'scss/**/*.scss', admin + 'scss/**/*.scss'],
      scripts:      [theme  + 'js/**/*.js', core + 'js/**/*.js', admin + 'js/**/*.js'],
      images:       src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)',
      php:          src + '**/*.php',
      livereload:   src + '**/*'
    },
    watcher: 'browsersync'
  }

};
