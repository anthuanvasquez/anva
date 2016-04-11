// Configuration
var url          = 'anva.dev';
var project      = 'anva';                      // Theme Name
var version      = '1.0.0';                     // Theme Version
var branch       = 'feature/canvas';            // Current Branch
var framework    = './framework/assets/';       // Framework Assets
var admin        = './framework/admin/assets/'; // Framework Admin Assets
var theme        = './assets/';                 // Theme Assets
var bower        = './bower_components/';
var build        = './build-theme/';            // Release Package
var buildInclude = [
    './**/*.php',
    './**/*.css',
    './**/*.js',
    './**/*.svg',
    './**/*.ttf',
    './**/*.otf',
    './**/*.eot',
    './**/*.woff',
    './**/*.woff2',
    './**/*.png',
    './**/*.gif',
    './**/*.jpg',
    './assets/**/*',
    './framework/**/*',
    'screenshot.png',
    '!node_modules/**/*',
    '!bower_components/**/*'
];

// Require plugins
var gulp         = require('gulp');
var browserSync  = require('browser-sync');
var reload       = browserSync.reload;
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-uglifycss');
var filter       = require('gulp-filter');
var uglify       = require('gulp-uglify');
var rename       = require('gulp-rename');
var concat       = require('gulp-concat');
var notify       = require('gulp-notify');
var runSequence  = require('gulp-run-sequence');
var sass         = require('gulp-sass');
var plugins      = require('gulp-load-plugins')({ camelize: true });
var ignore       = require('gulp-ignore');
var rimraf       = require('gulp-rimraf');
var zip          = require('gulp-zip');
var plumber      = require('gulp-plumber');
var cache        = require('gulp-cache');
var argv         = require('yargs').argv;
var git          = require('gulp-git');
var wpPot        = require('gulp-wp-pot');
var sort         = require('gulp-sort');

// Error handle
var onError = function( err ) {
  console.log( 'An error occurred:', err.message );
  this.emit( 'end' );
}


/**
 * Browser Sync
 */
gulp.task('browser-sync', function() {
    var files = [
        '**/*.php',
        '**/*.{png,jpg,gif}'
    ];
    browserSync.init( files, {
        proxy: url,
        injectChanges: true
    });
});


/**
 * Theme
 * 
 * SCSS, Minify CSS and Concatenate JS.
 */
