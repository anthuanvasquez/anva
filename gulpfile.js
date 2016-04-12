// Project Paths
var assets_theme    = './assets/',                 // Theme Assets
    assets_core     = './framework/assets/',       // Framework Assets
    assets_admin    = './framework/admin/assets/', // Framework Admin Assets
    build           = './build-theme/',            // Build Dir
    bower           = './bower_components/',       // Bower Components
    modules         = './node_modules/';           // Node Modules

// Project config
var config = {
    name:       'anva',                // Theme Name
    version:    '1.0.0',               // Theme Version
    branch:     'feature/canvas',      // Git Current Branch
    browsersync: {
        files: ['./**', '!./**/*.map', '!node_modules/**/*', '!bower_components/**/*'],
        notify: false,
        open: true,
        port: 3000,
        proxy: 'anva.dev',
        watchOptions: {
            debounceDelay: 2000
        }
    },
    theme: {
        files: [
            './**/*.php',
            './**/*.css',
            './**/*.js',
            './**/*.png',
            './**/*.jpg',
            './**/*.gif',
            '!bower_components/**/*',
            'node_modules/**/*'
        ],
        lang: './languages/**/*',
        minify: [
            assets_theme+'css/**/*.css',
            '!'+assets_theme+'css/custom.css',
            '!'+assets_theme+'css/ie.css'
        ],
        scss: assets_theme+'scss/**/*scss'
    }
}

// Require plugins
var gulp         = require('gulp');
var plugins      = require('gulp-load-plugins')({ camelize: true });

// @TODO Clean Plugins
var browserSync  = require('browser-sync');
var reload       = browserSync.reload;
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-uglifycss');
var uglify       = require('gulp-uglify');
var sass         = require('gulp-sass');
var filter       = require('gulp-filter');
var rename       = require('gulp-rename');
var concat       = require('gulp-concat');
var plumber      = require('gulp-plumber');
var notify       = require('gulp-notify');
var runSequence  = require('gulp-run-sequence');
var ignore       = require('gulp-ignore');
var rimraf       = require('gulp-rimraf');
var zip          = require('gulp-zip');
var cache        = require('gulp-cache');
var argv         = require('yargs').argv;
var git          = require('gulp-git');
var sort         = require('gulp-sort');
var wpPot        = require('gulp-wp-pot');

// Error handle
var onError = function( err ) {
  console.log( 'An error occurred:', err.message );
  this.emit( 'end' );
}


/**
 * Browser Sync
 */
gulp.task('browser-sync', function() {
    browsersync(config.browsersync);
});


/* -------------------------------------------------- */
/* THEME
/* -------------------------------------------------- */

