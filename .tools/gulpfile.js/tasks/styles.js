// ==== STYLES ==== //

var gulp          = require('gulp'),
    gutil         = require('gulp-util'),
    plugins       = require('gulp-load-plugins')({ camelize: true }),
    config        = require('../../gulpconfig').styles,
    autoprefixer  = require('autoprefixer'),
    processors    = [autoprefixer(config.autoprefixer)],
    browsersync   = require('browser-sync')
;

// error function for plumber
var onError = function(err) {
  plugins.gutil.beep();
  console.log(err);
  this.emit('end');
};

// Build SCSS files from theme
gulp.task('styles-theme', function() {
  return gulp.src(config.theme.src)
  .pipe(plugins.plumber({ errorHandler: onError }))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  //.pipe(plugins.cssnano(config.minify))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.theme.dest))
  .pipe(browsersync.reload({ stream: true }));
});

// Build SCSS files from core
gulp.task('styles-core', function() {
  return gulp.src(config.core.src)
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  //.pipe(plugins.cssnano(config.minify))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.core.dest))
  .pipe(browsersync.reload({ stream: true }));
});

// Build SCSS files from admin
gulp.task('styles-admin', function() {
  return gulp.src(config.admin.src)
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.sass(config.sass))
  .pipe(plugins.postcss(processors))
  //.pipe(plugins.cssnano(config.minify))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.admin.dest))
  .pipe(browsersync.reload({ stream: true }));
});

gulp.task('styles-css-lint', function() {
  return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
  .pipe(plugins.ignore.exclude(config.lint.ignore))
  .pipe(plugins.csslint(config.lint.options))
  .pipe(plugins.csslint.reporter());
});

// @TODO create task to minify all css files

// Copy CSS source files to the `build` folder
gulp.task('styles-build', function(){
    return gulp.src(config.src)
    .pipe(plugins.changed(config.dest))
    .pipe(gulp.dest(config.dest));
});


gulp.task('styles-watch', ['styles-theme', 'styles-core', 'styles-admin']);
gulp.task('styles', ['styles-build']);
