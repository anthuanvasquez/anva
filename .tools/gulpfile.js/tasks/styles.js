// ==== STYLES ==== //

var gulp          = require('gulp'),
    gutil         = require('gulp-util'),
    plugins       = require('gulp-load-plugins')({ camelize: true }),
    config        = require('../../gulpconfig').styles,
    autoprefixer  = require('autoprefixer'),
    processors    = [autoprefixer(config.autoprefixer)]
;

// error function for plumber
var onError = function (err) {
  plugins.gutil.beep();
  console.log(err);
  this.emit('end');
};

// Build stylesheets from source Sass files, autoprefix,
// and write source maps (for debugging) with libsass
gulp.task('styles-theme', function() {
  return gulp.src(config.theme.src)
  .pipe(plugins.plumber({ errorHandler: onError }))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  //.pipe(plugins.cssnano(config.minify))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.theme.dest))
  .pipe(plugins.notify({ message: 'Theme styles completed' }));
});

gulp.task('styles-core', function() {
  return gulp.src(config.core.src)
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  //.pipe(plugins.cssnano(config.minify))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.core.dest))
  .pipe(plugins.browserSync.reload({ stream: true }));
});

gulp.task('styles-admin', function() {
  return gulp.src(config.admin.src)
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  //.pipe(plugins.cssnano(config.minify))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.admin.dest));
});

gulp.task('styles', ['styles-theme', 'styles-core']);

