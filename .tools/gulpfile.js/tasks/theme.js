var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    config      = require('../../gulpconfig').theme
;

// Check textdomain on PHP source files
gulp.task('textdomain-lint', () => {
    return gulp.src(config.php.src)
        .pipe(plugins.checktextdomain(config.textdomain));
});

// Lint PHP source files
gulp.task('php-lint', () => {
    return gulp.src(config.php.src)
        .pipe(plugins.ignore.exclude(config.php.lint.ignore))
        .pipe(plugins.phplint('', { skipPassedFiles: true }))
        .pipe(plugins.phplint.reporter('fail'));
});

// Make POT file for theme translation
gulp.task('make-pot', () => {
    return gulp.src(config.php.src)
        .pipe(plugins.sort())
        .pipe(plugins.wpPot(config.lang.pot))
        .pipe(gulp.dest(config.lang.pot.dest))
        .pipe(plugins.notify({ message: 'POT file created' }));
});

// Copy everything under `../languages` indiscriminately
gulp.task('theme-lang', () => {
    return gulp.src(config.lang.src)
        .pipe(plugins.changed(config.lang.dest))
        .pipe(gulp.dest(config.lang.dest));
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

// Master theme task
gulp.task('theme', ['theme-lang', 'theme-php', 'theme-readme']);
