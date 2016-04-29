// Project paths
var project = 'anva',
    version = '1.0.0',
    proxy   = 'anva.dev',
    src     = '../',
    theme   = src + 'assets/',
    admin   = src + 'framework/admin/assets/',
    core    = src + 'framework/assets/',
    build   = './build/',
    dist    = './build-theme/' + project + '-' + version + '/',
    bower   = './bower_components/',
    modules = './node_modules/'
;

// Vendor Scripts
var bower_js = [
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
    files: [src + '/**'],
    notify: false,
    open: true,
    port: 3000,
    proxy: proxy,
    watchOptions: {
      debounceDelay: 2000
    }
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
  // Livereload
  // -------------------------------------------

  livereload: {
    port: 35729
  },

  // -------------------------------------------
  // Scripts
  // -------------------------------------------

  scripts: {
    dest: build + 'js/',
    lint: {
      src: [src + 'js/**/*.js'],
      'core': [src + '']
    },
    minify: {
      src: build+'js/**/*.js',
      uglify: {},
      dest: build+'js/'
    },
    namespace: 'wp-'
  },

  // -------------------------------------------
  // Styles
  // -------------------------------------------

  styles: {
    build: {
      src: theme + 'scss/**/*.scss',
      dest: build + 'assets/css/'
    },
    theme: {
      src: theme + 'scss/**/*.scss',
      dest: theme + 'css/'
    },
    core: {
      src: core + 'less/**/*.less',
      dest: core + 'css/'
    },
    admin: {
      src: admin + 'scss/**/*.scss',
      dest: build + 'css/'
    },
    compiler: 'libsass',
    autoprefixer: { browsers: ['> 3%', 'last 2 versions', 'ie 9', 'ios 6', 'android 4'] },
    minify: { safe: true },
    rubySass: {
      loadPath: ['./src/scss', bower, modules],
      precision: 6,
      sourcemap: true
    },
    libsass: {
      includePaths: ['./src/scss', bower, modules],
      precision: 6,
      onError: function(err) {
        return console.log(err);
      }
    }
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
      src: src + '**/*.php',
      dest: build
    }
  },

  // -------------------------------------------
  // Utils
  // -------------------------------------------

  utils: {
    clean: [build + '**/.DS_Store'],
    wipe: [dist],
    dist: {
      src: [build + '**/*', '!'+build+'**/*.map'],
      dest: dist
    }
  },

  // -------------------------------------------
  // Watch
  // -------------------------------------------

  watch: {
    src: {
      styles:       src+'assets/scss/**/*.scss',
      scripts:      src+'assets/js/**/*.js',
      images:       src+'**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)',
      theme:        src+'**/*.php',
      livereload:   src+'**/*'
    },
    watcher: 'livereload'
  }
}