gulp.task('theme-styles', function () {
    gulp.src(config.theme.scss)
        .pipe(plumber( { errorHandler: onError } ))
        .pipe(sass({
            errLogToConsole: true,
            outputStyle: 'expanded',
            precision: 10
        }))
        .pipe(autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(plumber.stop())
        .pipe(gulp.dest(assets_theme + 'css'))
        .pipe(reload({stream:true}))
        .pipe(notify({ message: 'Theme styles task complete', onLast: true }))
});

gulp.task('theme-css-min', function () {
    gulp.src(config.theme.minify)
        .pipe(plumber( { errorHandler: onError } ))
        .pipe(filter('**/*.css'))
        .pipe(minifycss({
            'maxLineLe': 80,
            'uglyComments': true
        }))
        .pipe(rename(function(path) {
            path.dirname = path.dirname.replace(assets_theme+'css');
            path.extname = '.min.css';
        }))
        .pipe(plumber.stop())
        .pipe(gulp.dest(assets_theme+'css'))
        .pipe(reload({stream:true}))
        .pipe(notify({ message: 'Theme minify styles task complete', onLast: true }));
});

gulp.task('theme-scripts', function() {
    return gulp.src([assets_theme + 'js/*.js'])
        .pipe(concat('global.js'))
        .pipe(gulp.dest(assets_theme + 'js'))
        .pipe(notify({ message: 'Theme scripts task complete', onLast: true }));
});

// Copy PHP source files to the `build-theme` folder
gulp.task('theme-php', function() {
  return gulp.src(config.theme.files)
      .pipe(plugins.changed(build))
      .pipe(gulp.dest(build));
});

// Copy everything under `src/languages` indiscriminately
gulp.task('theme-lang', function() {
  return gulp.src(config.theme.lang)
      .pipe(plugins.changed(build+'languages/'))
      .pipe(gulp.dest(build+'languages/'));
});

// All the theme tasks in one
gulp.task('theme-build', ['theme-lang', 'theme-php']);


/**
 * Framework
 *
 * Concatenate all framework required plugins for front end.
 */

bower_js_paths = [
    assets_core + 'js/vendor/twitterfeedfetcher.js',
    assets_core + 'js/vendor/smoothscroll-modified.min.js',
    assets_core + 'js/vendor/swiper.min.js',
    assets_core + 'js/vendor/jquery.flickrfeed.min.js',
    assets_core + 'js/vendor/jquery.plugin.min.js',
    assets_core + 'js/vendor/jquery.countdown.min.js',
    assets_core + 'js/vendor/jquery.flexslider-modified.min.js',
    assets_core + 'js/vendor/jquery.paginate.min.js',
    assets_core + 'js/vendor/jquery.paginate.min.js',
    assets_core + 'js/vendor/jquery.ui.1.11.4.min.js',
    bower       + 'jquery.easing/js//jquery.easing.min.js',
    bower       + 'jquery.fitvids/jquery.fitvids.js',
    bower       + 'superfish/dist/js/superfish.min.js',
    bower       + 'superfish/dist/js/hoverIntent.js',
    bower       + 'jrespond/js/jRespond.min.js',
    bower       + 'instafeed.js/js/instafeed.min.js',
    bower       + 'jribbble/dist/jribbble.min.js',
    bower       + 'jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js',
    bower       + 'jquery.cookie/jquery.cookie.js',
    bower       + 'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
    bower       + 'jquery.appear/jquery.appear.js',
    bower       + 'animsition/dist/js/animsition.min.js',
    bower       + 'jquery.stellar/jquery.stellar.min.js',
    bower       + 'jquery-countTo/jquery.countTo.js',
    bower       + 'owl.carousel/dist/owl.carousel.min.js',
    bower       + 'Morphext/dist/morphext.min.js',
    bower       + 'isotope/dist/isotope.pkgd.min.js',
    bower       + 'imagesloaded/imagesloaded.pkgd.min.js',
    bower       + 'jquery-bbq/jquery.ba-bbq.min.js',
    bower       + 'jquery-color/jquery.color.js',
    bower       + 'meteor-toastr/lib/toastr.js',
    bower       + 'Chart.js/dist/Chart.min.js',
    bower       + 'jquery-form/jquery.form.js',
    bower       + 'magnific-popup/dist/jquery.magnific-popup.min.js',
    bower       + 'jquery-infinite-scroll/jquery.infinitescroll.min.js',
    bower       + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
    bower       + 'jquery-validation/dist/jquery.validate.min.js'
]

gulp.task('core-js', function() {
    gulp.src(bower_js_paths)
        .pipe(concat('global.js'))
        .pipe(gulp.dest(assets_core + 'js'))
        .pipe(rename( {
            basename: 'global',
            suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest(assets_core + 'js'))
        .pipe(notify({ message: 'Framework scripts task complete', onLast: true }));
});


/**
 * Git Basic Tasks
 * 
 * Init, Add, Commit and Push.
 */

gulp.task('init', function() {
    console.log(argv.m);
});

gulp.task('add', function() {
    console.log('Adding...');
    return gulp.src('.')
        .pipe(git.add());
});

gulp.task('commit', function() {
    console.log('Commiting');
    if (argv.m) {
    return gulp.src('.')
        .pipe(git.commit(argv.m));
    }
});

gulp.task('push', function(){
    console.log('Pushing...');
    git.push('origin', config.branch, function (err) {
        if (err) throw err;
    });
});

gulp.task('git-send', function() {
    runSequence('add', 'commit', 'push');
});


/**
 * Make POT file for translation.
 */
gulp.task('makepot', function () {
    gulp.src('**/*.php')
        .pipe(ignore('bower_components/**'))
        .pipe(ignore('node_modules/**'))
        .pipe(sort())
        .pipe(wpPot( {
            domain: 'anva',
            destFile:'anva.pot',
            package: 'anva',
            bugReport: 'http://anthuanvasuqez.net',
            lastTranslator: 'Anthuan Vásquez <me@anthuanvasuqez.net>',
            team: 'Anthuan Vásquez <me@anthuanvasuqez.net>'
        } ))
        .pipe(gulp.dest('./languages'))
        .pipe(notify({ message: 'POT file created', onLast: true }));
});


/**
 * Clean gulp cache.
 */
gulp.task('clear', function () {
    cache.clearAll();
});


/**
 * Clean tasks for zip.
 */
gulp.task('clean', function() {
    gulp.src(['./bower_components', '**/.sass-cache', '**/.DS_Store'], { read: false })
        .pipe(ignore('node_modules/**'))
        .pipe(rimraf({ force: true }))
        // .pipe(notify({ message: 'Clean task complete', onLast: true }));
});

gulp.task('cleana-fter', function() {
    gulp.src(['./bower_components', '**/.sass-cache', '**/.DS_Store'], { read: false })
        .pipe(ignore('node_modules/**'))
        .pipe(rimraf({ force: true }))
        // .pipe(notify({ message: 'Clean task complete', onLast: true }));
});

/**
 * Files
 * 
 * Build task that moves essential theme files for production.
 */
gulp.task('build-files', function() {
    gulp.src(files)
        .pipe(gulp.dest(build))
        .pipe(notify({ message: 'Copy files complete', onLast: true }));
});


/**
 * Zipping build directory for distribution.
 */
gulp.task('build-zip', function () {
    gulp.src(build + '/**/')
        .pipe(zip(config.name + '-v' + config.version + '.zip'))
        .pipe(gulp.dest('./'))
        .pipe(notify({ message: 'Zip task complete', onLast: true }));
});


/**
 * Package Distributable Theme
 */
gulp.task('build', function(cb) {
    runSequence('theme-scss', 'clean', 'build-files', 'build-zip', 'clean-after', cb);
});


/**
 * Gulp Default Task
 *
 * Compiles styles, fires-up browser sync, watches js 
 * and php files. Note browser sync task watches php files.
 */
gulp.task('default', ['themescss', 'browser-sync'], function () {

    gulp.watch('./assets/scss/*.scss', ['themescss']);
    gulp.watch('./assets/js/**/*.js', ['themejs', browserSync.reload]);
    
});