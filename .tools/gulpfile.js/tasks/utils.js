// ==== UTILITIES ==== //

var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    del         = require('del'),
    config      = require('../../gulpconfig').utils
;

// Totally wipe the contents of the `dist` folder to prepare
// for a clean build; additionally trigger Bower-related tasks
// to ensure we have the latest source files
gulp.task('wipe-dist', () => {
    return del(config.wipe.dist, {force: true});
});

gulp.task('wipe-build', () => {
    return del(config.wipe.build, {force: true});
});

gulp.task('wipe-test', () => {
    return del(config.wipe.test, {force: true});
});

// Clean out junk files after build
gulp.task('clean', ['build', 'wipe-dist', 'wipe-test'], () => {
    return del(config.clean, {force: true});
});

// Copy files from the `build` folder to `dist/[project-version]`
gulp.task('dist', ['utils-clean'], () => {
    return gulp.src(config.dist.src)
    .pipe(plugins.zip(config.dist.name))
    .pipe(gulp.dest(config.dist.dest));
});
