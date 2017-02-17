// ==== THEME ==== //

var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    config      = require('../../gulpconfig').theme
;

// Check textdomain on PHP source files
gulp.task('lint-textdomain', () => {
    return gulp.src(config.php.src)
    .pipe(plugins.checktextdomain(config.textdomain));
});

// Make POT file for theme translation
gulp.task('theme-pot', () => {
    return gulp.src(config.php.src)
    .pipe(plugins.sort())
    .pipe(plugins.wpPot(config.lang.pot))
    .pipe(gulp.dest(config.lang.dest))
    .pipe(plugins.notify({ message: 'POT file created' }));
});

// Copy everything under `../languages` indiscriminately
gulp.task('theme-lang', () => {
    return gulp.src(config.lang.src)
    .pipe(plugins.changed(config.lang.dest))
    .pipe(gulp.dest(config.lang.dest));
});

// Lint PHP source files
gulp.task('php-lint', () => {
    return gulp.src(config.php.src)
    .pipe(plugins.phplint('', {skipPassedFiles: true}))
    .pipe(plugins.phplint.reporter('fail'));
});

// Copy PHP source files to the `build` folder
gulp.task('theme-php', () => {
    return gulp.src(config.php.src)
    .pipe(plugins.changed(config.php.dest))
    .pipe(gulp.dest(config.php.dest));
});

// Create the README file to the `build` folder
gulp.task('theme-readme', () => {
    return gulp.src(config.readme.src)
    .pipe(plugins.markdown())
    .pipe(gulp.dest(config.readme.dest));
});

// Create parent theme from the `build` folder
// to test the theme before released
gulp.task('theme-symlink', () => {
    return gulp.src(config.test.src)
    .pipe(plugins.symlink(config.test.dest));
});

// Master theme task
gulp.task('theme', ['theme-lang', 'theme-php', 'theme-readme', 'theme-symlink']);
