// ==== UTILITIES ==== //

var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    del         = require('del'),
    config      = require('../../gulpconfig').utils
;

// Totally wipe the contents of the `dist` folder to prepare
// for a clean build; additionally trigger Bower-related tasks
// to ensure we have the latest source files
gulp.task('utils-wipe-dist', function() {
  return del(config.wipe.dist);
});

gulp.task('utils-wipe-build', function() {
  return del(config.wipe.build);
});

// Clean out junk files after build
gulp.task('utils-clean', ['build', 'utils-wipe-dist'], function() {
  return del(config.clean);
});

// Copy files from the `build` folder to `dist/[project-version]`
gulp.task('utils-dist', ['utils-clean'], function() {
  return gulp.src(config.dist.src)
  .pipe(gulp.dest(config.dist.dest));
});

// Create zip file from `dist/[project-version]` to
// prepare final theme release
gulp.task('utils-zip', ['utils-dist'], function() {
  return gulp.src(config.zip.src)
  .pipe(plugins.zip(config.zip.name))
  .pipe(gulp.dest(config.zip.dest));
});