gulp.task('themescss', function () {
    gulp.src( theme + 'scss/*.scss')
        .pipe(plumber( { errorHandler: onError } ))
        .pipe(sass({
            errLogToConsole: true,
            // outputStyle: 'compact',
            // outputStyle: 'compressed',
            // outputStyle: 'nested',
            outputStyle: 'expanded',
            precision: 10
        }))
        .pipe(autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(plumber.stop())
        .pipe(gulp.dest('./assets/css'))
        .pipe(reload({stream:true}))
        .pipe(notify({ message: 'Theme styles task complete', onLast: true }))
});

var theme_css_paths = [
    theme + 'css/dark.css',
    theme + 'css/fonts.css',
    theme + 'css/login.css',
    theme + 'css/theme.css'
];

gulp.task('thememinify', function () {
    gulp.src(theme_css_paths)
        .pipe(plumber( { errorHandler: onError } ))
        .pipe(filter('**/*.css'))
        .pipe(minifycss({
            'maxLineLe': 80,
            'uglyComments': true
        }))
        .pipe(rename(function(path) {
            path.dirname = path.dirname.replace('./assets/css');
            path.extname = '.min.css';
        }))
        .pipe(plumber.stop())
        .pipe(gulp.dest( theme+ 'css'))
        .pipe(reload({stream:true}))
        .pipe(notify({ message: 'Theme minify styles task complete', onLast: true }));
});

gulp.task('themejs', function() {
    gulp.src([theme + 'js/*.js'])
        .pipe(concat('global.js'))
        .pipe(gulp.dest(theme + 'js'))
        .pipe(rename( {
            basename: 'global',
            suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest(theme + 'js'))
        .pipe(notify({ message: 'Theme scripts task complete', onLast: true }));
});


/**
 * Framework
 *
 * Concatenate all framework required plugins for front end.
 */

bower_js_paths = [
    bower     + 'jquery.easing/js//jquery.easing.min.js',
    bower     + 'jquery.fitvids/jquery.fitvids.js',
    bower     + 'superfish/dist/js/superfish.min.js',
    bower     + 'superfish/dist/js/hoverIntent.js',
    framework + 'js/vendor/twitterfeedfetcher.js',
    bower     + 'jrespond/js/jRespond.min.js',
    framework + 'js/vendor/smoothscroll-modified.min.js',
    framework + 'js/vendor/jquery.flickrfeed.min.js',
    bower     + 'instafeed.js/js/instafeed.min.js',
    bower     + 'jribbble/dist/jribbble.min.js',
    bower     + 'jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js',
    bower     + 'jquery.cookie/jquery.cookie.js',
    bower     + 'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
    bower     + 'jquery.appear/jquery.appear.js',
    bower     + 'animsition/dist/js/animsition.min.js',
    bower     + 'jquery.stellar/jquery.stellar.min.js',
    framework + 'js/vendor/jquery.plugin.min.js',
    framework + 'js/vendor/jquery.countdown.min.js',
    bower     + 'jquery-countTo/jquery.countTo.js',
    bower     + 'owl.carousel/dist/owl.carousel.min.js',
    bower     + 'Morphext/dist/morphext.min.js',
    bower     + 'isotope/dist/isotope.pkgd.min.js',
    bower     + 'imagesloaded/imagesloaded.pkgd.min.js',
    framework + 'js/vendor/swiper.min.js',
    bower     + 'jquery-bbq/jquery.ba-bbq.min.js',
    bower     + 'jquery-color/jquery.color.js',
    bower     + 'meteor-toastr/lib/toastr.js',
    bower     + 'Chart.js/dist/Chart.min.js',
    bower     + 'jquery-form/jquery.form.js',
    bower     + 'magnific-popup/dist/jquery.magnific-popup.min.js',
    framework + 'js/vendor/jquery.flexslider-modified.min.js',
    framework + 'js/vendor/jquery.paginate.min.js',
    framework + 'js/vendor/jquery.paginate.min.js',
    bower     + 'jquery-infinite-scroll/jquery.infinitescroll.min.js',
    framework + 'js/vendor/jquery.ui.1.11.4.min.js',
    bower     + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
    bower     + 'jquery-validation/dist/jquery.validate.min.js'
]

gulp.task('fjs', function() {
    gulp.src(bower_js_paths)
        .pipe(concat('global.js'))
        .pipe(gulp.dest(framework + 'js'))
        .pipe(rename( {
            basename: 'global',
            suffix: '.min'
        }))
        .pipe(uglify())
        .pipe(gulp.dest(framework + 'js'))
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
    git.push('origin', branch, function (err) {
        if (err) throw err;
    });
});

gulp.task('gitsend', function() {
    runSequence('add', 'commit', 'push');
});

gulp.task('makepot', function () {
    gulp.src('./**/*.php')
        .pipe(sort())
        .pipe(wpPot( {
            domain: 'anva',
            destFile:'Anva.pot',
            package: 'anva',
            bugReport: 'http://anthuanvasuqez.net',
            lastTranslator: 'Anthuan Vásquez <me@anthuanvasuqez.net>',
            team: 'Anthuan Vásquez <me@anthuanvasuqez.net>'
        } ))
        .pipe(gulp.dest('./languages'));
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

gulp.task('cleanafter', function() {
    gulp.src(['./bower_components','**/.sass-cache', '**/.DS_Store'], { read: false })
        .pipe(ignore('node_modules/**'))
        .pipe(rimraf({ force: true }))
        // .pipe(notify({ message: 'Clean task complete', onLast: true }));
});

/**
 * Files
 * 
 * Build task that moves essential theme files for production.
 */
gulp.task('buildfiles', function() {
    gulp.src(buildInclude)
        .pipe(gulp.dest(build))
        .pipe(notify({ message: 'Copy from buildfiles complete', onLast: true }));
});


/**
 * Zipping build directory for distribution.
 */
gulp.task('buildzip', function () {
    gulp.src(build + '/**/')
        .pipe(zip(project + '-v' + version + '.zip'))
        .pipe(gulp.dest('./'))
        .pipe(notify({ message: 'Zip task complete', onLast: true }));
});


/**
 * Package Distributable Theme
 */
gulp.task('build', function(cb) {
    runSequence('themescss', 'clean', 'buildfiles', 'buildzip', 'cleanafter', cb);
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