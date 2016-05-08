// ==== SCRIPTS ==== //

var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    merge       = require('merge-stream'),
    config      = require('../../gulpconfig').scripts
;

// Check scripts for errors on theme, core and admin
gulp.task('scripts-lint', function() {
  return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
  .pipe(plugins.ignore.exclude(config.lint.ignore))
  .pipe(plugins.jshint())
  .pipe(plugins.jshint.reporter('default'));
});

// Minify theme scripts
gulp.task('scripts-minify-theme', function(){
  return gulp.src(config.minify.theme.src)
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.uglify(config.minify.uglify))
  .pipe(plugins.rename(config.minify.rename))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.minify.theme.dest));
});

// Minify core scripts
gulp.task('scripts-minify-core', function(){
  return gulp.src(config.minify.core.src)
  .pipe(plugins.ignore.exclude(config.minify.core.ignore))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
  .pipe(plugins.uglify(config.minify.uglify))
  .pipe(plugins.rename(config.minify.rename))
  .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
  .pipe(gulp.dest(config.minify.core.dest));
});

// Concat and minify core vendor scripts
gulp.task('scripts-core-vendor', function(){
    return gulp.src(config.minify.core.vendor.files)
    .pipe(plugins.concat(config.minify.core.vendor.name))
    .pipe(gulp.dest(config.minify.core.dest))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(gulp.dest(config.minify.core.dest));
});

// Master script tasks
gulp.task('scripts-minify', ['scripts-minify-theme', 'scripts-minify-core']);
gulp.task('scripts', ['scripts-lint']);
