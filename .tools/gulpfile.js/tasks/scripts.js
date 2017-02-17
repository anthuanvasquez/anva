// ==== SCRIPTS ==== //

var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    merge       = require('merge-stream'),
    config      = require('../../gulpconfig').scripts
;

// Minify theme scripts
gulp.task('scripts-min-theme', () => {
    return gulp.src(config.minify.theme.src)
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
    .pipe(gulp.dest(config.minify.theme.dest));
});

// Minify core scripts
gulp.task('scripts-min-core', () => {
    return gulp.src(config.minify.core.src)
    .pipe(plugins.ignore.exclude(config.minify.core.ignore))
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
    .pipe(gulp.dest(config.minify.core.dest));
});

// Concat and minify core vendor scripts
gulp.task('scripts-core-vendor', () => {
    return gulp.src(config.minify.core.vendor.files)
    .pipe(plugins.concat(config.minify.core.vendor.name))
    .pipe(gulp.dest(config.minify.core.dest))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(gulp.dest(config.minify.core.dest));
});

// Check scripts for errors on theme, core and admin
gulp.task('scripts-lint', () => {
    return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
    .pipe(plugins.ignore.exclude(config.lint.ignore))
    .pipe(plugins.jshint(config.lint.options))
    .pipe(plugins.jshint.reporter('default'));
});

// Copy scripts source files to the `build` folder
gulp.task('scripts-build', () => {
    return gulp.src(config.src)
    .pipe(plugins.changed(config.dest))
    .pipe(gulp.dest(config.dest));
});

// Master script tasks
gulp.task('scripts-minify', ['scripts-min-theme', 'scripts-min-core']);
gulp.task('scripts', ['scripts-build']);
