// ==== CONFIGURATION ==== //

// Project paths
var project = 'anva',
    version = '1.0.0',
    _url    = 'anva.dev',
    src     = '../',
    build   = './build/',
    dist    = './build-theme/'+project+'-'+version+'/',
    assets  = './assets/',
    js_core = src+'framework/assets/js/',
    bower   = './bower_components/',
    modules = './node_modules/'
;

bower_js_paths = [
    js_core + 'vendor/twitterfeedfetcher.js',
    js_core + 'vendor/smoothscroll-modified.min.js',
    js_core + 'vendor/swiper.min.js',
    js_core + 'vendor/jquery.flickrfeed.min.js',
    js_core + 'vendor/jquery.plugin.min.js',
    js_core + 'vendor/jquery.countdown.min.js',
    js_core + 'vendor/jquery.flexslider-modified.min.js',
    js_core + 'vendor/jquery.paginate.min.js',
    js_core + 'vendor/jquery.paginate.min.js',
    js_core + 'vendor/jquery.ui.1.11.4.min.js',
    bower   + 'jquery.easing/js//jquery.easing.min.js',
    bower   + 'jquery.fitvids/jquery.fitvids.js',
    bower   + 'superfish/dist/js/superfish.min.js',
    bower   + 'superfish/dist/js/hoverIntent.js',
    bower   + 'jrespond/js/jRespond.min.js',
    bower   + 'instafeed.js/js/instafeed.min.js',
    bower   + 'jribbble/dist/jribbble.min.js',
    bower   + 'jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js',
    bower   + 'jquery.cookie/jquery.cookie.js',
    bower   + 'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
    bower   + 'jquery.appear/jquery.appear.js',
    bower   + 'animsition/dist/js/animsition.min.js',
    bower   + 'jquery.stellar/jquery.stellar.min.js',
    bower   + 'jquery-countTo/jquery.countTo.js',
    bower   + 'owl.carousel/dist/owl.carousel.min.js',
    bower   + 'Morphext/dist/morphext.min.js',
    bower   + 'isotope/dist/isotope.pkgd.min.js',
    bower   + 'imagesloaded/imagesloaded.pkgd.min.js',
    bower   + 'jquery-bbq/jquery.ba-bbq.min.js',
    bower   + 'jquery-color/jquery.color.js',
    bower   + 'meteor-toastr/lib/toastr.js',
    bower   + 'Chart.js/dist/Chart.min.js',
    bower   + 'jquery-form/jquery.form.js',
    bower   + 'magnific-popup/dist/jquery.magnific-popup.min.js',
    bower   + 'jquery-infinite-scroll/jquery.infinitescroll.min.js',
    bower   + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
    bower   + 'jquery-validation/dist/jquery.validate.min.js'
];

// Project settings
module.exports = {

  browsersync: {
    files: [src+'/**'],
    notify: false,
    open: true,
    port: 3000,
    proxy: 'localhost:8080',
    watchOptions: {
      debounceDelay: 2000
    }
  },

  images: {
    build: {
      src: [src+'**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)', '!'+src+'/.tools'],
      dest: build
    },
    dist: {
      src: [dist+'**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg)', '!'+dist+'screenshot.png'],
      imagemin: {
        optimizationLevel: 7,
        progressive: true,
        interlaced: true
      },
      dest: dist
    }
  },

  livereload: {
    port: 35729
  },

  scripts: {
    bundles: {
      core: ['core'],
      pageloader: ['pageloader', 'core']
    },
    chunks: {
      core: [
        modules+'timeago/jquery.timeago.js',
        src+'js/responsive-menu.js',
        src+'js/core.js'
      ],
      pageloader: [
        modules+'html5-history-api/history.js',
        modules+'spin.js/spin.js',
        modules+'spin.js/jquery.spin.js',
        modules+'wp-ajax-page-loader/wp-ajax-page-loader.js',
        src+'js/page-loader.js'
      ]
    },
    dest: build+'js/',
    lint: {
      src: [src+'js/**/*.js']
    },
    minify: {
      src: build+'js/**/*.js',
      uglify: {},
      dest: build+'js/'
    },
    namespace: 'wp-'
  },

  styles: {
    // Theme Styles
    build: {
      src: src+'assets/scss/**/*.scss',
      dest: build+'assets/css/'
    },
    // Themes Styles
    theme: {
      src: src+'assets/scss/**/*.scss',
      dest: build+'assets/css/'
    },
    // Framework styles
    core: {
      src: src+'framework/assets/less/**/*.less',
      dest: build+'framework/assets/css/'
    },
    admin: {
      src: src+'framework/admin/assets/scss/**/*.scss',
      dest: build+'framework/admin/assets/css/'
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

  theme: {
    lang: {
      src: src+'languages/**/*',
      dest: build+'languages/'
    },
    php: {
      src: src+'**/*.php',
      dest: build
    }
  },

  utils: {
    clean: [build+'**/.DS_Store'],
    wipe: [dist],
    dist: {
      src: [build+'**/*', '!'+build+'**/*.map'],
      dest: dist
    },
    normalize: {
      src: modules+'normalize.css/normalize.css',
      dest: src+'scss',
      rename: '_normalize.scss'
    }
  },

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
