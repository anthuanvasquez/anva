var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    merge       = require('merge-stream'),
    config      = require('../../gulpconfig').scripts
;

// Check scripts for errors on theme, core and admin
gulp.task('js-lint', () => {
    return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
    .pipe(plugins.ignore.exclude(config.lint.ignore))
    .pipe(plugins.jshint(config.lint.options))
    .pipe(plugins.jshint.reporter('default'));
});

gulp.task('jscs-lint', () => {
    return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
    .pipe(plugins.jscs(config.jscs.options))
    .pipe(plugins.jscs.reporter());
});

// Minify theme scripts
gulp.task('js-minify-theme', () => {
    return gulp.src(config.minify.theme.src)
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
    .pipe(gulp.dest(config.minify.theme.dest));
});

// Minify core scripts
gulp.task('js-minify-core', () => {
    return gulp.src(config.minify.core.src)
    .pipe(plugins.ignore.exclude(config.minify.core.ignore))
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
    .pipe(gulp.dest(config.minify.core.dest));
});

// Concat and minify core vendor scripts
gulp.task('js-concat-plugins', () => {
    return gulp.src(config.minify.core.vendor.files)
    .pipe(plugins.concat(config.minify.core.vendor.name))
    .pipe(gulp.dest(config.minify.core.dest))
    .pipe(plugins.uglify(config.minify.uglify))
    .pipe(plugins.rename(config.minify.rename))
    .pipe(gulp.dest(config.minify.core.dest));
});

// Copy scripts source files to the `build` folder
gulp.task('scripts-build', () => {
    return gulp.src(config.src)
    .pipe(plugins.changed(config.dest))
    .pipe(gulp.dest(config.dest));
});

// Master script tasks
gulp.task('scripts-minify', ['js-minify-theme', 'js-minify-core']);
gulp.task('scripts', ['scripts-build']);
