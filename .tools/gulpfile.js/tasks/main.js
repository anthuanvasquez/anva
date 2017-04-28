var gulp        = require('gulp'),
    gutil       = require('gulp-util'),
    runSequence = require('run-sequence');

// Default task chain: build -> (livereload or browsersync) -> watch
gulp.task('default', ['browsersync', 'watch']);

// Build a working copy of the theme
gulp.task('build', ['images', 'scripts', 'styles', 'theme']);

// Create distribution copy
gulp.task('release', ['dist']);

// Compress images - NOTE: this is a resource-intensive task!
gulp.task('optimize', ['images-optimize']);

// Tests - Lints
gulp.task('tests', () => {
    runSequence('sass-lint', 'css-lint', 'js-lint', 'php-lint', 'textdomain-lint');
});

gulp.task('prod', () => {
    gutil.env.prod = true;
    runSequence('sass-theme', 'sass-core', 'sass-admin');
});
